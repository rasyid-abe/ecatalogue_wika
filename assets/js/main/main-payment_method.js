require(["../common" ], function (common) {  
    require(["main-function","../app/app-payment_method"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});