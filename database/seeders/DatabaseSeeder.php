<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HeroSlider;
use App\Models\Alumni;
use App\Models\Dokumen;
use App\Models\Seminar;
use App\Models\Penelitian;
use App\Models\VisiPendidikan;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PANGGIL KONTEN WEB SEEDER DULUAN
        $this->call([
            KontenWebSeeder::class,
        ]);

        // =========================================================================
        // 2. DATA AKUN ADMINISTRATOR DENGAN FORMAT USERNAME NIP/NIDN (ANGKA)
        // =========================================================================

        // Akun 1: SUPER ADMIN
        User::updateOrCreate(
            ['email' => 'admin@iaincurup.ac.id'],
            [
                'name' => 'Super Admin Pascasarjana',
                'username' => '198706122026041001',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'prodi_id' => null,
            ]
        );

        // Akun 2: ADMIN PASCA (Pusat)
        User::updateOrCreate(
            ['email' => 'pasca@iaincurup.ac.id'],
            [
                'name' => 'Admin Sentral Pasca',
                'username' => '198706122026041002',
                'password' => Hash::make('password'),
                'role' => 'admin_pasca',
                'prodi_id' => null,
            ]
        );

        // Akun 3: ADMIN PRODI PAI
        $prodiPAI = ProgramStudi::where('slug', 'like', '%pai%')->first();
        if ($prodiPAI) {
            User::updateOrCreate(
                ['email' => 'pai@iaincurup.ac.id'],
                [
                    'name' => 'Admin Kaprodi PAI',
                    'username' => '198706122026041003',
                    'password' => Hash::make('password'),
                    'role' => 'admin_prodi',
                    'prodi_id' => $prodiPAI->id,
                ]
            );
        }

        // Akun 4: ADMIN PRODI MPI
        $prodiMPI = ProgramStudi::where('slug', 'like', '%mpi%')->first();
        if ($prodiMPI) {
            User::updateOrCreate(
                ['email' => 'mpi@iaincurup.ac.id'],
                [
                    'name' => 'Admin Kaprodi MPI',
                    'username' => '198706122026041004',
                    'password' => Hash::make('password'),
                    'role' => 'admin_prodi',
                    'prodi_id' => $prodiMPI->id,
                ]
            );
        }

        // =========================================================================
        // DATA SEEDER LAINNYA
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

        VisiPendidikan::truncate();
        VisiPendidikan::create([
            'judul_visi' => 'Visi & Misi Pascasarjana',
            'deskripsi_visi' => 'Menjadi pusat studi magister rumpun keilmuan Islam integratif, sosiologis, religius, unggul, dan kompetitif di Asia Tenggara.',
            'gambar_visi' => 'bg-iain2.jpeg'
        ]);
    }
}
