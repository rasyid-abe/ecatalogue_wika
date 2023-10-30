define(['jQuery'], function ($) {
    return {
        clickEvent               : "click",
        loading                  : $("#loading"),
        searchDatatable          : false,
        baseUrl                  : document.getElementById("base_url").value,
        initFunc    : function () {
            App.initValidationForm();
            //console.log($('#form-finishorder').length)
            if ($('#form-finishorder').length == 0)
            {
                App.modalFeedback();
            }
            //init datatable sarch
            if($('#is_can_search').val() == 1){
                App.searchDatatable = true;
            }else{
                App.searchDatatable = false;
            }

            // untuk munculkan alert cek pakta_integritas
            //console.log($('#is_check_pakta').val());
            var is_pengecualian = $('#is_pengecualian').val();
            var is_check_pakta = $('#is_check_pakta').val();

            // bearti belum checklist;
            if (is_pengecualian == 'ya' && is_check_pakta == 'tidak')
            {
                $('#modal_pakta_integritas').modal('show');
                $('#modal_pakta_integritas').on('hidden.bs.modal', function () {
                    App.forceLogOut();
                })
            }
            else if (is_pengecualian == 'tidak' && is_check_pakta == 'tidak')
            {
                App.forceLogOut();
            }

            $('#btn-ok-pakta-integritas').on('click', function(){
                $.ajax({
                    url : App.baseUrl+'redirect/check_pakta_integritas',
                    dataType : 'json',
                    type : 'POST',
                    success : function(result)
                    {
                        if (result.status == true)
                        {

                            $('#modal_pakta_integritas').modal('hide');
                            $('#is_check_pakta').val('ya');
                        }

                    }
                })
            });

            // untuk notif
            $('#btn-notif').on('click',function(){
                var ada_notif = $('#jml_notif').text() != '' ? true : false;
                //alert($('#jml_notif').text());
                if( ! ada_notif )
                {
                    //alert('ok');
                    return;
                }

                $.ajax({
                    url : App.baseUrl+'dashboard/read_notif',
                    type : 'POST',
                    dataType : 'json',
                    success : function (result)
                    {
                        if(result.status == true)
                        {
                            $('#jml_notif').remove();
                        }
                    }
                });
            });

        },
        modalFeedback : function(type_feedback = 'general')
        {
            $("#form-feedback").submit(function(e){
                e.preventDefault();

                $.ajax({
                    type : "POST",
                    dataType : 'json',
                    url : App.baseUrl+'list_feedback/create_feedback',
                    data : {
                        type_feedback : type_feedback,
                        isi_feedback : $('#isi_feedback').val(),
                        kategori_feedback_id : $('#kategori_feedback_id').val(),
                    },
                    success : function(result){
                        if(result.status == true)
                        {
                            $('#alert-feedback')
                            .addClass('alert-success')
                            .removeClass('hidden')
                            .html('Feedback berhasil dikirim');

                            $('#kategori_feedback_id').val('');
                            $('#isi_feedback').val('');

                            if(type_feedback == 'user')
                            {
                                $('#dismiss-modal-feedback').removeAttr('style');
                            }
                        }
                        else
                        {
                            $('#alert-feedback')
                            .addClass('alert-danger')
                            .removeClass('hidden')
                            .html('Feedback gagal dikirim');
                        }
                    },
                })
            })

            $('#btn-need-help').on('click', function(){
                $('#alert-feedback')
                .addClass('hidden')
                .removeClass('alert-success alert-danger');

                $('#modal_feedback').modal('show');

                App.get_list_kategori_feedback();
            });
        },
        get_list_kategori_feedback: function(){
            $.ajax({
                url : App.baseUrl+'kategori_feedback/get_list_kategori_feedback',
                type : "GET",
                dataType : 'json',
                success : function(result){
                    data = result.data;
                    $('#kategori_feedback_id').html('<option value="">Pilih Kategori Feedback</option>');
                    $.each(data, function(key, value){
                        $('#kategori_feedback_id').append('<option value="'+value.id+'">'+value.name+'</option>');
                    })
                },
            });
        },
        forceLogOut : function()
        {
            var is_check_pakta = $('#is_check_pakta').val();
            if (is_check_pakta == 'tidak')
            {
                window.location.replace(App.baseUrl+'auth/logout');
            }
        },
        initValidationForm :function(){
            $('.number').keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                     // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                     // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                         // let it happen, don't do anything
                         return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

            if($('#form-search').length > 0)
            {
                $('#form-search').find('.form-control').on('keydown', function(e){
                    if (e.keyCode == 13)
                    {
                        $('#search').click();
                    }
                });
            }
        },
        alert       : function(msg, callback){
            $("#alert_modal .modal-title").text("");
            // if (title != undefined && title != false && title != "") {
            //     $("#alert_modal .modal-title").text(title);
            // }
            $(".alert-msg").html(msg);
            $(".alert-cancel").hide();
            $(".alert-ok").show();

            $('#alert_modal').modal('show');

            $("#alert_modal .alert-ok").bind(App.clickEvent, function (e) {
                if (callback != undefined && callback != null && callback != false) {
                    callback();
                }

                setTimeout(function() {
                    $("#alert_modal").modal("hide");
                }, 200);

                e.preventDefault();
                $(this).unbind();
            });
        },
        confirm       : function(msg, callbackOk, callbackCancel){
            $("#alert_modal .modal-title").text("");
            // if (title != undefined && title != false && title != "") {
            //     $("#alert_modal .modal-title").text(title);
            // }

            $(".alert-msg").text(msg);
            $(".alert-cancel").show();
            $(".alert-ok").show();

            $('#alert_modal').modal('show');

            $("#alert_modal .alert-ok").bind(App.clickEvent, function (e) {
                if (callbackOk != undefined && callbackOk != null && callbackOk != false) {
                    callbackOk();
                }
                setTimeout(function() {
                    $("#alert_modal").modal("hide");
                }, 200);

                e.preventDefault();
                $(this).unbind();
                $("#alert_modal .alert-cancel").unbind();
            });

            $("#alert_modal .alert-cancel").bind(App.clickEvent, function (e) {
                if (callbackCancel != undefined && callbackCancel != null && callbackCancel != false) {
                    callbackCancel();
                }
                setTimeout(function() {
                    $("#alert_modal").modal("hide");
                }, 200);

                e.preventDefault();
                $(this).unbind();
                $("#alert_modal .alert-ok").unbind();
            });
        },
        approval       : function(msg, callbackOk, callbackCancel){
            $("#alert_approval .modal-title").text("");

            $(".alert-msg").text(msg);
            $(".alert-cancel").show();
            $(".alert-reject").show();
            $(".alert-approve").show();

            $('#alert_approval').modal('show');
            $("#alert_approval .alert-cancel").bind(App.clickEvent, function (e) {
                setTimeout(function() {
                    $("#alert_approval").modal("hide");
                }, 200);

                e.preventDefault();
                $(this).unbind();
                $("#alert_approval .alert-approve").unbind();
            });
            $("#alert_approval .alert-approve").bind(App.clickEvent, function (e) {
                if (callbackOk != undefined && callbackOk != null && callbackOk != false) {
                    callbackOk();
                }
                setTimeout(function() {
                    $("#alert_approval").modal("hide");
                }, 200);

                e.preventDefault();
                $(this).unbind();
                $("#alert_approval .alert-cancel").unbind();
            });

            $("#alert_approval .alert-reject").bind(App.clickEvent, function (e) {
                if (callbackCancel != undefined && callbackCancel != null && callbackCancel != false) {
                    callbackCancel();
                }
                setTimeout(function() {
                    $("#alert_approval").modal("hide");
                }, 200);

                e.preventDefault();
                $(this).unbind();
                $("#alert_approval .alert-ok").unbind();
            });
        },
        format : function(obj){

            var restoreMoneyValueFloat = function(obj)
            {
                var r = obj.value.replace(/\./g, '');
            	r = r.replace(/,/, '#');
            	r = r.replace(/,/g, '');
            	r = r.replace(/#/, '.');
            	return r;
            }

            var getDecimalSeparator = function ()
            {
            	var f = parseFloat(1/4);
            	var n = new Number(f);
    	        var r = new RegExp(',');
            	if (r.test(n.toLocaleString())) return ',';
    	        else return '.';
            }

            if (obj.value == '-') return;

          	var val = restoreMoneyValueFloat(obj);

          	var myreg		= /\.([0-9]*)$/;
          	var adakoma = myreg.test(val);
          	var lastkoma= adakoma ? (RegExp.$1=='') : false;

          	myreg = /\.(0+)$/;
          	var lastnol = adakoma && myreg.test(val);

          	myreg = /(0+)$/;
          	var tailnol = adakoma && myreg.test(val);
          	var adanol	 = tailnol ? RegExp.$1 : '';

          	var n   = parseFloat(val);

          	n = isNaN(n) ? 0 : n;
          	//if (entryFormatMoney.arguments[1] && n > entryFormatMoney.arguments[1]) n = entryFormatMoney.arguments[1];
          	var n = new Number(n);
          	var r = n.toLocaleString();


          	if (getDecimalSeparator()=='.')
          	{
          		r = r.replace(/\./g, '#');
          		r = r.replace(/,/g, '.');
          		r = r.replace(/#/g, ',');
          	}


          	myreg = /([0-9\.]*)(,?[0-9]{0,4})/;
          	if (myreg.test(r)) { r = RegExp.$1 + RegExp.$2; }

          	obj.value = r + (lastkoma || lastnol ? ',' : '') + (tailnol ? adanol : '');
        },
        // fungsi untuk mengembalikan nilai 122.311.312 tanpa tanda titik sebelum submit form.
        noFormattedNumber : function(element)
        {
            if(Array.isArray(element))
            {
                $.each(element, function(index,value){
                    this.noFormattedNumber(value)
                });
            }

            var val;
            function restoreMoneyValueFloatFromStr(str)
            {
                // fungsi ini utk mengembalikan string dari format money standar ke nilai float
                // nilai float dengan saparator decimal titik biar php/javascript bisa parsing
                var rr = new String(str);
                var r = rr.replace(/ /g, '');
                r = r.replace(/\./g, '');
                r = r.replace(/,/, '#');
                r = r.replace(/,/g, '');
                r = r.replace(/#/, '.');
                return r;
            }
            val = restoreMoneyValueFloatFromStr($(element).val());
            $(element).val(val);
        },
        toRp : function(str)
        {
            var sf = new String(str);
            var n = new Number(parseFloat(sf));
            n = isNaN(n) ? 0 : n;

            var r = n.toLocaleString();

            r = r.replace(/\./g, '#');
            r = r.replace(/,/g, '.');
            r = r.replace(/#/g, ',');

            var myreg = /([-][0-9\.]*)(,?[0-9]{0,4})/;
            if (myreg.test(r)) { r = RegExp.$1 + RegExp.$2; }

            return r;
        },
        get_waktu_sekarang : function()
        {

            var waktu = '',
            date = new Date(),
            tahun = date.getFullYear(),
            bulan = date.getMonth(),
            tgl = date.getDate(),
            jam = date.getHours(),
            jam = jam > 9 ? jam : 0+jam,
            menit = date.getMinutes(),
            menit = menit > 9 ? menit : ('0'+menit),
            detik = date.getSeconds(),
            detik = detik > 9 ? detik : ('0'+detik);

            waktu = tgl + ' ' + nama_bulan(bulan) + ' ' + tahun + ' ' + jam + ':' + menit + ':'+ detik;
            return waktu;

            function nama_bulan($index)
            {
                $bulan = [
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember',
                ];

                return $bulan[$index];
            }
        },
        nama_bulan : function($index)
        {
            $bulan = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ];

            return $bulan[$index];
        },
    }
});
