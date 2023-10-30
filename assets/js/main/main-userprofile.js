require(["../common" ], function (common) {  
    require(["main-function","../app/app-userprofile"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});