define([
    "jQuery",
	"bootstrap",
    "jqvalidate",
    "datatables",
    "uiForm"
	], function (
    $,
	bootstrap,
    jqvalidate,
    datatables,
    uiForm
	) {
    return {
        init: function () {
        	App.initFunc();
            App.initEvent();
            console.log("loaded");
            $(".loadingpage").hide();
		},

        initEvent : function(){
            var form = `
            <div class="form-group row pengalaman">
                <div class="col-md-11">
                    <label for="">Pengalaman</label>
                    <input type="text" class="form-control" name="pengalaman[]">
                </div>
                <div class="col-md-1">
                    <label for=""></label>
                    <button type="button" class="btn btn-danger form-control" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash-o"></i></button>
                </div>
            </div>`;

            $('#btn-tambah-pengalaman').on('click', function(){
                var pengalaman = $('.pengalaman');
                if(pengalaman.length > 0)
                {
                    $(form).insertAfter(pengalaman.last());
                }
                else
                {
                    $(form).insertAfter($(this).parent());
                }
            });

            $("#btn-login").removeAttr("disabled");
            $("#form-login").validate({
                rules: {
                    username: {
                        required: true
                    },
                    nama_lengkap: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirm: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    },
                    no_identitas: {
                        required: true
                    },
                    alamat: {
                        required: true
                    },
                    lokasi: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                },
                messages: {
                    username: {
                        required: "Username harus diisi"
                    },
                    nama_lengkap: {
                        required: "Nama lengkap harus diisi"
                    },
                    password: {
                        required: "Password is Required"
                    },
                    password: {
                        required: "Password Harus Diisi",
                        minlength: "Minimal 8 "
                    },
                    password_confirm: {
                        required: "Ulangi Password Harus Diisi",
                        minlength: "Minimal 8 ",
                        equalTo: "Password Tidak Sama"
                    },
                    no_identitas: {
                        required: "No Identitas harus diisi"
                    },
                    alamat: {
                        required: "Alamat harus diisi"
                    },
                    lokasi: {
                        required: "Lokasi harus diisi"
                    },
                    email: {
                        required: "Email harus diisi"
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
                    App.noFormattedNumber('#harga');
                    
                    form.submit();
                }
            });
        }
	}
});
