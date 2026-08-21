<?php

return [
    [
        'slug' => 'panduan-memulai-laravel-11',
        'title' => 'Panduan Lengkap Memulai Laravel 11',
        'excerpt' => 'Pelajari cara membangun aplikasi web modern dengan Laravel 11, dari instalasi, struktur folder, hingga best practices.',
        'date' => '2025-06-10',
        'read_time' => '8 menit',
        'tags' => ['Laravel', 'PHP', 'Tutorial'],
        'content' => [
            [
                'heading' => 'Pendahuluan',
                'paragraphs' => [
                    'Laravel adalah framework PHP paling populer untuk membangun aplikasi web yang cepat dan SEO-friendly. Versi 11 memperkenalkan berbagai penyempurnaan pada struktur aplikasi, routing, dan sistem yang lebih minimal.',
                    'Dalam artikel ini, kita akan membahas langkah-langkah dasar untuk memulai proyek Laravel baru, memahami struktur folder, serta beberapa best practices yang saya gunakan dalam proyek nyata.',
                ],
            ],
            [
                'heading' => 'Membuat Proyek Baru',
                'paragraphs' => [
                    'Gunakan perintah laravel new untuk membuat proyek baru dengan cepat. Framework akan menyiapkan konfigurasi default, autentikasi opsional, dan struktur direktori secara otomatis.',
                    'Struktur folder utama terdiri dari app/ (logika aplikasi), routes/ (routing), dan resources/views (tampilan Blade).',
                ],
            ],
            [
                'heading' => 'Routing Modern',
                'paragraphs' => [
                    'Laravel 11 merampingkan konfigurasi aplikasi menjadi satu file bootstrap/app.php. Semua konfigurasi middleware, routing, dan exception handling dilakukan di satu tempat.',
                    'Untuk proyek baru, pendekatan ini direkomendasikan karena arsitekturnya yang lebih modern, ringkas, dan mudah dipelihara.',
                ],
            ],
        ],
    ],
    [
        'slug' => 'mengoptimalkan-seo-website',
        'title' => '10 Cara Mengoptimalkan SEO Website Anda',
        'excerpt' => 'Dari metadata dinamis hingga structured data, inilah strategi SEO yang terbukti meningkatkan trafik organik.',
        'date' => '2025-04-22',
        'read_time' => '6 menit',
        'tags' => ['SEO', 'Marketing'],
        'content' => [
            [
                'heading' => 'Mengapa SEO Penting',
                'paragraphs' => [
                    'SEO adalah cara paling berkelanjutan untuk mendapatkan trafik organik. Dengan optimasi yang tepat, website Anda dapat muncul di halaman pertama hasil pencarian tanpa biaya iklan.',
                ],
            ],
            [
                'heading' => 'Optimasi Metadata',
                'paragraphs' => [
                    'Setiap halaman sebaiknya memiliki title dan description yang unik dan deskriptif. Gunakan helper Blade di Laravel untuk membuat metadata dinamis berdasarkan konten.',
                    'Open Graph dan Twitter Cards juga penting untuk tampilan menarik saat link dibagikan di media sosial.',
                ],
            ],
            [
                'heading' => 'Kecepatan Halaman',
                'paragraphs' => [
                    'Google menjadikan kecepatan halaman sebagai faktor peringkat. Gunakan gambar yang dioptimalkan, lazy loading, dan hindari JavaScript yang tidak perlu.',
                ],
            ],
        ],
    ],
    [
        'slug' => 'pengenalan-php-8',
        'title' => 'Pengenalan Fitur Baru PHP 8',
        'excerpt' => 'Apa saja fitur menarik di PHP 8, mengapa penting, dan bagaimana cara menggunakannya dengan benar di aplikasi Anda.',
        'date' => '2025-02-14',
        'read_time' => '7 menit',
        'tags' => ['PHP', 'Arsitektur'],
        'content' => [
            [
                'heading' => 'Konsep Dasar',
                'paragraphs' => [
                    'PHP 8 memperkenalkan berbagai fitur seperti named arguments, attributes, union types, dan match expression yang membuat kode lebih ekspresif dan aman.',
                ],
            ],
            [
                'heading' => 'Kapan Menggunakannya',
                'paragraphs' => [
                    'Gunakan match expression untuk menggantikan switch, gunakan named arguments untuk meningkatkan keterbacaan, dan gunakan attributes untuk metadata terstruktur.',
                ],
            ],
            [
                'heading' => 'Manfaat Nyata',
                'paragraphs' => [
                    'Dengan fitur-fitur baru ini, aplikasi Anda akan lebih mudah dibaca, lebih aman dari bug, dan lebih efisien dalam pemeliharaan.',
                ],
            ],
        ],
    ],
];