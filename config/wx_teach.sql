-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015-03-08 16:41:44
-- 服务器版本: 5.5.41-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wx_teach`
--

-- --------------------------------------------------------

--
-- 表的结构 `sign_in`
--

CREATE TABLE IF NOT EXISTS `sign_in` (
  `nums` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增字段无意义',
  `date` int(11) unsigned NOT NULL COMMENT '签到日期',
  `time` int(11) unsigned NOT NULL COMMENT '签到时间',
  `issign` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否签到１是０否',
  `sid` int(10) unsigned NOT NULL COMMENT '学号（索引）',
  `latitude` varchar(11) COLLATE utf8_estonian_ci NOT NULL COMMENT '纬度',
  `longitude` varchar(11) COLLATE utf8_estonian_ci NOT NULL COMMENT '经度',
  PRIMARY KEY (`nums`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci COMMENT='学生签到表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '学生id',
  `openid` varchar(32) NOT NULL COMMENT '微信openid',
  `snum` varchar(8) NOT NULL COMMENT '学号',
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `classes` varchar(8) NOT NULL COMMENT '班级',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生信息表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
