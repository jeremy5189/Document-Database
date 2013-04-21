CREATE TABLE IF NOT EXISTS `interview` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `schoolClass` int(11) NOT NULL,
  `schoolName` varchar(30) NOT NULL,
  `schoolDepart` varchar(30) NOT NULL DEFAULT '',
  `schoolResult` varchar(5) DEFAULT NULL,
  `studentClass` int(11) NOT NULL,
  `studentName` varchar(10) NOT NULL,
  `studentPhone` varchar(10) NOT NULL,
  `studentEmail` varchar(100) NOT NULL DEFAULT '',
  `studentGradeChinese` int(11) NOT NULL,
  `studentGradeEnglish` int(11) NOT NULL,
  `studentGradeMath` int(11) NOT NULL,
  `studentGradeSocial` int(11) NOT NULL,
  `studentGradeScience` int(11) NOT NULL,
  `studentGradeTotal` int(11) NOT NULL,
  `interviewMethod` text NOT NULL,
  `interviewApplying` text NOT NULL,
  `interviewDetail` text NOT NULL,
  `interviewPaperTest` text NOT NULL,
  `interviewOpinion` text NOT NULL,
  `createTime` datetime NOT NULL,
  `createUser` varchar(15) NOT NULL,
  `lastEditTime` datetime NOT NULL,
  `lastEditUser` varchar(15) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `interviewUser` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `displayName` varchar(20) NOT NULL,
  `authLevel` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

