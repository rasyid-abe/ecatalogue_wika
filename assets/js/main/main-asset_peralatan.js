require(["../common" ], function (common) {  
    require(["main-function","../app/app-asset_peralatan"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});