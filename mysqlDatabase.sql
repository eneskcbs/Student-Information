-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 29 Ağu 2022, 06:51:32
-- Sunucu sürümü: 5.5.68-MariaDB
-- PHP Sürümü: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `admin_enes`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `course`
--

INSERT INTO `course` (`id`, `name`) VALUES
(1, 'Matematik'),
(2, 'Fizik'),
(3, 'Kimya'),
(4, 'Biyoloji'),
(5, 'Ekoloji'),
(6, 'Sistematik'),
(1125, 'CoÄŸrafya');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exam_result`
--

CREATE TABLE `exam_result` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `score` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `exam_result`
--

INSERT INTO `exam_result` (`id`, `student_id`, `course_id`, `score`) VALUES
(0, 12658, 1, 1),
(0, 12658, 2, 2),
(0, 12658, 3, 3),
(0, 12658, 4, 4),
(0, 332, 2, 3),
(0, 12658, 1, 50),
(0, 12658, 2, 5),
(0, 12658, 5, 8);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `number` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gsm_number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `student`
--

INSERT INTO `student` (`id`, `full_name`, `number`, `email`, `gsm_number`) VALUES
(1, 'Enes KOCABAS', 12658, 'enes.kcbs2@gmail.com', '05532208722'),
(10, 'Best Student', 3334, 'troya_asas@hotmail.com', '5655565665'),
(11, 'Test Student', 1345566, '343243234', '4324324324'),
(12, 'Nurdan Ok', 332, 'enes.kcbs32@gmail.com', '5655565665');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `_web_adminusers`
--

CREATE TABLE `_web_adminusers` (
  `id` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `passmd5` varchar(50) NOT NULL,
  `passNormal` varchar(50) NOT NULL,
  `register_time` datetime NOT NULL,
  `last_login_time` datetime NOT NULL,
  `last_login_ip` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `_web_adminusers`
--

INSERT INTO `_web_adminusers` (`id`, `uname`, `passmd5`, `passNormal`, `register_time`, `last_login_time`, `last_login_ip`) VALUES
(1, 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '123456', '2021-09-07 20:14:32', '2022-08-29 13:49:43', '172.69.199.146');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `_web_adminusers`
--
ALTER TABLE `_web_adminusers`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `_web_adminusers`
--
ALTER TABLE `_web_adminusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
