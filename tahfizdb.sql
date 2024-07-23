-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2024 at 02:03 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tahfizdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classID` varchar(10) NOT NULL,
  `className` varchar(30) NOT NULL,
  `classCount` int NOT NULL,
  `staffID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classID`, `className`, `classCount`, `staffID`) VALUES
('1', 'IBNU SINA', 5, '3'),
('2', 'IBNU RUSYD', 5, '4'),
('3', 'IBNU KHALDUN', 5, '5'),
('4', 'IBNU ABBAS', 6, '6'),
('5', 'IBNU JAMIL', 5, '7');

-- --------------------------------------------------------

--
-- Table structure for table `registered_students`
--

CREATE TABLE `registered_students` (
  `studentIC` varchar(14) NOT NULL,
  `studentName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registered_students`
--

INSERT INTO `registered_students` (`studentIC`, `studentName`) VALUES
('090517115359', 'Rashdan'),
('090613100216', 'Aqilah'),
('090726060212', 'Lina'),
('090819115262', 'Afiqah'),
('091224140522', 'Farah'),
('100522060213', 'Mohd Farhan'),
('100608063003', 'Osman'),
('100608110915', 'Haziq'),
('100719070821', 'Irfan'),
('100917060512', 'Qaleeda'),
('101114081295', 'Hakim'),
('110101050910', 'Nadia'),
('110314090302', 'Siti'),
('110407021986', 'Wardah'),
('110501100346', 'Aisyah'),
('111212060814', 'Aminah'),
('120208060916', 'Helle'),
('140323110351', 'Hazreen'),
('140404010713', 'Abdullah'),
('140511120423', 'Azman'),
('140830080145', 'Adam'),
('141023010415', 'Wan Fakhrul'),
('141122334455', 'Mizi'),
('141208051128', 'Syahidatul');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` varchar(10) NOT NULL,
  `staffName` varchar(30) NOT NULL,
  `staffEmail` varchar(30) NOT NULL,
  `staffContact` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `qualification` varchar(30) NOT NULL,
  `staffRole` varchar(30) NOT NULL,
  `staffPass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `staffName`, `staffEmail`, `staffContact`, `qualification`, `staffRole`, `staffPass`) VALUES
('1', 'Musa Kilman', 'musa1234@gmail.com', '012-9742288', 'PHD', 'Principal', '123456'),
('2', 'Haris Iskandar', 'haris1234@gmail.com', '015-9875899', 'Master ', 'Clerk', '123456'),
('3', 'Siti Zubaidah', 'siti1234@yahoo.com', '012-9858899', 'Master of Arab', 'Instructor', '123456'),
('4', 'Ahmad Fakrul', 'fakrul123@yahoo.com', '012-6805520', 'Master', 'Instructor', '123456'),
('5', 'Zakwan Arif', 'zakwan@yahoo.com', '017-3259855', 'Master', 'Instructor', '123456'),
('6', 'Aisyah Puteri', 'aisyah123@yahoo.com', '017-8902266', 'Master', 'Instructor', '123456'),
('7', 'Syahim', 'syahim@yahoo.com', '012-4568899', 'Degree', 'Instructor', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentIC` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `studentPass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `studentName` varchar(30) NOT NULL,
  `studentAge` int NOT NULL,
  `studentEmail` varchar(30) NOT NULL,
  `studentAddress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `guardianName` varchar(30) NOT NULL,
  `guardianContact` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(2) NOT NULL,
  `classID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentIC`, `studentPass`, `studentName`, `studentAge`, `studentEmail`, `studentAddress`, `guardianName`, `guardianContact`, `status`, `classID`) VALUES
('090613100216', '123456', 'Aqilah', 15, 'aqilah@yahoo.com', 'No 3, Jalan Subang 3, Taman Pantai ', 'Farizal', '019-1259863', 'A', '5'),
('090726060212', '123456', 'Lina', 15, 'lina@gmail.com', 'No 67, Jalan Dato Irsyad, Taman Iman ', 'Aiman', '019-5421199', 'A', '4'),
('090819115262', '123456', 'Afiqah', 15, 'fiqah@gmail.com', 'No 52, Jalan Dato Tengku, Taman Bujang', 'Zafrul', '019-7802265', 'A', '4'),
('091224140522', '123456', 'Farah', 15, 'farah@gmail.com', 'No 26, Jalan Seksyen 8, Taman Yoi Ming', 'Rasyiqah', '018-9846625', 'A', '3'),
('100522060213', '123456', 'Mohd Farhan', 14, 'farhan@yahooo.com', 'No 3, Jalan Subang 3, Taman Kasih', 'Rosmadi Nur', '012-9856985', 'A', '4'),
('100608063003', '123456', 'Osman', 14, 'osman1234@gmail.com', 'No 37, Jalan Subang Jaya, Taman Pandan', 'Rosmadi', '012-5852246', 'NA', '1'),
('100608110915', '123456', 'Haziq', 14, 'haziq@gmail.com', 'No 58, Jalan Dato Seri, Taman Bahagia', 'Irfan', '012-5478899', 'A', '5'),
('100719070821', '123456', 'Irfan', 14, 'irfan@gmail.com', 'No 1, Jalan Kaya, Taman Riang Ria', 'Tarmizi', '014-9742214', 'A', '4'),
('100917060512', '123456', 'Qaleeda', 14, 'qalee@gmail.com', 'No 32, Jalan Kubang Buaya, Taman Kasturi', 'Aqil Syukry', '014-9861132', 'NA', '1'),
('101114081295', '123456', 'Hakim', 14, 'hakim22@gmail.com', 'No 35, Jalan Tengku Kahar, Taman Berjalan', 'Razin', '011-6395547', 'A', '3'),
('110101050910', '123456', 'Nadia', 13, 'nadia@yahoo.com', 'No 9, Jalan Hutan Bintang, Taman Al Jamil', 'Syukry', '018-9635588', 'A', '1'),
('110314090302', '123456', 'Siti', 13, 'siti@yahoo.com', 'No 56, Jalan Sultan Ahmad, Taman Damansara', 'Daniel', '018-5236647', 'A', '2'),
('110407021986', '123456', 'Wardah', 13, 'wardah@gmail.com', 'No 20, Jalan Kampung Sungai, Taman Pantai Cik', 'Iqmal', '019-9852279', 'A', '2'),
('110501100346', '123456', 'Aisyah', 13, 'aisyah@gmail.com', 'No 18, Jalan Dato Ismail, Taman Seri Perdana', 'Rosmadi', '012-3258866', 'A', '1'),
('111212060814', '123456', 'Aminah', 13, 'aminah123@yahoo.com', 'No 98, Jalan Lembing Nipis, Taman Astana Permai', 'Zameer', '018-5294436', 'A', '2'),
('120208060916', '123456', 'Helle', 12, 'helle@gmail.com', 'No 42, Jalan Sembang Jaya, Taman Pandan', 'Dollah Sai', '015-7744577', 'NA', '1'),
('140323110351', '123456', 'Hazreen', 21, 'aqilah@yahoo.com', 'No 18, Jalan Dato Ismail, Tama', 'amakfafa', '012-9806915', 'A', '4'),
('140404010713', '123456', 'Abdullah', 10, 'abdullah123@gmail.com', 'No 18, Jalan IM 14/7, Taman Indah 4', 'Saidi Man', '012-9806915', 'A', '4'),
('140511120423', '123456', 'Azman', 10, 'azman@gmail.com', 'No 98, Jalan Dato Jalil, Taman Bersatu 2', 'Aziz', '019-1259944', 'A', '2'),
('140830080145', '123456', 'Adam', 10, 'adam@gmail.com', 'No 78, Jalan Gerbang 3, Taman Gelap', 'Dollah', '015-7744545', 'A', '5'),
('141023010415', '123456', 'Wan Fakhrul', 10, 'fakhrul123@yahoo.com', 'No 17, Jalan Sultan Mahmud, Taman Damai', 'Suhaila', '012-6329985', 'A', '3'),
('141122334455', '123456', 'Mizi', 10, 'abdulah@yahoo.com', 'No 18, Jalan Dato Ismail, Tama', 'Rosmadi', '012-9806915', 'A', '3'),
('141208051128', '123456', 'Syahidatul', 10, 'syahi123@gmail.com', 'No 33, Jalan IM 16/8, Taman Indah 2', 'Rizlan', '012-5684497', 'A', '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classID`),
  ADD KEY `staffID` (`staffID`);

--
-- Indexes for table `registered_students`
--
ALTER TABLE `registered_students`
  ADD PRIMARY KEY (`studentIC`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentIC`),
  ADD KEY `classID` (`classID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `staffID` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
