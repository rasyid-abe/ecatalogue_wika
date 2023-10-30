require(["../common" ], function (common) {
    require(["main-function","../app/app-project"], function (func,application) {
    App = $.extend(application,func);
        App.init();
    });
});
