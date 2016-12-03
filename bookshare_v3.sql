-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2016 at 10:56 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bookshare_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(11) NOT NULL,
  `account_name` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `year_level` varchar(60) NOT NULL,
  `course` varchar(100) NOT NULL,
  `account_imagepath` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_name`, `username`, `password`, `year_level`, `course`, `account_imagepath`) VALUES
(1, 'Allyn Joy Calcaben', 'allyn_jdc', '30edf65dc2e7c3e3d0b8fe0533131600', '3rd year', 'BS in Computer Science', '../uploads/2014XXXXX-Calcaben_AD.jpg'),
(2, 'Jessa Palquiran', 'Jessa', '53eec0fc40b3cca6bec7e1ff240d6daf', '2nd_year', 'History', '../uploads/00201415953_photo_201415953-Palquiran_JS.jpg'),
(3, 'Ellana Mantana', 'Yan_Ligaya', '168ae69d79e0a9f5977cbba89c582450', '1st_year', 'Business Administration', '../uploads/201437456-Mantana_EP.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `account_contacts`
--

CREATE TABLE `account_contacts` (
  `contact_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `contact_number` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_contacts`
--

INSERT INTO `account_contacts` (`contact_id`, `account_id`, `contact_number`) VALUES
(1, 1, '09203437936'),
(2, 1, '09306668814'),
(3, 2, '09123223431'),
(4, 3, '09231358493');

-- --------------------------------------------------------

--
-- Table structure for table `account_emails`
--

CREATE TABLE `account_emails` (
  `email_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_emails`
--

INSERT INTO `account_emails` (`email_id`, `account_id`, `email`) VALUES
(1, 1, 'calcabenallynjoy@gmail.com'),
(2, 1, 'calcabenajd@yahoo.com'),
(3, 2, 'palquiranjessamae@gmail.com'),
(4, 3, 'mantanaej@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `bookmark_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `book_name` varchar(100) NOT NULL,
  `book_edition` varchar(10) DEFAULT NULL,
  `book_price` int(11) NOT NULL,
  `book_desc` varchar(200) NOT NULL,
  `book_imagepath` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `account_id`, `book_name`, `book_edition`, `book_price`, `book_desc`, `book_imagepath`) VALUES
(1, 1, 'Introduction to Physics', '9th Ed', 450, '', '../uploads/2013_Intro_to_Physics.jpg'),
(2, 1, 'An Introduction to Programming using Alice 2.2', '2nd Ed', 150, '', '../uploads/2014_An_Into_to_Programming_using_Alice2.2.jpg'),
(3, 1, 'The Official Ubuntu Book ', '5th Ed', 500, '', '../uploads/2014_The_Official_Ubuntu_Book.jpg'),
(4, 1, 'Calculus: For Business, Economics, and the Social and Life Sciences ', '7th Ed', 250, '', '../uploads/2015_Calculus.jpg'),
(5, 1, 'Discrete Mathematics for Computer Scientists ', NULL, 250, '', '../uploads/2015_Discrete_Mathematics_for_CS.jpg'),
(6, 1, 'Java Programming: Problem Analysis to Program Design', '5th Ed', 350, '', '../uploads/2015_Java_Programming.jpg'),
(7, 1, 'Data Structures and Algorithms in Java ', '2nd Ed', 350, '', '../uploads/2016_Data_Structures_&_Algorithms_in_Java.jpg'),
(8, 1, 'Database Management Systems', '8th Ed', 400, '', '../uploads/2016_Database_Management_Systems.jpg'),
(9, 1, 'Fundamentals of Statistical Analysis', NULL, 200, '', '../uploads/2016_Fundamentals_of_Statistical_Analysis.jpg'),
(10, 1, 'Software Engineering', NULL, 450, '', '../uploads/2016_Software_Engineering.jpg'),
(11, 2, 'Our Daily Dictionary', '8th', 139, 'An awesome dictionary with full of astonishing words.', '../uploads/dictionary.jpg'),
(12, 3, 'The Catholic Youth Bible', '1st', 245, 'Pray it. Study it. Live it.', '../uploads/bible.jpg'),
(13, 3, 'Managerial Accounting', '4th', 387, 'International Student version', '../uploads/managerial.jpg'),
(14, 3, 'Accounting Information Systems', '13th', 598, 'Best reference book to those who were taking up Accounting Technology.', '../uploads/acc.jpg'),
(15, 3, 'Selling to Women', '', 359, 'Good book for Business Administration students.', '../uploads/Selling-to-Women-9781938635014.jpg'),
(16, 2, 'History of the Filipino People', '', 975, 'Philippine History', '../uploads/history.jpg'),
(17, 2, 'Noli Me Tangere', '', 239, 'edited by Emerlinda G. Cruz', '../uploads/noli_me_tangere.jpg'),
(18, 2, 'Adventures of an Accidental Sociologist', '', 450, 'Good Reference Book for Sociology students', '../uploads/socio.jpg'),
(19, 2, 'Government is Good', '', 649, 'A political study in USA.', '../uploads/polsci.png'),
(20, 3, 'Transcending Self-Interest', '', 739, 'Psychological explorations of the quiet ego.', '../uploads/psycho.jpg'),
(21, 3, 'Child, Family, and Community', '6th', 429, 'Basic reference book for Community Development students.', '../uploads/Child Family Community.jpg'),
(22, 1, 'Veterinary, Hematology and Clinical Chemistry', '2nd', 349, 'A reference book for Chemistry major students.', '../uploads/chem.jpg'),
(23, 1, 'Mastering Public Health', '2nd', 569, 'A post graduate guide to examinations and revalidation.', '../uploads/pub.jpg'),
(24, 1, 'Campbell: Biology', '10th', 740, 'Good reference book for Biology major students.', '../uploads/campbell.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `book_info`
--

CREATE TABLE `book_info` (
  `info_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_subject` varchar(60) NOT NULL,
  `book_pages` int(11) NOT NULL,
  `book_quality` varchar(60) NOT NULL,
  `book_author` varchar(150) NOT NULL,
  `book_details` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_info`
--

INSERT INTO `book_info` (`info_id`, `book_id`, `book_subject`, `book_pages`, `book_quality`, `book_author`, `book_details`) VALUES
(1, 1, 'Physics ', 1008, '40%', 'John D. Cutnell,\r\nKenneth W. Johnson', 'Covered with tape. It has a name sticker on its front Cover Page as a sign of ownership. Has ballpen & pencil marks on some pages.'),
(2, 2, 'Computer Science ', 345, '60%', 'Charles W. Herbert ', 'Covered with cellophane cover. It has my name & signature on the 1st Page. '),
(3, 3, 'Computer Science ', 401, '80%', 'Benjamin Mako Hill,\r\nMatthew Helmke,\r\nCorey Burger', '(with Installer Disk) Covered with cellophane cover. It has my name & signature on the 2nd Page as a\r\nsign of ownership.'),
(4, 4, 'Mathematics', 723, '60%', 'Gerald L. Bradley,\r\nLaurence D. Hoffmann ', 'Covered with cellophane cover. It has my name & signature on the 2nd Page as a\r\nsign of ownership.  Has pencil marks on some pages.'),
(5, 5, 'Computer Science ', 496, '60%', 'Cliff L. Stein,\r\nRobert Drysdale,\r\nKenneth Bogart ', 'Covered with cellophane cover. It has my name & signature on the 2nd Page as a\r\nsign of ownership.  Has pencil marks on some pages.'),
(6, 6, 'Computer  Science', 1009, '60%', 'D.S. Malik', 'Covered with cellophane cover. It has my name & signature on the 3rd Page as asign of ownership. Has pencilmarks on some pages.'),
(7, 7, 'Computer Science ', 752, '60%', 'Adam Drozdek', 'Covered with cellophane cover. It has only my name & signature on the 1st Page as a sign of ownership.  Has pencil marks on some pages. '),
(8, 8, 'Computer Science ', 413, '80%', 'Philip J. Pratt,\r\nMary Z. Last ', 'Covered with cellophane cover. It has only my name & signature on the 1st Page as a sign of ownership.  Has pencil\r\nmarks on some pages.'),
(9, 9, 'Statistics', 245, '80%', 'Cole P.Pineda, \r\nMarilou T. Nepa,\r\net al. ', 'Covered with cellophane cover. It has only my name & signature on the 1st Page as a sign of ownership. Has pencil\r\nmarks on some pages.'),
(10, 10, 'Computer Science', 461, '90%', 'c/o McGraw-Hill: Create', ''),
(11, 11, 'Literature', 0, '', 'Meriam Webster', 'The book was covered with love.'),
(12, 12, 'Political Science', 0, '', 'St. Marys Press', 'Covered with plastic cellophane cover.'),
(13, 13, 'Management', 0, '', 'James Jiambalvo', 'Some pages were stained but the content still readable.'),
(14, 14, 'Accountancy', 0, '', 'Marshall Romney, Paul John Steinbart', 'Covered with thick cellophane cover. Has my name and signature at the first page of this book.'),
(15, 15, 'Business Administration', 0, '', 'Connie Podesta', 'Some pages has pencil marks.'),
(16, 16, 'History', 0, '', 'Teodoro Agoncillo ft. Alfonso', 'Some pages were torn due to the oldness.'),
(17, 17, 'Literature', 0, '', 'Dr. Jose Rizal', 'Cover with plastic cellophane'),
(18, 18, 'Sociology', 0, '', 'Peter Berger', 'Covered with plastic cellophane. '),
(19, 19, 'Political Science', 0, '', 'Douglas Amy', 'Has a ballpoint pen marks in some pages.'),
(20, 20, 'Psychology', 0, '', 'Heidi Wayment, Jack Bauer', 'covered with plastic cellophane and has ballpoint pen marks in some pages.'),
(21, 21, 'Community Development', 0, '', 'Janet Gonzalez-Mena', 'Has my name and signature on the first page of this book.'),
(22, 22, 'Chemistry', 0, '', 'Mary Thrall, Robin Allison, et al.', 'covered by plastic cellophane and has pencil marks in some pages.'),
(23, 23, 'Public Health', 0, '', 'Tim Crayford, Jamie Bernal, et al.', 'Covered with plastic cellophane with my name and signature on the first page of this book.'),
(24, 24, 'Biology', 0, '', 'Reece, Meyers, Urry, et al.', 'Has ballpoint pen marks in some pages and has my name & signature on the first page of this book.');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_no` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_no`, `seller_id`, `book_id`, `buyer_id`, `date`) VALUES
(1, 1, 3, 3, '2016-11-28 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_no` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message_number` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_no`, `message_id`, `message_number`, `seller_id`, `buyer_id`, `date`) VALUES
(1, 2, 1, 2, 1, '2016-11-09 04:14:35'),
(2, 1, 2, 1, 2, '2016-11-17 05:05:00'),
(3, 1, 3, 3, 1, '2016-11-11 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `message_content`
--

CREATE TABLE `message_content` (
  `message_id` int(1) NOT NULL,
  `message_details` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_content`
--

INSERT INTO `message_content` (`message_id`, `message_details`) VALUES
(1, ' You have purchased the following book(s) from me:'),
(2, ' I have purchased the following book(s) from you:');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `account_contacts`
--
ALTER TABLE `account_contacts`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `account_emails`
--
ALTER TABLE `account_emails`
  ADD PRIMARY KEY (`email_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `book_info`
--
ALTER TABLE `book_info`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_no`),
  ADD KEY `transaction_id` (`seller_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_no`);

--
-- Indexes for table `message_content`
--
ALTER TABLE `message_content`
  ADD PRIMARY KEY (`message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `account_contacts`
--
ALTER TABLE `account_contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `account_emails`
--
ALTER TABLE `account_emails`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `book_info`
--
ALTER TABLE `book_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_contacts`
--
ALTER TABLE `account_contacts`
  ADD CONSTRAINT `account_contacts_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

--
-- Constraints for table `account_emails`
--
ALTER TABLE `account_emails`
  ADD CONSTRAINT `account_emails_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

--
-- Constraints for table `book_info`
--
ALTER TABLE `book_info`
  ADD CONSTRAINT `book_info_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `cart_ibfk_4` FOREIGN KEY (`seller_id`) REFERENCES `account` (`account_id`);
