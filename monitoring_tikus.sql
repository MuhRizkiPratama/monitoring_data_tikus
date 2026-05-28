-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 28 Bulan Mei 2026 pada 21.29
-- Versi server: 8.4.3
-- Versi PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `monitoring_tikus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `monitoring`
--

CREATE TABLE `monitoring` (
  `id` int NOT NULL,
  `id_tikus` int NOT NULL,
  `hari_ke` int NOT NULL,
  `berat_badan` decimal(10,2) DEFAULT NULL,
  `skor_eritema` tinyint NOT NULL DEFAULT '0',
  `skor_edema` tinyint NOT NULL DEFAULT '0',
  `foto_berat` varchar(255) DEFAULT NULL,
  `foto_kulit` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `monitoring`
--

INSERT INTO `monitoring` (`id`, `id_tikus`, `hari_ke`, `berat_badan`, `skor_eritema`, `skor_edema`, `foto_berat`, `foto_kulit`, `tanggal`) VALUES
(2, 2, 1, 189.00, 0, 0, 'src/uploads/monitoring/foto_berat_20260515094200_6a06ea68b933e.jpg', 'src/uploads/monitoring/foto_kulit_20260515094200_6a06ea68b98a8.jpg', '2026-05-15'),
(3, 3, 1, 178.00, 0, 0, 'src/uploads/monitoring/foto_berat_20260515095411_6a06ed431e9ee.jpg', 'src/uploads/monitoring/foto_kulit_20260515095411_6a06ed431f01b.jpg', '2026-05-15'),
(4, 4, 1, 181.00, 0, 0, 'src/uploads/monitoring/foto_berat_20260515095546_6a06eda275970.jpg', 'src/uploads/monitoring/foto_kulit_20260515095546_6a06eda276f2d.jpg', '2026-05-15'),
(5, 5, 1, 170.00, 0, 0, 'src/uploads/monitoring/foto_berat_20260515095748_6a06ee1c238e9.jpg', 'src/uploads/monitoring/foto_kulit_20260515095748_6a06ee1c23ddf.jpg', '2026-05-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sampel`
--

CREATE TABLE `sampel` (
  `id_sampel` int NOT NULL,
  `nama_sampel` varchar(255) NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sampel`
--

INSERT INTO `sampel` (`id_sampel`, `nama_sampel`, `deskripsi`) VALUES
(2, 'Kontrol (-)', ''),
(3, 'F1', ''),
(4, 'F2', ''),
(5, 'F3', ''),
(6, 'Kontrol (+) 15%', ''),
(7, 'Kontrol (+) 20%', ''),
(8, 'Kontrol (+) 25%', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tikus`
--

CREATE TABLE `tikus` (
  `id_tikus` int NOT NULL,
  `id_sampel` int NOT NULL,
  `kode_tikus` varchar(50) NOT NULL,
  `jenis_kelamin` enum('jantan','betina') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tikus`
--

INSERT INTO `tikus` (`id_tikus`, `id_sampel`, `kode_tikus`, `jenis_kelamin`) VALUES
(2, 2, 'T001', 'jantan'),
(3, 2, 'T002', 'jantan'),
(4, 2, 'T003', 'jantan'),
(5, 2, 'T004', 'jantan'),
(6, 3, 'T005', 'jantan');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `monitoring`
--
ALTER TABLE `monitoring`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tikus` (`id_tikus`);

--
-- Indeks untuk tabel `sampel`
--
ALTER TABLE `sampel`
  ADD PRIMARY KEY (`id_sampel`);

--
-- Indeks untuk tabel `tikus`
--
ALTER TABLE `tikus`
  ADD PRIMARY KEY (`id_tikus`),
  ADD KEY `id_sampel` (`id_sampel`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `monitoring`
--
ALTER TABLE `monitoring`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `sampel`
--
ALTER TABLE `sampel`
  MODIFY `id_sampel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tikus`
--
ALTER TABLE `tikus`
  MODIFY `id_tikus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `monitoring`
--
ALTER TABLE `monitoring`
  ADD CONSTRAINT `monitoring_ibfk_1` FOREIGN KEY (`id_tikus`) REFERENCES `tikus` (`id_tikus`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tikus`
--
ALTER TABLE `tikus`
  ADD CONSTRAINT `tikus_ibfk_1` FOREIGN KEY (`id_sampel`) REFERENCES `sampel` (`id_sampel`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
