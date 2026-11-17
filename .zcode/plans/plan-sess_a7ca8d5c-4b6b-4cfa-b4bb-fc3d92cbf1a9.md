## Konteks

Menu item di menu collapse mobile terbuka memakai scale(1.1) saat hover dengan durasi 0,35s (blok "HAPUS TRANSISI WARNA SAAT SCROLL", style.css ±2668–2716). User menyetujui (via AskUserQuestion): **item menu 0,25s, wadah & garis hamburger tetap 0,35s** — animasi buka/tutup menu dan morph silang tidak berubah.

## Perubahan — `public/css/style.css` saja

**Pisahkan blok `:is(.navbar.menu-open, ...)` (±2668–2716) menjadi dua:**

1. **Wadah + garis hamburger — tetap 0,35s !important** (transform, opacity): selector bare `:is(...)` (navbar), `#navContainer`, `.navbar-collapse`, `.sh-nav-group-wrapper`, `#navbarMenu`, `#navControls`, `.sh-btn-circle .sh-hamburger-line`. Dengan komentar: wadah menggerakkan fade buka/tutup menu (pengecualian user, tidak diubah).

2. **Item menu — 0,25s !important** (transform, opacity): `.sh-nav-item`, `.sh-nav-item>span`, `.sh-nav-item>i`, `#navControls .lang-btn`, `.lang-label`, `#lang-toggle .sh-nav-icon`, `#navControls .sh-btn-contact`, `>span`, `>i`. Dengan komentar: scale(1.1) hover = keluarga feedback cepat (glow item 0,25s, ring 0,25s, dim overlay 0,25s, cursor 0,25s).

3. Komentar blok induk ("Yang SENGAJA dipertahankan...") ditambah satu kalimat tentang pemisahan durasi ini.

**Tidak tersentuh:** fade buka/tutup collapse (2196–2216, tetap 0,35s), tombol X mobile (2798–2802), background/color hover item yang memang tanpa transisi (by design, sinkron scroll), semua aturan desktop, JS.

## Verifikasi

1. Hard-refresh, buka menu mobile: fade buka/tutup tetap 0,35s (tidak berubah).
2. Hover item menu / lang-btn / "Hubungi Saya" di menu terbuka: scale teks/ikon kini 0,25s; background tint & warna tetap snap (by design).
3. Tombol silang: morph tetap 0,35s.