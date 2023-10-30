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
            App.sync();
            $(".loadingpage").hide();
        },
        sync : function(){
            $('#btn-sync').on('click',function(){
                $.ajax({
                    url : App.baseUrl+'sync/startsync',
                    method : 'GET',
                    dataType : 'json',
                    success : function(data)
                    {
                        console.log(data);
                    },
                });
            });
        },
        initEvent : function(){

            if($("#form").length > 0){
                //$("#save-btn").removeAttr("disabled");
                $("#form").validate({
                     rules: {
                        sync_code: {
                            required: true
                        },
                    },
                    messages: {
                        sync_code: {
                            required: "Jenis Sync harus dipilih"
                        }
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
                        $('#save-btn').html('Sedang diproses ...');
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
                "searching": false,
                "order": [[2, "desc"]],
                "ajax":{
                    "url": App.baseUrl+"sync/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id", "class" : 'text-center'  },
                    { "data": "sync_name"},
                    { "data": "created_at" ,"class" :"text-center"},
                ]
            });

        },
	}
});
