require(["../common" ], function (common) {
    require(["main-function","../app/app-resources_code5"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
