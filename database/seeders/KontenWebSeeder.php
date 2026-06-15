<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;
use App\Models\Berita;
use App\Models\GuruBesar;
use Faker\Factory as Faker;

class KontenWebSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan lokalisasi Indonesia

        // --- 1. SEEDER PROGRAM STUDI (DATA LENGKAP & FORMAL) ---
        $dataProdi = [
            [
                'nama' => 'S2 - Pendidikan Agama Islam (PAI)',
                'icon' => 'fa-book-quran',
                'search_tags' => 'pendidikan agama islam pai tarbiyah kurikulum guru dosen',
                'deskripsi' => 'Fokus pada pengembangan inovasi metode pengajaran, konstruksi kurikulum berbasis digital instruksional, serta penguatan riset pedagogi Islam transformatif di era modern.'
            ],
            [
                'nama' => 'S2 - Manajemen Pendidikan Islam (MPI)',
                'icon' => 'fa-folder-tree',
                'search_tags' => 'manajemen pendidikan islam mpi sekolah madrasah tata kelola kepemimpinan',
                'deskripsi' => 'Mempersiapkan pengelola, kepala madrasah, dan pengawas institusi pendidikan yang strategis, visioner, akuntabel, serta adaptif terhadap standar mutu internasional.'
            ],
            [
                'nama' => 'S2 - Hukum Keluarga Islam (HKI)',
                'icon' => 'fa-scale-unbalanced',
                'search_tags' => 'hukum keluarga islam hki syariah perdata fikih sengketa pengadilan',
                'deskripsi' => 'Pendalaman yurisprudensi fikih sosiologis kontemporer, penanganan legislasi hukum formil, dan mediasi penyelesaian sengketa pranata perdata keluarga muslim.'
            ],
            [
                'nama' => 'S2 - Studi Agama Agama (SAA)',
                'icon' => 'fa-hands-holding-child',
                'search_tags' => 'studi agama saa toleransi filsafat teologi moderasi sosial',
                'deskripsi' => 'Kajian mendalam mengenai kerukunan antarumat beragama, resolusi konflik sosiologis, teologi komparatif, dan penguatan pilar moderasi beragama di Indonesia.'
            ],
            [
                'nama' => 'S2 - Ekonomi Syariah (EKOS)',
                'icon' => 'fa-wallet',
                'search_tags' => 'ekonomi syariah ekos perbankan akuntansi makro mikro keuangan',
                'deskripsi' => 'Pengembangan analisis sistem keuangan syariah, tata kelola perbankan islam, instrumen filantropi (Zakat & Wakaf), serta industri produk halal global.'
            ],
            [
                'nama' => 'S2 - Komunikasi dan Penyiaran Islam (KPI)',
                'icon' => 'fa-bullhorn',
                'search_tags' => 'komunikasi penyiaran islam kpi dakwah jurnalistik media digital jurnalis',
                'deskripsi' => 'Studi strategi komunikasi massa, produksi konten dakwah kreatif berbasis multimedia, jurnalisme investigatif, dan analisis sosiologi media siber.'
            ]
        ];

        foreach ($dataProdi as $prodi) {
            ProgramStudi::create($prodi);
        }


        // --- 2. SEEDER BERITA (30 DATA PREMETRIC FORMAL) ---

        // 15 Judul Berita Klaster Akademik
        $judulAkademik = [
            'Simposium Internasional: Tantangan Kurikulum Pascasarjana di Asia Tenggara',
            'Workshop Metodologi Riset Kuantitatif Menggunakan SmartPLS bagi Mahasiswa S2',
            'Sidang Munaqasyah Terbuka: Model Integrasi Fikih dan Sains Kontemporer',
            'Pelatihan Penulisan Jurnal Bereputasi Scopus untuk Akselerasi Kelulusan Magister',
            'Kuliah Umum Pascasarjana: Reorientasi Hukum Islam di Era Transformasi Digital',
            'Bedah Buku Epistemologi Pendidikan Islam Modern Bersama Dewan Profesor',
            'Kolaborasi Riset Antar Perguruan Tinggi Keagamaan Islam Negeri Sumatera',
            'Stadium Generale: Menggagas Arah Baru Ekonomi Syariah Pasca Pandemi',
            'Ujian Kelayakan Proposal Tesis Gelombang Pertama Resmi Dimulai',
            'Peluncuran Jurnal Ilmiah Terindeks Sinta 2 Khasanah Pascasarjana',
            'Focus Group Discussion: Standardisasi Mutu Tesis rumpun Hukum Keluarga Islam',
            'Seminar Internasional Integrasi Islam dan Ilmu Humaniora di Abad 21',
            'Workshop Penyusunan Draft Publikasi Jurnal Internasional Bagi Mahasiswa MPI',
            'Bedah Pemikiran Tokoh Pendidikan Islam Nusantara Bersama Pakar Eksekutif',
            'Riset Kolaboratif Dosen-Mahasiswa Pascasarjana Berhasil Tembus Reputasi Global'
        ];

        // 15 Judul Berita Klaster Pengumuman / Agenda Resmi
        $judulPengumuman = [
            'Perpanjangan Masa Pendaftaran Seleksi Calon Mahasiswa Baru Gelombang II',
            'Kalender Akademik Semester Ganjil: Batas Akhir Pembayaran UKT dan Pengisian KRS',
            'Pengumuman Beasiswa Tahfidz dan Prestasi Akademik Program Magister',
            'Prosedur Pengajuan Bebas Pustaka dan Verifikasi Turnitin untuk Yudisium',
            'Jadwal Pelaksanaan Matrikulasi Mahasiswa Baru Tahun Akademik Ini',
            'Panduan Penyusunan Draf Tesis dan Format Penulisan Karya Ilmiah Terbaru',
            'Undangan Rapat Koordinasi Dosen Pembimbing Utama dan Pendamping Tesis',
            'Pengumuman Hasil Seleksi Administrasi Calon Mahasiswa Jalur Kerja Sama',
            'Alur Registrasi Ulang dan Pemeriksaan Kesehatan Mahasiswa Pascasarjana',
            'Pemberitahuan Pelaksanaan Ujian Komprehensif Berbasis Computer Assisted Test (CAT)',
            'Batas Akhir Unggah Mandiri Naskah Digital Repositori Perpustakaan Kampus',
            'Pengumuman Jadwal Ujian Kolokium Gelombang Akhir Semester Genap',
            'Edaran Direktur: Mekanisme Dispensasi Cuti Akademik Mahasiswa Magister',
            'Daftar Peserta Penerima Insentif Riset Tesis Hibah Internal Pascasarjana',
            'Pemberitahuan Agenda Gladi Bersih Wisuda Sarjana dan Magister Periode I'
        ];

        // Generate 15 Berita Akademik
        for ($i = 0; $i < 15; $i++) {
            Berita::create([
                'judul' => $judulAkademik[$i],
                'kategori' => 'akademik',
                'cover' => 'news1.jpeg',
                'konten' => $faker->paragraph(8) . "\n\n" . $faker->paragraph(10) . "\n\n" . $faker->paragraph(6),
                'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
            ]);
        }

        // Generate 15 Berita Pengumuman
        for ($i = 0; $i < 15; $i++) {
            Berita::create([
                'judul' => $judulPengumuman[$i],
                'kategori' => 'pengumuman',
                'cover' => 'news2.jpeg',
                'konten' => $faker->paragraph(6) . "\n\n" . $faker->paragraph(8) . "\n\n" . $faker->paragraph(5),
                'created_at' => $faker->dateTimeBetween('-1 months', 'now'),
            ]);
        }


        // --- 3. SEEDER DEWAN GURU BESAR (DATA PADA LENGKAP & BANYAK) ---
        $dataGuruBesar = [
            [
                'nama' => 'H. Lukman',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'M.Ag.',
                'bidang_keahlian' => 'Filsafat Pendidikan Islam Kontemporer',
                'foto' => 'default-prof.png',
                'biografi_singkat' => 'Fokus pada riset rekonstruksi epistemologi pendidikan Islam, integrasi kurikulum berbasis sains-teknologi, dan sosiologi makro kelembagaan pesantren.'
            ],
            [
                'nama' => 'Hj. Siti Aminah',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'M.A.',
                'bidang_keahlian' => 'Hukum Perdata Islam & Sosiologi Hukum',
                'foto' => 'default-prof.png',
                'biografi_singkat' => 'Pakar dalam kajian perbandingan hukum keluarga di Asia Tenggara, mediasi sengketa keperdataan islam, serta legislasi hukum formil pengadilan agama.'
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'M.Pd.',
                'bidang_keahlian' => 'Manajemen Strategis Pendidikan Tinggi',
                'foto' => 'default-prof.png',
                'biografi_singkat' => 'Aktif mengembangkan model penjaminan mutu terpadu (TQM), tata kelola organisasi madrasah modern, dan analisis kebijakan publik kependidikan.'
            ],
            [
                'nama' => 'M. Lutfi Mustofa',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'M.Ag.',
                'bidang_keahlian' => 'Teologi Islam & Dialog Antar Iman',
                'foto' => 'default-prof.png',
                'biografi_singkat' => 'Meneliti pemikiran teologi islam klasik, studi kerukunan sosiologis antarumat beragama, dan strategi penguatan pilar moderasi beragama nasional.'
            ],
            [
                'nama' => 'H. Hendra Wijaya',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'M.E.I.',
                'bidang_keahlian' => 'Ekonomi Islam & Kebijakan Fiskal Syariah',
                'foto' => 'default-prof.png',
                'biografi_singkat' => 'Spesialisasi riset pada instrumen filantropi (tata kelola zakat komparatif dan wakaf produktif) serta ekosistem hukum perbankan syariah nasional.'
            ],
            [
                'nama' => 'Hj. Rahmawati',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'M.Si.',
                'bidang_keahlian' => 'Komunikasi Massa & Komunikasi Dakwah',
                'foto' => 'default-prof.png',
                'biografi_singkat' => 'Kajian mendalam sosiologi media siber, konstruksi retorika dakwah kreatif di ruang digital, serta analisis jurnalisme investigatif keagamaan.'
            ],
            [
                'nama' => 'Zulkifli',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'M.Hum.',
                'bidang_keahlian' => 'Sejarah Kebudayaan Islam & Filologi',
                'foto' => 'default-prof.png',
                'biografi_singkat' => 'Ahli dalam pembacaan manuskrip keagamaan nusantara kuno, rekonstruksi jalur dakwah maritim, dan perkembangan kebudayaan islam kontemporer.'
            ],
            [
                'nama' => 'H. Supriadi',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'M.Sc.',
                'bidang_keahlian' => 'Studi Kurikulum & Evaluasi Pendidikan',
                'foto' => 'default-prof.png',
                'biografi_singkat' => 'Mengembangkan sistem penilaian otentik pembelajaran digital, psikometrika kependidikan, serta model evaluasi kurikulum adaptif institusi keagamaan.'
            ]
        ];

        foreach ($dataGuruBesar as $gb) {
            GuruBesar::create($gb);
        }
    }
}
