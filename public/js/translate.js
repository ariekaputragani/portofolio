/* Translator Indonesia / English toggle */
(function () {
  "use strict";

  var translations = window.PORTFOLIO_TRANSLATIONS || { en: {} };
  var DEFAULT_LANG = document.documentElement.lang === "en" ? "en" : "id";

  function currentLang() {
    try {
      var saved = localStorage.getItem("portfolio_lang");
      if (saved === "en" || saved === "id") return saved;
    } catch (e) {}
    return DEFAULT_LANG;
  }

  function applyLang(lang) {
    var dict = translations[lang] || {};
    document.querySelectorAll("[data-t]").forEach(function (el) {
      var key = el.getAttribute("data-t");
      if (dict[key]) {
        el.textContent = dict[key];
      }
    });
    var label = document.getElementById("lang-label");
    if (label) {
      label.textContent = lang === "id" ? "EN" : "ID";
    }
    document.documentElement.lang = lang;
  }

  function init() {
    applyLang(currentLang());

    var btn = document.getElementById("lang-toggle");
    if (!btn) return;

    btn.addEventListener("click", function () {
      var next = currentLang() === "id" ? "en" : "id";
      try {
        localStorage.setItem("portfolio_lang", next);
      } catch (e) {}
      applyLang(next);
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();