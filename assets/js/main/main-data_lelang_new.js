require(["../common"], function (common) {
  require(["main-function", "../app/app-data_lelang_new"], function (
    func,
    application
  ) {
    App = $.extend(application, func);
    App.init();
  });
});
