require(["../common" ], function (common) {
    require(["main-function","../app/app-riwayat"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
