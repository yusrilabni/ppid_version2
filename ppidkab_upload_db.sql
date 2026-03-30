-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 03 Des 2025 pada 09.52
-- Versi server: 8.0.44
-- Versi PHP: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppidkab_upload_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `count_data`
--

CREATE TABLE `count_data` (
  `count_id` int NOT NULL,
  `count_nama` varchar(256) NOT NULL,
  `count_jml` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dok_data`
--

CREATE TABLE `dok_data` (
  `dok_id` int NOT NULL,
  `kategori_id` int NOT NULL,
  `jenis_id` int NOT NULL,
  `dok_nama` varchar(256) NOT NULL,
  `dok_deskripsi` text NOT NULL,
  `dok_file` text NOT NULL,
  `dok_url` text NOT NULL,
  `nip` varchar(18) NOT NULL,
  `unit_id` varchar(11) NOT NULL,
  `dok_count` int NOT NULL DEFAULT '0',
  `dok_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dok_data`
--

INSERT INTO `dok_data` (`dok_id`, `kategori_id`, `jenis_id`, `dok_nama`, `dok_deskripsi`, `dok_file`, `dok_url`, `nip`, `unit_id`, `dok_count`, `dok_created`) VALUES
(3, 1, 0, 'LHKPN SEKDA Tahun 2020', 'LHKPN SEKDA Tahun 2020', 'lhkpn_sekda.pdf', '', '197901152009011005', '730714', 146, '2021-10-01 18:21:42'),
(4, 1, 0, 'LHKPN WAKIL BUPATI Tahun 2020', 'LHKPN WAKIL BUPATI Tahun 2020', 'lhkpn_wakil_bupati.pdf', '', '197901152009011005', '730714', 133, '2021-10-01 18:56:51'),
(5, 1, 0, 'LHKPN BUPATI Tahun 2020', 'LHKPN BUPATI Tahun 2020', 'lhkpn_Bupati_2020.pdf', '', '197901152009011005', '730714', 150, '2021-10-01 18:59:14'),
(6, 1, 0, 'Indeks Kepuasan Masyarakat Tahun 2020', 'Indeks Kepuasan Masyarakat Tahun 2020', 'indeks_kepuasan_2020.pdf', '', '197901152009011005', '730714', 133, '2021-10-12 04:17:42'),
(7, 1, 0, 'DPA Penguatan Tata Kelola Informasi Pemerintah Daerah (PPID)', 'DPA Penguatan Tata Kelola Informasi Pemerintah Daerah (PPID)', '1__PPID_2021_DPA.docx', '', '197901152009011005', '730714', 116, '2021-10-12 04:27:56'),
(10, 1, 0, 'Sop Penanganan Sengketa PPID', 'Sop Penanganan Sengketa PPID', '02-01-PISKP-Penanganan_Sengketa_PPID.pdf', '', '197901152009011005', '730714', 101, '2021-10-13 02:07:50'),
(11, 1, 0, 'Sop Penetapan dan Pemutakhiran DIP ', 'Sop Penetapan dan Pemutakhiran DIP ', '02-01-PISKP-Penetapan_dan_Pemutakhiran_DIP_OK.pdf', '', '197901152009011005', '730714', 107, '2021-10-13 02:08:40'),
(12, 1, 0, 'Sop Pengelolaan Keberatan PPID', 'Sop Pengelolaan Keberatan PPID', '02-01-PISKP-Pengelolaan_Keberatan_PPID.pdf', '', '197901152009011005', '730714', 110, '2021-10-13 02:09:27'),
(13, 1, 0, 'Sop Pengelolaan Permohonan Informasi', 'Sop Pengelolaan Permohonan Informasi', '02-01-PISKP-Pengelolaan_Permohonan_informasi.pdf', '', '197901152009011005', '730714', 146, '2021-10-13 02:10:16'),
(14, 1, 0, 'Sop Uji Konsikuensi', 'Sop Uji Konsikuensi', '02-01-PISKP-Uji_Konsekuensi.pdf', '', '197901152009011005', '730714', 102, '2021-10-13 02:11:02'),
(15, 1, 0, 'Sop Pendokumentasian Informasi Publik', 'Sop Pendokumentasian Informasi Publik', 'PISKP-Pendokumentasian_Informasi_Publik.pdf', '', '197901152009011005', '730714', 119, '2021-10-13 02:11:51'),
(16, 1, 0, 'Sop Pendokumentasian Informasi Publik yang dikecualikan', 'Sop Pendokumentasian Informasi Publik yang dikecualikan', 'PISKP-Pendokumentasian_Informasi_yang_Dikecualikan.pdf', '', '197901152009011005', '730714', 106, '2021-10-13 02:12:38'),
(17, 2, 0, 'Tata Cara Permohonan Informasi dan Tata Cara Pengajuan Keberatan', 'Tata Cara Permohonan Informasi dan Tata Cara Pengajuan Keberatan', 'Tata_Cara_Permohonan_Informasi_dan_Tata_cara_pengajuan_keberatan.docx', '', '197901152009011005', '730714', 135, '2021-10-13 02:15:57'),
(18, 2, 0, 'Lampiran Capaian Perjanjian Kinerja Dinas Perikanan Tahun 2020', 'Lampiran Capaian Perjanjian Kinerja Dinas Perikanan Tahun 2020', 'LAMPIRAN_CAPAIAN_PK_TA_2020.pdf', '', '197901152009011005', '730714', 107, '2021-10-13 02:18:39'),
(21, 1, 0, 'Rencana Kinerja Tahunan 2022 Diskominfo Sinjai', 'Rencana Kinerja Tahunan 2022 Diskominfo Sinjai', '3_b__Rencana_Kinerja_Tahunan_2022_Diskominfo_Sinjai.pdf', '', '197708262010011003', '730714', 140, '2022-04-20 05:55:13'),
(24, 1, 0, 'SK Pengangkatan Tenaga Sukarela DP3AP2KB 2022', '', 'SK_TENAGA_SUKARELA_2022.pdf', '', '198411012010012007', '730709', 150, '2022-04-25 03:38:56'),
(26, 1, 0, 'Bagan Susunan Organisasi Dinas Lingkungan Hidup dan Kehutanan Kab. Sinjai ', 'Struktur Organisasi DLHK  berdasarkan Peraturan Bupati Sinjai Nomor 58 Tahun 2022 ', 'STRUKTUR_DLHK_2022_(5).pdf', '', '197909292007012009', '730731', 153, '2022-04-25 05:42:35'),
(28, 1, 4, 'DPA POLPP DAN DAMKAR TAHUN 2022', 'DPA POLPP DAN DAMKAR TAHUN 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300159327', '198504112009042008', '730714', 15, '2022-05-10 03:27:04'),
(29, 1, 5, 'Realisasi PAD Bulan April Tahun 2022', 'Realisasi PAD Bulan April Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300159327', '198504112009042008', '730714', 19, '2022-05-19 02:27:48'),
(30, 1, 2, 'SK PPID Tahun 2022', 'SK PPID Tahun 2022', 'SK_Bupati_PPID_2022.pdf', '', '198504112009042008', '730714', 137, '2022-05-19 02:35:30'),
(31, 2, 7, 'Inventaris Satpol PP dan Damkar', 'Inventaris Satpol PP dan Damkar', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300159636', '198504112009042008', '730714', 22, '2022-05-19 02:40:33'),
(32, 1, 4, 'DPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2020', 'DPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2020', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158898', '198504112009042008', '730714', 18, '2022-05-19 02:42:18'),
(33, 1, 1, 'Struktur Organisasi Tahun 2022 Dinas Pekerjjaan Umum dan Penataan Ruang Kab.Sinjai', 'Struktur Organisasi Tahun 2022 Dinas Pekerjjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158869', '198504112009042008', '730714', 17, '2022-05-19 02:43:04'),
(34, 3, 10, 'Sk Bupati Informasi Yang Dikecualikan', 'Sk Bupati Informasi Yang Dikecualikan', 'SK_BUPATI_-_INFORMASI_DIKECUALIKAN.pdf', '', '198504112009042008', '730714', 150, '2022-05-19 03:03:17'),
(35, 1, 2, 'DOKUMEN PERUBAHAN RENJA 2021', '', 'DOKUMEN_PERUBAHAN_RENJA_2021_compressed.pdf', '', '197109211992031006', '730712', 92, '2022-06-10 03:54:43'),
(36, 1, 4, 'Realisasi PAD PARIWISATA Bulan Mei Tahun 2022', 'Realisasi PAD Bulan Mei Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300169093', '198504112009042008', '730714', 8, '2022-06-20 05:45:53'),
(37, 1, 3, 'evaluasi program triwulan IV Dinas  Koperasi UKM dan Tenaga Kerja', 'evaluasi program triwulan IV Dinas  Koperasi UKM dan Tenaga Kerja', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300163313', '198504112009042008', '730714', 9, '2022-06-20 05:59:20'),
(38, 2, 1, 'Tugas Pokok dan Fungsi Bappeda Tahun 2021', 'Tugas Pokok dan Fungsi Bappeda Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158170', '198504112009042008', '730714', 13, '2022-06-20 06:06:23'),
(39, 2, 2, 'Rencana Aksi Tahun 2022 Bapedda', 'Rencana Aksi Tahun 2022 Bapedda', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158127', '198504112009042008', '730714', 9, '2022-06-20 06:09:54'),
(40, 2, 1, 'Rencana Aksi Tahun 2021 Bapedda', 'Rencana Aksi Tahun 2021 Bapedda', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158125', '198504112009042008', '730714', 15, '2022-06-20 06:16:23'),
(41, 1, 4, 'Laporan Keuangan Akhir Tahun 2021 Bappeda', 'Laporan Keuangan Akhir Tahun 2021 Bappeda', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158113', '198504112009042008', '730714', 8, '2022-06-20 06:25:12'),
(42, 1, 2, 'Rencana Aksi Tahun 2022 Bappeda', 'Rencana Aksi Tahun 2022 Bappeda', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158127', '198504112009042008', '730714', 8, '2022-06-20 06:28:39'),
(43, 1, 2, 'Rencana Aksi Tahun 2021 Bappeda', 'Rencana Aksi Tahun 2021 Bappeda', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158125', '198504112009042008', '730714', 8, '2022-06-20 06:29:39'),
(44, 1, 1, 'Perbup Kab. SInjai Penyesuaian Tarif Retribusi Kebersihan DLHK', 'Perbup Kab. SInjai Penyesuaian Tarif Retribusi Kebersihan DLHK', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300159191', '198504112009042008', '730714', 8, '2022-06-20 06:42:42'),
(45, 1, 4, 'DPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2020', 'DPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2020', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158898', '198504112009042008', '730714', 9, '2022-06-20 06:53:07'),
(46, 1, 1, 'Struktur Organisasi Tahun 2021 Dinas Pekerjjaan Umum dan Penataan Ruang Kab.Sinjai', 'Struktur Organisasi Tahun 2021 Dinas Pekerjjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158868', '198504112009042008', '730714', 7, '2022-06-20 06:53:50'),
(47, 1, 2, 'Rencana Aksi Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Rencana Aksi Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158641', '198504112009042008', '730714', 8, '2022-06-20 06:55:39'),
(48, 1, 2, 'RENJA Pokok Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'RENJA Pokok Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158588', '198504112009042008', '730714', 6, '2022-06-20 06:57:37'),
(49, 1, 4, 'kemajuan fisik diskopnaker 2021', 'kemajuan fisik diskopnaker 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158584', '198504112009042008', '730714', 7, '2022-06-20 06:58:39'),
(50, 1, 1, 'DPPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', 'DPPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158468', '198504112009042008', '730714', 7, '2022-06-20 07:01:10'),
(51, 1, 1, 'perjanjian kinerja tahun 2021 Dinas Koperasi UKM dan Tenaga Kerja', 'perjanjian kinerja tahun 2021 Dinas Koperasi UKM dan Tenaga Kerja', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158452', '198504112009042008', '730714', 9, '2022-06-20 07:04:12'),
(52, 1, 5, 'Laporan Capaian Kinerja dan Ikhtisar Realisasi Kinerja Tahun 2021 Dinas Pekerjan Umum dan Penataan Ruang Kab.Sinjai', 'Laporan Capaian Kinerja dan Ikhtisar Realisasi Kinerja Tahun 2021 Dinas Pekerjan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158387', '198504112009042008', '730714', 9, '2022-06-20 07:05:52'),
(53, 1, 4, 'Laporan Keuangan KPU Sinjai Tahun 2021', 'Laporan Keuangan KPU Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158300', '198504112009042008', '730714', 8, '2022-06-20 07:07:11'),
(54, 1, 1, 'Perjanjian Kinerja KPU Sinjai Tahun 2022', 'Perjanjian Kinerja KPU Sinjai Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158294', '198504112009042008', '730714', 8, '2022-06-20 07:08:00'),
(55, 1, 1, 'LAKIP KPU Kabupaten Sinjai Tahun 2021', 'LAKIP KPU Kabupaten Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/500158211', '198504112009042008', '730714', 8, '2022-06-20 07:08:50'),
(56, 1, 2, 'Cascading Bappeda 2022', 'Cascading Bappeda 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400158124', '198504112009042008', '730714', 8, '2022-06-20 07:11:41'),
(57, 1, 2, 'Cascading Diskominfo Sinjai Perubahan 2018-2023', 'Cascading Diskominfo Sinjai Perubahan 2018-2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158097', '198504112009042008', '730714', 8, '2022-06-20 07:12:39'),
(58, 1, 1, 'Rencana Aksi Tahun 2022 Diskominfo', 'Rencana Aksi Tahun 2022 Diskominfo', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157873', '198504112009042008', '730714', 8, '2022-06-20 07:13:49'),
(59, 1, 1, 'RPJMD Tahun 2018 - 2023', 'RPJMD Tahun 2018 - 2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300144757', '198504112009042008', '730714', 7, '2022-06-20 07:15:22'),
(60, 1, 1, 'BA Daftar Pemilih Berkelanjutan Bulan Desember 2021', 'BA Daftar Pemilih Berkelanjutan Bulan Desember 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300143524', '198504112009042008', '730714', 7, '2022-06-20 07:16:58'),
(61, 1, 1, 'BA Daftar Pemilih Berkelanjutan Bulan Januari 2022', 'BA Daftar Pemilih Berkelanjutan Bulan Januari 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300143526', '198504112009042008', '730714', 8, '2022-06-20 07:18:04'),
(62, 1, 1, 'DPA PPID / Penguatan Tata Kelola Komisi Informasi di Daerah', 'DPA PPID / Penguatan Tata Kelola Komisi Informasi di Daerah', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300118841', '198504112009042008', '730714', 9, '2022-06-20 07:19:48'),
(63, 4, 1, 'Jumlah Desa, Luas Daerah dan Tinggi Wilayah', 'Jumlah Desa, Luas Daerah dan Tinggi Wilayah', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/1', '198504112009042008', '730714', 11, '2022-06-20 07:36:58'),
(64, 4, 1, 'Data Sistik  Egoverment', 'Data Sistik  Egoverment', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/2', '198504112009042008', '730714', 9, '2022-06-20 07:39:54'),
(65, 4, 0, 'Data Sistik Jumlah Penduduk Kab.Sinjai', 'Data Sistik Jumlah Penduduk Kab.Sinjai', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/3', '198504112009042008', '730714', 8, '2022-06-20 07:41:12'),
(66, 4, 0, 'Data Sistik Sosial', 'Data Sistik Sosial', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/4', '198504112009042008', '730714', 9, '2022-06-20 07:45:06'),
(67, 4, 1, 'Data Sistik Agricultur Kab.Sinjai', 'Data Sistik Agricultur Kab.Sinjai', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/5', '198504112009042008', '730714', 10, '2022-06-20 07:46:37'),
(68, 4, 0, 'Data Sistik Industri Kab. Sinjai', 'Data Sistik Industri Kab. Sinjai', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/6', '198504112009042008', '730714', 12, '2022-06-20 07:47:38'),
(69, 4, 1, 'Data Sistik Trending Kab. Sinjai', 'Data Sistik Trending Kab. Sinjai', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/7', '198504112009042008', '730714', 8, '2022-06-20 07:48:36'),
(70, 4, 1, 'Data Sistik Hotel dan Tourisim Kab. Sinjai', 'Data Sistik Hotel dan Tourisim Kab. Sinjai', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/8', '198504112009042008', '730714', 14, '2022-06-20 07:50:38'),
(71, 4, 1, 'Data Sistik Transportation dan Communation Kab.Sinjai', 'Data Sistik Transportation dan Communation Kab.Sinjai', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/9', '198504112009042008', '730714', 9, '2022-06-20 07:53:11'),
(72, 4, 1, 'Data Sistik Finance dan Prices Kab. Sinjai', 'Data Sistik Finance dan Prices Kab. Sinjai', '', 'http://apps.sinjaikab.go.id/sistik/dashboard/kategori/10', '198504112009042008', '730714', 14, '2022-06-20 07:55:35'),
(74, 4, 2, 'MoU KERJASAMA DATA DAN INFORMASI STATISTIK SEKTORAL', 'MoU KERJASAMA DATA DAN INFORMASI STATISTIK SEKTORAL', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400022121', '198504112009042008', '730714', 8, '2022-06-20 07:58:32'),
(75, 4, 2, 'RENCANA STRATEGIS (RENSTRA) 2018-2023 Dinas Perhubungan ', 'RENCANA STRATEGIS (RENSTRA) 2018-2023 Dinas Perhubungan ', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/500117539', '198504112009042008', '730714', 9, '2022-06-20 08:00:14'),
(76, 4, 1, 'Rencana Strategis Sekretariat Daerah 2018-2023 ', 'Rencana Strategis Sekretariat Daerah 2018-2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300072824', '198504112009042008', '730714', 9, '2022-06-20 08:01:32'),
(77, 4, 1, 'RENCANA STRATEGIS TAHUN 2018 - 2023 DINAS KOMUNIKASI INFORMATIKA & PERSANDIAN KAB. SINJAI', 'RENCANA STRATEGIS TAHUN 2018 - 2023 DINAS KOMUNIKASI INFORMATIKA & PERSANDIAN KAB. SINJAI', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300071441', '198504112009042008', '730714', 9, '2022-06-20 08:02:43'),
(78, 4, 1, 'Rencana Strategis (renstra) Bappeda 2013-2018', 'Rencana Strategis (renstra) Bappeda 2013-2018', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300058609', '198504112009042008', '730714', 9, '2022-06-20 08:03:36'),
(79, 4, 1, 'RENCANA STRATEGIS DINAS PMPTSP 2013-2018', 'RENCANA STRATEGIS DINAS PMPTSP 2013-2018', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300033706', '198504112009042008', '730714', 13, '2022-06-20 08:04:23'),
(80, 4, 4, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 31 Maret 2022', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 31 Maret 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158855', '198504112009042008', '730714', 10, '2022-06-20 08:07:21'),
(81, 1, 2, 'Cascadding Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Cascadding Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158651', '198504112009042008', '730714', 7, '2022-06-21 02:29:25'),
(82, 1, 3, 'Rencana Aksi Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Rencana Aksi Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158641', '198504112009042008', '730714', 8, '2022-06-21 16:37:37'),
(83, 1, 3, 'Evaluasi Rencana Aksi Triwulan I Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Evaluasi Rencana Aksi Triwulan I Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158615', '198504112009042008', '730714', 6, '2022-06-21 16:39:26'),
(84, 1, 3, 'Evaluasi Rencana Kerja Triwulan I Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Evaluasi Rencana Kerja Triwulan I Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158617', '198504112009042008', '730714', 7, '2022-06-21 16:40:05'),
(85, 1, 2, 'RENSTRA Tahun 2018-2023 Tahun Anggaran 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'RENSTRA Tahun 2018-2023 Tahun Anggaran 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158629', '198504112009042008', '730714', 5, '2022-06-21 16:40:49'),
(86, 1, 1, 'TUPOKSI Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'TUPOKSI Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158626', '198504112009042008', '730714', 3, '2022-06-21 16:41:32'),
(87, 1, 3, 'RKT Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'RKT Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158589', '198504112009042008', '730714', 5, '2022-06-21 16:46:56'),
(88, 1, 3, 'RENJA Pokok Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'RENJA Pokok Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158588', '198504112009042008', '730714', 6, '2022-06-21 16:47:33'),
(89, 1, 5, 'DPA 2022', 'DPA 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158587', '198504112009042008', '730714', 5, '2022-06-21 16:48:12'),
(90, 1, 5, 'sk Tim pelaksanaan kegiatan penyusunan dokumen 2022', 'sk Tim pelaksanaan kegiatan penyusunan dokumen 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158580', '198504112009042008', '730714', 5, '2022-06-21 16:48:58'),
(91, 1, 5, 'kemajuan fisik diskopnaker 2021', 'kemajuan fisik diskopnaker 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158584', '198504112009042008', '730714', 4, '2022-06-22 16:55:56'),
(92, 1, 3, 'RENJA Pokok Tahun 2020 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'RENJA Pokok Tahun 2020 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158579', '198504112009042008', '730714', 3, '2022-06-22 16:57:02'),
(93, 1, 5, 'sk panitia pelaksana kegiatan pelaksanaan penatausahaan /verifikasi', 'sk panitia pelaksana kegiatan pelaksanaan penatausahaan /verifikasi', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158569', '198504112009042008', '730714', 3, '2022-06-22 16:57:39'),
(94, 1, 5, 'sk pembentukan kebersihan kantor diskopnaker 2022', 'sk pembentukan kebersihan kantor diskopnaker 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158568', '198504112009042008', '730714', 4, '2022-06-22 16:58:25'),
(95, 1, 5, 'sk panitia pelaksana kegiatan penyediaan jasa pelayanan umum kantor', 'sk panitia pelaksana kegiatan penyediaan jasa pelayanan umum kantor', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158567', '198504112009042008', '730714', 4, '2022-06-22 16:58:59'),
(96, 1, 5, 'sk pembentukan tim pengelolaan konten website pada dinas koperasi 2022', 'sk pembentukan tim pengelolaan konten website pada dinas koperasi 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158566', '198504112009042008', '730714', 3, '2022-06-22 16:59:29'),
(97, 1, 5, 'sk berisi pelimpahan wewenang pejabat pengguna anggaran', 'sk berisi pelimpahan wewenang pejabat pengguna anggaran', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158552', '198504112009042008', '730714', 6, '2022-06-22 17:01:25'),
(98, 1, 5, 'sk pengangkatan tenaga sopir', 'sk pengangkatan tenaga sopir', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158549', '198504112009042008', '730714', 7, '2022-06-22 17:01:46'),
(99, 1, 5, 'sk kelompok tugas substansi dan nomenklatur sub koordinasi diskopnaker 2021', 'sk kelompok tugas substansi dan nomenklatur sub koordinasi diskopnaker 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158548', '198504112009042008', '730714', 6, '2022-06-22 17:02:18'),
(100, 1, 5, 'sk pelimpahan wewenang pejabat pengguna anggaran', 'sk pelimpahan wewenang pejabat pengguna anggaran', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158545', '198504112009042008', '730714', 3, '2022-06-22 17:02:48'),
(101, 1, 5, 'sk pemberian dan pembesaran uang persediaan', 'sk pemberian dan pembesaran uang persediaan', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158544', '198504112009042008', '730714', 3, '2022-06-22 17:03:12'),
(102, 1, 5, 'SK Tim pemberdayaan peningkatan produktivitas', 'SK Tim pemberdayaan peningkatan produktivitas', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158541', '198504112009042008', '730714', 4, '2022-06-22 17:04:08'),
(103, 1, 5, 'SK pembentukan penilaian kesehatan 2022', 'SK pembentukan penilaian kesehatan 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158540', '198504112009042008', '730714', 3, '2022-06-22 17:04:34'),
(104, 1, 5, 'SK PPK', 'SK PPK', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158539', '198504112009042008', '730714', 3, '2022-06-22 17:04:57'),
(105, 1, 5, 'SK pengangkatan pejabat pelaksanaan teknis', 'SK pengangkatan pejabat pelaksanaan teknis', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158538', '198504112009042008', '730714', 7, '2022-06-22 17:05:24'),
(106, 1, 5, 'SK penetapan pemengang', 'SK penetapan pemengang', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158535', '198504112009042008', '730714', 5, '2022-06-22 17:05:55'),
(107, 1, 5, 'sk pendataan potensi', 'sk pendataan potensi', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158530', '198504112009042008', '730714', 6, '2022-06-22 17:11:56'),
(108, 1, 5, 'kegiatan fasilitasi usaha', 'kegiatan fasilitasi usaha', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158524', '198504112009042008', '730714', 5, '2022-06-22 17:12:21'),
(109, 1, 3, 'RKT Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'RKT Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158521', '198504112009042008', '730714', 4, '2022-06-22 17:12:44'),
(110, 1, 3, 'RENJA Pokok Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'RENJA Pokok Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158498', '198504112009042008', '730714', 3, '2022-06-22 17:13:11'),
(111, 1, 2, 'Pohon Kinerja Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Pohon Kinerja Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158485', '198504112009042008', '730714', 5, '2022-06-22 17:13:48'),
(112, 1, 2, 'DPA Pol PP dan Damkar Tahun 2022', 'DPA Pol PP dan Damkar Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158483', '198504112009042008', '730714', 3, '2022-06-22 17:14:38'),
(113, 1, 3, 'Perjanjian Kinerja Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Perjanjian Kinerja Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158481', '198504112009042008', '730714', 4, '2022-06-22 17:15:00'),
(114, 1, 2, 'Cascadding Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Cascadding Tahun 2022 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158478', '198504112009042008', '730714', 5, '2022-06-22 17:15:27'),
(115, 1, 2, 'Perubahan RENSTRA Tahun 2018-2023 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Perubahan RENSTRA Tahun 2018-2023 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158475', '198504112009042008', '730714', 5, '2022-06-22 17:16:00'),
(116, 1, 2, 'DPPA Ke-3 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', 'DPPA Ke-3 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158471', '198504112009042008', '730714', 5, '2022-06-22 17:16:39'),
(117, 1, 2, 'DPPA Ke-2 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', 'DPPA Ke-2 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158469', '198504112009042008', '730714', 4, '2022-06-25 16:09:17'),
(118, 1, 2, 'DPPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', 'DPPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158468', '198504112009042008', '730714', 3, '2022-06-25 16:09:43'),
(119, 1, 2, 'DPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', 'DPA Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158458', '198504112009042008', '730714', 3, '2022-06-25 16:12:05'),
(120, 1, 5, 'ABK ANJAB dan IKU 2019', 'ABK ANJAB dan IKU 2019', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158455', '198504112009042008', '730714', 3, '2022-06-25 16:12:35'),
(121, 1, 5, 'LHKSN Pegawai Diskopnaker 2021', 'LHKSN Pegawai Diskopnaker 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158453', '198504112009042008', '730714', 5, '2022-06-25 16:13:00'),
(122, 1, 5, 'Perjanjian kinerja tahun 2021', 'Perjanjian kinerja tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158452', '198504112009042008', '730714', 4, '2022-06-25 16:13:56'),
(123, 1, 5, 'Perubahan Renstra Diskopnaker 2021', 'Perubahan Renstra Diskopnaker 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158450', '198504112009042008', '730714', 5, '2022-06-25 16:14:32'),
(124, 1, 5, 'Peta Probis dan PK 2021', 'Peta Probis dan PK 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158449', '198504112009042008', '730714', 5, '2022-06-25 16:15:07'),
(125, 1, 5, 'Probis Renstra dan Renja Tahun 2021', 'Probis Renstra dan Renja Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158448', '198504112009042008', '730714', 6, '2022-06-25 16:15:38'),
(126, 1, 5, 'Renja 2021 Diskopnaker2 ok-converted (1)', 'Renja 2021 Diskopnaker2 ok-converted (1)', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158447', '198504112009042008', '730714', 5, '2022-06-25 16:16:24'),
(127, 1, 5, 'RENSTRA DISKOP 2018-2023', 'RENSTRA DISKOP 2018-2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158446', '198504112009042008', '730714', 4, '2022-06-26 12:14:05'),
(128, 1, 5, 'RKT 2021', 'RKT 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158445', '198504112009042008', '730714', 3, '2022-06-26 12:14:31'),
(129, 1, 5, 'SK BUPATI SINJAI NO 73 Tahun 2022 ttg TIM ASESSOR dan AGEN PERUBAHAN 2022', 'SK BUPATI SINJAI NO 73 Tahun 2022 ttg TIM ASESSOR dan AGEN PERUBAHAN 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158444', '198504112009042008', '730714', 3, '2022-06-26 12:15:01'),
(130, 2, 3, 'SK Indikator 2020', 'SK Indikator 2020', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158443', '198504112009042008', '730714', 12, '2022-06-27 04:32:02'),
(131, 1, 5, 'SK Susunan Orgnisasi Tahun 2021', 'SK Susunan Orgnisasi Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158442', '198504112009042008', '730714', 4, '2022-06-27 04:33:05'),
(132, 1, 3, 'SK Tugas Substansi dan Sub koordinator Tahun 2021', 'SK Tugas Substansi dan Sub koordinator Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158441', '198504112009042008', '730714', 4, '2022-06-27 04:33:32'),
(133, 1, 2, 'Perubahan Rencana Kerja (Renja) Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Perubahan Rencana Kerja (Renja) Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158403', '198504112009042008', '730714', 5, '2022-06-27 04:34:06'),
(134, 1, 3, 'Perubahan RKT Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Perubahan RKT Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158400', '198504112009042008', '730714', 5, '2022-06-27 04:35:28'),
(135, 1, 3, 'Perubahan Perjanjian Kinerja Tahun 2021 DPUPR', 'Perubahan Perjanjian Kinerja Tahun 2021 DPUPR', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158391', '198504112009042008', '730714', 4, '2022-06-27 04:36:28'),
(136, 1, 3, 'RENCANA KINERJA TAHUNAN (RKT) TAHUN 2021', 'RENCANA KINERJA TAHUNAN (RKT) TAHUN 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158390', '198504112009042008', '730714', 7, '2022-06-27 04:36:53'),
(137, 1, 3, 'Perubahan Indikator Kinerja Kunci (IKU) Tahun 2018-2023 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Perubahan Indikator Kinerja Kunci (IKU) Tahun 2018-2023 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158389', '198504112009042008', '730714', 3, '2022-06-27 04:37:39'),
(138, 4, 3, 'LAPORAN KINERJA TAHUN 2021', 'LAPORAN KINERJA TAHUN 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158388', '198504112009042008', '730714', 7, '2022-06-27 04:38:22'),
(139, 1, 3, 'Laporan Capaian Kinerja dan Ikhtisar Realisasi Kinerja Tahun 2021 Dinas Pekerjan Umum dan Penataan Ruang Kab.Sinjai', 'Laporan Capaian Kinerja dan Ikhtisar Realisasi Kinerja Tahun 2021 Dinas Pekerjan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158387', '198504112009042008', '730714', 3, '2022-06-27 04:38:57'),
(140, 4, 2, 'RENJA TAHUN 2022', 'RENJA TAHUN 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158386', '198504112009042008', '730714', 7, '2022-06-27 04:39:38'),
(141, 1, 3, 'Evaluasi Rencana Kerja Triwulan IV Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Evaluasi Rencana Kerja Triwulan IV Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158385', '198504112009042008', '730714', 4, '2022-06-27 04:40:25'),
(142, 1, 3, 'Evaluasi Rencana Kerja Triwulan III Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Evaluasi Rencana Kerja Triwulan III Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158384', '198504112009042008', '730714', 5, '2022-06-27 04:41:57'),
(143, 1, 2, 'PERJANJIAN KINERJA TAHUN 2022', 'PERJANJIAN KINERJA TAHUN 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158383', '198504112009042008', '730714', 4, '2022-06-27 04:42:37'),
(144, 1, 3, 'Evaluasi Rencana Kerja Triwulan II Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Evaluasi Rencana Kerja Triwulan II Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158382', '198504112009042008', '730714', 6, '2022-06-27 04:43:05'),
(145, 1, 3, 'Evaluasi Rencana Kerja Triwulan I Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', 'Evaluasi Rencana Kerja Triwulan I Tahun 2021 Dinas Pekerjaan Umum dan Penataan Ruang Kab.Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158381', '198504112009042008', '730714', 3, '2022-06-27 04:43:43'),
(146, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 Desember 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 Desember 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158361', '198504112009042008', '730714', 3, '2022-06-27 04:44:09'),
(147, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 November 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 November 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158360', '198504112009042008', '730714', 4, '2022-06-27 04:49:56'),
(148, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 29 Oktober 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 29 Oktober 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158359', '198504112009042008', '730714', 5, '2022-06-27 04:50:17'),
(149, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 September 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 September 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158358', '198504112009042008', '730714', 5, '2022-06-27 04:50:43'),
(150, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 31 Agustus 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 31 Agustus 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158357', '198504112009042008', '730714', 5, '2022-06-27 04:51:16'),
(151, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 Juli 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 Juli 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158355', '198504112009042008', '730714', 4, '2022-06-27 04:51:48'),
(152, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 Juni 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 Juni 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158347', '198504112009042008', '730714', 4, '2022-06-27 04:52:20'),
(153, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 31 Mei 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 31 Mei 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158323', '198504112009042008', '730714', 5, '2022-06-27 04:57:10'),
(154, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 April 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 30 April 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158301', '198504112009042008', '730714', 4, '2022-06-27 05:19:42'),
(155, 1, 4, 'Laporan Keuangan KPU Sinjai Tahun 2021', 'Laporan Keuangan KPU Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158300', '198504112009042008', '730714', 3, '2022-06-27 05:20:20'),
(156, 1, 3, 'Perjanjian Kinerja KPU Sinjai Tahun 2022', 'Perjanjian Kinerja KPU Sinjai Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158294', '198504112009042008', '730714', 3, '2022-06-27 05:20:50'),
(157, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 31 Maret 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 31 Maret 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158290', '198504112009042008', '730714', 1, '2022-06-30 10:45:15'),
(158, 1, 2, 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 26 Februari 2021', 'Laporan Kemajuan Fisik dan Keuangan Menurut Alokasi Bidang Keadaan s/d 26 Februari 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158287', '198504112009042008', '730714', 1, '2022-06-30 10:45:50'),
(159, 1, 3, 'LAKIP KPU Kabupaten Sinjai Tahun 2021', 'LAKIP KPU Kabupaten Sinjai Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/500158211', '198504112009042008', '730714', 2, '2022-06-30 10:46:33'),
(160, 4, 2, 'BA Daftar Pemilih Berkelanjutan bulan Maret 2022', 'BA Daftar Pemilih Berkelanjutan bulan Maret 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/500158200', '198504112009042008', '730714', 4, '2022-06-30 10:47:45'),
(161, 2, 1, 'Tugas Pokok dan Fungsi Bappeda Tahun 2021', 'Tugas Pokok dan Fungsi Bappeda Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158170', '198504112009042008', '730714', 5, '2022-06-30 10:48:56'),
(162, 2, 3, 'Rencana Aksi Tahun 2022', 'Rencana Aksi Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158127', '198504112009042008', '730714', 10, '2022-06-30 10:49:23'),
(163, 2, 3, 'Rencana Aksi Tahun 2021', 'Rencana Aksi Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158125', '198504112009042008', '730714', 6, '2022-06-30 10:49:55'),
(164, 2, 3, 'Cascading Bappeda 2022', 'Cascading Bappeda 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400158124', '198504112009042008', '730714', 6, '2022-06-30 10:50:17'),
(165, 2, 3, 'Perjanjian Kinerja Tahun 2022', 'Perjanjian Kinerja Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158123', '198504112009042008', '730714', 4, '2022-06-30 10:51:17'),
(166, 2, 3, 'LKj Bappeda 2021', 'LKj Bappeda 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158121', '198504112009042008', '730714', 6, '2022-06-30 10:51:48'),
(167, 2, 3, 'RKT Bappeda 2022', 'RKT Bappeda 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158119', '198504112009042008', '730714', 5, '2022-06-30 10:52:11'),
(168, 2, 2, 'Rencana Kerja Bappeda Tahun 2022', 'Rencana Kerja Bappeda Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158115', '198504112009042008', '730714', 5, '2022-06-30 10:52:47'),
(169, 2, 4, 'Laporan Keuangan Akhir Tahun 2021', 'Laporan Keuangan Akhir Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158113', '198504112009042008', '730714', 6, '2022-06-30 10:53:17'),
(170, 4, 2, 'Perubahan Renstra 2018-2023', 'Perubahan Renstra 2018-2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158108', '198504112009042008', '730714', 4, '2022-06-30 10:54:01'),
(171, 4, 5, 'Laporan Evaluasi Internal Atas Program KegiatanTahun 2021', 'Laporan Evaluasi Internal Atas Program KegiatanTahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158098', '198504112009042008', '730714', 3, '2022-06-30 10:54:25'),
(172, 1, 2, 'Cascading Diskominfo Sinjai Perubahan 2018-2023', 'Cascading Diskominfo Sinjai Perubahan 2018-2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158097', '198504112009042008', '730714', 1, '2022-06-30 10:55:56'),
(173, 1, 3, 'Evaluasi Rencana Aksi Tahun 2021', 'Evaluasi Rencana Aksi Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158090', '198504112009042008', '730714', 2, '2022-06-30 10:56:19'),
(174, 1, 2, 'Rencana Aksi Tahun 2021', 'Rencana Aksi Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158087', '198504112009042008', '730714', 1, '2022-06-30 10:56:44'),
(175, 1, 3, 'Laporan Kinerja Diskominfo Tahun 2021', 'Laporan Kinerja Diskominfo Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157875', '198504112009042008', '730714', 1, '2022-06-30 10:58:42'),
(176, 1, 2, 'Rencana Aksi Tahun 2022', 'Rencana Aksi Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157873', '198504112009042008', '730714', 1, '2022-06-30 10:59:11'),
(177, 4, 2, 'Renja 2022', 'Renja 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157827', '198504112009042008', '730714', 7, '2022-06-30 11:00:03'),
(178, 4, 2, 'Rentra Perubahan', 'Rentra Perubahan', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157810', '198504112009042008', '730714', 3, '2022-06-30 11:00:35'),
(179, 1, 3, 'Rencana Aksi Tahun Anggaran 2022', 'Rencana Aksi Tahun Anggaran 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157819', '198504112009042008', '730714', 2, '2022-06-30 11:01:07'),
(180, 1, 3, 'Renstra Diskan Ta. 2022', 'Renstra Diskan Ta. 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157807', '198504112009042008', '730714', 3, '2022-07-01 19:36:47'),
(181, 1, 3, 'LKJ Diskan TA. 2021', 'LKJ Diskan TA. 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157796', '198504112009042008', '730714', 1, '2022-07-01 19:37:22'),
(182, 1, 3, 'CASCADING TA. 2022', 'CASCADING TA. 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157788', '198504112009042008', '730714', 1, '2022-07-01 19:37:45'),
(183, 1, 2, 'Perjanjian Kinerja Tahun 2022', 'Perjanjian Kinerja Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157541', '198504112009042008', '730714', 3, '2022-07-01 19:38:07'),
(184, 1, 3, 'Rencana Kinerja Tahun 2022', 'Rencana Kinerja Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157536', '198504112009042008', '730714', 1, '2022-07-01 19:38:32'),
(185, 1, 3, 'Rencana Kerja TAHUN 2022', 'Rencana Kerja TAHUN 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157532', '198504112009042008', '730714', 2, '2022-07-01 19:39:29'),
(186, 1, 2, 'IKU Perubahan 2018 - 2023', 'IKU Perubahan 2018 - 2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157528', '198504112009042008', '730714', 1, '2022-07-01 19:39:55'),
(187, 1, 2, 'Renstra Perubahan 2018 - 2023', 'Renstra Perubahan 2018 - 2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157524', '198504112009042008', '730714', 4, '2022-07-01 19:40:24'),
(188, 4, 3, 'SK Perubahan IKU', 'SK Perubahan IKU', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157303', '198504112009042008', '730714', 5, '2022-07-01 19:41:02'),
(189, 4, 2, 'RKT Pol PP damkar', 'RKT Pol PP damkar', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157297', '198504112009042008', '730714', 4, '2022-07-01 19:41:26'),
(190, 4, 2, 'Renstra Perubahan', 'Renstra Perubahan', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157296', '198504112009042008', '730714', 3, '2022-07-01 19:41:55'),
(191, 4, 3, 'Pohon Kinerja Pol PP Damkar', 'Pohon Kinerja Pol PP Damkar', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157294', '198504112009042008', '730714', 4, '2022-07-01 19:42:27'),
(192, 4, 3, 'Perjanjian Kinerja', 'Perjanjian Kinerja', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157290', '198504112009042008', '730714', 4, '2022-07-01 19:42:51'),
(193, 4, 2, 'LKJ', 'LKJ', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157288', '198504112009042008', '730714', 5, '2022-07-01 19:43:28'),
(194, 4, 3, 'Capaian IKU 2021 Pol PP Damkar', 'Capaian IKU 2021 Pol PP Damkar', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157272', '198504112009042008', '730714', 5, '2022-07-01 19:43:58'),
(195, 4, 2, 'BA Daftar Pemilih Berkelanjutan Bulan Februari 2022', 'BA Daftar Pemilih Berkelanjutan Bulan Februari 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300147847', '198504112009042008', '730714', 5, '2022-07-01 19:44:31'),
(196, 1, 2, 'Cascading Tahun 2022', 'Cascading Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157276', '198504112009042008', '730714', 2, '2022-07-01 19:46:05'),
(197, 1, 5, 'Realisasi PAD Bulan Maret Tahun 2022', 'Realisasi PAD Bulan Maret Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300157092', '198504112009042008', '730714', 3, '2022-07-01 19:46:37'),
(198, 1, 4, 'Dokumen Rencana Kerja Tahun 2022', 'Dokumen Rencana Kerja Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300148612', '198504112009042008', '730714', 3, '2022-07-01 19:47:10'),
(199, 1, 4, 'Dokumen Perubahan Renstra Strategis Tahun 2022', 'Dokumen Perubahan Renstra Strategis Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300148609', '198504112009042008', '730714', 5, '2022-07-01 19:47:38'),
(200, 1, 5, 'Realisasi PAD Bulan Februari Tahun 2022', 'Realisasi PAD Bulan Februari Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300148607', '198504112009042008', '730714', 3, '2022-07-01 19:48:10'),
(201, 1, 5, 'Realisasi PAD Bulan Januari Tahun 2022', 'Realisasi PAD Bulan Januari Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300146982', '198504112009042008', '730714', 1, '2022-07-01 19:49:07'),
(202, 1, 3, 'IKU Perubahan Dinas Peternakan dan Kesehatan Hewan Tahun 2021', 'IKU Perubahan Dinas Peternakan dan Kesehatan Hewan Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300146241', '198504112009042008', '730714', 2, '2022-07-01 19:49:33'),
(203, 1, 3, 'Perjanjian Kinerja Dinas Peternakan dan Kesehatan Hewan Tahun 2021', 'Perjanjian Kinerja Dinas Peternakan dan Kesehatan Hewan Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300146240', '198504112009042008', '730714', 1, '2022-07-01 19:49:53'),
(204, 1, 2, 'RPJMD Tahun 2018 - 2023', 'RPJMD Tahun 2018 - 2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300144757', '198504112009042008', '730714', 2, '2022-07-01 19:50:20'),
(205, 1, 4, 'Dokumen Pelaksanaan Anggaran Perubahan Tahun 2021', 'Dokumen Pelaksanaan Anggaran Perubahan Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300141737', '198504112009042008', '730714', 2, '2022-07-01 19:50:51'),
(206, 1, 4, 'Dokumen Pelaksanaan Anggaran Refocusing Tahun 2021', 'Dokumen Pelaksanaan Anggaran Refocusing Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300141736', '198504112009042008', '730714', 2, '2022-07-01 19:51:29'),
(208, 1, 4, 'Dokumen Pelaksanaan Anggaran Tahun 2021', 'Dokumen Pelaksanaan Anggaran Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300141733', '198504112009042008', '730714', 2, '2022-07-01 19:54:36'),
(209, 4, 2, 'Renja Perubahan Dinas Peternakan dan Kesehatan Hewan Tahun 2021', 'Renja Perubahan Dinas Peternakan dan Kesehatan Hewan Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300146239', '198504112009042008', '730714', 4, '2022-07-01 19:55:07'),
(210, 4, 2, 'BA Daftar Pemilih Berkelanjutan Bulan Januari 2022', 'BA Daftar Pemilih Berkelanjutan Bulan Januari 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300143526', '198504112009042008', '730714', 4, '2022-07-01 19:55:33'),
(211, 4, 2, 'BA Daftar Pemilih Berkelanjutan Bulan Desember 2021', 'BA Daftar Pemilih Berkelanjutan Bulan Desember 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300143524', '198504112009042008', '730714', 5, '2022-07-01 19:56:01'),
(217, 1, 5, 'Realisasi PAD Bulan Desember Tahun 2021', 'Realisasi PAD Bulan Desember Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300138471', '198504112009042008', '730714', 1, '2022-07-07 04:11:20'),
(218, 1, 5, 'Realisasi PAD Bulan Nopember Tahun 2021', 'Realisasi PAD Bulan Nopember Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300132423', '198504112009042008', '730714', 2, '2022-07-07 04:12:16'),
(219, 1, 2, 'Data Terpilah Tahun 2020', 'Data Terpilah Tahun 2020', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300127329', '198504112009042008', '730714', 2, '2022-07-07 04:13:00'),
(220, 1, 5, 'Realisasi PAD Bulan Oktober Tahun 2021', 'Realisasi PAD Bulan Oktober Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300127249', '198504112009042008', '730714', 1, '2022-07-07 04:13:29'),
(221, 4, 2, 'BA Daftar Pemilih Berkelanjutan Bulan November 2021', 'BA Daftar Pemilih Berkelanjutan Bulan November 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300132485', '198504112009042008', '730714', 5, '2022-07-07 04:14:10'),
(222, 4, 2, 'BA Daftar Pemilih Berkelanjutan Bulan Oktober 2021', 'BA Daftar Pemilih Berkelanjutan Bulan Oktober 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300126179', '198504112009042008', '730714', 4, '2022-07-07 04:14:34'),
(223, 4, 2, 'BA Daftar Pemilih Berkelanjutan Periode Bulan September 2021', 'BA Daftar Pemilih Berkelanjutan Periode Bulan September 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300120365', '198504112009042008', '730714', 4, '2022-07-07 04:15:47'),
(224, 2, 1, 'Tata Cara Permohonan Informasi dan Tata cara pengajuan keberatan', 'Tata Cara Permohonan Informasi dan Tata cara pengajuan keberatan', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300118915', '198504112009042008', '730714', 5, '2022-07-07 04:16:22'),
(229, 1, 3, 'PERJANJIAN KINERJA (PK) CAMAT SINJAI TIMUR TAHUN 2022', 'PERJANJIAN KINERJA (PK) CAMAT SINJAI TIMUR TAHUN 2022', 'PK_kepala_OPD4.pdf', '', '198307082010011022', '730734', 75, '2022-07-07 07:03:39'),
(231, 1, 3, 'PERJANJIAN KINERJA (PK) ESELON III,IV,DAN PELAKSANA KANTOR CAMAT SINJAI TIMUR TAHUN 2022', 'PERJANJIAN KINERJA (PK) ESELON III,IV,DAN PELAKSANA KANTOR CAMAT SINJAI TIMUR TAHUN 2022', 'PK_eselon_III,_IV,_dan_pelaksana1.pdf', '', '198307082010011022', '730734', 79, '2022-07-07 07:24:15'),
(232, 1, 1, 'PETA PROSES BISNIS TAHUN 2022 KECAMATAN SINJAI TIMUR', 'PETA PROSES BISNIS TAHUN 2022 KECAMATAN SINJAI TIMUR ', 'PROBIS_2022_.pdf', '', '198307082010011022', '730734', 192, '2022-07-07 07:33:35'),
(233, 1, 3, 'RA PK KEPALA OPD TAHUN 2022 KECAMATAN SINJAI TIMUR', 'RA PK KEPALA OPD TAHUN 2022 KECAMATAN SINJAI TIMUR', 'RA_PK_Kepala_OPD_Tahun_2022.pdf', '', '198307082010011022', '730734', 99, '2022-07-07 07:40:27'),
(234, 1, 2, 'RKT PERUBAHAN KANTOR KEC,SINJAI TIMUR TAHUN 2021', 'RKT PERUBAHAN KANTOR KEC.SINJAI TIMUR TAHUN 2021', 'PERUBAHAN_RKT_2021.pdf', '', '198307082010011022', '730734', 159, '2022-07-07 08:11:02');
INSERT INTO `dok_data` (`dok_id`, `kategori_id`, `jenis_id`, `dok_nama`, `dok_deskripsi`, `dok_file`, `dok_url`, `nip`, `unit_id`, `dok_count`, `dok_created`) VALUES
(235, 1, 3, 'SK PERUBAHAN INDIKATOR KERJA UTAMA(IKU)KANTOR KEC.SINJAI TIMUR TAHUN 2018-2023', 'SK PERUBAHAN IKU KANTOR KEC.SINJAI TIMUR THN.2018-2023', 'SK_PERUBAHAN_IKU_opd.pdf', '', '198307082010011022', '730734', 170, '2022-07-07 08:16:02'),
(236, 1, 0, 'RENSTRA PERUBAHAN TAHUN 2018 - 2023', 'RENSTRA PERUBAHAN TAHUN 2018 - 2023', 'Renstra_Perubahan_Tahun_2018-2023.pdf', '', '198307082010011022', '730734', 103, '2022-07-07 08:21:52'),
(237, 1, 2, 'DPA 2021 KEC.SINJAI TIMUR', 'DPA 2021 KANTOR KECAMATAN SINJAI TIMUR', 'DPA_20211.pdf', '', '198307082010011022', '730734', 80, '2022-07-07 08:28:45'),
(238, 1, 2, 'RKA 2021 KEC.SINJAI TIMUR', 'RKA TAHUN 2021 KECAMATAN SINJAI TIMUR', 'RKA_20213.pdf', '', '198307082010011022', '730734', 76, '2022-07-07 08:30:01'),
(239, 1, 1, 'SK Tim Penegakan Disiplin 2021', 'SK Tim Penegakan Disiplin 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300176121', '198504112009042008', '730714', 1, '2022-07-08 06:23:11'),
(240, 1, 1, 'SK BUPATI PETA PROSES BISNIS TAHUN 2022', 'SK BUPATI PETA PROSES BISNIS TAHUN 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300178484', '198504112009042008', '730714', 1, '2022-07-19 02:49:30'),
(241, 1, 1, 'PENETAPAN PETA LINTAS FUNGSI BAPENDA TAHUN 2022-2023', 'PENETAPAN PETA LINTAS FUNGSI BAPENDA TAHUN 2022-2023', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300178479', '198504112009042008', '730714', 1, '2022-07-19 02:50:20'),
(242, 1, 4, 'REALISASI PROGRAM, KEGIATAN DAN ANGGARAN PEMERINTAH TPB/SDGs TAHUN 2021', 'REALISASI PROGRAM, KEGIATAN DAN ANGGARAN PEMERINTAH TPB/SDGs TAHUN 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300178477', '198504112009042008', '730714', 1, '2022-07-19 02:51:32'),
(243, 1, 3, 'EVALUASI HASIL RKPD TW II', '', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300178475', '198504112009042008', '730714', 1, '2022-07-19 02:52:24'),
(244, 1, 1, 'SK Tim Penegakan Disiplin 2021', 'SK Tim Penegakan Disiplin 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300176121', '198504112009042008', '730714', 1, '2022-07-19 02:53:27'),
(245, 1, 10, 'KEPUTUSAN BUPATI SINJAI NOMOR 889 TAHUN 2021 ', 'Keputusan Bupati Sinjai Nomor 889 Tahun 2021 tentang Pelimpahan Wewenang Pejabat Pengguna Anggaran / Pengguna Barang, Bendara Pengeluaran, Bendahara Pengeluaran Pembantu, Bendahara Penerimaan, Pengurus Barang Pengguna dan Pembantu Pengurus Barang Pengguna Kepada Satuan Kerja Perangkat Daerah Kabupaten Sinjai Tahun Anggaran 2022', 'KEPUTUSAN_BUPATI_SINJAI_NOMOR_889_TAHUN_2021_TENTANG_PELIMPAHAN_WEWENANG_PEJABAT_PENGGUNA_ANGGARAN.pdf', '', '197507292006042022', '730724', 74, '2022-07-21 08:09:13'),
(246, 1, 2, 'Proses Bisnis Tahun 2022', 'Proses Bisnis Dinas Pekerjaan Umum dan Penataan Ruang Tahun 2022', 'probis_2022fix.pdf', '', '197507292006042022', '730724', 65, '2022-07-25 11:32:49'),
(247, 1, 1, 'SOP Diskopnaker Tahun 2022', 'SOP Disnaker', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300179990', '198504112009042008', '730714', 0, '2022-07-26 04:34:43'),
(248, 1, 1, 'Lakip KPU Tahun 2022', 'Lakip KPU Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/500158211', '198504112009042008', '730714', 0, '2022-07-26 04:35:55'),
(249, 1, 1, 'LAKIP KABUPATEN SINJAI', 'LAKIP KABUPATEN SINJAI', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300075461', '198504112009042008', '730714', 0, '2022-07-26 04:36:52'),
(250, 1, 4, 'Laporan Keuangan dan Laporan Realisasi Anggaran, Neracakompratif, Laporan Operasional, Laporan Perubahan Ekuitas 31 Desember 2019-2018', 'Laporan Keuangan dan Laporan Realisasi Anggaran, Neracakompratif, Laporan Operasional, Laporan Perubahan Ekuitas 31 Desember 2019-2018', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300158864', '198504112009042008', '730714', 0, '2022-07-26 04:38:30'),
(251, 1, 4, 'Dokumen Pelaksanaan Anggaran Refocusing Tahun 2021', 'Dokumen Pelaksanaan Anggaran Refocusing Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300141736', '198504112009042008', '730714', 0, '2022-07-26 04:39:37'),
(253, 2, 3, 'RKT BKPSDMA 2022', 'Renjana Kerja Tahunan BKPSDMA 2022', 'RKT_BKPSDMA_2022.pdf', '', '199408132019031008', '730707', 126, '2022-07-26 06:44:10'),
(254, 2, 3, '5 Rencana Aksi & Capaian RA Tahun 2021 BKPSDMA', '5 Rencana Aksi & Capaian RA Tahun 2021 Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Aparaur', '5_Rencana_Aksi_Capaian_RA_Tahun_20211.pdf', '', '199408132019031008', '730707', 113, '2022-07-26 06:46:09'),
(255, 2, 3, '8 Cascading BKPSDMA 2021', '8 Cascading Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Aparatur 2021', '8_Cascading_BKPSDMA_2021.pdf', '', '199408132019031008', '730707', 85, '2022-07-26 06:51:06'),
(256, 4, 4, 'LAPORAN REALISASI ANGGARAN 2021', '', 'LRA_SEMESTER_I_TA_2021.pdf', '', '197109211992031006', '730712', 110, '2022-07-26 07:31:47'),
(257, 1, 3, 'DOKUMEN PERUBAHAN RENJA 2021', '', 'DOKUMEN_PERUBAHAN_RENJA_2021_compressed1.pdf', '', '197109211992031006', '730712', 104, '2022-07-26 07:35:57'),
(258, 1, 4, 'RINGKASAN DPA TAHUN 2022', '', 'RINGKASAN_DPA_TAHUN_2022_(1).pdf', '', '197109211992031006', '730712', 67, '2022-07-26 08:01:23'),
(259, 1, 4, 'Laporan Keuangan BKPSDMA Kabupaten Sinjai Tahun 2021', 'Laporan Keuangan BKPSDMA Kabupaten Sinjai Tahun 2021', 'LAPORAN_KEUANGAN_PER_31_DES_2021.pdf', '', '198308122009042005', '730707', 66, '2022-07-26 08:25:09'),
(262, 4, 6, 'TATA CARA PENANGANAN PENGADUAN', '', '5Tata_Cara_Penanganan_Pengaduan_2020.pdf', '', '197109211992031006', '730712', 81, '2022-07-27 01:20:19'),
(263, 1, 5, 'LAPORAN REALISASI ANGGARAN 2021', '', 'LRA_SEMESTER_I_TA_2021_(2).pdf', '', '197109211992031006', '730712', 72, '2022-07-27 01:22:41'),
(265, 5, 10, 'PERBUP 16 TH 2021 TENTANG PEMBERIAN INSENTIF DAN KEMUDAHAN PENANAMAN MODAL', '', 'Perbup_16_tentang_Pemberian_Insentif_2021_(1).pdf', '', '197109211992031006', '730712', 77, '2022-07-27 01:27:41'),
(266, 5, 10, 'SK PENGELOLA WEBSITE TAHUN 2022', '', 'SK_PENGELOLA_WEB_TAHUN_2022_(2).pdf', '', '197109211992031006', '730712', 131, '2022-07-27 01:29:41'),
(267, 5, 10, 'SK MAKLUMAT PELAYANAN TAHUN 2022', '', 'SK_MAKLUMAT_PELAYANAN_TAHUN_2022_(1).pdf', '', '197109211992031006', '730712', 145, '2022-07-27 01:33:19'),
(268, 2, 6, 'ALUR PENANGANAN PENGADUAN', '', '1_Alur_Penanganan_Pengaduan_2020.pdf', '', '197109211992031006', '730712', 89, '2022-07-27 02:17:12'),
(269, 5, 10, 'PERDA NO 11 TH 2021 TENTANG PERIZINAN BERUSAHA DAN NON BERUSAHA', '', 'PERDA_NO_11_TH_2021_TTG_PERIZINAN_BERUSAHA_(1)_compressed.pdf', '', '197109211992031006', '730712', 103, '2022-07-27 02:37:58'),
(270, 2, 3, 'PERJANJIAN KINERJA TAHUN 2021', '', 'PERJANJIAN_KINERJA_2021_compressed.pdf', '', '197109211992031006', '730712', 112, '2022-07-27 03:00:19'),
(271, 1, 2, 'RENCANA STRATEGIS PD', '', '111_DOKUMEN_PERUBAHAN_RENSTRA_2018-2023_upload_compressed.pdf', '', '197109211992031006', '730712', 88, '2022-07-28 02:33:28'),
(272, 1, 9, 'Produk Hasil Kelitbangan ', 'Produk Hasil Kelitbangan kurun waktu 2017 s/d 2021', '', 'https://balitbangda.sinjaikab.go.id/hasil-kajian/', '197602082011011003', '730747', 8, '2022-07-28 03:17:34'),
(273, 1, 3, 'Renja Dinas Sosial Tahun 2022', 'Renja Dinas Sosial Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300182139', '198504112009042008', '730714', 0, '2022-07-29 07:35:28'),
(274, 1, 4, 'LKj/LAKIP DINSOS 2021', 'LKj/LAKIP DINSOS 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300182138', '198504112009042008', '730714', 0, '2022-07-29 07:42:45'),
(275, 1, 0, 'Data terpilah tahun 2021', 'Data terpilah tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300183398', '198504112009042008', '730714', 0, '2022-08-01 02:30:28'),
(276, 1, 4, 'DPA RSUD SINJAI TAHUN 2022', 'DPA RSUD SINJAI TAHUN 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300183558', '198504112009042008', '730714', 0, '2022-08-03 02:14:12'),
(277, 1, 3, 'LKJ RSUD SINJAI TAHUN 2021', 'LKJ RSUD SINJAI TAHUN 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300183557', '198504112009042008', '730714', 0, '2022-08-03 02:15:13'),
(278, 1, 1, 'PROFIL RUMAH SAKIT UMUM DAERAH KABUPATEN SINJAI TAHUN 2021', 'PROFIL RUMAH SAKIT UMUM DAERAH KABUPATEN SINJAI TAHUN 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300183530', '198504112009042008', '730714', 0, '2022-08-03 02:16:02'),
(279, 1, 10, 'Data Pencapaian Peserta KB', 'Data Pencapaian Peserta KB', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/500182353', '198504112009042008', '730714', 0, '2022-08-03 02:19:31'),
(280, 1, 3, 'LKj/LAKIP DINSOS 2021', 'LKj/LAKIP DINSOS 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300182138', '198504112009042008', '730714', 0, '2022-08-03 02:20:10'),
(281, 1, 5, 'Sop Pelayanan DPMPTSP Tahun 2021', '', '1_SOP_PELAYANAN_PERIZINAN_BERUSAHA_DAN_NON_PERIZINAN_compressed.pdf', '', '197109211992031006', '730712', 116, '2022-08-03 02:57:09'),
(282, 1, 5, 'Standar Pelayanan Tahun 2021', '', 'STANDAR_PELAYANAN_compressed.pdf', '', '197109211992031006', '730712', 71, '2022-08-03 03:00:10'),
(284, 1, 1, 'Perbup Satu Data Tahun 2021', 'Perbup Satu Data Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300184659', '198504112009042008', '730714', 0, '2022-08-04 03:44:10'),
(285, 1, 9, 'IKM BKPSDMA Kab. Sinjai', 'Indeks Kepuasan Masyarakat Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Aparatur Kabupaten Sinjai', 'IKM_BKPSDMA_2021.pdf', '', '198308122009042005', '730707', 70, '2022-08-04 08:53:28'),
(286, 1, 2, 'LKj Dinas Pendidikan 2021', 'Laporan Kinerja (LKj) Dinas Pendidikan Kabupaten Sinjai Tahun 2021 merupakan capaian akuntabilitas kinerja pada tahun Ketiga dalam masa RENSTRA   Tahun   2018-2023.   LKj   Tahun   2021   disusun   berdasarkan Rencana Kerja (RENJA) Tahun 2021 yang dijabarkan dari Rencana Strategis (RENSTRA Tahun 2018.-2023).', 'LKJ_2021_(1).pdf', '', '196412311994121020', '730723', 73, '2022-08-05 02:58:24'),
(287, 1, 2, 'RKT', 'Rencana Kinerja Tahunan OPD merupakan proses penjabaran\r\nlebih lanjut dari sasaran dan program yang telah ditetapkan dalam \r\nRencana Stratejik (Renstra) OPD yang mencakup periode tahunan.\r\nRencana Kinerja Tahunan OPD menggambarkan kegiatan tahunan\r\nyang akan dilaksanakan oleh instansi pemerintah (OPD) dan indikator\r\nkinerja beserta target-targetnya berdasarkan program, kebijakan, dan\r\nsasaran yang telah ditetapkan dalam rencana stratejik. Target kinerja\r\ntahunan di dalam rencana kinerja ditetapkan untuk seluruh indikator\r\nkinerja yang ada pada tingkat sasaran dan kegiatan. Target kinerja\r\ntersebut merupakan komitmen bagi instansi untuk mencapainya dalam\r\nsatu periode tahunan.  \r\n ', 'RKT_2021.pdf', '', '196412311994121020', '730723', 182, '2022-08-05 03:03:54'),
(288, 1, 2, 'RENSTRA PERUBAHAN DINAS PENDIDIKAN 2018-2023', 'Rencana Strategis (Renstra) Urusan Pendidikan Tahun 2018-2023 yang ditangani \r\noleh Dinas Pendidikan Kabupaten Sinjai pada Tahun 2018, merupakan perencanaan jangka\r\nmenengah yang dijadikan acuan pelaksanaan program kerja pembangunan Bidang\r\nPendidikan. Renstra ini merupakan dokumen perencanaan yang tidak terlepas dari\r\ndokumen perencanaan pada tingkat Kabupaten berupa RPJMD maupun pada tingkat\r\nprovinsi dan tingkat pusat. \r\n', 'RENSTRA_PERUBAHAN_2018-2023.pdf', '', '196412311994121020', '730723', 74, '2022-08-05 03:11:46'),
(289, 1, 4, 'Laporan Kemajuan Fisik dan Keuangan Dinas Pendidikan Tahun 2021', 'Laporan Kemajuan Fisik dan Keuangan Dinas Pendidikan Tahun 2021', 'Laporan_Kemajuan_Fisik_Desember_2021.pdf', '', '196412311994121020', '730723', 64, '2022-08-05 03:25:25'),
(290, 1, 4, 'LHKPN SETDA KAB.SINJAI TAHUN 2021', 'LHKPN SETDA KAB.SINJAI TAHUN 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300185165', '198504112009042008', '730714', 0, '2022-08-08 02:45:30'),
(291, 1, 4, 'LHKPN WAKIL BUPATI KAB.SINJAI TAHUN 2021', 'LHKPN WAKIL BUPATI KAB.SINJAI TAHUN 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300185170', '198504112009042008', '730714', 0, '2022-08-08 02:47:28'),
(292, 1, 4, 'LHKPN BUPATI KAB.SINJAI TAHUN 2021', 'LHKPN BUPATI KAB.SINJAI TAHUN 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300185174', '198504112009042008', '730714', 0, '2022-08-08 02:48:21'),
(293, 5, 6, 'Standar Operasional Prosedur', 'Pengelolaan Pengaduan Melalui Media Online', 'SOP_Pengelolaan_Pengaduan_Melalui_Media_Online.pdf', '', '197909292007012009', '730731', 98, '2022-08-09 04:09:13'),
(294, 1, 1, 'Standar Biaya Perolehan Informasi Publik Tahun 2021', 'Standar Biaya Perolehan Informasi Publik Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300185593', '198504112009042008', '730714', 0, '2022-08-09 06:13:06'),
(295, 1, 1, 'Alur Lapor SP4N', 'Alur Lapor SP4N', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300185813', '198504112009042008', '730714', 0, '2022-08-10 06:36:32'),
(296, 1, 5, 'Rekapan Aduan Tahun 2021', 'Rekapan Aduan Tahun 2021', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300185815', '198504112009042008', '730714', 0, '2022-08-10 06:37:25'),
(300, 1, 4, 'Renstra Perubahan Dinas Perpustakaan dan Kearsipan Tahun 2018 2023', 'Renstra Perubahan Dinas Perpustakaan dan Kearsipan Tahun 2018 2023', 'Renstra_Perubahan_Dinas_Perpustakaan_dan_Kearsipan_Kab_Sinjai_Tahun_2018_2023.pdf', '', '198105102010011010', '730730', 261, '2022-08-12 01:38:37'),
(301, 1, 4, 'DPA Dinas Perpustakaan dan Kearsipan Tahun 2022', 'DPA Dinas Perpustakaan dan Kearsipan Tahun 2022', 'DPA_Dinas_Perpustakaan_dan_Kearsipan_Tahun_2022.pdf', '', '198105102010011010', '730730', 78, '2022-08-12 01:41:38'),
(302, 1, 2, 'Renja Dinas Perpustakaan dan Kearsipan Kab. Sinjai Tahun 2022', 'Renja Dinas Perpustakaan dan Kearsipan Kab. Sinjai Tahun 2022', 'Renja_Dinas_Perpustakaan_dan_Kearsipan_Kab__Sinjai_Tahun_2022.pdf', '', '198105102010011010', '730730', 86, '2022-08-12 01:47:13'),
(303, 4, 3, 'Laporan Kinerja (LKJ) Dinas Perpustakaan dan Kearsipan Kab. Sinjai Tahun 2021', 'Laporan Kinerja (LKJ) Dinas Perpustakaan dan Kearsipan Kab. Sinjai Tahun 2021', 'Laporan_Kinerja_(LKJ)_Dispusip_Tahun_2021.pdf', '', '198105102010011010', '730730', 205, '2022-08-12 01:56:02'),
(304, 2, 3, 'Rencana Kinerja Tahunan (RKT) Dinas Perpustakaan dan Kearsipan Tahun 2022', 'Rencana Kinerja Tahunan (RKT) Dinas Perpustakaan dan Kearsipan Tahun 2022', 'Rencana_Kinerja_Tahunan_(RKT)_Dinas_Perpustakaan_dan_Kearsipan_Tahun_2022.pdf', '', '198105102010011010', '730730', 100, '2022-08-12 02:09:04'),
(305, 5, 10, 'PERDA NOMOR 26 TAHUN 2019 TENTANG PENYELENGGARAAN PERPUSTAKAAN', 'PERDA NOMOR 26 TAHUN 2019 TENTANG PENYELENGGARAAN PERPUSTAKAAN', 'PERDA_NOMOR_26_TAHUN_2019_TENTANG_PENYELENGGARAAN_PERPUSTAKAAN.pdf', '', '198105102010011010', '730730', 165, '2022-08-12 02:23:16'),
(306, 5, 10, 'PERDA NOMOR 9 TAHUN 2018 TENTANG PENYELENGGARAAN KEARSIPAN', 'PERDA NOMOR 9 TAHUN 2018 TENTANG PENYELENGGARAAN KEARSIPAN', 'PERATURAN_DAERAH_NOMOR_9_TAHUN_2018_TENTANG_PENYELENGGARAAN_KEARSIPAN.pdf', '', '198105102010011010', '730730', 173, '2022-08-12 02:26:17'),
(307, 5, 10, 'PERBUP NOMOR 67 TAHUN 2021 TENTANG KEDUDUKAN, SUSUNAN ORGANISASI, TUGAS DAN FUNGSI SERTA TATA KERJA DINAS PERPUSTAKAAN DAN KEARSIPAN', 'PERBUP NOMOR 67 TAHUN 2021 TENTANG KEDUDUKAN, SUSUNAN ORGANISASI, TUGAS DAN FUNGSI SERTA TATA KERJA DINAS PERPUSTAKAAN DAN KEARSIPAN', 'PERBUP_NOMOR_67_TAHUN_2021_TENTANG_KEDUDUKAN,_SUSUNAN_ORGANISASI,_TUGAS_DAN_FUNGSI_SERTA_TATA_KERJA_DINAS_PERPUSTAKAAN_DAN_KEARSIPAN.pdf', '', '198105102010011010', '730730', 118, '2022-08-12 02:33:37'),
(308, 1, 2, 'Cascading Dinas Perpustakaan dan Kearsipan Tahun 2022', 'Cascading Dinas Perpustakaan dan Kearsipan Tahun 2022', 'Cascading_Dinas_Perpustakaan_dan_Kearsipan_Tahun_2022.pdf', '', '198105102010011010', '730730', 62, '2022-08-12 02:50:49'),
(309, 1, 3, 'Perubahan Indikator Kinerja Utama (IKU) Tahun 2018-2023 Dispusip', 'Perubahan Indikator Kinerja Utama (IKU) Tahun 2018-2023 Dispusip', 'Perubahan_Indikator_Kinerja_Utama_(IKU)_Tahun_2018-2023_Dispusip.pdf', '', '198105102010011010', '730730', 65, '2022-08-12 03:05:03'),
(310, 1, 9, 'Uji Konsekuensi Informasi Publik Tahun 2022', 'Uji Konsekuensi Informasi Publik Tahun 2022', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300185834', '198504112009042008', '730714', 0, '2022-08-12 04:33:49'),
(311, 1, 5, 'Buku register Tahun 2022', 'Buku register Tahun 2022', 'BUKU_REGISTER_2022.pdf', '', '198504112009042008', '730714', 92, '2022-08-12 04:53:28'),
(312, 1, 5, 'Indeks Kepuasan Masyarakat Tahun 2021', 'Indeks Kepuasan Masyarakat Tahun 2021', 'IKM_Tahun_2021.pdf', '', '198504112009042008', '730714', 180, '2022-08-12 06:19:55'),
(314, 1, 4, 'Penjabaran APBD Tahun 2022', 'Penjabaran APBD Tahun 2022', 'Sistem_Informasi_Pemerintahan_Daerah_-_Lampiran_1_APBD1.pdf', '', '198504112009042008', '730714', 81, '2022-08-12 07:11:06'),
(315, 1, 5, 'PENJABARAN APBD YANG DIKLASIFIKASI MENURUT KELOMPOK, JENIS, OBJEK, RINCIAN OBJEK, SUB RINCIAN OBJEK PENDAPATAN, BELANJA, DAN PEMBIAYAAN', 'PENJABARAN APBD YANG DIKLASIFIKASI MENURUT KELOMPOK, JENIS, OBJEK,\r\nRINCIAN OBJEK, SUB RINCIAN OBJEK PENDAPATAN, BELANJA, DAN PEMBIAYAAN', 'Sistem_Informasi_Pemerintahan_Daerah_-_Lampiran_1_APBD_pagenumber_(3).pdf', '', '198504112009042008', '730714', 64, '2022-08-12 07:14:57'),
(316, 1, 7, 'Pengadaan Barang dan Jasa Diskominfo Tahun 2021', 'Pengadaan Barang dan Jasa Diskominfo Tahun 2021', 'Pengadaan.pdf', '', '198504112009042008', '730714', 72, '2022-08-12 07:21:35'),
(318, 1, 7, 'KONTRAK SWAKELOLA PEMBAGUNAN DRAINASE LINGK.BATU LAPPA KEL.SAMATARING KEC.SINJAI TIMUR TAHUN ANGGARAN 2021', 'KONTRAK SWAKELOLA PEMBAGUNAN DRAINASE LINGK.BATU LAPPA KEL.SAMATARING KEC.SINJAI TIMUR TAHUN ANGGARAN 2021.', 'Kontrak_Pembangunan_Drainase_I_Tahun_2021_Kel_Samataring_Kc_Sinjai_Timur1.pdf', '', '198307082010011022', '730734', 100, '2022-08-16 05:18:39'),
(319, 1, 7, 'KONTRAK SWAKELOLA PEMBAGUNAN DRAINASE JL.NDI AKBAR(SAMPING SD 84 LINGK.MANGARABOMBANG KEL.SAMATARING KEC.SINJAI TIMUR TAHUN ANGGARAN 2021', 'KONTRAK SWAKELOLA PEMBAGUNAN DRAINASE JL.NDI AKBAR(SAMPING SD 84 LINGK.MANGARABOMBANG KEL.SAMATARING KEC.SINJAI TIMUR TAHUN ANGGARAN 2021', 'Kontrak_Pembangunan_Drainase_II_Tahun_2021_Kel_Samataring_Kec_Sinjai_Timur.pdf', '', '198307082010011022', '730734', 315, '2022-08-16 05:20:51'),
(320, 1, 1, 'PENETAPAN PERUBAHAN INDIKATOR KINERJA UTAMA DINAS KESEHATAN. TAHUN 2018-2023', 'PENETAPAN PERUBAHAN INDIKATOR\r\nKINERJA UTAMA DINAS KESEHATAN.\r\nTAHUN 2018-2023', 'IKU_Perubahan_Dinkes_tahun_2018-2023New.pdf', '', '197704292006042023', '730722', 106, '2022-08-18 01:41:42'),
(321, 1, 1, 'LAPORAN KINERJA DINAS KESEHATAN TAHUN 2021', 'LAPORAN KINERJA DINAS KESEHATAN TAHUN 2021', 'LKj_2O21_SAMPUL_BARU.pdf', '', '197704292006042023', '730722', 263, '2022-08-18 01:45:31'),
(322, 1, 2, ' RENCANA KERJA ORGANISASI PERANGKAT DAERAH  DINAS KESEHATAN KABUPATEN SINJAI TAHUN 2022', ' RENCANA KERJA\r\nORGANISASI PERANGKAT DAERAH \r\nDINAS KESEHATAN\r\nKABUPATEN SINJAI TAHUN 2022', 'RENJA_Dinkes_2022_GABUNG.pdf', '', '197704292006042023', '730722', 314, '2022-08-18 01:56:17'),
(323, 1, 3, 'RENCANA STRATEGIS PERANGKAT DAERAH KABUPATEN SINJAI DINAS KESEHATAN TAHUN 2018-2023', 'RENCANA STRATEGIS PERANGKAT DAERAH KABUPATEN SINJAI DINAS KESEHATAN TAHUN 2018-2023', 'RENSTRA_DINKES_ok.pdf', '', '197704292006042023', '730722', 403, '2022-08-18 01:59:16'),
(324, 1, 3, 'RENCANA KINERJA TAHUNAN DINAS KESEHATAN ', 'RENCANA KINERJA TAHUNAN DINAS KESEHATAN ', 'RKT_Dinkes_2022_OK.pdf', '', '197704292006042023', '730722', 98, '2022-08-18 02:01:09'),
(326, 3, 5, 'Hak Kekayaan Intelektual', 'Hak Kekayaan Intelektual', 'HKI1.pdf', '', '199910022022031005', '730714', 77, '2022-08-18 07:05:00'),
(327, 4, 7, 'Surat Perjanjian (Kontrak) ', 'Kontrak Pengadaan Furnitur dan Kelengkapan Balai Tahun 2021', 'Kontrak_Furnitur.pdf', '', '198411012010012007', '730709', 96, '2022-08-18 07:37:00'),
(328, 1, 7, 'Pengadaan C Panel', 'Pengadaan C Panel', 'Pengadaan_Cpanel.pdf', '', '199910022022031005', '730714', 134, '2022-08-18 07:43:13'),
(329, 1, 6, 'Sengketa Informasi', 'Sengketa Informasi', 'Sengketa_Informasi.pdf', '', '199910022022031005', '730714', 160, '2022-08-18 07:53:55'),
(330, 4, 2, 'Data kasus kekerasan terhadap perempuan dan anak', 'Data kekerasan terhadap perempuan dan anak tahun 2021', 'Data_Kekerasan_Terhadap_Perempuan_dan_Anak_tahun_2021.pdf', '', '198411012010012007', '730709', 124, '2022-08-18 07:57:17'),
(331, 4, 7, 'MOU Icon Plus', 'MOU Icon Plus', 'MOU_Icon_Plus.pdf', '', '199910022022031005', '730714', 71, '2022-08-18 08:52:49'),
(332, 4, 2, 'Mou DP3AP2KB dengan Dinas Pendidikan  ', 'Kemitraan tetang pencegahan dan penanganan kasus kekerasan Setra Pencegahan Perkawianan Anak di Lingkup Sekolah di Kabupaten Sinjai', 'MOU_1_Kemitraan_dalam_Pencegahan_dan_Penanganan_Kasus_Kekerasan.pdf', '', '198411012010012007', '730709', 143, '2022-08-18 09:36:50'),
(333, 1, 2, 'Dokumen PPID', 'Dokumen Persuratan PPID 2022', 'Dokumen_PPID1.pdf', '', '197708262010011003', '730714', 115, '2022-08-19 07:31:25'),
(335, 1, 5, 'Ringkasan Laporan Informasi Publik Penyebaran Informasi Kegiatan DPRD ', 'Ringkasan Laporan Informasi Publik Merupakan Ringkasan Media yang digunakan Sekretariat DPRD Sinjai dalam menyebarkan Informasi Kegiatan Pimpinan dan Anggota DPRD/', 'RINGKASAN_LAPORAN_AKSES_INFORMASI_PUBLIK1.pdf', '', '198203172008011013', '730702', 83, '2022-08-20 14:33:45'),
(337, 5, 10, 'SK Pimpinan DPRD Tahun 2022', 'SK Pimpinan DPRD Nomor 13 Tahun 2021  Tentang Program Pembentukan Peraturan Daerah Kabupaten Sinjai Tahun 2022', 'SK_PIMPINAN_DPRD_TENTANG_PROGRAM_PEMBENTUKAN_PERATURAN_DAERAH_KABUPATEN_SINJAI_TAHUN_20221.pdf', '', '198203172008011013', '730702', 147, '2022-08-20 14:36:38'),
(338, 1, 2, 'Laporan Kegiatan Pimpinan DPRD', 'Laporan Kegiatan Pimpinan DPRD, Januari - Juli 2022', 'AGENDA_KEGIATAN_PIMPINAN_2022.pdf', '', '198203172008011013', '730702', 103, '2022-08-20 14:39:46'),
(339, 4, 5, 'Laporan Aplikasi Penyebaran Informasi ', 'Laporan Aplikasi penyebarluasan Informasi melalui media Website DPRD, dan Media Sosial.', 'DATA_APLIKASI_PENYEBARAN_PUBLIK.pdf', '', '198203172008011013', '730702', 77, '2022-08-20 14:42:10'),
(340, 4, 1, 'Visi Misi ', 'Visi Misi Sekretariar DPRD ', 'VISI_MISI.pdf', '', '198203172008011013', '730702', 85, '2022-08-20 14:44:51'),
(342, 1, 3, 'Perjanjian Kinerja Sekretariat DPRD 2021', 'Perjanjian kinerja adalah lembar/dokumen yang berisikan penugasan dari pimpinan instansi yang lebih tinggi kepada pimpinan instansi yang lebih rendah untuk melaksanakan program/kegiatan yang disertai dengan indikator kinerja.', 'PERJANJIAN_KINERJA_2021.pdf', '', '198203172008011013', '730702', 91, '2022-08-20 14:50:49'),
(343, 1, 3, 'Perjanjian Kinerja Sekretariat DPRD 2020', 'Perjanjian kinerja adalah lembar/dokumen yang berisikan penugasan dari pimpinan instansi yang lebih tinggi kepada pimpinan instansi yang lebih rendah untuk melaksanakan program/kegiatan yang disertai dengan indikator kinerja.', 'PERJANJIAN_KERJA_20201.pdf', '', '198203172008011013', '730702', 90, '2022-08-20 14:52:41'),
(344, 2, 1, 'Data PNS Sekretariat DPRD', 'Data PNS Sekreariat DPRD Tahun 2022', 'DATA_JABATAN_PNS_2022.pdf', '', '198203172008011013', '730702', 107, '2022-08-20 15:05:37'),
(345, 2, 1, 'Data Non PNS Kategori II Sekretariat DPRD  tahun 2022', 'Data Non PNS Kategori II Sekretariat DPRD tahun 2022', 'DATA_NON_PNS_(KATEGORI_II).pdf', '', '198203172008011013', '730702', 116, '2022-08-20 15:09:12'),
(346, 2, 1, 'Data Non ASN Sekretariat DPRD Tahun 2022', 'Data Non ASN Sekretariat DPRD Tahun 2022', 'DATA_NON_PNS_2022.pdf', '', '198203172008011013', '730702', 105, '2022-08-20 15:09:58'),
(347, 1, 3, 'Laporan Kinerja Sekretariat DPRD tahun 2021', 'Laporan Akuntabilitas Kinerja   yang menggambarkan kinerja yang dicapai  atas pelaksanaan program dan kegiatan yang dibiayai APBD. ', 'LAPORAN_KINERJA_ANGGARAN_2021.pdf', '', '198203172008011013', '730702', 216, '2022-08-20 15:13:56'),
(348, 1, 1, 'Penataan Jabatan Staf Fungsional Sekretariat DPRD ', 'Penataan Jabatan Staf Fungsional Sekretariat DPRD ', 'PENATAAN_JABATAN_STAF_PNS_2022.pdf', '', '198203172008011013', '730702', 147, '2022-08-20 15:19:08'),
(349, 1, 1, 'Struktur Organisasi Perangkat Daerah Sekretariat DPRD ', 'Struktur Organisasi Perangkat Daerah Sekretariat DPRD  Tahun 2022', 'STRUKTUR_ORGANISASAI_PERANGKAT_DAERAH_SET__DPRD.pdf', '', '198203172008011013', '730702', 96, '2022-08-21 02:21:00'),
(351, 4, 5, 'S.O.P Penerimaan Aspirasi Sekretariat DPRD', 'S.O.P Penerimaan Aspirasi Sekretariat DPRD', 'SOP_ASPIRASI1.pdf', '', '198203172008011013', '730702', 86, '2022-08-22 01:22:34'),
(352, 5, 10, 'Daftar Ranperda Yang Dibahas Dan Disetujui Bersama DPRD 2020', 'Daftar Ranperda Yang Dibahas Dan Disetujui Bersama DPRD 2020', 'DAFTAR_RANPERDA_YANG_DIBAHAS_DAN_DISETUJUI_BERSAMA_DPRD_2020.pdf', '', '198203172008011013', '730702', 108, '2022-08-22 04:11:29'),
(353, 5, 10, 'Daftar Ranperda Yang Dibahas Dan Disetujui Bersama DPRD 2021', 'Daftar Ranperda Yang Dibahas Dan Disetujui Bersama DPRD 2021', 'DAFTAR_RANPERDA_YANG_DIBAHAS_DAN_DISETUJUI_BERSAMA_DPRD_2021.pdf', '', '198203172008011013', '730702', 93, '2022-08-22 04:12:14'),
(354, 5, 10, 'Format E Lakpin Tahun 2021 Sekretariat DPRD', 'Format E Lakpin Tahun 2021 Sekretariat DPRD', 'FORMAT_ELAPKIN_2021.pdf', '', '198203172008011013', '730702', 93, '2022-08-22 04:21:25'),
(355, 1, 3, 'Format E Lakpin  Sekretariat DPRD 2021', 'Format E Lakpin  Sekretariat DPRD 2021', 'FORMAT_ELAPKIN_20211.pdf', '', '198203172008011013', '730702', 75, '2022-08-22 04:35:03'),
(356, 1, 5, 'formolir permintaan data Tahun 2020', 'formolir permintaan data Tahun 2020', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300077691', '198504112009042008', '730714', 0, '2022-09-13 05:58:49'),
(357, 1, 5, 'formolir permintaan data Tahun 2022', 'formolir permintaan data Tahun 2022', 'formolir_ppid_2022.pdf', '', '198504112009042008', '730714', 86, '2022-09-13 06:02:13'),
(358, 1, 5, 'Formolir keberatan Permintaan Data', 'Formolir keberatan Permintaan Data', 'formolir_keberatan.pdf', '', '198504112009042008', '730714', 80, '2022-09-13 06:03:06'),
(359, 1, 4, 'Lampiran APBD 1 Tahun 2022', 'Lampiran APBD 1 Tahun 2022', 'Sistem_Informasi_Pemerintahan_Daerah_-_Lampiran_1_APBD11.pdf', '', '199910022022031005', '730714', 89, '2022-09-14 13:09:48'),
(360, 1, 4, 'PENJABARAN APBD YANG DIKLASIFIKASI MENURUT KELOMPOK, JENIS, OBJEK, RINCIAN OBJEK, SUB RINCIAN OBJEK PENDAPATAN, BELANJA, DAN PEMBIAYAAN', 'PENJABARAN APBD YANG DIKLASIFIKASI MENURUT KELOMPOK, JENIS, OBJEK, RINCIAN OBJEK, SUB RINCIAN OBJEK PENDAPATAN, BELANJA, DAN PEMBIAYAAN', 'Sistem_Informasi_Pemerintahan_Daerah_-_Lampiran_1_APBD_pagenumber_(3)_(1).pdf', '', '199910022022031005', '730714', 154, '2022-09-14 14:03:13'),
(361, 1, 2, 'RKPD KABUPATEN SINJAI TAHUN 2022', 'RKPD KABUPATEN SINJAI TAHUN 2O22', 'RKPD_KABUPATEN_SINJAI_TAHUN_2022.pdf', '', '19790115009011005', '730714', 88, '2022-09-15 01:41:42'),
(362, 1, 4, 'APBD Tahun 2022', 'APBD Tahun 2022', 'Sistem_Informasi_Pemerintahan_Daerah_-_Lampiran_1_APBD12.pdf', '', '198504112009042008', '730714', 103, '2022-09-15 02:39:35'),
(363, 6, 5, 'Daftar Informasi Publik Tahun 2020', 'Daftar Informasi Publik Tahun 2020', 'DAFTAR_INFORMASI_PUBLIK_TAHUN_2020_(1).pdf', '', '198504112009042008', '730714', 75, '2022-09-21 07:01:21'),
(364, 6, 5, 'Daftar Informasi Publik Tahun 2021', 'Daftar Informasi Publik Tahun 2021', 'DAFTAR_INFORMASI_PUBLIK1.pdf', '', '198504112009042008', '730714', 92, '2022-09-21 07:02:14'),
(365, 1, 4, 'DPA PPID Tahun 2022', 'DPA PPID Tahun 2022', 'DPA_PPID_Tahun_2022.pdf', '', '199910022022031005', '730714', 80, '2022-09-30 00:09:27'),
(366, 5, 1, 'PERDA NOMOR 25 TAHUN 2019', 'PERDA NOMOR 25 TAHUN 2019', 'PERDA_NOMOR_25_TAHUN_2019.pdf', '', '198504112009042008', '730714', 216, '2022-11-01 07:49:52'),
(367, 1, 4, 'Laporan Realisasi Fisik Dan Keuangan TA 2022', 'Laporan Realisasi Fisik dan Keuangan memuat Data Realisasi Tiap Kegiatan  Anggaran 2022', 'Rekap_Lap__Realisasi_Fisik_Keu_TA__22_(1).pdf', '', '198506022010012036', '730720', 68, '2023-02-09 10:47:58'),
(368, 1, 5, 'REALISASI IZIN DAN PAD TAHUN ANGGARAN 2022', 'REALISASI IZIN DAN PAD TAHUN ANGGARAN 2022', 'Realisasi_Izin_dan_Pad_Tahun_Anggaran_2022_.pdf', '', '197109211992031006', '730712', 61, '2023-02-16 09:17:29'),
(369, 1, 3, 'Draft Renstra Perubahan 2018 - 2023', 'Berisi restra perubahan 2018 -2023 pada dinas koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', 'DrAFT_Renstra_Perubahan_2018-2023.pdf', '', '196608061990031014', '730743', 42, '2023-02-28 15:08:16'),
(370, 1, 3, 'Kegiatan Fasilitasi Usaha', 'Berisi Kegiatan Fasilitasi Usaha pada Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', 'kegiatan_fasilitasi_usaha.pdf', '', '196608061990031014', '730743', 36, '2023-02-28 15:10:49'),
(371, 1, 2, 'pembentukan tim pengelolaan ', 'berisi pembentukan Tim pengelolaan pada dinas koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', 'Pembentukan_Tim_Pengelola.pdf', '', '196608061990031014', '730743', 36, '2023-02-28 15:13:36'),
(372, 1, 4, 'penatausahaan keuangan ', 'berisi penatausahaan keuangan pada dinas koperasi ukm dan tenaga kerja ', 'penatausahaan_Keuangan.pdf', '', '196608061990031014', '730743', 41, '2023-02-28 15:15:01'),
(373, 1, 2, 'Pendataan Potensi', 'Berisi laporan pendataan potensi Dinas Koperasi UKM dan Tenaga Kerja ', 'pendataan_potensi.pdf', '', '196608061990031014', '730743', 51, '2023-02-28 15:16:42'),
(374, 1, 2, 'SK pembentukan Penilaian kesehatan 2022', 'Bersisi SK kegiatan pembentukan Penilaian Kesehatan 2022 dinas koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', 'SK_pembentukan_penilaian_kesehatan_2022.pdf', '', '196608061990031014', '730743', 65, '2023-03-01 09:15:03'),
(375, 1, 2, 'SK pembentukan Penilaian kesehatan 2022', 'Bersisi SK kegiatan pembentukan Penilaian Kesehatan 2022 dinas koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', 'SK_pembentukan_penilaian_kesehatan_20221.pdf', '', '196608061990031014', '730743', 70, '2023-03-01 09:15:05'),
(376, 1, 2, 'SK PPK ', 'Berisi SK PPK pada Dinas Koperasi UKM dan Tenaga Kerja ', 'PPK.pdf', '', '196608061990031014', '730743', 39, '2023-03-01 09:16:33'),
(377, 1, 3, 'Rencana Aksi Tahun 2022', 'Sasaran dan IKU', 'RA2022Disdukcapil.pdf', '', '197709272006041003', '730726', 42, '2023-03-01 10:50:56'),
(378, 1, 2, 'Renstra Perubahan Disdukcapil 2018-2023', 'Dokumen Perencanaan 5 Tahun', 'RENSTRAPERUBAHANCAPILLENGKAP_compressed.pdf', '', '197709272006041003', '730726', 96, '2023-03-01 15:52:45'),
(379, 1, 2, 'Rencana Kerja Tahun 2022', 'Berisi informasi Tentang dokumen perencanaan perangkat daerah untuk periode 1 (satu) tahun, yang memuat kebijakan, program, dan kegiatan pembangunan ', 'RENJA2022DisdukcapilFix.pdf', '', '197709272006041003', '730726', 95, '2023-03-02 10:33:11'),
(380, 1, 3, 'Perubahan IKU', 'Berisi informasi tentang ukuran atau indikator kinerja suatu instansi, utamanya dalam mencapai tujuan dan sasaran tertentu', 'SK_PERUBAHAN_IKU_21-1.pdf', '', '197709272006041003', '730726', 56, '2023-03-02 10:35:36'),
(381, 1, 3, 'Laporan Kinerja', 'Berisi informasi tentang  pelaporan kinerja dalam rangka mengimplementasikan sistem akuntabilitas instansi pemerintah ', 'LKJDISDUKCAPIL2021.pdf', '', '197709272006041003', '730726', 84, '2023-03-02 10:37:51'),
(383, 1, 2, 'SK PEMBENTUKAN PANITIA', 'SK PEMBENTUKAN PANITIA PELAKSANA SUB KEGIATAN PENYEDIAAN PETA POTENSI DAN PELUANG USAHA DAERAH PADA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', '', 'https://drive.google.com/file/d/19Qi7Vmr8Ov8KNcR4D7dd0BOBESSrNvd7/view?usp=share_link', '197109211992031006', '730712', 0, '2023-03-28 14:09:27'),
(384, 1, 2, 'PERDA NO 6 TAHUN 2022 ', 'PERDA NO 6 TAHUN 2022 TENTANG PEMBERIAN INSENTIF DANATAU KEMUDAHAN INVESTASI', '', 'https://drive.google.com/file/d/15p-xd7CDEKkDE2XE0-jEcAgq6yuVCbuE/view?usp=share_link', '197109211992031006', '730712', 0, '2023-03-28 14:13:10'),
(385, 1, 2, 'PERBUP NO 21 TAHUN 2022', 'PERBUP NO 21 TAHUN 2022 TENTANG PENDELEGASIAN KEWENANGAN PENYELENGGARAAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN KEPADA KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', '', 'https://drive.google.com/file/d/1WnMDV91PRhH9TaTmEoqt4yfR8C9TbCLM/view?usp=share_link', '197109211992031006', '730712', 0, '2023-03-28 14:14:40'),
(387, 1, 2, 'RENSTRA PERUBAHAN 2018-2023', 'Berisi Dokumen Perencanaan 5 Tahun Dinas Perdagangan, Perindustrian, Energi dan Sumber Daya Mineral', '', 'https://drive.google.com/file/d/1GfsGJTJsCh9QV5hN8seyyBB3xsjTUjbc/view?usp=share_link', '199809252022032011', '730721', 0, '2023-04-28 11:46:34'),
(388, 1, 1, 'DAFTAR INDUK PEGAWAI DPMPTSP', 'DAFTAR INDUK PEGAWAI DPMPTSP', 'DAFTAR_INDUK_PEGAWAI_DPMPTSP.pdf', '', '197109211992031006', '730712', 50, '2023-05-05 10:37:35'),
(389, 1, 1, 'DAFTAR URUT KEPANGKATAN PEGAWAI DPMPTSP', 'DAFTAR URUT KEPANGKATAN PEGAWAI DPMPTSP', 'DAFTAR_URUT_KEPANGKATAN_PEGAWAI_DPMPTSP_.pdf', '', '197109211992031006', '730712', 48, '2023-05-05 10:41:49'),
(390, 1, 3, 'LKJ Tahun 2022', 'berisi laporan Kinerja Tahun 2022', '', 'https://drive.google.com/file/d/1ksUd_bQNseIKk8GNoehe2Z9LFr1ndykz/view?usp=share_link', '197109211992031006', '730712', 0, '2023-05-05 13:53:12'),
(391, 1, 10, 'Perbup Nomor 21 Tahun 2022 Tentang Pendelegasian Kewenangan Penyelenggaraan Perizinan Berus', 'berisi Perbup Nomor 21 Tahun 2022 Tentang Pendelegasian Kewenangan Penyelenggaraan Perizinan Berus', '', 'https://drive.google.com/file/d/1DiyN4z7spwD1dPmynmHI6yetGT2wzpvU/view?usp=share_link', '197109211992031006', '730712', 1, '2023-05-05 14:02:38'),
(392, 1, 10, 'PERBUP TUPOKSI DPMPTSP NOMOR 64 TAHUN 2021', 'Berisi PERBUP TUPOKSI DPMPTSP NOMOR 64 TAHUN 2021', '', 'https://drive.google.com/file/d/1rNR3r6Ve2IbyEXMOHtkVEuHcxoukHDSw/view?usp=share_link', '197109211992031006', '730712', 1, '2023-05-05 14:04:05'),
(393, 1, 10, 'PERDA NO.6 THN 2022 TENTANG PEMBERIAN INSENTIF DAN KEMUDAHAN INVESTASI', 'Berisis PERDA NO.6 THN 2022 TENTANG PEMBERIAN INSENTIF DAN KEMUDAHAN INVESTASI', '', 'https://drive.google.com/file/d/10a2XV64VD_q6kapIZFEHMroMKMgqHIK5/view?usp=share_link', '197109211992031006', '730712', 1, '2023-05-05 14:04:58'),
(394, 1, 3, 'PERJANJIAN KINERJA 2023', 'Bersisi PERJANJIAN KINERJA 2023', '', 'https://drive.google.com/file/d/1nWqQ8AFOku7ILXbt3YOG2higmUZ6H_QN/view?usp=share_link', '197109211992031006', '730712', 1, '2023-05-05 14:06:13'),
(395, 1, 2, 'RENJA TAHUN 2023', 'Berisi RENJA TAHUN 2023', '', 'https://drive.google.com/file/d/1g63ibFG-7KBCnEH5LFnagPrEJB-aWOp3/view?usp=share_link', '197109211992031006', '730712', 3, '2023-05-05 14:07:32'),
(396, 1, 2, 'Renja Dinas Perikanan TA 2023', 'Rencana Kerja Perangkat Daerah (Renja Perangkat Daerah) yang\r\nselanjutnya disingkat dengan Renja PERANGKAT DAERAH merupakan\r\ndokumen perencanaan perangkat daerah untuk periode 1 (satu) tahun.\r\nRencana kerja disusun sebagai penjabaran atas Rencana Kerja\r\nPerangkat Daerah (RKPD).', 'RENJA_DISKAN_Full_TA_23-compressed.pdf', '', '198506022010012036', '730720', 32, '2023-05-08 11:00:25'),
(398, 1, 10, 'PERDA NO 11 TAHUN 2021 TENTANG PENYELENGGARAAN PERIZINAN BERUSAHA DAN PERIZINAN NON BERUSAHA DI DAERAH', 'BERISI PERATURAN DAERAH  NO 11 TAHUN 2021 TENTANG PENYELENGGARAAN PERIZINAN BERUSAHA DAN PERIZINAN NON BERUSAHA DI DAERAH', '', 'https://drive.google.com/file/d/1ph52TROhqabCG-tDxFlvZn-t36_ExpjI/view?usp=share_link', '197109211992031006', '730712', 1, '2023-05-11 08:49:43'),
(399, 1, 7, 'DOKUMEN PENGADAAN BARANG DAN JASA', 'Berisi Dokumen pengadaan barang dan jasa yang telah selesai pada tahun sebelumnya mulai dari RUP,proses pengadaan ,sampai berita acara serah terima baik tender,swakelola maupun PL.', '', 'https://drive.google.com/file/d/1zLic7RgnJiEMxO6PI6W6oKrq7e9R1Iee/view?usp=share_link', '197109211992031006', '730712', 0, '2023-05-11 08:50:44'),
(400, 6, 5, 'Data kepegawaian Dinas Perikanan Sinjai ', 'Memuat Daftar pegawai ASN Dinas Perikanan', 'Data_Kepegawaian_ASN_Dinas_Perikanan_(1).xlsx', '', '198506022010012036', '730720', 46, '2023-05-11 09:18:15'),
(402, 1, 1, 'Data kepegawaian Dinas Perikanan Sinjai ', 'Memuat Data Kepegawaian ASN Dinas Perikanan Kabupaten Sinjai', 'Data_Kepegawaian_ASN_Dinas_Perikanan1.xlsx', '', '198506022010012036', '730720', 36, '2023-05-12 10:31:35'),
(403, 1, 1, 'SK PPID TAHUN 2023', 'SK PPID TAHUN 2023', 'SK_admin_PPID.pdf', '', '198504112009042008', '730714', 86, '2023-05-15 12:19:23'),
(405, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Administrasi Keuangan Perangkat Daerah', 'Administrasi_Keuangan_Perangkat_Daerah.pdf', '', '197705202006042022', '730732', 35, '2023-05-16 09:43:22'),
(406, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Administrasi Kepegawaian Perangkat Daerah', 'Administrasi_Umum_Perangkat_Daerah.pdf', '', '197705202006042022', '730732', 126, '2023-05-16 09:45:45'),
(407, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Administrasi Umum Perangkat Daerah', 'Administrasi_Umum_Perangkat_Daerah1.pdf', '', '197705202006042022', '730732', 32, '2023-05-16 09:46:55'),
(408, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Pemberdayaan Masyarakat dalam Pencegahan Kebakaran', 'Pemberdayaan_Masyarakat_dalam_Pencegahan_Kebakaran.pdf', '', '197705202006042022', '730732', 115, '2023-05-16 09:48:25'),
(409, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintah Daerah', 'Pemeliharaan_Barang_Milik_Daerah_Penunjang_Urusan_Pemerintahan_Daerah.pdf', '', '197705202006042022', '730732', 34, '2023-05-16 09:51:36'),
(410, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Peningkatan Ketentraman dan Ketertiban Umum', 'Penanganan_Gangguan_Ketenteraman_dan_Ketertiban_Umum_dalam_1_(Satu)___.pdf', '', '197705202006042022', '730732', 36, '2023-05-16 09:52:52'),
(411, 1, 3, 'PK Dinas Perikanan 2023', 'PK Dinas Perikanan 2023', '', 'http://diskan.sinjaikab.go.id/web/wp-content/uploads/2023/05/PK-Diskan-2023-gabung_compressed-1.pdf', '198506022010012036', '730720', 4, '2023-05-16 09:53:12'),
(412, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Pencegahan, Pengendalian, Pemadaman, Penyelamatan Kebakaran dan Non Kebakaran', 'Pencegahan,_Pengendalian,_Pemadaman,_Penyelamatan,_dan_Penanganan.pdf', '', '197705202006042022', '730732', 37, '2023-05-16 09:54:20'),
(413, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Penegakan Peraturan Daerah', 'Penegakan_Peraturan_Daerah_Kabupaten_Kota_dan_Peraturan_Bupati_Wali.pdf', '', '197705202006042022', '730732', 38, '2023-05-16 09:55:04'),
(414, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Penyediaan Jasa', 'Penyediaan_Jasa_Penunjang_Urusan_Pemerintahan_Daerah.pdf', '', '197705202006042022', '730732', 34, '2023-05-16 09:56:47'),
(415, 4, 2, 'DPA Satpol PP dan Damkar Kab. Sinjai Tahun 2023', 'Perencanaan,Penganggaran dan Evaluasi Kinerja Perangkat Daerah', 'Perencanaan,_Penganggaran,_dan_Evaluasi_Kinerja_Perangkat_Daerah.pdf', '', '197705202006042022', '730732', 41, '2023-05-16 09:57:58'),
(416, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Rekapitulasi Anggaran Belanja', 'Rekapitulasi_Anggaran_Belanja.pdf', '', '197705202006042022', '730732', 50, '2023-05-16 10:02:48'),
(417, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Administrasi Keuangan Perangkat Daerah', 'RKA_Administrasi_Keuangan_Perangkat_Daerah.pdf', '', '197705202006042022', '730732', 41, '2023-05-16 10:04:06'),
(418, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Administrasi Kepegawaian Perangkat Daerah', 'RKA_Administrasi_Kepegawaian_Perangkat_Daerah.pdf', '', '197705202006042022', '730732', 36, '2023-05-16 10:05:09'),
(419, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Administrasi Umum Perangkat Daerah', 'RKA_Administrasi_umum_Perangkat_Daerah.pdf', '', '197705202006042022', '730732', 67, '2023-05-16 10:06:15'),
(420, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Pemberdayaan Masyarakat dalam Pencegahan Kebakaran', 'RKA_Pemberdayaan_Masyarakat_dalam_Pencegahan_Kebakaran.pdf', '', '197705202006042022', '730732', 34, '2023-05-16 10:07:58'),
(421, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Pembinaan Penyidik PPNS', 'RKA_Pembinaan_Penyidik_PPNS.pdf', '', '197705202006042022', '730732', 44, '2023-05-16 10:08:45'),
(422, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintah Daerah', 'RKA_Pemeliharaan_Barang_Milik_Daerah_Penunjang_Urusan_Pemerintahan.pdf', '', '197705202006042022', '730732', 40, '2023-05-16 10:10:03'),
(423, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Peningkatan Ketentraman dan Ketertiban Umum', 'RKA_Penanganan_Gangguan_Ketentraman_dan_Ketertiban_Umum_dalam_1_Daerah.pdf', '', '197705202006042022', '730732', 44, '2023-05-16 10:20:49'),
(424, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Pencegahan, Pengedalian,Pemadaman,Penyelamatan Kebakaran dan Penyelamatan Non Kebakaran', 'RKA_Pencegahan,_Pengendalian,_Pemadamam,_Penyelamatan_dan_Penanganan_Damkar.pdf', '', '197705202006042022', '730732', 46, '2023-05-16 10:24:39'),
(425, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Penegakan Peraturan Daerah', 'RKA_Penegakan_Peraturan_Daerah.pdf', '', '197705202006042022', '730732', 33, '2023-05-16 10:37:05'),
(426, 1, 4, 'Laporan Kemajuan Fisik dan Keuangan Bulan Januari', 'Berisi tentang Laporan Kemajuan Fisik dan Keuangan Bulan Januari Tahun 2023 pada Badan Pendapatan Daerah', 'LAPORAN_KEMAJUAN_FISIK_DAN_KEUANGAN_JANUARI.pdf', '', '197212251992032006', '730715', 61, '2023-05-16 10:46:48'),
(427, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Penyediaan Jasa', 'RKA_Penyediaan_Jasa_Penunjang_Urusan_Pemerintahan_Daerah.pdf', '', '197705202006042022', '730732', 43, '2023-05-16 10:48:45'),
(428, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Pengadaan Barang Milik Daerah', 'RKA_Pengadaan_Barang_Milik_Daerah_Penunjang_Urusan_Pemerintahan_Daerah.pdf', '', '197705202006042022', '730732', 38, '2023-05-16 10:51:19'),
(429, 4, 2, 'RKA Satpol PP dan Pemadam Kebakaran Tahun 2023', 'Perencanaan,Penganggaran dan Evaluasi Kinerja Perangkat Daerah', 'RKA_Perencanaan,_Penganggaran_dan_evaluasi_Kinerja_Perangkat_Daerah.pdf', '', '197705202006042022', '730732', 35, '2023-05-16 10:52:28'),
(430, 1, 4, 'Laporan kemajuan Fisik dan Keuangan Dinas Perikanan Bulan Maret TA. 2023', 'Berisi tentang Laporan Kemajuan Fisik dan Keuangan Bulan Maret Tahun 2023 pada Dinas Perikanan Sinjai', 'Lap__Fisik_Keu_maret_23.pdf', '', '198506022010012036', '730720', 37, '2023-05-16 11:01:16'),
(431, 4, 7, 'Inventaris Satpol PP dan Damkar Tahun 2023', 'Inventaris Satpol PP dan Damkar Januari s/d Maret Tahun 2023', 'Inventaris_Satpol_PP_Damkar_Maret_2023.xlsx', '', '197705202006042022', '730732', 45, '2023-05-16 11:09:42'),
(432, 4, 6, 'Pengaduan Masyarakat Tahun 2023', 'Pengaduan Masyarakat Bulan Januari 2023', 'pengaduan_januari_2023.pdf', '', '197705202006042022', '730732', 48, '2023-05-16 11:17:52'),
(433, 4, 6, 'Pengaduan Masyarakat Tahun 2023', 'Pengaduan Masyarakat Bulan Februari Tahun 2023', 'Pengaduan_Februari_2023.pdf', '', '197705202006042022', '730732', 43, '2023-05-16 11:19:26'),
(434, 4, 6, 'Pengaduan Masyarakat Tahun 2023', 'Pengaduan Masyarakat Bulan Maret Tahun 2023', 'pengaduan_maret_2023.pdf', '', '197705202006042022', '730732', 67, '2023-05-16 11:22:31'),
(436, 2, 6, 'Data Trantibum Tahun 2023', 'Data Pelanggaran Trantibum Triwulan 1 Tahun 2023', 'Data_Trantib_2023.xlsx', '', '197705202006042022', '730732', 45, '2023-05-16 11:45:20'),
(437, 1, 3, 'SK PPID Pembantu Dinas Perikanan TA. 2023', 'SK PPID Pembantu Dinas Perikanan TA. 2023', 'SK_PPID_pembantu_Diskan_23.pdf', '', '198506022010012036', '730720', 39, '2023-05-17 09:01:07'),
(438, 1, 1, 'Struktur Organisasi dan Tata Laksana Dinas Perikanan 2023', 'SOTK (Struktur Organisasi dan Tata Laksana) Dinas Perikanan', 'Struktur_Organisasi_Lengkap.doc', '', '198506022010012036', '730720', 41, '2023-05-17 09:10:03'),
(439, 1, 2, 'Belanja Hibah Barang Kepada Badan dan lembaga yang Bersifat Nirlaba, Sukarela dan Sosial yang dibentuk Berdasarkan Peraturan Perundang-Undangan yang di', 'Belanja Hibah Barang Kepada Badan dan lembaga berupa Penyediaan Prasarana Usaha Perikanan Tangkap TA. 2022', '', 'http://diskan.sinjaikab.go.id/web/wp-content/uploads/2023/05/ilovepdf_merged-1_compressed-1_compressed_compressed-1.pdf', '198506022010012036', '730720', 0, '2023-05-17 09:44:17'),
(440, 1, 10, 'STANDAR PELAYANAN DPMPTSP TA 2022', 'Berisi Standar Pelayanan Publik Pada Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu Tahun 2022', '', 'https://drive.google.com/file/d/1jZukUJp1IJEtlCNDtGIBFx3gnVfc9ObT/view?usp=share_link', '197109211992031006', '730712', 0, '2023-05-17 14:27:50'),
(441, 1, 10, 'SK PPID DPMPTSP TAHUN 2023', 'Berisi SK PPID TAHUN 2023', '', 'https://drive.google.com/file/d/1QRrHpvcK9_yfdu8Va6BjLcLNg3LEQDDB/view?usp=share_link', '197109211992031006', '730712', 0, '2023-05-23 12:49:52'),
(442, 1, 4, 'Laporan Kemajuan Fisik & Keuangan Bulan April Tahun 2023 ', 'Berisi tentang Laporan Kemajuan Fisik dan Keuangan Bulan April Tahun 2023 ', 'Laporan_Perkembangan_Realisasi_Pelaksanaan_Kegiatan.pdf', '', '197109211992031006', '730712', 37, '2023-05-26 08:24:34'),
(443, 1, 3, 'INDEKS KEPUASAN MASYARAKAT DPMPTSP TAHUN 2022', 'Berisi Laporan Indeks Kepuasan Masyarakat Tahun 2022 ', 'INDEKS_kEPUASAN_MASYARAKAT_DPMPTSP_TAHUN_2022.pdf', '', '197109211992031006', '730712', 38, '2023-05-26 08:30:28'),
(444, 1, 10, 'PERBUP NO 23 TAHUN 2023 ', 'BERISI TENTANG KEDUDUKAN,SUSUNAN ORGANISASI,TUGAS DAN FUNGSI SERTA TATA KERJA DPMPTSP', '', 'https://drive.google.com/file/d/1MtjFoQYdoek6f65phRbKVF2IZSt_V26q/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-05-26 08:35:30'),
(445, 1, 5, 'STANDAR OPERASIONAL PROSEDUR', 'Berisi Tentang Penetapan Standar Operasional Prosedur (SOP ) DPMPTSP Tahun 2022', '', 'https://drive.google.com/file/d/1Pg8lPTWwiysaoxr2PmJzp9bnotRJWwrx/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-05-26 08:39:08'),
(446, 1, 6, 'SK PENUNJUKAN PETUGAS PENGELOLA PENGADUAN', 'Berisi SK Tentang Penunjukan Petugas Pengelola Pengaduan Pada Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu Tahun 2022', '', 'https://drive.google.com/file/d/10F6OM5xj-jk9WVMgia3oI0kzaQiEdevN/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-05-26 09:20:01'),
(447, 1, 6, 'SK PEMBENTUKAN TIM PELAKSANA KEGIATAN ', 'Berisi SK Tentang Pembentukan Tim Pelaksana Kegiatan Penyediaan Layanan Konsultasi Dan Pengelolaan Pengaduan Masyarakat Terhadap Pelayanan Terpadu Perizinan Dan Non Perizinan Dinas Penanaman Modal Tahun 2022', '', 'https://drive.google.com/file/d/1o9XliWeO9Q6Ibs-4Vgk9-0kJH7womGOB/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-05-26 09:24:05'),
(448, 1, 6, 'LAPORAN PENGADUAN DAN TINDAK LANJUT TAHUN 2022', 'Berisi Tentang Rekapitulasi Dan Tindak Lanjut Pengaduan Semester I (Periode Januari S.d Juni ) Tahun 2022', '', 'https://drive.google.com/file/d/1pfxJzUm1YWhG5ZKSYJq9nZU6nBaRcVSN/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-05-26 09:26:25'),
(449, 1, 6, 'LAPORAN PENGADUAN DAN TINDAK LANJUT TAHUN 2022', 'BERISI TENTANG REKAPITULASI DAN TINDAK LANJUT PENGADUAN SEMESTER II (PERIODE JULI S.D DESEMBER) TAHUN 2022 ', '', 'https://drive.google.com/file/d/1JpcGOJM1lHjRsGlTfdhEYdBtxL4a2Wn4/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-05-26 09:28:55'),
(451, 1, 4, 'LAPORAN KEMAJUAN FISIK DAN KEUANGAN BULAN MARET', 'Berisi tentang Laporan Kemajuan Fisik dan Keuangan Bulan Maret pada Badan Pendapatan Daerah', 'LAPORAN_KEMAJUAN_FISIK_DAN_KEUANGAN_MARET.pdf', '', '197212251992032006', '730715', 44, '2023-05-30 11:47:38'),
(453, 1, 10, 'SOTK DLHK Sinjai Tahun 2023', 'Peraturan Bupati Nomor 58 Tahun 2021 tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi Serta Tata Kerja Dinas Lingkungan Hidup dan Kehutanan sebagaimana telah diubah dengan Peraturan Bupati Sinjai Nomor 17 Tahun 2023 tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi  Serta Tata Kerja Dinas Lingkungan Hidup Dan Kehutanan, tertanggal 28 Pebruari 2023', 'RANPERBUP_TUPOKSI_DINAS_LINGKUNGAN_HIDUP_Tahun_2023.docx', '', '197909292007012009', '730731', 34, '2023-05-30 12:22:46'),
(454, 5, 10, 'Peraturan Bupati Sinjai Nomor 4 Tahun 2022 ', 'Tarif Retribusi Kebersihan Kabupaten Sinjai', 'Perbup_Nomor_4_Tahun_2022__Penyesuaian_Tarif_Retribusi_Kebersihan_compressed.pdf', '', '197909292007012009', '730731', 32, '2023-05-30 15:40:17'),
(456, 1, 3, 'Realisasi Kinerja (Rencana Aksi ) DLHK Sinjai Tahun 2022', '', 'Capaian_Kinerja_Indikator_Kinerja_Utama_dalam_perubahan_RPJMD_2018-2023.pdf', '', '197909292007012009', '730731', 43, '2023-05-31 13:12:05'),
(457, 1, 3, 'Laporan evaluasi rencana aksi Dinas LHK Kab. Sinjai Triwulan IV Tahun 2022', 'Berisi laporan realisasi kinerja dan anggaran Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai Tahun 2022', 'Evaluasi_rencana_aksi_triwulan_IV_tahun_2022_compressed.pdf', '', '197909292007012009', '730731', 33, '2023-05-31 13:22:52'),
(458, 1, 3, 'Pohon Kinerja DLHK Kab. Sinjai Tahun 2023', '', 'Pohon_kinerja_DLHK_2023.pdf', '', '197909292007012009', '730731', 36, '2023-05-31 13:28:38'),
(459, 1, 1, 'SK PEMBANTU PPID 2023', 'SK PEMBANTU PPID 2023', 'sk_intern_ppid_2023_compressed.pdf', '', '198504112009042008', '730714', 40, '2023-05-31 14:22:12'),
(460, 1, 2, 'RENSTRA PERUBAHAN 2018 - 2023 DISKOMINFO', 'RENSTRA PERUBAHAN 2018 - 2023 DISKOMINFO', '', 'https://drive.google.com/drive/folders/1IbDTtYd6niPWUabkGVxTv8idLj2C2XWf', '198504112009042008', '730714', 0, '2023-05-31 14:24:26'),
(461, 1, 3, 'PERUBAHAN IKU 2018 - 2023 DISKOMINFO', 'PERUBAHAN IKU 2018 - 2023 DISKOMINFO', '', 'https://drive.google.com/drive/folders/1IbDTtYd6niPWUabkGVxTv8idLj2C2XWf', '198504112009042008', '730714', 0, '2023-05-31 14:32:52'),
(462, 1, 2, 'RENCANA KERJA 2022 DISKOMINFO', 'RENCANA KERJA 2022 DISKOMINFO', '', 'https://drive.google.com/drive/folders/1IbDTtYd6niPWUabkGVxTv8idLj2C2XWf', '198504112009042008', '730714', 0, '2023-05-31 14:35:44');
INSERT INTO `dok_data` (`dok_id`, `kategori_id`, `jenis_id`, `dok_nama`, `dok_deskripsi`, `dok_file`, `dok_url`, `nip`, `unit_id`, `dok_count`, `dok_created`) VALUES
(463, 1, 3, 'LRRA DLHK Sinjai Triwulan I 2022', 'Berisi laporan realisasi capaian kinerja dan anggaran Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai, keadaan sampai dengan Triwulan I 2022', 'LR_Rencana_Aksi_DLHK_Sinjai_Triwulan_I_2022.pdf', '', '197909292007012009', '730731', 34, '2023-06-06 11:45:44'),
(464, 1, 3, 'LRRA DLHK Sinjai Triwulan II 2022', 'Berisi laporan realisasi rencana aksi (capaian kinerja dan anggaran) Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai, keadaan sampai dengan Triwulan II 2022', 'LR_Rencana_Aksi_DLHK_Sinjai_Triwulan_II_2022.pdf', '', '197909292007012009', '730731', 49, '2023-06-06 11:49:17'),
(465, 1, 3, 'LRRA DLHK Sinjai Triwulan III 2022', '', 'LR_Rencana_Aksi_DLHK_Sinjai_Triwulan_III_2022.pdf', '', '197909292007012009', '730731', 41, '2023-06-06 11:54:06'),
(466, 1, 1, 'Daftar Urut Kepangkatan DLHK Sinjai Tahun 2022', '', 'DUK_TAHUN_2022.pdf', '', '197909292007012009', '730731', 72, '2023-06-06 11:56:26'),
(467, 1, 3, 'RKA Tahun 2023 ', 'RKA Tahun 2023', 'RKA_2023.pdf', '', '199806272022032010', '730709', 34, '2023-06-06 15:27:14'),
(468, 1, 2, 'RKA 2023 Dinas Perikanan', 'Rencana kerja dan Anggaran Dinas Perikanan 2023', 'ilovepdf_merged_(1).pdf', '', '198506022010012036', '730720', 43, '2023-06-07 09:50:41'),
(469, 1, 2, 'RKT 2023', 'Berisi Rencana Kinerja Tahunan (RKT) Tahun 2023 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/193oeggblUaASkQ16HOU3D8JfNG04f-Az/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:00:54'),
(470, 1, 2, 'RKT 2022', 'Berisi Revisi Rencana Kinerja Tahunan 2022 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1bzEy683aMW8DxlRzEJWiHnpL3ma1Qkun/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:04:40'),
(471, 1, 2, 'Renja 2023', 'Berisi Rencana Kerja Tahun 2023 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', '', 'https://drive.google.com/file/d/1tNtSB0SfcbgpWeTyTwZUfWjzLnO4IL2g/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:07:26'),
(472, 1, 2, 'Perjanjian kinerja 2022', 'Berisi Perjanjian Kinerja Tahun 2022 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', '', 'https://drive.google.com/file/d/1oiZTrsJG4W1vN7ksAPyWEevXTOWGUJHl/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:09:09'),
(473, 1, 2, 'Perjanjian Kinerja 2023', 'Perjanjian Kinerja Tahun 2023 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1zQyW__l9EQjCBwY77Jzf0O39Yx-RQDqG/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:12:51'),
(474, 1, 2, 'LKJ 2022', 'Berisi Laporan Kinerja Tahun 2022 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', '', 'https://drive.google.com/file/d/1CgtGsdskFNrG020yFG8ZERz_w03aOZPL/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:14:32'),
(475, 1, 4, 'Laporan Kemajuan Fisik dan Keuangan 2023', 'Berisi Laporan Kemajuan Fisik dan keuangan Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', '', 'https://drive.google.com/file/d/1h9F4rz33tioPVLXr_e1ZLGjp9uNz5N-e/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:22:03'),
(476, 1, 2, 'RKA 2022', 'BERISI RKA TAHUN 2022 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1b5V1XzLkjYtRKAg9JQDGbbdo6AMMgqyK/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:36:49'),
(477, 1, 2, 'Evaluasi Program 2022', 'Berisi Evaluasi Program Tahun 2022 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/14WnyYVIV9XYGyds8hmUvPA1ITiijzvgi/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:38:15'),
(478, 1, 2, 'DPA Pokok 2022', 'Berisi DPA Pokok Tahun 2022 Dinas Koperasi UKM dan Tenaga Kerja Kbupaten Sinjai', '', 'https://drive.google.com/file/d/146i7x_JB8Fn2BUUYle4E39qNpkAFmfay/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:40:11'),
(479, 1, 2, 'DPA PERUBAHAN 2022', 'Berisi DPA Perubahan tahun 2022 Dinas Koperasi UKM dan Tenga Kerja Kabupaten Sinjai ', '', 'https://drive.google.com/file/d/1E5lFqzY1hWZ92g0FYJiP4EEBXuYbiRTq/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:41:41'),
(480, 1, 4, 'SPJ Fungsional Bulan Mei 2022', 'Berisi SPJ Fungsional Bulan Mei 2022 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1KxCTK7bR_-dR-iFJ2gnhobV-7fCbmdiI/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:48:05'),
(481, 1, 2, 'SKP TAHUN 2022', 'Berisi SKP Tahun 2022 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1eeHmo38xMW0emzQtNfB9k0ZJAb3YXrWV/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:49:32'),
(482, 1, 2, 'Sasaran Kerja Tahun 2023', 'Berisi sasaran Kerja  tahun 2023 Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1dsSYxtg3-3Wt-jK5tD02fI8-AGCrhtQA/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:51:51'),
(483, 1, 2, 'Register SP2D', 'Berisi register SP2D Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1Yo2k-h7lGXO11etr9CSF30A5uIglczlo/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:53:55'),
(484, 1, 2, 'Register Penutupan Kas', 'Berisi Register Penutupan Kas Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1svt362jXM8pT7OnBpOJzQ1rcP-KUUGNa/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:55:26'),
(485, 1, 2, 'Penutupan Buku kas Bulan Mei', 'Berisi Penutupan Buku Kas Bulan Mei Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', '', 'https://drive.google.com/file/d/1U8gJyVyXdvNfCxeeyQexsz-naY4rNdUk/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 10:56:59'),
(486, 1, 5, 'RENJA TAHUN 2023 DINAS P3AP2KB', 'RENJA TAHUN 2023 DINAS P3AP2KB', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300266665', '198411012010012007', '730709', 0, '2023-06-07 11:04:09'),
(487, 1, 2, 'RENSTRA PERUBAHAN 2018 - 2023 DINAS P3AP2KB', 'RENSTRA PERUBAHAN 2018 - 2023 DINAS P3AP2KB', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300266664', '198411012010012007', '730709', 0, '2023-06-07 11:05:10'),
(488, 1, 2, 'LKJ TAHUN 2022 DINAS P3A2PKB ', 'LKJ TAHUN 2022 DINAS P3A2PKB ', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300266662', '198411012010012007', '730709', 0, '2023-06-07 11:06:19'),
(489, 1, 2, 'Penutupan Buku kas Bulan Mei', 'Berisi Penutupan Buku Kas Bulan Mei Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', '', 'https://drive.google.com/file/d/1U8gJyVyXdvNfCxeeyQexsz-naY4rNdUk/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 11:19:42'),
(490, 1, 2, 'Penutupan Buku kas Bulan Mei', 'Berisi Penutupan Buku Kas Bulan Mei Dinas Koperasi UKM dan Tenaga Kerja Kabupaten Sinjai ', '', 'https://drive.google.com/file/d/1U8gJyVyXdvNfCxeeyQexsz-naY4rNdUk/view?usp=sharing', '196608061990031014', '730743', 0, '2023-06-07 11:19:42'),
(492, 2, 3, 'IKLH (IKA, IKU, IKL) Kabupaten Sinjai Tahun 2022', 'Berisi Nilai Indeks Kualitas Lingkungan Hidup Kabupaten Sinjai Tahun 2022, yang mencakup Indeks Kualitas Air (IKA), Indeks Kualitas Udara (IKU), Indeks Kualitas Lahan (IKL) Tahun 2022', 'Outcome_IKK_Indeks_Kualitas_Lingkungan_Hidup_(IKLH).pdf', '', '197909292007012009', '730731', 36, '2023-06-07 15:32:54'),
(493, 4, 3, 'Dokumen Restra, Renja, Perjanjian Kinerja, DPA TAhun 2023', 'Berisi dokumen Perencanaan dan penganggaran Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai, mencakup ; Renstra Tahun 2028-2023,  Renja Tahun 2023, Renja Tahun 2022, DPA Tahun 2023, Perjanjian Kinerja Tahun 2022, Perjanjian Kinerja Tahun 2023', '', 'https://drive.google.com/drive/folders/15UfjLQr8dCxtgSrZJiWA2DAxqJJ0JCo2?usp=sharing', '197909292007012009', '730731', 0, '2023-06-07 15:51:42'),
(494, 1, 4, 'Laporan Keuangan DLHK Sinjai Tahun 2022', '', '', 'https://drive.google.com/drive/folders/1MYDYycrtqtCNESArknTtXfwDwn60979v?usp=drive_link', '197909292007012009', '730731', 0, '2023-06-07 16:02:36'),
(495, 1, 3, 'Rencana Aksi Diskan Ta. 2022', 'Rencana Aksi Diskan Ta. 2022', 'Rencana_Aksi_Ta__2022.pdf', '', '198506022010012036', '730720', 31, '2023-06-08 10:48:41'),
(496, 1, 3, 'Realisasi Rencana Aksi Diskan Ta. 2022', 'Realisasi Rencana Aksi Diskan Ta. 2022', 'Realisasi_Rencana_Aksi_Ta__22.pdf', '', '198506022010012036', '730720', 55, '2023-06-08 10:49:57'),
(497, 1, 2, 'Rencana Aksi Diskan Ta. 2023', 'Rencana Aksi Diskan Ta. 2023', 'Rencana_Aksi_2023.pdf', '', '198506022010012036', '730720', 39, '2023-06-08 10:52:58'),
(498, 1, 4, 'Catatan Atas Laporan Keuangan Diskan Ta. 2022', 'Catatan Atas Laporan Keuangan Diskan Ta. 2022', '', 'http://diskan.sinjaikab.go.id/web/wp-content/uploads/2023/06/LK-Unaudited-2022_compressed-1_compressed-1.pdf', '198506022010012036', '730720', 0, '2023-06-09 10:07:17'),
(499, 1, 3, 'Pohon Kinerja Diskan 2023', 'Pohon Kinerja Diskan 2023', 'POHON_KINERJA_DISKAN_2023.pdf', '', '198506022010012036', '730720', 39, '2023-06-09 14:48:41'),
(500, 1, 3, 'Cascading Diskan 2023', 'cascading Diskan 2023', 'CASCADING_DISKAN_2023.pdf', '', '198506022010012036', '730720', 34, '2023-06-09 14:49:36'),
(501, 1, 2, 'LKJ Diskan 2022', 'LKJ Diskan 2022', 'LKJ_22.pdf', '', '198506022010012036', '730720', 35, '2023-06-09 14:51:08'),
(502, 1, 10, 'SK PPID DLHK Kab. Sinjai Tahun 2023', '', 'SK_PPID_DLHK_Tahun_2023_compressed.pdf', '', '197909292007012009', '730731', 59, '2023-06-12 12:06:51'),
(503, 1, 10, 'SK PPID DP3AP2KB', 'SK PPID DP3AP2KB', 'SK_PPID_DP3AP2KB.pdf', '', '198411012010012007', '730709', 47, '2023-06-12 12:10:32'),
(504, 1, 3, 'Laporan Kinerja (LKj) DLHK Kab. Sinjai Tahun 2022', 'Berisi  Pendahuluan, Perencanaan & Perjanjian Kinerja, Akuntabilitas Kinerja Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai Tahun 2022. \r\n\r\n', '', 'https://drive.google.com/file/d/1KOIg4eit9lXN6JzubRnww1JaW28JDbxP/view?usp=sharing', '197909292007012009', '730731', 0, '2023-06-12 12:20:26'),
(505, 1, 3, 'Perjanjian Kinerja DLHK Kab. Sinjai Tahun 2023', 'Berisi Perjanjian Kinerja seluruh ASN Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai Tahun 2023', '', 'https://drive.google.com/file/d/1plUUo6JF3AmP2I3k2rmyuuR-ZMAKjnE9/view?usp=drive_link', '197909292007012009', '730731', 0, '2023-06-12 12:55:24'),
(506, 1, 3, 'Perjanjian Kinerja DLHK Sinjai Tahun 2022', 'Berisi Perjanjian Kinerja seluruh ASN Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai TAhun 2022', '', 'https://drive.google.com/file/d/1yFm9z1Jb32v52zytMx4gZTvGSa8dmd2-/view?usp=drive_link', '197909292007012009', '730731', 0, '2023-06-12 12:57:56'),
(507, 5, 10, 'Peraturan Bupati Sinjai Nomor 28 Tahun 2018', 'Berisi Kebijakan dan Strategi Kabupaten Sinjai dalam Pengelolaan Sampah dan Sampah Sejenis Sampah Rumah Tangga', '', 'https://drive.google.com/file/d/1JqhHXSmTND0pERXkeea5ys-DfgC6To8r/view?usp=sharing', '197909292007012009', '730731', 0, '2023-06-12 15:09:39'),
(508, 5, 10, 'Perda Nomor 6 Tahun 2015', 'Berisi Kebijakan tentang Perlindungan dan Pengelolaan Lingkungan Hidup', '', 'https://drive.google.com/file/d/1ANm_SqMCvWbyGX-aukRxVhSZ1Wko5Y4P/view?usp=drive_link', '197909292007012009', '730731', 0, '2023-06-12 15:17:32'),
(509, 5, 10, 'Perda Nomor 10 Tahun 2017', 'Berisi kebijakan tentang Pengelolaan Sampah', '', 'https://drive.google.com/file/d/1GZnDyu_buQKnllyD-l_0Z19JmkfOONsL/view?usp=drive_link', '197909292007012009', '730731', 0, '2023-06-12 15:27:27'),
(510, 5, 10, 'Surat Edaran Nomor 440/05.913/Set Tahun 2019', 'Himbauan Penggunaan Sampah Plastik', '', 'https://drive.google.com/file/d/1qlJwFpQy4v35e6ki-0oK1Vxhu6rUrCcT/view?usp=drive_link', '197909292007012009', '730731', 0, '2023-06-12 15:58:12'),
(511, 0, 0, '', '', '', 'https://bit.ly/perbuptupoksiDPKH2023', '198012292009012004', '730717', 0, '2023-06-14 10:45:49'),
(512, 4, 1, 'Perbup Nomor 29 Tahun 2023 Tentang Tupoksi DPKH', 'Peraturan Bupati Sinjai Nomor 29 Tahun 2023 Serta Tata Kerja Dinas Peternakan dan Kesehatan Hewan', '', 'https://bit.ly/perbuptupoksiDPKH2023', '198012292009012004', '730717', 0, '2023-06-14 11:34:23'),
(513, 4, 1, 'Perbup Nomor 29 Tahun 2023 Tentang Tupoksi DPKH', 'Peraturan Bupati Sinjai Nomor 29 Tahun 2023 Serta Tata Kerja Dinas Peternakan dan Kesehatan Hewan', '', 'https://bit.ly/perbuptupoksiDPKH2023', '198012292009012004', '730717', 0, '2023-06-14 11:34:28'),
(515, 1, 2, 'RKA DPKH TA.2023', 'Rencana Kerja Anggaran Dinas Peternakan dan Kesehatan Hewan TA.2023', '', 'https://bit.ly/RKADPKH2023', '198012292009012004', '730717', 0, '2023-06-14 11:40:42'),
(516, 1, 3, 'AKD DPKH 2023', 'Dokumen Analisis Kebutuhan Diklat DPKH Tahun 2023', '', 'https://bit.ly/AKDDPKH2023', '198012292009012004', '730717', 0, '2023-06-15 15:27:13'),
(517, 4, 3, 'Perbup Tupoksi DPKH nomor 29 Tahun 2023', 'Peraturan Bupati Sinjai Nomor 29 Tahun 2023 Tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi Serta Tata Kerja Dinas Peternakan dan Kesehatan Hewan Tahun 2023', '', 'https://bit.ly/perbuptupoksiDPKH2023', '198012292009012004', '730717', 0, '2023-06-15 15:34:10'),
(518, 6, 1, 'PROFIL PEGAWAI DINAS KETAHANAN PANGAN ', 'Profil Pegawai Negeri Sipil Dinas Ketahanan Pangan tahun 2023', '', 'https://drive.google.com/drive/folders/1b9tF3Gr97BQAKeqc7g9KQWjxIY04_4fe', '199305282022031003', '730713', 0, '2023-06-20 15:49:50'),
(519, 1, 2, 'Informasi Berkala 2023', '', '', 'https://drive.google.com/drive/folders/1kHEm1bQh93U0NWBrAUrya7FVNsAOh2ty?usp=sharing', '199508122022032011', '730724', 0, '2023-07-03 21:35:20'),
(520, 4, 3, 'Tersedia Setiap Saat 2023', '', '', 'https://drive.google.com/drive/folders/1VJv4EGY1nTRJ8Dohgp88-JajANi78H7B?usp=sharing', '199508122022032011', '730724', 0, '2023-07-03 21:43:35'),
(521, 1, 3, 'LKj DINAS PMD KAB. SINJAI TAHUN 2022', 'Laporan Kinerja (LKj) Dinas PMD terdiri dari Pendahuluan, Perencanaan dan Perjanjian Kinerja, Akuntabilias Kinerja dan Inovasi dalam skema Reformasi Birokrasi', 'LKj_Dinas_PMD_Kabupaten_Sinjai_2022.pdf', '', '198008032008012016', '730708', 28, '2023-07-11 11:47:00'),
(522, 1, 3, 'Rencana Kerja Dinas PMD Tahun 2023', 'Rencana Kerja Dinas Pemberdayaan Masyarakat dan Desa Kab. Sinjai merupakan Dokumen Perencanaan Perangkat Daerah yang memuat Tujuan, Sasaran, Program, dan Kegiatan Dinas PMD Kab. Sinjai', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300271572', '198008032008012016', '730708', 0, '2023-07-11 12:01:48'),
(523, 2, 4, 'PERUBAHAN RENSTRA DINAS PERHUBUNGAN 2018-2023', 'PERUBAHAN RENSTRA DINAS PERHUBUNGAN 2018-2023', 'PERUBAHAN_RENSTRA_DISHUB_TAHUN_2018-2023_(New).pdf', '', '198204102006041009', '730716', 56, '2023-07-18 09:46:54'),
(524, 4, 4, 'RENJA DISHUB TAHUN 2023', 'RENJA DINAS PERHUBUNGAN TAHUN 2023', 'RENJA_DISHUB_SINJAI_2022.pdf', '', '198204102006041009', '730716', 70, '2023-07-18 09:54:54'),
(526, 1, 5, 'Jumlah Pengunjung Objek Wisata Dikelola Desa/Kel. Se Kab. Sinjai', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/Jumlah-Pengunjung-Objek-Wisata-Dikelola-DesaKel.-Bulan-Juni-2023.pdf', '198104272005022006', '730746', 0, '2023-07-18 12:51:51'),
(527, 1, 5, 'Jumlah Pengunjung Berdasarkan PAD Objek Wisata', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/Realisasi-Pengunjung-Bulan-Juni-2023.pdf', '198104272005022006', '730746', 0, '2023-07-18 12:52:57'),
(528, 1, 5, 'Jumlah PAD Objek Wisata', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/Realisasi-PAD-Bulan-Juni-2023.pdf', '198104272005022006', '730746', 0, '2023-07-18 12:53:32'),
(530, 1, 0, 'SK PPTK Tahun 2023', '', '', 'https://disparbud.sinjaikab.go.id/web/?p=6037', '198104272005022006', '730746', 0, '2023-07-18 12:56:45'),
(531, 1, 5, 'Memorandum of Undestanding (MoU) Disparbud dengan Beritabersatu.com', 'MoU Penyebarluasan Informasi Kegiatan Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Disparbud dengan Beritabersatu.com', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/PKS-Media-Berita-Bersatu-2023-Disparbud.pdf', '198104272005022006', '730746', 0, '2023-07-18 12:59:40'),
(532, 1, 5, 'Memorandum of Undestanding (MoU) Disparbud dengan Detikcom', 'MoU Penyebarluasan Informasi Kegiatan Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Disparbud dengan Detikcom', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/PKS-Media-DetikCom-2023-DISPARBUD.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:00:40'),
(533, 1, 3, 'Perjanjian Kinerja Tahun 2022', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/PERJANJIAN-KINERJA-2022.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:02:42'),
(534, 1, 3, 'Rencana Aksi Perjanjian Kinerja', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/RENCANA-AKSI-2022.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:02:44'),
(535, 1, 3, 'Evaluasi Kinerja Trw I Tahun 2022.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/Evaluasi-Rencana-Aksi-Triwulan-I-Tahun-2022.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:03:30'),
(536, 1, 3, 'Evaluasi Kinerja Trw II Tahun 2022.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/Eveluasi-Rencana-Aksi-Triwulan-II-Tahun-2022.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:03:32'),
(537, 1, 3, 'Evaluasi Kinerja Trw III tahun 2022.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/Eveluasi-Rencana-Aksi-Triwulan-III-Tahun-2022.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:03:57'),
(538, 1, 3, 'Evaluasi Kinerja Trw IV Tahun 2022.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/Eveluasi-Rencana-Aksi-Triwulan-iv-Tahun-2022.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:04:26'),
(539, 1, 3, 'Dokumen Laporan Kinerja Tahun 2022.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/LAPORAN-KINERJA-TAHUN-2022.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:04:57'),
(540, 1, 3, 'Perjanjian Kinerja Tahun 2023.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/PERJANJIAN-KINERJA-2023.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:05:56'),
(542, 1, 3, 'Rencana Aksi Perjanjian Kinerja tahun 2023.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/RENCANA-AKSI-2023.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:06:30'),
(543, 1, 3, 'IKU Perubahan 2018-2023 Tahun 2023.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/IKU-PERUBAHAN-2018-2023.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:06:56'),
(544, 1, 2, 'Rencana Kerja Tahun 2022', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/RKT-TAHUN-2022.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:08:40'),
(545, 1, 2, 'Rencana Kerja Tahun 2023.', '', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/RKT-TAHUN-2023.pdf', '198104272005022006', '730746', 0, '2023-07-18 13:09:10'),
(546, 1, 3, 'Laporan Kinerja Dinas Ketahanan Pangan 2022', 'Laporan Kinerja Dinas Ketahanan Pangan 2022', 'LKj_2022_ttd.pdf', '', '197812172006041011', '730713', 25, '2023-07-20 14:36:28'),
(563, 1, 4, 'LHKPN BUPATI TAHUN 2022', 'LHKPN BUPATI TAHUN 2022', 'LHKPN_BUPATI.pdf', '', '198504112009042008', '730714', 27, '2023-07-28 11:10:41'),
(564, 1, 4, 'LHKPN WAKIL BUPATI TAHUN 2022', 'LHKPN WAKIL BUPATI TAHUN 2022', 'lhkpn_wakil.pdf', '', '198504112009042008', '730714', 27, '2023-07-28 11:11:57'),
(565, 1, 3, 'Laporan Hasil Evaluasi Dinas Perikanan', 'Laporan Hasil Evaluasi Dinas Perikanan', 'LHE_perikanan_compressed_(1).pdf', '', '198506022010012036', '730720', 34, '2023-07-31 09:50:38'),
(566, 1, 5, 'SK Bupati tentang Penetapan Kawasan Adat Karampuang Sebagai Kawasan Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Kawasan Adat Karampuang Sebagai Kawasan Cagar Budaya Peringkat Kabupaten Nomor 683 Tahun 2018', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Kawasan-Adat-Karampuang-Tahun-2018.pdf', '198104272005022006', '730746', 0, '2023-07-31 14:58:24'),
(567, 1, 5, 'SK Bupati tentang Penetapan Makam Tampung Cidue Sebagai Kawasan Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Makam Tampung Cidue Sebagai Kawasan Cagar Budaya Peringkat Kabupaten Nomor 684 Tahun 2018.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Makam-Tampung-Cidue-Tahun-2018.pdf', '198104272005022006', '730746', 0, '2023-07-31 14:59:00'),
(570, 1, 5, 'SK Bupati tentang Penetapan Bangunan Saoraja Ri Linrung Sebagai Sebagai Situs Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Bangunan Saoraja Ri Linrung Sebagai Sebagai Situs Cagar Budaya Peringkat Kabupaten Nomor 879 Tahun 2019.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Bangunan-Saoraja-Ri-Linrung-Tahun-2019.pdf', '198104272005022006', '730746', 0, '2023-07-31 15:08:21'),
(571, 1, 5, 'SK Bupati tentang Penetapan Situs Makam Bonto Salama Sebagai Sebagai Situs Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Situs Makam Bonto Salama Sebagai Sebagai Situs Cagar Budaya Peringkat Kabupaten. 880 Tahun 2019.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Situs-Makam-Bonto-Salam-Tahun-2019.pdf', '198104272005022006', '730746', 0, '2023-07-31 15:09:27'),
(572, 1, 5, 'SK Bupati tentang Penetapan Bangunan Mesjid Tua Aruhu Sebagai Bangunan Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Bangunan Mesjid Tua Aruhu Sebagai Bagunan Cagar Budaya Peringkat Kabupaten Nomor 881 Tahun 2019.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Bangunan-Mesjid-Tua-Aruhu-Tahun-2019.pdf', '198104272005022006', '730746', 0, '2023-07-31 15:11:11'),
(574, 1, 5, 'SK Bupati tentang Penetapan Situs Caropo Sebagai Situs Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Situs Caropo Sebagai Situs Cagar Budaya Peringkat Kabupaten Nomor 681 Tahun 2018.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Situs-Caropo-Tahun-2018.pdf', '198104272005022006', '730746', 0, '2023-07-31 15:20:53'),
(576, 1, 5, 'SK Bupati tentang Penetapan Bangunan Mesjid Nur Balangnipa Sebagai Bangunan Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Bangunan Mesjid Nur Balangnipa Sebagai Bangunan Cagar Budaya Peringkat Kabupaten Nomor 878 Tahun 2019.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Bangunan-Mesjid-Nur-Balangnipa-Tahun-2019.pdf', '198104272005022006', '730746', 0, '2023-07-31 15:24:34'),
(577, 1, 5, 'SK Bupati tentang Penetapan Situs Perjanjian Topekkong Sebagai Situs Cagar Budaya Kabupaten.', 'SK Bupati tentang Penetapan Situs Perjanjian Topekkong Sebagai Situs Cagar Budaya Kabupaten Nomor 682 Tahun 2018.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Situs-Perjanjian-Topekkong-Tahun-2018.pdf', '198104272005022006', '730746', 0, '2023-07-31 15:29:01'),
(580, 1, 5, 'SK Bupati tentang Penetapan Bangunan Rumah Adat Arung Lappa Sebagai Bangunan Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Bangunan Rumah Adat Arung Lappa Sebagai Bangunan Cagar Budaya Peringkat Kabupaten Nomor 66 Tahun 2021.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Bangunan-Rumah-Adat-Arung-Lappa-Tahun-2021.pdf', '198104272005022006', '730746', 0, '2023-08-01 11:10:51'),
(581, 1, 5, 'SK Bupati tentang Penetapan Struktur Makam Al Syaikh Ibrahim Barat Al Haq Khutbah Bulo - Bulo Atau  Tuan Sengngo Sebagai Struktur Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Struktur Makam Al Syaikh Ibrahim Barat Al Haq Khutbah Bulo - Bulo Atau  Tuan Sengngo Sebagai Struktur Cagar Budaya Peringkat Kabupaten Nomor 823 Tahun 2022.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Struktur-Makam-Al-Syaikh-Ibrahim-Tahun-2022.pdf', '198104272005022006', '730746', 0, '2023-08-01 11:28:54'),
(582, 1, 5, 'SK Bupati tentang Penetapan Bangunan Saoraja Bikeru Sebagai Bangunan Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Bangunan Saoraja Bikeru Sebagai Bangunan Cagar Budaya Peringkat Kabupaten Nomor 821 Tahun 2021.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Saoraja-Bikeru-Tahun-2022.pdf', '198104272005022006', '730746', 0, '2023-08-01 11:33:20'),
(584, 1, 5, 'SK Bupati tentang Penetapan Bangunan Saoraja Tondong Sebagai Bangunan Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Bangunan Saoraja Tondong Sebagai Bangunan Cagar Budaya Peringkat Kabupaten Nomor 822 Tahun 2021.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Pemetapan-Saoraja-Tondong-Tahun-2022.pdf', '198104272005022006', '730746', 0, '2023-08-01 11:40:56'),
(593, 1, 5, 'SK Penetapan Tim Pengelolaan Kawasan Destinasi Pariwisata.', 'SK Penetapan Tim Pengelolaan Kawasan Destinasi Pariwisata Tahun 2021 s/d 2023.', '', 'https://disparbud.sinjaikab.go.id/web/?p=6115', '198104272005022006', '730746', 0, '2023-08-01 13:07:32'),
(596, 1, 5, 'Mou antara Direktorat Jenderal Kebudayaan Kemedikbudristek dan Pemerintah Kabupaten Sinjai Tahun 2021.', 'MoU antara Direktorat Jenderal Kebudayaan Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi dan Pemerintah Kabupaten Sinjai tentang Pemanfaatan Bagi Hasil Retribusi Masuk Objek Wisata Taman Purbakala Batu Pake Gojeng dan Benteng Balangnipa Kabupaten Sinjai.Tahun 2021.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2022/06/MOU-KEMENDIKBUDRISTEK.pdf', '198104272005022006', '730746', 0, '2023-08-01 13:22:41'),
(597, 1, 5, 'MoU antara Pemerintah Kabupaten SInjai dan Politeknik Pariwisata Makassar tahun 2021.', 'MoU Antara Pemerintah Kabupaten SInjai dan Politeknik Pariwisata Makassar tentang Pendidikan dan Pelatihan Sumber Daya Manusia, Penelitian, Pengabdian Pada Masyarakat Dalam Pengembangan Pariwisata dan Kepariwisataan Di Kabupaten Sinjai Tahun 2021.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2022/06/MOU-POLTEKPAR.pdf', '198104272005022006', '730746', 0, '2023-08-01 13:23:50'),
(598, 1, 5, 'Mou antara Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Dengan Kejaksaan Negeri Sinjai tahun 2022.', 'Mou antara Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Dengan Kejaksaan Negeri Sinjai tentang Penanganan Masalah Hukum Perdata dan Tata Usaha Negara Tahun 2022.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2022/06/Penanganan-Masalah-Hukum.pdf', '198104272005022006', '730746', 0, '2023-08-01 13:25:11'),
(601, 1, 5, 'SK Pengangkatan Tenaga Sukarela Tahun 2021.', 'SK Kepala Dinas Pariwisata dan Kebudayaan Nomor 01 Tahun 2021 tentang Pengangkatan/Penetapan Tenaga Kerja Non ASN/Sukarela Lingkup Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Tahun 2021.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Tenaga-Sukarela-Tahun-2021.pdf', '198104272005022006', '730746', 0, '2023-08-01 13:48:57'),
(602, 1, 5, 'SK Pengangkatan Tenaga Sukarela Tahun 2018.', 'SK Kepala Dinas Pariwisata dan Kebudayaan Nomor 5 Tahun 2018 tentang Pengangkatan/Penetapan Tenaga Kerja Sukarela Kepala Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Tahun 2018.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2022/09/SK-2018-min.pdf', '198104272005022006', '730746', 0, '2023-08-01 13:49:57'),
(603, 1, 5, 'SK Pengangkatan Tenaga Sukarela Tahun 2019.', 'SK Kepala Dinas Pariwisata dan Kebudayaan Nomor 01 Tahun 2019 tentang Pengangkatan/Penetapan Kembali Tenaga Kerja Sukarela Kepala Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Tahun 2019.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2022/09/SK-2019-min.pdf', '198104272005022006', '730746', 0, '2023-08-01 13:51:09'),
(604, 1, 5, 'SK Pengangkatan Tenaga Sukarela Tahun 2020.', 'SK Kepala Dinas Pariwisata dan Kebudayaan Nomor 09 Tahun 2020 tentang Pengangkatan/Penetapan Kembali Tenaga Kerja Sukarela Kepala Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Tahun 2020.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2022/09/SK-2020-min.pdf', '198104272005022006', '730746', 0, '2023-08-01 13:51:59'),
(605, 1, 5, 'SK Pengangkatan Tenaga Sukarela Tahun 2023.', 'SK Kepala Dinas Pariwisata dan Kebudayaan Nomor 04 Tahun 2023 tentang Pengangkatan/Penetapan Tenaga Kerja Non ASN/Sukarela Lingkup Dinas Pariwisata dan Kebudayaan Kabupaten Sinjai Tahun 2023.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Tenaga-Sukarela-Tahun-2023.pdf', '198104272005022006', '730746', 0, '2023-08-01 13:54:21'),
(606, 1, 5, 'Daftar Penginapan Se Kabupaten Sinjai Tahun 2022.', 'Daftar Penginapan Se Kabupaten Sinjai Tahun 2022.', '', 'https://disparbud.sinjaikab.go.id/web/?p=5312', '198104272005022006', '730746', 0, '2023-08-01 13:55:33'),
(607, 1, 5, 'Daftar Warung/Rumah Makan/Restoran Tahun 2022.', 'Terdapat sebanyak 148 Warung/Rumah Makan/Restoran Tahun 2022.', '', 'https://disparbud.sinjaikab.go.id/web/?p=5309', '198104272005022006', '730746', 0, '2023-08-01 14:00:16'),
(608, 1, 5, 'Naskah Rekomendasi Penetapan Cagar Budaya.', 'Naskah Rekomendasi Penetapan Cagar Budaya Benteng Balangnipa Tahun 2017 dan Batu Pake Gojeng tahun 2017.', '', 'https://disparbud.sinjaikab.go.id/web/?p=5302', '198104272005022006', '730746', 0, '2023-08-01 14:07:27'),
(612, 1, 1, 'Struktur Organisasi', 'Struktur Organisasi Dinas Perrpustakaan dan Kearsipan', 'STRUKTUR_ORGANISASI_DINAS_PERPUSTAKAAN_DAN_KEARSIPAN.pdf', '', '197909142007011009', '730730', 28, '2023-08-02 01:16:42'),
(613, 1, 2, 'DPA T.A 2023', 'Rekap DPA T.A 2023 Dinas Perpustakaan dan Kearsipan', 'Ringkasan.pdf', '', '197909142007011009', '730730', 29, '2023-08-02 01:21:01'),
(614, 1, 2, 'Renja 2023', 'Renja T.A  2023', 'Renja_Dinas_Perpustakaan_dan_Kearsipan_Tahun_2023.pdf', '', '197909142007011009', '730730', 29, '2023-08-02 01:27:08'),
(615, 1, 3, 'Laporan Kinerja Tahun 2022', 'Laporan Kinerja Tahun 2022', 'lkj_2022.pdf', '', '197909142007011009', '730730', 76, '2023-08-02 01:32:02'),
(616, 1, 3, 'cascading', 'Cascading Dinas Perpustakaan dan kearsipan T.A 2023', 'Cascading_DinaS_pERPUSTAKAAN_DAN_KEARSIPAN.pdf', '', '197909142007011009', '730730', 32, '2023-08-02 01:37:40'),
(617, 1, 3, 'lHE SAKIP TAHUN 2022', 'lHE SAKIP TAHUN 2022', 'LHE_SAKIP_DINAS_PERPUSTAKAAN_DAN_KEARSIPAN_TAHUN_2022.pdf', '', '197909142007011009', '730730', 78, '2023-08-02 01:40:06'),
(618, 1, 3, 'Perjanjian Kinerrja T.A 2023', 'Perjanjian Kinerrja T.A 2023', 'Perjanjian_Kinerja_DInas_Perpustakaan_dan_Kearssipan_Tahun_2023.pdf', '', '197909142007011009', '730730', 31, '2023-08-02 01:46:38'),
(619, 1, 3, 'Laporan Tahunan TA. 2022', 'Berisi Laporan Tahunan yang mencakup seluruh Kegiatan dalam 1 Tahun Anggaran ', 'LAPORAN_TAHUNAN_2022.pdf', '', '198506022010012036', '730720', 44, '2023-08-03 08:14:41'),
(620, 1, 5, 'Statistik Dinas Perikanan TA. 2018-2022', 'Berisi Informasi tentang Pertumbuhan Produksi Perikanan Baik Bidang Penangkapan, Budidaya serta Pengolahan. Serta menggambarkan Potensi Perikanan yang ada di kabupaten Sinjai.', '2022_BUKU_STATISTIK_compressed.pdf', '', '198506022010012036', '730720', 512, '2023-08-03 08:22:26'),
(621, 1, 2, 'Perjanjian Kerja Sama (PKS) Tambak Cilellang Ta. 2021-2022', 'Berisi Informasi tentang PKS dan Kesepakatan Bersama antara Pemerintah Kabupaten Sinjai dan Rekanan mengenai Sewa Tambak Cilellang.', 'PKS_cilellang_merged.pdf', '', '198506022010012036', '730720', 36, '2023-08-03 08:58:32'),
(624, 1, 5, 'SK Bupati tentang Penetapan Bangunan Eks Sekolah Rakyat Sebagai Bangunan Cagar Budaya Peringkat Kabupaten.', 'SK Bupati tentang Penetapan Bangunan Eks Sekolah Rakyat Sebagai Bangunan Cagar Budaya Peringkat Kabupaten Nomor 450 Tahun 2021.', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/07/SK-Penetapan-Bangunan-Eks-Sekolah-Rakyat-Nomor-450-Tahun-2021.pdf', '198104272005022006', '730746', 0, '2023-08-07 10:41:55'),
(625, 1, 5, 'Daftar Kekayaan Intelektual Komunal Kab. Sinjai.', 'Daftar Surat Pencatatan Inventarisasi Kekayaan Intelektual Komunal Kementrian Hukum dan Hak Asasi Manusia.', '', 'https://disparbud.sinjaikab.go.id/web/?p=4508', '198104272005022006', '730746', 0, '2023-08-07 11:00:41'),
(626, 1, 5, 'Realisasi Jumlah Pengunjung dan Jumlah PAD Objek Wisata Kabupaten Sinjai Bulan Juli Tahun 2023 ', 'Realisasi Jumlah Pengunjung dan Jumlah PAD Objek Wisata Kabupaten Sinjai Bulan Juli Tahun 2023 ', 'Realisasi_Pengunjung_PAD_Bulan_Juli_2023.pdf', '', '198104272005022006', '730746', 29, '2023-08-07 14:57:02'),
(627, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Juli Tahun 2023', 'Jumlah Pengunjung Berdasarkan Non PAD Objek Wisata Kabupaten Sinjai Bulan Juli Tahun 2023', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Juli_2023.pdf', '', '198104272005022006', '730746', 26, '2023-08-08 11:32:19'),
(628, 1, 7, 'Dokumen Kontrak CV. Bangun Inti Nusantara.', 'Dokumen Kontrak CV. Bangun Inti Nusantara.', '', 'https://disdiksinjaikab-my.sharepoint.com/:b:/g/personal/ayokesinjai_disdik_sinjaikab_go_id/EQGpVLXMk6NDjNeuH-_2P4wBzw0tAPwaOR3eS4y5QyiwmQ?e=eNf7sa', '198104272005022006', '730746', 0, '2023-08-08 13:48:40'),
(629, 1, 0, 'Dokumen Perjanjian CV. Bangun Inti Nusantara.', '', '', 'https://disdiksinjaikab-my.sharepoint.com/:b:/g/personal/ayokesinjai_disdik_sinjaikab_go_id/EdFrqE4h00BIi-B8__RQLHoBajSMHJdYP8Pr-L0YclQ97Q?e=9CFJdg', '198104272005022006', '730746', 0, '2023-08-08 13:55:17'),
(630, 1, 7, 'Dokumen Pembayaran CV. Bangun Inti Nusantara.', '', '', 'https://disdiksinjaikab-my.sharepoint.com/:b:/g/personal/ayokesinjai_disdik_sinjaikab_go_id/EZpHaCpwZlBIgRP73HF2_VgBRTo7OGU8JJqxqym1au49hQ?e=oMH76w', '198104272005022006', '730746', 0, '2023-08-08 13:55:23'),
(631, 1, 0, 'Dokumen Pembayaran Uang Muka CV. Bangun Inti Nusantara.', '', '', 'https://disdiksinjaikab-my.sharepoint.com/:b:/g/personal/ayokesinjai_disdik_sinjaikab_go_id/EZCzIZ9XZyFBhMONPaBhlaEBqFiRYNDiszmhXc6dQ3iGKA?e=5XNyWs', '198104272005022006', '730746', 0, '2023-08-08 13:56:30'),
(632, 1, 7, 'Dokumen Pembayaran Uang Muka CV. Bangun Inti Nusantara.', '', '', 'https://disdiksinjaikab-my.sharepoint.com/:b:/g/personal/ayokesinjai_disdik_sinjaikab_go_id/EZCzIZ9XZyFBhMONPaBhlaEBqFiRYNDiszmhXc6dQ3iGKA?e=5XNyWs', '198104272005022006', '730746', 0, '2023-08-08 13:56:35'),
(633, 1, 7, 'Dokumen Kontrak CV. Bangun Inti Nusantara.', '', '', 'https://disdiksinjaikab-my.sharepoint.com/:b:/g/personal/ayokesinjai_disdik_sinjaikab_go_id/EQLpXm68viNOjF5CqOm2VTsBPisl9pQi11F2PoMa1tTbbA?e=3JTJEB', '198104272005022006', '730746', 0, '2023-08-08 13:57:49'),
(634, 1, 7, 'Dokumen Kontrak Pengawasan CV. Benuanta Indo Plan.', '', '', 'KONTRAK PENGAWASAN CV BENUANTA INDO PLAN.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:12:20'),
(635, 1, 7, 'Dokumen Pengawasan CV. Benuanta Indo Plan.', '', '', 'Dok Kontrak Pengawasan CV BENUANTA INDO PLAN.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:12:36'),
(636, 1, 7, 'Dokumen Pembayaran Uang Muka CV. Benuanta Indo Plan.', '', '', 'Dok. Pembayaran Uang Muka CV BANGUN INTI NUSANTARA.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:13:06'),
(637, 1, 7, 'Dokumen Pembayaran Pengawasan CV. Benuanta Indo Plan', '', '', 'PEMBAYARAN PENGAWASAN CV BENUANTA INDO PLAN.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:13:24'),
(638, 1, 7, 'Dokumen Perjanjian Pengawasan  CV. Benuanta Indo Plan.', '', '', 'PERJANJIAN PENGAWASAN CV BENUANTA INDO PLAN.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:14:07'),
(639, 1, 7, 'Dokumen Kontrak Perencanaan Saktiawan.', '', '', 'KONTRAK PERENCANAAN SAKTIAWAN.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:14:24'),
(640, 1, 7, 'Dokumen Perjanjian Perencanaan Saktiawan.', '', '', 'PERJANJIAN PERENCANAAN SAKTIAWAN.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:15:16'),
(641, 1, 7, 'Dokumen Pembayaran Perencanaan Saktiawan.', '', '', 'PEMBAYARAN PERENCANAAN SAKTIAWAN.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:15:22'),
(642, 1, 7, 'RAB Kajian Teknis Air Limbah.', '', '', 'RAB Kajian Teknis Air Limbah.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:15:43'),
(643, 1, 7, 'RAB Pembuatan Desain.', '', '', 'RAB Pembuatan Desain.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:16:00'),
(644, 1, 7, 'RAB Pembuatan Desain.', '', '', 'REVISI KAK PERTEK IPAL.pdf', '198104272005022006', '730746', 0, '2023-08-08 14:16:14'),
(645, 1, 4, 'LHKPN Eselon II', '', '', 'https://drive.google.com/drive/folders/1XN2WDFGXgYlN9wsZWi45jwAd9VLNwqQ7?usp=sharing', '199910022022031005', '730714', 0, '2023-09-13 11:09:51'),
(646, 1, 4, 'Laporan Realisasi Fisik dan Keuangan DLHK Sinjai bulan Agustus 2023', 'Berisi rekapitulasi realisasi  anggaran dan kemajuan fisik pelaksanaan program, kegiatan dan sub kegiatan Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai, keadaan Tahun 2023 (s.d Agustus 2023)', '', 'https://drive.google.com/drive/folders/1Gn5DoR9NCqG7F0cqJjEfeGYUzCu10sxK?usp=sharing', '197909292007012009', '730731', 0, '2023-09-13 16:05:31'),
(647, 1, 5, 'Jumlah Pengunjung Berdasarkan PAD Bulan Agustus Tahun 2023', 'Jumlah Pengunjung dan PAD Bulan Agustus Tahun 2023', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/09/Realisasi-Pengunjung-PAD-Bulan-Agustus-2023.pdf', '198104272005022006', '730746', 0, '2023-09-18 10:08:58'),
(648, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Agustus Tahun 2023', 'Jumlah Pengunjung Berdasarkan Non PAD Objek Wisata Kabupaten Sinjai Bulan Agustus Tahun 2023', '', 'https://disparbud.sinjaikab.go.id/web/wp-content/uploads/2023/09/Jumlah-Pengunjung-Objek-Wisata-Dikelola-DesaKel.-Bulan-Agustus-2023.pdf', '198104272005022006', '730746', 0, '2023-09-18 10:15:03'),
(649, 1, 2, 'laporan Hasil Reviu tata kelola perizinan', 'Berisi laporan Hasil Reviu tata kelola perizinan', '', 'https://drive.google.com/file/d/16mFhIqmY_f5cIuO_d3QeQsG1fXvk7RW3/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-09-18 10:15:29'),
(650, 1, 2, 'LAPORAN INDEKS KEPUASAN MASYARAKAT [IKM] SEMESTER 1 TAHUN 2023', 'BERISI LAPORAN INDEKS KEPUASAN MASYARAKAT [IKM] SEMESTER 1 TAHUN 2023', '', 'https://drive.google.com/file/d/1yU6xuhL93hkw3LT1WU2GNmfmliKwWAts/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-09-18 10:17:09'),
(651, 1, 6, 'TOTAL PENGADUAN MASYARAKAT ATAS KENDALA PROSES PERIZINAN PERIODE JANUARI SAMPAI AGUSTUS', 'BERISI TOTAL PENGADUAN MASYARAKAT ATAS KENDALA PROSES PERIZINAN PERIODE JANUARI SAMPAI AGUSTUS', '', 'https://drive.google.com/file/d/1tcbGSCEQUOtz_VBSK95i2IyHUvAuFHov/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-09-18 10:19:31'),
(652, 1, 2, 'SK PEMBENTUKAN TIM TEKNIS PELAYANAN PERIZINAN BERUSAHA, PERIZINAN NON BERUSAHA DAN NON PERIZINAN PADA DPMPTSP TAHUN 2023', 'BERISI SK PEMBENTUKAN TIM TEKNIS PELAYANAN PERIZINAN BERUSAHA, PERIZINAN NON BERUSAHA DAN NON PERIZINAN PADA DPMPTSP TAHUN 2023', '', 'https://drive.google.com/file/d/1QgS0ve9Pq0RmLR0Cafo74FCXpSa4nir7/view?usp=drive_link', '197109211992031006', '730712', 0, '2023-09-18 10:30:53'),
(653, 1, 7, 'SPK 2022 Dinas Tanaman Pangan Hortikultura dan Perkebunan ', 'SPK 2022 Dinas Tanaman Pangan Hortikultura dan Perkebunan ', '', 'https://drive.google.com/drive/folders/1pNO1_LpExTLZjMzxch_0g9zA_kGZjrT_?usp=sharing', '199910022022031005', '730714', 0, '2023-09-19 10:09:18'),
(655, 1, 2, 'PERMOHONAN DAN PERSYARATAN IZIN', 'BERISI PERMOHONAN DAN PERSYARATAN IZIN', '', 'https://drive.google.com/drive/folders/1EoTxfku-HiFMgINBqcLY6jW-fnAplkAx?usp=drive_link', '197109211992031006', '730712', 0, '2023-09-19 11:10:46'),
(656, 1, 2, 'WAKTU PENERBITAN IZIN,ALUR TAHAPAN OSS,BIAYA IZIN OSS,BIAYA PBG,PROSEDUR DAN ALUR PELAYANAN PERIZINAN, PROSEDUR DAN ALUR PELAYANAN PENGADUAN', 'BERISI INFORMASI MENGENAI WAKTU PENERBITAN IZIN, ALUR TAHAPAN OSS, BIAYA IZIN OSS, BIAYA PBG, PROSEDUR DAN ALUR PELAYANAN PERIZINAN, PROSEDUR DAN ALUR PELAYANAN PENGADUAN', '', 'https://drive.google.com/drive/folders/1RgNUrNOafQjsFIzKoR0d0qsBDQdzt1rO?usp=drive_link', '197109211992031006', '730712', 0, '2023-09-19 11:32:34'),
(657, 1, 7, 'Dokumen Pengadaan Barang dan Jasa', 'Dokumen Pengadaan Barang dan Jasa Penyusunan rencana teknis dan dokumen lingkungan hidup untuk konstruksi irigasi dan rawa', '', 'https://drive.google.com/drive/folders/11OTlTPpAt3WixHZpeTfIa_mKPlBKEAwl?usp=sharing', '199508122022032011', '730724', 0, '2023-09-21 08:27:41'),
(659, 1, 7, 'Rekontruksi (PAKET 1) Tahun 2022', 'PBJ (Pengadaan Barang dan Jasa)', '', 'https://drive.google.com/file/d/1z_zZxWIgtuhAJGPmV0sFLMKiHB71Dpo2/view?usp=drive_link', '199910022022031005', '730714', 0, '2023-09-21 10:22:15'),
(660, 1, 7, 'Peningkata Jalan DAK (PAKET 2) Tahun 2022', 'PBJ (Pengadaan Barang dan Jasa)', '', 'https://drive.google.com/file/d/1Esxarx92BdQtcQ_LuaNU6X_qbGaEfTMP/view?usp=drive_link', '199910022022031005', '730714', 0, '2023-09-21 10:29:06'),
(661, 1, 7, 'Peningkatan Jalan (PAKET 3) Tahun 2022', 'PBJ (Pengadaan Barang dan Jasa)', '', 'https://drive.google.com/file/d/1laivAqL0vvNR6bweAa6atXqKLDesmIum/view?usp=drive_link', '199910022022031005', '730714', 0, '2023-09-21 10:32:18'),
(662, 1, 7, 'pembangunan Jaringan Irigasi (PAKET 4) Tahun 2022', 'PBJ (Pengadaan Barang dan Jasa)', '', 'https://drive.google.com/file/d/1gP0G7pYybBb5S4eNzcHX8-KxndtQGYUy/view?usp=drive_link', '199910022022031005', '730714', 0, '2023-09-21 10:33:48'),
(663, 1, 7, 'Perluasan SPAM (PAKET 5) Tahun 2022', 'PBJ (Pengadaan Barang dan Jasa)', '', 'https://drive.google.com/file/d/1g7AnLnayx1miSJRlgCTH1uYjCNGxkxro/view?usp=drive_link', '199910022022031005', '730714', 0, '2023-09-21 10:35:37'),
(664, 1, 7, 'Kerangka Acuan Kerja (KAK)', 'KAK Bimtek SMKK 2023', '', 'https://drive.google.com/file/d/1AqWwBNvke8c88kr1Mqv2kxqYHACFVWcm/view?usp=sharing', '199508122022032011', '730724', 0, '2023-09-21 12:21:07'),
(665, 1, 7, 'Rancangan Kontrak', 'Draft Kontrak Paket 1 Pekerjaan Peningkatan Jalan DAK', '', 'https://drive.google.com/file/d/165IIkAtlPuQuM9931khqLuy_Hda9_lYX/view?usp=sharing', '199508122022032011', '730724', 0, '2023-09-22 08:25:38'),
(666, 1, 7, 'Gambar Rancangan Pekerjaan', 'Gambar Rancangan Pekerjaan Jalan Ruas Jatie - Bua', '', 'https://drive.google.com/file/d/1JYsHznttq4CcYyTc16h1W3zBbrOyb6lV/view?usp=sharing', '199508122022032011', '730724', 0, '2023-09-22 09:20:38'),
(668, 1, 4, 'Kebijakan Anggaran Umum (KUA) 2023', 'Badan Keuangan dan Aset Daerah', '', 'https://drive.google.com/drive/folders/1GZqetaAVQqjufqeOziBB5fBTaJ2Xg9l3', '199910022022031005', '730714', 0, '2023-09-22 14:36:14'),
(669, 1, 4, 'Prioritas Pagu Anggaran Sementara (PPAS) 2023', 'Badan Keuangan dan Aset Daerah ', '', 'https://drive.google.com/drive/folders/1lzkDt_441riLYsKr0hvg99p8JaMnKLiD', '199910022022031005', '730714', 0, '2023-09-22 14:42:07'),
(672, 1, 4, 'Laporan Realisasi Anggaran seluruh SKPD Tahun 2022', 'Badan Keuangan dan Aset Daerah', '', 'https://drive.google.com/drive/folders/15NdUgxBVnbrTpvFUgK1kRPHvIwKmCPdR', '199910022022031005', '730714', 0, '2023-09-22 15:10:43'),
(673, 1, 4, 'Perda APBD Beserta Lampiran APBD dan Perubahannya  tahun 2023', 'Badan Keuangan dan Aset Daerah', '', 'https://drive.google.com/drive/folders/1qWpP5EEx_ke1M2-A-YaazthcUygNSVzg', '199910022022031005', '730714', 0, '2023-09-22 15:31:27'),
(674, 6, 5, 'Daftar Informasi Publik Tahun 2023', 'Daftar Informasi Publik Tahun 2023', '', 'https://drive.google.com/drive/folders/183SgPK-SF1kbDfZx5A2Rq-6IHjnegv0V', '199910022022031005', '730714', 0, '2023-09-26 14:05:07'),
(675, 5, 10, 'Peraturan Bupati No.17 Tahun 2011', 'Peraturan Bupati No.17 Tahun 2011', '', 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300022354', '199910022022031005', '730714', 0, '2023-09-26 15:32:22'),
(677, 1, 0, 'Anggaran Kas Pokok Tahun 2023', 'Anggaran Kas Pokok tahun 2023 Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai', '', 'https://drive.google.com/file/d/1KcY1a6ZoFbJYlJkTEQnT5OwcZgvHrEGf/view?usp=drive_link', '197909292007012009', '730731', 0, '2023-09-27 12:32:42'),
(678, 1, 7, 'Rekomendasi RSUD Sinjai (AMDAL) Tahun 2022', 'Rekomendasi RSUD Sinjai (AMDAL) Tahun 2022', '', 'https://drive.google.com/drive/folders/1A48YRxJrrYit4zjJU2ra9f-oidCXu6Pb?hl=id', '198504112009042008', '730714', 0, '2023-09-28 15:51:52'),
(679, 1, 9, 'Daftar Hasil Penelitian Tahun 2021 - 2023', 'Balitbangda', '', 'https://drive.google.com/drive/folders/1kPFC8SHsvTH7_Px7Skqt35LqxuM0lW_B?hl=id', '198504112009042008', '730714', 0, '2023-09-28 16:01:57'),
(680, 1, 7, 'Dokumen PBJ - Tahap Pelaksanaan', 'Berisi dokumen Pengadaan Barang dan Jasa Pada Tahap Pelaksanaan Ex Pekerjaan Rehabilitasi Stadion H. Andi Bintang', '', 'https://drive.google.com/drive/folders/1AVtcO-qLZWUCTVsIDOvzBn_sQqFO3co8?usp=sharing', '199508122022032011', '730724', 0, '2023-09-29 12:49:51'),
(682, 4, 10, 'Hak Kekayaan Intelektual', 'Hak Kekayaan Intelektual', '', 'https://drive.google.com/drive/folders/1LSDEofB69ry1wAwK_pdTEYL2Ujh7jsG5?hl=id', '198504112009042008', '730714', 0, '2023-09-29 17:02:55'),
(683, 6, 5, 'SK DIP tahun 2023', 'SK DIP tahun 2023', '', 'https://drive.google.com/drive/folders/1uprdEI4ZrxPBnNT6OPYlUjoVSTgU863C?hl=id', '198504112009042008', '730714', 0, '2023-09-29 22:07:48'),
(684, 6, 5, 'Daftar Informasi Publik Tahun 2023 di pemuktahiran', 'Daftar Informasi Publik Tahun 2023 di pemuktahiran', 'DAFTAR_INFORMASI_PUBLIK_Pemuktahiran_.pdf', '', '198504112009042008', '730714', 43, '2023-09-29 22:16:03'),
(685, 1, 5, 'Berita Acara Uji Konsekueansi', 'Berita Acara Uji Konsekuensi', 'Berita_Acara_Uji_Konsekueansi.pdf', '', '198504112009042008', '730714', 38, '2023-09-29 22:35:47'),
(686, 1, 4, 'RKA ', 'RKA', 'RKA_2023_IKP.pdf', '', '199910022022031005', '730714', 35, '2023-09-29 23:26:17'),
(687, 1, 2, 'Program dan Kegiatan Dinas Perikanan', 'Memuat Informasi Program dan Kegiatan Dinas Perikanan', 'DPPA-BELANJA_-_3_25_0_00_0_00_21_0000_DINAS_PERIKANAN_-_Penetapan_APBD_Pergeseran_III_-_2023.pdf', '', '198506022010012036', '730720', 42, '2023-10-04 08:21:19'),
(689, 1, 2, 'Anggaran Kas Tahun 2023', 'Memuat Informasi berisi Laporan Anggaran Kas Dinas Perikanan Ta. 2023', 'Anggkas_Diskan-New1.pdf', '', '198506022010012036', '730720', 32, '2023-10-04 08:33:38'),
(690, 1, 4, 'DPPA SKPD', 'Berisi Dokumen Pelaksanaan Perubahan Anggaran Satuan Kerja Perangkat Daerah', '', 'https://drive.google.com/file/d/1w_igzBBsGfh3kaUXL0Bg2vHvplRkZEow/view?usp=sharing', '197109211992031006', '730712', 0, '2023-10-04 15:14:19'),
(692, 1, 2, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan September Tahun 2023', 'Jumlah Pengunjung Berdasarkan Non PAD Objek Wisata Kabupaten Sinjai Bulan September Tahun 2023', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_September_2023.pdf', '', '198104272005022006', '730746', 25, '2023-10-16 09:56:36'),
(693, 1, 5, 'Jumlah Pengunjung Berdasarkan PAD Bulan September Tahun 2023', 'Jumlah Pengunjung dan PAD Bulan September Tahun 2023', 'Realisasi_Pengunjung_PAD_Bulan_September_2023.pdf', '', '198104272005022006', '730746', 30, '2023-10-16 09:58:53'),
(694, 1, 4, 'Ringkasan Penjabaran APBD TA. 2023', 'Ringkasan Penjabaran APBD TA. 2023', '', 'https://www.sinjaikab.go.id/v4/2023/05/19/ringkasan-penjabaran-apbd-ta-2023/', '199910022022031005', '730714', 0, '2023-11-10 10:20:01'),
(696, 2, 2, 'Pengumuman Seleksi Pengadaan Calon Aparatur Sipil Negara (CASN)', 'Pengumuman Seleksi Pengadaan Calon Aparatur Sipil Negara (CASN) ', '', 'https://www.sinjaikab.go.id/v4/2023/09/20/pengumuman-seleksi-pengadaan-calon-aparatur-sipil-negara-lingkup-pemerintah-kabupaten-sinjai-tahun-anggaran-2023/', '199910022022031005', '730714', 0, '2023-11-10 21:18:39'),
(697, 2, 2, 'Pengumuman Penyesuaian Jadwal Tahapan Calon Aparatur Sipil Negara (CASN)', 'Pengumuman Penyesuaian Jadwal Tahapan Calon Aparatur Sipil Negara (CASN)', '', 'https://www.sinjaikab.go.id/v4/2023/10/18/pengumuman-penyesuaian-jadwal-tahapan-pelaksanaan-seleksi-calon-aparatur-sipil-negara-dan-hasil-seleksi-administrasi-pegawai-pemerintah-dengan-perjanjian-kerja-pemerintah-kabupaten-sinjai-tahun-anggar/', '199910022022031005', '730714', 0, '2023-11-10 21:22:56'),
(698, 2, 2, 'Pengumuman Hasil Seleksi Administrasi Pasca Sanggah Calon Aparatur Sipil Negara (CASN)', 'Pengumuman Hasil Seleksi Administrasi Pasca Sanggah Calon Aparatur Sipil Negara (CASN)', '', 'https://www.sinjaikab.go.id/v4/2023/10/28/pengumuman-hasil-seleksi-administrasi-pasca-sanggah-pengadaan-calon-aparatur-sipil-negara-pemerintah-kabupaten-sinjai-tahun-anggaran-2023/', '199910022022031005', '730714', 0, '2023-11-10 21:25:05'),
(699, 2, 2, 'Harga Kebutuhan Pokok ', 'Harga Kebutuhan Pokok (06 November 2023)', 'Harga_Kebutuhan_Pokok.pdf', '', '199910022022031005', '730714', 15, '2023-11-10 21:29:47'),
(700, 2, 10, 'Surat Edaran Penyebarluasan Informasi Website dan Media Sosial ', 'Surat Edaran Penyebarluasan Informasi Website dan Media Sosial ', 'Surat_Edaran_Penyebarluasan_Informasi_Website_dan_Media_Sosial_.pdf', '', '199910022022031005', '730714', 15, '2023-11-10 21:34:53'),
(701, 6, 1, 'Profil PPID ', 'Profil PPID Sinjai', 'PROFIL_PPID_SINJAI.pdf', '', '199910022022031005', '730714', 30, '2023-11-10 21:38:18'),
(702, 2, 10, 'Surat Edaran Command Center ', 'Surat Edaran Command Center ', 'SURAT_EDARAN_CC.pdf', '', '199910022022031005', '730714', 16, '2023-11-10 21:55:03'),
(703, 2, 10, 'Surat Edaran Website', 'Surat Edaran Website', 'Surat_Edaran_Website.pdf', '', '199910022022031005', '730714', 19, '2023-11-10 21:56:45'),
(704, 2, 10, 'Surat Edaran Mendengarkan Radio Suara Bersatu 95.5 FM', 'Surat Edaran Mendengarkan Radio Suara Bersatu 95.5 FM', 'SE_Mendengarkan_Radio_SB_95,5_FM.pdf', '', '199910022022031005', '730714', 20, '2023-11-10 21:58:07'),
(705, 2, 2, 'Penyampaian Harga Kebutuhan Pokok ', 'Harga Kebutuhan Pokok  (8 November 2023)', 'Penyampaian_Harga_Kebutuhan_Pokok_08_November_2023.pdf', '', '199910022022031005', '730714', 16, '2023-11-10 22:00:53');
INSERT INTO `dok_data` (`dok_id`, `kategori_id`, `jenis_id`, `dok_nama`, `dok_deskripsi`, `dok_file`, `dok_url`, `nip`, `unit_id`, `dok_count`, `dok_created`) VALUES
(706, 2, 2, 'Pengumuman Pelaksanaan Ujian Calon Aparatur Sipil Negara (CASN)', 'Pengumuman Pelaksanaan Ujian Calon Aparatur Sipil Negara (CASN) T.A 2023', '', 'https://www.sinjaikab.go.id/v4/2023/11/08/pengumuman-pelaksanaan-ujian-seleksi-kompetensi-peserta-seleksi-penerimaan-calon-aparatur-sipil-negara-pemerintah-kabupaten-sinjai-tahun-anggaran-2023/', '199910022022031005', '730714', 0, '2023-11-10 22:04:00'),
(707, 6, 1, 'Struktur Organisasi PPID', 'Struktur Organisasi PPID', 'Struktur_PPID.pdf', '', '199910022022031005', '730714', 26, '2023-11-10 22:43:25'),
(708, 4, 2, 'SWAKELOLA TAHUN 2022', 'SWAKELOLA TAHUN 2022', '', 'https://drive.google.com/drive/folders/1M3itWntySTieRdxle3SjOz78Q-7GDIhI?hl=id', '199910022022031005', '730714', 0, '2023-11-11 17:22:18'),
(709, 1, 5, 'DIP 2023', 'DIP 2023', 'Dip_2023.pdf', '', '199910022022031005', '730714', 22, '2023-11-11 21:17:57'),
(711, 1, 5, 'Jumlah Pengunjung Berdasarkan PAD Bulan Oktober Tahun 2023', 'Jumlah Pengunjung Berdasarkan PAD Bulan Oktober Tahun 2023', 'Realisasi_Pengunjung_PAD_Bulan_Oktober_20231.pdf', '', '198104272005022006', '730746', 15, '2023-11-30 10:50:46'),
(713, 0, 0, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Oktober Tahun 2023', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Oktober Tahun 2023', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Oktober_20231.pdf', '', '198104272005022006', '730746', 3, '2023-11-30 10:53:53'),
(714, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Oktober Tahun 2023', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Oktober Tahun 2023', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Oktober_20232.pdf', '', '198104272005022006', '730746', 17, '2023-12-07 10:20:48'),
(715, 1, 5, 'Jumlah Pengunjung Berdasarkan PAD Bulan November Tahun 2023', 'Jumlah Pengunjung Berdasarkan PAD Bulan November Tahun 2023', 'Realisasi_Pengunjung_PAD_Bulan_November_2023.pdf', '', '198104272005022006', '730746', 14, '2023-12-07 10:22:40'),
(716, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan November Tahun 2023', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan November Tahun 2023', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_November_2023.pdf', '', '198104272005022006', '730746', 19, '2023-12-07 10:23:37'),
(717, 1, 5, 'Jumlah Pengunjung Berdasarkan PAD Bulan Desember Tahun 2023', 'Jumlah Pengunjung Berdasarkan PAD Bulan Desember Tahun 2023', 'Realisasi_Pengunjung_Bulan_Desember_2023.pdf', '', '198104272005022006', '730746', 9, '2024-01-08 09:25:28'),
(718, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Desember Tahun 2023', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Desember Tahun 2023', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Desember_2023.pdf', '', '198104272005022006', '730746', 14, '2024-01-08 09:26:25'),
(719, 1, 5, 'Jumlah Pengunjung Berdasarkan PAD Bulan Januari Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Januari Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Januari_2024.pdf', '', '198104272005022006', '730746', 9, '2024-05-14 10:32:47'),
(721, 1, 10, 'SK PPID 2024', 'SK PPID 2024', '', 'http://tiny.cc/SKPPID2024', '199702132022032013', '730714', 0, '2024-06-04 17:05:05'),
(722, 1, 10, 'SK SP4N  LAPOR Tahun 2024', 'SK SP4N  LAPOR Tahun 2024', '', 'http://tiny.cc/SKLaporSP4N2024', '199702132022032013', '730714', 0, '2024-06-04 17:06:06'),
(723, 1, 10, 'SK Forkohumas Tahun 2024', 'SK Forkohumas Tahun 2024', '', 'http://tiny.cc/SKForkohumas2024', '199702132022032013', '730714', 0, '2024-06-04 17:06:44'),
(724, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Januari Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Januari Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Januari_2024.pdf', '', '198104272005022006', '730746', 1, '2024-06-10 09:41:51'),
(725, 1, 5, 'Jumlah Pengunjung dan PAD Bulan Februari Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Februari Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Februari_2024.pdf', '', '198104272005022006', '730746', 2, '2024-06-10 09:42:56'),
(726, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Februari Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Februari Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Februari_2024.pdf', '', '198104272005022006', '730746', 1, '2024-06-10 09:43:57'),
(727, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Maret Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Maret Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Maret_2024.pdf', '', '198104272005022006', '730746', 1, '2024-06-10 09:44:56'),
(728, 1, 5, 'Jumlah Pengunjung dan PAD Bulan Maret Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Maret Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Maret_2024.pdf', '', '198104272005022006', '730746', 1, '2024-06-10 09:45:58'),
(729, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan April Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan April Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_April_2024.pdf', '', '198104272005022006', '730746', 1, '2024-06-10 09:46:51'),
(730, 1, 5, 'Jumlah Pengunjung dan PAD Bulan April Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan April Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_April_2024.pdf', '', '198104272005022006', '730746', 1, '2024-06-10 09:47:43'),
(731, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Mei Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Mei Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Mei_2024.pdf', '', '198104272005022006', '730746', 1, '2024-06-10 09:52:23'),
(732, 1, 5, 'Jumlah Pengunjung dan PAD Bulan Mei Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Mei Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Mei_2024.pdf', '', '198104272005022006', '730746', 1, '2024-06-10 09:53:10'),
(733, 1, 3, 'SK TIM TEKNIS PERIZINAN TAHUN 2024', 'Berisi SK Nomor 109 Tahun 2024 Tentang Pembentukan tim teknis pelayanan perizinan berusaha, perizinan non berusaha dan non perizinan pada dinas penanaman modal dan pelayanan terpadu satu pintu', '', 'https://drive.google.com/file/d/1GEF7pXPP50BYlZS91vIs8wZ2Egd6qGN5/view?usp=sharing', '197109211992031006', '730712', 0, '2024-06-11 11:15:17'),
(734, 1, 2, 'SK PPID DPMPTSP TAHUN 2024', 'Berisi SK No 16.a Tahun 2024 Tentang Penunjukan Pejabat Pengelola Informasi Dan Dokumentasi (PPID) Pembantu Lingkup Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu ', '', 'https://drive.google.com/file/d/1R2kaQGRSsCfjgioW0BQKfa0jyZRZOFiK/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-06-11 11:25:26'),
(735, 1, 2, 'SK PENGELOLA WEBSITE 2024', 'Berisi SK No.22 Tahun 2024 Tentang Pembentukan Tim Pengelola Konten Website Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu', '', 'https://drive.google.com/file/d/1b9vrERzlBtxVbFXOT9YdzUY353axW6op/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-06-12 14:19:42'),
(736, 1, 2, 'SK NO 52 THN 2024 TENTANG PEMBENTUKAN TIM PELAKSANA KEGIATAN SURVEI KEPUASAN MASYARAKAT', 'BERISI SK NO 52 THN 2024 TENTANG PEMBENTUKAN TIM PELAKSANA KEGIATAN SURVEI KEPUASAN MASYARAKAT', '', 'https://drive.google.com/file/d/1joAkpse7doCj-6smRFquUVFv1oFWxW7f/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-06-12 14:22:09'),
(737, 1, 2, 'SK NO 13 THN 2024 TENTANG PEMBENTUKAN TIM PELAKSANA KEGIATAN PENYEDIAAN DAN PENGELOLAAN LAYANAN KONSULTASI PERIZINAN SERTA PENGELOLAAN PENGADUAN MASYARAKAT', 'BERISI SK NO 13 TAHUN 2024 TENTANG PEMBENTUKAN TIM PELAKSANA KEGIATAN PENYEDIAAN DAN PENGELOLAAN LAYANAN KONSULTASI PERIZINAN SERTA PENGELOLAAN PENGADUAN MASYARAKAT', '', 'https://drive.google.com/file/d/1hOK3K6qs_iArC_pbBiD-5OaNlP9PvYP0/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-06-14 11:10:03'),
(738, 1, 2, 'LAPORAN PENYELENGGARAAN PTSP TRIWULAN IV TAHUN 2023', 'BERISI TENTANG LAPORAN PENYELENGGARAAN PTSP TRIWULAN IV TAHUN 2023', '', 'https://drive.google.com/file/d/1q-hDk1mnqCVJu4SkzYzoN-jrTYi_xGJT/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-06-14 11:11:58'),
(739, 1, 2, 'LAPORAN KINERJA TAHUN 2023', 'BERISI TENTANG LAPORAN KINERJA TAHUN 2023', '', 'https://drive.google.com/file/d/1pvsEQ8Hz3sHHT6sURVf7F_xKOJCJcUmv/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-06-20 10:36:57'),
(740, 1, 4, 'LAPORAN KEMAJUAN FISIK DAN KEUANGAN MEI 2024', 'BERISI TENTANG LAPORAN KEMAJUAN FISIK DAN KEUANGAN MEI 2024', '', 'https://drive.google.com/file/d/1VSrI6oqatL3HwU8tyRa2OqqtvDf7cLbn/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-06-28 12:29:28'),
(741, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Juni Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Juni Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Juni_2024.pdf', '', '198104272005022006', '730746', 1, '2024-07-03 15:26:34'),
(742, 1, 5, 'Jumlah Pengunjung dan PAD Bulan Juni Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan  Juni Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Juni_2024.pdf', '', '198104272005022006', '730746', 1, '2024-07-03 15:27:33'),
(743, 1, 2, 'Laporan Penyelenggaraan PTSP TW I 2024', 'Berisi Tentang Laporan Penyelenggaraan PTSP TW I 2024', '', 'https://drive.google.com/file/d/1VSrI6oqatL3HwU8tyRa2OqqtvDf7cLbn/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-08 10:43:03'),
(744, 1, 2, 'PERJANJIAN KINERJA TAHUN 2024', 'BERISI TENTANG PERJANJIAN KINERJA TAHUN 2024', '', 'https://drive.google.com/file/d/1rjUG_eKrnmPVODFsZKX1dZ_V7DOMZGHF/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-08 10:44:46'),
(745, 1, 2, 'DUK 2024', 'BERISI TENTANG DAFTAR URUTAN KEPEGAWAIAN TAHUN 2024 ', '', 'https://drive.google.com/file/d/1iErG9tYJ9IuoW649DFG_m47iS0LizHFa/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-08 10:46:17'),
(746, 1, 3, 'RENJA TAHUN 2024', 'BERISI TENTANG RENJA TAHUN 2024', '', 'https://drive.google.com/file/d/1hTPDmj9tRMwocMHglA06jOBgYSJDHjLt/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-08 10:47:38'),
(747, 1, 3, 'REKAPITULASI PENGADUAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN TAHUN 2023', 'BERISI TENTANG REKAPITULASI PENGADUAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN TAHUN 2023 ', '', 'https://drive.google.com/file/d/1UItz3wT8m6vL6RjuO2GqqwYKyRK7A0CY/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-08 10:51:07'),
(748, 1, 3, 'LAPORAN TINDAK LANJUT PENGADUAN PERIZINAN BERUSAHA, PERIZINAN NON BERUSAHA DAN NON PERIZINAN TAHUN 2023', 'BERISI TENTANG LAPORAN TINDAK LANJUT PENGADUAN PERIZINAN BERUSAHA, PERIZINAN NON BERUSAHA DAN NON PERIZINAN TAHUN 2023', '', 'https://drive.google.com/file/d/1IMhyv_eHCJ4fwUuBuPJSAMGo4PA0jfli/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-08 10:51:45'),
(749, 1, 10, 'SK NO.8 TAHUN 2023 TENTANG PENUNJUKAN PETUGAS PENGELOLA PENGADUAN', 'BERISI SK NO.8 TAHUN 2023 TENTANG PENUNJUKAN PETUGAS PENGELOLA PENGADUAN', '', 'https://drive.google.com/file/d/1xjeFGTDc8fbtV6tgItLHnw59ecckTZQb/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-11 09:37:33'),
(750, 1, 10, 'SK NO.9 TAHUN 2023 TENTANG PEMBENTUKAN TIM PELAKSANA KEGIATAN PENYEDIAAN LAYANAN KONSULTASI DAN PENGELOLAAN PENGADUAN MASYARAKAT TERHADAP PELAYANAN TERPADU PERIZINAN DAN NON PERIZINAN', 'BERISI SK NO.9 TAHUN 2023 TENTANG PEMBENTUKAN TIM PELAKSANA KEGIATAN PENYEDIAAN LAYANAN KONSULTASI DAN PENGELOLAAN PENGADUAN MASYARAKAT TERHADAP PELAYANAN TERPADU PERIZINAN DAN NON PERIZINAN', '', 'https://drive.google.com/file/d/1G9Hd-MDLwOvVhpEvP4Kef5po3fel2Kpf/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-11 09:38:34'),
(752, 1, 3, 'REKAPITULASI PENGADUAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN TAHUN 2024', 'BERISI TENTANG REKAPITULASI PENGADUAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN TAHUN 2024', '', 'https://drive.google.com/file/d/1p-QSvn_MTdokiQlOAsRxgx5O_LWNmB8k/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-11 09:41:22'),
(753, 1, 3, 'LAPORAN TINDAK LANJUT PENGADUAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN TAHUN 2024', 'BERISI TENTANG  LAPORAN TINDAK LANJUT PENGADUAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN TAHUN 2024', '', 'https://drive.google.com/file/d/16MApolYnjDCR6DPgTpZePMAXWLbqUD1a/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-11 09:46:01'),
(754, 1, 10, 'SK NO.14 TAHUN 20214 TENTANG PENUNJUKAN PETUGAS PENGELOLA PENGADUAN', 'BERISI SK NO.14 TAHUN 20214 TENTANG PENUNJUKAN PETUGAS PENGELOLA PENGADUAN', '', 'https://drive.google.com/file/d/1HYUz7yV5CGVr-RfQdzxuv3319JdGS4b9/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-11 09:47:06'),
(755, 1, 3, 'LAPORAN  TAHUN 2023', 'BERISI LAPORAN REALISASI IZIN DAN PAD TAHUN 2023', '', 'https://drive.google.com/file/d/1Z5pvIeI8-Q1pEtdmEp4w3FpBYgRDw0Kt/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-11 09:51:11'),
(756, 1, 3, 'LAPORAN REALISASI IZIN DAN PAD BULAN JUNI', 'BERISI TENTANG LAPORAN REALISASI IZIN DAN PAD BULAN JUNI', '', 'https://drive.google.com/file/d/1Mahx841pd9PAlprWi1Fdd50SKYKsCXdm/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-07-11 09:54:19'),
(759, 1, 4, 'Laporan Fisik dan Keuangan', 'Berisi Tentang Laporan Fisik dan Keuangan Bulan Juni 2024', '06_Ketapang_FisKeu_Juni2.pdf', '', '199305282022031003', '730713', 2, '2024-07-25 09:25:02'),
(760, 4, 2, 'Rencana Kerja Tahunan', 'Berisi Tentang Rencana Kerja Tahunan Dinas Ketahanan Pangan', 'RKT-2024_Dinas_Ketapang2.pdf', '', '199305282022031003', '730713', 1, '2024-07-25 10:34:28'),
(761, 4, 2, 'Rencana Kerja ', 'Berisi Tentang RENJA DKP Tahun 2024', 'RENJA_DKP_2024b.pdf', '', '199305282022031003', '730713', 1, '2024-07-25 10:35:41'),
(762, 1, 2, 'renja', 'renja', 'RENJA_2024_FIX_(1).pdf', '', '199806272022032010', '730709', 5, '2024-08-01 14:36:59'),
(763, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400252899', 'ALAT PENGUKUR KOMPOSISI TUBUH “BIOIMPEDANCE ANALYSIS (BIA)” DI RUMAH SAKIT UMUM DAERAH SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:16:57'),
(764, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300264447', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN JANUARI TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:18:46'),
(765, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300264454', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN FEBRUARI TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:22:11'),
(766, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300264458', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN MARET TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:23:55'),
(767, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300264460', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN APRIL TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:26:10'),
(768, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300268718', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN MEI TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:27:04'),
(769, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400272071', 'MAKLUMAT PELAYANAN RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:28:26'),
(770, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400272072', 'STANDAR PELAYANAN INSTALASI LABORATORIUM RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:29:29'),
(771, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400272073', 'STANDAR PEMBERIAN PELAYANAN RADIOLOGI RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:30:13'),
(772, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400272074', 'STANDAR PELAYANAN PEMERIKSAAN USG DI RADIOLOGI RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:31:02'),
(773, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400272076', 'STANDAR PELAYANAN INSTALASI RADIOLOGI RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:32:39'),
(774, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400272077', 'STANDAR PELAYANAN RESEP APOTEK RAWAT JALAN RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:33:42'),
(775, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400272078', 'STANDAR PELAYANAN RESEP OBAT JADI APOTEK RAWAT INAP RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:34:28'),
(776, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300272089', 'STANDAR PELAYANAN PUBLIK (SPP) TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:35:26'),
(777, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300272090', 'SK JENIS PELAYANAN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:36:26'),
(778, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300275037', 'ANALISIS DAMPAK LINGKUNGAN (AMDAL)', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:37:26'),
(779, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300275047', 'PERJANJIAN KERJASAMA', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:38:04'),
(780, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300278447', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN JUNI TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:39:11'),
(781, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300278728', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN JULI TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:40:09'),
(782, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300285414', 'SK PENUNJUKAN PEJABAT PENGELOLA PPID PEMBANTU LINGKUP RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:41:08'),
(783, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300289440', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN AGUSTUS TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:42:31'),
(784, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300292888', 'RENCANA AKSI RUMAH SAKIT UMUM DAERAH SINJAI TAHUN ANGGARAN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:43:43'),
(785, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300293124', 'PELAKSANAAN PERUBAHAAN ANGGARAN RSUD SINJAI TAHUN ANGGARAN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:44:44'),
(786, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300294592', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN SEPTEMBER TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:46:12'),
(787, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300297891', 'SK PENETAPAN DAFTAR INFORMASI YANG DIKECUALIKAN RUMAH SAKIT UMUM DAERAH SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:47:23'),
(788, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300299851', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN OKTOBER TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:48:10'),
(789, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300303604', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN NOVEMBER TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:49:05'),
(790, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300309047', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN DESEMBER TAHUN 2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:49:54'),
(791, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/400311551', 'RSUD SINJAI MEMERIAHKAN HARI JADI SINJAI KE-460 DENGAN MENGGELAR SENAM SEHAT BERSAMA PI', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:52:01'),
(792, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300315926', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN FEBRUARI TAHUN 2024', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:53:47'),
(793, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300316081', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN JANUARI TAHUN 2024', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:55:31'),
(794, 1, 9, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300317408', 'RENCANA TINDAK LANJUT SURVEI INDEKS KEPUASAN MASYARAKAT TERHADAP PELAYANAN PUBLIK RS', '', '', '197707242003122006', '730728', 0, '2024-08-01 16:56:24'),
(795, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300321419', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN MARET TAHUN 2024', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:02:33'),
(796, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300323209', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN APRIL TAHUN 2024', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:04:37'),
(797, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300331693', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN MEI TAHUN 2024', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:08:28'),
(798, 1, 2, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300331760', 'DAFTAR 10 PENYAKIT TERBANYAK DI RSUD SINJAI BULAN JUNI TAHUN 2024', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:09:31'),
(799, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335153', 'KEPUTUSAN KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU KABUPATEN SINJAI TENTANG SURAT IZIN SARANA KESEHATAN', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:10:36'),
(800, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335161', 'KEPUTUSAN BUPATI SINJAI NO 428 TAHUN 2011 TENTANG PENETAPAN RSUD KABUPATEN SINJAI UNTUK MENETAPKAN POLA PENGELOLAAN KEUANGAN BADAN LAYANAN UMUM DAERAH', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:12:51'),
(801, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335164', 'PERATURAN BUPATI SINJAI NO 11 TAHUN 2018 TENTANG PEDOMAN PENATAUSAHAAN KEUANGAN BADAN LAYANAN UMUM DAERAH KABUPATEN SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:14:21'),
(802, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335165', 'PERATURAN BUPATI SINJAI NOMOR 21 TAHUN 2019 TENTANG KEBIJAKAN DAN SISTEM AKUTANSI BADAN LAYANAN UMUM DAERAH RUMAH SAKIT UMUM DAERAH KABUPATEN SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:15:12'),
(803, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335167', 'PERATURAN BUPATI SINJAI NO 51 TAHUN 2018 TENTANG STANDAR PELAYANAN MINIMAL RUMAH SAKIT UMUM DAERAH SINJAI TAHUN 2019-2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:16:27'),
(804, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335168', 'PERATURAN BUPATI SINJAI NO 14 TAHUN 2020 TENTANG ORGANISASI DAN TATA KERJA UNIT PELAKSANA TEKNIS RUMAH SAKIT UMUM DAERAH SINJAI PADA DINAS KESEHATAN', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:17:27'),
(805, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335175', 'KEPUTUSAN BUPATI SINJAI NOMOR 699 TAHUN 2021 TENTANG PENETAPAN RENCANA KERJA PERANGKAT DAERAH KABUPATEN SINJAI TAHUN 2022', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:19:48'),
(806, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335186', 'PERATURAN BUPATI SINJAI NO 18 TAHUN 2021 TENTANG PERUBAHAN ATAS PERATURAN BUPATI SINJAI NO 14 TAHUN 2019 TENTANG RENCANA STRATEGIS PERANGKAT DAERAH KABUPATEN SINJAI TAHUN 2018-2023', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:21:48'),
(807, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335191', 'PERATURAN BUPATI SINJAI NO 10 TAHUN 2017 TENTANG PEMBERIAN TAMBAHAN PENGHASILAN BERDASARKAN KELANGKAAN PROFESI DI LINGKUNGAN RSUD KABUPATEN SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:23:30'),
(808, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335192', 'PERATURAN BUPATI SINJAI NO 52 TAHUN 2018, TENTANG TARIF PELAYANAN KESEHATAN PADA BADAN LAYANAN UMUM DAERAH RSUD', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:24:50'),
(809, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335206', 'PERATURAN BUPATI SINJAI NO 07 TAHUN 2013 TENTANG PERATURAN INTERNAL HOSPITAL BYLAWS RSUD SINJAI', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:25:23'),
(810, 1, 10, 'http://ppid.sinjaikab.go.id/front/dokumen/detail/300335219', 'PERATURAN BUPATI SINJAI NO 52 TAHUN 2018 TENTANG TARIF PELAYANAN KESEHATAN PADA BADAN LAYANAN UMUM DAERAH RUMAH SAKIT UMUM DAERAH', '', '', '197707242003122006', '730728', 0, '2024-08-01 17:26:38'),
(811, 1, 5, 'https://rsudsinjai.com/pages/alur-pelayanan-poliklinik-rawat-jalan', 'ALUR PELAYANAN POLIKLINIK RAWAT JALAN', '', '', '197707242003122006', '730728', 0, '2024-08-03 09:48:37'),
(812, 1, 1, 'https://rsudsinjai.com/pages/visi-dan-misi-rsud-sinjai', 'Visi dan Misi RSUD Sinjai', '', '', '197707242003122006', '730728', 0, '2024-08-03 09:51:09'),
(813, 1, 1, 'https://rsudsinjai.com/pages/struktur-organisasi-rsud-sinjai', 'Struktur Organisasi RSUD Sinjai', '', '', '197707242003122006', '730728', 0, '2024-08-03 09:52:34'),
(818, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Juli Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Juli Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Juli_2024.pdf', '', '198104272005022006', '730746', 1, '2024-08-05 11:35:34'),
(819, 0, 0, 'Jumlah Pengunjung dan PAD Bulan Juli Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Juli Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Juli_2024.pdf', '', '198104272005022006', '730746', 0, '2024-08-05 11:37:06'),
(820, 1, 5, 'Jumlah Pengunjung dan PAD Bulan Juli Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Juli Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Juli_20241.pdf', '', '198104272005022006', '730746', 1, '2024-08-05 11:39:19'),
(826, 1, 3, 'Kegiatan pelaksanaan teknis perlindungan perempuan dan anak', 'Kegiatan pelaksanaan teknis perlindungan perempuan dan anak', 'Keg__UPT_PPA.pdf', '', '199806272022032010', '730709', 1, '2024-08-13 14:05:55'),
(827, 1, 2, 'Kegiatan pengendalian penduduk, penggerakan program bangga kencana', 'Kegiatan pengendalian penduduk, penggerakan program bangga kencana', 'Laporan_Juli_2024_Dalduk.docx', '', '199806272022032010', '730709', 1, '2024-08-13 14:09:52'),
(828, 5, 10, 'Perbup Nomor 52 tahun 2023', 'Penetapan Indikator Kinerja Utama tahun 2024-2026', 'Perbup_IKU_tahun_2024-2026.pdf', '', '199601232022032009', '730731', 1, '2024-08-13 14:32:49'),
(830, 5, 10, 'SK Bupati No 863 tahun  2023 ', 'Penunjukan Bendahara Pengeluaran & Bendahara Penerimaan Tahun 2024', 'SK_Bupati_No_863_2023_Tentang_Penunjukan_Bendahara_Pengeluaran_Bendahara_Penerimaan_Tahun_2024_11zon.pdf', '', '199601232022032009', '730731', 1, '2024-08-13 15:38:50'),
(831, 5, 10, 'SK Bupati No. 853 tahun 2022 ', 'Pelimpahan Weweang PA, Bendahara Pengaluaran, Bendahara Penerimaan & Pengurus Barang Tahun 2023', 'SK_Bupati_No__853_2022_Tentang_Pelimpahan_Weweang_PA,_Bendahara_Pengaluaran,_Bendahara_Penerimaan_Pengurus_Barang_Tahun_20231.pdf', '', '199601232022032009', '730731', 1, '2024-08-13 15:40:47'),
(832, 1, 2, 'Renstra  2024', 'renstra 2024', '', 'https://drive.google.com/drive/folders/1HWYqGJH67ANXMJX-LgkV0MgNiBXTgnh8?usp=drive_link', '198411012010012007', '730709', 0, '2024-08-14 11:01:12'),
(834, 1, 5, 'Hasil Pengukuran IKLH, IKA, IKU dan IKL semester I tahun 2024', 'Hasil Pengukuran Indeks Kualitas Lingkungan hidup (IKLH), Indeks Kualitas Air (IKA), Indeks Kualitas Udara (IKU) dan Indeks Kualitas Lahan (IKL) semester I tahun 2024', 'Hasil_Pengukuran_IKLH,_IKA,_IKU_dan_IKL_semester_I_tahun_2024_.pdf', '', '199601232022032009', '730731', 2, '2024-08-22 09:54:38'),
(835, 1, 2, '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN JULI TAHUN 2024', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN JULI TAHUN 2024', '10_BESAR_PENYAKIT_TERBANYAK_RAWAT_JALAN_DAN_RAWAT_INAP_BULAN_JULI.pdf', '', '197707242003122006', '730728', 2, '2024-08-22 15:37:34'),
(837, 1, 10, 'Keputusan Direktur Rumah Sakit Umum Daerah Kabupaten Sinjai Nomor 96 Tahun 2024 Tentang Pembentukan Tim Pembentukan Tim Pengelola Website Rumah Sakit Umum Daerah Kabupaten Sinjai', 'Keputusan Direktur Rumah Sakit Umum Daerah Kabupaten Sinjai Nomor 96 Tahun 2024 Tentang Pembentukan Tim Pembentukan Tim Pengelola Website Rumah Sakit Umum Daerah Kabupaten Sinjai', 'SK_Pembetukan_Tim_pengelola_Website_rumah_sakit_umum_daerah_kabupaten_sinjai_Tahun_2024.pdf', '', '197707242003122006', '730728', 1, '2024-08-23 12:04:06'),
(839, 1, 10, 'Keputusan Direktur Rumah Sakit Umum Daerah Kabupaten Sinjai Nomor 097 Tahun 2024 Penunjukan Pejabat Pengelola Informasi Dan Dokumentasi ( PPID ) Pembantu di Lingkup Rumah Sakit Umum Daerah Kabupaten Sinjai Tahun 2024.', 'Keputusan Direktur Rumah Sakit Umum Daerah Kabupaten Sinjai Nomor 097 Tahun 2024 Penunjukan Pejabat Pengelola Informasi Dan Dokumentasi ( PPID ) Pembantu di Lingkup Rumah Sakit Umum Daerah Kabupaten Sinjai Tahun 2024.', 'SK_PPID.pdf', '', '197707242003122006', '730728', 1, '2024-08-26 14:48:44'),
(840, 1, 10, 'Keputusan Direktur Rumah Sakit Umum Daerah Kabupaten Sinjai Nomor 98 Tahun 2024 Tentang Tim Koordinasi Sistem Pengelolaan Pengaduan Pelayanan Publik Nasional ( SP4N ) Layanan Aspirasi Dan Pengaduan Online Rakyat ( Lapor ) Lingkup Rumah Sakit Umum Daerah Ka', 'Keputusan Direktur Rumah Sakit Umum Daerah Kabupaten Sinjai Nomor 98 Tahun 2024 Tentang Tim Koordinasi Sistem Pengelolaan Pengaduan Pelayanan Publik Nasional ( SP4N ) Layanan Aspirasi Dan Pengaduan Online Rakyat ( Lapor ) Lingkup Rumah Sakit Umum Daerah Kabupaten Sinjai Tahun 2024.', 'SK_SP4N_(span_lapor)1.pdf', '', '197707242003122006', '730728', 1, '2024-08-26 14:50:31'),
(841, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Agustus Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Agustus Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Agustus_2024.pdf', '', '198104272005022006', '730746', 1, '2024-09-04 10:32:01'),
(842, 1, 5, 'Jumlah Pengunjung dan PAD Bulan Agustus Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Agustus Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Agustus_2024.pdf', '', '198104272005022006', '730746', 1, '2024-09-04 10:33:13'),
(843, 1, 0, 'SK No 51  Tahun 2024', 'Berisi tentang Penetapan Pejabat Pengelola Informasi dan Dokumentasi (PPID) Dinas Lingkungan Hidup dan Kehutanan Kabupaten Sinjai tahun 2024', 'SK_No_51_tentang_Penetapan_PPID_Tahun_2024_.pdf', '', '199601232022032009', '730731', 1, '2024-09-12 13:34:00'),
(844, 1, 0, 'Hasil Pengukuran  IKLH,IKA, IKU, dan IKL Semester I tahun 2024', 'Hasil Pengukuran Indeks Kualitas Lingkungan Hidup (IKLH), Indeks Kualitas Air (IKA) Indeks Kualitas Udara (IKU) dan Indeks Kualitas Lahan (IKL) Semester I tahun 2024', 'Hasil_Pengukuran_IKLH,_IKA,_IKU_dan_IKL_semester_I_tahun_2024.pdf', '', '199601232022032009', '730731', 1, '2024-09-12 13:48:40'),
(845, 0, 0, 'https://drive.google.com/file/d/1XsyqGlAaeYnGU5IEQbl0XOdf-526CUxE/view?usp=sharing', 'Berisi DPA Pokok tahun 2024 Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai ', '', 'https://drive.google.com/file/d/1XsyqGlAaeYnGU5IEQbl0XOdf-526CUxE/view?usp=sharing', '199601232022032009', '730731', 0, '2024-09-12 14:10:08'),
(846, 4, 0, 'https://drive.google.com/file/d/1wT6UFuPu-juB89ZmGE9zhs1SCFzGPgdr/view?usp=drive_link', 'Berisi Rencana Kerja Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai tahun 2024', '', 'https://drive.google.com/file/d/1wT6UFuPu-juB89ZmGE9zhs1SCFzGPgdr/view?usp=drive_link', '199601232022032009', '730731', 0, '2024-09-12 14:25:11'),
(847, 1, 10, 'Keputusan Direktur Rumah Sakit Umum Daerah Kabupaten Sinjai Nomor 116 Tahun 2024 Tentang Perubahan Atas Surat Keputusan Direktur Nomor 19 Tahun 2023 Tentang Jenis Pelayanan Di Rumah Sakit Umum Daerah Kabupaten Sinjai Tahun 2024', 'Keputusan Direktur Rumah Sakit Umum Daerah Kabupaten Sinjai Nomor 116 Tahun 2024 Tentang Perubahan Atas Surat Keputusan Direktur Nomor 19 Tahun 2023 Tentang Jenis Pelayanan Di Rumah Sakit Umum Daerah Kabupaten Sinjai Tahun 2024', 'JENIS_LAYANAN_116_2024_REVISI_19_TAHUN_2023.pdf', '', '197707242003122006', '730728', 1, '2024-09-18 09:40:15'),
(848, 1, 10, 'SK PPID JUZIAM 2024 (DINAS PUPR)', 'Berisi tentang SK Penetapan Admin PPID Tahun 2024 Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Sinjai', 'SK_PPID_JUZI_2024.pdf', '', '199508122022032011', '730724', 8, '2024-09-23 09:58:01'),
(849, 1, 2, '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN AGUSTUS TAHUN 2024', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN AGUSTUS TAHUN 2024', '10_Besar_Penyakit_Terbanyak_Rawat_Jalan_dan_Rawat_Inap_Bulan_Agustus.pdf', '', '197707242003122006', '730728', 1, '2024-09-23 11:24:48'),
(850, 1, 3, 'INDEKS KEPUASAN MASYARAKAT SEMESTER 1', 'BERISI INDEKS KEPUASAN MASYARAKAT SEMESTER 1 TAHUN 2024', '', 'https://drive.google.com/file/d/1RjAPn3IJU5tajXhI06jUUWV6LZmUxIy_/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-09-27 08:59:41'),
(851, 1, 5, 'umlah Pengunjung Berdasarkan Non PAD Bulan September Tahun 2024', 'umlah Pengunjung Berdasarkan Non PAD Bulan September Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_September_2024.pdf', '', '198104272005022006', '730746', 1, '2024-10-02 10:46:44'),
(852, 1, 5, 'Jumlah Pengunjung dan PAD Bulan September Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan September Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_September_2024.pdf', '', '198104272005022006', '730746', 1, '2024-10-02 10:48:19'),
(853, 1, 3, 'PERJANJIAN KINERJA RSUD SINJAI TAHUN 2023', 'PERJANJIAN KINERJA RSUD SINJAI TAHUN 2023', 'PERJANJIAN_KINERJA_RSUD_SINJAI_2023.pdf', '', '197707242003122006', '730728', 1, '2024-10-02 10:49:46'),
(854, 1, 3, 'Laporan Harga Tahunan Produk Unggulan Komoditi Perkebunan Kabupaten Sinjai Provinsi Sulawesi Selatan Tingkat Produsen dan Pengumpul Bulan September', 'Laporan Harga Tahunan Produk Unggulan Komoditi Perkebunan Kabupaten Sinjai Provinsi Sulawesi Selatan Tingkat Produsen dan Pengumpul Bulan September', 'CamScanner_02-10-2024_05_32.pdf', '', '199910022022031005', '730714', 1, '2024-10-02 10:52:04'),
(855, 1, 3, 'Laporan Kunjungan fungsional Analisis Pasar Hasil Pertanian Kepada Petani/Kelompok Tani/Gapok Tani/UPTD Pasar/Pelaku Usaha Hasil Pertanian  ', 'Laporan Kunjungan fungsional Analisis Pasar Hasil Pertanian Kepada Petani/Kelompok Tani/Gapok Tani/UPTD Pasar/Pelaku Usaha Hasil Pertanian  ', 'CamScanner_02-10-2024_05_33.pdf', '', '199910022022031005', '730714', 2, '2024-10-02 10:55:53'),
(856, 1, 3, 'Dokumentasi Pertanian', 'Dokumentasi Pertanian', 'CamScanner_02-10-2024_05_321.pdf', '', '199910022022031005', '730714', 3, '2024-10-02 10:57:23'),
(857, 1, 2, 'RKA RSUD SINJAI TAHUN 2023', 'RKA RSUD SINJAI TAHUN 2023', 'RKA_RSUD_SINJAI_2023.pdf', '', '197707242003122006', '730728', 1, '2024-10-07 10:43:20'),
(859, 1, 9, 'https://rsudsinjai.com/detailpost/hasil-survey-indeks-kepuasan-masyarakat-rumah-sakit-umum-daerah-kabupaten-sinjai-semester-1-tahun-2024', 'Hasil Survey Indeks Kepuasan Masyarakat Rumah Sakit Umum Daerah Kabupaten Sinjai Semester 1 Tahun 2024', '', 'https://rsudsinjai.com/detailpost/hasil-survey-indeks-kepuasan-masyarakat-rumah-sakit-umum-daerah-kabupaten-sinjai-semester-1-tahun-2024', '197707242003122006', '730728', 0, '2024-10-17 08:35:44'),
(860, 2, 10, 'Penetapan Status Transisi Tanggap Darurat Bencana Kepemulihan pasca Cuaca Ekstrim Banjir, Tanah Longsor, dan Angin Kencang di Kabupaten Sinjai Tahun 2023', 'Penetapan Status Transisi Tanggap Darurat Bencana Kepemulihan pasca Cuaca Ekstrim Banjir, Tanah Longsor, dan Angin Kencang di Kabupaten Sinjai Tahun 2023', 'SK_Status_Transisi_TANGGAP_DARURAT_BENCANA_2023.pdf', '', '198401192009041002', '730710', 2, '2024-10-17 11:04:06'),
(861, 2, 10, 'Penetapan Status Tanggap Darurat Cuaca Ekstrim Banjir, Tanah Longsor, dan Angin Kencang dalam Wilayah Kabupaten Sinjai Tahun 2023', 'Penetapan Status Tanggap Darurat Cuaca Ekstrim Banjir, Tanah Longsor, dan Angin Kencang dalam Wilayah Kabupaten Sinjai Tahun 2023', 'SK_STATUS_TANGGAP_DARURAT_BENCANA_sinjai_2023.pdf', '', '198401192009041002', '730710', 1, '2024-10-17 11:09:21'),
(863, 2, 10, 'Penetapan Perpanjangan Status Tanggap Darurat Cuaca Ekstrim Banjir, Tanah Longsor, dan Angin Kencang dalam Wilayah Kabupaten Sinjai Tahun 2023', 'Penetapan Perpanjangan Status Tanggap Darurat Cuaca Ekstrim Banjir, Tanah Longsor, dan Angin Kencang dalam Wilayah Kabupaten Sinjai Tahun 2023', 'SK_PERPANJANGAN_STATUS_TANGGAP_DARURAT_BENCANA_2023.pdf', '', '198401192009041002', '730710', 1, '2024-10-17 11:15:57'),
(864, 2, 10, 'Penetapan Status Tanggap Darurat Kekeringan, Kebakaran Hutan dan Lahan dalam Wilayah Kabupaten Sinjai Tahun 2023', 'Penetapan Status Tanggap Darurat Kekeringan, Kebakaran Hutan dan Lahan dalam Wilayah Kabupaten Sinjai Tahun 2023', 'SK_STATUS_TANGGAP_DARURAT_BENCANA_KEKERINGAN_20231.pdf', '', '198401192009041002', '730710', 2, '2024-10-17 11:18:38'),
(865, 2, 10, 'Surat Edaran Bupati Sinjai Nomor 1754 Tahun 2023 tentang Imbauan Kesiapsiagaan Menghadapi Dampak El Nino Tahun 2023', 'Penetapan Status Tanggap Darurat Kekeringan, Kebakaran Hutan dan Lahan dalam Wilayah Kabupaten Sinjai Tahun 2023', 'SURAT_EDARAN_EL_NINO_BUPATI.pdf', '', '198401192009041002', '730710', 1, '2024-10-17 11:22:37'),
(866, 1, 2, 'STANDAR PELAYANAN PUBLIK DAN MAKLUMAT PELAYANAN RSUD SINJAI', 'STANDAR PELAYANAN PUBLIK DAN MAKLUMAT PELAYANAN RSUD SINJAI', '', 'https://rsudsinjai.com/detailpost/standar-pelayanan-publik-dan-maklumat-pelayanan-rsud-sinjai', '197707242003122006', '730728', 0, '2024-10-21 09:21:16'),
(867, 1, 10, 'PERINGATI HARI OSTEOPOROSIS, PKRS LAKUKAN PENYULUHAN KESEHATAN', 'PERINGATI HARI OSTEOPOROSIS, PKRS LAKUKAN PENYULUHAN KESEHATAN', '', 'https://rsudsinjai.com/detailpost/peringati-hari-osteoporosis-pkrs-lakukan-penyuluhan-kesehatan', '197707242003122006', '730728', 0, '2024-10-28 12:43:03'),
(868, 1, 3, 'ALUR PELAYANAN POLIKLINIK RAWAT JALAN RSUD SINJAI', 'ALUR PELAYANAN POLIKLINIK RAWAT JALAN RSUD SINJAI', '', 'https://rsudsinjai.com/pages/alur-pelayanan-poliklinik-rawat-jalan', '197707242003122006', '730728', 0, '2024-11-04 11:18:12'),
(869, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Oktober Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Oktober Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Oktober_2024.pdf', '', '198104272005022006', '730746', 1, '2024-11-06 10:21:57'),
(870, 1, 4, 'Jumlah Pengunjung dan PAD Bulan Oktober Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Oktober Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Oktober_2024.pdf', '', '198104272005022006', '730746', 1, '2024-11-06 10:26:56'),
(871, 1, 0, 'Persiapan Penilaian Adipura tahun 2024', 'Persiapan Penilaian Adipura tahun 2024 dengan melakukan persiapan untuk penilaian dan pemantauan terhadap pelaksanaan Kriteria, Indikator, dan Skala Nilai Capaian Adipura', 'Surat_Persiapan_Adipura_Tahun_2024.pdf', '', '199601232022032009', '730731', 1, '2024-11-07 14:41:55'),
(873, 5, 0, 'SK Bupati No.640 Tahun 2024', 'Pembentukan Tim Koordinasi Pembinaan Adipura Kabupaten Sinjai Tahun 2024', 'SK_ADIPURA_TAHUN_2024.pdf', '', '199601232022032009', '730731', 1, '2024-11-07 14:52:40'),
(874, 1, 0, 'Laporan Kemajuan Fisik dan Keuangan Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai', 'Laporan Kemajuan Fisik dan Keuangan sampai dengan bulan oktober tahun 2024', 'Laporan_Kemajuan_Fisik_dan_Keuangan_bulan_Oktober_tahun_2024.pdf', '', '199601232022032009', '730731', 2, '2024-11-11 13:26:53'),
(875, 1, 2, 'https://rsud.sinjaikab.go.id/detailpost/pemeriksaan-laboratorium-pra-nikah', 'PEMERIKSAAN LABORATORIUM PRA NIKAH', '', 'https://rsud.sinjaikab.go.id/detailpost/pemeriksaan-laboratorium-pra-nikah', '197707242003122006', '730728', 0, '2024-11-13 08:51:48'),
(876, 1, 5, 'https://rsud.sinjaikab.go.id/detailpost/pengumuman-aplikasi-e-siantri-di-non-aktifkan', 'PENGUMUMAN APLIKASI E-SIANTRI DI NON-AKTIFKAN', '', 'https://rsud.sinjaikab.go.id/detailpost/pengumuman-aplikasi-e-siantri-di-non-aktifkan', '197707242003122006', '730728', 0, '2024-11-13 08:56:47'),
(878, 5, 10, 'SK PPID DINAS PUPR 2024', 'SK Admin PPID Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Sinjai Tahun 2024', 'SK_PPID_Dinas_Pekerjaan_Umum_dan_Penataan_Ruang_20241.pdf', '', '199508122022032011', '730724', 2, '2024-11-13 09:53:50'),
(879, 5, 10, 'SK PPID RSUD SINJAI TAHUN 2024', 'SK Admin PPID RSUD SINJAI Tahun 2024', 'SK_PPID1.pdf', '', '197707242003122006', '730728', 2, '2024-11-13 10:09:08'),
(880, 1, 8, 'https://rsudsinjai.com/detailpost/pengumuman', 'PENGUMUMAN ', '', 'https://rsudsinjai.com/detailpost/pengumuman', '197707242003122006', '730728', 0, '2024-11-14 16:46:49'),
(881, 1, 8, 'https://rsud.sinjaikab.go.id/detailpost/pengumuman-informasi-layanan-via-whatsapp', 'PENGUMUMAN INFORMASI LAYANAN VIA WHATSAPP', '', 'https://rsud.sinjaikab.go.id/detailpost/pengumuman-informasi-layanan-via-whatsapp', '197707242003122006', '730728', 0, '2024-11-16 10:26:55'),
(882, 1, 6, 'LAPORAN TINDAK LANJUT PENGADUAN ', 'BERISIS LAPORAN TINDAK LANJUT PENGADUAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN TRIWULAN III TAHUN 2024', '', 'https://drive.google.com/file/d/1gJ04ztIln5Ui_ixk2uuGYQgK5Ltl5Qdh/view?usp=sharing', '197109211992031006', '730712', 0, '2024-11-19 08:42:12'),
(883, 1, 6, 'REKAPITULASI PENGADUAN', 'BERISI TENTANG REKAPITULASI PENGADUAN PERIZINAN BERUSAHA,PERIZINAN NON BERUSAHA DAN NON PERIZINAN TRIWULAN III TAHUN 2024', '', 'https://drive.google.com/file/d/1KwaGTpTvMnj715x2MOOtzBKpkYGSHABu/view?usp=drive_link', '197109211992031006', '730712', 0, '2024-11-19 08:44:00'),
(884, 1, 2, 'Renstra Diskan 2024-2026', 'Rentra Diskan TA. 2024- 2026', 'organized_compressed.pdf', '', '198506022010012036', '730720', 1, '2024-11-19 09:24:21'),
(885, 1, 3, 'Cascading Diskan 2024', 'Berisi Informasi proses penjabaran dan penyelarasan target, IKU, dan Sasaran Strategis secara vertikal dari level unit atau pegawai yang lebih tinggi ke level unit atau pegawai yang lebih rendah', 'CASCADING_2024_DISKAN_.pdf', '', '198506022010012036', '730720', 1, '2024-11-19 09:27:13'),
(886, 1, 3, 'Laporan Kinerja Diskan 2023', 'Berisi Laporan Kinerja Dinas Perikanan Ta. 2023 ', 'Laporan_Kinerja_2023.pdf', '', '198506022010012036', '730720', 1, '2024-11-19 09:29:35'),
(887, 1, 2, 'Pohon Kinerja Diskan 2024', 'Berisi Informasi Kinerja Diskan ', 'POHON_KINERJA_DISKAN_2024.pdf', '', '198506022010012036', '730720', 1, '2024-11-19 09:32:09'),
(888, 1, 2, 'Rencana Aksi Berdasarkan perjanjaian Kinerja Diskan 2024', 'Berisi Informasi rencana Diskan berdasarkan Perjanjain Kinerja 2024', 'rencana_aksi_berdasarkan_PK_Diskan_T__2024.pdf', '', '198506022010012036', '730720', 1, '2024-11-19 09:34:01'),
(889, 5, 3, 'SK PPID Diskan Tahun 2024', 'berisi Informasi SK PPID Diskan Tahun 2024', 'SK_PPID_diskan_24(3).pdf', '', '198506022010012036', '730720', 3, '2024-11-19 10:03:18'),
(890, 5, 3, 'SK Pengelola Website Diskan Tahun 2024', 'Berisi Informasi SK Pengelola Website Diskan Tahun 2024', 'SK_Pengelola_Web_diskan_24(2).pdf', '', '198506022010012036', '730720', 1, '2024-11-19 10:05:35'),
(891, 1, 2, 'Laporan kemajuan Fisik dan keuangan Diskan s/d bulan Oktober 2024', 'berisi Informasi Program Kerja kemajuan Fisik dan keuangan Diskan s/d bulan Oktober 2024', 'Lap__Fisik_keu_Oktober.pdf', '', '198506022010012036', '730720', 1, '2024-11-19 10:07:24'),
(892, 1, 3, 'Statistik Dinas Perikanan TA. 2019 - 2023', 'Berisi Informasi tentang Pertumbuhan Produksi Perikanan Baik Bidang Penangkapan, Budidaya serta Pengolahan. Serta menggambarkan Potensi Perikanan yang ada di kabupaten Sinjai.', 'Statistik_perikanan_2023.pdf', '', '198506022010012036', '730720', 1, '2024-11-19 11:08:26'),
(893, 1, 3, 'Laporan Monitoring dan Evaluasi Trw I Diskan TA. 2024', 'berisi Laporan kegiatan  Monitoring dan Evaluasi Trw I Diskan TA. 2024', 'Laporan_monitoring_dan_evaluasi_triwulan_I_tahun_2024.pdf', '', '198506022010012036', '730720', 1, '2024-11-21 08:41:35'),
(894, 1, 3, 'Laporan Monitoring dan Evaluasi Trw II Diskan TA. 2024', 'Berisi Laporan kegiatan Monitoring dan Evaluasi Trw II Diskan TA. 2024', 'Laporan_monitoring_dan_evaluasi_triwulan_II_2024.pdf', '', '198506022010012036', '730720', 2, '2024-11-21 08:42:36'),
(895, 1, 2, 'Dokter Gigi Spesialis Protodonsia Hadir di RSUD Sinjai', 'Dokter Gigi Spesialis Protodonsia Hadir di RSUD Sinjai', '', 'https://rsudsinjai.com/detailpost/dokter-gigi-spesialis-protodonsia-hadir-di-rsud-sinjai', '197707242003122006', '730728', 0, '2024-12-02 11:39:13'),
(897, 5, 10, 'Standar Operasional Biaya PPID', 'Standar Operasional Biaya PPID', '20241114140924Standar_Operasional_Biaya_PPID1.pdf', '', '199910022022031005', '730714', 4, '2024-12-02 11:54:37'),
(898, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan November Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bula November Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_November_2024.pdf', '', '198104272005022006', '730746', 2, '2024-12-04 10:22:35'),
(899, 1, 5, 'Jumlah Pengunjung dan PAD Bulan November Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan November Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_November_2024.pdf', '', '198104272005022006', '730746', 1, '2024-12-04 10:24:10'),
(900, 1, 3, 'https://rsud.sinjaikab.go.id/detailpost/rsud-sinjai-adakan-monitoring-dan-evaluasi-manrisk-triwulan-iii-tahun-2024-dirangkaikan-dengan-penyusunan-manrisk-tahun-2025', 'RSUD SINJAI ADAKAN MONITORING DAN EVALUASI MANRISK TRIWULAN III TAHUN 2024 DIRANGKAIKAN DENGAN PENYUSUNAN MANRISK TAHUN 2025', '', 'https://rsud.sinjaikab.go.id/detailpost/rsud-sinjai-adakan-monitoring-dan-evaluasi-manrisk-triwulan-iii-tahun-2024-dirangkaikan-dengan-penyusunan-manrisk-tahun-2025', '197707242003122006', '730728', 0, '2024-12-05 10:02:56'),
(901, 1, 3, 'https://rsud.sinjaikab.go.id/detailpost/pemeliharaan-alat-kesehatan-di-rumah-sakit-bersama-teknisi-elektromedis-rsud-sinjai', 'PEMELIHARAAN ALAT KESEHATAN DI RUMAH SAKIT BERSAMA TEKNISI ELEKTROMEDIS RSUD SINJAI', '', 'https://rsud.sinjaikab.go.id/detailpost/pemeliharaan-alat-kesehatan-di-rumah-sakit-bersama-teknisi-elektromedis-rsud-sinjai', '197707242003122006', '730728', 0, '2024-12-05 10:05:49'),
(902, 1, 2, 'AKAN HADIR KEPALA BIDANG PELAYANAN MEDIS DAN KEPERAWATAN UPT RSUD SINJAI PADA ACARA TALKSHOW DOKTER TA’ DI SINJAI TV', 'AKAN HADIR KEPALA BIDANG PELAYANAN MEDIS DAN KEPERAWATAN UPT RSUD SINJAI PADA ACARA TALKSHOW DOKTER TA’ DI SINJAI TV', '', 'https://rsudsinjai.com/detailpost/akan-hadir-kepala-bidang-pelayanan-medis-dan-keperawatan-upt-rsud-sinjai-pada-acara-talkshow-dokter-ta-di-sinjai-tv', '197707242003122006', '730728', 0, '2024-12-10 12:06:56'),
(903, 1, 2, 'RSUD SINJAI MENGADAKAN PENYULUHAN PENCEGAHAN PENYAKIT TUBERKULOSIS TBC', 'RSUD SINJAI MENGADAKAN PENYULUHAN PENCEGAHAN PENYAKIT TUBERKULOSIS TBC', '', 'https://rsudsinjai.com/detailpost/rsud-sinjai-mengadakan-penyuluhan-pencegahan-penyakit-tuberkulosis-tbc', '197707242003122006', '730728', 0, '2024-12-10 12:11:21'),
(906, 1, 3, '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN NOVEMBER TAHUN 2024', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN NOVEMBER TAHUN 2024.', '10_BESAR_PENYAKIT_TERBANYAK_BULAN_NOVEMBER_RAWAT_JALAN_DAN_INAP.pdf', '', '197707242003122006', '730728', 3, '2024-12-17 12:18:39'),
(907, 1, 3, 'RENJA RSUD SINJAI TAHUN 2023', 'RENJA RSUD SINJAI TAHUN 2023', 'RENJA_RSUD_SINJAI__TAHUN_2023.pdf', '', '197707242003122006', '730728', 2, '2024-12-18 07:44:28'),
(908, 1, 9, 'INFORMASI PENYAKIT TERBANYAK BULAN DESEMBER 2024 DI RSUD SINJAI', 'Data penyakit terbanyak pada pelayanan kesehatan Poliklinik Rawat Jalan RSUD Sinjai, kunjungan pasien dengan penyakit terbanyak pada Bulan Desember 2024', '', 'https://rsudsinjai.com/detailpost/informasi-penyakit-terbanyak-bulan-desember-2024-di-rsud-sinjai', '197707242003122006', '730728', 0, '2025-01-03 18:57:20'),
(909, 1, 5, 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Desember Tahun 2024', 'Jumlah Pengunjung Berdasarkan Non PAD Bulan Desember Tahun 2024', 'Jumlah_Pengunjung_Objek_Wisata_Dikelola_DesaKel__Bulan_Desember_2024.pdf', '', '198104272005022006', '730746', 1, '2025-01-07 10:20:35'),
(910, 1, 5, 'Jumlah Pengunjung dan PAD Bulan Desember Tahun 2024', 'Jumlah Pengunjung dan PAD Bulan Desember Tahun 2024', 'Realisasi_PAD_dan_Pengunjung_Bulan_Desember_2024.pdf', '', '198104272005022006', '730746', 1, '2025-01-07 10:21:41'),
(912, 1, 1, 'PROFIL RSUD SINJAI TAHUN 2023', 'PROFIL RSUD SINJAI TAHUN 2023', 'PROFIL_RS_2023_11zon-31.pdf', '', '197707242003122006', '730728', 2, '2025-01-10 13:49:24'),
(913, 1, 2, 'TIM HIV UPT RSUD SINJAI LAKSANAKAN MONEV SEMESTER II TAHUN 2024', 'UPT Rumah Sakit Umum Daerah Sinjai, dalam hal ini, Tim HIV melaksanakan Monitoring dan Evaluasi (MONEV) Semester II tahun 2024', '', 'https://rsudsinjai.com/detailpost/tim-hiv-upt-rsud-sinjai-laksanakan-monev-semester-ii-tahun-2024', '197707242003122006', '730728', 0, '2025-01-17 12:34:59'),
(914, 1, 3, 'LAPORAN SURVEI KEPUASAN MASYARAKAT SEMESTER II TAHUN 2024 (1)', 'BERIAI TENTANG LAPORAN SURVEI KEPUASAN MASYARAKAT SEMESTER II TAHUN 2024 (1)', '', 'https://drive.google.com/file/d/10w5J_aksOzNHH_39yFO7uBlYU0DgN1U7/view?usp=sharing', '197109211992031006', '730712', 0, '2025-01-21 08:43:04'),
(915, 1, 0, 'Risk Register 2025', 'Berisi tentang Risk Register Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai tahun 2025', '', 'https://drive.google.com/file/d/1hSbJYPhf73LZyZ5vq5yCxJ7IP-Ww-gk1/view?usp=drive_link', '199601232022032009', '730731', 0, '2025-01-22 14:12:27'),
(916, 4, 0, 'Rencana Kerja', 'Berisi tentang Rencana Kerja Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai tahun 2025', '', 'https://drive.google.com/file/d/1SAVldHXg26FgR0XKKwaW-BdzDaNmn5eS/view?usp=drive_link', '199601232022032009', '730731', 0, '2025-01-22 14:26:36');
INSERT INTO `dok_data` (`dok_id`, `kategori_id`, `jenis_id`, `dok_nama`, `dok_deskripsi`, `dok_file`, `dok_url`, `nip`, `unit_id`, `dok_count`, `dok_created`) VALUES
(917, 4, 0, 'Rencana Kerja Perubahan', 'Berisi Tentang Rencana Kerja Perubahan Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai tahun 2024', '', 'https://drive.google.com/file/d/1JqFky-PpnsZlfEMl5TzxXgaEjZhS9c3w/view?usp=drive_link', '199601232022032009', '730731', 0, '2025-01-22 14:33:59'),
(918, 1, 0, 'Hasil Pengukuran IKLH Semester II tahun 2024', 'Berisi hasil pengukuran Indeks kualitas lingkungan hidup (IKLH) semester II tahun 2024', '', 'https://drive.google.com/file/d/1sKcZCCOPjOwJ00X8Bs4gxHouXqm7p-6A/view?usp=drive_link', '199601232022032009', '730731', 0, '2025-01-22 15:02:32'),
(919, 1, 4, 'Laporan kemajuan fisik ', 'berisi kemajuan fisik diskopnaker 2024', '12_Desember_2024_Diskopnaker1.xlsx', '', '196812021994011001', '730743', 1, '2025-01-22 15:22:21'),
(920, 1, 7, ' laporan pengadaan ', 'laporan pengadaan modal 2024', 'KOPERASI_UKM.xlsx', '', '196812021994011001', '730743', 3, '2025-01-22 15:23:56'),
(921, 1, 7, 'laporan rencana pengadaan barang', 'berisi rencana laporan pengadaan 2024', 'Rekap_2024.xlsx', '', '196812021994011001', '730743', 1, '2025-01-22 15:28:22'),
(922, 1, 4, 'rka 2024', 'berisi laporan RKA 2024', 'Rekap_RKA_Belanja_SKPD_DINAS_KOPERASI,_USAHA_KECIL_MENENGAH_DAN_TENAGA_KERJA.docx', '', '196812021994011001', '730743', 2, '2025-01-22 15:29:40'),
(923, 1, 2, 'EVALUASI PROGRAM 2024', 'Berisi tabel evaluasi program 2024', 'tabel_triwulan_IV_24.docx', '', '196812021994011001', '730743', 2, '2025-01-22 15:31:45'),
(924, 1, 2, 'rencana aksi 2024', 'berisi laporan rencana aksi 2024', 'Rencana_Aksi_Diskopnaker_2024.xlsx', '', '196812021994011001', '730743', 1, '2025-01-22 15:33:46'),
(925, 1, 2, 'evaluasi renja 2024', 'berisi laporan evaluasi renja 2024', 'EVALUASI_RENJA_2024_FIX.xlsx', '', '196812021994011001', '730743', 1, '2025-01-22 15:35:07'),
(926, 1, 2, 'RKT 2024', 'Berisi laporan RKT 2024', 'RKT_2024.docx', '', '196812021994011001', '730743', 1, '2025-01-22 15:35:55'),
(927, 1, 3, 'FAKTA INTEGRITAS', 'Berisi fakta integritas 2024', 'PAKTA_INTEGRITAS_2024_diskopnaker.doc', '', '196812021994011001', '730743', 4, '2025-01-22 15:37:35'),
(928, 1, 7, 'format pengadaan barang dan jasa', 'berisi barang dan jasa tahun 2024', 'Format_Pengadaan_Barang_dan_Jasa_2024.xlsx', '', '196812021994011001', '730743', 3, '2025-01-22 15:46:20'),
(929, 1, 4, 'LRA 2024', 'Beri laporan keuangan 2024', 'LRA_KOPERASI_per_31_desember_2024.xlsx', '', '196812021994011001', '730743', 8, '2025-01-22 15:46:56'),
(930, 1, 3, 'Rencana Kinerja Tahunan 2024', 'berisi Informasi Kinerja Tahunan 2024', 'RKT_2024_sdh_TTD.pdf', '', '198506022010012036', '730720', 0, '2025-02-05 08:12:45'),
(931, 1, 4, 'Laporan Penyerapan Anggaran 2024', 'Berisi Laporan penyerapan realisasi Anggaran 2024', 'LRA_Desember.xlsx', '', '198506022010012036', '730720', 0, '2025-02-05 08:16:19'),
(933, 1, 4, 'Laporan Kemajuan Fisik Dan keuangan Desember 2024', 'Berisi laporan Fisik dan Keuangan Dinas Perikanan Desember 2024', 'Lap__Kemajuan_Fisik_dan_keuangan_Des1.pdf', '', '198506022010012036', '730720', 3, '2025-02-05 08:21:42'),
(935, 1, 4, 'Laporan Mutasi Persediaan 2024', 'Berisi Laporan Mutasi Persediaan Diskan 2024', 'Persediaan_Des_compressed_compressed_(1).pdf', '', '198506022010012036', '730720', 3, '2025-02-05 08:35:18'),
(936, 1, 3, 'Renja Diskan 2024', 'berisi rencana Kerja Diskan 2024', 'RENJA_DISKAN_2024_merged_compressed.pdf', '', '198506022010012036', '730720', 0, '2025-02-05 09:20:09'),
(937, 4, 3, 'Renja Diskan 2024', 'berisi rencana Kerja Diskan 2024', 'RENJA_DISKAN_2024_merged_compressed1.pdf', '', '198506022010012036', '730720', 0, '2025-02-05 09:27:37'),
(938, 4, 3, 'DPPA Diskan 2024', 'berisi Dokumen perubahan Pelaksanaan Anggaran Diskan  2024', 'DPPA_2024_merged_compressed.pdf', '', '198506022010012036', '730720', 0, '2025-02-05 09:37:27'),
(940, 1, 7, 'Pembangunan Gedung Infection Center 2023', 'Paket-paket pengadaan barang dan jasa Tahun 2023 berkaitan program atau kegiatan infrastruktur dan non infrastruktur dengan nilai tertinggi atau strategis sebagaimana tercantum dalam LPSE yang telah selesai serah terim', '', 'https://drive.google.com/file/d/11wn_tDzzJbFpqnkwU8ENswT1gq7V9TBA/view', '199910022022031005', '730714', 0, '2025-02-05 10:06:04'),
(941, 1, 7, 'Penataan Kawasan Alun-alun Sinjai Bersatu Tahun 2023', 'Paket-paket pengadaan barang dan jasa Tahun 2023 berkaitan program atau kegiatan infrastruktur dan non infrastruktur dengan nilai tertinggi atau strategis sebagaimana tercantum dalam LPSE yang telah selesai serah terim', '', 'https://drive.google.com/file/d/1RmB-6eshkcShICl2gTapxNR1_TbAdQcg/view', '199910022022031005', '730714', 0, '2025-02-05 10:08:42'),
(942, 1, 2, 'RKA 2024', 'Berisi RKA 2024', 'RKA_2024.pdf', '', '198506022010012036', '730720', 0, '2025-02-05 11:32:16'),
(943, 1, 2, 'Laporan Monitoring & Evaluasi Kinerja ', 'Berisi Laporan Monitoring dan Evaluasi Kinerja Diskan 2024', 'LAPORAN_MONITORING_EVALUASI_KINERJA_TRIWULAN_IV_250205_100513.pdf', '', '198506022010012036', '730720', 0, '2025-02-05 11:37:12'),
(944, 4, 10, 'SK Penetapan DIP Tahun 2024', 'Daftar Informasi Publik (DIP) Tahun 2024', '', 'https://drive.google.com/file/d/1SK1CSsnuT1hoKYtM-e3dsIJqMWP09T6y/view', '199910022022031005', '730714', 0, '2025-02-05 12:25:44'),
(945, 1, 7, 'Kerangka Acuan Kerja', 'Dokumen Kerangka Acuan Kerja (KAK) 2023', '', 'https://drive.google.com/file/d/1v_RnWHykuhOMDUF2HZReGu6LvUFLOFOH/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:10:20'),
(946, 1, 7, 'Harga Perkiraan Sendiri', 'Dokumen Harga Perkiraan Sendiri (HPS) 2023', '', 'https://drive.google.com/file/d/1EYrskM-2IuCSdmOAFJZ3Kc60_M9QGR_Q/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:11:24'),
(947, 1, 7, 'Rancangan Kontrak', 'Dokumen Rancangan Kontrak 2023', '', 'https://drive.google.com/file/d/1lIZYDEZredKeeYYnTT-qtfwol3hhog6v/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:12:22'),
(948, 1, 7, 'Daftar Harga', 'Dokumen Daftar Harga 2023', '', 'https://drive.google.com/file/d/1ykgbSxKhHWmsQuKzPzb9acgtBuUbKu3_/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:14:35'),
(949, 1, 7, 'Jadwal Pelaksanaan dan Data Lokasi Pekerjaan', 'Dokumen Jadwal Pelaksanaan dan Data Lokasi Pekerjaan 2023', '', 'https://drive.google.com/file/d/1h4KdyDIpTfcO141BJA782GYWFkuhp8oD/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:16:01'),
(950, 1, 7, 'Gambar Rancangan Pekerjaan', 'Dokumen Gambar Rancangan Pekerjaan 2023', '', 'https://drive.google.com/file/d/1fb0q5w7Qs_m8b_IngEnOQBLubAJ0Bseu/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:17:08'),
(951, 1, 7, 'Dokumen Penawaran Administratif', 'Dokumen Penawaran Administratif 2023', '', 'https://drive.google.com/file/d/1mN3hpMjW4up3HohslL_epXnj-2Okwvxo/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:18:05'),
(952, 1, 7, 'Surat Penawaran Penyedia', 'Dokumen Surat Penawaran Penyedia 2023', '', 'https://drive.google.com/file/d/1yBAxgP8x8e7nQeLZExOxv4ZI0j4Iplp_/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:19:19'),
(953, 1, 7, 'Berita Acara Penetapan atau Pengumuman Pemenang Pemilihan', 'Dokumen Berita Acara Penetapan atau Pengumuman Pemenang Pemilihan 2023', '', 'https://drive.google.com/file/d/1So9dYcvp7DWrpCoOQC6eCs_vDxQynIhE/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:20:47'),
(954, 1, 7, 'Berita Acara Hasil Pemilihan Penyedia', 'Dokumen Berita Acara Hasil Pemilihan Penyedia 2023', '', 'https://drive.google.com/file/d/1FB37feicl_l0MmQSE08HAPe9vTplAiZk/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:22:07'),
(955, 1, 7, 'Surat Penunjukkan Penyedia Barang Jasa', 'Dokumen Surat Penunjukkan Penyedia Barang Jasa (SPPBJ) 2023', '', 'https://drive.google.com/file/d/1GXMiEG_4nhgZjsSrMYlN7NILYPaB5zTP/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:24:21'),
(956, 1, 7, 'Surat Perjanjian Kemitraan', 'DOkumen Surat Perjanjian Kemitraan 2023', '', 'https://drive.google.com/file/d/16RwDHRmfLphe9vdH2b8iK0bBBIiiHksF/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:25:30'),
(957, 1, 7, 'Dokumen SPK', 'DOkumen SPK 2023', '', 'https://drive.google.com/file/d/1jEKxZsN9LPqxJ0O42sVwmdffpcSNSoW7/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:26:00'),
(958, 1, 7, 'Surat Perintah Mulai Kerja', 'Dokumen Surat Perintah Mulai Kerja 2023', '', 'https://drive.google.com/file/d/14KKo9EGAgmrIoM29UwYohY8m2AK4JQS4/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:27:01'),
(959, 1, 7, 'Surat Jaminan Pelaksanaan', 'DOkumen Surat Jaminan Pelaksanaan 2023', '', 'https://drive.google.com/file/d/1mFpYNNZo9DQT0_mgKbX5rdlJJ6SAcoKt/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:27:39'),
(960, 1, 7, 'Surat Jaminan Uang Muka', 'Dokumen Surat Jaminan Uang Muka 2023', '', 'https://drive.google.com/file/d/1-b1PN1B6dpee5sHPW063FYYWgWOOkpSf/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:28:32'),
(961, 1, 7, 'Surat Jaminan Pemeliharaan', 'Dokumen Surat Jaminan Pemeliharaan 2023', '', 'https://drive.google.com/file/d/1qO5N4q1DMXmubuGDYudrcaVjjl_vVcNz/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:29:51'),
(962, 1, 7, 'Surat Tagihan', 'DOkumen Surat Tagihan 2023', '', 'https://drive.google.com/file/d/1GTSd0zsnvsI9usozijZEGn95P6-rOueL/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:30:40'),
(963, 1, 7, 'Surat Pesanan E-Purchasing', 'Dokumen Surat Pesanan E-Purchasing 2023', '', 'https://drive.google.com/file/d/1qrCpyH5aZS28mnp9xkge_f24-Qrd1yfu/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:31:31'),
(964, 1, 7, 'Surat Perintah Membayar', 'Dokumen Surat Perintah Membayar 2023', '', 'https://drive.google.com/file/d/1Tqct1C55DWWeYzFxsxnsCsCYIu3jCS38/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:32:09'),
(965, 1, 7, 'Surat Perintah Pencairan Dana', 'Dokumen Surat Perintah Pencairan Dana 2023', '', 'https://drive.google.com/file/d/1zrTHbRon_EgwDI8lh9Yfbx8yw1ZJ-z7z/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-05 16:32:55'),
(966, 1, 2, 'RKPD Tahun 2024', 'RKPD Tahun 2024', '', 'https://drive.google.com/file/d/1QsXAUNiGN0gD-c4x_krtK2zgZPpUcIku/view', '199910022022031005', '730714', 0, '2025-02-06 09:26:59'),
(967, 4, 2, 'RKPD Tahun 2023', 'RKPD Tahun 2023', '', 'https://drive.google.com/file/d/1_PPzCRu1dW4B24fGefMQoK0n7Tncln5l/view', '199910022022031005', '730714', 0, '2025-02-06 09:30:01'),
(969, 1, 4, 'LRA 2023', 'Rencana dan laporan realisasi anggaran 2023', '', 'https://drive.google.com/file/d/19kWrYjHMDdfunsn83XRh6WRKxM9NsRo5/view', '199910022022031005', '730714', 0, '2025-02-06 11:16:43'),
(970, 1, 4, 'Neraca 2023', 'Neraca 2023', '', 'https://drive.google.com/file/d/1d8uTYrPS84tUCSohUqetsfd6xuTrZZdv/view', '199910022022031005', '730714', 0, '2025-02-06 11:19:15'),
(971, 1, 4, 'LAPORAN ARUS KAS 2023', 'LAPORAN ARUS KAS 2023', '', 'https://drive.google.com/file/d/16cmwJ7aKcvM5nvDKIblzz9ClPX0Z1c0x/view', '199910022022031005', '730714', 0, '2025-02-06 11:21:03'),
(972, 1, 4, 'PERDA NO. 5 Th 2022 APBD TA 2023 ', 'PERDA NO. 5 Th 2022 APBD TA 2023 ', '', 'https://drive.google.com/file/d/1D94tXWI5PFYwMXeL3LWu60IJfiPLAmic/view', '199910022022031005', '730714', 0, '2025-02-07 09:36:59'),
(973, 1, 4, 'PERDA NO. 2 Th 2023 Perubahan APBD TA 2023', 'PERDA NO. 2 Th 2023 Perubahan APBD TA 2023', '', 'https://drive.google.com/file/d/1UMEwAWBhNCT4xQb1nAR0B4qOHcCRnn-c/view', '199910022022031005', '730714', 0, '2025-02-07 09:41:01'),
(974, 1, 4, 'LRA PPKD 2023', 'LRA PPKD 2023', '', 'https://drive.google.com/file/d/1Or79rs31PRcW3LgHrxU2pU_1s8DWEO7l/view', '199910022022031005', '730714', 0, '2025-02-07 09:59:33'),
(975, 1, 4, 'OPINI 2023 dan Resume hasil pemeriksaan ', 'OPINI 2023 dan Resume hasil pemeriksaan ', '', 'https://drive.google.com/file/d/1QW58-F1zDou8gAavEkRG0_Cm0NEmCgTc/view', '199910022022031005', '730714', 0, '2025-02-07 10:43:12'),
(976, 1, 7, 'Kerangka Acuan Kerja', 'Dokumen Kerangka Acuan Kerja (KAK) 2024', '', 'https://drive.google.com/file/d/1lXDrC4tOsxzwmcTdPvjUOxMCBRswaB_L/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:47:19'),
(977, 1, 7, 'Harga Perkiraan Sendiri', 'DOkumen Harga Perkiraan Sendiri (HPS) 2024', '', 'https://drive.google.com/file/d/1ZWajYVddaUf_RegIeQ4tEfjLjOhKmy4I/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:48:01'),
(978, 1, 7, 'Spesifikasi Teknis', 'Dokumen Spesifikasi Teknis 2024', '', 'https://drive.google.com/file/d/1boi8jFg9CA35qmcIwUdLxbbLsPnon64A/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:48:45'),
(979, 1, 7, 'Rancangan Kontrak', 'Dokumen Rancangan Kontrak 2024', '', 'https://drive.google.com/file/d/1_bkjgFq9Wa86x7oLwdnA4RY84PnH-V0L/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:49:19'),
(980, 1, 7, 'Dokumen Persyaratan Proses Pemilihan atau Lembar Data Pemilihan', 'Dokumen Persyaratan Proses Pemilihan atau Lembar Data Pemilihan 2024', '', 'https://drive.google.com/file/d/14UIUS7XuJOMiESJJ8EnbyK4PtsmOCmXg/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:51:13'),
(981, 1, 7, 'Daftar Kuantitas dan Harga', 'DOkumen Daftar KuUantitas dan Harga 2024', '', 'https://drive.google.com/file/d/1EcVUf25Lgw3Xm4vwScvFhWlUS_EZrmR6/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:52:10'),
(982, 1, 7, 'Jadwal Pelaksanaan dan Data Lokasi Pekerjaan', 'Dokumen Jadwal Pelaksanaan dan Data Lokasi Pekerjaan 2024', '', 'https://drive.google.com/file/d/1ChnETX1zxVAxceP8zkm3x-kSjajFi9fI/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:53:13'),
(983, 1, 7, 'Gambar Rancangan Pekerjaan', 'Dokumen Gambar Rancangan Pekerjaan 2024', '', 'https://drive.google.com/file/d/1HmC_SwaU_Z1JTgbwgUE17ybgd2FKc_jV/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:53:48'),
(984, 1, 7, 'Dokumen Penawaran Administratif', 'Dokumen Penawaran Administratif 2024', '', 'https://drive.google.com/file/d/1PtReqFB0Wi4IsTOjeDw36mPD0899DvY8/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:54:45'),
(985, 1, 7, 'Surat Penawaran Penyedia', 'Dokumen Surat Penawaran Penyedia 2024', '', 'https://drive.google.com/file/d/11_L3FC4Kx2j3Hqipn2x7B3bU9XnpvZFF/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:55:27'),
(986, 1, 7, 'Berita Acara Pemberian Penjelasan', 'Dokumen Berita Acara Pemberian Penjelasan 2024', '', 'https://drive.google.com/file/d/16bmOPBrEGLTUMw-EC2RFVUT0xGEXaiQz/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:56:53'),
(987, 1, 7, 'Berita Acara Penetapan atau Pengumuman Pemenang Pemilihan', 'Dokumen Berita Acara Penetapan atau Pengumuman Pemenang Pemilihan 2024', '', 'https://drive.google.com/file/d/1rYLg4koHK61clxCW4qAvlWGlqhE3K5ZA/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:58:24'),
(988, 1, 7, 'Berita Acara Hasil Pemilihan Penyedia', 'Dokumen Berita Acara Hasil Pemilihan Penyedia 2024', '', 'https://drive.google.com/file/d/1SGgk1BX7HTO1XB-lzhpZK01TBG9uynQM/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 10:59:21'),
(989, 1, 7, 'Surat Penunjukkan Penyedia Barang Jasa', 'Dokumen Surat Penunjukkan Penyedia Barang Jasa (SPPBJ) 2024', '', 'https://drive.google.com/file/d/1XltdjleDvL8IVU2FCwg_4VsufgQgKNEN/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:00:26'),
(990, 1, 7, 'Surat Perjanjian Kemitraan', 'Dokumen Surat Perjanjian Kemitraan 2024', '', 'https://drive.google.com/file/d/1029XKxdcVnNbGKRqx1hm83mky6iLbrs2/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:01:10'),
(991, 1, 7, 'SPK/ Kontrak', 'Dokumen SPK/ Kontrak 2024', '', 'https://drive.google.com/file/d/1ojjSZ44grRRRSydFZAjGvRm3hwvpiMlD/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:02:20'),
(992, 1, 7, 'Surat Perintah Mulai Kerja', 'DOkumen Surat Perintah Mulai Kerja (SPMK) 2024', '', 'https://drive.google.com/file/d/1vbjxsmvV30jkS2OqOnDodNu2I3WzgtF9/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:03:06'),
(993, 1, 7, 'Surat Jaminan Pelaksanaan', 'Dokumen Surat Jaminan Pelaksanaan 2024', '', 'https://drive.google.com/file/d/18gR138tKjpbF5wAUyPOQ76s4Z23u4n6P/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:03:50'),
(994, 1, 7, 'Surat Jaminan Uang Muka', 'Dokumen Surat Jaminan Uang Muka 2024', '', 'https://drive.google.com/file/d/1NY3UtBggwO-qzFut5v7ru2jmV3k_z3EM/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:04:35'),
(995, 1, 7, 'Surat Jaminan Pemeliharaan', 'Dokumen Surat Jaminan Pemeliharaan 2024', '', 'https://drive.google.com/file/d/1ei69OyDGIf60NjUAtZej9N6Jv-j8FJBm/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:05:18'),
(996, 1, 7, 'Surat Pesanan E-Purchasing', 'Dokumen Surat Pesanan E-Purchasing 2024', '', 'https://drive.google.com/file/d/19bhfWJ64eQgOYUqdkvDzHSIcF6FBb8vh/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:06:10'),
(997, 1, 7, 'Surat Perintah Membayar', 'Dokumen Surat Perintah Membayar (SPM) 2024', '', 'https://drive.google.com/file/d/1KKA9SDoDdwm03Lnkzu9j9FLik9_Z683V/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:06:59'),
(998, 1, 7, 'Surat Perintah Pencairan Dana', 'Dokumen Surat Perintah Pencairan Dana (SP2D) 2024', '', 'https://drive.google.com/file/d/1xcndW2ja9nniXfucKPcovZmenyZVcevX/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-07 11:07:44'),
(1003, 1, 7, 'PAKET 1 PENINGKATAN JALAN DAK (NON TEMATIK) TAHUN 2024', 'PAKET 1 PENINGKATAN JALAN DAK (NON TEMATIK) TAHUN 2024', '', 'https://drive.google.com/file/d/1KiO3VBZoIIl_8lED48vuACGC-k4rNHOo/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-10 11:33:45'),
(1004, 1, 7, 'PAKET 2. PENINGKATAN JALAN DAK (TEMATIK) 2024', 'PAKET 2. PENINGKATAN JALAN DAK (TEMATIK) 2024', '', 'https://drive.google.com/file/d/1CBhULKwXkGKMwBP0tbVPinJH7nx1rrF6/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-10 11:34:29'),
(1005, 1, 3, 'Indeks Kepuasan Masyarakat 2024', 'Berisi Informasi Survei Kepuasan Masyarakat terhadap pelayanan Dinas Perikanan', 'ikm_2024_gabung_semester_i_ii_ttd_pj.pdf', '', '198506022010012036', '730720', 0, '2025-02-11 08:09:59'),
(1006, 4, 5, 'LAPORAN PPID TAHUN 2024', 'LAPORAN PPID TAHUN 2024', 'laporan_ppid_2024.pdf', '', '199910022022031005', '730714', 1, '2025-02-11 10:09:14'),
(1007, 4, 10, 'SK PPID 2024', 'SK PPID 2024', '', 'https://drive.google.com/file/d/1mDyc2C6l18Cl-LXl1Nbqfsw7JLinazGL/view', '199910022022031005', '730714', 0, '2025-02-11 11:45:53'),
(1008, 4, 10, 'Perbup Sistem Kerja 2023 kab. Sinjai', 'Perbup Sistem Kerja 2023 kab. Sinjai', '', 'https://drive.google.com/file/d/1n6nYeenW2U4XK2oAiYOfnpwDqLfBllIs/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-11 12:44:13'),
(1009, 4, 10, 'Peraturan Bupati TPP 2022 ', 'Perauran Bupati TPP 2022 ', '', 'https://drive.google.com/file/d/19A98-RDZDHdRY9Q8CzcPNgkUt09sFaDE/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-11 12:59:12'),
(1010, 1, 4, 'Daftar Aset dan Investasi', 'Daftar Aset dan Investasi', '', 'https://drive.google.com/drive/folders/13B3JEctkkN4LBgZlbi54e14yuD1RrMVi?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-12 11:22:54'),
(1011, 1, 10, 'Draf Rancangan Peraturan Daerah  ', 'Draf Rancangan Peraturan Daerah  ', 'KIP_(1).pdf', '', '199910022022031005', '730714', 3, '2025-02-12 11:47:18'),
(1012, 1, 4, 'Kebijakan Anggaran Umum (KUA) 2024', 'Kebijakan Anggaran Umum (KUA) 2024', '', 'https://drive.google.com/file/d/1VCTYYVxgPZ1XTh7oufWSONMgzMK2DSsk/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-12 12:01:18'),
(1013, 1, 4, 'Prioritas Pagu Anggaran Sementara (PPAS) 2024', 'Prioritas Pagu Anggaran Sementara (PPAS) 2024', '', 'https://drive.google.com/file/d/1YPbmv7x5_RnEDSQJVvI9YY92Af3s_dkO/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-12 12:01:46'),
(1014, 1, 4, 'Ringkasan DPA PPKD 2024', 'Ringkasan DPA PPKD 2024', '', 'https://drive.google.com/file/d/1gCS8RX8A2VqPk_SG8fuHkXUlybY2-55t/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-12 12:02:19'),
(1015, 1, 4, 'Ringkasan DPA SKPD 2024', 'Ringkasan DPA SKPD 2024', '', 'https://drive.google.com/file/d/1x_cHBqx8a3z2S36JV5AGzPA18icpbUgC/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-12 12:02:50'),
(1016, 1, 4, 'Ringkasan RKA PPKD 2024', 'Ringkasan RKA PPKD 2024', '', 'https://drive.google.com/file/d/1PeQprOmwJ7Jc8-jqODztIiqHbKPjGNIR/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-12 12:03:20'),
(1017, 1, 4, 'Ringkasan RKA SKPD 2024', 'Ringkasan RKA SKPD 2024', '', 'https://drive.google.com/file/d/1P5xCk2Ac9jh5wL7HAPC8_7gZHbKHeq1k/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-12 12:03:57'),
(1018, 1, 4, 'Informasi Peraturan Daerah tentang Perubahan APBD Tahun 2024', 'Informasi Peraturan Daerah tentang Perubahan APBD Tahun 2024', '', 'https://drive.google.com/file/d/1zeeZRund8ViGReE5MXGxvT501qfP3beH/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-13 09:20:58'),
(1020, 1, 4, 'Informasi Peraturan Daerah tentang APBD Tahun 2024', 'Informasi Peraturan Daerah tentang APBD Tahun 2024', '', 'http://bkad.sinjaikab.go.id/wp-content/uploads/2024/10/Peraturan-Daerah-Nomor-4-Tahun-2023-tentang-APBD-TA-2024.pdf', '199910022022031005', '730714', 0, '2025-02-17 09:56:06'),
(1021, 1, 3, 'Surat Pengantar Evaluasi Kerjsama Tahun 2024', 'Surat Pengantar Evaluasi Kerjsama Tahun 2024', 'Surat_Pengantar_Evaluasi_Kerjsama_Tahun_2024.pdf', '', '199910022022031005', '730714', 2, '2025-02-17 10:28:19'),
(1022, 4, 3, 'Penyampaian Kegiatan Pada Musrembang 2024', 'Penyampaian Kegiatan Pada Musrembang 2024', '', 'https://drive.google.com/drive/u/0/folders/1hdtGSc-TtYcpCnHX10hklfb3k-n0Nfjg', '199910022022031005', '730714', 0, '2025-02-17 10:46:46'),
(1023, 1, 10, 'Draf Rancangan Peraturan Daerah', 'Draf Rancangan Peraturan Daerah', 'DAFTAR_RANCANGAN_DAN_TAHAP_PEMBENTUKAN_PERATURAN_PERUNDANG_.pdf', '', '199910022022031005', '730714', 10, '2025-02-18 10:40:30'),
(1024, 4, 6, 'Tindak Lanjut dugaan hasil pengawasan', 'Tindak Lanjut dugaan hasil pengawasan', 'Tindak_Lanjut_dugaan_hasil_pengawasan.pdf', '', '199910022022031005', '730714', 8, '2025-02-18 10:45:26'),
(1026, 4, 6, 'laporan penanganan pengaduan', 'laporan penanganan pengaduan', '', 'https://drive.google.com/file/d/12X3GmCbc6mbtn5OGgvVNJ2e0oBaLMCJ_/view?usp=sharing', '199910022022031005', '730714', 0, '2025-02-18 10:50:23'),
(1027, 4, 0, 'Indek Kepuasan Masyarakat (IKM)', 'Indek Kepuasan Masyarakat (IKM)', '', 'https://drive.google.com/drive/folders/1686lI6FrjyQbWi4VEfd6WUEN2uoCbu0X', '199910022022031005', '730714', 0, '2025-02-18 12:10:18'),
(1028, 4, 1, 'Profil Lengkap Pimipinan Seluruh OPD Kabupaten Sinjai', 'Profil Lengkap Pimipinan Seluruh OPD Kabupaten Sinjai', '', 'https://drive.google.com/drive/u/3/folders/1c3WJb8W06wL0WDDAf-evlkHFV64NebOC', '199910022022031005', '730714', 0, '2025-02-19 10:17:49'),
(1029, 4, 0, 'Surat Menyurat Pimpinan 2022 - 2024 ', 'Surat Menyurat Pimpinan 2022 - 2024 ', '', 'https://drive.google.com/drive/u/3/folders/1Y1dK0uYywtkB82LYiBXorQhQdMPI0_D4', '199910022022031005', '730714', 0, '2025-02-20 12:22:19'),
(1030, 1, 10, 'Naskah Akademik Tahun 2024', 'Naskah Akademik Tahun 2024', 'Naska_Akademik_Tahun_2024.pdf', '', '199910022022031005', '730714', 2, '2025-02-20 12:25:37'),
(1031, 1, 4, 'Realisasi PAD Diskan Tahun 2024', 'Berisi Target dan Realissi Pendapatan Asli Daerah  Dinas Perikanan TA. 2024', 'CamScanner_03-01-2025_11_12_compressed.pdf', '', '198506022010012036', '730720', 0, '2025-02-21 08:58:44'),
(1032, 1, 3, 'Renja Diskan 2025', 'Berisi Informasi Rencana Kerja Dinas perikanan Tahun 2025', 'RENJA_DISKAN_2025.pdf', '', '198506022010012036', '730720', 0, '2025-02-21 09:08:15'),
(1033, 1, 3, 'RKT Diskan 2025', 'Berisi Informasi Rencana Kerja Tahunan Diskan Tahun 2025', 'RKT_DISKAN_2025.docx', '', '198506022010012036', '730720', 1, '2025-02-21 09:10:49'),
(1034, 1, 4, 'Realisasi PAD Diskan Tahun 2020-2023', 'Berisi Informasi Target dan Realisasi PAD Diskan TA. 2020 - 2023', 'ilovepdf_merged_(2).pdf', '', '198506022010012036', '730720', 1, '2025-02-21 09:18:26'),
(1035, 4, 3, 'Risalah Rapat Pembentuan Peraturan ', 'Risalah Rapat Pembentuan Peraturan Daerah', '', 'https://drive.google.com/file/d/1bfdFUi170uEPsxgymSj2T5bFLiwZ18pj/view', '199910022022031005', '730714', 0, '2025-02-21 09:43:58'),
(1036, 4, 3, 'Masukan Pembentukan Rapat Peraturan Daerah', 'Masukan Pembentukan Rapat Peraturan Daerah', '', 'https://drive.google.com/file/d/1WJ5EodEOleX2oVetu1VCCPsxTq1Cjyk_/view', '199910022022031005', '730714', 0, '2025-02-21 09:47:24'),
(1037, 1, 3, 'REKAPAN PERIZINAN BERUSAHA DAN NON BERUSAHA TAHUN 2024', 'BERISI TENTANG REKAPAN PERIZINAN BERUSAHA DAN NON BERUSAHA TAHUN 2024', '', 'https://drive.google.com/file/d/1kUqGCybjOijGHBQoLeAIXigcVwNzpESj/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-02-21 11:22:05'),
(1038, 1, 2, 'Brosur Potensi dan Peluang Investasi ', 'Berisi Tentang Brosur Potensi dan Peluang Investasi ', '', 'https://drive.google.com/file/d/1zvJ9_YQxFSPYZQdrDBG4Fz-torLYbtE9/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-02-21 11:24:59'),
(1039, 1, 1, 'STRUKTUR ORGANISASI', 'BERISI TENTANG STRUKTUR ORGANISASI', '', 'https://drive.google.com/file/d/1i04wQ2feFvw_pAFriyeClv1mG1BaHcsp/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-02-21 11:49:00'),
(1040, 1, 0, 'MoU DLHK dengan Jasa Raharja Putra', 'Berisi tentang Mou Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai dengan Jasa Raharja Putra tentang Asuransi Public Liability bagi wisatawan pada kawasan pariwisata alam yang dikelola oleh Pemerintah Daerah Kab.Sinjai', 'MOU_DLHK_DENGAN_JASARAHARJA_PUTRA_.pdf', '', '199601232022032009', '730731', 0, '2025-02-21 16:11:42'),
(1041, 1, 3, 'LAPORAN PENYELENGGARAAN PTSP TW IV 2024', 'BERISI TENTANG LAPORAN PENYELENGGARAAN PTSP TW IV 2024', '', 'https://drive.google.com/file/d/1r-zBKolKqB9qoPQj0TKrgME5Jh5Xtfgh/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-02-24 08:47:00'),
(1042, 1, 4, 'Laporan Kemajuan fiskeu des 2024', 'Berisi Tentang Laporan Kemajuan fiskeu des 2024', '', 'https://drive.google.com/file/d/1FoqPcVqC0go5r4B2J49ZppaFIBSKVy1d/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-02-24 08:48:11'),
(1043, 1, 2, 'DPMPTSP_RENJA 2025', 'BERISI TENTANG RENJA 2025', '', 'https://drive.google.com/file/d/1Ouc1BjTNBAnzgAM845G9lo1LhwzU35hb/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-02-24 08:49:23'),
(1044, 6, 10, 'SK. PPID Disdukcapil Tahun 2025', 'Pengelola Informasi dan Dokumentasi', '', 'https://drive.google.com/drive/u/0/folders/1JKhAWDjrHNMyIxlcJlPxE3iOk84V45iQ', '197709272006041003', '730726', 0, '2025-02-24 10:09:40'),
(1045, 1, 3, 'Rekapan perizinan berusaha tahun 2023 acc', 'Berisi Tentang Rekapan perizinan berusaha tahun 2023 ', '', 'https://drive.google.com/file/d/1xGP6gJycd4Lq5WxhfDMbl3_zcK---JUP/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-02-24 10:22:19'),
(1046, 1, 2, 'Kalender Kegiatan ', 'Agenda Penyusunan Dokumen Perencanaan Tahun 2025', 'Agenda_Penyusunan_Dokumen_Perencanaan_Tahun_2025.xlsx', '', '199910022022031005', '730714', 4, '2025-02-25 09:36:52'),
(1047, 1, 2, 'Capaian program dan kegiatan', 'EVALUASI RPJMD', '', 'https://drive.google.com/file/d/1edjqDATflxXzrRhpVakc6X64-MUlhRbc/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-25 09:41:47'),
(1048, 4, 3, 'Laporan SKM Tahun 2024', 'Indeks Kepuasan Masyarakat', '', 'https://drive.google.com/drive/u/0/folders/1JKhAWDjrHNMyIxlcJlPxE3iOk84V45iQ', '197709272006041003', '730726', 0, '2025-02-25 09:41:58'),
(1049, 1, 2, 'RKA Perubahan 2024', 'Berisi Program dan Kegiatan', '', 'https://drive.google.com/drive/u/0/folders/1JKhAWDjrHNMyIxlcJlPxE3iOk84V45iQ', '197709272006041003', '730726', 0, '2025-02-25 09:48:20'),
(1050, 5, 10, 'SK PPID Diskan Tahun 2025', 'Berisi Informasi SK Kegiatan PPID 2025', 'SK_PPID_2025_compressed_(1).pdf', '', '198506022010012036', '730720', 0, '2025-02-26 09:47:12'),
(1051, 5, 10, 'SK Pengelola Website Diskan Tahun 2025', 'Berisi Informasi SK Pengelola Website Diskan Tahun 2025', 'SK_Web_Diskan_2025_compressed.pdf', '', '198506022010012036', '730720', 0, '2025-02-26 09:48:10'),
(1052, 1, 7, 'Spefifikasi Teknis', 'DOkumen Spesifikasi Teknis', '', 'https://drive.google.com/file/d/1q8Nib0GbihvRONx8cLkNEplN-WzuX8Dx/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-26 10:16:03'),
(1053, 1, 7, 'Dokumen Persyaratan Proses Pemilihan atau Lembar Data Pemilihan', 'Dokumen Persyaratan Proses Pemilihan atau Lembar Data Pemilihan', '', 'https://drive.google.com/file/d/1qAtLBZ4f7LPTzY39YhyBo7aGI37BFLl4/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-26 10:17:53'),
(1054, 1, 7, 'Laporan Pelaksanaan Pekerjaan', 'DOkumen Laporan Pelaksanaan Pekerjaan', '', 'https://drive.google.com/file/d/1rmxhmNkcXMupdkxX8fHLL554YFMjg7qU/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-26 10:18:47'),
(1055, 1, 7, 'Laporan Penyelesaian Pekerjaan', 'DOkumen Laporan Penyelesaian Pekerjaan', '', 'https://drive.google.com/file/d/1qBQqAxew0bX2cRXuuyOpareYwblDQEe3/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-26 10:19:43'),
(1056, 1, 7, 'Berita Acara Pemeriksaan Hasil Pekerjaan', 'Dokumen Berita Acara Pemeriksaan Hasil Pekerjaan', '', 'https://drive.google.com/file/d/1rmqyz0-FnzBMxVsu5zAJpllzFzg7WVDj/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-02-26 10:20:30'),
(1057, 2, 10, 'HIMBAUAN POTENSI ANCAMAN BENCANA', 'HIMBAUAN POTENSI ANCAMAN BENCANA 2024', 'HIMBAUAN_POTENSI_ANCAMAN_BENCANA_2024.pdf', '', '198401192009041002', '730710', 0, '2025-02-26 10:58:58'),
(1058, 2, 10, 'SK SIAGA BENCANA HIDROMETEOROLOGI 2024', 'SK SIAGA BENCANA HIDROMETEOROLOGI 2024', 'SK_SIAGA_BENCANA_HIDROMETEOROLOGI_2024.pdf', '', '198401192009041002', '730710', 0, '2025-02-26 11:00:27'),
(1059, 4, 10, 'SK Dikecualikan 2025', 'SK Dikecualikan 2025', '', 'https://drive.google.com/file/d/19Fz2nCT75HJZivH7uFweXvWarfgftS5K/view?usp=drive_link', '199910022022031005', '730714', 0, '2025-02-26 11:00:50'),
(1060, 2, 10, 'SK STATUS SIAGA DARURAT BENCANA BANJIR, TANAH LONGSOR DAN ANGIN KENCANG 2024', 'SK STATUS SIAGA DARURAT BENCANA BANJIR, TANAH LONGSOR DAN ANGIN KENCANG 2024', 'SK_STATUS_SIAGA_DARURAT_BENCANA_BANJIR,_TANAH_LONGSOR_DAN_ANGIN_KENCANG_2024.pdf', '', '198401192009041002', '730710', 0, '2025-02-26 11:01:43'),
(1061, 5, 10, 'SK PPID BPBD 2024', 'SK PPID BPBD 2024', 'SK_PPID_2024_compressed.pdf', '', '198401192009041002', '730710', 0, '2025-02-26 11:08:16'),
(1062, 2, 10, 'SK PPID BPBD 2024', 'SK PPID BPBD 2024', 'SK_PPID_2024_compressed1.pdf', '', '198401192009041002', '730710', 0, '2025-02-26 11:09:57'),
(1063, 1, 2, 'Jadwal pelaksanaan program dan kegiatan', 'Jadwal pelaksanaan program dan kegiatan', 'Agenda_Penyusunan_Dokumen_Perencanaan_Tahun_2025_(3).xlsx', '', '199910022022031005', '730714', 5, '2025-02-26 15:40:25'),
(1064, 4, 7, 'Inventaris Barang Milik Daerah tahun 2023', 'Inventaris Barang Milik Daerah tahun 2023', '2023.pdf', '', '199910022022031005', '730714', 2, '2025-03-03 09:23:34'),
(1065, 4, 7, 'Inventaris Barang Milik Daerah tahun 2024', 'Inventaris Barang Milik Daerah tahun 2024', '2024.pdf', '', '199910022022031005', '730714', 2, '2025-03-03 09:24:29'),
(1066, 1, 1, 'Standar Biaya', 'Standar Biaya', 'Standar_Biaya.pdf', '', '199910022022031005', '730714', 1, '2025-03-03 09:53:12'),
(1067, 1, 5, 'Lembar Pengujian Konsekuensi', 'Lembar Pengujian Konsekuensi', 'Lembar_Pengujian_Konsekuensi.pdf', '', '199910022022031005', '730714', 0, '2025-03-03 10:16:12'),
(1068, 1, 5, 'Berita Acara Rapat Pengujian Konsekuensi', 'Berita Acara Rapat Pengujian Konsekuensi', 'Berita_Acara_Rapat_Pengujian_Konsekuensi.pdf', '', '199910022022031005', '730714', 1, '2025-03-03 10:21:27'),
(1069, 1, 10, 'SK PPID DPMPTSP TAHUN 2025', 'BERISI TENTANG SK PPID DPMPTSP TAHUN 2025', '', 'https://drive.google.com/file/d/1qq9x4ByriBRtd4u5SKeICllVzXSjOL9a/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-03-06 10:26:29'),
(1070, 1, 10, 'KEPUTUSAN BUPATI SINJAI NOMOR 826 TAHUN 2024 TENTANG PENGESAHAN DOKUMEN PELAKSANAAN ANGGARAN SATUAN KERJA PERANGKAT DAERAH DINAS KESEHATAN KABUPATEN SINJAI TAHUN ANGGARAN 2025', 'KEPUTUSAN BUPATI SINJAI NOMOR 826 TAHUN 2024 TENTANG PENGESAHAN DOKUMEN PELAKSANAAN ANGGARAN SATUAN KERJA PERANGKAT DAERAH DINAS KESEHATAN KABUPATEN SINJAI TAHUN ANGGARAN 2025', 'SK_DPA_2025_DINKES_SINJAI_compressed.pdf', '', '197707242003122006', '730728', 0, '2025-03-06 11:25:47'),
(1072, 1, 7, 'Dokumen Persyaratan Penyedia atau Lembar Data Kualifikasi', 'Dokumen Persyaratan Penyedia atau Lembar Data Kualifikasi Tahun 2024', '', 'https://drive.google.com/file/d/1s8Hjrnwqkspuopejg04buiCk7gefpj23/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-03-14 10:46:18'),
(1073, 1, 7, 'Berita Acara Klarifikasi dan Verifikasi Data Kualifikasi', 'DOkumen Berita Acara Klarifikasi dan Verifikasi Data Kualifikasi Tahun 2024', '', 'https://drive.google.com/file/d/1s8Hjrnwqkspuopejg04buiCk7gefpj23/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-03-14 10:47:43'),
(1074, 1, 7, 'Surat Perjanjian Swakelola', 'Dokumen Surat Perjanjian Swakelola Tahun 2024', '', 'https://drive.google.com/file/d/1sRvHbSWGFtdjA2jbKiy0D2sEABRElZJi/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-03-14 10:48:35'),
(1075, 1, 7, 'Surat Tagihan', 'Dokumen Surat Tagiha Tahun 2024', '', 'https://drive.google.com/file/d/1sB1X8azUzhukMwldBXctIeNkD2BywDEB/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-03-14 10:49:18'),
(1076, 1, 7, 'Laporan Pelaksanaan Pekerjaan', 'Dokumen Pelaksanaan Pekerjaan Tahun 2024', '', 'https://drive.google.com/file/d/1s9575YSnNUT8gSvdozZXj7rDg476ZLEs/view?usp=drivesdk', '199508122022032011', '730724', 0, '2025-03-14 10:50:06'),
(1077, 1, 10, 'SK PPID RSUD SINJAI TAHUN 2025', 'SK PPID RSUD SINJAI TAHUN 2025', 'SK_PPID_TAHUN_2025_11zon.pdf', '', '197707242003122006', '730728', 0, '2025-03-21 10:42:13'),
(1079, 1, 3, '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN JANUARI TAHUN 2025', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN JANUARI TAHUN 2025', '202501_10_Besar_Penyakit_Terbanyak1.pdf', '', '197707242003122006', '730728', 0, '2025-03-24 08:41:56'),
(1080, 1, 3, '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN FEBRUARI TAHUN 2025', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN FEBRUARI TAHUN 2025', '202502_10_Besar_Penyakit_Terbanyak.pdf', '', '197707242003122006', '730728', 0, '2025-03-25 08:13:57'),
(1081, 2, 3, 'DATA JUMLAH PENGGUNA LAYANAN MPP KAB.SINJAI TAHUN 2024', 'BERISI TENTANG DATA JUMLAH PENGGUNA LAYANAN MPP KAB.SINJAI TAHUN 2024', '', 'https://drive.google.com/file/d/1q702AvdiiK5NdOwCiQh5ApUI4SXa_z9u/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-03-25 11:06:18'),
(1082, 2, 3, 'DATA JUMLAH PENGGUNA LAYANAN MPP BULAN FEBRUARI TAHUN 2025', 'BERISI TENTANG DATA JUMLAH PENGGUNA LAYANAN MPP BULAN FEBRUARI TAHUN 2025', '', 'https://drive.google.com/file/d/1XTZPY3jYylPhss7_TPgzNFbAQw8bP094/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-03-25 11:07:14'),
(1083, 1, 3, '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN MARET TAHUN 2025', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN MARET TAHUN 2025', '10_BESAR_PENYAKIT_TERBANYAK_RAWAT_INAP_BULAN_MARET.pdf', '', '197707242003122006', '730728', 0, '2025-04-11 09:57:31'),
(1084, 4, 0, 'Rencana Kerja', 'Rencana Kerja Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai Tahun 2025', '', 'https://drive.google.com/file/d/1SAVldHXg26FgR0XKKwaW-BdzDaNmn5eS/view?usp=drive_link', '199601232022032009', '730731', 0, '2025-04-17 12:19:20'),
(1085, 1, 2, 'UPT RSUD SINJAI LAKSANAKAN MONEV MANRISK TRIWULAN IV TAHUN 2024', 'UPT RSUD SINJAI LAKSANAKAN MONEV MANRISK TRIWULAN IV TAHUN 2024', '', 'https://rsudsinjai.com/detailpost/upt-rsud-sinjai-laksanakan-monev-manrisk-triwulan-iv-tahun-2024', '197707242003122006', '730728', 0, '2025-04-19 07:53:50'),
(1086, 1, 2, 'RSUD SINJAI ADAKAN PENYULUHAN 13 PESAN DASAR PEDOMAN UMUM GIZI SEIMBANG PUGS UNTUK KESEHATAN OPTIMAL', 'RSUD SINJAI ADAKAN PENYULUHAN 13 PESAN DASAR PEDOMAN UMUM GIZI SEIMBANG PUGS UNTUK KESEHATAN OPTIMAL', '', 'https://rsudsinjai.com/detailpost/rsud-sinjai-adakan-penyuluhan-13-pesan-dasar-pedoman-umum-gizi-seimbang-pugs-untuk-kesehatan-optimal', '197707242003122006', '730728', 0, '2025-04-19 08:14:27'),
(1087, 1, 2, 'DIREKTUR UPT RSUD SINJAI DAN JAJARANYA MENYAMBUT TIM KAJI BANDING DARI RSUD KABUPATEN BUTON PROVINSI SULAWESI TENGGARA', 'DIREKTUR UPT RSUD SINJAI DAN JAJARANYA MENYAMBUT TIM KAJI BANDING DARI RSUD KABUPATEN BUTON PROVINSI SULAWESI TENGGARA', '', 'https://www.instagram.com/p/DInpOecyH0v/?img_index=2&igsh=czk2bmdsd2drYWU1', '197707242003122006', '730728', 0, '2025-04-23 09:07:06'),
(1088, 1, 3, 'LAPORAN PENYELENGGARAAN MAL PELAYANAN PUBLIK BULAN MARET', 'BERISI LAPORAN TENTANG PENYELENGGARAAN MAL PELAYANAN PUBLIK BULAN MARET', '', 'https://drive.google.com/file/d/1NdlwWl_n9-EjrEyWiBbbLhOjHGU8eJKb/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-04-24 09:19:00'),
(1089, 1, 4, 'LAPORAN KEMAJUAN KEUANGAN DAN FISIK DESEMBER 2024', 'LAPORAN KEMAJUAN KEUANGAN DAN FISIK DESEMBER 2024', 'LAPORAN_KEMAJUANKEUANGAN_DAN_FISIK_DESEMBER_2024.pdf', '', '197707242003122006', '730728', 0, '2025-04-28 08:18:32'),
(1090, 1, 1, 'MAKLUMAT PELAYANAN RSUD SINJAI', 'MAKLUMAT PELAYANAN RSUD SINJAI', '', 'https://ppid.sinjaikab.go.id/front/dokumen/detail/400272071', '197707242003122006', '730728', 0, '2025-04-29 10:09:24'),
(1091, 1, 2, 'SEKERTARIS DAERAH KABUPATEN SINJAI, BESERTA KETUA DWP KAB. SINJAI TURUT HADIR MERIAHKAN HARI ULANG TAHUN UPT RSUD SINJAI KE 43 TAHUN', 'SEKERTARIS DAERAH KABUPATEN SINJAI, BESERTA KETUA DWP KAB. SINJAI TURUT HADIR MERIAHKAN HARI ULANG TAHUN UPT RSUD SINJAI KE 43 TAHUN', '', 'https://www.instagram.com/p/DJRNqc5ytNr/?igsh=cGlqZjR3dWpuaDE2', '197707242003122006', '730728', 0, '2025-05-06 08:46:57'),
(1093, 1, 10, 'SK JENIS LAYANAN RSUD SINJAI TAHUN 2025', 'SK JENIS LAYANAN RSUD SINJAI TAHUN 2025', 'SK_JENIS_LAYANAN_2025.pdf', '', '197707242003122006', '730728', 0, '2025-05-08 09:46:34'),
(1094, 1, 2, '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN APRIL TAHUN 2025', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN APRIL TAHUN 2025', '10_Penyakit_terbanyak_Bulan_april.pdf', '', '197707242003122006', '730728', 0, '2025-05-15 08:28:16'),
(1095, 1, 2, 'Hasil Rekapan Survei Indeks Kepuasan Masyarakat RSUD Sinjai Semester II Tahun 2024 ', 'Hasil Rekapan Survei Indeks Kepuasan Masyarakat RSUD Sinjai Semester II Tahun 2024 mendapatkan nilai 81,71 dengan predikat B (Baik)\r\n\r\nAdapun unsur-unsur aspek indeks kepuasan masyarakat, yaitu :\r\n1.    Persyaratan Pelayanan\r\n2.    Prosedur Pelayanan\r\n3.    Waktu Pelayanan\r\n4.    Biaya/tarif Pelayanan\r\n5.    Produk Spesifikasi Jenis pelayanan\r\n6.    Kompetensi Pelaksana Pelayanan\r\n7.    Perilaku Pelaksana Pelayanan\r\n8.    Penanganan Pengaduan, Saran dan Masukan\r\n9.    Sarana dan Prasarana Pelayanan', '', 'https://rsudsinjai.com/detailpost/hasil-survei-ikm-rumah-sakit-umum-daerah-sinjai-semester-ii-tahun-2024', '197707242003122006', '730728', 0, '2025-05-16 13:17:16'),
(1096, 1, 2, 'UPT RSUD SINJAI ASPIRASI PEMBERIAN JAMINAN KEMATIAN BPJS KETENAGAKERJAAN', 'UPT RSUD SINJAI ASPIRASI PEMBERIAN JAMINAN KEMATIAN BPJS KETENAGAKERJAAN', '', 'https://www.instagram.com/p/DJ9R9-NTtB9/?img_index=1&igsh=MW95Yzh1ajltcTdzNQ==', '197707242003122006', '730728', 0, '2025-05-26 10:20:30'),
(1097, 1, 3, 'Laporan Pengaduan Triwulan 1 Tahun 2025', 'Laporan Pengaduan Triwulan 1 Tahun 2025', 'Laporan_Pengaduan_Triwulan_I_Tahun_2025.pdf', '', '197707242003122006', '730728', 0, '2025-05-28 12:49:04'),
(1098, 1, 2, '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN MEI TAHUN 2025', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN MEI TAHUN 2025', '10_Besar_penyakit_terbanyak_bulan_Mei_Tahun_2025.pdf', '', '197707242003122006', '730728', 0, '2025-06-05 11:08:40'),
(1099, 1, 2, 'KASUBAG UMUM DAN KEPEGAWAIAN  UPT RSUD SINJAI HADIRI RAPAT KOORDINASI PERSIAPAN LOMBA DESA TINGKAT PROVINSI SULSEL TAHUN 2025', 'KASUBAG UMUM DAN KEPEGAWAIAN  UPT RSUD SINJAI HADIRI RAPAT KOORDINASI PERSIAPAN LOMBA DESA TINGKAT PROVINSI SULSEL TAHUN 2025', '', 'https://www.facebook.com/share/19EFpRZCGY/', '197707242003122006', '730728', 0, '2025-06-12 10:10:43'),
(1101, 1, 10, 'KEPUTUSAN DIREKTUR UPT RUMAH SAKIT UMUM DAERAH KABUPATEN SINJAI NOMOR 15 TAHUN 2025', 'STANDAR PELAYANAN PUBLIK\r\nUPT RUMAH SAKIT UMUM DAERAH SINJAI', 'SPP_2025_merged-11.pdf', '', '197707242003122006', '730728', 0, '2025-06-17 11:58:15'),
(1102, 1, 3, 'LKJ TAHUN 2024', 'LAPORAN KINERJA TAHUN ANGGARAN 2024', 'LKJ_TAHUN_2024.pdf', '', '197707242003122006', '730728', 1, '2025-06-18 08:36:56'),
(1103, 1, 2, 'PERJANJIAN KINERJA TAHUN 2024', 'PERJANJIAN KINERJA\r\nUPT RSUD SINJAI PADA DINAS KESEHATAN\r\nTAHUN ANGGARAN 2024', 'PERJANJIAN_KINERJA_2024.pdf', '', '197707242003122006', '730728', 0, '2025-06-26 08:46:49'),
(1104, 1, 2, 'RSUD SINJAI MENDUKUNG PENUH PENERAPAN PERDA ANTI ROKOK', 'RSUD SINJAI MENDUKUNG PENERAPAN PERDA ANTI ROKOK', '', 'https://www.instagram.com/p/DLbWHMlTFeg/?igsh=cWp6NHhpcjBoajd2', '197707242003122006', '730728', 0, '2025-07-02 09:19:51'),
(1105, 1, 4, 'LRA', 'Laporan Realisasi Anggaran Untuk Tahun yang berakhir sampai dengan 31 Desember 2024 dan 2023', 'SCAN_LK_BLUD_RSUD_SINJAI_AUDITED_KAP_2024_FIX(1).pdf', '', '197707242003122006', '730728', 0, '2025-07-03 09:32:05'),
(1106, 1, 3, '10 BESAR PENYAKIT TERBANYAK', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN JUNI TAHUN 2025', '10_Besar_penyakit_terbanyak_bulan_juni.pdf', '', '197707242003122006', '730728', 0, '2025-07-14 09:23:44'),
(1107, 1, 2, 'PERJANJIAN KINERJA TAHUN 2025', 'DOKUMEN PERJANJIAN KINERJA TAHUN ANGGARAN 2025', 'PERJANJIAN_KINERJA_2025.pdf', '', '197707242003122006', '730728', 0, '2025-07-17 12:30:33'),
(1108, 1, 3, 'RENJA TAHUN 2025', 'RENCANA KERJA TAHUN ANGGARAN 2025', 'DOKUMEN_RENJA_TA_2025.pdf', '', '197707242003122006', '730728', 0, '2025-07-23 13:28:57'),
(1109, 1, 5, 'Dokumen Pelaksanaan Anggaran', 'Dokumen Anggaran 2019, 2020, 2021, 2022, 2023', '', 'https://disparbud.sinjaikab.go.id/web/2023/07/dokumen-anggaran/', '198104272005022006', '730746', 0, '2025-07-31 15:54:30'),
(1110, 1, 5, 'SK Tenaga Sukarela', 'SK Tenaga Sukarela Tahun 2018, 2019, 2020, 2021, 2022, 2023, 2024, dan 2025.', '', 'https://disparbud.sinjaikab.go.id/web/2025/04/sk-tenaga-sukarela/', '198104272005022006', '730746', 0, '2025-07-31 16:00:00'),
(1112, 1, 2, 'https://www.instagram.com/p/DMxftkOyE1Z/?igsh=MmE4ZGlpMzhpOGNv', 'SEKERTARIS DAERAH KABUPATEN SINJAI HADIRI RAPAT KOORDINASI PERSIAPAN AVALUASI ZONA INTEGRITAS UPT RSUD SINJAI', '', 'https://www.instagram.com/p/DMxftkOyE1Z/?igsh=MmE4ZGlpMzhpOGNv', '197707242003122006', '730728', 0, '2025-08-07 07:58:49'),
(1115, 1, 2, 'Inovasi terbaru UPT RSUD Sinjai Syifa On Care', 'Kini telah hadir inovasi terbaru dari Rumah Sakit Umum Daerah Sinjai “Syifa On Care”. Sistem Farmasi Antar Obat Nyaman, Cepat, Aman, Responsif, Efisien.', '', 'https://www.instagram.com/p/DNFEr-bTEHq/?igsh=bmJubGVhYjB2YmJ5', '197707242003122006', '730728', 0, '2025-08-12 09:55:43'),
(1116, 1, 2, 'WOW, ADA \"BINTANG KE SINJAI\" DI LAPPA PAGI TADI !!! YUK, KITA INTIP AKSINYA', '“BINTANG KE SINJAI\" atau Basmi Stunting dengan Pendampingan Intensif Puskesmas dan RSUD Sinjai merupakan salah satu inovasi yang diluncurkan oleh RSUD Sinjai dalam rangka penurunan prevelensi stunting dan wasting di Kabupaten Sinjai. Inovasi ini memiliki beberapa program salah satunya adalah Home Visit atau Kunjungan Rumah pada pasien stunting yang dilakukan oleh Tim Penurunan Prevalensi Stunting dan Wasting RSUD Sinjai.', '', 'https://www.facebook.com/share/p/1YKnLykQs6/', '197707242003122006', '730728', 0, '2025-08-19 11:07:27'),
(1117, 1, 3, '10 BESAR PENYAKIT TERBANYAK ', '10 BESAR PENYAKIT TERBANYAK RAWAT INAP DAN RAWAT JALAN BULAN JULI TAHUN 2025', '10_Besar_penyakit_terbanyak_bulan_juli.pdf', '', '197707242003122006', '730728', 0, '2025-08-21 08:52:21'),
(1118, 1, 3, 'UPT RSUD SINJAI RAIH PRESTASI DI AJANG TEMU NASIONAL AKREDITASI RUMAH SAKIT ( TERAS III ) TAHUN 2025', 'UPT RSUD SINJAI RAIH PRESTASI DI AJANG TEMU NASIONAL AKREDITASI RUMAH SAKIT ( TERAS III ) TAHUN 2025', '', 'https://www.instagram.com/p/DNsMOhi5i-3/?igsh=MXdkb3lmY29taTV3eA==', '197707242003122006', '730728', 0, '2025-08-26 09:17:19'),
(1119, 1, 2, 'https://www.instagram.com/p/DONYa_Nk5ka/?igsh=c2V2NGo4bjlvZnlk', 'UPT RSUD SINJAI MENGGELAR PERTEMUAN TENTANG DATA ASPAK TAHUN 2025', '', 'https://www.instagram.com/p/DONYa_Nk5ka/?igsh=c2V2NGo4bjlvZnlk', '197707242003122006', '730728', 0, '2025-09-09 08:16:32'),
(1120, 1, 2, 'https://www.instagram.com/reel/DOD56vGkwQg/?igsh=NXZoaGlkOWw0b3l4', 'FORUM KONSULTASI PUBLIK UPT RSUD Sinjai Tahun 2025', '', 'https://www.instagram.com/reel/DOD56vGkwQg/?igsh=NXZoaGlkOWw0b3l4', '197707242003122006', '730728', 0, '2025-09-09 08:22:11'),
(1123, 1, 4, 'Neraca 2024', 'Neraca 2024', '', 'https://drive.google.com/file/d/1alDQJVk4JwoIPZLNKEtB1kWbTKivjXku/view', '199910022022031005', '730714', 0, '2025-09-12 10:58:49'),
(1124, 1, 4, 'LRA Pemda Sinjai Audited 2024', 'LRA Pemda Sinjai Audited 2024', '', 'https://drive.google.com/file/d/1rDAFTzd6THlzHTWLdIUumjnFWpWK4zWv/view', '199910022022031005', '730714', 0, '2025-09-12 11:01:36'),
(1125, 1, 4, 'LAK Pemda Sinjai Audited 2024', 'LAK Pemda Sinjai Audited 2024', '', 'https://drive.google.com/file/d/1VAKsXzqcSu8vEC3qDZsS0OQQsHduoYX_/view', '199910022022031005', '730714', 0, '2025-09-12 11:04:10'),
(1126, 1, 2, 'https://www.instagram.com/p/DOvlnDNk1Ya/?igsh=aHdpOXB3dHVxbjY=', 'AKSI TIM \"BINTANG KE SINJAI\" DALAM DEMO MPASI BERSAMA DWP UNIT RSUD SINJAI', '', '    https://www.instagram.com/p/DOvlnDNk1Ya/?igsh=aHdpOXB3dHVxbjY=', '197707242003122006', '730728', 0, '2025-09-19 13:23:43'),
(1127, 1, 5, 'Data Pemakaian Kamar Penginapan Se Kabupaten Sinjai', 'Berisikan Data Pemakaian Kamar Penginapan Se Kabupaten Sinjai mulai tahun 2017 dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2025/09/jumlah-pemakaian-kamar-penginapan-se-kabupaten-sinjai/', '198104272005022006', '730746', 0, '2025-09-19 14:54:08'),
(1128, 1, 5, 'Data Pengunjung dan PAD Objek Wisata Kabupaten Sinjai', 'Berisikan data pengunjung dan PAD objek wisata Kabupaten Sinjai mulai tyahun 2018 dan tersinkronisasi dengan data website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2025/09/data-pengunjung-dan-pad-objek-wisata-kabupaten-sinjai-2/', '198104272005022006', '730746', 0, '2025-09-19 14:56:33'),
(1129, 1, 5, 'Dokumen Kinerja DISPARBUD', 'Berisikan Dokumen Kinerja DISPARBUD Kabupaten Sinjai mulai tahun 2017 dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2025/01/dokumen-laporan-kinerja/', '198104272005022006', '730746', 0, '2025-09-19 14:58:08'),
(1130, 1, 5, 'SK Tenaga Sukarela DISPARBUD Kabupaten Sinjai', 'Berisikan SK Tenaga Sukarela DISPARBUD Kabupaten Sinjai mulai tahun 2018 dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2025/04/sk-tenaga-sukarela/', '198104272005022006', '730746', 0, '2025-09-19 15:01:35'),
(1131, 1, 5, 'SK POKDARWIS Se Kabupaten Sinjai', 'Berisikan SK POKDARWIS Se Kabupaten Sinjai mulai tahun 2015 dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2025/05/daftar-pokdarwis-se-kabupaten-sinjai/', '198104272005022006', '730746', 0, '2025-09-19 15:03:21'),
(1132, 1, 5, 'Data Sanggar Seni Se Kab. Sinjai', 'Berisikan Data Sanggar Seni Se Kabupaten Sinjai dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2025/05/data-sanggar-se-kab-sinjai-2/', '198104272005022006', '730746', 0, '2025-09-19 15:05:41'),
(1133, 1, 5, 'Daftar SK Penetapan Cagar Budaya Kab. Sinjai', 'Berisikan Daftar SK Penetapan Cagar Budaya Se Kabupaten Sinjai dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2023/07/daftar-sk-penetapan-cagar-budaya-kab-sinjai/', '198104272005022006', '730746', 0, '2025-09-19 15:08:48'),
(1135, 1, 5, 'Dokumen Pelaksanaan Anggaran', 'Berisikan Dokumen Pelaksanaan Anggaran (DPA) DISPARBUD Kabupaten Sinjai dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2023/07/dokumen-anggaran/', '198104272005022006', '730746', 0, '2025-09-22 09:27:54'),
(1136, 1, 5, 'Kekayaan Intelektual Komunal (KIK) Kabupaten Sinjai', 'Berisikan Kekayaan Intelektual Komunal (KIK) Kabupaten Sinjai dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/2022/05/kekayaan-intelektual-komunal-kik/', '198104272005022006', '730746', 0, '2025-09-22 09:33:51'),
(1137, 1, 10, 'SK NO 06 TAHUN 2025 TENTANG PEMBENTUKAN TIM PELAKSANA KEGIATAN PENYEDIAAN DAN PENGELOLAAN LAYANAN KONSULTASI SERTA PENGELOLAAN PENGADUAN MASYARAKAT', 'BERISI TENTANG SK NO 06 TAHUN 2025 TENTANG PEMBENTUKAN TIM PELAKSANA KEGIATAN PENYEDIAAN DAN PENGELOLAAN LAYANAN KONSULTASI SERTA PENGELOLAAN PENGADUAN MASYARAKAT', '', 'https://drive.google.com/file/d/1syCIMTFiw8OkCtq4mu4pcpfKa5niMsPx/view?usp=sharing', '197109211992031006', '730712', 0, '2025-09-23 09:04:58');
INSERT INTO `dok_data` (`dok_id`, `kategori_id`, `jenis_id`, `dok_nama`, `dok_deskripsi`, `dok_file`, `dok_url`, `nip`, `unit_id`, `dok_count`, `dok_created`) VALUES
(1138, 1, 10, 'SK NO 07 TAHUN 2025 TENTANG PENUNJUKAN PETUGAS PENGELOLA PENGADUAN', 'BERISI TENTANG SK NO 07 TAHUN 2025 TENTANG PENUNJUKAN PETUGAS PENGELOLA PENGADUAN', '', 'https://drive.google.com/file/d/1T65Z2kRxT4QDQGQPMXKRcRNqjUjNxyJE/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-09-23 09:05:54'),
(1139, 1, 2, 'DAFTAR REKAPITULASI DAN TINDAK LANJUT PENGADUAN PELAYANAN PERIZINAN,PERIZINAN BERUSAHA DAN NON PERIZINAN', 'BERISI TENTANG DAFTAR REKAPITULASI DAN TINDAK LANJUT PENGADUAN PELAYANAN PERIZINAN,PERIZINAN BERUSAHA DAN NON PERIZINAN', '', 'https://drive.google.com/file/d/1FbKFO-np_GXFdTTpFtttupakmAO9Uann/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-09-24 08:26:15'),
(1140, 1, 2, 'IKM SEMESTER 1 TAHUN 2025', 'BERISI TENTANG IKM SEMESTER 1 TAHUN 2025', '', 'https://drive.google.com/file/d/1jEChwp3VL-7wSQZMuvNl3oDYJ2pUX6nb/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-09-24 08:27:12'),
(1141, 1, 2, 'LAPORAN HASIL TINDAK LANJUT IKM TAHUN 2024', 'BERISI TENTANG LAPORAN HASIL TINDAK LANJUT IKM TAHUN 2024', '', 'https://drive.google.com/file/d/1pKVrfvHF0TElbeEPJaKZ-IzSz-T9oQzc/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-09-24 08:28:12'),
(1142, 1, 3, 'HASIL SURVEI INDEKS KEPUASAN MASYARAKAT UPT. RUMAH SAKIT UMUM DAERAH SINJAI TAHUN 2025 SEMESTER I', 'HASIL SURVEI INDEKS KEPUASAN MASYARAKAT\r\nUPT. RUMAH SAKIT UMUM DAERAH SINJAI TAHUN 2025 SEMESTER I\r\nHasil Rekapan Survei Indeks Kepuasan Masyarakat UPT. Rumah Sakit Umum Daerah Sinjai Semester Tahun 2025 mendapatkan Nilai 83,29 dengan predikat B (BAIK). ', 'WhatsApp_Image_2025-09-24_at_13_36_08(2).jpeg', '', '197707242003122006', '730728', 0, '2025-09-25 08:22:45'),
(1143, 6, 5, 'Daftar Informasi Publik 2024', 'Daftar Informasi Publik 2024', 'DIP_2023.pdf', '', '199910022022031005', '730714', 4, '2024-12-16 12:00:38'),
(1144, 1, 3, 'LAPORAN FISKEU AGUSTUS', 'BERISI TENTANG LAPORAN FISIK DAN LAPORAN KEUANGAN BULAN AGUSTUS TAHUN 2025', '', 'https://drive.google.com/file/d/1E5Xu-9qp7vIRemSjnLk-VSnp08lcBXlO/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-09-29 08:31:02'),
(1145, 1, 3, 'SURVEI KEPUASAN MASYARAKAT SEMESTER 1', 'BERISI TENTANG SURVEI KEPUASAN MASYARAKAT SEMESTER 1', '', 'https://drive.google.com/file/d/1Q-YxG5dXCrtwLrnP1FOAO2eGyMhphlZ4/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-09-29 08:32:06'),
(1146, 1, 2, '10 BESAR PENYAKIT TERBANYAK RSUD SINJAI', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN AGUSTUS TAHUN 2025', '10_Besar_penyakit_terbanyak_RJ_RI_bulan_Agustus.pdf', '', '197707242003122006', '730728', 1, '2025-09-29 09:30:10'),
(1148, 1, 3, 'Perjanjian Kinerja', 'Perjanjian Kinerja', '', 'https://drive.google.com/file/d/1efvR0tuNv1LmzrvmDjU3W2gqTI1ubRhm/view?usp=sharing', '199910022022031005', '730714', 0, '2025-10-02 11:51:11'),
(1149, 1, 0, 'SURVEI KEPUASAN MASYARAKAT SEMESTER I', 'Hasil Survei Kepuasan Masyarakat Dinas Lingkungan Hidup dan Kehutanan Kab.Sinjai Semester I Tahun 2025 Mendapatkan Nilai 80,92 dengan Kategori  B (Baik)', '', 'https://drive.google.com/file/d/1iQQSMlWEDKrqr0zrzNN1ZwzP4ynV5Txh/view?usp=sharing', '197909292007012009', '730731', 0, '2025-10-03 10:18:59'),
(1150, 1, 3, 'Perjanjian Kinerja Tahun 2025', 'Perjanjian Kinerja', '', 'https://drive.google.com/file/d/13kGaiAnRmg7kzBQmyblECpVagtfnpJzl/view?usp=sharing', '197909292007012009', '730731', 0, '2025-10-03 10:21:05'),
(1151, 1, 3, 'LAPORAN REALISASI IZIN DAN PAD TAHUN 2023', 'BERISI TENTANG LAPORAN REALISASI IZIN DAN PAD TAHUN 2023', '', 'https://drive.google.com/file/d/1JOwvx0MUP3yeXhyCNKa3WtbXPBnUaPJr/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-10-06 09:37:30'),
(1152, 1, 3, 'LAPORAN REALISASI IZIN DAN PAD TAHUN 2024', 'BERISI TENTANG LAPORAN REALISASI IZIN DAN PAD TAHUN 2024', '', 'https://drive.google.com/file/d/1sdkoqYzunaGoZs0azIusInpIYfhf53u1/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-10-06 09:38:37'),
(1153, 5, 3, 'SK DIP TAHUN 2024', 'SK DIP TAHUN 2024', 'DIP_Tahun_2024.pdf', '', '199910022022031005', '730714', 4, '2024-01-15 11:16:41'),
(1157, 5, 3, 'SK DIP Tahun 2024 Pemutakhiran', 'SK DIP Tahun 2024 Pemutakhiran', 'DIP_2024_pemutakhiran2.pdf', '', '199910022022031005', '730714', 1, '2024-01-15 12:08:07'),
(1158, 5, 3, 'SK DIP Tahun 2024 Berkala Ke Setiap Saat', 'SK DIP Tahun 2024 (Berkala Ke Setiap Saat)', 'DIP_OPD_berkala_jadi_setiap_saat1.pdf', '', '199910022022031005', '730714', 1, '2024-01-15 12:09:58'),
(1159, 1, 2, 'RAD PUG dan RAD KLA', 'RAD PUG dan RAD KLA', '', 'https://drive.google.com/drive/u/2/folders/1uGl2d6tarESk0r4K6c7Wxk756d6DEENk', '199910022022031005', '730714', 0, '2025-10-06 12:31:57'),
(1160, 1, 2, 'RKA dan DPA Diskominfo 2024', 'RKA dan DPA Diskominfo 2024', '', 'https://drive.google.com/drive/u/2/folders/18Lk-O7y2qW11PTjnND9Lg7mZiRa2WyJ9', '199910022022031005', '730714', 0, '2025-10-06 12:40:39'),
(1161, 1, 3, 'LAPORAN REALISASI IZIN DAN PAD TAHUN 2024', 'LAPORAN REALISASI IZIN DAN PAD TAHUN 2024', 'LAPORAN_REALISASI_IZIN_DAN_PAD_TAHUN_2024.pdf', '', '199910022022031005', '730714', 1, '2025-10-06 12:42:42'),
(1162, 4, 10, 'Risalah Tahun 2022 sampai 2024', 'Risalah Tahun 2022 - 2024', '', 'https://drive.google.com/drive/u/2/folders/1EIqL5IzfXPqn3sLrhaSk0fJaE4465mHN', '199910022022031005', '730714', 0, '2025-10-06 15:18:37'),
(1163, 4, 10, 'draft Ranperda Olahraga 2023', 'draft Ranperda Olahraga 2023', '', 'https://drive.google.com/file/d/18rIsSyB3fTKuePMzY3Qh4Krt14WaQMqK/view', '199910022022031005', '730714', 0, '2025-10-06 15:24:02'),
(1164, 4, 10, 'Naskah Akademik Tahun 2022 sampai 2024', 'Naskah Akademik Tahun 2022 -2024', '', 'https://drive.google.com/drive/u/2/folders/1afuQwj_9kPQwnpsH2G5v72Eing2EP7Ok', '199910022022031005', '730714', 0, '2025-10-06 15:29:28'),
(1166, 4, 2, 'Pembangunan Gedung Infection Center 2023 Paket 1', 'Pembangunan Gedung Infection Center 2023 (Paket 1)', '', 'https://drive.google.com/file/d/1UOrTasnkasa8CqmuCwe-RTc9duKSrIXw/view?usp=sharing', '199910022022031005', '730714', 0, '2025-10-07 11:46:03'),
(1168, 4, 2, 'Penataan Kawasan Alun-alun Sinjai Bersatu 2023 Paket 2', 'Penataan Kawasan Alun-alun Sinjai Bersatu 2023 (Paket 2)', '', 'https://drive.google.com/drive/u/2/my-drive?q=after:2025-10-07%20parent:0ACjiou3iHvrwUk9PVA', '199910022022031005', '730714', 0, '2025-10-07 11:50:21'),
(1172, 4, 2, 'PAKET 1 PENINGKATAN JALAN DAK NON TEMATIKTAHUN 2024', 'PAKET 1 PENINGKATAN JALAN DAK (NON TEMATIK) TAHUN 2024', '2024_Paket_1_Peningkatan_Jalan_(DAK)_Non_Tematik.pdf', '', '199910022022031005', '730714', 0, '2025-10-07 12:15:39'),
(1174, 4, 2, 'Paket 2 Peningkatan Jalan DAK Tematik', 'Paket 2 Peningkatan Jalan (DAK) Tematik', '', 'https://drive.google.com/file/d/1CBhULKwXkGKMwBP0tbVPinJH7nx1rrF6/view?usp=sharing', '199910022022031005', '730714', 0, '2025-10-07 12:18:32'),
(1175, 4, 2, 'Tata Kelola Diskominfo Tahun 2024 ', 'Tata Kelola Diskominfo Tahun 2024 ', '', 'https://drive.google.com/file/d/13VilHx-UT86LjhrzaV3LVphf4-swIUZA/view?usp=sharing', '199910022022031005', '730714', 0, '2025-10-07 12:22:50'),
(1177, 4, 6, 'LAPORAN TINDAK LANJUT PENGADUÁN TAHUN 2023', 'LAPORAN TINDAK LANJUT PENGADUÁN TAHUN 2023', 'LAPORAN_TINDAK_LANJUT_PENGADUÁN_TAHUN_20231.pdf', '', '199910022022031005', '730714', 0, '2025-10-08 09:13:08'),
(1178, 4, 6, 'RASIO TINDAK LANJUT PENYELESAIAN PENGADUAN MASYARAKAT', 'RASIO TINDAK LANJUT PENYELESAIAN PENGADUAN MASYARAKAT', 'RASIO_TINDAK_LANJUT_PENGADUAN.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 09:13:41'),
(1179, 5, 10, 'SK PPID BPBD 2025', 'SK PPID BPBD 2025', 'SK_PPID_BPBD_2025_compressed.pdf', '', '198401192009041002', '730710', 0, '2025-10-08 11:41:09'),
(1181, 4, 7, 'Jaminan Uang Muka', 'Jaminan Uang Muka ', 'Jaminan_Uang_Muka1.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:20:12'),
(1182, 4, 7, 'Surat Tagihan', 'Surat Tagihan', 'Surat_Tagihan.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:21:40'),
(1183, 4, 7, 'Surat Perintah Membayar', 'Surat Perintah Membayar', 'Surat_Perintah_Membayar.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:29:36'),
(1184, 4, 7, 'Surat Perintah Mulai Kerja', 'Surat Perintah Mulai Kerja', 'Surat_Perintah_Mulai_Kerja.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:30:21'),
(1185, 4, 7, 'Surat Perintah Pencairan Dana', 'Surat Perintah Pencairan Dana', 'Surat_Perintah_pencairan_dana.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:30:59'),
(1186, 4, 7, 'Surat Penunjukan Penyedia Barang dan Jasa  SPPBJ', 'Surat Penunjukan Penyedia Barang/Jasa ( SPPBJ )', 'Surat_SPPBJ.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:32:04'),
(1187, 4, 7, 'Surat Pernyataan Pemelihara', 'Surat Pernyataan Pemelihara', 'Surat_Pernyataan_Pemelihara.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:33:38'),
(1188, 4, 7, 'Laporan Pelaksanaan Pekerja  Poin 26 ', 'Laporan Pelaksanaan Pekerja ( Poin 26 )', 'Laporan_Pelaksanaan_Pekerjaan_(Poin_26).pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:34:26'),
(1189, 4, 7, 'Surat Jaminan Pelaksanaan', 'Surat Jaminan Pelaksanaan', 'Surat_Jaminan_Pelaksanaan.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:35:01'),
(1190, 4, 7, 'Surat Berita Acara Pemerikasaan Pekerjaan', 'Surat Berita Acara Pemerikasaan Pekerjaan', 'Surat_Berita_Acara_Pemeriksaan_Pekerjaan.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 14:36:03'),
(1191, 4, 7, 'Surat Berita Acara Pembayaran', 'Surat Berita Acara Pembayaran', 'Surat_Berita_Acara_Pembayaran.pdf', '', '199910022022031005', '730714', 0, '2025-10-08 14:36:48'),
(1192, 4, 7, 'Dokumen SPK Kontrak  Poin 18 ', 'Dokumen SPK Kontrak ( Poin 18 )', 'Dokumen_SPK_Kontrak_(Poin_18)-dikompresi.pdf', '', '199910022022031005', '730714', 3, '2025-10-08 14:38:33'),
(1193, 4, 7, 'Daftar Kuantitas Harga Arango I  poin 6 ', 'Daftar Kuantitas Harga Arango I ( poin 6 ) ', 'Daftar_Kuantitas_Harga__Arango_I_(Poin_6).pdf', '', '199910022022031005', '730714', 0, '2025-10-08 15:12:08'),
(1194, 4, 7, 'Jadwal Pelaksanaan sab data lokasi pekerjaan Paket Arango I Poin 7', 'Jadwal Pelaksanaan sab data lokasi pekerjaan Paket Arango I (Poin 7)', 'Jadwal_Pelaksanaan_sab_data_lokasi_pekerjaan_Paket_Arango_I_(Poin_7).pdf', '', '199910022022031005', '730714', 1, '2025-10-08 15:16:23'),
(1195, 4, 7, 'Dokumen Kualifikasi Manalohe 1', 'Dokumen Kualifikasi Manalohe 1', 'Dokumen_kualifikasi_MANALOHE_1-dikompresi.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 15:18:42'),
(1196, 4, 7, 'KAK D.I. Arango ', 'KAK D.I. Arango \r\n', '7__KAK_D_I__Arango_I.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 19:35:11'),
(1197, 4, 7, 'HPS Rencana Anggaran Biaya RAB Manalohe I', 'HPS Rencana Anggaran Biaya (RAB) Manalohe I', 'HPS_Rencana_Anggaran_Biaya_(RAB)_Manalohe_I.pdf', '', '199910022022031005', '730714', 2, '2025-10-08 19:37:33'),
(1198, 4, 7, 'SPESIFIKASI TEKNISREHAB IRIGASI MANALOHE I', 'SPESIFIKASI TEKNISREHAB IRIGASI MANALOHE I', 'SPESIFIKASI_TEKNISREHAB_IRIGASI_MANALOHE_I.pdf', '', '199910022022031005', '730714', 1, '2025-10-08 19:38:53'),
(1199, 4, 7, 'GAMBAR DED D I ARANGO', '2. GAMBAR DED D.I ARANGO', '', 'https://drive.google.com/file/d/1H9m-3_GHQ4eQEKFadougWGEXESc6PpBk/view?usp=sharing', '199910022022031005', '730714', 0, '2025-10-08 19:41:54'),
(1201, 2, 8, 'Surat Edaran Mitigasi Banjir dan Tanah Longsor 2025', 'Surat Edaran Mitigasi Banjir dan Tanah Longsor 2025', 'Surat_Edaran_Mitigasi_BAnjir_dan_Tanah_Longsor_2025.pdf', '', '198401192009041002', '730710', 0, '2025-10-09 10:17:28'),
(1202, 2, 10, 'SK STATUS TANGGAP DARURAT BENCANA HIDROMETEOROLOGI 2025', 'SK STATUS TANGGAP DARURAT BENCANA HIDROMETEOROLOGI 2025', 'SK_STATUS_TANGGAP_DARURAT_BENCANA_HIDROMETEOROLOGI_MEI_2025.pdf', '', '198401192009041002', '730710', 0, '2025-10-09 10:22:00'),
(1203, 2, 10, 'SK PERPANJANGAN STATUS TANGGAP DARURAT BENCANA HIDROMETEOROLOGI  2025', 'SK PERPANJANGAN STATUS TANGGAP DARURAT BENCANA HIDROMETEOROLOGI   2025', 'SK_PERPANJANGAN_STATUS_TANGGAP_DARURAT_BENCANA_HIDROMETEOROLOGI_MEI_2025.pdf', '', '198401192009041002', '730710', 0, '2025-10-09 10:24:46'),
(1204, 2, 10, 'SK Status Transisi Darurat ke Pemulihan 2025', 'SK Status Transisi Darurat ke Pemulihan 2025', 'SK_Status_Transisi_Darurat_ke_Pemulihan_(_JULI)_2025.pdf', '', '198401192009041002', '730710', 0, '2025-10-09 10:26:21'),
(1205, 1, 4, 'Laporan Realisasi PAD Dinas Perikanan September 2025', 'Laporan Realisasi PAD Dinas Perikanan September 2025', 'SPJ_Fumgsional_Bulan_September(2).pdf', '', '198506022010012036', '730720', 0, '2025-10-13 08:28:40'),
(1206, 1, 2, 'CALK AUDITED Dinas Perikanan Tahun 2024', 'CALK AUDITED Dinas Perikanan Tahun 2024', 'CALK_AUDITED_24_merged_compressed.pdf', '', '198506022010012036', '730720', 0, '2025-10-13 08:38:31'),
(1207, 1, 3, 'Perjanjian Kinerja Dinas Perikanan 2025', 'Perjanjian Kinerja Dinas Perikanan 2025', 'PK_Tahun_2025_Diskan_compressed_compressed_(2).pdf', '', '198506022010012036', '730720', 1, '2025-10-13 08:49:34'),
(1208, 1, 4, 'Laporan Kemajuan Fisik dan keuangan September 2025', 'Berisi Laporan Kemajuan Fisik dan keuangan Bulan September Dinas Perikanan 2025', 'Lap__Fisik_Keu_September.pdf', '', '198506022010012036', '730720', 0, '2025-10-13 08:54:35'),
(1209, 1, 4, 'Laporan Mutasi Persediaan Dinas Perikanan Tw III Tahun 2025', 'Berisi Laporan Mutasi Persediaan Triwulan III Dinas Perikanan Tahun 2025', 'Lap__Mutasi_Persediaan_September_compressed_(1).pdf', '', '198506022010012036', '730720', 0, '2025-10-13 09:01:47'),
(1210, 4, 9, 'Statistik Dinas Perikanan TA. 2020 2024 Book 1', 'Berisi laporan Statistik Dinas Perikanan TA. 2020 2024 Book 1', '1__BOOK_1_-_DRAFT_STATISTIK_PERIKANAN_KABUPATEN_SINJAI_TAHUN_2024.pdf', '', '198506022010012036', '730720', 0, '2025-10-13 09:31:58'),
(1211, 4, 9, 'Statistik Dinas Perikanan TA. 2020 2024 Book 2', 'Berisi Laporan Statistik Dinas Perikanan TA. 2020 2024 Book 2', '1__BOOk_2_DRAFT_STATISTIK_PERIKANAN_KABUPATEN_SINJAI_TAHUN_2024.pdf', '', '198506022010012036', '730720', 0, '2025-10-13 09:33:13'),
(1212, 1, 3, 'SK Pengelola PPID Tahun 2025', 'SK Pengelola PPID Tahun 2025 Dinas Perikanan', 'SK_PPID_TERBARU_2025.docx', '', '198506022010012036', '730720', 4, '2025-10-13 09:40:14'),
(1213, 1, 3, 'SK Pengelola Website Pemda Tahun 2025 ', 'Berisi SK Pengelola Website Pemda Tahun 2025 Dinas Perikanan', 'SK_Tim_Pengelola_Website_Pemda_2025.docx', '', '198506022010012036', '730720', 0, '2025-10-13 09:44:27'),
(1214, 1, 3, 'Capaian perjanjian Kinerja Kepala Dinas Tahun 2024', 'Berisi Laporan Capaian perjanjian Kinerja Kepala Dinas Tahun 2024 Dinas Perikanan', 'Capaian_PK_Kadis_2024.pdf', '', '198506022010012036', '730720', 0, '2025-10-13 15:14:37'),
(1215, 1, 3, 'LHE Inspektorat 2023', 'Laporan Hasil Evaluasi Akuntabilitas Kinerja Instansi Dinas Perikanan Pemerintah daerah Tahun 2023', 'LHE_Inspektorat_20241_compressed.pdf', '', '198506022010012036', '730720', 0, '2025-10-13 15:21:35'),
(1216, 1, 5, 'REGULASI', 'Berisikan Regulasi DISPARBUD Kabupaten Sinjai dan tersinkronisasi dengan website https://disparbud.sinjaikab.go.id/web/', '', 'https://disparbud.sinjaikab.go.id/web/regulasi/?customize_changeset_uuid=20b1a2ca-4211-475d-8e33-dd399d82ffc2', '198104272005022006', '730746', 0, '2025-10-15 08:26:32'),
(1217, 1, 2, 'https://www.facebook.com/share/p/1MLRUvGe5c/', 'Komitmen Tiada Henti, RSUD SINJAI Raih Penghargaan Faskes Berkomitmen Dalam Program JKN Tahun 2025 Tingkat Cabang Watampone', '', 'https://www.facebook.com/share/p/1MLRUvGe5c/', '197707242003122006', '730728', 0, '2025-10-16 08:46:29'),
(1218, 1, 3, 'DAFTAR REKAPITULASI DAN TINDAK LANJUT PENGADUAN PELAYANAN PERIZINAN,PERIZINAN BERUSAHA DAN NON PERIZINAN TRIWULAN I TAHUN 2025', 'BERISI TENTANG DAFTAR REKAPITULASI DAN TINDAK LANJUT PENGADUAN PELAYANAN PERIZINAN,PERIZINAN BERUSAHA DAN NON PERIZINAN TRIWULAN I TAHUN 2025', '', 'https://drive.google.com/file/d/1VAf6z6_PiIZfZSRIpY6_h2gC7AQGR5B9/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-10-30 09:03:13'),
(1219, 1, 3, 'DAFTAR REKAPITULASI DAN TINDAK LANJUT PENGADUAN PELAYANAN PERIZINAN,PERIZINAN BERUSAHA DAN NON PERIZINAN TRIWULAN II TAHUN 2025', 'BERISI TENTANG DAFTAR REKAPITULASI DAN TINDAK LANJUT PENGADUAN PELAYANAN PERIZINAN,PERIZINAN BERUSAHA DAN NON PERIZINAN TRIWULAN II TAHUN 2025', '', 'https://drive.google.com/file/d/1Kbsc4teeV7ibooaRxRZj0nNdmSmrbyCk/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-10-30 09:05:59'),
(1220, 1, 3, 'DAFTAR REKAPITULASI DAN TINDAK LANJUT PENGADUAN PELAYANAN PERIZINAN,PERIZINAN BERUSAHA DAN NON PERIZINAN TRIWULAN III TAHUN 2025', 'BERISI TENTANG DAFTAR REKAPITULASI DAN TINDAK LANJUT PENGADUAN PELAYANAN PERIZINAN,PERIZINAN BERUSAHA DAN NON PERIZINAN TRIWULAN III TAHUN 2025', '', 'https://drive.google.com/file/d/1Vfxzj3S_zSFS2zw2eMa9yRo-IGuXcT9l/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-10-30 09:07:24'),
(1221, 1, 2, 'https://www.instagram.com/p/DQEoSuyk1fA/?igsh=bWlwdXRmNjZ5OHQy', 'DIREKTUR UPT RSUD SINJAI HADIRI ZOOM MEETING EVALUASI AKUNTABILITAS KINERJA INSTANSI PEMERINTAH TAHUN 2025\r\n', '', 'https://www.instagram.com/p/DQEoSuyk1fA/?igsh=bWlwdXRmNjZ5OHQy', '197707242003122006', '730728', 0, '2025-10-30 09:20:23'),
(1223, 1, 2, 'Rencana Pembangunan Jangka Menengah Daerah  Tahun 2025 2029 Kabupaten Sinjai  ', 'RPJMD 2025 2029 Kabupaten Sinjai', '', 'https://drive.google.com/file/d/1Y6q5C7Hmru3PaB45Jj9VYQwB_cqTW3Pt/view', '199910022022031005', '730714', 0, '2025-11-11 09:22:57'),
(1224, 1, 2, 'https://www.facebook.com/share/p/17DmGeZZUN/', 'PENYUSUNAN TARIF RUMAH SAKIT, UPT RSUD SINJAI MENGHADIRKAN BAGIAN HUKUM SETDAKAB SINJAI', '', 'https://www.facebook.com/share/p/17DmGeZZUN/', '197707242003122006', '730728', 0, '2025-11-17 09:25:29'),
(1225, 1, 3, '10 BESAR PENYAKIT TERBANYAK BULAN SEPTEMBER TAHUN 2025', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP RSUD SINJAI BULAN SEPTEMBER TAHUN 2025', '202509_10_Besar_Penyakit_Terbanyak.pdf', '', '197707242003122006', '730728', 0, '2025-11-17 11:47:40'),
(1226, 1, 2, '10 BESAR PENYAKIT TERBANYAK BULAN OKTOBER TAHUN 2025', '10 BESAR PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP BULAN OKTOBER TAHUN 2025', '202510_10_Besar_penyakit_Terbanyak.pdf', '', '197707242003122006', '730728', 0, '2025-11-21 09:30:21'),
(1227, 1, 3, 'LAPORAN PELAKSANAAN SURVEI KEPUASAN MASYARAKAT TAHAP 1 TAHUN 2025', 'BERISI TENTANG LAPORAN PELAKSANAAN SURVEI KEPUASAN MASYARAKAT TAHAP 1 TAHUN 2025', '', 'https://drive.google.com/file/d/1hrjyXkZPd4s7XAOPIAp4Q9skTH59uovN/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-11-24 09:16:46'),
(1228, 1, 3, 'LAPORAN PELAKSANAAN SURVEY KEPUASAN MASYARAKAT TAHAP II TAHUN 2025', 'BERISI TENTANG LAPORAN PELAKSANAAN SURVEY KEPUASAN MASYARAKAT TAHAP II TAHUN 2025', '', 'https://drive.google.com/file/d/16p4_fp6oy__8xzVDOmK_WXG2eQTdW9ox/view?usp=drive_link', '197109211992031006', '730712', 0, '2025-11-24 09:17:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dok_galeri`
--

CREATE TABLE `dok_galeri` (
  `galeri_id` int NOT NULL,
  `nm_galeri` varchar(256) NOT NULL,
  `url_galeri` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dok_galeri`
--

INSERT INTO `dok_galeri` (`galeri_id`, `nm_galeri`, `url_galeri`) VALUES
(1, 'PENDAMOINGAN PENGINPUTAN DATA PPID', 'WhatsApp_Image_2021-08-24_at_12_17_57.jpeg'),
(2, 'PENDAMPINGAN PENGINPUTAN DATA PPID', 'IMG-20220425-WA0029.jpg'),
(3, 'PENDAMPINGAN PENGINPUTAN DATA PPID', 'WhatsApp_Image_2021-08-24_at_12_19_27.jpeg'),
(4, 'PENDAMPINGAN PENGINPUTAN DATA PPID', 'WhatsApp_Image_2021-08-26_at_12_24_09.jpeg'),
(5, '', 'WhatsApp_Image_2021-08-30_at_09_35_32.jpeg'),
(6, 'PENDAMPINGAN PENGINPUTAN DATA PPID', 'WhatsApp_Image_2021-08-30_at_09_40_18.jpeg'),
(7, 'PENDAMPINGAN PENGINPUTAN DATA PPID', 'WhatsApp_Image_2022-08-04_at_11_01_43_(3).jpeg'),
(8, 'PENDAMPINGAN PENGINPUTAN DATA PPID', 'WhatsApp_Image_2022-04-06_at_10_26_00_(2).jpeg'),
(9, '', 'WhatsApp_Image_2022-04-06_at_10_26_00_(1).jpeg'),
(10, '', 'WhatsApp_Image_2022-04-06_at_10_26_00_(3).jpeg'),
(11, '', 'WhatsApp_Image_2022-04-06_at_10_26_00.jpeg'),
(12, '', 'WhatsApp_Image_2022-06-07_at_11_38_10_(1).jpeg'),
(13, '', 'WhatsApp_Image_2022-06-07_at_11_38_10_(2).jpeg'),
(14, '', 'WhatsApp_Image_2022-02-10_at_11_46_38.jpeg'),
(15, '', 'WhatsApp_Image_2021-09-03_at_12_06_03.jpeg'),
(16, '', 'WhatsApp_Image_2021-09-03_at_12_06_02.jpeg'),
(17, 'PEMBERIAN FORMOLIR ', 'WhatsApp_Image_2021-09-21_at_09_44_03.jpeg'),
(19, '', 'WhatsApp_Image_2021-08-24_at_12_20_04.jpeg'),
(27, 'Ruangan Pelayanan Informasi PPID Kabupaten Sinjai', 'WhatsApp_Image_2022-08-15_at_13_49_48.jpeg'),
(28, 'RUANGAN PPID', 'WhatsApp_Image_2021-09-21_at_11_12_13.jpeg'),
(29, 'Jalur Khusus Disabilitas PPID Kab.Sinjai', 'FRAME-PPID_01.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dok_laporan`
--

CREATE TABLE `dok_laporan` (
  `laporan_id` int NOT NULL,
  `nm_laporan` varchar(256) NOT NULL,
  `url_laporan` text NOT NULL,
  `url_sampul` text NOT NULL,
  `tahun` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dok_laporan`
--

INSERT INTO `dok_laporan` (`laporan_id`, `nm_laporan`, `url_laporan`, `url_sampul`, `tahun`) VALUES
(1, 'LAPORAN TAHUNAN 2019', 'LAPORAN_PPID_2019.pdf', 'sampul_2019.PNG', 2019),
(2, 'LAPORAN TAHUNAN 2020', 'LAPORAN_PPID_2020.pdf', 'sampul_2020.PNG', 2020),
(3, 'LAPORAN TAHUNAN 2021', 'LAPORAN_PPID_2021.pdf', 'sampul_2021.PNG', 2021),
(4, 'LAPORAN TAHUNAN 2022 ', 'PPID_Laporan_Tahunan_20221.pdf', 'sampul_2022.PNG', 2022),
(9, 'Laporan PPID ', 'laporan_ppid_20243.pdf', 'Cover_2024.png', 2024);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_data`
--

CREATE TABLE `jenis_data` (
  `jenis_id` int NOT NULL,
  `jenis_nama` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_data`
--

INSERT INTO `jenis_data` (`jenis_id`, `jenis_nama`) VALUES
(1, 'Profil Badan Publik'),
(2, 'Program dan Kegiatan'),
(3, 'Informasi Kinerja'),
(4, 'Laporan Keuangan'),
(5, 'Laporan dan Prosedur Akses Informasi'),
(6, 'Pengaduan dan Pelanggaran'),
(7, 'Pengadaan Barang dan Jasa'),
(8, 'Informasi Darurat'),
(9, 'Hasil Penelitian'),
(10, 'Regulasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_data`
--

CREATE TABLE `kategori_data` (
  `kategori_id` int NOT NULL,
  `kategori_nama` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori_data`
--

INSERT INTO `kategori_data` (`kategori_id`, `kategori_nama`) VALUES
(1, 'Informasi Berkala'),
(2, 'Informasi Serta Merta'),
(3, 'Daftar Informasi Dikecualikan'),
(4, 'Tersedia Setiap Saat'),
(5, 'Kebijakan'),
(6, 'Dasar Informasi Publik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keberatan_data`
--

CREATE TABLE `keberatan_data` (
  `keberatan_id` int NOT NULL,
  `permohonan_id` int NOT NULL,
  `email` int NOT NULL,
  `nm_kuasa_pemohon` int NOT NULL,
  `alamat_kuasa_pemohon` int NOT NULL,
  `keberatan_alasan` int NOT NULL,
  `hp_kuasa_pemohon` int NOT NULL,
  `keberatan_ringkasan` int NOT NULL,
  `kasus_posisi` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lhkpn_data`
--

CREATE TABLE `lhkpn_data` (
  `lhkpn_id` int NOT NULL,
  `kategori_id` int NOT NULL,
  `nip` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `judul` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penerbit` varchar(84) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahun` int NOT NULL,
  `lhkpn_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `diupload_oleh` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lhkpn_count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `lhkpn_data`
--

INSERT INTO `lhkpn_data` (`lhkpn_id`, `kategori_id`, `nip`, `judul`, `penerbit`, `tahun`, `lhkpn_file`, `keterangan`, `diupload_oleh`, `tanggal_upload`, `lhkpn_count`) VALUES
(1, 1, '197007112006041001', 'Kepala Dinas Perpustakaan dan Arsip', 'Dinas Perpustakaan dan Kearsipan', 2023, 'LHKPN_ABDUL_AZIZ1.pdf', 'Kepala Dinas Perpustakaan dan Arsip', 'MUH. YUSRIL ABNI', '2025-03-05 09:48:41', 0),
(3, 1, '196912311990021008', 'LHKPN Kepala Dinas Perhubungan', 'Dinas Perhubungan', 2023, 'LHKPN_AKBAR1.pdf', 'LHKPN Kepala Dinas Perhubungan', 'MUH. YUSRIL ABNI', '2025-03-05 09:54:05', 0),
(4, 1, '197303121993031009', 'Kepala Badan Penelitian dan Pengembangan Daerah', 'Badan Penelitian dan Pengembangan Daerah ', 2024, 'LHKPN_ALAMSYAH_BAHAR.pdf', 'Kepala Badan Penelitian dan Pengembangan Daerah', 'MUH. YUSRIL ABNI', '2025-03-05 09:55:56', 0),
(5, 1, '197709052000031004', 'LHKPN Staf Ahli Bidang Sosial dan Sumber Daya Manusia', 'Sekretariat Daerah', 2023, 'LHKPN_ANDI_MANDASINI.pdf', 'LHKPN Staf Ahli Bidang Sosial dan Sumber Daya Manusia', 'MUH. YUSRIL ABNI', '2025-03-05 21:34:41', 0),
(6, 1, '197706242003122003', 'LHKPN Staf Ahli Bidang Ekonomi, Keuangan dan Pembangunan', 'Sekretariat Daerah', 2023, 'LHKPN_ANDI_TENRI_RAWE_BASO.pdf', 'LHKPN Staf Ahli Bidang Ekonomi, Keuangan dan Pembangunan', 'MUH. YUSRIL ABNI', '2025-03-05 21:39:41', 0),
(8, 1, '196512311998031039', 'LHKPN Kepala BPBD', 'Badan Penanggulangan Bencana Daerah', 2023, 'LHKPN_BUDIAMAN.pdf', 'LHKPN Kepala BPBD', 'MUH. YUSRIL ABNI', '2025-03-05 21:41:26', 0),
(9, 1, '196712251999031007', 'LHKPN Kepala Dinas Peternakan dan Kesehatan Hewan', 'Dinas Peternakan dan Kesehatan Hewan', 2023, 'LHKPN_BURHANUDDIN.pdf', 'LHKPN Kepala Dinas Peternakan dan Kesehatan Hewan', 'MUH. YUSRIL ABNI', '2025-03-05 21:42:03', 0),
(10, 1, '196603282002122002', 'LHKPN Kepala Dinas Kesehatan ×', 'Dinas Kesehatan', 2023, 'LHKPN_EMMY_KARTAHARA.pdf', 'LHKPN Kepala Dinas Kesehatan ×', 'MUH. YUSRIL ABNI', '2025-03-05 21:42:37', 0),
(11, 1, '197212281992022001', 'LHKPN Kepala Badan Perencanaan Pembangunan Daerah', 'Badan Perencanaan Pembangunan Daerah', 2023, 'LHKPN_HAERANI_DAHLAN.pdf', 'LHKPN Kepala Badan Perencanaan Pembangunan Daerah', 'MUH. YUSRIL ABNI', '2025-03-05 21:43:11', 0),
(12, 1, '197007122003121011', 'LHKPN Kepala Dinas Pekerjaan Umum dan Penataan Ruang', 'Dinas Pekerjaan Umum dan Penataan Ruang', 2023, 'LHKPN_HARIS_ACHMAD.pdf', 'LHKPN Kepala Dinas Pekerjaan Umum dan Penataan Ruang', 'MUH. YUSRIL ABNI', '2025-03-05 21:44:09', 0),
(13, 1, '196512311985032024', 'LHKPN Staf Ahli Bidang Hukum, Politik dan Pemerintahan', 'Sekretariat Daerah', 2023, 'LHKPN_HARIYANI_RASYID.pdf', 'LHKPN Staf Ahli Bidang Hukum, Politik dan Pemerintahan', 'MUH. YUSRIL ABNI', '2025-03-05 21:45:03', 0),
(14, 1, '196812121992031013', 'LHKPN Kepala Dinas Pemuda dan Olahraga', 'Dinas Pemuda dan Olahraga', 2023, 'LHKPN_HASIR_AHMAD.pdf', 'LHKPN Kepala Dinas Pemuda dan Olahraga', 'MUH. YUSRIL ABNI', '2025-03-05 21:46:04', 0),
(15, 1, '197308181994011001', 'LHKPN Kepala Dinas Sosial', 'Dinas Sosial', 2023, 'LHKPN_IDNAN.pdf', 'LHKPN Kepala Dinas Sosial', 'MUH. YUSRIL ABNI', '2025-03-05 21:47:03', 0),
(16, 1, '197801071996121002', 'LHKPN Asisten Pemerintahan dan Kesejahteraan Rakyat', 'Sekretariat Daerah', 2023, 'LHKPN_IRWANSYAHRANI.pdf', 'LHKPN Asisten Pemerintahan dan Kesejahteraan Rakyat', 'MUH. YUSRIL ABNI', '2025-03-05 21:47:58', 0),
(18, 1, '196902151997031010', 'Kepala Dinas tanaman Pangan Hortikultura dan Perkebunan', 'Dinas Tanaman Pangan, Holtikultura dan Perkebunan', 2023, 'LHKPN_KAMARUDDIN.pdf', 'Kepala Dinas tanaman Pangan Hortikultura dan Perkebunan', 'MUH. YUSRIL ABNI', '2025-03-05 21:49:37', 0),
(19, 1, '197209181993021002', 'LHKPN Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Aparatur', 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Aparatur', 2023, 'LHKPN_LUKMAN_MANNAN.pdf', 'LHKPN Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Aparatur', 'MUH. YUSRIL ABNI', '2025-03-05 21:50:19', 0),
(20, 1, '197202071996031002', 'LHKPN Kepala Dinas Komunikasi Informatika dan Persandian', 'Dinas Komunikasi Informatika dan Persandian', 2023, 'LHKPN_MANSYUR.pdf', 'LHKPN Kepala Dinas Komunikasi Informatika dan Persandian', 'MUH. YUSRIL ABNI', '2025-03-05 21:51:04', 0),
(21, 1, '197401121994121001', 'LHKPN Kepala Badan Kesatuan Bangsa dan Politik', 'Badan Kesatuan Bangsa dan Politik', 2023, 'LHKPN_MUH__AKBAR.pdf', 'LHKPN Kepala Badan Kesatuan Bangsa dan Politik', 'MUH. YUSRIL ABNI', '2025-03-05 21:51:46', 0),
(22, 1, '196505111996031002', 'LHKPN Kepala Dinas Perdagangan, Perindustrian dan Energi Sumber Daya Mineral', 'Dinas Perdagangan, Perindustrian dan Energi Sumber Daya Mineral', 2023, 'LHKPN_MUH__SALEH.pdf', 'LHKPN Kepala Dinas Perdagangan, Perindustrian dan Energi Sumber Daya Mineral', 'MUH. YUSRIL ABNI', '2025-03-05 21:52:48', 0),
(23, 1, '196812021994011001', 'LHKPN Kepala Dinas Koperasi Usaha Kecil Menengah dan Tenaga Kerja', 'Dinas Koperasi Usaha Kecil Menengah dan Tenaga Kerja', 2023, 'LHKPN_MUH_RAMHLAN_HAMID.pdf', 'LHKPN Kepala Dinas Koperasi Usaha Kecil Menengah dan Tenaga Kerja', 'MUH. YUSRIL ABNI', '2025-03-05 21:53:59', 0),
(25, 1, '197611142000031002', 'LHKPN Kepala Badan Pendapatan Daerah', 'Badan Pendapatan Daerah', 2023, 'LHKPN_ASDAR_AMAL.pdf', 'LHKPN Kepala Badan Pendapatan Daerah', 'MUH. YUSRIL ABNI', '2025-03-05 21:56:28', 0),
(26, 1, '196510071993031004', 'LHKPN Sekretaris DPRD Kab Sinjai', 'Sekretariat DPRD', 2023, 'LHKPN_SEKRETARIAT_DPRD.pdf', 'LHKPN Sekretaris DPRD Kab Sinjai', 'MUH. YUSRIL ABNI', '2025-03-05 21:57:21', 0),
(27, 1, '197906092010011007', 'LHKPN Kepala Dinas Lingkungan Hidup dan Kehutanan', 'Dinas Lingkungan Hidup dan Kehutanan', 2023, 'LHKPN_SOFWAN_SABIRIN.pdf', 'LHKPN Kepala Dinas Lingkungan Hidup dan Kehutanan', 'MUH. YUSRIL ABNI', '2025-03-05 21:58:13', 0),
(28, 1, '197312172000031004', 'LHKPN Kepala Dinas Perikanan', 'Dinas Perikanan', 2023, 'LHKPN_SYAMSUL_ALAM.pdf', 'LHKPN Kepala Dinas Perikanan', 'MUH. YUSRIL ABNI', '2025-03-05 21:58:51', 0),
(29, 1, '197306111993111002', 'LHKPN Kepala Dinas Pariwisata dan Kebudayaan', 'Dinas Pariwisata dan Kebudayaan', 2023, 'LHKPN_TAMZIL_BINAWAN.pdf', 'LHKPN Kepala Dinas Pariwisata dan Kebudayaan', 'MUH. YUSRIL ABNI', '2025-03-05 21:59:30', 0),
(30, 1, '197405091993021001', 'LHKPN Kepala Dinas Pemberdayaan Masyarakat dan Desa', 'Dinas Pemberdayaan Masyarakat dan Desa', 2024, 'LHKPN_YUHADI_SAMAD.pdf', 'LHKPN Kepala Dinas Pemberdayaan Masyarakat dan Desa', 'MUH. YUSRIL ABNI', '2025-03-05 22:00:08', 0),
(31, 1, '196705081987031007', 'LHKPN PJ.Bupati Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ANDI_JEFRIANTO_ASAPA.pdf', 'LHKPN PJ Bupati Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:06:49', 0),
(33, 1, '197501051993111001', 'LHKPN Inspektur Inspektorat Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ANDI_ADEHA_SYAMSURI.pdf', 'LHKPN Inspektur Inspektorat Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:24:58', 0),
(34, 1, '197205121992021001', 'LHKPN Plt Kepala Badan Keuangan dan Aset Daerah Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ANDI_ILHAM_ABUBAKAR.pdf', 'LHKPN Plt Kepala Badan Keuangan dan Aset Daerah Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:26:25', 0),
(35, 1, '196709051996031004', ' LHKPN Kepala Dinas Ketahanan Pangan Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ANDI_HIMAWAN_SALEH.pdf', ' LHKPN Kepala Dinas Ketahanan Pangan Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:29:44', 0),
(36, 1, '197903221999121001', 'LHKPN Kepala Dinas Pendidikan Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'IRWAN_SUAIB.pdf', 'LHKPN Kepala Dinas Pendidikan Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:31:14', 0),
(37, 1, '197911272000031001', ' LHKPN Kepala Dinas Kependudukan dan Pencatatan Sipil Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ANDI_REZA_AMRAN_R.pdf', ' LHKPN Kepala Dinas Kependudukan dan Pencatatan Sipil Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:34:28', 0),
(38, 1, '197505181993111001', 'LHKPN Kepala Satuan Polisi Pamong Praja dan Pemadam Kebakaran Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'AGUNG_BUDI_PRAYOGO.pdf', 'LHKPN Kepala Satuan Polisi Pamong Praja dan Pemadam Kebakaran Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:36:29', 0),
(39, 1, '197212281992022001', 'LHKPN Kepala Badan Perencanaan Pembangunan Daerah Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'HAERANI_DAHLAN.pdf', 'LHKPN Kepala Badan Perencanaan Pembangunan Daerah Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:43:55', 0),
(40, 1, '197101241992031008', 'LHKPN Kepala Dinas Pemberdayaan Perempuan,Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana Kab. Sinjai Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'JANWAR.pdf', 'LHKPN Kepala Dinas Pemberdayaan Perempuan,Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana Kab. Sinjai Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:47:19', 0),
(42, 1, '196512311998031039', ' LHKPN Kepala BPBD Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'BUDIAMAN.pdf', ' LHKPN Kepala BPBD Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 10:48:28', 0),
(43, 1, '197202071996031002', 'LHKPN Kepala Dinas Komunikasi Informatika dan Persandian Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'MANSYUR.pdf', 'LHKPN Kepala Dinas Komunikasi Informatika dan Persandian Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 11:02:03', 0),
(44, 1, '197611142000031002', ' LHKPN Kepala Badan Pendapatan Daerah Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ASDAR_AMAL_DHARMAWAN.pdf', ' LHKPN Kepala Badan Pendapatan Daerah Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 11:05:05', 0),
(47, 1, '196902151997031010', 'LHKPN Kepala Dinas tanaman Pangan Hortikultura dan Perkebunan Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'KAMARUDDIN.pdf', 'LHKPN Kepala Dinas tanaman Pangan Hortikultura dan Perkebunan Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 11:07:53', 0),
(48, 1, '196712251999031007', 'LHKPN Kepala Dinas Peternakan dan Kesehatan Hewan Tahun 2024 ', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'BURHANUDDIN.pdf', 'LHKPN Kepala Dinas Peternakan dan Kesehatan Hewan Tahun 2024 ', 'MUH. YUSRIL ABNI', '2025-10-03 11:08:54', 0),
(50, 1, '196912311990021008', 'LHKPN Kepala Dinas Perhubungan Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'AKBAR_DISHUB.pdf', 'LHKPN Kepala Dinas Perhubungan Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 11:10:17', 0),
(51, 1, '197801071996121002', ' LHKPN Plt. Kepala Dinas Perdagangan, Perindustrian dan Energi Sumber Daya Mineral Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'A__IRWANSYAHRANI_YUSUF.pdf', ' LHKPN Plt. Kepala Dinas Perdagangan, Perindustrian dan Energi Sumber Daya Mineral Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 11:13:27', 0),
(52, 1, '196603282002122002', 'LHKPN Kepala Dinas Kesehatan Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'EMMY_KARTAHARA_MALIK.pdf', 'LHKPN Kepala Dinas Kesehatan Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 11:15:07', 0),
(53, 1, '197007122003121011', 'LHKPN Kepala Dinas Pekerjaan Umum dan Penataan Ruang Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'HARIS_ACHMAD.pdf', 'LHKPN Kepala Dinas Pekerjaan Umum dan Penataan Ruang Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 11:16:24', 0),
(55, 1, '197308181994011001', ' LHKPN Kepala Dinas Sosial Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ANDI_MUHAMMAD_IDNAN.pdf', ' LHKPN Kepala Dinas Sosial Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 14:20:55', 0),
(56, 1, '197007112006041001', ' LHKPN Kepala Dinas Perpustakaan dan arsip Kab Sinjai Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ABDUL_AZIZ_AMIN.pdf', ' LHKPN Kepala Dinas Perpustakaan dan arsip Kab Sinjai Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 14:22:46', 0),
(57, 1, '197906092010011007', 'LHKPN Kepala Dinas Lingkungan Hidup dan Kehutanan Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'SOFWAN_SABIRIN.pdf', 'LHKPN Kepala Dinas Lingkungan Hidup dan Kehutanan Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 14:24:28', 0),
(58, 1, '196812021994011001', 'LHKPN Kepala Dinas Koperasi Usaha Kecil Menengah dan Tenaga Kerja Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'MUHAMMAD_RAMLAN_HAMID.pdf', 'LHKPN Kepala Dinas Koperasi Usaha Kecil Menengah dan Tenaga Kerja Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 14:25:46', 0),
(59, 1, '196812121992031013', 'LHKPN Kepala Dinas Pemuda dan Olahraga Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'HASIR_AHMAD.pdf', 'LHKPN Kepala Dinas Pemuda dan Olahraga Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 14:26:35', 0),
(60, 1, '197306111993111002', 'LHKPN Kepala Dinas Pariwisata dan Kebudayaan Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'TAMZIL_BINAWAN.pdf', 'LHKPN Kepala Dinas Pariwisata dan Kebudayaan Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 14:27:36', 0),
(61, 1, '197303121993031009', 'LHKPN Kepala Badan Penelitian dan Pengembangan Daerah Tahun 2024', 'Dinas Komunikasi Informatika dan Persandian', 2024, 'ALAMSYAH_BAHAR.pdf', 'LHKPN Kepala Badan Penelitian dan Pengembangan Daerah Tahun 2024', 'MUH. YUSRIL ABNI', '2025-10-03 14:29:01', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pbj_data`
--

CREATE TABLE `pbj_data` (
  `pbj_id` int NOT NULL,
  `kd_pbj` int NOT NULL DEFAULT '0',
  `kd_pbj_sub` int NOT NULL DEFAULT '0',
  `kategori_id` int NOT NULL,
  `jenis_id` int NOT NULL,
  `judul` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penerbit` varchar(84) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahun` int NOT NULL,
  `pbj_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `diupload_oleh` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dilihat_sebanyak` int NOT NULL,
  `didownload_sebanyak` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan_data`
--

CREATE TABLE `permohonan_data` (
  `permohonan_id` int NOT NULL,
  `email` varchar(128) NOT NULL,
  `permohonan_kategori` varchar(64) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(128) DEFAULT NULL,
  `nm_lembaga` varchar(128) DEFAULT NULL,
  `upload_ktp` text,
  `alamat` varchar(128) NOT NULL,
  `no_hp` varchar(16) NOT NULL,
  `pekerjaan` varchar(128) NOT NULL,
  `permohonan_nomor` varchar(64) NOT NULL,
  `permohonan_rincian` text NOT NULL,
  `permohonan_tujuan` varchar(512) NOT NULL,
  `permohonan_diperoleh` varchar(128) NOT NULL,
  `permohonan_salinan` varchar(128) NOT NULL,
  `permohonan_salinan_diperoleh` varchar(128) NOT NULL,
  `kb_nama` varchar(32) DEFAULT NULL,
  `kb_alamat` varchar(128) NOT NULL,
  `kb_alasan` varchar(128) NOT NULL,
  `kb_hp` varchar(32) NOT NULL,
  `kb_ringkasan` text NOT NULL,
  `kasus_posisi` varchar(128) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permohonan_data`
--

INSERT INTO `permohonan_data` (`permohonan_id`, `email`, `permohonan_kategori`, `nik`, `nama`, `nm_lembaga`, `upload_ktp`, `alamat`, `no_hp`, `pekerjaan`, `permohonan_nomor`, `permohonan_rincian`, `permohonan_tujuan`, `permohonan_diperoleh`, `permohonan_salinan`, `permohonan_salinan_diperoleh`, `kb_nama`, `kb_alamat`, `kb_alasan`, `kb_hp`, `kb_ringkasan`, `kasus_posisi`, `status`, `created`) VALUES
(1, 'jamilakominfo@gmail.com', '', '', NULL, NULL, '', '', '', '', 'dkip/ /2021', 'Renstra dinas koperasi tahun 2020', 'untuk kebutuhan skripsi', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Mengambil langsung', '', 'Pigouppub', '', 'Permohonan Informasi Ditolak', 'Pigouppub', 'In order to further verify this hypothesis we tested the ability of estradiol to rescue MCF 7 cells from melatonin inhibition, and the potential of this indoleamine to block the ability of estradiol to rescue the cells from tamoxifen inhibition <a href=http://buycialis.skin>coupons for cialis 20 mg</a> This was the product re labelled as Testosterone Propionate 50MG ML by scum bags', '', 2, '2022-02-10 07:11:54'),
(2, 'axoseve@benjaminmail.xyz', 'Perorangan', 'axoseve', 'axoseve', 'axoseve', NULL, 'https://dapoxetine.buzz', '86238299287', '', 'dkip/      /2021', 'Kutteh is clearly very knowledgeable, yet his focus is very much on statistics and cutting- edge research <a href=https://dapoxetine.buzz>buy priligy without a script</a>', 'Kutteh is clearly very knowledgeable, yet his focus is very much on statistics and cutting- edge research <a href=https://dapoxetine.buzz>buy priligy without a script</a>', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', 'vdsv', 'fewf', 'Informasi Berkala Tidak Disediakan', '576457', 'thtrh', 'dfgbgrh', 2, '2023-04-24 18:24:58'),
(3, 'ciptBiope@fmaill.xyz', 'Perorangan', 'chaicle', 'chaicle', 'chaicle', NULL, 'https://cialiss.sbs', '81593744526', '', 'dkip/      /2021', 'I was on clomid 50 mg and did my first cycle in December of 2015 <a href=https://cialiss.sbs>generic cialis</a> Generally, a good nano emulsion ZP value lies greater than 30 mV or less 30 mV as the particles formulated would have adequate repulsive force, less aggregation due to electrostatic repulsion and thus leading to having a better stability 26, 27, 28', 'I was on clomid 50 mg and did my first cycle in December of 2015 <a href=https://cialiss.sbs>generic cialis</a> Generally, a good nano emulsion ZP value lies greater than 30 mV or less 30 mV as the particles formulated would have adequate repulsive force, less aggregation due to electrostatic repulsion and thus leading to having a better stability 26, 27, 28', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 0, '2023-05-31 06:22:33'),
(4, 'ciptBiope@fmaill.xyz', 'Perorangan', 'chaicle', 'chaicle', 'chaicle', NULL, 'https://ciali.sbs', '84614514627', '', 'dkip/      /2021', '<a href=http://ciali.sbs>best price cialis 20mg</a> Specifications Form capsules', '<a href=http://ciali.sbs>best price cialis 20mg</a> Specifications Form capsules', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 0, '2023-06-07 09:32:51'),
(5, 'fitrianiyusuf.adm19@gmail.com', 'Perorangan', '7307034102010001', 'Fitriani Yusuf', '', NULL, 'Lingk. Langguli Kel. Samataring Kec. Sinjai Timur', '085810031654', 'Mahasiswa', 'dkip/      /2021', 'Surat Keputusan Bupati Sinjai Nomor 319 Tahun 2019 Tentang Penetapan Pengelola Layanan Informasi dan Dokumentasi Kabupaten Sinjai', 'Untuk melengkapi data pada proposal penelitian', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 2, '2023-06-24 16:40:56'),
(6, 'wicapej807@usharer.com', 'Perorangan', '2564852356452354', 'wagyu', '', NULL, 'jln tempik', '0897665544453345', 'asdasdasdasdasd', 'dkip/      /2021', 'sdas', 'dadadada', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-12 20:46:52'),
(7, 'wicapej807@usharer.com', 'Perorangan', '2564852356452354', 'wagyu', '', 'vyolins.jpg', 'jln tempik', '08782342342342', 'addaadda', 'dkip/      /2021', 'erwewer', 'werwrwr', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Hardcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-13 13:01:37'),
(8, 'cerisew506@soremap.com', 'Perorangan', '3756422123243534', 'asdasd', '', NULL, 'Jl. Traktor 1, Makassar', '0856745745634634', 'asdasdasd', 'dkip/      /2021', 'sdadaasdad', 'adasdasasd', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-13 13:03:31'),
(9, 'cerisew506@soremap.com', 'Perorangan', '3756422123243534', 'asdasd', '', NULL, 'Jl. Traktor 1, Makassar', '0856745745634634', 'asdasdasd', 'dkip/      /2021', 'sdadaasdad', 'adasdasasd', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-13 13:03:55'),
(10, 'cerisew506@soremap.com', 'Perorangan', '3756422123243534', 'asdasd', '', NULL, 'Jl. Traktor 1, Makassar', '0856745745634634', 'asdasdasd', 'dkip/      /2021', 'sdadaasdad', 'adasdasasd', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-13 13:04:07'),
(11, 'cerisew506@soremap.com', 'Perorangan', '3756422123243534', 'asdasd', '', NULL, 'Jl. Traktor 1, Makassar', '0856745745634634', 'asdasdasd', 'dkip/      /2021', 'sdadaasdad', 'adasdasasd', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-13 13:04:18'),
(12, 'cerisew506@soremap.com', 'Perorangan', '3756422123243534', 'asdasd', '', 'vyolins_php.jpg', 'Jl. Traktor 1, Makassar', '0856745745634634', 'asdasdasd', 'dkip/      /2021', 'sdadaasdad', 'adasdasasd', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-13 13:04:34'),
(13, 'cerisew506@soremap.com', 'Perorangan', '3756422123243534', 'asdasd', '', NULL, 'Jl. Traktor 1, Makassar', '0856745745634634', 'asdasdasd', 'dkip/      /2021', 'sdadaasdad', 'adasdasasd', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-13 13:04:52'),
(14, 'cerisew506@soremap.com', 'Perorangan', '3756422123243534', 'asdasd', '', NULL, 'Jl. Traktor 1, Makassar', '0856745745634634', 'asdasdasd', 'dkip/      /2021', 'sdadaasdad', 'adasdasasd', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2023-07-13 13:05:08'),
(15, 'wmxczaapr@exelica.com', 'Perorangan', '1234567890121212', 'wmxczaapr', '', NULL, 'wmxczaapr', '1111111111', 'wmxczaapr', 'dkip/      /2021', 'wmxczaapr', 'wmxczaapr', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Hardcopy', 'Kurir', NULL, '', '', '', '', '', 0, '2023-08-16 04:28:19'),
(16, 'aa99@gmail.com', 'Perorangan', '1613534689583658', 'JAKFAD', '', NULL, 'Balikpapan', '9156261415', 'ts', 'dkip/      /2021', 'test', 'es', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 2, '2023-08-21 20:06:52'),
(17, 'layaknyamatahari@gmail.com', 'Perorangan', '3671051806030004', 'CHIKAL RAYANDI', '', NULL, 'Jl. Imam Bonjol No.129', '081818181', 'adasdasd', 'dkip/      /2021', 'asdasdasd', 'asdadad', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 2, '2023-09-04 04:31:34'),
(18, 'GxSec1337@protonmail.com', 'Perorangan', '1333108080008388', 'test', '', 'tod.jpg', 'test', '056705424012', 'test', 'dkip/      /2021', 'test', 'tet', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2024-01-21 16:50:52'),
(19, 'GxSec1337@protonmail.com', 'Perorangan', '1333108080008388', 'test', '', NULL, 'test', '0875434545', 'test', 'dkip/      /2021', 'test', 'test', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2024-01-21 16:53:40'),
(20, 'GxSec1337@protonmail.com', 'Perorangan', '1333108080008388', 'test', '', NULL, 'test', '0875434545', 'test', 'dkip/      /2021', 'test', 'test', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2024-01-21 16:54:58'),
(21, 'GxSec1337@protonmail.com', 'Perorangan', '1333108080008388', 'test', '', NULL, 'test', '0875434545', 'test', 'dkip/      /2021', 'test', 'test', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2024-01-21 16:55:41'),
(22, 'GxSec1337@protonmail.com', 'Perorangan', '1333108080008388', 'test', '', NULL, 'test', '0875434545', 'test', 'dkip/      /2021', 'test', 'test', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2024-01-21 16:55:49'),
(23, 'GxSec1337@protonmail.com', 'Perorangan', '1333108080008388', 'test', '', 'tod_php.jpg', 'test', '0875434545', 'test', 'dkip/      /2021', 'test', 'test', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2024-01-21 16:56:02'),
(24, 'GxSec1337@protonmail.com', 'Perorangan', '1333108080008388', 'test', '', 'tod_php1.jpg', 'test', '0875434545', 'test', 'dkip/      /2021', 'test', 'test', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2024-01-21 16:56:11'),
(25, 'GxSec1337@protonmail.com', 'Perorangan', '1333108080008388', '<script>alert()</script>', '', NULL, 'test', '0875434545', 'test', 'dkip/      /2021', 'test', 'test', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 0, '2024-01-21 16:56:51'),
(26, 'perencanoose@gmail.com', 'Perorangan', '1122447788885524', 'bukanamp', '', NULL, 'kalimantan', '081268888888', 'amp', 'dkip/      /2021', 'backdoor', 'backdoor', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 0, '2024-03-19 15:35:31'),
(27, 'yusrilabni8877@gmail.com', 'Perorangan', '7302020210990001', 'Yusril ', '', NULL, 'Anjsjs', '08761', 'Habaha', 'dkip/      /2021', 'Hahah', 'Ahaha', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Hardcopy', 'Mengambil langsung', 'Weni', 'Jalan Pemuda', 'Permohonan Informasi Ditolak', '087432546231', 'informasi tidak disediakan', '', 0, '2024-06-10 10:20:32'),
(28, 'wnisawitri@gmail.com', 'Perorangan', '12345678', 'weni sawitri', '', 'KTP_WENI.jpg', 'Jalan Pemuda', '085256836922', 'Mahasiswa', 'dkip/      /2021', 'DPA 2025', 'Verifikasi Monev Ujicoba Menu Permohonan Informasi dan Keberatan', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Softcopy', 'Email', NULL, '', '', '', '', '', 1, '2025-04-13 01:54:11'),
(29, 'nurulmawaddah898@gmail.com', 'Perorangan', '7307084612020002', 'Nurul Mawaddah Warahmah', '', NULL, 'Dusun pakkita, kelurahan mannanti, kec.Tellulimpoe', '082187885759', 'Mahasiswa ', 'dkip/      /2021', '1. Bagaimana sistem lapor ini bekerja di dinas kominfo?\r\n2. ?bagaimana alur penanganan laporan dari awal sampai selesai?\r\n3. ?apakah semua laporan di tindak lanjuti?\r\n4. ?bagaimana cara instalasi atau opd menindaklanjuti laporan dari masyarakat?\r\n5. ?apakah masyarakat di beri notifikasi saat laporan mereka di proses?', 'Pemenuhan proposal', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 2, '2025-05-24 12:57:50'),
(30, 'nurulmawaddah898@gmail.com', 'Perorangan', '7307084612020002', 'Nurul mawaddah warahmah', '', NULL, 'Dusun pakkita', '082187885759', 'Mahasiswa ', 'dkip/      /2021', '1. Bagaimana sistem lapor ini bekerja di dinas kominfo?\r\n2. ?bagaimana alur penanganan laporan dari awal sampai selesai?\r\n3. ?apakah semua laporan di tindak lanjuti?\r\n4. ?bagaimana cara instalasi atau opd menindaklanjuti laporan dari masyarakat?\r\n5. ?apakah masyarakat di beri notifikasi saat laporan mereka di proses?', 'Pemenuhan proposal ', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 2, '2025-05-24 13:01:37'),
(31, 'nurulmawaddah898@gmail.com', 'Perorangan', '7307084612020002', 'Nurul mawaddah warahmah', '', NULL, 'Dusun pakkita', '082187885759', 'Mahasiswa ', 'dkip/      /2021', '1. Bagaimana sistem lapor ini bekerja di dinas kominfo?\r\n2. ?bagaimana alur penanganan laporan dari awal sampai selesai?\r\n3. ?apakah semua laporan di tindak lanjuti?\r\n4. ?bagaimana cara instalasi atau opd menindaklanjuti laporan dari masyarakat?\r\n5. ?apakah masyarakat di beri notifikasi saat laporan mereka di proses?', 'Pemenuhan proposal ', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 2, '2025-05-24 17:06:32'),
(32, 'nurulmawaddah898@gmail.com', 'Perorangan', '7307084612020002', 'Nurul Mawaddah Warahmah', '', NULL, 'Dusun pakkita, kec. Tellulimpoe ', '082187885759', 'Mahasiswa ', 'dkip/      /2021', '1. Apakah Dinas Kominfo Kabupaten Sinjai telah memiliki SOP khusus dalam pengelolaan laporan dari masyarakat melalui sistem LAPOR?\r\n2. ?Bagaimana alur atau tahapan kerja berdasarkan SOP ketika ada laporan masuk melalui sistem LAPOR? Dan untuk di tindak lanjuti laporan tersebut minimal berapa hari?\r\n3. Apa saja kendala yang biasanya terjadi dalam pelaksanaan SOP tersebut, dan bagaimana solusinya?', 'Pemenuhan proposal', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 0, '2025-05-27 10:31:27'),
(33, 'nurulmawaddah898@gmail.com', 'Perorangan', '7307084612020002', 'Nurul Mawaddah Warahmah', '', NULL, 'Dusun pakkita, kec. Tellulimpoe ', '082187885759', 'Mahasiswa ', 'dkip/      /2021', '1. Apakah Dinas Kominfo Kabupaten Sinjai telah memiliki SOP khusus dalam pengelolaan laporan dari masyarakat melalui sistem LAPOR?\r\n2. ?Bagaimana alur atau tahapan kerja berdasarkan SOP ketika ada laporan masuk melalui sistem LAPOR? Dan untuk di tindak lanjuti laporan tersebut minimal berapa hari?\r\n3. Apa saja kendala yang biasanya terjadi dalam pelaksanaan SOP tersebut, dan bagaimana solusinya?', 'Pemenuhan proposal', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 0, '2025-05-27 17:13:26'),
(34, 'nurulmawaddah898@gmail.com', 'Perorangan', '7307084612020002', 'Nurul Mawaddah Warahmah', '', NULL, 'Dusun pakkita, kec. Tellulimpoe ', '082187885759', 'Mahasiswa ', 'dkip/      /2021', '1. Apakah Dinas Kominfo Kabupaten Sinjai telah memiliki SOP khusus dalam pengelolaan laporan dari masyarakat melalui sistem LAPOR?\r\n2. ?Bagaimana alur atau tahapan kerja berdasarkan SOP ketika ada laporan masuk melalui sistem LAPOR? Dan untuk di tindak lanjuti laporan tersebut minimal berapa hari?\r\n3. Apa saja kendala yang biasanya terjadi dalam pelaksanaan SOP tersebut, dan bagaimana solusinya?', 'Pemenuhan proposal', 'Melihat / Membaca / Mendengarkan', 'Softcopy', 'Mengambil langsung', NULL, '', '', '', '', '', 0, '2025-05-27 19:07:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_pbj`
--

CREATE TABLE `ref_pbj` (
  `kd_pbj` int NOT NULL,
  `nama_pbj` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_pbj_sub`
--

CREATE TABLE `ref_pbj_sub` (
  `kd_pbj_sub` int NOT NULL,
  `kd_pbj` int NOT NULL,
  `nama_pbj_sub` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_permohonan_status`
--

CREATE TABLE `ref_permohonan_status` (
  `kd_status` int NOT NULL,
  `nm_status` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_permohonan_status`
--

INSERT INTO `ref_permohonan_status` (`kd_status`, `nm_status`) VALUES
(0, 'Belum Proses'),
(1, 'Sedang Proses'),
(2, 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `user_nama` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `nik` varchar(26) NOT NULL,
  `instansi` varchar(256) NOT NULL,
  `alamat` text NOT NULL,
  `pekerjaan` varchar(128) NOT NULL,
  `no_hp` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int NOT NULL,
  `is_active` int NOT NULL,
  `date_created` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_nama`, `email`, `nik`, `instansi`, `alamat`, `pekerjaan`, `no_hp`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'ABDUL RAHIM', 'rahimkominfo@gmail.com', '7307052808840002', 'Dinas Komunikasi, Informatika dan Persandian Kab. Sinjai', 'Jl. Cakalang', 'Tenaga Honorer', '085395084234', '794394d5084f0a341b34ef8d46c8ec95', 1, 1, 1633732594),
(2, 'mila', 'jamilakominfo@gmail.com', '7308030107970137', '', 'lompu kec.kajuara', '', '085342815520', 'deb74d52649b549ff4e376ae99109651', 2, 1, 1634011355),
(3, 'Meliana', 'desabuhungpitie@gmail.com', '7307084105900001', 'Kantor desa buhung pitue', 'Pulau burung lohe', 'Aparat desa', '082344453707', '25421ac98bc45b2bee6ddf885f046573', 2, 0, 1650854774),
(4, 'Meliana', 'desabuhungpitue@gmail.com', '7307084105900001', 'Kantor desa buhung pitue', 'Pulau burung lohe', 'Aparat desa', '082344453707', '25421ac98bc45b2bee6ddf885f046573', 2, 0, 1650854837),
(5, 'Indah Sari', 'surelindahsari1@gmail.com', '7322046510950001', 'Universitas Hasanuddin', 'PK VII', 'mahasiswa', '085255671646', '13378175dc9e2ac58d87ff5d70ee7302', 2, 0, 1656345303),
(6, 'Jjj', 'ass@gmail.com', '1212121212121212', 'Jjjj', 'Jjjj', 'Jjj', '77777', '90ec46864daa32d55d823291a0b3c2b5', 2, 0, 1659418713),
(7, 'adadad', 'nejeb55537@5k2u.com', '1111545455646466', 'teets', 'ttetsd', 'euyfuefu', '0741454464646', '2aca5772c8406ae39da42c4780225f8f', 2, 0, 1659553072),
(8, 'A. MUH. HIJRAH', 'dinkes@sinjaikab.go.id', '-', 'Dinas Kesehatan ', 'Jln. Jend Sudirman No. 4', 'Staf', '085242915959', '482c811da5d5b4bc6d497ffa98491e38', 2, 0, 1659580736),
(9, 'Ss', 'ass@ass.com', '1212121212121212', 'Aaa', 'Aa', 'Aa', 'Jjjhj', '90ec46864daa32d55d823291a0b3c2b5', 2, 0, 1663947014),
(10, 'm34n5t49718 m34n5t49718', 'm34n5t4@gmail.com', '5465465465465454', 'sdfsdfsd', 'm34n5t49718', 'm34n5t49718', '56756756756756', '58e21f9754f7cb35bb64d243f79fd68d', 2, 0, 1672237113),
(11, 'ahmad kasim', 'badm99201@gmail.com', '3213211212010002', 'adgadg', 'Perum panorama indah', 'sfhsfh', '089659412234', 'ed2b1f468c5f915f3f1cf75d7068baae', 2, 0, 1680617416),
(12, 'Fathan', 'saefulbakung2@gmail.com', '1929292733', 'jajs', 'shhahshsjs', 'hwwielsnndd', '0895617553368', '*22415A7146214A9F149ECF674BB44126A9D766BA', 2, 0, 1693276374),
(13, 'Fathan', 'aafathan2005@gmail.com', '1929292733', 'jajs', 'shhahshsjs', 'hwwielsnndd', '0895617553368', '4af7986f544d643b3f8b3500b5bb90eb', 2, 0, 1693276453),
(14, 'wagyu', 'hider55579@vikinoko.com', '2564852356452354', 'wewe', 'jln tempik', 'asdasd', '0897665544453345', 'd4d0ba378fe5efc84bd9c575e736cf04', 2, 0, 1693649377),
(15, 'bimhybim', 'h2z0k548c4@zipcatfish.com', '1223344556677889', 'fdsfdsf', 'hghjg', 'jhgjhgjg', '089766554433', '97df4a5b688a8f778703bcd5cd1578e4', 2, 0, 1694513159),
(16, 'ARIS KURNIAWAN', 'ily011020@gmail.com', '3173083010871001', 'personal', 'alama kpu kudus kab 1 no 28', 'dosen', '0858644654986', 'f3cfb62c91db3f21ab209bd9c2640f5e', 2, 0, 1698986592),
(17, 'adikadik', 'fluxi13337@gmail.com', '3737373737373737', 'Hduduududud', 'Jzjxjz', 'Djjdddddr', '083838383838', '18514e7d0cb181b758d7f336b18efc2e', 2, 0, 1705815903),
(18, 'asfasfasfasf', 'wantek1510@gmail.com', '1531864062240546', 'asfasfas', 'fasfasf', 'asfasf', '081380374774', '1f992ede056666e1c0ece6409e9592b2', 2, 0, 1713390556),
(19, 'ahmad kasim', 'badm99201+@gmail.com', '1371026803980005', 'adgadgadg', 'Perum panorama indah', 'aaaaa', '089659412234', '70ba2db50ec8354bc9ee2fa835991d69', 2, 0, 1714573896),
(20, 'ahmad kasim', 'badm992011@gmail.com', '1371026803980005', 'adgadgadg', 'Perum panorama indah', 'aaaaa', '089659412234', 'ed2b1f468c5f915f3f1cf75d7068baae', 2, 0, 1714574104);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(3, 'desabuhungpitie@gmail.com', 'AWQj39Wx9snbjzZBL/Ez5fZ585bQeP/8m8UayE1eEXo=', 1650854774),
(4, 'desabuhungpitue@gmail.com', 'JWQPhsjs0fJfyGnbVUugibUMxIWOwO3Az41ndVuB2FY=', 1650854837),
(5, 'surelindahsari1@gmail.com', 'hFUKZvx/dSo7THPAJoj0hut8iLQP/AEv9DScGqd3BME=', 1656345303),
(6, 'ass@gmail.com', 'kHduv2lN62qx8pJscf0ynJsjW7iy7zTUGhCUKQ/e4Cc=', 1659418713),
(7, 'nejeb55537@5k2u.com', 'Kw1VQcvteQnKeWCbm8KkZLuXqlNvLEqIyQa7kjK0DoM=', 1659553072),
(8, 'dinkes@sinjaikab.go.id', 'sjyTnucyHu+56VWR7T5/PeuuquXKmz59YgoqXNrykrk=', 1659580736),
(9, 'ass@ass.com', 'd9tz8WqN/0AhSQy7QD70FKPs954O7skSLSNfMbHVgVY=', 1663947014),
(10, 'm34n5t4@gmail.com', 'PJeW98H+f1z9zkVVbxdbOXmfEEK0TZwbj6159ECpHTY=', 1672237113),
(11, 'badm99201@gmail.com', 'k5M41Cq05gLI2XQAFvLqx4mIPoB1OIfcj8YtJnOdlkw=', 1680617416),
(12, 'saefulbakung2@gmail.com', '0/nvofTCY+F7YMctiw0Ikmb7ceF8i+XBNqnDZTpP3ro=', 1693276374),
(13, 'aafathan2005@gmail.com', 'YgNCZGRzg9AZYpC9Ljp6apuKOOhRVjpJJvTWQRhYOu8=', 1693276453),
(14, 'hider55579@vikinoko.com', 'T7QqLFa9+81Ficaop4x7Rsv4jI6sJJiSn6t0O4Kp3nY=', 1693649377),
(15, 'h2z0k548c4@zipcatfish.com', 'AY5oHCvrZkBUZLAZZxKakNEtlF8ds0YScOLFAv5nHMk=', 1694513159),
(16, 'ily011020@gmail.com', '7d7wlxGfwv2tt3ZfC5MrC3q0VcojExCkgP75pBLDptQ=', 1698986592),
(17, 'fluxi13337@gmail.com', 'KdSTYgs8shC6Qp+QOqf9AU5wabCLlfXHpMt2uWsL/gE=', 1705815903),
(18, 'wantek1510@gmail.com', 'N/+yKsDBYcKnM8mS3HXcA5kO/j5v/vGGvKmBojvjOIE=', 1713390556),
(19, 'badm99201+@gmail.com', 'zsh2gUMe5EvQx9MyQ4ngj8b8HUDAsjuQGu9ykdpS8MM=', 1714573896),
(20, 'badm992011@gmail.com', 'dG3Vu/3uC1JTj2n5B3n9yIbeNT8ooq7heSgbhzFEZZk=', 1714574104);

-- --------------------------------------------------------

--
-- Struktur dari tabel `_permohonan_data`
--

CREATE TABLE `_permohonan_data` (
  `permohonan_id` int NOT NULL,
  `email` varchar(128) NOT NULL,
  `permohonan_nomor` varchar(64) NOT NULL,
  `permohonan_rincian` text NOT NULL,
  `permohonan_tujuan` varchar(512) NOT NULL,
  `permohonan_diperoleh` varchar(128) NOT NULL,
  `permohonan_salinan_diperoleh` varchar(128) NOT NULL,
  `kb_nama` varchar(32) DEFAULT NULL,
  `kb_alamat` varchar(128) NOT NULL,
  `kb_alasan` varchar(128) NOT NULL,
  `kb_hp` varchar(32) NOT NULL,
  `kb_ringkasan` text NOT NULL,
  `kasus_posisi` varchar(128) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `_permohonan_data`
--

INSERT INTO `_permohonan_data` (`permohonan_id`, `email`, `permohonan_nomor`, `permohonan_rincian`, `permohonan_tujuan`, `permohonan_diperoleh`, `permohonan_salinan_diperoleh`, `kb_nama`, `kb_alamat`, `kb_alasan`, `kb_hp`, `kb_ringkasan`, `kasus_posisi`, `status`, `created`) VALUES
(1, 'jamilakominfo@gmail.com', 'dkip/ /2021', 'Renstra dinas koperasi tahun 2020', 'untuk kebutuhan skripsi', 'Mendapatkan Salinan Informasi Hard/Soft Copy', 'Mengambil langsung', NULL, '', '', '', '', '', 0, '2022-02-10 07:11:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `count_data`
--
ALTER TABLE `count_data`
  ADD PRIMARY KEY (`count_id`);

--
-- Indeks untuk tabel `dok_data`
--
ALTER TABLE `dok_data`
  ADD PRIMARY KEY (`dok_id`);

--
-- Indeks untuk tabel `dok_galeri`
--
ALTER TABLE `dok_galeri`
  ADD PRIMARY KEY (`galeri_id`);

--
-- Indeks untuk tabel `dok_laporan`
--
ALTER TABLE `dok_laporan`
  ADD PRIMARY KEY (`laporan_id`);

--
-- Indeks untuk tabel `jenis_data`
--
ALTER TABLE `jenis_data`
  ADD PRIMARY KEY (`jenis_id`);

--
-- Indeks untuk tabel `kategori_data`
--
ALTER TABLE `kategori_data`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indeks untuk tabel `keberatan_data`
--
ALTER TABLE `keberatan_data`
  ADD PRIMARY KEY (`keberatan_id`);

--
-- Indeks untuk tabel `lhkpn_data`
--
ALTER TABLE `lhkpn_data`
  ADD PRIMARY KEY (`lhkpn_id`);

--
-- Indeks untuk tabel `pbj_data`
--
ALTER TABLE `pbj_data`
  ADD PRIMARY KEY (`pbj_id`);

--
-- Indeks untuk tabel `permohonan_data`
--
ALTER TABLE `permohonan_data`
  ADD PRIMARY KEY (`permohonan_id`);

--
-- Indeks untuk tabel `ref_pbj`
--
ALTER TABLE `ref_pbj`
  ADD PRIMARY KEY (`kd_pbj`);

--
-- Indeks untuk tabel `ref_pbj_sub`
--
ALTER TABLE `ref_pbj_sub`
  ADD PRIMARY KEY (`kd_pbj_sub`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `_permohonan_data`
--
ALTER TABLE `_permohonan_data`
  ADD PRIMARY KEY (`permohonan_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `count_data`
--
ALTER TABLE `count_data`
  MODIFY `count_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dok_data`
--
ALTER TABLE `dok_data`
  MODIFY `dok_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1229;

--
-- AUTO_INCREMENT untuk tabel `dok_galeri`
--
ALTER TABLE `dok_galeri`
  MODIFY `galeri_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `dok_laporan`
--
ALTER TABLE `dok_laporan`
  MODIFY `laporan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `jenis_data`
--
ALTER TABLE `jenis_data`
  MODIFY `jenis_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kategori_data`
--
ALTER TABLE `kategori_data`
  MODIFY `kategori_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `keberatan_data`
--
ALTER TABLE `keberatan_data`
  MODIFY `keberatan_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lhkpn_data`
--
ALTER TABLE `lhkpn_data`
  MODIFY `lhkpn_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `pbj_data`
--
ALTER TABLE `pbj_data`
  MODIFY `pbj_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `permohonan_data`
--
ALTER TABLE `permohonan_data`
  MODIFY `permohonan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `ref_pbj`
--
ALTER TABLE `ref_pbj`
  MODIFY `kd_pbj` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ref_pbj_sub`
--
ALTER TABLE `ref_pbj_sub`
  MODIFY `kd_pbj_sub` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `_permohonan_data`
--
ALTER TABLE `_permohonan_data`
  MODIFY `permohonan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
