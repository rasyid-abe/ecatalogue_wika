define([
    "jQuery",
	"bootstrap4",
    "jqvalidate",
    "datatables",
    "noUiSlider",
    "select2",
	], function (
    $,
	bootstrap4,
    jqvalidate,
    datatables,
    noUiSlider,
    select2
	) {
    return {
        init: function () {
        	App.initFunc();
            App.initEvent();
            App.addTocart();
            App.addTocartSimilar();
            console.log("loaded");
            $(".loadingpage").hide();
		},
        initEvent : function(){
            $('.location-dropdown').on('change', function(){
                var location_name = $('option:selected', this).attr('data-location-name'),
                    form_id = $(this).attr('data-form-id'),
                    location_id = $(this).val();

                    $('#' + form_id).find('.location_idnya').val(location_id);
                    $('#' + form_id).find('.location_namenya').val(location_name);
            });
        },
        addTocartSimilar : function (){
            $('.btn-similar').on('click', function(){
                id = $(this).attr('data-id');
                location_id = $('#form-cart' + id).find('.location_idnya').val();
                if (location_id == '')
                {
                    App.alert('Lokasi barang harus diisi');
                    return false;
                }
                var form_data = new FormData($('#form-cart'+id)[0]);
                    $.ajax({
                    method: "POST",
                    url: App.baseUrl+"cart/add",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType:"JSON",
                    data:form_data,
                    }).done(function(data, textStatus, errorThrown ) {
                        if(data.status == true){
                            total = Object.keys(data.data).length;
                            if(total >0){
                                $('#cart_notif').removeClass('hidden');
                                $('#cart_notif').text(total);
                            }
                            //var cek = Object.keys(data.data);
                            //alert(cek.length);
                            //console.log(data.data[1]);
                            //alert(total);
                            $('#alert_belanja_lagi').modal('show');
                            $('#alert_belanja_lagi').find('.alert-msg').html(data.messages);
                            //App.alert(data.messages);
                        }else{
                            App.alert(data.messages);
                        }
                    }).fail(function (data, textStatus, errorThrown) {
                        App.alert(errorThrown);
                    });
            });
        },
        addTocart : function (){

            if($("#form-cart").length > 0){
                $("#form-cart").validate({
                    rules: {
                        quantity: {
                            required: true
                        },

                    },
                    messages: {
                        quantity: {
                            required: "Quantity Harus Diisi"
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

                        var form_data = new FormData($('#form-cart')[0]);
                        $.ajax({
                        method: "POST",
                        url: App.baseUrl+"cart/add",
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType:"JSON",
                        data:form_data,
                        }).done(function(data, textStatus, errorThrown ) {
                            if(data.status == true){
                                //total = data.data.length;
                                total = Object.keys(data.data).length;
                                if(total >0){
                                    $('#cart_notif').removeClass('hidden');
                                    $('#cart_notif').text(total);
                                }
                                //App.alert(data.messages);
                                $('#alert_belanja_lagi').modal('show');
                                $('#alert_belanja_lagi').find('.alert-msg').html(data.messages)
                            }else{
                                App.alert(data.messages);
                            }
                        }).fail(function (data, textStatus, errorThrown) {
                            App.alert(errorThrown);
                        });
                    }
                });
            }
        },
	}
});
