## Context

User ingin kursor meniru transisi swap navbar **persis**: di navbar, saat garis batas section menyapu, permukaannya ter-split dua warna dengan garis potong tajam di koordinat viewport (gradient hard-stop di `--pf-split-y`, dihitung per permukaan tiap frame oleh tint-navbar.js) — bukan cross-fade dan bukan pergantian warna satu kotak. Kursor saat ini baru menukar warna keseluruhan dot secara instan saat titik kursor melewati batas. Sekarang dot **dan ring** harus ikut ter-split dua warna di garis batas section yang sama, dengan palet dari CSS `[data-pf-section="…"]` (sumber kebenaran tunggal, sama seperti navbar).

## Perubahan

### 1. `public/js/cursor.js` — render split per frame, per permukaan

Ganti logika `applyCursorSection()`/`lastSectionKey`/`needsProbe` dengan mirror dari `updateSectionTint()`/`applySplit()` di tint-navbar.js, dijalankan di render loop tiap frame:

- **Dua permukaan**: dot (layout 12px) dan ring (layout 40px). Sama seperti navbar ("offset garis potong WAJIB dihitung per permukaan"), masing-masing punya `--pf-split-y` sendiri dari satu garis batas yang sama.
- **Probe navbar-style**: probe di visualTop+0.5 dan visualBottom-0.5 tiap permukaan → cari section atas (`upper`) dan bawah (`lower`) dari `getTrackedSections()` (loop `getBoundingClientRect`, logika identik tint-navbar.js:400–457).
- **Kompensasi skala hover** (kunci agar garis terkunci di batas): visual rect dibaca via `getBoundingClientRect` (sudah termasuk `transform: scale`), lalu `offset = clamp((boundaryY - visualTop) / scale, 0, layoutHeight)` dengan `scale = visualHeight / layoutHeight` (dot 0.5× saat hover, ring 2.7×). Saat tidak ada batas di dalam permukaan (upper === lower / probe gagal) → `offset = layoutHeight` → polos warna atas, persis konvensi navbar (`boundaryY === null`).
- **Warna**: pakai cache palet yang sudah ada (`getCursorTints()` — probe `navbar[data-pf-section]`, sudah membaca `--dot-color`, `--navbar-color`, `--dot-box-shadow-hover`, `--ring-border`, `--ring-border-hover`). Tulis pasangan warna upper/lower hanya saat key berubah (pola `lastTintA/lastTintB` navbar):
  - dot: `--pf-dot-a/b` (normal) + `--pf-dot-hover-a/b` (hover) + shadow `--navbar-bg` & `--dot-box-shadow-hover` dari section bawah (section yang dimasuki).
  - ring: `--pf-ring-a/b` (normal) + `--pf-ring-hover-a/b` (hover).
- **Perf**: tulis `--pf-split-y` hanya kalau nilainya berubah (`!== next`, pola navbar tint-navbar.js:390–396). Urutan di render(): tulis left/top dulu, baru baca rect (hindari layout thrash berulang).
- Halaman tanpa section → tidak menulis apa pun, kursor jatuh ke fallback CSS (polos, warna body).

### 2. `public/css/style.css` — background gradient hard-stop

- `#cursor-dot`: ganti `background-color` menjadi gradient hard-stop:
  `background-image: linear-gradient(to bottom, var(--pf-dot-a, var(--dot-color)) var(--pf-split-y, 100%), var(--pf-dot-b, var(--dot-color)) var(--pf-split-y, 100%))`. `border-radius: 50%`, `mix-blend-mode: difference`, box-shadow tetap.
- Hover dot (`#custom-cursor-canvas.hover~#cursor-dot`): ganti `background-color: var(--navbar-color)` dengan gradient hover `--pf-dot-hover-a/b` (split sama); `transform: scale(0.5)` dan box-shadow hover tetap.
- `#cursor-ring`: border 1px diganti teknik **gradient + radial mask** agar bisa ter-split mengikuti lingkaran (border-image tidak bisa ikut border-radius): `background-image: linear-gradient(... var(--pf-ring-a/b) ...)` + `mask`/`-webkit-mask: radial-gradient(circle closest-side, transparent calc(100% - 1px), #000 calc(100% - 1px))` — menghasilkan ring 1px dari gradient.
- Hover ring: ganti `border-color` dengan gradient hover `--pf-ring-hover-a/b`; `scale(2.7)` tetap.
- Transisi tetap **transform 0.25s cubic-bezier(0.4,0,0.2,1) saja** (tidak berubah). Perbarui komentar blok "GANTI STATE ANTAR SECTION": swap = split garis tajam instan, mengikuti navbar.
- Fallback var default (`var(--pf-split-y, 100%)` + fallback `var(--dot-color)`/`var(--ring-border)`) supaya sebelum JS menulis nilai, kursor tetap polos warna body.

### 3. `resources/views/components/app-layout.blade.php`

- Cache-buster `js/cursor.js }}?v=12` → `?v=13`.

## Verifikasi

1. Buka site via browser-use skill (server Laragon, halaman `/`).
2. Scroll perlahan sampai garis batas section menyapu dot: screenshot memperlihatkan dot ter-split dua warna dengan garis tajam segaris dengan batas background section.
3. Hover elemen interaktif dekat garis batas: selama scale 0.5×/2.7× berjalan, garis potong tetap segaris dengan batas section (kompensasi skala bekerja).
4. Pindah ke section lain + footer: dot polos satu warna, tidak ada fade.
5. Update memori `custom-cursor-effect.md` (swap = split dua warna per permukaan, bukan penukaran warna keseluruhan).
