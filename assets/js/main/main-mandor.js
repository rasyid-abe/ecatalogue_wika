require(["../common" ], function (common) {
    require(["main-function","../app/app-mandor"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
