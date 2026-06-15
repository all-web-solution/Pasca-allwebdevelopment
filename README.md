🏛️ Portal Akademik & Ekosistem Riset Pascasarjana IAIN Curup
Portal Web Responsif berbasis Laravel 11 yang dirancang sebagai pusat deseminasi riset ilmiah, pengelolaan administrasi publik, jurnalistik kampus, serta manajemen data alumni terpadu di lingkungan Pascasarjana IAIN Curup.

🚀 Fitur Utama Sistem
🌐 Halaman Publik (Front-End)
Premium Hero Slider Carousel: Komponen spanduk dinamis terintegrasi database untuk media informasi program strategis kampus.

Direktori Program Studi: Sistem navigasi pemetaan konsentrasi magister (PAI, MPI, HKI, dll) dilengkapi fitur Live Search (pencarian instan tanpa reload halaman).

Portal Jurnalistik & Berita: Feed horizontal premium untuk memisahkan klaster Berita Akademik dan Pengumuman Resmi Kampus.

Pusat Unduhan Dokumen: Komponen Accordion interaktif berkas legalitas, SOP, dan formulir dengan pencatatan counter total unduhan secara real-time.

Arsip Publikasi Penelitian: Repositori draf karya ilmiah populer dosen-mahasiswa yang terhubung langsung ke Open Journal System (OJS).

Security Throttling Auto-Logout: Perlindungan sesi aktif browser. Pengguna atau admin yang tidak melakukan aktivitas (idle) selama 15 menit akan otomatis ter-logout secara aman demi menghindari pembajakan sesi.

🔐 Panel Kendali Admin (Back-End)
Executive Analytics Dashboard: Widget akumulasi metrik total data riil database (Prodi, Berita, Dokumen, Alumni) beserta visualisasi log aktivitas terakhir.

CRUD Kontrol Pendidikan: Manajemen data Visi Misi institusi, kurikulum Program Studi, dan dewan Guru Besar/Profesor.

CRUD Pusat Arsip & Media: Pengelolaan penuh berkas media banner slider, berkas dokumen unduhan, agenda kolokium/seminar, dan repositori publikasi jurnal.

DOM Event Listener Anti-Crash: Seluruh interaksi modal box (View & Edit) menggunakan arsitektur data atribut untuk menjamin keamanan parsing teks berkarakter newline (enter).

🗄️ Arsitektur Basis Data & Alur Aliran Data (Data Flow)
Sistem ini bergerak menggunakan arsitektur database relasional linier, di mana setiap tabel berdiri secara independen untuk mendukung efisiensi performa proses querying data skala besar tanpa membebani memori server.

1. Kamus Struktur Tabel Database (Schema Dictionary)
   users: Menyimpan kredensial otentikasi tunggal (aktor utama). Field username bersifat unik untuk memfasilitasi integrasi validasi NIDN dosen atau Nomor Induk Pegawai Kampus.

beritas: Klaster data pusat jurnalisme. Field kategori memisahkan secara logis antara konten akademik (artikel kegiatan) dan pengumuman (surat edaran/agenda wajib).

program_studis: Repositori profil konsentrasi magister. Field search_tags menampung kata kunci spesifik yang dipindai secara real-time oleh mesin JavaScript front-end.

visi_pendidikans: Tabel kontrol statis tunggal pembungkus teks narasi profil institusi pada halaman latar belakang.

alumnis: Bank data jaringan ikatan alumni beserta rekam karier profesional dan pesan testimoni pelacakan lulusan (tracer study).

dokumens: Kontrol pusat berkas legalitas. Field download_count bertindak sebagai pencatat angka akumulasi performa unduhan yang melonjak secara atomik setiap kali tombol unduh diklik tamu.

penelitians: Repositori indeksasi publikasi karya ilmiah populer dosen-mahasiswa yang terintegrasi lewat tautan luar field link_jurnal ke Open Journal System (OJS).

hero_sliders: Tabel suplai visual dinamis pembentuk komponen spanduk carousel beranda utama.

seminars: Agenda deseminasi keilmuan dan jadwal kolokium tesis mahasiswa aktif.

2. Mekanisme & Alur Kerja Data Sistem (Data Flow Pipeline)
   Proses manipulasi data hingga penyajiannya ke hadapan publik diatur melalui jalur pipa (pipeline) arsitektur MVC (Model-View-Controller) Laravel sebagai berikut:

Plaintext
[Aktor: Administrator]
│
▼
(Isi Form Input) ──► [AdminController] ──► (Validasi Request)
│
▼
[Halaman Publik] ◄── [PublicController] ◄── [Database MySQL]
(View Blade) (Model Eloquent) (Tabel Skema)
A. Alur Penerbitan & Proteksi Media (Berita, Slider, Guru Besar)
Pemicu (Trigger): Admin mengunggah berkas gambar/cover baru melalui form kontrol admin.

Pemrosesan (Controller): AdminController menangkap request, mengekripsi nama file menggunakan timestamp unik (time()), memindahkan berkas ke folder penyimpanan lokal (public/img atau public/uploads), lalu mendaftarkan nama berkas tersebut ke database.

Penyajian (Front-End): Saat tamu mengakses halaman depan, PublicController memanggil data terbaru (latest()) lewat Model, dan View Blade merendernya dalam bentuk grid responsif atau feed horizontal premium.

B. Alur Manajemen Berkas & Counter Download (Dokumen Akademik)
Penyimpanan: Admin mengunggah dokumen (.pdf/.docx) di panel arsip. Sistem membersihkan nama asli file dari karakter aneh menggunakan RegExp (preg*replace), melindunginya dengan prefix doc*, lalu menyimpannya di folder public/uploads/dokumen.

Aksi Tamu: Ketika mahasiswa mengklik tombol "Unduh Dokumen" di halaman publik, request tidak langsung menunjuk ke file fisik, melainkan diarahkan ke route public.dokumen.download.

Penghitungan Otomatis: Method downloadDokumen() di PublicController akan mencegat request, memicu fungsi $dokumen->increment('download_count') untuk menaikkan angka statistik unduhan secara instan di database, kemudian mengirimkan file asli menggunakan response()->download().

C. Alur Live Search Tanpa Reload (Prodi & Seminar)
Pendaftaran: Admin mendaftarkan program studi atau agenda seminar baru lengkap dengan kata kunci relevan di kolom search_tags / tags_pencarian.

Injeksi DOM: Blade merender seluruh kartu komponen (.prodi-card) ke browser, namun menyimpan teks kata kunci di dalam atribut HTML khusus (data-search="{{ $p->search_tags }}").

Eksekusi Client-Side: Saat pengguna mengetik di kolom pencarian, JavaScript menangkap karakter, lalu membandingkannya dengan isi atribut data-search pada tiap kartu menggunakan method .includes(). Jika cocok, elemen tetap ditampilkan (display: block); jika tidak, otomatis disembunyikan (display: none) secara instan tanpa mengganggu koneksi server (zero-server-load).

🛠️ Spesifikasi Teknologi (Tech Stack)
Framework Inti: Laravel v11.x

Bahasa Pemrograman: PHP v8.2+ / v8.4

Database Engine: MySQL / MariaDB

Desain Antarmuka: Vanilla CSS3 Modern (Custom Glassmorphism Variables)

Ikonografi: FontAwesome v6.4.0 (Eksternal CDN)

Mesin Generator Data: Faker Keagamaan & Akademik Lokalisasi Indonesia (id_ID)

💻 Panduan Instalasi Lokalisasi (How to Clone & Run)
Ikuti langkah-langkah taktis di bawah ini untuk menduplikasi dan menjalankan proyek di perangkat lokal kamu (Mac/Windows/Linux):

1. Kloning Repositori
   Buka terminal/command prompt kamu, lalu jalankan perintah klon berikut:

Bash
git clone https://github.com/username-kamu/nama-repo-kamu.git
cd nama-repo-kamu 2. Instalasi Dependensi PHP
Unduh seluruh library vendor pihak ketiga yang dibutuhkan oleh Laravel melalui Composer:

Bash
composer install 3. Konfigurasi Environment File
Salin file konfigurasi environment bawaan, lalu generate secure application key:

Bash
cp .env.example .env
php artisan key:generate 4. Pengaturan Database
Buka file .env menggunakan kode editor kamu, lalu sesuaikan kredensial koneksi database MySQL perangkatmu:

Cuplikan kode
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iain-pasca
DB_USERNAME=root
DB_PASSWORD=password_mysql_kamu 5. Konfigurasi Waktu Batas Auto-Logout
Pastikan durasi menit untuk sistem proteksi pemantauan aktivitas idle session sudah terdaftar di .env:

Cuplikan kode
SESSION_LIFETIME=15
SESSION_EXPIRE_ON_CLOSE=true 6. Migrasi Skema & Seeding Data Otomatis
Jalankan perintah mutakhir ini untuk membangun ulang seluruh tabel skema migrasi sekaligus mengisi database dengan 30 data berita formal, data sampel prodi, dewan profesor, dan akun admin tiruan:

Bash
php artisan migrate:fresh --seed 7. Bersihkan Cache Framework
Sangat direkomendasikan untuk melakukan optimasi pembersihan cache agar sistem mengenali struktur rute, metadata, dan view kompilasi baru secara segar:

Bash
php artisan optimize:clear 8. Jalankan Server Lokal
Nyalakan server lokal Laravel untuk mulai mengakses sistem melalui browser:

Bash
php artisan serve
Sekarang buka browser favorit kamu dan akses URL berikut:

Halaman Depan: http://127.0.0.1:8000

Konsol Login Admin: http://127.0.0.1:8000/login

🔑 Kredensial Akses Login Default (Awal)
Gunakan akun di bawah ini untuk masuk sebagai administrator sistem setelah proses seeding database berhasil dieksekusi:

Email Institusi: admin@iaincurup.ac.id

Username (NIDN): 198706122026041001

Secure Password: password

📁 Struktur Direktori Penting Proyek
Plaintext
├── app/
│ ├── Http/Controllers/
│ │ ├── AdminController.php <-- Logika Back-End Dashboard & CRUD Panel
│ │ └── PublicController.php <-- Logika Front-End & Akselerasi Hitungan Download
│ └── Models/ <-- Struktur Objek Data (Alumni, Berita, Seminar, dll)
├── database/
│ ├── migrations/ <-- Blueprint Arsitektur Tabel Database
│ └── seeders/
│ ├── DatabaseSeeder.php <-- Hub Utama Eksekutor Benih Data
│ └── KontenWebSeeder.php <-- Pabrikasi 30 Berita Melimpah & Guru Besar
├── public/
│ ├── img/ <-- Penyimpanan Gambar Cover & Foto Profesor
│ └── uploads/ <-- Folder Berkas Dokumen Upload S2 & Banner Slider
└── resources/views/
├── layouts/ <-- Layout Induk (Public & Admin + Throttling Logout Script)
├── admin/ <-- Halaman Kontrol Back-End (Dashboard, Arsip, Berita)
└── public/ <-- Halaman Akses Tamu (Beranda, Alumni, Pendidikan, Riset)
💡 Catatan: Pastikan folder public/uploads/slider, public/uploads/alumni, dan public/uploads/dokumen memiliki hak akses tulis (write permission) penuh di perangkat lokal Anda agar fitur upload file media berjalan lancar tanpa hambatan.
