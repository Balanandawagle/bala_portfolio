-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2026 at 02:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `issuer` varchar(200) NOT NULL,
  `issue_date` varchar(100) NOT NULL,
  `credential_url` varchar(255) DEFAULT '#',
  `skills_covered` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `title`, `issuer`, `issue_date`, `credential_url`, `skills_covered`, `display_order`, `is_visible`) VALUES
(1, 'MERN Stack Development', 'Evolve IT Hub', 'Dec 2024 · Expired Mar 2025', 'https://drive.google.com/file/d/1HsZTx2pWpYdjyjmT9QJQtWW_0tz1grFE/view', 'React.js, Node.js, Express.js, MongoDB', 1, 1),
(2, 'Beginner SEO with Semrush', 'Semrush', 'May 2025', 'https://static.semrush.com/academy/certificates/caea43d727/balananda-wagle_25.pdf', 'SEO, Keyword Research, On-Page SEO', 2, 1),
(3, 'Web Design Specialist', 'Broadway Infosys', 'Nov 2024 · Expired Feb 2025', 'https://drive.google.com/file/d/196sIIv3bVIYyYOOqCJJWxghkxpnQxuIh/view', 'Front-End Dev, Web Design, HTML/CSS', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) DEFAULT 'General Inquiry',
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'bala', 'wagle@gmail.com', 'let connect', 'i love your web', '2026-08-19 14:15:23'),
(14, 'john', 'hjon@gmail.com', 'haha', 'loce', '2026-08-20 02:35:07'),
(17, 'beda', 'beda@gmail.com', '', 'haha nice', '2026-08-20 03:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `degree` varchar(200) NOT NULL,
  `institution` varchar(200) NOT NULL,
  `gpa` varchar(50) NOT NULL,
  `timeline` varchar(100) NOT NULL,
  `skills_covered` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `degree`, `institution`, `gpa`, `timeline`, `skills_covered`, `display_order`, `is_visible`) VALUES
(1, 'Bachelor of Information Management (BIM)', 'Tribhuvan University', '3.72 / 4.0', 'Apr 2021 – Jan 2026', 'UED, CSS, Web Development, Database Management', 1, 1),
(2, '+2 High School (Science & Tech)', 'Milestone International College', '3.49 / 4.0', '2019 – 2021 · Graduated', 'Computer Science, Mathematics, Digital Communication', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `role_title` varchar(200) NOT NULL,
  `company` varchar(200) NOT NULL,
  `employment_type` varchar(100) DEFAULT 'Full-time',
  `timeline` varchar(100) NOT NULL,
  `location` varchar(150) DEFAULT 'Remote',
  `skills_used` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `role_title`, `company`, `employment_type`, `timeline`, `location`, `skills_used`, `display_order`, `is_visible`) VALUES
(1, 'Advanced AI Data Trainer', 'Invisible Technologies', 'Freelance', 'Jun 2024 - Present · 2 yrs 3 mos', 'United States · Remote', 'Technical Writing, Content Evaluation, AI Training & QA', 1, 1),
(2, 'Junior Digital Content Creator & Social Media', 'Neputer Tech', 'Full-time', 'Dec 2025 - Present · 9 mos', 'Kathmandu, Nepal · On-site', 'SEO, Google Search Console, Content Strategy', 2, 1),
(3, 'Tech Content Writer', 'Routine of Nepal Banda', 'Internship', 'Aug 2025 - Feb 2026 · 7 mos', 'Nepal · Remote', 'Tech Content Writing, Canva, Social Media Management', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL DEFAULT 1,
  `name` varchar(150) NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `hero_title` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `about_text` text NOT NULL,
  `status_text` varchar(100) DEFAULT 'Available for High-Impact Roles',
  `location` varchar(150) DEFAULT 'Kathmandu, Nepal',
  `email` varchar(150) DEFAULT 'wagleom@gmail.com',
  `resume_url` varchar(255) DEFAULT '#',
  `years_exp` int(11) DEFAULT 2,
  `articles_written` int(11) DEFAULT 600
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `name`, `tagline`, `hero_title`, `bio`, `about_text`, `status_text`, `location`, `email`, `resume_url`, `years_exp`, `articles_written`) VALUES
(1, 'Balananda', 'SEO Strategist · Frontend Engineer · Growth Hacker', 'Scaling Organic Reach & Engineering Modern Web Products', 'Data-backed SEO specialist, frontend developer, and content strategist driving real search traffic, conversion growth, and modern web applications.', '', 'Available for High-Impact Roles', 'Kathmandu, Nepal', 'wagleom@gmail.com', 'assets/resume_1787201342_650.pdf', 2, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tech_stack` varchar(255) NOT NULL,
  `project_url` varchar(255) DEFAULT '#',
  `image_path` varchar(255) DEFAULT 'assets/finance.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `tech_stack`, `project_url`, `image_path`) VALUES
(1, 'Corporate Website', 'Modern, high-performance corporate web solution built with Vite + React. Features sleek UI components, optimized assets, and responsive enterprise layouts.', 'React.js, Vite, HTML5, CSS3, JavaScript, Responsive UI', 'https://coroporate-website.vercel.app/', 'assets/finance.png'),
(2, 'E-commerce Platform', 'Full-featured online storefront application featuring interactive product catalogs, dynamic shopping cart management, and modern Bootstrap UI architecture.', 'React.js, Bootstrap, JavaScript, CSS3, State Management, GitHub', 'https://github.com/Balanandawagle/E-commerce-project', 'assets/ecommerce.png'),
(3, 'Travel & Tours Website', 'Dynamic, SEO-optimized tourism and tour booking platform built on Next.js. Features destination showcases, fast SSR page loading, and responsive itineraries.', 'Next.js, Bootstrap, React.js, SSR, SEO Optimization, UI/UX', 'https://travel-tours-website-rose.vercel.app/', 'assets/travel.png'),
(4, 'CelebWikiCorner — 600+ SEO Articles & Multi-Channel Growth', 'Authored 600+ search-intent celebrity biography articles driving compound organic search traffic, combined with automated multi-channel promotion across Instagram, Facebook, and YouTube.', 'SEO Strategy, Technical Writing, Keyword Silos, Instagram Growth, YouTube, Google Search Console', 'https://celebwikicorner.com/', 'assets/celebwikicorner.jpg'),
(5, 'Aayat Nepal — Social Media Brand Promotion & Logistics', 'Engineered visual marketing collateral, video campaigns, and social media brand positioning to scale awareness for cross-border logistics and retail imports.', 'Social Media Marketing, Brand Strategy, Canva Pro, Meta Ads, Video Copywriting, Logistics Funnels', 'https://www.instagram.com/aayatnepal/', 'assets/aayat.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `rating` decimal(2,1) DEFAULT 5.0,
  `display_order` int(11) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$w09uV91qE5O6F4J3G1uM5.5mC/4hW6w4X9u4X5A0qg7sW5p3C1H9e', '2026-08-20 02:43:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
