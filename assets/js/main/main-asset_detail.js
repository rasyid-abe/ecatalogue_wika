require(["../common" ], function (common) {  
    require(["main-function","../app/app-asset_detail"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});