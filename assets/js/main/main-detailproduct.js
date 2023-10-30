require(["../common" ], function (common) {  
    require(["main-function","../app/app-detailproduct"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});