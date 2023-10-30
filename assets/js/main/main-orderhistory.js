require(["../common" ], function (common) {  
    require(["main-function","../app/app-orderhistory"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});