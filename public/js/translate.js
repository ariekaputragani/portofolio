/* Translator Indonesia / English toggle (jQuery) */
(function ($) {
  "use strict";

  var translations = window.PORTFOLIO_TRANSLATIONS || { en: {} };
  var DEFAULT_LANG = $("html").attr("lang") === "en" ? "en" : "id";

  function currentLang() {
    try {
      var saved = localStorage.getItem("portfolio_lang");
      if (saved === "en" || saved === "id") return saved;
    } catch (e) {}
    return DEFAULT_LANG;
  }

  function applyLang(lang) {
    var dict = translations[lang] || {};
    $("[data-t]").each(function () {
      var key = $(this).attr("data-t");
      if (dict[key]) {
        $(this).text(dict[key]);
      }
    });
    var $label = $("#lang-label");
    if ($label.length) {
      $label.text(lang === "id" ? "EN" : "ID");
    }
    $("html").attr("lang", lang);
  }

  $(function () {
    applyLang(currentLang());

    var $btn = $("#lang-toggle");
    if (!$btn.length) return;

    $btn.on("click", function () {
      var next = currentLang() === "id" ? "en" : "id";
      try {
        localStorage.setItem("portfolio_lang", next);
      } catch (e) {}
      applyLang(next);
    });
  });
})(jQuery);
