require(["../common" ], function (common) {  
    require(["main-function","../app/app-product"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});