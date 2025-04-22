-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 05:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_watching_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `uname`, `pwd`, `email`) VALUES
(6, 'admin', 'admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `c_id` int(255) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_post` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `c_id`, `c_name`, `c_post`) VALUES
(1, 1, 'Comedy', 0),
(2, 2, 'Horror', 0),
(3, 3, 'Action', 0),
(4, 4, 'Thriller', 0),
(5, 5, 'Drama', 0),
(6, 6, 'Crime', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `mes`) VALUES
(1, 'user', 'user@gmail.com', 'this is user'),
(2, 'user2', 'golivih877@intady.com', 'i want an avenger endgame movie'),
(4, 'fhg', 'user@gmail.com', 'sdc');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `user_id`, `movie_id`) VALUES
(1, 5, 1),
(2, 5, 2),
(4, 5, 14),
(5, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `m_des` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `director` varchar(255) NOT NULL,
  `vid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `m_name`, `m_des`, `date`, `img`, `lang`, `director`, `vid`) VALUES
(1, 'Dhoom Dhaam', 'On their wedding night, an oddball couple gets entangled in a chaotic chase, dodging both goons and the police as they desperately search for Charlie.', '2025-02-14', 'images.jpg', 'Hindi', 'Rishab Sheth', 'http://localhost/project81/thumb/Recording%202025-03-17%20232405.mp4'),
(2, 'Hisaab Barabar', 'The film follows an ordinary man who stumbles upon a discrepancy in his bank account and courageously takes on the challenge of uncovering a billion-dollar scam by a corporate bank.', '2025-01-24', 'download.webp', 'Hindi', 'Ashwani Dhir', 'http://localhost/project81/thumb/Hisaab.Barabar.2025.1080p.HEVC.Hindi.WEB-DL.5.1.ESub.x265-HDHub4u.Tv.mkv'),
(4, ' Pushpa 2: The Rule', 'Pushpa 2 The Rule was theatrically released on December 5 2024 and is a sequel to the 2021 hit Pushpa  The Rise starring Allu Arjun Rashmika Mandanna and Fahadh Faasil with the film also available on Netflix with an extended cut. ', '2025-01-17', 'pushpa.jpg', 'Hindi', 'Sukumar', 'http://localhost/project81/thumb/Pushpa-2.The.Rule.2024.HQ.1080p.Hindi-ORG.HDRip.DD2.0.x264-HDHub4u.Tv.mp4'),
(5, 'Phir Hera Pheri', 'Phir Hera Pheri (2006) follows the comedic misadventures of Raju, Shyam, and Baburao, who find themselves entangled in a scam orchestrated by Anuradha, leading them into debt with a dreaded gangster, and they must find a way to repay the loan', '2006-07-21', 'download.jpg', 'Hindi', 'Neeraj Vora', 'http://localhost/project81/thumb/videoplayback.mp4'),
(6, 'The Shawshank Redemption', 'Two imprisoned men form a deep friendship over many years, finding solace and eventual redemption through acts of common decency.', '1994-09-23', 'download (1).jpg', 'English', 'Frank Darabont', 'http://localhost/project81/thumb/Mr.Bachchan.2024.1080p.10Bit.WEB-DL.Hindi.2.0-Telugu.5.1.HEVC.x265-HDHub4u.Tv.mkv'),
(7, 'The Godfather', ' The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', '1972-03-24', 'download (2).jpg', 'English', 'Francis Ford Coppola', 'http://localhost/project81/thumb/Hisaab.Barabar.2025.1080p.HEVC.Hindi.WEB-DL.5.1.ESub.x265-HDHub4u.Tv.mkv'),
(8, 'The Dark Knight', 'When the menace known as The Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham.', '2008-07-18', 'download (3).jpg', 'English', ' Christopher Nolan', 'http://localhost/project81/thumb/Mr.Bachchan.2024.1080p.10Bit.WEB-DL.Hindi.2.0-Telugu.5.1.HEVC.x265-HDHub4u.Tv.mkv'),
(9, 'Pulp Fiction', 'The lives of two mob hitmen a boxer a gangster wife and a pair of diner bandits intertwine in four tales of violence and redemption.', '1994-10-14', 'download (1).jpg', 'English', 'Quentin Tarantino', 'http://localhost/project81/thumb/Pushpa-2.The.Rule.2024.HQ.1080p.Hindi-ORG.HDRip.DD2.0.x264-HDHub4u.Tv.mp4'),
(10, 'Lagaan', ' In 1893, a small village in India is oppressed by high taxes. A young man challenges the British rulers to a cricket match to avoid paying the taxes.', '1995-09-10', 'download.jpg', 'Hindi', 'Ashutosh Gowariker', 'http://localhost/project81/thumb/Pushpa-2.The.Rule.2024.HQ.1080p.Hindi-ORG.HDRip.DD2.0.x264-HDHub4u.Tv.mp4'),
(11, '3 Idiots', 'Three engineering students are part of a life-changing journey as they challenge the conventional ways of learning and living.', '2009-12-25', 'download (2).jpg', 'Hindi', 'Rajkumar Hirani', 'http://localhost/project81/thumb/videoplayback.mp4'),
(12, 'Dilwale Dulhania Le Jayenge (DDLJ)', 'A young man and woman fall in love during a trip to Europe, but their journey to marriage is complicated by cultural traditions and family expectations.', '1995-08-20', 'download (3).jpg', 'Hindi', 'Aditya Chopra', 'http://localhost/project81/thumb/Pushpa-2.The.Rule.2024.HQ.1080p.Hindi-ORG.HDRip.DD2.0.x264-HDHub4u.Tv.mp4'),
(13, 'Bajrangi Bhaijaan', 'A devout man embarks on a journey to reunite a mute, lost Pakistani girl with her family across the border.', '2016-03-24', 'download.jpg', 'Hindi', 'Kabir Khan', 'http://localhost/project81/thumb/Mr.Bachchan.2024.1080p.10Bit.WEB-DL.Hindi.2.0-Telugu.5.1.HEVC.x265-HDHub4u.Tv.mkv'),
(14, 'Zindagi Na Milegi Dobara', 'Three friends reunite for a road trip in Spain that challenges their views on life, love, and friendship.', '2011-06-15', 'download (2).jpg', 'Hindi', 'Zoya Akhtar', 'http://localhost/project81/thumb/Hisaab.Barabar.2025.1080p.HEVC.Hindi.WEB-DL.5.1.ESub.x265-HDHub4u.Tv.mkv');

-- --------------------------------------------------------

--
-- Table structure for table `movie_categories`
--

CREATE TABLE `movie_categories` (
  `movie_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_categories`
--

INSERT INTO `movie_categories` (`movie_id`, `category_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(2, 4),
(2, 5),
(4, 3),
(4, 4),
(5, 1),
(5, 5),
(6, 4),
(6, 5),
(7, 4),
(7, 6),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(9, 1),
(9, 4),
(9, 5),
(9, 6),
(10, 5),
(11, 1),
(11, 5),
(12, 5),
(13, 1),
(13, 5),
(14, 5);

-- --------------------------------------------------------

--
-- Table structure for table `movie_views`
--

CREATE TABLE `movie_views` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `view_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_views`
--

INSERT INTO `movie_views` (`id`, `movie_id`, `view_count`) VALUES
(1, 10, 2),
(2, 8, 3),
(3, 9, 5),
(4, 5, 1),
(5, 2, 1),
(6, 14, 2),
(7, 13, 2),
(8, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recently_watched`
--

CREATE TABLE `recently_watched` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `watched_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recently_watched`
--

INSERT INTO `recently_watched` (`id`, `user_id`, `movie_id`, `watched_at`) VALUES
(1, 5, 14, '2025-03-29 16:34:42'),
(2, 5, 1, '2025-03-29 16:32:33'),
(4, 5, 9, '2025-04-06 12:31:36'),
(6, 5, 10, '2025-03-30 06:57:06'),
(7, 5, 5, '2025-03-30 06:58:54'),
(8, 5, 2, '2025-03-30 07:00:24'),
(9, 5, 8, '2025-04-08 05:10:14'),
(10, 5, 4, '2025-04-08 05:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `movie_id`, `rating`, `review`, `created_at`) VALUES
(1, 5, 14, 1, 'it is good movie', '2025-03-23 12:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uname`, `pwd`, `email`) VALUES
(5, 'user', 'user', 'user@gmail.com'),
(6, 'domin', 'domin', 'domin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `user_id`, `action`, `movie_id`, `created_at`) VALUES
(1, 5, 'Watched Movie', 10, '2025-03-30 06:57:06'),
(2, 5, 'Added to Watchlist', NULL, '2025-03-30 06:57:21'),
(3, 5, 'Watched Movie', 5, '2025-03-30 06:58:54'),
(4, 5, 'Added to Watchlist', NULL, '2025-03-30 06:59:04'),
(5, 5, 'Watched Movie', 2, '2025-03-30 07:00:24'),
(6, 5, 'Added to Watchlist', 2, '2025-03-30 07:00:30'),
(7, 5, 'Watched Movie', 9, '2025-04-06 12:31:36'),
(8, 5, 'Watched Movie', 8, '2025-04-08 05:10:14'),
(9, 5, 'Watched Movie', 4, '2025-04-08 05:11:09'),
(10, 5, 'Added to Watchlist', 14, '2025-04-08 05:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`id`, `user_id`, `movie_id`, `created_at`) VALUES
(12, 5, 12, '2025-03-30 06:12:56'),
(14, 5, 5, '2025-03-30 06:59:04'),
(15, 5, 2, '2025-03-30 07:00:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_categories`
--
ALTER TABLE `movie_categories`
  ADD PRIMARY KEY (`movie_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `movie_views`
--
ALTER TABLE `movie_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `recently_watched`
--
ALTER TABLE `recently_watched`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `movie_views`
--
ALTER TABLE `movie_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `recently_watched`
--
ALTER TABLE `recently_watched`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Constraints for table `movie_categories`
--
ALTER TABLE `movie_categories`
  ADD CONSTRAINT `movie_categories_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `movie_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `movie_views`
--
ALTER TABLE `movie_views`
  ADD CONSTRAINT `movie_views_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recently_watched`
--
ALTER TABLE `recently_watched`
  ADD CONSTRAINT `recently_watched_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recently_watched_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_activity_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
