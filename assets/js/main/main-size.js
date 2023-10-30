require(["../common" ], function (common) {  
    require(["main-function","../app/app-size"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});