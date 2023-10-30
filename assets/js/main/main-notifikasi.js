require(["../common" ], function (common) {
    require(["main-function","../app/app-notifikasi"], function (func,application) {
    App = $.extend(application,func);
        App.init();
    });
});
