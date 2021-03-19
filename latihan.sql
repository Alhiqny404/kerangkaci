-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 19 Mar 2021 pada 15.43
-- Versi server: 5.6.38
-- Versi PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `latihan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(7, 'Dashboard'),
(9, 'ajax');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'User'),
(25, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_menu`
--

CREATE TABLE `role_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `role_menu`
--

INSERT INTO `role_menu` (`id`, `menu_id`, `role_id`) VALUES
(1, 1, 1),
(7, 2, 1),
(3, 2, 2),
(4, 3, 1),
(9, 7, 1),
(11, 9, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `url` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `sub_menu`
--

INSERT INTO `sub_menu` (`id`, `menu_id`, `title`, `icon`, `url`, `is_active`) VALUES
(1, 1, 'Dashboard', 'fas fa-fw fa-tachometer-alt', 'dashboard', 1),
(2, 2, 'My Profile', 'fas fa-fw fa-user', 'User', 1),
(3, 3, 'Menu Group', 'fas fa-fw fa fa-folder', 'menu', 1),
(4, 3, 'Sub Menu', 'fas fa-fw fa-folder-open', 'dashboard/system/submenu', 1),
(5, 1, 'Role', 'fas fa-fw fa-user', 'dashboard/role', 1),
(6, 2, 'Edit Profile', 'fas fa-fw fa-user-edit', 'user/edit', 1),
(10, 2, 'Ganti Password', 'fa fw fa-edit', 'user/ganti-password', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(125) NOT NULL,
  `email` varchar(125) NOT NULL,
  `password` varchar(300) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `limit_salah` int(10) NOT NULL,
  `is_active` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `created_at` int(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `avatar`, `limit_salah`, `is_active`, `role_id`, `created_at`) VALUES
(7, 'Abror', 'admin@admin.com', '$2y$10$g/GlBAqUD65R/5WL2ExR7uf3a/O0zloxDWhV9O8075kgO5LpoioNq', 'avatar.png', 0, 1, 1, 1613835483),
(12, 'Abror', 'muhammadalhiqny@gmail.com', '$2y$10$UdEo4IfHh8hTel9/m8IWg.rjJFc6aRObFRsWbctjfPP/Hbm07WCgS', 'avatar.png', 0, 0, 2, 1616001320),
(11, 'Alhiqny', 'usepfesbuk@gmail.com', '$2y$10$/FIzFbBG0zAw97.c93S8UehO9Maki3ZnPVsL2Z98Qh/BtCMfP5Rn6', 'avatar.png', 0, 1, 2, 1616001272);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `created_at`) VALUES
(4, 'muhammadalhiqny@gmail.com', 'DlaZ4SRIiA4yCUNlv7/pAtk9yphBZLU1u2ZGxwfwmvY=', 1616001320);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `role_menu`
--
ALTER TABLE `role_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
