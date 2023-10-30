require(["../common" ], function (common) {
    require(["main-function","../app/app-category_new"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
