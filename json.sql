-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 19 Jun 2022 pada 13.00
-- Versi Server: 5.5.32
-- Versi PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `json`
--
CREATE DATABASE IF NOT EXISTS `json` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `json`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `level` int(11) NOT NULL,
  `token` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `token`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEiLCJ1c2VyIjoiYWRtaW4iLCJpYXQiOjE2MjA5NjYzMTYsImV4cCI6MTYyMDk4NDMxNn0.BNb6KplPy4ucWWUMxt1JB_MIE42dI6lLSDLLigJRmqI'),
(2, 'dodi', 'ca26331c6bfbf9487a7cde0f1f95644449e83baa', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjIiLCJ1c2VyIjoiZG9kaSIsImlhdCI6MTYyMTA0MTYxNywiZXhwIjoxNjIxMDU5NjE3fQ.cvfd1fZ7dU0d4no_CWdbca8B_e2qMGbSxYquJLBficY'),
(5, 'G.211.19.0019', '9365f235408320faf414189398d78342a153c3a3', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata`
--

CREATE TABLE IF NOT EXISTS `wisata` (
  `id_wisata` int(2) NOT NULL AUTO_INCREMENT,
  `kota` varchar(10) NOT NULL,
  `landmark` varchar(100) NOT NULL,
  `tarif` varchar(10) NOT NULL,
  PRIMARY KEY (`id_wisata`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `wisata`
--

INSERT INTO `wisata` (`id_wisata`, `kota`, `landmark`, `tarif`) VALUES
(1, 'SEMARANG', 'LAWANG SEWU', '20000'),
(2, 'YOGYAKARTA', 'PRAMBANAN', '35000'),
(3, 'MAGELANG', 'BOROBUDUR', '45000'),
(4, 'Surakarta', 'Pgs', 'Gratis');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
