require(["../common" ], function (common) {
    require(["main-function","../app/app-resources_berat"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
