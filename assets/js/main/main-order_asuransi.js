require(["../common" ], function (common) {
    require(["main-function","../app/app-order_asuransi"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
