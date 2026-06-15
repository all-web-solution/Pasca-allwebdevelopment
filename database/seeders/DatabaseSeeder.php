<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Berita;
use App\Models\GuruBesar;
use App\Models\VisiPendidikan;
use App\Models\Alumni;
use App\Models\Dokumen;
use App\Models\Penelitian;
use App\Models\HeroSlider;
use App\Models\Seminar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil KontenWebSeeder dengan sintaks yang benar agar tidak error
        // Perbaikan syntax: Wajib dibungkus array [] dan panggil dengan ::class
        $this->call([
            KontenWebSeeder::class,
        ]);

        // =========================================================================
        // 1. DATA AKUN ADMINISTRATOR UTAMA (SINKRON DENGAN FIELD USERNAME KAMPUS)
        // =========================================================================
        User::updateOrCreate(
            ['email' => 'admin@iaincurup.ac.id'],
            [
                'name' => 'Super Admin Pascasarjana',
                'username' => '198706122026041001', // Contoh NIDN / username unik bawaan migration kamu
                'password' => Hash::make('password'),
            ]
        );

        // Note: Data ProgramStudi & GuruBesar tidak di-seed di sini lagi karena sudah di-handle 
        // secara lengkap dan banyak di dalam KontenWebSeeder di atas agar tidak terjadi duplikasi.

        // =========================================================================
        // 2. DATA BANNER HERO SLIDER (BERANDA)
        // =========================================================================
        HeroSlider::truncate();
        HeroSlider::insert([
            [
                'badge_text' => 'Institut Agama Islam Negeri Curup',
                'title' => 'Membangun Generasi Unggul & Islami',
                'subtitle' => 'Selamat datang di Pusat Layanan Portal Akademik Transformasi Digital Magister Pascasarjana IAIN Curup.',
                'image' => 'bg-iain2.jpeg',
                'link_url' => '#prodi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'badge_text' => 'Penerimaan Mahasiswa Baru',
                'title' => 'Gerbang Mutu Riset & Kontemporer',
                'subtitle' => 'Tingkatkan kapasitas intelektual profesional Anda bersama dewan Guru Besar dan Doktor terkemuka.',
                'image' => 'bg-iain.jpeg',
                'link_url' => '#contact',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // =========================================================================
        // 3. DATA REKAM JEJAK & TESTIMONI ALUMNI
        // =========================================================================
        Alumni::truncate();
        Alumni::insert([
            [
                'nama' => 'Dr. Rahmat Hidayat, M.Pd.',
                'tahun_lulus' => 2024,
                'pekerjaan' => 'Kepala Madrasah Aliyah Negeri (MAN) Inovatif Regional Sumatra',
                'testimoni' => 'Kurikulum berbasis riset mendalam di Pascasarjana IAIN Curup benar-benar membekali saya untuk menjadi problem solver di berbagai sektor krusial kependidikan.',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // =========================================================================
        // 4. DATA ARSIPS BERKAS DOKUMEN UNDUHAN
        // =========================================================================
        Dokumen::truncate();
        Dokumen::insert([
            [
                'nama_dokumen' => 'Form Pendaftaran Calon Mahasiswa Magister S2.pdf',
                'file_path' => 'doc_default_pendaftaran.pdf',
                'kategori' => 'Formulir',
                'download_count' => 124,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_dokumen' => 'Buku Panduan Academic & SOP Ujian Tesis Akhir.pdf',
                'file_path' => 'doc_default_sop.pdf',
                'kategori' => 'Panduan',
                'download_count' => 85,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_dokumen' => 'Sertifikat SK Akreditasi BAN-PT Magister PAI.pdf',
                'file_path' => 'doc_default_akreditasi.pdf',
                'kategori' => 'Kurikulum',
                'download_count' => 42,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // =========================================================================
        // 5. DATA AGENDA SEMINAR & KOLOKIUM
        // =========================================================================
        Seminar::truncate();
        Seminar::insert([
            [
                'judul_seminar' => 'Seminar Nasional Moderasi Islam',
                'tanggal_pelaksanaan' => '2026-07-24',
                'deskripsi_singkat' => 'Deseminasi pemikiran hukum keluarga kontemporer dan transformasi kurikulum kependidikan Islam di era digital.',
                'tags_pencarian' => 'seminar nasional moderasi beragama digital hukum keluarga',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // =========================================================================
        // 6. DATA REPOSITORI PUBLIKASI PENELITIAN JURNAL
        // =========================================================================
        Penelitian::truncate();
        Penelitian::insert([
            [
                'judul_riset' => 'Digitalization of Islamic Learning Models in Rural Madrasah',
                'penulis' => 'Dr. Ahmad Ridwan, M.Pd.',
                'jurnal_nama' => 'Jurnal Edukasia Pasca Sinta 2',
                'tahun' => '2026',
                'link_jurnal' => 'https://journal.iaincurup.ac.id',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // =========================================================================
        // 7. DATA KONTROL PROFIL PENDIDIKAN (VISI & BACKGROUND)
        // =========================================================================
        VisiPendidikan::truncate();
        VisiPendidikan::create([
            'judul_visi' => 'Visi & Misi Pascasarjana',
            'deskripsi_visi' => 'Menjadi pusat studi magister rumpun keilmuan Islam integratif, sosiologis, religius, unggul, dan kompetitif di Asia Tenggara.',
            'gambar_visi' => 'bg-iain2.jpeg'
        ]);
    }
}
