require(["../common" ], function (common) {
    require(["main-function","../app/app-asuransi"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
