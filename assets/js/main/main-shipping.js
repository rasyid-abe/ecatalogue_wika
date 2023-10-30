require(["../common" ], function (common) {  
    require(["main-function","../app/app-shipping"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});