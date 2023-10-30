require(["../common"], function (common) {
  require(["main-function", "../app/app-test_data_lelang"], function (
    func,
    application
  ) {
    App = $.extend(application, func);
    App.init();
  });
});
s;
