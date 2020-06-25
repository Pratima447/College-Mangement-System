-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2019 at 07:46 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET AUTOCOMMIT = 0;
-- START TRANSACTION;
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentmanagement`
--
-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(11) NOT NULL,
  `loginid` varchar(250) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- -- --
-- -- -- Dumping data for table `credentials` for admin
-- -- --

INSERT INTO `credentials` (`id`,`loginid`, `password`) VALUES
(1, 'admin', 'admin');

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `courses`
-- --

CREATE TABLE `courses` (
  `cid` int(11) NOT NULL,
  `cshort` varchar(250) DEFAULT NULL,
  `cfull` varchar(250) DEFAULT NULL,
  `cdate` varchar(50) DEFAULT NULL,
  `update_date` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --
-- -- Indexes for table `courses`

ALTER TABLE `courses`
  ADD PRIMARY KEY (`cid`);

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `sub_id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `cshort` varchar(50) DEFAULT NULL,
  `subject_name` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -- --
-- -- -- Indexes for table `courses`
-- -- --
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`sub_id`);


-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
    `sid` int(11) NOT NULL,
    `cid` int(11) NOT NULL,
    `subjects` varchar(250) NOT NULL,
    `sub_ids` varchar(250) NOT NULL,
    `fname` varchar(250) NOT NULL,
    `mname` varchar(250) NOT NULL,
    `lname` varchar(250) NOT NULL,
    `gender` varchar(50) NOT NULL,
    `guard_name` varchar(250) NOT NULL,
    `occupation` varchar(50) NOT NULL,
    `income` varchar(250) NOT NULL,
    `category` varchar(250) NOT NULL,
    `phy_challenged` varchar(250) NOT NULL,
    `nationality` varchar(250) NOT NULL,
    `mobile` varchar(50) NOT NULL,
    `email_id` varchar(250) NOT NULL,
    `perm_address` varchar(300) NOT NULL,
    `board_1` varchar(250) NOT NULL,
    `roll_no_1` varchar(50) NOT NULL,
    `percent_1` varchar(50) NOT NULL,
    `pass_year_1` varchar(50) NOT NULL,
    `board_2` varchar(250) NOT NULL,
    `roll_no_2` varchar(250) NOT NULL,
    `percent_2` varchar(250) NOT NULL,
    `pass_year_2` varchar(50) NOT NULL,
    `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `reg_no` varchar(250) NOT NULL,
    `dob` date
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --
-- -- Indexes for table `registration`
-- --
ALTER TABLE `students`
  ADD PRIMARY KEY (`sid`);

-- Adding password COLUMN

ALTER TABLE `students`
    ADD COLUMN `password` int(50) DEFAULT NULL;
-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `lecturers`
-- --


CREATE TABLE `lecturers` (
  `lid` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `qualification` varchar(250) DEFAULT NULL,
  `gender` varchar(50) NOT NULL,
  `join_date` date DEFAULT NULL,
  `perm_address` varchar(300) NOT NULL,
  `password` varchar(300)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -- -- --
-- -- -- -- Indexes for table `lecturers`
-- -- -- --
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`lid`);


-- -- --------------------------------------------------------

-- --
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `did` int(11) NOT NULL,
  `dshort` varchar(250) DEFAULT NULL,
  `dfull` varchar(250) DEFAULT NULL,
  `cdate` varchar(50) DEFAULT NULL,
  `update_date` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- -- Indexes for table `departments`

ALTER TABLE `departments`
  ADD PRIMARY KEY (`did`);

-- --
-- Table structure for table `time table course and sem`
--

CREATE TABLE `tt_course_sem` (
  `c_s_d_id` int(11) NOT NULL,
  `cid` int(11)  DEFAULT NULL,
  `cshort` varchar(250) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `day` varchar(200) DEFAULT NULL,
  `course_sem_day` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- -- -- --
-- -- -- -- Indexes for table `tt_course_sem`
-- -- -- --

ALTER TABLE `tt_course_sem`
  ADD PRIMARY KEY (`c_s_d_id`);


-- --
-- Table structure for table `time table course and sem`
--

CREATE TABLE `time_table_daily` (
  `tid` int(11) NOT NULL,
  `course_sem_day` varchar(200) DEFAULT NULL,
  `day` varchar(200) DEFAULT NULL,
  `start_time` TIME DEFAULT NULL,
  `end_time` TIME DEFAULT NULL,
  `sub_id` int(11) NOT NULL,
  `subject`  varchar(200) DEFAULT NULL,
  `lect_id` int(11) NOT NULL,
  `lecturer` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- -- -- -- --
-- -- -- -- -- Indexes for table `time_table_daily`
-- -- -- -- --

ALTER TABLE `time_table_daily`
  ADD PRIMARY KEY (`tid`);



-- --
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
    `stud_id` int(11) NOT NULL,
    `sub_id` int(11) NOT NULL,
    `lect_id` int(11) NOT NULL,
    `student_name` varchar(250) NOT NULL,
    `subject_name` varchar(250) NOT NULL,
    `lect_name` varchar(250) NOT NULL,
    `day` varchar(200) DEFAULT NULL,
    `start_time` TIME DEFAULT NULL,
    `end_time` TIME DEFAULT NULL,
    `presence`int(10) DEFAULT 0 ,

    FOREIGN KEY (stud_id) REFERENCES students(sid),
    FOREIGN KEY (sub_id) REFERENCES subjects(sub_id),
    FOREIGN KEY (lect_id) REFERENCES lecturers(lid)

) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dumping values in attendance

INSERT INTO `attendance`
    SELECT `students`.`sid`, `time_table_daily`.`sub_id`,`time_table_daily`.`lect_id`, 
    concat(`students`.`fname`,' ',`students`.`mname`) as `student_name`, `time_table_daily`.`subject`, 
    `time_table_daily`.`lecturer`,`time_table_daily`.`day`,`time_table_daily`.`start_time`,`time_table_daily`.`end_time`,0

    FROM `time_table_daily`,`students`
    WHERE FIND_IN_SET(`time_table_daily`.`sub_id`, `students`.`sub_ids`);


--
-- Table structure for table `internal_marks`


CREATE TABLE `internal_marks` (
    `c_id` int(11) NOT NULL,
    `stud_id` int(11) NOT NULL,
    `sub_id` int(11) NOT NULL,
    `lect_id` int(11) NOT NULL,
  	`semester` varchar(50) DEFAULT NULL,
    `reg_no` varchar(250) NOT NULL,
    `student_name` varchar(250) NOT NULL,
    `subject_name` varchar(250) NOT NULL,
    `lect_name` varchar(250) NOT NULL,
    `session` int(11) DEFAULT 0,
	  `marks` int (11) DEFAULT 0,

    FOREIGN KEY (c_id) REFERENCES courses(cid),
    FOREIGN KEY (stud_id) REFERENCES students(sid),
    FOREIGN KEY (sub_id) REFERENCES subjects(sub_id),
    FOREIGN KEY (lect_id) REFERENCES lecturers(lid)

) ENGINE=InnoDB DEFAULT CHARSET=latin1;




-- Table structure for table `queries`

CREATE TABLE `queries` (
    `qid` int(11) NOT NULL,
    `stud_id` int(11) NOT NULL,
    `sub_id` int(11) NOT NULL,
    `lect_id` int(11) DEFAULT 0,
    `student_name` varchar(250) NOT NULL,
    `subject_name` varchar(250) NOT NULL,
    `lect_name` varchar(250) DEFAULT NULL,
    `question` varchar(250) DEFAULT NULL,
    `request_time` timestamp DEFAULT CURRENT_TIMESTAMP,
    `answer` varchar(250) DEFAULT NULL,
    `solution_time` int  DEFAULT NULL,
    `solved` int(11) DEFAULT 0

) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- -- -- -- --
-- -- -- -- -- Indexes for table `queries`
-- -- -- -- --

ALTER TABLE `queries`
    ADD PRIMARY KEY (`qid`);