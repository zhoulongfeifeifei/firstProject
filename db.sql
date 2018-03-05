-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-05-26 14:47:28
-- 服务器版本： 5.6.27
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `party`
--

-- --------------------------------------------------------

--
-- 表的结构 `edu_department`
--

CREATE TABLE IF NOT EXISTS `edu_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '名称',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `permission` text NOT NULL COMMENT '部门权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `edu_department`
--

INSERT INTO `edu_department` (`id`, `name`, `create_time`, `update_time`, `permission`) VALUES
(1, '管理员', 1454483852, 1457601925, 'items,items_lists,orders,orders_lists,jobs,jobs_lists,users,users_need_lists,users_give_lists,adverts,index_adv,message,push_lists,datas,datas_orders,system,employee,department'),
(2, '技术部', 1454489850, 1463109266, 'wechat_menu,wechat_menu,wechat_message,receive_msg,wechat_keywords,replay_lists,system,employee,department');

-- --------------------------------------------------------

--
-- 表的结构 `edu_employee`
--

CREATE TABLE IF NOT EXISTS `edu_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) unsigned NOT NULL COMMENT '部门id',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `account` varchar(20) NOT NULL COMMENT '账号',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `name` varchar(20) NOT NULL COMMENT '名字',
  `permission` text NOT NULL COMMENT '权限',
  `is_director` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 默认 1 超级管理员 2 部门主管',
  `create_time` int(11) NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `edu_employee`
--

INSERT INTO `edu_employee` (`id`, `did`, `fid`, `account`, `password`, `name`, `permission`, `is_director`, `create_time`, `update_time`) VALUES
(1, 1, 0, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '超级管理员', 'add_items,add_orders,add_jobs,edit_jobs,add_push_msg,add_employee,add_department,edit_department', 1, 1453283191, 0),
(17, 2, 0, 'test', 'e10adc3949ba59abbe56e057f20f883e', '123456', '', 2, 1463557702, 0),
(18, 2, 17, 'test2', 'e10adc3949ba59abbe56e057f20f883e', 'test2', 'del_receive_msg,add_keywords,edit_keywords,add_employee', 0, 1463557725, 0);

-- --------------------------------------------------------

--
-- 表的结构 `edu_wechat_keywords`
--

CREATE TABLE IF NOT EXISTS `edu_wechat_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `words` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `edu_wechat_keywords`
--

INSERT INTO `edu_wechat_keywords` (`id`, `words`, `status`, `create_time`, `update_time`) VALUES
(2, '文本', 1, 1463120044, 1463120050),
(3, '测试', 1, 1463472103, NULL),
(4, '图片', 1, 1463472114, NULL),
(5, '视频', 1, 1463472123, NULL),
(6, '说话', 1, 1463472130, NULL),
(7, '有人没', 1, 1463472140, NULL),
(8, '怎么玩', 1, 1463472148, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `edu_wechat_material`
--

CREATE TABLE IF NOT EXISTS `edu_wechat_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型 1 文本 2 图片 3  语音 4视频 5音乐 6图文',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `MediaId` varchar(100) DEFAULT NULL COMMENT '微信素材id',
  `title` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `contenturl` varchar(200) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `content` varchar(2000) NOT NULL,
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) NOT NULL,
  `start_time` int(10) NOT NULL,
  `end_time` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `edu_wechat_material`
--

INSERT INTO `edu_wechat_material` (`id`, `type`, `name`, `MediaId`, `title`, `description`, `contenturl`, `url`, `content`, `create_time`, `update_time`, `start_time`, `end_time`, `status`) VALUES
(1, 1, '关注回复文本', NULL, NULL, NULL, '', NULL, '感谢你的关注！', 1463480820, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `edu_wechat_menu`
--

CREATE TABLE IF NOT EXISTS `edu_wechat_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL DEFAULT '0',
  `sort` varchar(4) NOT NULL DEFAULT '0',
  `menu_name` varchar(40) DEFAULT NULL,
  `menu_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '对应自定义分类的type',
  `menu_content` varchar(200) NOT NULL COMMENT '自定义菜单中对应url／key',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 1可用 0禁用',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `edu_wechat_menu`
--

INSERT INTO `edu_wechat_menu` (`menu_id`, `fid`, `sort`, `menu_name`, `menu_type`, `menu_content`, `status`, `create_time`, `update_time`) VALUES
(1, 0, '0', '首页', 1, 'index', 1, 1463037816, NULL),
(3, 1, '0', '地图', 2, 'http://map.baidu.com', 1, 1463037933, NULL),
(5, 0, '0', '测试菜单', 2, 'http://120.26.117.129/', 1, 1463038314, 1463045002),
(6, 1, '0', '获取时间', 1, 'nowtime', 1, 1463038630, 1463042910),
(7, 0, '0', '休闲娱乐', 1, 'yl', 1, 1463041850, NULL),
(8, 7, '0', '时时彩计划', 2, 'http://120.26.117.129/api/index/ssc_plan', 1, 1463041926, NULL),
(9, 7, '0', '新浪', 2, 'http://sina.com.cn', 1, 1463041971, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `edu_wechat_message`
--

CREATE TABLE IF NOT EXISTS `edu_wechat_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '消息类型 0 默认 1 文本消息 2图片消息 3 语音消息 4 视频消息 5 小视频消息 6 地理位置消息 7 链接消息',
  `from` varchar(50) DEFAULT NULL COMMENT '发送来源',
  `to` varchar(100) DEFAULT NULL,
  `content` varchar(2000) DEFAULT NULL COMMENT '消息内容',
  `MediaId` varchar(100) DEFAULT NULL,
  `MsgId` varchar(64) DEFAULT NULL,
  `otherInfo` varchar(2000) DEFAULT NULL,
  `MediaLoc` varchar(200) DEFAULT NULL COMMENT '媒体文件本地路径',
  `create_time` int(10) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 未读 1 已读',
  `from_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '消息的类型 0 接收 1 回复',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `edu_wechat_message`
--

INSERT INTO `edu_wechat_message` (`id`, `type`, `from`, `to`, `content`, `MediaId`, `MsgId`, `otherInfo`, `MediaLoc`, `create_time`, `is_read`, `from_type`) VALUES
(1, 1, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', '文本', NULL, '6286661859124163561', NULL, NULL, 1463727527, 1, 0),
(2, 2, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', 'http://mmbiz.qpic.cn/mmbiz/bAdHkDXMh0mRII5Alzu57pbGZhyDX7icMYbmJ8HiaOY5I3weOMb5MgSCSxOY5Hp7J8Ng1uXh3CzlTJwGYcXDwFqQ/0', 'toMxYsYHZT386c8s1EvKyFjAU4vQsNtaWgO7kvPJA6V-0F1Qm7vKKpmMnfHe-xhd', '6286661962203378670', NULL, '/Static/data/message/obvQHwgf95-5daaVueoRhXBEsI8Y/image/2016/05/20/toMxYsYHZT386c8s1EvKyFjAU4vQsNtaWgO7kvPJA6V-0F1Qm7vKKpmMnfHe-xhd.jpg', 1463727551, 1, 0),
(3, 3, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', '哎！', 'SiVRm0oY-_v9GcGJ1z_R79XkwRldvn4Xao0pF0D4_F62S2RsuqzMI-F25qsqFHvY', '6286662030518648832', 'amr', '/Static/data/message/obvQHwgf95-5daaVueoRhXBEsI8Y/voice/2016/05/20/SiVRm0oY-_v9GcGJ1z_R79XkwRldvn4Xao0pF0D4_F62S2RsuqzMI-F25qsqFHvY.amr', 1463727567, 1, 0),
(4, 4, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', NULL, 'SJeZDigmsA8hoYHPOCvbV1K6k6k7cpAm-h94Wfc8hpUPvBsnYbH4d5ApDXInOKdg', '6286662529139061760', 'm7wVQFiJgSHBMqpeh8Y8Lcn-KpYeK_SLE_lrVVngz04b86pg4KB4FDvJGQSn_KIM', '/Static/data/message/obvQHwgf95-5daaVueoRhXBEsI8Y/video/2016/05/20/SJeZDigmsA8hoYHPOCvbV1K6k6k7cpAm-h94Wfc8hpUPvBsnYbH4d5ApDXInOKdg.mp4', 1463727683, 1, 0),
(5, 4, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', NULL, 'SJeZDigmsA8hoYHPOCvbV1K6k6k7cpAm-h94Wfc8hpUPvBsnYbH4d5ApDXInOKdg', '6286662529139061760', 'm7wVQFiJgSHBMqpeh8Y8Lcn-KpYeK_SLE_lrVVngz04b86pg4KB4FDvJGQSn_KIM', '/Static/data/message/obvQHwgf95-5daaVueoRhXBEsI8Y/video/2016/05/20/SJeZDigmsA8hoYHPOCvbV1K6k6k7cpAm-h94Wfc8hpUPvBsnYbH4d5ApDXInOKdg.mp4', 1463727683, 1, 0),
(6, 4, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', NULL, 'SJeZDigmsA8hoYHPOCvbV1K6k6k7cpAm-h94Wfc8hpUPvBsnYbH4d5ApDXInOKdg', '6286662529139061760', 'm7wVQFiJgSHBMqpeh8Y8Lcn-KpYeK_SLE_lrVVngz04b86pg4KB4FDvJGQSn_KIM', '/Static/data/message/obvQHwgf95-5daaVueoRhXBEsI8Y/video/2016/05/20/SJeZDigmsA8hoYHPOCvbV1K6k6k7cpAm-h94Wfc8hpUPvBsnYbH4d5ApDXInOKdg.mp4', 1463727683, 1, 0),
(7, 5, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', NULL, 'idlHZf4Awl3LqRxxICKxzQu0EB0YqES50-9SZmteZi3LPShTlP0MZ8CRx1z5z_XO', '6286662623628342277', '4oSJguVHEIj8ihuIc1lzEYbYXL28USa2ukvvDYyTxm3MC0owbeLR0SzZLuLoP6Tc', '/Static/data/message/obvQHwgf95-5daaVueoRhXBEsI8Y/shortvideo/2016/05/20/idlHZf4Awl3LqRxxICKxzQu0EB0YqES50-9SZmteZi3LPShTlP0MZ8CRx1z5z_XO.mp4', 1463727705, 1, 0),
(8, 6, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', '浙江省杭州市西湖区黄姑山路29号', NULL, '6286662859851543567', '30.275517_120.132607_16', NULL, 1463727760, 1, 0),
(9, 7, 'obvQHwgf95-5daaVueoRhXBEsI8Y', 'gh_db3668c953ce', 'http://mp.weixin.qq.com/s?__biz=MzA3MzUwOTIyMg==&mid=2650514016&idx=4&sn=fb918a89960497324a2fd1c05735c448&scene=2&srcid=05145ngi8fbDyAYvsen4QeB0&from=timeline&isappinstalled=0#rd', NULL, '6286662937160954899', 'a:2:{s:5:"Title";s:71:"银行卡被盗刷19万！他立即这样做，银行不得不赔↓↓";s:11:"Description";s:162:"银行卡明明就在自己身边，手机却收到了刷卡短信，这样盗刷银行卡的案例，我们已经见过很多次了。钱没了，是谁的责任";}', NULL, 1463727778, 1, 0),
(10, 1, NULL, 'obvQHwgf95-5daaVueoRhXBEsI8Y', '测试一下回车发送消息', NULL, NULL, NULL, NULL, 1463799387, 1, 0),
(11, 1, NULL, 'obvQHwgf95-5daaVueoRhXBEsI8Y', '/::)', NULL, NULL, NULL, NULL, 1463799426, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `edu_wechat_message_revert`
--

CREATE TABLE IF NOT EXISTS `edu_wechat_message_revert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `material_id` varchar(100) NOT NULL,
  `receive_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '接收类型 默认0 关键词回复 1 关注回复 2 图片回复 3 语音回复 4  视频  5  小视频  6 地理位置 7 链接  ',
  `revert_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '回复类型 0无 1 文本 2图片 3语音 4视频 5 音乐 6图文',
  `keywords_id` varchar(2000) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `edu_wechat_message_revert`
--

INSERT INTO `edu_wechat_message_revert` (`id`, `name`, `material_id`, `receive_type`, `revert_type`, `keywords_id`, `create_time`, `update_time`, `status`) VALUES
(1, '回复图片消息', '19,7', 2, 6, NULL, 1463474176, 1463477840, 0),
(3, '关注回复', '1', 1, 1, NULL, 1463474447, 1463480835, 1),
(5, 'sdfasf', '7,19', 2, 6, NULL, 1463477224, 1463477758, 0),
(6, '关键词回复', '1', 0, 1, '2,8,7,3', 1463536383, 1463536821, 1);

-- --------------------------------------------------------

--
-- 表的结构 `edu_wechat_service`
--

CREATE TABLE IF NOT EXISTS `edu_wechat_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(50) DEFAULT NULL COMMENT '客服帐号',
  `nickname` varchar(12) DEFAULT NULL,
  `kf_id` varchar(100) DEFAULT NULL COMMENT '微信客服工号',
  `password` varchar(32) DEFAULT NULL,
  `headimgurl` varchar(200) DEFAULT NULL COMMENT '客服头像',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_wechat_users`
--

CREATE TABLE IF NOT EXISTS `edu_wechat_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL,
  `nickname` varchar(30) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 未知 1男 2女',
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  `headimgurl` varchar(200) DEFAULT NULL,
  `unionid` varchar(100) DEFAULT NULL,
  `remark` varchar(500) NOT NULL,
  `groupid` varchar(100) NOT NULL,
  `tagid_list` varchar(100) NOT NULL,
  `subscribe` tinyint(1) DEFAULT '1',
  `qrcode_img` varchar(100) DEFAULT NULL COMMENT '二维码',
  `qrcode_time` int(10) DEFAULT NULL COMMENT '二维码生成时间',
  `qrcode_type` tinyint(1) DEFAULT '0' COMMENT '二维码类型 0 永久 1 临时',
  `no_read_msg` varchar(100) NOT NULL DEFAULT '0' COMMENT '未读消暑数',
  `recommend_id` int(11) NOT NULL DEFAULT '0' COMMENT '推荐人id （二维码扫描）',
  `subscribe_time` int(10) DEFAULT NULL,
  `unsubscribe_time` int(10) DEFAULT NULL COMMENT '取消关注时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `edu_wechat_users`
--

INSERT INTO `edu_wechat_users` (`id`, `openid`, `nickname`, `sex`, `city`, `province`, `country`, `language`, `headimgurl`, `unionid`, `remark`, `groupid`, `tagid_list`, `subscribe`, `qrcode_img`, `qrcode_time`, `no_read_msg`, `recommend_id`, `subscribe_time`, `unsubscribe_time`) VALUES
(1, 'obvQHwgf95-5daaVueoRhXBEsI8Y', '慧彼星', 1, '杭州', '浙江', '中国', 'zh_CN', 'http://wx.qlogo.cn/mmopen/PkXKn1XrJvSfoQeZ8vbwPbNs2aD8iaRTR0HJS0tE0ia8ZP5ibJ2wEbW63LsW3M14ox05muagicqE44laNC4yu2kTGzmWkYMiboXgM/0', NULL, '', '0', 'a:0:{}', 0, '/Static/data/uploads/qrcode/obvQHwgf95-5daaVueoRhXBEsI8Y_qrcode.jpg', 1464143216, '0', 0, 1463107252, 1463198567),
(2, 'obvQHwolDzY8lMcJiTD2KafMCkpI', 'NARUTO', 1, '杭州', '浙江', '中国', 'zh_CN', 'http://wx.qlogo.cn/mmopen/Besge3uSjh0SzWj8O5ctzY0PI8YRFHwHGAIqYdZVGEtPOMAbal4bC3NHZicCh0Sbu9NibDc88Asynw109UpGt13mpces7Cvj1e/0', NULL, '', '0', 'a:0:{}', 1, '/Static/data/uploads/qrcode/obvQHwolDzY8lMcJiTD2KafMCkpI_qrcode.jpg', 1464143217, '0', 0, 1463561375, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
