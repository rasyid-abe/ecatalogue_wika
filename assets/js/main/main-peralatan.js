require(["../common" ], function (common) {  
    require(["main-function","../app/app-peralatan"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});