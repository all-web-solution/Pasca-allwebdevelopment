<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;
use App\Models\Berita;
use App\Models\GuruBesar;
use Faker\Factory as Faker;
use Illuminate\Support\Str; // <-- WAJIB TAMBAHIN INI BUAT BIKIN SLUG
use Illuminate\Support\Facades\Schema; // <-- 1. WAJIB TAMBAHKAN INI DI ATAS
class KontenWebSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 2. MATIKAN PENGECEKAN FOREIGN KEY SEMENTARA
        Schema::disableForeignKeyConstraints();

        ProgramStudi::truncate();
        Berita::truncate();
        GuruBesar::truncate();

        // 3. NYALAKAN KEMBALI PENGECEKAN FOREIGN KEY
        Schema::enableForeignKeyConstraints();

        // --- 1. SEEDER PROGRAM STUDI ---
        $dataProdi = [
            [
                'nama' => 'S2 - Pendidikan Agama Islam (PAI)',
                'slug' => Str::slug('S2 - Pendidikan Agama Islam (PAI)'),
                'icon' => 'fa-book-quran',
                'search_tags' => 'pendidikan agama islam pai tarbiyah kurikulum guru dosen',
                'deskripsi' => 'Fokus pada pengembangan inovasi metode pengajaran, konstruksi kurikulum berbasis digital instruksional, serta penguatan riset pedagogi Islam transformatif di era modern.',
                'profil' => '<p>Program Magister Pendidikan Agama Islam (PAI) dirancang untuk mencetak lulusan yang profesional, inovatif, dan responsif terhadap dinamika pendidikan Islam kontemporer.</p>',
                'visi_misi' => '<p><b>Visi:</b><br>Menjadi pusat keunggulan dalam riset dan pengembangan Pendidikan Agama Islam di Asia Tenggara.</p>',
                'kurikulum' => '<p>Total beban studi adalah 36 SKS.</p>',
                'dosen' => '<ul><li>Prof. Dr. H. Lukman, M.Ag.</li></ul>',
                'dokumen' => '<p><a href="#">Unduh Pedoman Penulisan Tesis PAI (PDF)</a></p>'
            ],
            [
                'nama' => 'S2 - Manajemen Pendidikan Islam (MPI)',
                'slug' => Str::slug('S2 - Manajemen Pendidikan Islam (MPI)'),
                'icon' => 'fa-folder-tree',
                'search_tags' => 'manajemen pendidikan islam mpi sekolah madrasah tata kelola kepemimpinan',
                'deskripsi' => 'Mempersiapkan pengelola, kepala madrasah, dan pengawas institusi pendidikan yang strategis, visioner, akuntabel, serta adaptif.',
                'profil' => '<p>Program Studi MPI berfokus pada penguatan kapasitas kepemimpinan dan tata kelola lembaga pendidikan Islam.</p>',
                'visi_misi' => '<ul><li><b>Visi:</b> Pionir tata kelola pendidikan Islam modern.</li></ul>',
                'kurikulum' => '<p>Mata kuliah unggulan: Manajemen Mutu Terpadu (TQM), Kepemimpinan Visioner.</p>',
                'dosen' => '<ul><li>Prof. Dr. Ahmad Fauzi, M.Pd.</li></ul>',
                'dokumen' => '<p><a href="#">Unduh Instrumen Akreditasi MPI (PDF)</a></p>'
            ],
            [
                'nama' => 'S2 - Hukum Keluarga Islam (HKI)',
                'slug' => Str::slug('S2 - Hukum Keluarga Islam (HKI)'),
                'icon' => 'fa-scale-unbalanced',
                'search_tags' => 'hukum keluarga islam hki syariah perdata fikih sengketa pengadilan',
                'deskripsi' => 'Pendalaman yurisprudensi fikih sosiologis kontemporer, penanganan legislasi hukum formil, dan mediasi sengketa keluarga.',
                'profil' => '<p>Prodi HKI mencetak praktisi hukum, mediator bersertifikat, dan hakim agama.</p>',
                'visi_misi' => '<p>Menegakkan keadilan restoratif dalam tatanan keluarga muslim modern.</p>',
                'kurikulum' => '<p>Mata kuliah inti: Sosiologi Hukum Islam, Penyelesaian Sengketa (ADR).</p>',
                'dosen' => '<ul><li>Prof. Dr. Hj. Siti Aminah, M.A.</li></ul>',
                'dokumen' => '<p><a href="#">Unduh Jurnal Ahwal Al-Syakhshiyyah</a></p>'
            ]
        ];

        foreach ($dataProdi as $prodi) {
            ProgramStudi::create($prodi);
        }

        // Ambil ID prodi yang barusan dibuat buat di-assign ke Berita & Guru Besar
        $prodiList = ProgramStudi::pluck('id')->toArray();

        // --- 2. SEEDER BERITA (DENGAN PENANDA LEVEL & PRODI) ---
        $judulAkademik = [
            'Simposium Internasional: Tantangan Kurikulum',
            'Workshop Metodologi Riset',
            'Sidang Munaqasyah Terbuka',
            'Pelatihan Penulisan Jurnal',
            'Kuliah Umum Pascasarjana',
            'Bedah Buku Epistemologi',
            'Kolaborasi Riset Antar Kampus',
            'Stadium Generale Ekonomi Syariah',
            'Ujian Kelayakan Proposal',
            'Peluncuran Jurnal Ilmiah Sinta 2',
            'Focus Group Discussion',
            'Seminar Internasional',
            'Workshop Penyusunan Draft Publikasi',
            'Bedah Pemikiran Tokoh',
            'Riset Kolaboratif Dosen-Mahasiswa'
        ];

        $judulPengumuman = [
            'Perpanjangan Masa Pendaftaran',
            'Kalender Akademik Semester Ganjil',
            'Pengumuman Beasiswa Tahfidz',
            'Prosedur Pengajuan Bebas Pustaka',
            'Jadwal Pelaksanaan Matrikulasi',
            'Panduan Penyusunan Draf Tesis',
            'Undangan Rapat Koordinasi Dosen',
            'Pengumuman Hasil Seleksi Administrasi',
            'Alur Registrasi Ulang',
            'Pemberitahuan Pelaksanaan Ujian',
            'Batas Akhir Unggah Mandiri',
            'Pengumuman Jadwal Kolokium',
            'Mekanisme Dispensasi Cuti Akademik',
            'Daftar Peserta Penerima Insentif',
            'Agenda Gladi Bersih Wisuda'
        ];

        // Seeder Berita Akademik
        for ($i = 0; $i < 15; $i++) {
            $isProdi = $faker->boolean(40); // 40% kemungkinan ini berita dari prodi
            Berita::create([
                'judul' => $judulAkademik[$i],
                'kategori' => 'akademik',
                'cover' => 'news1.jpeg',
                'konten' => $faker->paragraph(4) . "\n\n" . $faker->paragraph(5),
                'level' => $isProdi ? 'prodi' : 'pasca',
                'prodi_id' => $isProdi ? $faker->randomElement($prodiList) : null,
                'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
            ]);
        }

        // Seeder Berita Pengumuman
        for ($i = 0; $i < 15; $i++) {
            $isProdi = $faker->boolean(40);
            Berita::create([
                'judul' => $judulPengumuman[$i],
                'kategori' => 'pengumuman',
                'cover' => 'news2.jpeg',
                'konten' => $faker->paragraph(3) . "\n\n" . $faker->paragraph(4),
                'level' => $isProdi ? 'prodi' : 'pasca',
                'prodi_id' => $isProdi ? $faker->randomElement($prodiList) : null,
                'created_at' => $faker->dateTimeBetween('-1 months', 'now'),
            ]);
        }

        // --- 3. SEEDER DEWAN GURU BESAR (HOMEBASE PRODI DITAMBAHKAN) ---
        $dataGuruBesar = [
            ['nama' => 'H. Lukman', 'gelar_depan' => 'Prof. Dr.', 'gelar_belakang' => 'M.Ag.', 'bidang_keahlian' => 'Filsafat Pendidikan Islam Kontemporer', 'biografi_singkat' => 'Fokus pada riset rekonstruksi epistemologi.'],
            ['nama' => 'Hj. Siti Aminah', 'gelar_depan' => 'Prof. Dr.', 'gelar_belakang' => 'M.A.', 'bidang_keahlian' => 'Hukum Perdata Islam & Sosiologi Hukum', 'biografi_singkat' => 'Pakar dalam kajian perbandingan hukum keluarga.'],
            ['nama' => 'Ahmad Fauzi', 'gelar_depan' => 'Prof. Dr.', 'gelar_belakang' => 'M.Pd.', 'bidang_keahlian' => 'Manajemen Strategis Pendidikan Tinggi', 'biografi_singkat' => 'Aktif mengembangkan model penjaminan mutu terpadu (TQM).'],
            ['nama' => 'M. Lutfi Mustofa', 'gelar_depan' => 'Prof. Dr.', 'gelar_belakang' => 'M.Ag.', 'bidang_keahlian' => 'Teologi Islam & Dialog Antar Iman', 'biografi_singkat' => 'Meneliti pemikiran teologi islam klasik.']
        ];

        foreach ($dataGuruBesar as $gb) {
            GuruBesar::create([
                'nama' => $gb['nama'],
                'gelar_depan' => $gb['gelar_depan'],
                'gelar_belakang' => $gb['gelar_belakang'],
                'bidang_keahlian' => $gb['bidang_keahlian'],
                'foto' => 'default-prof.png',
                'biografi_singkat' => $gb['biografi_singkat'],
                'prodi_id' => $faker->randomElement($prodiList), // Otomatis milih homebase prodi acak
            ]);
        }
    }
}
