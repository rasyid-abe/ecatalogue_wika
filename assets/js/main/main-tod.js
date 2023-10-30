require(["../common" ], function (common) {  
    require(["main-function","../app/app-tod"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});