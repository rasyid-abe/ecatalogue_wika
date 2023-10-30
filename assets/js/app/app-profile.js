define([
    "jQuery",
    "jQueryUI",
    "bootstrap", 
    "sidebar",
    "datatables",
    "datatablesBootstrap",
     "jqvalidate",
	], function (
    $,
	jQueryUI,
    bootstrap, 
    sidebar ,
    datatables,
    datatablesBootstrap,
    jqvalidate,
	) {
    return {  
        init: function () { 
        	App.initFunc();
            App.initEvent(); 
            console.log("loaded");
            $(".loadingpage").hide();
		},
         
        initEvent : function(){  
            $("#form").validate({ 
                rules: {
                    nama_lengkap: {
                        required: true
                    },
                    user_name: {
                        required: true,
                        minlength: 8
                    },
                    email: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    address: {
                        required: true,
                    }
                    // new_confirm: {
                    //     required: true,
                    //     equalTo: "#new",
                    //     minlength: 8
                    // },

                },
                messages: {
                    nama_lengkap: {
                        required: "Nama lengkap harus diisi"
                    },
                    user_name: {
                        required: "Username harus diisi",
                        minlength : "Minimal 8"
                    },
                    email: {
                        required: "Email harus diisi",
                    },
                    phone: {
                        required: "No Tlp Harus Diisi"
                    },
                    address: {
                        required: "Alamat Harus Diisi"
                    }
                    // new: {
                    //     required: "Password Baru Harus Diisi",
                    //     minlength: "Minimal 8"
                    // },
                    // new_confirm: {
                    //     required: "Konfirmasi Password Harus Diisi",
                    //     equalTo: "Password tidak sama",
                    //     minlength: "Minimal 8"
                    // }
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
             $("#forms").validate({ 
                rules: {
                    old_password: {
                        required: true
                    },
                    new_password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password",
                        minlength: 8
                    },

                },
                messages: {
                    old_password: {
                        required: "Password Harus Diisi"
                    },
                    new_password: {
                        required: "Password Baru Harus Diisi",
                        minlength: "Minimal 8"
                    },
                    confirm_password: {
                        required: "Konfirmasi Password Harus Diisi",
                        equalTo: "Password tidak sama",
                        minlength: "Minimal 8"
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
                }
            });
        }
	}
});
