require(["../common" ], function (common) {  
    require(["main-function","../app/app-jenis"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});