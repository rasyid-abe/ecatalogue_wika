require(["../common" ], function (common) {
    require(["main-function","../app/app-chat_vendor"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
