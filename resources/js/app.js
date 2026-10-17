/**
 * Entry point bundle.
 *
 * PENTING — jangan pernah `new Vue({ el: '#app' })` di file ini lagi.
 *
 * Halaman ini dirender penuh di server oleh Blade (lihat resources/views/
 * layouts/app.blade.php: <div id="app"> berisi navbar + @yield('content') +
 * footer). Kalau Vue di-mount ke '#app' tanpa `template`, Vue memakai
 * in-DOM template: SELURUH ~120KB DOM hasil render server dibuang lalu
 * dibangun ulang dari nol oleh Vue.
 *
 * Akibatnya saat pertama page load:
 *   - seluruh node baru -> layout + paint diulang -> halaman berkedip,
 *   - <script> inline di dalam #app ikut terhapus (navbar hover wipe),
 *   - semua handler jQuery yang di-bind ke node di dalam #app hilang,
 *   - animasi/transition CSS yang sedang jalan mulai dari awal,
 *   - request gambar yang sedang berjalan dibatalkan & diulang.
 *
 * Tidak ada satu pun view yang memakai komponen Vue (tidak ada
 * <example-component>, tidak ada direktif v- prefixed maupun :binding / @event),
 * jadi mount itu murni memberatkan halaman. Kalau suatu saat memang butuh Vue,
 * mount ke elemen sendiri yang kosong — jangan pernah ke wrapper halaman.
 */

require('./bootstrap');
