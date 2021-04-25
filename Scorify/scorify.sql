-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql110.byetcluster.com
-- Generation Time: Jun 02, 2020 at 01:38 AM
-- Server version: 5.6.47-87.0
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_25903260_scorify`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `name`, `id_user`) VALUES
('G0001', 'Nigel', 2),
('G0002', 'Hari', 4),
('G0003', 'Steve Rogers', 7);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `name`) VALUES
('IF0001', 'A'),
('IF0002', 'B'),
('IF0003', 'C'),
('IF0004', 'D'),
('IF0005', 'E'),
('IF0006', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `manage_kelas`
--

CREATE TABLE `manage_kelas` (
  `id_manage` int(11) NOT NULL,
  `id_kelas` varchar(255) NOT NULL,
  `id_siswa` varchar(255) NOT NULL,
  `id_guru` varchar(255) NOT NULL,
  `id_mata_pelajaran` varchar(255) NOT NULL,
  `nilai_tugas` int(11) NOT NULL DEFAULT '0',
  `nilai_uts` int(11) NOT NULL DEFAULT '0',
  `nilai_uas` int(11) NOT NULL DEFAULT '0',
  `nilai_akhir` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manage_kelas`
--

INSERT INTO `manage_kelas` (`id_manage`, `id_kelas`, `id_siswa`, `id_guru`, `id_mata_pelajaran`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_akhir`) VALUES
(1, 'IF0001', 'S0001', 'G0001', 'P0001', 80, 80, 83, 81),
(9, 'IF0001', 'S0004', 'G0001', 'P0001', 0, 0, 0, 0),
(4, 'IF0002', 'S0002', 'G0001', 'P0001', 0, 0, 0, 0),
(5, 'IF0002', 'S0001', 'G0001', 'P0003', 0, 0, 0, 0),
(6, 'IF0003', 'S0004', 'G0003', 'P0010', 45, 43, 51, 46),
(7, 'IF0004', 'S0003', 'G0003', 'P0007', 87, 98, 76, 87),
(8, 'IF0004', 'S0005', 'G0002', 'P0007', 80, 80, 80, 80);

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id_mata_pelajaran` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id_mata_pelajaran`, `name`) VALUES
('P0001', 'Web Programming'),
('P0002', 'Object Oriented Programming'),
('P0003', 'Rekayasa Piranti Lunak'),
('P0005', 'Software Project Manager'),
('P0004', 'Numerical Method'),
('P0006', 'Computer Security'),
('P0007', 'English 1'),
('P0008', 'English 2'),
('P0009', 'English 3'),
('P0010', 'Bahasa Indonesia'),
('P0011', 'Civics'),
('P0012', 'Kewarganegaraan'),
('P0013', 'Pengantar Teknologi Informasi'),
('P0014', 'AI'),
('P0015', 'Database System');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` text NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2020-05-10-231723', 'App\\Database\\Migrations\\CreateRoleTable', 'default', 'App', 1590904671, 1),
(2, '2020-05-10-231730', 'App\\Database\\Migrations\\CreateUserTable', 'default', 'App', 1590904671, 1),
(3, '2020-05-10-232138', 'App\\Database\\Migrations\\CreateKelasTable', 'default', 'App', 1590904671, 1),
(4, '2020-05-10-234746', 'App\\Database\\Migrations\\CreateGuruTable', 'default', 'App', 1590904671, 1),
(5, '2020-05-11-003214', 'App\\Database\\Migrations\\CreateMataPelajaranTable', 'default', 'App', 1590904671, 1),
(6, '2020-05-11-003215', 'App\\Database\\Migrations\\CreatesiswaTable', 'default', 'App', 1590904671, 1),
(7, '2020-05-11-003216', 'App\\Database\\Migrations\\CreateAlokasiKelasTable', 'default', 'App', 1590904671, 1),
(8, '2020-05-17-160846', 'App\\Database\\Migrations\\CreateNotificationTable', 'default', 'App', 1590904671, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id_notification` int(11) NOT NULL,
  `from_id_user` int(11) NOT NULL,
  `to_id_user` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `read` varchar(10) NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id_notification`, `from_id_user`, `to_id_user`, `message`, `read`) VALUES
(1, 3, 2, 'S0001-Marco mengajukan peninjauan nilai kelas [IF0001]A', 'true'),
(2, 3, 2, 'S0001-Marco mengajukan peninjauan nilai kelas [IF0001]A', 'true'),
(3, 2, 1, 'Nigel[2] asking for edit profile permission', 'true'),
(4, 3, 2, 'S0001-Marco mengajukan peninjauan nilai kelas [IF0001]A', 'true'),
(5, 2, 1, 'Nigel[2] asking for edit profile permission', 'true'),
(6, 2, 1, 'Nigel[2] asking for edit profile permission', 'true'),
(7, 3, 1, 'Marco[3] asking for edit profile permission', 'true'),
(8, 2, 1, 'Nigel[2] asking for edit profile permission', 'true'),
(9, 3, 2, 'S0001-Marco mengajukan peninjauan nilai kelas [IF0001]A', 'true'),
(10, 2, 1, 'Nigel[2] asking for edit profile permission', 'true'),
(11, 2, 1, 'Nigel Felim[2] asking for edit profile permission', 'true'),
(12, 5, 2, 'S0002-Devin mengajukan peninjauan nilai kelas [IF0002]B', 'true'),
(13, 8, 7, 'S0004-Tony Stark mengajukan peninjauan nilai kelas [IF0003]C', 'true'),
(14, 8, 7, 'S0004-Tony Stark mengajukan peninjauan nilai kelas [IF0003]C', 'false'),
(15, 7, 1, 'Steve Rogers[7] asking for edit profile permission', 'true'),
(16, 4, 1, 'Hari[4] asking for edit profile permission', 'true'),
(17, 9, 4, 'S0005-Darsen  mengajukan peninjauan nilai kelas [IF0004]D', 'true'),
(18, 4, 1, 'Hari[4] Meminta Izin Edit Profile', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `name`) VALUES
('R0001', 'admin'),
('R0002', 'guru'),
('R0003', 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `name`, `id_user`) VALUES
('S0001', 'Marco', 3),
('S0003', 'josh', 6),
('S0002', 'Devin', 5),
('S0004', 'Tony Stark', 8),
('S0005', 'Darsen ', 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `id_role` varchar(255) NOT NULL,
  `izin_edit` varchar(10) NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `name`, `birthdate`, `id_role`, `izin_edit`) VALUES
(1, 'admin@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Admin', '2000-10-31', 'R0001', 'true'),
(2, 'nigel@gmail.com', 'ac104ff596d79b3a890e851b9f80fdc4c0690ea00c5bb9a28e3d80a7f680cad6', 'Nigel', '1995-05-29', 'R0002', 'false'),
(3, 'marco@gmail.com', '7c8ccc86c11654af029457d90fdd9d013ce6fb011ee8fdb1374832268cc8d967', 'Marco', '2006-10-31', 'R0003', 'false'),
(4, 'hari@gmail.com', 'f7b3781c5eafc2779a96bae2e4875a83ecce46f198e9f81916521d9d218c7da7', 'Hari', '2000-11-04', 'R0002', 'false'),
(5, 'devin@gmail.com', '5792d2981981be5a2677cd353db6f55cd9d2779570061ae8d86176635b3cc745', 'Devin', '2000-08-23', 'R0003', 'false'),
(6, 'josh@gmail.com', '386a85d8c88778b00b1355608363c7e3078857f3e9633cfd0802d3bf1c0b5b83', 'josh', '2000-09-19', 'R0003', 'false'),
(7, 'steve@gmail.com', 'f148389d080cfe85952998a8a367e2f7eaf35f2d72d2599a5b0412fe4094d65c', 'Steve Rogers', '1938-04-11', 'R0002', 'false'),
(8, 'tony@gmail.com', 'e9e326d5f3b4741fe5967b5f9f3997e6275331ba18567ef9ef9e0e3a00e78371', 'Tony Stark', '1991-12-18', 'R0003', 'false'),
(9, 'darsen@gmail.com', 'ecac8d20b3ce36a8e78a6bb46e01b4a667ee4848e7bb45b56299da8c2a0b95e7', 'Darsen ', '2020-04-10', 'R0003', 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `manage_kelas`
--
ALTER TABLE `manage_kelas`
  ADD PRIMARY KEY (`id_manage`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id_mata_pelajaran`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `user_id_role_foreign` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manage_kelas`
--
ALTER TABLE `manage_kelas`
  MODIFY `id_manage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
