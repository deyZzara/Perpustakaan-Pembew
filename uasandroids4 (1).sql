-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 28 Bulan Mei 2025 pada 18.12
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uasandroids4`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `rekomendasi_usia` int(11) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `rekomendasi_usia`, `cover`, `deskripsi`, `stok`) VALUES
(1, 'All Quiet on the Western Front', 'Erich Maria Remarque', 15, 'https://covers.openlibrary.org/b/id/9251631-L.jpg', 'A novel describing the brutal realities of World War I from the German soldier\'s point of view.', 4),
(2, 'The Guns of August', 'Barbara W. Tuchman', 16, 'https://covers.openlibrary.org/b/id/8231651-L.jpg', 'A historical account of the opening month of World War I, focusing on military strategy and miscalculations.', 5),
(3, 'The Diary of Anne Frank', 'Anne Frank', 13, 'https://covers.openlibrary.org/b/id/8221891-L.jpg', 'The personal diary of a young Jewish girl hiding during the Nazi occupation in WWII.', 5),
(4, 'Night', 'Elie Wiesel', 16, 'https://covers.openlibrary.org/b/id/8203771-L.jpg', 'A harrowing memoir of a Holocaust survivor recounting his experience in Nazi concentration camps.', 5),
(5, 'The Book Thief', 'Markus Zusak', 14, 'https://covers.openlibrary.org/b/id/7222245-L.jpg', 'A young girl steals books and shares them in Nazi Germany, narrated by Death itself.', 0),
(6, 'Unbroken', 'Laura Hillenbrand', 16, 'https://covers.openlibrary.org/b/id/8374921-L.jpg', 'The incredible survival story of a WWII airman who crashes in the Pacific and is captured by the Japanese.', 0),
(7, 'The Longest Day', 'Cornelius Ryan', 16, 'https://covers.openlibrary.org/b/id/8231345-L.jpg', 'An hour-by-hour account of the D-Day invasion of Normandy.', 5),
(8, 'A Farewell to Arms', 'Ernest Hemingway', 15, 'https://covers.openlibrary.org/b/id/8224169-L.jpg', 'A romantic tragedy set during WWI between an American ambulance driver and a British nurse.', 5),
(9, 'The Nightingale', 'Kristin Hannah', 14, 'https://covers.openlibrary.org/b/id/8231523-L.jpg', 'Two sisters resist the German occupation of France in WWII, showing different paths of courage.', 5),
(10, 'Schindler\'s List', 'Thomas Keneally', 16, 'https://covers.openlibrary.org/b/id/8232001-L.jpg', 'The true story of a man who saved over a thousand Jews during the Holocaust.', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `denda`
--

CREATE TABLE `denda` (
  `id` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `jumlah_hari_telat` int(11) NOT NULL,
  `jumlah_denda` decimal(10,2) NOT NULL,
  `status_pembayaran` enum('belum_dibayar','sudah_dibayar') DEFAULT 'belum_dibayar',
  `tanggal_pembayaran` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `denda`
--

INSERT INTO `denda` (`id`, `id_peminjaman`, `jumlah_hari_telat`, `jumlah_denda`, `status_pembayaran`, `tanggal_pembayaran`, `created_at`) VALUES
(1, 48, 7, 21000.00, 'belum_dibayar', NULL, '2025-05-28 09:35:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `batas_waktu` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('menunggu','bisa_diambil','dipinjam','dikembalikan','dibatalkan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_user`, `id_buku`, `tanggal_pinjam`, `batas_waktu`, `tanggal_kembali`, `status`) VALUES
(1, 2, 1, '2025-05-20', '2025-06-20', NULL, 'dikembalikan'),
(2, 2, 3, '2025-05-21', '2025-06-21', NULL, 'dikembalikan'),
(3, 2, 4, '2025-05-22', '2025-06-22', NULL, 'dikembalikan'),
(4, 2, 5, '2025-05-23', '2025-06-23', '2025-05-24', 'dikembalikan'),
(5, 2, 7, '2025-05-24', '2025-06-24', NULL, 'dikembalikan'),
(25, 14, 8, '2025-05-24', '2025-06-23', NULL, 'dikembalikan'),
(26, 14, 9, '2025-05-24', '2025-06-23', '2025-05-28', 'dikembalikan'),
(27, 14, 4, '2025-05-24', '2025-06-23', NULL, 'dikembalikan'),
(28, 15, 1, '2025-05-24', '2025-06-23', NULL, 'dikembalikan'),
(29, 16, 10, '2025-05-24', '2025-06-23', '2025-05-28', 'dikembalikan'),
(30, 14, 1, '2025-05-27', '2025-06-03', '2025-05-27', 'dikembalikan'),
(31, 15, 4, '2025-05-28', '2025-06-04', '2025-05-28', 'dikembalikan'),
(32, 15, 3, '2025-05-28', '2025-06-04', '2025-05-28', 'dikembalikan'),
(33, 15, 6, '2025-05-28', '2025-06-04', '2025-05-28', 'dikembalikan'),
(34, 15, 10, '2025-05-28', '2025-06-04', '2025-05-28', 'dikembalikan'),
(35, 15, 9, '2025-05-28', '2025-06-04', '2025-05-28', 'dikembalikan'),
(36, 15, 3, '2025-05-28', '2025-06-04', '2025-05-28', 'dikembalikan'),
(37, 20, 10, '2025-05-28', '2025-06-04', '2025-05-28', 'dikembalikan'),
(38, 15, 1, '2025-05-29', '0000-00-00', '2025-05-31', 'dikembalikan'),
(39, 15, 6, '2025-05-29', '0000-00-00', '2025-05-31', 'dikembalikan'),
(40, 15, 1, '2025-05-29', '0000-00-00', '2025-05-28', 'dikembalikan'),
(41, 26, 8, '2025-05-29', '0000-00-00', '2025-05-31', 'dikembalikan'),
(42, 26, 4, '2025-05-29', '0000-00-00', '2025-05-30', 'dikembalikan'),
(43, 26, 3, '2025-05-13', '2025-05-20', '2025-05-28', 'dikembalikan'),
(44, 26, 2, '2025-05-13', '2025-05-21', '2025-05-30', 'dikembalikan'),
(45, 26, 10, '2025-05-13', '2025-05-21', '2025-05-30', 'dikembalikan'),
(46, 26, 10, '2025-05-13', '2025-05-21', '2025-05-28', 'dikembalikan'),
(47, 26, 2, '2025-05-13', '2025-05-21', '2025-05-30', 'dikembalikan'),
(48, 15, 10, '2025-05-13', '2025-05-21', '2025-05-28', 'dikembalikan'),
(49, 15, 8, '2025-05-13', '2025-05-21', '2025-05-30', 'dikembalikan'),
(50, 26, 1, '2025-05-13', '2025-05-21', '2025-05-30', 'dipinjam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_denda`
--

CREATE TABLE `pengaturan_denda` (
  `id` int(11) NOT NULL,
  `denda_per_hari` decimal(10,2) DEFAULT 3000.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaturan_denda`
--

INSERT INTO `pengaturan_denda` (`id`, `denda_per_hari`, `updated_at`) VALUES
(1, 3000.00, '2025-05-28 09:41:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('user','staff') DEFAULT 'user',
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `is_banned` tinyint(1) DEFAULT 1,
  `status_registrasi` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `nama_lengkap`, `email`, `no_telp`, `is_banned`, `status_registrasi`) VALUES
(2, 'fadey2', '87dc1e131a1369fdf8f1c824a6a62dff', 'staff', NULL, NULL, NULL, 0, 'pending'),
(14, 'fadey11', 'user11', 'user', NULL, NULL, NULL, 0, 'pending'),
(15, 'fadilrahman', '6f2a22892f7d149cf7eeab7a2ec1a8f1', 'user', NULL, NULL, NULL, 0, 'pending'),
(16, 'kekey12', 'kekey12', 'user', NULL, NULL, NULL, 0, 'pending'),
(17, 'admin1', '0192023a7bbd73250516f069df18b500', '', NULL, NULL, NULL, 0, 'pending'),
(20, 'fadey123', '9870acbba6d7cf615586bf1de5b97b0d', 'user', NULL, NULL, NULL, 0, 'pending'),
(23, 'raihan', '6e24184c9f8092a67bcd413cbcf598da', 'user', NULL, NULL, NULL, 0, 'pending'),
(24, 'risky', 'aed7b8c200d4151cca403d57ba72c98e', 'user', 'Rizky Sugiharto', 'risky@gmail.com', '089677564432', 0, 'pending'),
(25, 'atvhi', '3f6eab0cf74136253e4c6271b94040e2', 'user', 'atvhi has', 'atvhi@gmail.com', '12345678765', 0, 'pending'),
(26, 'azka', '06cc3d3dba39b5305f4ec0c3045d0ec4', 'user', 'azka putra aulia', 'azka@gmail.com', '09876678823', 0, 'pending');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `denda`
--
ALTER TABLE `denda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `denda_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
