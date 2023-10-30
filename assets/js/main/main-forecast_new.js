require(["../common"], function (common) {
  require(["main-function", "../app/app-forecast_new"], function (
    func,
    application
  ) {
    App = $.extend(application, func);
    App.init();
  });
});
