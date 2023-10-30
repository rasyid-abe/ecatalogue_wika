require(["../common" ], function (common) {  
    require(["main-function","../app/app-amandemen-asuransi"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});