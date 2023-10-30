define([
    "jQuery",
	"bootstrap4",
    "jqvalidate",
    "datatables",
	], function (
    $,
	bootstrap4,
    jqvalidate,
    datatables,
	) {
    return {
        init: function () {
        	App.initFunc();
            App.initEvent();
            console.log("loaded");
            $(".loadingpage").hide();

            //alert(App.toRp('23000.1234222222222222'))
		},
        initEvent : function(){
            if($("#form-feedback-po").length > 0){
                $("#form-feedback-po").validate({
                    rules: {
                    },
                    messages: {

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
	}
});
