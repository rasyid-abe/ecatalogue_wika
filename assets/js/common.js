var App;
if(!window.console) {
        var console = {
            log : function(){},
            warn : function(){},
            error : function(){},
            time : function(){},
            timeEnd : function(){}
        }
    }
var log = function() {};

require.config({
    paths: {
        "jQuery": "../../plugins/jquery/jquery.min",
        "jQueryFront": "../../plugins/jqueryfront/jquery",
        "bootstrap" : "../../plugins/bootstrap/js/bootstrap.min",
        "datatables" : "../../plugins/datatables/js/jquery.dataTables.min",
        "datatablesBootstrap" : "../../plugins/datatables.net-bs/js/dataTables.bootstrap",
        "datatablesBootstrap4" : "../../plugins/datatables.net-bs/js/dataTables.bootstrap4.min",
        // "bootstrapFront": "../../front/bootstrap/js/bootstrap.bundle.min",
        "jqvalidate" : "../../plugins/jquery-validate/jquery.validate.min",
        "jQueryUI" : "../../plugins/jquery-ui/jquery-ui.min",
        "moment" : "../../plugins/moment/moment.min",
        "bootstrapDatepicker" : "../../plugins/bootstrap-datepicker/bootstrap-datepicker.min",
        "bootstrapDatetimepicker" : "../../plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min",
        "bootstrapDatepickerFront": "../../front/bootstrap/js/bootstrap-datepicker",
        "highstock" : "../../plugins/highchart/stock/highstock",
        "exporting" : "../../plugins/highchart/stock/exporting",
        "treeview" : "../../plugins/treeview",
        "uiForm" : "../../plugins/ui-form",
        "sidebar" : "../../plugins/sidebar",
        "jqueryStep" : "../../plugins/jquery-step/jquery.steps",
        "bootstrapWizard" : "../../plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard",
        "bootstrapTimepicker" : "../../plugins/bootstrap-timepicker/bootstrap-timepicker",
        "highchart" : "../../plugins/highchart/highcharts.src",
        "highchartmore" : "../../plugins/highchart/highcharts-more",
        "select2" : "../../plugins/select2/select2.min",
        "popper" : "../../plugins/popper.min",
        "bootstrap4" : "../../plugins/bootstrap4/js/bootstrap.bundle",
        "inputmask" : "../../plugins/inputmask/jquery.inputmask.bundle.min",
        "numeral" : "../../plugins/numeral/numeral.min",
        "viewer" : "../../plugins/viewerjs/viewer.min",
        "noUiSlider" : "../../plugins/nouislider",
        "Handsontable" : "../../plugins/handsontable/dist/handsontable.full.min",
        // "Handsontable" : "https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min",
        "HotLang" : "../../plugins/handsontable/dist/all",
        //"numbro" : "../../plugins/handsontable/dist/id",
        "daterangepicker" : "../../plugins/bootstrap-daterangepicker/daterangepicker",
    },
    waitSeconds: 0,
    // urlArgs: "bust=" + (new Date()).getTime(),
    shim: {
        "jQuery": {
            exports: "jQuery",
            init: function(){
                console.log('JQuery inited..');
            }
        },
        "jQueryFront": {
            exports: "jQueryFront",
            init: function(){
                console.log('JQuery inited..');
            }
        },
        "bootstrap": {
            deps: ["jQuery"],
            exports: "bootstrap",
            init: function(){
                console.log('bootstrap inited..');
            }
        },
        "popper": {
            deps: ["jQuery"],
            exports: "Popper",
            init: function(){
                console.log('Popper inited..');
            }
        },
        "datatablesBootstrap4": {
            deps: ["jQuery","datatables"],
            exports: "datatablesBootstrap4",
            init: function(){
                console.log('datatablesBootstrap inited..');
            }
        },
        "bootstrap4": {
            deps: ["jQuery","popper"],
            exports: "bootstrap4",
            init: function(){
                console.log('bootstrap4 inited..');
            }
        },
        "datatables": {
            deps: ["jQuery"],
            exports: "datatables",
            init: function(){
                console.log('datatables inited..');
            }
        },
         "datatablesBootstrap": {
            deps: ["jQuery","datatables"],
            exports: "datatablesBootstrap",
            init: function(){
                console.log('datatablesBootstrap inited..');
            }
        },
        "jqvalidate": {
            deps: ["jQuery"],
            exports: "jqvalidate",
            init: function(){
                console.log('jqvalidate inited..');
            }
        },
        "jQueryUI": {
            deps: ["jQuery"],
            exports: "jQueryUI",
            init: function(){
                console.log('jQueryUI inited..');
            }
        },
        "treeview": {
            deps: ["jQuery"],
            exports: "treeview",
            init: function(){
                console.log('treeview inited..');
            }
        },
        "uiForm": {
            deps: ["jQuery"],
            exports: "uiForm",
            init: function(){
                console.log('uiForm inited..');
            }
        },
        "moment": {
            deps: ["jQuery"],
            exports: "moment",
            init: function(){
                console.log('moment inited..');
            }
        },
        "bootstrapDatepicker": {
            deps: ["jQuery","bootstrap"],
            exports: "bootstrapDatepicker",
            init: function(){
                console.log('bootstrapDatepicker inited..');
            }
        },
        "bootstrapDatetimepicker": {
            deps: ["jQuery","bootstrap"],
            exports: "bootstrapDatetimepicker",
            init: function(){
                console.log('bootstrapDatetimepicker inited..');
            }
        },
        "bootstrapTimepicker": {
            deps: ["jQuery","bootstrap"],
            exports: "bootstrapTimepicker",
            init: function(){
                console.log('bootstrapTimepicker inited..');
            }
        },
        "sidebar": {
            deps: ["jQuery"],
            exports: "sidebar",
            init: function(){
                console.log('sidebar inited..');
            }
        },
        "bootstrapWizard": {
            deps: ["jQuery"],
            exports: "bootstrapWizard",
            init: function(){
                console.log('bootstrapWizard inited..');
            }
        },
         "jqueryStep": {
            deps: ["jQuery"],
            exports: "jqueryStep",
            init: function(){
                console.log('jqueryStep inited..');
            }
        },
        "highchart": {
            deps: ["jQuery"],
            exports: "highchart",
            init: function(){
                console.log('highchart inited..');
            }
        },
        "highchartmore": {
            deps: ["jQuery","highchart"],
            exports: "highchart",
            init: function(){
                console.log('highchart inited..');
            }
        },
        "select2": {
            deps: ["jQuery"],
            exports: "select2",
            init: function(){
                console.log('select2 inited..');
            }
        },
        "highstock": {
            deps: ["jQuery"],
            exports: "highstock",
            init: function(){
                console.log('highstock inited..');
            }
        },
        "exporting": {
            deps: ["jQuery","highstock"],
            exports: "exporting",
            init: function(){
                console.log('exporting inited..');
            }
        },
        "inputmask": {
            deps: ["jQuery"],
            exports: "inputmask",
            init: function(){
                console.log('inputmask inited..');
            }
        },
        "numeral": {
            deps: ["jQuery"],
            exports: "numeral",
            init: function(){
                console.log('numeral inited..');
            }
        },
        "viewer": {
            deps: ["jQuery"],
            exports: "viewer",
            init: function(){
                console.log('viewer inited..');
            }
        },
        "noUiSlider": {
            deps: ["jQuery"],
            exports: "noUiSlider",
            init: function(){
                console.log('nouislider inited..');
            }
        },
        "HotLang": {
            deps: ["jQuery","Handsontable"],
            exports: "HotLang",
            init: function(){
                console.log('Handsontable Languages inited..');
            }
        },

        "numbro": {
            exports: "numbro",
            init: function(){
                console.log('numbro inited..');
            }
        },
        "daterangepicker" : {
            deps: ["jQuery"],
            exports: "daterangepicker",
            init: function(){
                console.log('daterangepicker inited..');
            }
        },
        "Handsontable": {
            deps: ["jQuery"],
            exports: "Handsontable",
            init: function(){
                console.log('handsontable inited..');
            }
        },
        "bootstrapDatepickerFront": {
            deps:["jQuery", "bootstrap4"], exports:"bootstrapDatepickerFront", init:function() {
                console.log("Datepicker Front inited..")
            }
        },

    }
});
