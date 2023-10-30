require(["../common" ], function (common) {
    require(["main-function","../app/app-kontrak"], function (func,application) {
    App = $.extend(application,func);
        App.init();
    });
});
