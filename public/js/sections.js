/**
 * Konfigurasi Tunggal Section Portofolio (Single Source of Truth).
 * Digunakan bersama oleh tint-navbar.js dan cursor.js untuk mendeteksi
 * urutan section dan sinkronisasi warna split pada navbar & kursor.
 */
(function ($) {
    "use strict";

    window.PF_SECTIONS = [
        { id: "home", key: "hero" },
        { cls: "pf-section-skills", key: "skills" },
        { cls: "pf-section-bigsins", key: "bigsins" },
        { cls: "pf-section-journey", key: "journey" },
        { cls: "pf-section-services", key: "services" },
        { cls: "pf-project", key: "project" },
        { cls: "pf-section-blog", key: "blog" },
        { cls: "pf-section-contact", key: "contact" }
    ];
})(jQuery);
