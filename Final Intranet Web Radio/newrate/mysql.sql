-- with Sample Data:
--
-- Table structure for table `tut_starRating`
--


--
-- Table structure for table `tut_starRating`
--

CREATE TABLE `tut_starRating` (
  `articleId` smallint(6) NOT NULL,
  `votes` smallint(6) NOT NULL default '0',
  `rating` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`articleId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tut_starRating`
--

INSERT INTO `tut_starRating` (`articleId`, `votes`, `rating`) VALUES
(1, 343, 2461),
(2, 257, 1861),
(3, 207, 1484),
(4, 177, 1233),
(144, 141, 992),
(10, 119, 838),
(6, 110, 802),
(5, 154, 1116);