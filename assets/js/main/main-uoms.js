require(["../common" ], function (common) {  
    require(["main-function","../app/app-uoms"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});