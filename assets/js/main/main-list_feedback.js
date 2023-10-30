require(["../common" ], function (common) {
    require(["main-function","../app/app-list_feedback"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
