require(["../common" ], function (common) {
    require(["main-function","../app/app-departemen_approval"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
