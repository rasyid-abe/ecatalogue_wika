require(["../common" ], function (common) {
    require(["main-function","../app/app-forecast_3_bulan"], function (func,application) {
    App = $.extend(application,func);
        App.init();
    });
});
