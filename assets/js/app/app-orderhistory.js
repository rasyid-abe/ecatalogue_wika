define([
    "jQuery",
	"bootstrap4",
    "jqvalidate",
    "datatablesBootstrap4",
    "noUiSlider",
    "select2",
    "daterangepicker",
	], function (
    $,
	bootstrap4,
    jqvalidate,
    datatablesBootstrap4,
    noUiSlider,
    select2,
    daterangepicker,
	) {
    return {
        init: function () {
        	App.initFunc();
            App.initEvent();
            console.log("loaded");
            App.searchTable();
            App.resetSearch();
            $(".dataTables_filter").hide();
            $(".loadingpage").hide();
            App.exportToExcel();
            App.initConfirm();
            App.revisi_po();
		    App.cancel_revisi_po();
		    App.selectAlasan();
		},
        revisi_po :function(){
            $(document).on('click', '#revisi_btn', function() {
                var id = $(this).val();
                App.confirm("Apakah Anda Yakin Revisi PO ini?",function(){
                    $.ajax({
                        url: App.baseUrl + 'frontend/orderhistory/act_revisi',
                        method: "POST",
                        data: {id:id},
                        dataType: "json",
                        success: function(e) {
                            if (e.status) {
                                window.location.replace(App.baseUrl + 'mycart');
                            } else {
                                App.alert('No order ' + e.no_order + ' sudah di Keranjang Saya.');
                            }
                        }
                    })
                })
            })
        },
        cancel_revisi_po :function(){
            $(document).on('click', '#cancel_btn', function() {
                var id = $(this).val();
                App.confirm("Apakah Anda Yakin Cancel Revisi PO ini?",function(){
                    $.ajax({
                        url: App.baseUrl + 'frontend/orderhistory/act_cancel_revisi',
                        method: "POST",
                        data: {id:id},
                        dataType: "json",
                        success: function(e) {
                            if (e.status) {
                                window.location.replace(App.baseUrl + 'orderhistory');
                            } else {
                                App.alert('No order ' + e.no_order + ' sudah di Keranjang Saya.');
                            }
                        }
                    })
                })
            })
        },
        selectAlasan: function () {
            $("#status").on("change", function () {
              let status = $("#status").val();
              $.ajax({
                url: App.baseUrl + "order/get_alasan",
                data: { status: status },
                method: "post",
                dataType: "json",
                success: function (data) {
                  alasan = '<option value="">- Pilih -</option>';
                  $.each(data, function (key, val) {
                    alasan +=
                      '<option value="' +
                      val.id +
                      '">' +
                      val.alasan +
                      "</option>";
                  });
                  $("#alasan").html(alasan).removeAttr("disabled");
                },
              });
            });
          },
        initConfirm :function(){
            $('#detail_submit').on( 'click', function () {
                var url = $(this).attr("url_approve");
                var alasan = $("#alasan").val();
                var keterangan = $("#keterangan").val();
                var status = $("#status").val();
                var order_no = $("#order_no").val();
                var users_groups = $("#users_groups").val();
                if(status==1)
                {
                    var url2 = url + "approve_po/" + order_no + "/" + users_groups;
                    var status2 = "Approve";
                }
                else if(status==2)
                {
                    var url2 = url + "revisi/" + order_no + "/" + users_groups;
                    var status2 = "Revisi";
                }
                else if(status==3)
                {
                    var url2 = url + "reject/" + order_no + "/" + users_groups;
                    var status2 = "Cancel";
                }
                
                App.confirm("Apakah Anda Yakin "+ status2 +" PO ini?",function(){
                    $(".loadingpage").show();
                   $.ajax({
                      method: "POST",
                      url: url2,
                      data: {
                        alasan: alasan,
                        keterangan: keterangan,
                      },
                      dataType : 'json',
                    }).done(function( msg ) {
                        setTimeout(function(){
                            if (msg.status == true)
                            {
                                App.alert(status2 +' Berhasil');
                                location.reload();
                            }
                            else
                            {
                                App.alert(status2 +' Gagal');
                            }
                            $(".loadingpage").hide();
                        }, 500)
                    });
                })
            });

            $('#detail_reject').on( 'click', function () {
                var url = $(this).attr("url_reject");
                var alasan = $("#alasan").val();
                var keterangan = $("#keterangan").val();
                App.confirm("Apakah Anda Yakin reject PO ini?",function(){
                   $.ajax({
                      method: "POST",
                      url: url,
                      data: {
                        alasan: alasan,
                        keterangan: keterangan,
                      },
                      dataType : 'json',
                    }).done(function( msg ) {
                        setTimeout(function(){
                            if (msg.status == true)
                            {
                                App.alert('Reject Berhasil');
                                location.reload();
                            }
                            else
                            {
                                App.alert('Reject Gagal');
                            }
                        }, 500)
                    });
                })
            });

            $('#detail_revisi').on( 'click', function () {
                var url = $(this).attr("url_reject");
                var alasan = $("#alasan").val();
                var keterangan = $("#keterangan").val();
                App.confirm("Apakah Anda Yakin revisi PO ini?",function(){
                   $.ajax({
                      method: "POST",
                      url: url,
                      data: {
                        alasan: alasan,
                        keterangan: keterangan,
                      },
                      dataType : 'json',
                    }).done(function( msg ) {
                        setTimeout(function(){
                            if (msg.status == true)
                            {
                                App.alert('Revisi Berhasil');
                                location.reload();
                            }
                            else
                            {
                                App.alert('Revisi Gagal');
                            }
                        }, 500)
                    });
                })
            });
            $('#table tbody').on( 'click', '.approve', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah Anda Yakin Approve PO ini?",function(){
                   $(".loadingpage").show();
                   $.ajax({
                      method: "GET",
                      url: url,
                      dataType : 'json',
                    }).done(function( msg ) {
                        setTimeout(function(){
                            if (msg.status == true)
                            {
                                App.table.ajax.reload(null,true);
                                App.alert('Approve Berhasil');
                            }
                            else
                            {
                                App.alert('Approve Gagal');
                            }
                            $(".loadingpage").hide();
                        }, 500)
                    });
                })
            });

            $('#table tbody').on( 'click', '.reject', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah Anda Yakin reject PO ini?",function(){
                   $.ajax({
                      method: "GET",
                      url: url,
                      dataType : 'json',
                    }).done(function( msg ) {
                        setTimeout(function(){
                            if (msg.status == true)
                            {
                                App.table.ajax.reload(null,true);
                                App.alert('Reject Berhasil');
                            }
                            else
                            {
                                App.alert('Reject Gagal');
                            }
                        }, 500)
                    });
                })
            });
        },
        exportToExcel : function()
        {
            $('#btn-export-to-excel').on('click', function(){
                var q_string = "";
                var i = 0;
                $.each(App.filter, function(k, v){
                    q_string += i == 0 ? '?' : '&';

                    q_string += k + '=' + v;
                    i++;
                });


                window.open(App.baseUrl+'frontend/orderhistory/export_to_excel' + q_string);
            });
        },
        initEvent : function(){
            $('#btn-back').on('click', function(){
                window.location.href = App.baseUrl+"home";
            });

            $('*select[data-selectjs="true"]').select2({width: '100%'});

            $('#daterange').daterangepicker();
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
                //"searching": false,
                "ajax":{
                    "url": App.baseUrl+"frontend/orderhistory/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "order": [[5, "desc"]],
                "columns": [
                    { "data": "order_no" },
                    { "data": "no_surat" },
                    { "data": "vendor_name" },
                    { "data": "project_name" },
                    { "data": "total_price","class" : "text-right" },
                    { "data": "created_at" },
                    { "data": "status" },
                    { "data": "action" ,"orderable": false}
                ]
            });
        },
        searchTable:function(){
            $('#search').on('click', function () {
                console.log("SEARCH");
                var order_no = $("#order_no").val();
                var nm_project = $("#nm_project").val();
                var daterange = $("#daterange").val();

                var filter = [{
                    order_no : $("#order_no").val(),
                    nm_project : $("#nm_project").val(),
                    daterange : $("#daterange").val(),
                    no_surat : $("#no_surat").val(),
                    vendor_name : $("#vendor_name").val(),
                    location_name : $("#location_name").val(),
                    perihal : $("#perihal").val(),
                    departemen_id : $("#departemen_id").val(),
                    po_status : $("#po_status").val(),
                }];

                //var email = $("#email").val();
                App.filter = filter[0];
                App.table.column(1).search(JSON.stringify(filter),true,true);
                console.log(filter);

                App.table.draw();

            });
        },
        filter : [],
        resetSearch:function(){
            $('#reset').on( 'click', function () {
                $("#order_no").val('');
                $("#nm_project").val('');
                $("#daterange").val('');
                $("#no_surat").val('');
                $("#vendor_name").val('');
                $("#location_name").val('');
                $("#perihal").val('');
                $("#departemen_id").val('').trigger('change');
                $("#po_status").val('1000');

                App.table.search( '' ).columns().search( '' ).draw();
            });
        },
	}
});
