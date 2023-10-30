define([
    "jQuery",
    "jQueryUI",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    "select2",
    ], function (
    $,
    jQueryUI,
    jqvalidate,
    bootstrap,
    sidebar ,
    datatables,
    datatablesBootstrap,
    select2
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.initConfirm();
            App.initPlugins();
            $(".loadingpage").hide();
        },
        initPlugins : function(){

            $('*select[data-selectjs="true"]').select2({width: '100%'});

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
            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_  dari _END_ ",
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
                "searching": App.searchDatatable,
                "ajax":{
                    "url": App.baseUrl+"jenis_sub/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "katagori" },
                    { "data": "name" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            // //append button to datatables
            // add_btn = '<a href="'+App.baseUrl+'jenis_sub/create" class="btn btn-sm btn-primary ml-2 mt-1"><i class="fa fa-plus"></i> Jabatan</a>';
            // $('#table_filter').append(add_btn);

            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                    rules: {
                        name: {
                            required: true
                        },
                        parent: {
                            required: true
                        },
                    },
                    messages: {
                        name: {
                            required: "Nama Sub Kategori Harus Diisi"
                        },
                        parent: {
                            required: "Kategori Harus Diisi"
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
        }
        
	}
});
