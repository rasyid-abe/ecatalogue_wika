require(["../common" ], function (common) {  
    require(["main-function","../app/app-feedbackpo"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});