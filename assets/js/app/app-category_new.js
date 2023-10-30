define([
     "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    "jqvalidate",
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    sidebar,
    jqvalidate,
    ) {
    return {
        table:null,
        init: function () {
            App.initEvent();
            $(".loadingpage").hide();
            App.initPlugins();
            App.initConfirm();
        },
        initPlugins : function(){
            var _URL = window.URL || window.webkitURL;
            $("#icon_file").change(function(e) {

                var image, file;

                var attached = $(this).get(0).files[0];
                var fname = attached.name;
                var ext = fname.split("").reverse().join("").split(".")[0].split("").reverse().join("").toLowerCase();
                var allowedFile = ['bmp','jpg','jpeg','gif','png'];

                if ((file = this.files[0])) {

                    image = new Image();

                    image.onload = function() {
                        if(this.width > 15 || this.height > 15 || allowedFile.indexOf(ext) == -1)
                        {
                            var pesan = [];
                            if(this.width > 15) pesan.push('Width tidak boleh lebih dari 15, width gambar anda adalah '+this.width);
                            if(this.height > 15) pesan.push('Height tidak boleh lebih dari 15, width gambar anda adalah '+this.height);
                            if(allowedFile.indexOf(ext) == -1) pesan.push('File "'+fname+'" tidak didukung, silahkan hanya masukkan file dengan ekstensi '+allowedFile.join(", ").replace(/,(?=[^,]*$)/, ' atau'));
                            App.alert(pesan.join());
                            $('#icon_file').val('');
                        }
                        //alert("The image width is " +this.width + " and image height is " + this.height);
                    };

                    image.src = _URL.createObjectURL(file);
                    //alert(image.src);

                }

            })
        },
        initEvent : function(){

            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                    rules: {
                        name: {
                            required: true
                        },
                    },
                    messages: {
                        name: {
                            required: "Nama Kategori Harus Diisi"
                        },
                    },
                    debug:true,

                    errorPlacement: function(error, element) {
                        var name = element.attr('name');
                        var errorSelector = '.form-control-feedback[for="' + name + '"]';
                        var $element = $(errorSelector);
                        if ($element.length) {
                            $(errorSelector).html(error.html());
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler : function(form) {
                        form.submit();
                    }
                });
            }

            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang ditampilkan ",
                    "infoFiltered": "(pencarian dari _MAX_ total records)",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelum"
                    },
                },
                "processing": true,
                "serverSide": true,
                "searching": $('#is_can_search').val(),
                "ajax":{
                    "url": App.baseUrl+"category_new/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id", 'class' : 'text-center' },
                    { "data": "code" },
                    { "data": "name" },
                    { "data": "icon" },
                    { "data": "action" ,"orderable": false}
                ]
            });

        },
        initConfirm :function(){
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah Anda Yakin Untuk Mengubah Ini?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        $(".loadingpage").show();
                        App.table.ajax.reload();
                        setTimeout(function(){
                        $('.loadingpage').hide();
                        }, 500);
                    });
                })
            });
        },
	}
});
