-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 07, 2021 at 08:25 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thoughts`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` tinyint(4) NOT NULL,
  `bookTitle` varchar(100) NOT NULL,
  `bookAuthor` varchar(100) NOT NULL,
  `bookISBN` varchar(50) NOT NULL,
  `bookReleaseDate` varchar(50) NOT NULL,
  `bookCoverImage` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `bookTitle`, `bookAuthor`, `bookISBN`, `bookReleaseDate`, `bookCoverImage`, `created_at`, `updated_at`) VALUES
(1, 'The Overstory', 'Richard Powers', '9780393635522', 'April 3, 2018', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'The Martian', 'Andy Weir', '9780804139021', '2011', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'The Hate U Give', 'Angie Thomas', '9780062498533)', 'Feb 28, 2017', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FThe_Hate_U_Give&psig=AOvVaw1xrDfJedY1tHXi03lQkxHs&ust=1634576620950000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKDFisn20fMCFQAAAAAdAAAAABAD', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'The Subtle Art of Not Giving a F*ck', 'Mark Manson', '9780062457714', '2016', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '12 Rules for Life', 'Jordan B. Peterson', '9780141988511', '2018', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` tinyint(4) NOT NULL,
  `post_id` tinyint(4) NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `content` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 'Oh I sooo wish that there\'d had been more in-depth detail like Weir had in the book. I have to respect the information they kept in though!', '2021-10-15 14:19:48', '2021-11-13 00:44:42'),
(3, 5, 5, 'this is no longer just a test comment', '2021-10-17 13:14:52', '2021-12-06 20:41:09'),
(4, 3, 11, 'I really enjoy adventure/sci-fi genres. But also auto-biographies', '2021-10-17 13:14:52', '0'),
(5, 4, 3, 'Come on this isn\'t the bEst movie ever, sure it has its moments and characters but surely there\'s something better out there.', '2021-10-17 13:15:51', '0'),
(6, 1, 2, 'I agree!', '2021-10-17 13:16:53', '0');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` tinyint(4) NOT NULL,
  `movieTitle` varchar(250) NOT NULL,
  `movieDirector` varchar(250) NOT NULL,
  `movieReleaseDate` varchar(100) NOT NULL,
  `movieCoverImage` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movieTitle`, `movieDirector`, `movieReleaseDate`, `movieCoverImage`, `created_at`, `updated_at`) VALUES
(1, 'The Martian', 'Ridley Scott', 'October 2, 2015', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.amazon.com%2FMartian-Matt-Damon%2Fdp%2FB017S3OP7A&psig=AOvVaw2eyqH3gqojn87RSG6di0NQ&ust=1634407849601000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIjxtuyBzfMCFQAAAAAdAAAAABAF', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'No Time To Die', 'Cary Joji Fukunaga', 'October 8, 2021', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Black Widow', 'Cate Shortland', 'July 9, 2021', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Its a Wonderful Life', 'Frank Capra', 'January 7, 1947', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.amazon.com%2FIts-Wonderful-Life-60th-Anniversary%2Fdp%2FB000HEWEJO&psig=AOvVaw0ZVb6SlCIKpNaJBrwL-1yA&ust=1634576986784000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCPj9nff30fMCFQAAAAAdAAAAABAI', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Avengers: Endgame', 'Anthony Russo; Joe Russo', 'April 26, 2019', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.imdb.com%2Ftitle%2Ftt4154796%2F&psig=AOvVaw0d6kJl5Gv_F-5mdZ1t-Vty&ust=1634577073255000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCOD5o6D40fMCFQAAAAAdAAAAABAD', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Eternals', 'Some dude who had too much money', 'sometime last week', NULL, '2021-11-13 01:10:20', '2021-11-13 01:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` tinyint(4) NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` varchar(250) NOT NULL,
  `book_id` tinyint(4) DEFAULT NULL,
  `movie_id` tinyint(4) DEFAULT NULL,
  `created_at` varchar(110) NOT NULL,
  `updated_at` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `title`, `content`, `book_id`, `movie_id`, `created_at`, `updated_at`) VALUES
(1, 11, 'This Book is Crazyyyyy Good!', 'The Overstory is just a beautiful journey through multiple people\'s perspectives. I would HIGHLY recommend it.', 1, NULL, '2021-10-15 13:02:40', '0000-00-00 00:00:00'),
(2, 3, 'What do we think about the transition of The Martian from book to movie?', 'Personally, I think the movie did a great job of portraying most of the content covered in the book. However, I will always be a book over movie person.', 2, 1, '2021-10-13 13:02:40', '2021-11-12 21:50:38'),
(3, 4, 'What\'s your favorite type of genre to read?', 'I want to see what the communities favorite genre is! Let me know what your favorite genre is and maybe some books from that genre too!', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 'Can we Nominate This for #1 Movie of all time?', 'Avengers Endgame might be the biggest and best moment of cinematic history. A decade of storytelling brought together in a three hour-long epic', NULL, 5, '2021-10-17 13:12:34', '0000-00-00 00:00:00'),
(5, 5, 'This is a test post', 'This is a test post content', NULL, NULL, '2021-10-17 13:14:17', '0000-00-00 00:00:00'),
(7, 4, 'this was a good time', 'blah blah blah', NULL, NULL, '2021-11-12 21:55:07', '2021-11-12 21:55:07'),
(8, 4, 'this was a good time', 'blah blah blah', 2, NULL, '2021-11-12 21:55:29', '2021-11-12 21:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `value` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token_id`, `user_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, '5998899533b219624ae399b6ae5419e01cdaaf83a26f997d4d3ef1c970bf77d489ffacdfda72263915349423d576786fa4c2405725f3f094908632d6e9f4f6eb', '2019-11-26 18:35:07', '2020-12-03 00:06:56'),
(2, 2, '02c181c78e937fd6039c11b852cbc57f917926c64722787c95a47edc5c3519220d3ef764802753e9a232132a34e63eccfe6b', '2019-11-26 18:35:07', '2019-11-26 18:35:07'),
(3, 3, '02c181c78e937fd6039c11b852cbc57f917926c64722787c95a47edc5c3519220d3ef764802753e9a232132a34e63eccfe6c', '2019-11-26 18:35:17', '2019-11-26 18:35:17'),
(4, 4, '02c181c78e937fd6039c11b852cbc57f917926c64722787c95a47edc5c3519220d3ef764802753e9a232132a34e63eccfe6d', '2019-11-26 18:35:17', '2019-11-26 18:35:17'),
(7, 5, '4f95b82de35bc5e5a073ee1f93ef1d861e7f1722a90367f8ea532bfc1f7444a2525fbe58bcf0c9c2c814d4ee7980331cecd8f83a8006d24a24b607757ddb6e09', '2019-11-30 04:04:27', '2020-12-03 05:07:10'),
(8, 9, '390aeebdc4442ffc87000256f47bcb6aa6a8eff3dc68459f019d7a6516ebc4211eaf66be2e5e697f95ee114fe3fd81302b2e30b2640474d5dd9b809dd267eadc', '2021-12-07 13:22:46', '2021-12-07 13:22:46'),
(9, 11, 'cc2cb6c2c73e9913eeb39cc229bde22c9825ad44e8771ffb42abfc55a95da200e20b6a56dd71b636836b4c6045c5fb47b6c59daa26fe67b4c019f0cf8e692658', '2021-12-07 13:28:23', '2021-12-07 13:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` tinyint(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` varchar(110) NOT NULL,
  `updated_at` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `username`, `password`, `created_at`, `updated_at`) VALUES
(2, 'Brandon', 'Pepper', 'bpepper@gmail.com', 'brandonpepper', 'brandonpepper', '2021-11-12 21:29:46', '2021-11-12 21:29:46'),
(3, 'Taylor', 'Young', 'tyoung@gmail.com', 'tayloryoung', 'tayloryoung', '2021-11-12 21:29:46', '2021-11-12 21:29:46'),
(4, 'James', 'Myers', 'jmyers@gmail.com', 'jamesmyers', 'jamesmyers', '2021-11-12 21:29:46', '2021-11-12 21:29:46'),
(5, 'Admin', 'Admin', 'admin@gmail.com', 'admin', 'admin', '2021-11-12 21:29:46', '2021-11-12 21:29:46'),
(9, 'hi', 'hi', 'hi@gmail.com', 'hi', '$2y$10$9W1z1DRvL6fn12pXI2YV5ekXYgdrDYg.4negkk/wQ3UYUwMSmH6dS', '2021-12-03 23:48:53', '2021-12-03 23:48:53'),
(11, 'Jaron', 'Kempson', 'jronkemp@gmail.com', 'jronkemp', '$2y$10$4TZmwfPZ90K2XZCz6xq25.KzL6hPxa0SfXUEYGst/fhEDOt5md./6', '2021-12-07 08:25:28', '2021-12-07 08:25:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `movie_id` (`movie_id`) USING BTREE,
  ADD KEY `book_id` (`book_id`) USING BTREE;

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
