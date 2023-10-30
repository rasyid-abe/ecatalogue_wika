define([
    "jQuery",
    "jQueryUI",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "select2",
    "datatablesBootstrap",
    ], function (
    $,
    jQueryUI,
    jqvalidate,
    bootstrap,
    sidebar ,
    datatables,
    select2,
    datatablesBootstrap
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.initConfirm();
            App.initPlugin();
            App.staticRow();
            App.staticRowEdit();
            $(".loadingpage").hide();
        },
        staticRow : function(){
            let option_lokasi = '';
            var x = 1;
            $.ajax({
                url: App.baseUrl+"vendor_lokasi/get_lokasi",
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(i, v) {
                        option_lokasi += `
                            <option value="${v.location_id}">${v.full_name}</option>
                        `;
                    })
                    $('#tbody-row').append(`
                        <tr>
                            <td class="row" width=100%>
                                <div class="box-body">
                                    <select class="select-td form-control col-sm-10" name="location_id[]" required>
                                        <option value="" disabled selected>Pilih Lokasi</option>
                                        ${option_lokasi}
                                    </select><br><br><br>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Alamat" name="alamat[]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Latitude</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Latitude" name="latitude[]" id="latitude_01">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Longitude</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Longitude" name="longitude[]" id="longitude_01">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Maps</label>
                                        <div class="col-sm-8">
                                            <button type="button" class="btn btn-xs btn-primary pull-left show_modal" onclick="sho_m('01')"><i class='fa fa-plus'></i> Input Maps</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                    $('select.select-td').select2();
                }
            })

            $('#add_row_btn').on('click', function() {
                x++;
                if(x < 9999){
                    $('#tbody-row').append(`
                        <tr class="ch_remove_${x}">
                            <td class="row" width=100%>
                                <div class="box-body col-12">
                                    <select class="select-td form-control col-sm-12" name="location_id[]" required>
                                        <option value="" disabled selected>Pilih Lokasi</option>
                                        ${option_lokasi}
                                    </select><br><br><br>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Alamat" name="alamat[]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Latitude</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Latitude" name="latitude[]" id="latitude_${x}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Longitude</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Longitude" name="longitude[]" id="longitude_${x}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Maps</label>
                                        <div class="col-sm-8">
                                            <button type="button" class="btn btn-xs btn-primary pull-left show_modal" onclick="sho_m('${x}')"><i class='fa fa-plus'></i> Input Maps</button>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="javascript:void(0);" data-class="${x}" class="remove_button btn btn-danger float-right"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                    $('select.select-td').select2();
                }
            })
            $(document).on('click', '.remove_button', function(e){
                e.preventDefault();
                var klas = $(this).data('class');
                $('.ch_remove_' + klas).html('');
            });
        },
        staticRowEdit : function(){
            let option_lokasi = option_lokasi_add = body_edit = '';
            var x = 1;
            var id = $('#_id').val();
            $.ajax({
                url: App.baseUrl+"vendor_lokasi/edit_data",
                method: 'post',
                data: {id:id},
                dataType: 'json',
                async: false,
                success: function(res) {
                    lokasi = res.lokasi;
                    data = res.data;
                    console.log(data);
                    x = data.length;

                    $.each(lokasi, function(i, v) {
                        option_lokasi_add += `
                        <option value="${v.location_id}">${v.full_name}</option>
                        `;
                    })

                    $.each(data, function(index, val) {
                        $.each(lokasi, function(i, v) {
                            option_lokasi += `
                            <option value="${v.location_id}" ${v.location_id == val.wilayah_id ? 'selected="selected"' : ''}>${v.full_name}</option>
                            `;
                        })

                        body_edit += `
                        <tr class="ch_remove_${index}">
                            <td class="row" width=100%>
                                <div class="box-body">
                                    <select class="select-td form-control col-sm-10" name="location_id[]" required>
                                        <option value="" disabled selected>Pilih Lokasi</option>
                                        ${option_lokasi}
                                    </select><br><br><br>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Alamat" name="alamat[]" value="${val.alamat}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Latitude</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Latitude" name="latitude[]" id="latitude_${index}" value="${val.latitude}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Longitude</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Longitude" name="longitude[]" id="longitude_${index}" value="${val.longitude}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Maps</label>
                                        <div class="col-sm-8">
                                            <button type="button" class="btn btn-xs btn-primary pull-left show_modal" onclick="sho_m('${index}')"><i class='fa fa-plus'></i> Input Maps</button>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="javascript:void(0);" data-class="${index}" class="remove_button btn btn-danger float-right"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        `;
                    })
                    $('#tbody-row-edit').append(body_edit);
                    $('select.select-td').select2();
                }
            })
            console.log(x);
            $('#add_row_btn').on('click', function() {
                x++;
                if(x < 9999){
                    $('#tbody-row-edit').append(`
                        <tr class="ch_remove_${x}">
                            <td class="row" width=100%>
                                <div class="box-body col-12">
                                    <select class="select-td form-control col-sm-12" name="location_id[]" required>
                                        <option value="" disabled selected>Pilih Lokasi</option>
                                        ${option_lokasi_add}
                                    </select><br><br><br>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Alamat" name="alamat[]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Latitude</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Latitude" name="latitude[]" id="latitude_${x}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Longitude</label>
                                        <div class="col-sm-7">
                                            <input type="name" class="form-control" placeholder="Longitude" name="longitude[]" id="longitude_${x}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Maps</label>
                                        <div class="col-sm-8">
                                            <button type="button" class="btn btn-xs btn-primary pull-left show_modal" onclick="sho_m('${x}')"><i class='fa fa-plus'></i> Input Maps</button>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="javascript:void(0);" data-class="${x}" class="remove_button btn btn-danger float-right"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                    $('select.select-td').select2();
                }
            })
            $(document).on('click', '.remove_button', function(e){
                e.preventDefault();
                var klas = $(this).data('class');
                $('.ch_remove_' + klas).html('');
            });
        },
        initPlugin : function(){
             $('*select[data-selectjs="true"]').select2({width: '100%'});
             $('.select-td').select2({
                    width : 'element'
                });
        },
        initEvent : function(){

            $('#btn-add-row').on('click', function(){
                var row = $('#template-row-product').html();
                row = row.replace(/countArraynyaDigantiNanti/g, App.countArray);
                App.countArray++;
                $('#tbody-row').append(row);
                $('.select-td').select2({
                    width : 'element'
                });
            });

            $('#specification_id').on('change', function(){
                var code = $('option:selected', this).attr('data-code-cat');
                //alert(code);
                $('#code_1').val(code)
            });

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
                    "url": App.baseUrl+"vendor_lokasi/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "vendor" },
                    { "data": "lokasi" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                    rules: {
                        vendor_id: {
                            required: true
                        }

                    },
                    messages: {
                        vendor_id: {
                            required: "Vendor Harus Dipilih"
                        }
                    },
                    debug:true,

                    errorPlacement: function(error, element) {
                        var name = element.attr('vendor_id');
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
