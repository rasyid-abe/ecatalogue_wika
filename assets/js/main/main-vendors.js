require(["../common" ], function (common) {  
    require(["main-function","../app/app-vendors"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});