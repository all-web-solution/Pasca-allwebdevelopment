<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;
use App\Models\Berita;
use App\Models\GuruBesar;
use Faker\Factory as Faker;
use Illuminate\Support\Str; // <-- WAJIB TAMBAHIN INI BUAT BIKIN SLUG
class KontenWebSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan lokalisasi Indonesia

        // --- 1. SEEDER PROGRAM STUDI (DATA LENGKAP & FORMAL) ---
        $dataProdi = [
            [
                'nama' => 'S2 - Pendidikan Agama Islam (PAI)',
                'slug' => Str::slug('S2 - Pendidikan Agama Islam (PAI)'), // Bikin slug otomatis
                'icon' => 'fa-book-quran',
                'search_tags' => 'pendidikan agama islam pai tarbiyah kurikulum guru dosen',
                'deskripsi' => 'Fokus pada pengembangan inovasi metode pengajaran, konstruksi kurikulum berbasis digital instruksional, serta penguatan riset pedagogi Islam transformatif di era modern.',

                // DATA KONTEN DETAIL HALAMAN
                'profil' => '<p>Program Magister Pendidikan Agama Islam (PAI) dirancang untuk mencetak lulusan yang profesional, inovatif, dan responsif terhadap dinamika pendidikan Islam kontemporer. Lulusan dipersiapkan untuk menjadi akademisi, konsultan, maupun praktisi pendidikan yang handal.</p>',
                'visi_misi' => '<p><b>Visi:</b><br>Menjadi pusat keunggulan (center of excellence) dalam riset dan pengembangan Pendidikan Agama Islam di Asia Tenggara.</p><p><b>Misi:</b></p><ul><li>Menyelenggarakan pendidikan Islam berbasis riset multidisipliner.</li><li>Melakukan pengabdian yang berdampak langsung pada madrasah dan pesantren.</li></ul>',
                'kurikulum' => '<p>Total beban studi adalah 36 SKS.</p><table border="1" style="width:100%"><tr><th>Mata Kuliah Utama</th><th>SKS</th></tr><tr><td>Filsafat Pendidikan Islam</td><td>3 SKS</td></tr><tr><td>Metodologi Penelitian PAI</td><td>3 SKS</td></tr></table>',
                'dosen' => '<ul><li>Prof. Dr. H. Lukman, M.Ag.</li><li>Dr. Ahmad Ridwan, M.Pd.</li></ul>',
                'dokumen' => '<p><a href="#">Unduh Pedoman Penulisan Tesis PAI (PDF)</a></p>'
            ],
            [
                'nama' => 'S2 - Manajemen Pendidikan Islam (MPI)',
                'slug' => Str::slug('S2 - Manajemen Pendidikan Islam (MPI)'),
                'icon' => 'fa-folder-tree',
                'search_tags' => 'manajemen pendidikan islam mpi sekolah madrasah tata kelola kepemimpinan',
                'deskripsi' => 'Mempersiapkan pengelola, kepala madrasah, dan pengawas institusi pendidikan yang strategis, visioner, akuntabel, serta adaptif.',
                'profil' => '<p>Program Studi MPI berfokus pada penguatan kapasitas kepemimpinan (leadership) dan tata kelola (governance) lembaga pendidikan Islam agar mampu bersaing di taraf internasional.</p>',
                'visi_misi' => '<ul><li><b>Visi:</b> Pionir tata kelola pendidikan Islam modern.</li></ul>',
                'kurikulum' => '<p>Mata kuliah unggulan: Manajemen Mutu Terpadu (TQM), Kepemimpinan Visioner, Sistem Informasi Manajemen Pendidikan.</p>',
                'dosen' => '<ul><li>Prof. Dr. Ahmad Fauzi, M.Pd.</li></ul>',
                'dokumen' => '<p><a href="#">Unduh Instrumen Akreditasi MPI (PDF)</a></p>'
            ],
            [
                'nama' => 'S2 - Hukum Keluarga Islam (HKI)',
                'slug' => Str::slug('S2 - Hukum Keluarga Islam (HKI)'),
                'icon' => 'fa-scale-unbalanced',
                'search_tags' => 'hukum keluarga islam hki syariah perdata fikih sengketa pengadilan',
                'deskripsi' => 'Pendalaman yurisprudensi fikih sosiologis kontemporer, penanganan legislasi hukum formil, dan mediasi sengketa keluarga.',
                'profil' => '<p>Prodi HKI mencetak praktisi hukum, mediator bersertifikat, dan hakim agama yang menguasai hukum positif Indonesia dan kitab kuning.</p>',
                'visi_misi' => '<p>Menegakkan keadilan restoratif dalam tatanan keluarga muslim modern.</p>',
                'kurikulum' => '<p>Mata kuliah inti: Sosiologi Hukum Islam, Penyelesaian Sengketa (ADR), Hukum Acara Peradilan Agama.</p>',
                'dosen' => '<ul><li>Prof. Dr. Hj. Siti Aminah, M.A.</li></ul>',
                'dokumen' => '<p><a href="#">Unduh Jurnal Ahwal Al-Syakhshiyyah</a></p>'
            ],
            [
                'nama' => 'S2 - Studi Agama Agama (SAA)',
                'slug' => Str::slug('S2 - Studi Agama Agama (SAA)'),
                'icon' => 'fa-hands-holding-child',
                'search_tags' => 'studi agama saa toleransi filsafat teologi moderasi sosial',
                'deskripsi' => 'Kajian mendalam mengenai kerukunan antarumat beragama, resolusi konflik sosiologis, dan penguatan pilar moderasi.',
                'profil' => '<p>Program Studi SAA menjadi pionir dalam kajian resolusi konflik, moderasi beragama, dan teologi lintas iman di Indonesia.</p>',
                'visi_misi' => '<p>Mewujudkan harmoni sosial melalui pendekatan akademis dan dialog antar iman.</p>',
                'kurikulum' => '<ul><li>Filsafat Perenial</li><li>Sosiologi Agama Kontemporer</li></ul>',
                'dosen' => '<ul><li>Prof. Dr. M. Lutfi Mustofa, M.Ag.</li></ul>',
                'dokumen' => '<p><a href="#">Modul Moderasi Beragama</a></p>'
            ],
            [
                'nama' => 'S2 - Ekonomi Syariah (EKOS)',
                'slug' => Str::slug('S2 - Ekonomi Syariah (EKOS)'),
                'icon' => 'fa-wallet',
                'search_tags' => 'ekonomi syariah ekos perbankan akuntansi makro mikro keuangan',
                'deskripsi' => 'Pengembangan analisis sistem keuangan syariah, tata kelola perbankan islam, instrumen filantropi, serta industri halal.',
                'profil' => '<p>Prodi EKOS menjawab tantangan globalisasi industri halal dan perbankan syariah dengan pendekatan makro dan mikro ekonomi makro yang komprehensif.</p>',
                'visi_misi' => '<p>Menjadi kiblat inovasi produk keuangan syariah di tingkat nasional.</p>',
                'kurikulum' => '<p>Fokus Riset: Ziswaf, Pasar Modal Syariah, Halal Supply Chain.</p>',
                'dosen' => '<ul><li>Prof. Dr. H. Hendra Wijaya, M.E.I.</li></ul>',
                'dokumen' => '<p><a href="#">Panduan Tesis Ekonomi Syariah</a></p>'
            ],
            [
                'nama' => 'S2 - Komunikasi dan Penyiaran Islam (KPI)',
                'slug' => Str::slug('S2 - Komunikasi dan Penyiaran Islam (KPI)'),
                'icon' => 'fa-bullhorn',
                'search_tags' => 'komunikasi penyiaran islam kpi dakwah jurnalistik media digital jurnalis',
                'deskripsi' => 'Studi strategi komunikasi massa, produksi konten dakwah kreatif berbasis multimedia, jurnalisme investigatif.',
                'profil' => '<p>Mencetak dai, jurnalis, dan pakar komunikasi yang mampu memanfaatkan media baru (new media) untuk diseminasi nilai-nilai keislaman.</p>',
                'visi_misi' => '<p>Mengedepankan dakwah transformatif di era cyber society.</p>',
                'kurikulum' => '<p>Mata Kuliah: Sosiologi Komunikasi Massa, Jurnalisme Investigatif, Strategi Dakwah Digital.</p>',
                'dosen' => '<ul><li>Prof. Dr. Hj. Rahmawati, M.Si.</li></ul>',
                'dokumen' => '<p><a href="#">SOP Praktikum Studio Penyiaran</a></p>'
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
