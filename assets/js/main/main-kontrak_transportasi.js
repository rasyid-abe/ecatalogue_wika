require(["../common" ], function (common) {
    require(["main-function","../app/app-kontrak_transportasi"], function (func,application) { 
    App = $.extend(application,func);
        App.init();
    });
});
