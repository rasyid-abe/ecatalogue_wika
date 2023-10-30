require(["../common" ], function (common) {
    require(["main-function","../app/app-pakta_integritas"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
