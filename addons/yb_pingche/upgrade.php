<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_access_token` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(400) DEFAULT NULL,
  `expires_in` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_access_token','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_access_token')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_access_token','access_token')) {pdo_query("ALTER TABLE ".tablename('yb_pc_access_token')." ADD   `access_token` varchar(400) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_access_token','expires_in')) {pdo_query("ALTER TABLE ".tablename('yb_pc_access_token')." ADD   `expires_in` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_access_token','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_access_token')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_ad_click` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `ad_img_id` int(11) DEFAULT '0',
  `m_id` bigint(20) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_ad_click','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_click')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_ad_click','ad_img_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_click')." ADD   `ad_img_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_click','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_click')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_click','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_click')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_ad_click','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_click')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_ad_info` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `a_id` int(11) DEFAULT '0',
  `nsort` int(11) DEFAULT '0',
  `file_path` varchar(255) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `isdel` tinyint(1) DEFAULT '1',
  `hits` int(11) DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `nclass` tinyint(1) DEFAULT '0',
  `xcx_path` varchar(100) DEFAULT NULL,
  `xcx_param` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_ad_info','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_ad_info','a_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `a_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_info','nsort')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `nsort` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_info','file_path')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `file_path` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_ad_info','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_ad_info','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `isdel` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_ad_info','hits')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `hits` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_info','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `nstatus` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_info','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_info','nclass')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `nclass` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_info','xcx_path')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `xcx_path` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_ad_info','xcx_param')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_info')." ADD   `xcx_param` varchar(100) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_ad_seat` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `width` int(11) DEFAULT '0',
  `height` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '1',
  `file_path` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  `ntype` int(1) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_ad_seat','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_ad_seat','name')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `name` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_ad_seat','width')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `width` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_seat','height')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `height` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_seat','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_ad_seat','num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_seat','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_ad_seat','file_path')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `file_path` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_ad_seat','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_ad_seat','ntype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_ad_seat')." ADD   `ntype` int(1) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_admin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `truename` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `reason` varchar(100) DEFAULT NULL,
  `regtime` datetime DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  `loginip` varchar(20) DEFAULT NULL,
  `logintime` datetime DEFAULT NULL,
  `headimg` varchar(100) DEFAULT 'logo.png',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_admin','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD 
  `id` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_admin','username')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `username` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_admin','password')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `password` varchar(32) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_admin','truename')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `truename` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_admin','status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `status` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_admin','reason')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `reason` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_admin','regtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `regtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_admin','num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_admin','loginip')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `loginip` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_admin','logintime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `logintime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_admin','headimg')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `headimg` varchar(100) DEFAULT 'logo.png'");}
if(!pdo_fieldexists('yb_pc_admin','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_admin')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_adminlog` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT '0',
  `logintime` int(11) DEFAULT '0',
  `loginip` varchar(30) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_adminlog','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_adminlog')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_adminlog','admin_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_adminlog')." ADD   `admin_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_adminlog','logintime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_adminlog')." ADD   `logintime` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_adminlog','loginip')) {pdo_query("ALTER TABLE ".tablename('yb_pc_adminlog')." ADD   `loginip` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_adminlog','username')) {pdo_query("ALTER TABLE ".tablename('yb_pc_adminlog')." ADD   `username` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_adminlog','password')) {pdo_query("ALTER TABLE ".tablename('yb_pc_adminlog')." ADD   `password` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_adminlog','type')) {pdo_query("ALTER TABLE ".tablename('yb_pc_adminlog')." ADD   `type` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_adminlog','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_adminlog')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_area_price` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `p_id` int(11) DEFAULT '0',
  `allsubid` varchar(2000) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `start_price` float(10,2) DEFAULT '0.00',
  `sstart_mileage` float(10,2) DEFAULT '0.00',
  `skm_price` float(10,2) DEFAULT '0.00',
  `bkm_price` float(10,2) DEFAULT '0.00',
  `bstart_mileage` float(10,2) DEFAULT '0.00',
  `nstatus` tinyint(1) DEFAULT '1',
  `word` varchar(10) DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  `flag` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_area_price','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_area_price','name')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_area_price','p_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `p_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_area_price','allsubid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `allsubid` varchar(2000) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_area_price','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_area_price','start_price')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `start_price` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_area_price','sstart_mileage')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `sstart_mileage` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_area_price','skm_price')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `skm_price` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_area_price','bkm_price')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `bkm_price` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_area_price','bstart_mileage')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `bstart_mileage` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_area_price','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_area_price','word')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `word` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_area_price','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_area_price','flag')) {pdo_query("ALTER TABLE ".tablename('yb_pc_area_price')." ADD   `flag` tinyint(1) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_auth_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `rules` varchar(200) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_auth_group','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_auth_group','title')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group')." ADD   `title` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_auth_group','status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group')." ADD   `status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_auth_group','rules')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group')." ADD   `rules` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_auth_group','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_auth_group','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_auth_group_access` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT '0',
  `group_id` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_auth_group_access','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group_access')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_auth_group_access','uid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group_access')." ADD   `uid` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_auth_group_access','group_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group_access')." ADD   `group_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_auth_group_access','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_group_access')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_auth_rule` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT '',
  `type` tinyint(1) DEFAULT '1',
  `status` tinyint(1) DEFAULT '1',
  `pid` int(11) DEFAULT '0',
  `condition` char(100) DEFAULT NULL,
  `ico` varchar(20) NOT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_auth_rule','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD 
  `id` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_auth_rule','name')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD   `name` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_auth_rule','title')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD   `title` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('yb_pc_auth_rule','type')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD   `type` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_auth_rule','status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD   `status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_auth_rule','pid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD   `pid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_auth_rule','condition')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD   `condition` char(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_auth_rule','ico')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD   `ico` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yb_pc_auth_rule','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_auth_rule_class` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '',
  `addtime` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_auth_rule_class','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule_class')." ADD 
  `id` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_auth_rule_class','title')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule_class')." ADD   `title` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('yb_pc_auth_rule_class','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule_class')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_auth_rule_class','status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule_class')." ADD   `status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_auth_rule_class','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_auth_rule_class')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_bidding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `starting_place` varchar(255) DEFAULT NULL,
  `end_place` varchar(255) DEFAULT NULL,
  `begin_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `flag` tinyint(1) DEFAULT '1',
  `mobile` varchar(255) DEFAULT NULL,
  `weixin` varchar(255) DEFAULT NULL,
  `put_time` int(11) DEFAULT '0',
  `truename` varchar(255) DEFAULT NULL,
  `addtime` int(11) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '1',
  `overdue` int(11) DEFAULT '0',
  `reason` varchar(255) DEFAULT NULL,
  `operate_time` int(11) DEFAULT '0',
  `m_id` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '0' COMMENT '0正常，1暂停',
  `b_lnglat` varchar(255) DEFAULT NULL,
  `e_lnglat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `begin_addr` varchar(500) DEFAULT NULL,
  `end_addr` varchar(500) DEFAULT NULL,
  `ccc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_bidding','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_bidding','starting_place')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `starting_place` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','end_place')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `end_place` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','begin_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `begin_time` time DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','end_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `end_time` time DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','flag')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `flag` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_bidding','mobile')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `mobile` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','weixin')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `weixin` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','put_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `put_time` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_bidding','truename')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `truename` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `addtime` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_bidding','audit')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `audit` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_bidding','overdue')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `overdue` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_bidding','reason')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `reason` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','operate_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `operate_time` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_bidding','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `m_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_bidding','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_bidding','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `nstatus` tinyint(1) DEFAULT '0' COMMENT '0正常，1暂停'");}
if(!pdo_fieldexists('yb_pc_bidding','b_lnglat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `b_lnglat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','e_lnglat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `e_lnglat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','lng')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `lng` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','lat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `lat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','begin_addr')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `begin_addr` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','end_addr')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `end_addr` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding','ccc')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding')." ADD   `ccc` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_bidding_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `daynum` int(11) DEFAULT '0',
  `price` float DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_bidding_price','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding_price')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_bidding_price','daynum')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding_price')." ADD   `daynum` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_bidding_price','price')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding_price')." ADD   `price` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_bidding_price','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding_price')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_bidding_price','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding_price')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_bidding_price','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_bidding_price')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_car_owner_deposit_log` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `co_id` bigint(20) DEFAULT '0',
  `deposit` float DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `ispay` tinyint(1) DEFAULT '1',
  `transaction_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `isdel` tinyint(1) DEFAULT '0',
  `mobile` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `overtime` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  `ntype` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','co_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `co_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','deposit')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `deposit` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','ispay')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `ispay` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `transaction_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','ordernum')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `isdel` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','mobile')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `mobile` varchar(15) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','overtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `overtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_deposit_log','ntype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_deposit_log')." ADD   `ntype` tinyint(1) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_car_owner_notes` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `note` text CHARACTER SET utf8,
  `addtime` datetime DEFAULT NULL,
  `chotline` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `nclass` tinyint(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_car_owner_notes','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_notes')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_car_owner_notes','note')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_notes')." ADD   `note` text CHARACTER SET utf8");}
if(!pdo_fieldexists('yb_pc_car_owner_notes','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_notes')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_notes','chotline')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_notes')." ADD   `chotline` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_notes','nclass')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_notes')." ADD   `nclass` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_notes','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_notes')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_car_owner_order` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `co_id` bigint(20) DEFAULT '0',
  `starting_place` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `end_place` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `nstatus` tinyint(1) DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `number` int(11) DEFAULT '0',
  `note` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `money` float DEFAULT '0',
  `area_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `isreceipt` tinyint(1) DEFAULT '1',
  `now_num` int(11) DEFAULT '0',
  `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `ismatching` tinyint(1) DEFAULT '1',
  `isdel` tinyint(1) DEFAULT '0',
  `cancel_order` tinyint(1) DEFAULT '0',
  `iscancel` tinyint(1) DEFAULT '0',
  `surplus_seat` int(11) NOT NULL DEFAULT '0',
  `apply` tinyint(1) NOT NULL DEFAULT '0',
  `is_flag` tinyint(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  `b_lnglat` varchar(255) DEFAULT NULL,
  `e_lnglat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `begin_addr` varchar(500) DEFAULT NULL,
  `end_addr` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_car_owner_order','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_car_owner_order','co_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `co_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','starting_place')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `starting_place` varchar(30) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','end_place')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `end_place` varchar(30) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','begin_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','end_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','number')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `number` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','note')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `note` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','money')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `money` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','area_name')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `area_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','isreceipt')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `isreceipt` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','now_num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `now_num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','ordernum')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','ismatching')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `ismatching` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `isdel` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','cancel_order')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `cancel_order` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','iscancel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `iscancel` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','surplus_seat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `surplus_seat` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','apply')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `apply` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','is_flag')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `is_flag` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order','b_lnglat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `b_lnglat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','e_lnglat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `e_lnglat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','lng')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `lng` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','lat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `lat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','begin_addr')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `begin_addr` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order','end_addr')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order')." ADD   `end_addr` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_car_owner_order_complain` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) DEFAULT '0',
  `pid` bigint(20) DEFAULT '0',
  `picpath` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `addtime` datetime DEFAULT NULL COMMENT '添加时间',
  `nstatus` tinyint(1) DEFAULT '1',
  `note` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `nclass` tinyint(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_car_owner_order_complain','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_car_owner_order_complain','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_complain','pid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD   `pid` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_complain','picpath')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD   `picpath` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_complain','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD   `addtime` datetime DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_complain','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_complain','note')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD   `note` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_complain','nclass')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD   `nclass` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_complain','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_complain')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_car_owner_order_details` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `coo_id` bigint(20) DEFAULT '0',
  `m_id` bigint(20) DEFAULT '0',
  `menoy` float DEFAULT '0',
  `seat_num` int(11) DEFAULT '0',
  `ntotal` float DEFAULT '0',
  `ispay` tinyint(1) DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `cancel_order` tinyint(1) DEFAULT '0',
  `iscancal` tinyint(1) DEFAULT '0',
  `isdel` tinyint(1) DEFAULT '0',
  `istransfer` tinyint(1) DEFAULT '0',
  `transaction_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `ordernum` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `isstart` tinyint(1) DEFAULT '1',
  `redpacked` float DEFAULT '0',
  `apply` tinyint(1) NOT NULL DEFAULT '0',
  `num` int(11) NOT NULL,
  `paytype` tinyint(1) NOT NULL DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  `coos_id` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_car_owner_order_details','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','coo_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `coo_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','menoy')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `menoy` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','seat_num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `seat_num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','ntotal')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `ntotal` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','ispay')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `ispay` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','cancel_order')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `cancel_order` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','iscancal')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `iscancal` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `isdel` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','istransfer')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `istransfer` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `transaction_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','transaction_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `transaction_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','ordernum')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `ordernum` varchar(30) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','isstart')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `isstart` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','redpacked')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `redpacked` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','apply')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `apply` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','paytype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `paytype` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_details','coos_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_details')." ADD   `coos_id` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_car_owner_order_station` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coo_id` int(11) DEFAULT '0',
  `starting_place` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `end_place` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `b_lnglat` varchar(255) DEFAULT NULL,
  `e_lnglat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `begin_addr` varchar(500) DEFAULT NULL,
  `end_addr` varchar(500) DEFAULT NULL,
  `money` float DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `nstatus` tinyint(1) DEFAULT '1',
  `number` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `isreceipt` tinyint(1) DEFAULT '1',
  `isdel` tinyint(1) DEFAULT '0',
  `area_name` varchar(100) DEFAULT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_car_owner_order_station','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','coo_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `coo_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','starting_place')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `starting_place` varchar(30) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','end_place')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `end_place` varchar(30) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','b_lnglat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `b_lnglat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','e_lnglat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `e_lnglat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','lng')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `lng` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','lat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `lat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','begin_addr')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `begin_addr` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','end_addr')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `end_addr` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','money')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `money` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','number')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `number` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','isreceipt')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `isreceipt` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `isdel` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','area_name')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `area_name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','begin_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_order_station','end_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_order_station')." ADD   `end_time` datetime DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_car_owner_share` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) DEFAULT '0',
  `referee_id` bigint(20) DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '0',
  `share_time` datetime DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `isdel` tinyint(1) DEFAULT '1',
  `reason` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `redpacked` float NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `ntype` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_car_owner_share','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_car_owner_share','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_share','referee_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `referee_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_share','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `nstatus` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_share','share_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `share_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_share','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_share','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `isdel` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_car_owner_share','reason')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `reason` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_car_owner_share','redpacked')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `redpacked` float NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_share','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_car_owner_share','ntype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_car_owner_share')." ADD   `ntype` tinyint(1) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nclass` varchar(500) DEFAULT NULL,
  `templet_id1` varchar(55) DEFAULT NULL,
  `templet_id2` varchar(55) DEFAULT NULL,
  `templet_id3` varchar(55) DEFAULT NULL,
  `member_deposit` float(10,2) DEFAULT '0.00',
  `member_redpacked` float(10,2) DEFAULT '0.00',
  `member_share` float(10,2) DEFAULT '0.00',
  `member_jine` float(10,2) DEFAULT '0.00',
  `member_taskcount` int(10) DEFAULT '0',
  `platform_plat_dj_passenger` float(10,2) DEFAULT '0.00',
  `platform_plat_dj_car_owner` float(10,2) DEFAULT '0.00',
  `platform_plat_car_owner1` float(10,2) DEFAULT '0.00',
  `platform_plat_passenger2` float(10,2) DEFAULT '0.00',
  `platform_platform` float(10,2) DEFAULT '0.00',
  `platform_car_owner` float(10,2) DEFAULT '0.00',
  `platform_passenger` float(10,2) DEFAULT '0.00',
  `platform_platform_dj` float(10,2) DEFAULT '0.00',
  `platform_cover_charge` float(10,2) DEFAULT '0.00',
  `uptype` varchar(500) DEFAULT NULL,
  `pingche_xcx_appid` varchar(255) DEFAULT NULL,
  `pingche_xcx_secret` varchar(255) DEFAULT NULL,
  `ali_sms_product` varchar(255) DEFAULT NULL,
  `ali_sms_domain` varchar(255) DEFAULT NULL,
  `ali_sms_region` varchar(255) DEFAULT NULL,
  `ali_sms_end_point_name` varchar(255) DEFAULT NULL,
  `ali_sms_key_id` varchar(255) DEFAULT NULL,
  `ali_sms_key_secret` varchar(255) DEFAULT NULL,
  `ali_sms_signname` varchar(255) DEFAULT NULL,
  `ali_sms_templatecode` varchar(255) DEFAULT NULL,
  `ali_sms_sms2` varchar(255) DEFAULT NULL,
  `ali_sms_sms3` varchar(255) DEFAULT NULL,
  `ali_sms_sms4` varchar(255) DEFAULT NULL,
  `ali_sms_sms5` varchar(255) DEFAULT NULL,
  `ali_sms_sms6` varchar(255) DEFAULT NULL,
  `ali_sms_sms7` varchar(255) DEFAULT NULL,
  `ali_sms_sms8` varchar(255) DEFAULT NULL,
  `ali_sms_sms9` varchar(255) DEFAULT NULL,
  `ali_sms_sms10` varchar(255) DEFAULT NULL,
  `ali_sms_sms11` varchar(255) DEFAULT NULL,
  `ali_sms_sms12` varchar(255) DEFAULT NULL,
  `ali_sms_sms13` varchar(255) DEFAULT NULL,
  `ali_sms_sms14` varchar(255) DEFAULT NULL,
  `ali_sms_sms15` varchar(255) DEFAULT NULL,
  `wx_pay_appid` varchar(255) DEFAULT NULL,
  `wx_pay_mchid` varchar(100) DEFAULT NULL,
  `wx_pay_secrect_key` varchar(50) DEFAULT NULL,
  `wx_pay_ip` varchar(20) DEFAULT NULL,
  `wx_pay_sslcert_path` text,
  `wx_pay_sslkey_path` text,
  `uploadaddr_uploadhead` varchar(200) DEFAULT NULL,
  `uploadaddr_adimg` varchar(200) DEFAULT NULL,
  `uploadaddr_complain` text,
  `ht_pay_path_passengertaskpay` text,
  `ht_pay_path_passengerbuyseatpay` text,
  `ht_pay_path_carownerrechargepay` text,
  `copyright` varchar(255) DEFAULT NULL,
  `is_web` tinyint(1) DEFAULT '1',
  `is_web_explain` varchar(200) DEFAULT NULL,
  `kefumobile` varchar(40) DEFAULT NULL,
  `kefu_time` varchar(100) DEFAULT NULL,
  `sitename` varchar(100) DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  `start_price` float(10,2) DEFAULT '0.00',
  `sstart_mileage` float(10,2) DEFAULT '0.00',
  `skm_price` float(10,2) DEFAULT '0.00',
  `bkm_price` float(10,2) DEFAULT '0.00',
  `bstart_mileage` float(10,2) DEFAULT '0.00',
  `localkey` varchar(100) DEFAULT NULL,
  `gzh_appid` varchar(100) DEFAULT NULL,
  `gzh_secret` varchar(50) DEFAULT NULL,
  `gzh_ywym_status` tinyint(1) DEFAULT '1',
  `gzh_ywym_filename` varchar(100) DEFAULT NULL,
  `gzh_ywym_filecontent` varchar(100) DEFAULT NULL,
  `gzh_wysq_status` tinyint(1) DEFAULT '1',
  `gzh_wysq_filename` tinyint(1) DEFAULT NULL,
  `gzh_wysq_filecontent` varchar(50) DEFAULT NULL,
  `car_owner_share` float(10,2) DEFAULT '0.00',
  `gzh_token` varchar(100) DEFAULT NULL,
  `gzh_template1` varchar(100) DEFAULT NULL,
  `gzh_template2` varchar(100) DEFAULT NULL,
  `gzh_template3` varchar(100) DEFAULT NULL,
  `ali_sms_sms16` varchar(30) DEFAULT NULL,
  `ali_sms_sms17` varchar(30) DEFAULT NULL,
  `ali_sms_sms18` varchar(30) DEFAULT NULL,
  `ali_sms_sms19` varchar(30) DEFAULT NULL,
  `ali_sms_sms20` varchar(50) DEFAULT NULL,
  `ali_sms_sms21` varchar(50) DEFAULT NULL,
  `ali_sms_sms22` varchar(100) DEFAULT NULL,
  `appname` varchar(255) DEFAULT NULL,
  `addtime` int(11) DEFAULT '0',
  `ali_sms_sms23` varchar(100) DEFAULT NULL,
  `max_upload_size` int(11) DEFAULT '0',
  `oss_access_id` varchar(50) DEFAULT NULL,
  `oss_access_key` varchar(50) DEFAULT NULL,
  `oss_endpoint` varchar(100) DEFAULT NULL,
  `oss_bucket` varchar(100) DEFAULT NULL,
  `oss_web_site` varchar(50) DEFAULT NULL,
  `upload_type` int(1) DEFAULT '0',
  `qiniu_ak` varchar(255) DEFAULT NULL,
  `qiniu_sk` varchar(255) DEFAULT NULL,
  `qiniu_site` varchar(255) DEFAULT NULL,
  `qiniu_bucket` varchar(255) DEFAULT NULL,
  `is_autoprice` int(11) DEFAULT '1',
  `is_ordercanel` int(11) DEFAULT '1',
  `ordercaneltime` int(11) DEFAULT '0',
  `piansheng_title` varchar(200) DEFAULT NULL,
  `piansheng_email` varchar(100) DEFAULT NULL,
  `piansheng_qq` varchar(100) DEFAULT NULL,
  `station_num` int(11) DEFAULT '0',
  `co_awards_status` tinyint(1) DEFAULT '1',
  `co_awards_type` tinyint(1) DEFAULT '1',
  `co_awards_value` int(11) DEFAULT '0',
  `passenger_awards_status` tinyint(1) DEFAULT '1',
  `passenger_awards_type` tinyint(1) DEFAULT '1',
  `passenger_awards_value` int(11) DEFAULT '0',
  `piansheng_content` text,
  `mobileshow_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_config','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_config','nclass')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `nclass` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','templet_id1')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `templet_id1` varchar(55) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','templet_id2')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `templet_id2` varchar(55) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','templet_id3')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `templet_id3` varchar(55) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','member_deposit')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `member_deposit` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','member_redpacked')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `member_redpacked` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','member_share')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `member_share` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','member_jine')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `member_jine` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','member_taskcount')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `member_taskcount` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','platform_plat_dj_passenger')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_plat_dj_passenger` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','platform_plat_dj_car_owner')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_plat_dj_car_owner` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','platform_plat_car_owner1')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_plat_car_owner1` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','platform_plat_passenger2')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_plat_passenger2` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','platform_platform')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_platform` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','platform_car_owner')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_car_owner` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','platform_passenger')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_passenger` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','platform_platform_dj')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_platform_dj` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','platform_cover_charge')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `platform_cover_charge` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','uptype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `uptype` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','pingche_xcx_appid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `pingche_xcx_appid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','pingche_xcx_secret')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `pingche_xcx_secret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_product')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_product` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_domain')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_domain` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_region')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_region` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_end_point_name')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_end_point_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_key_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_key_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_key_secret')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_key_secret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_signname')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_signname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_templatecode')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_templatecode` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms2')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms2` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms3')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms3` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms4')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms4` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms5')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms5` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms6')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms6` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms7')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms7` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms8')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms8` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms9')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms9` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms10')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms10` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms11')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms11` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms12')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms12` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms13')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms13` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms14')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms14` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms15')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms15` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','wx_pay_appid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `wx_pay_appid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','wx_pay_mchid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `wx_pay_mchid` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','wx_pay_secrect_key')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `wx_pay_secrect_key` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','wx_pay_ip')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `wx_pay_ip` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','wx_pay_sslcert_path')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `wx_pay_sslcert_path` text");}
if(!pdo_fieldexists('yb_pc_config','wx_pay_sslkey_path')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `wx_pay_sslkey_path` text");}
if(!pdo_fieldexists('yb_pc_config','uploadaddr_uploadhead')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `uploadaddr_uploadhead` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','uploadaddr_adimg')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `uploadaddr_adimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','uploadaddr_complain')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `uploadaddr_complain` text");}
if(!pdo_fieldexists('yb_pc_config','ht_pay_path_passengertaskpay')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ht_pay_path_passengertaskpay` text");}
if(!pdo_fieldexists('yb_pc_config','ht_pay_path_passengerbuyseatpay')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ht_pay_path_passengerbuyseatpay` text");}
if(!pdo_fieldexists('yb_pc_config','ht_pay_path_carownerrechargepay')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ht_pay_path_carownerrechargepay` text");}
if(!pdo_fieldexists('yb_pc_config','copyright')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `copyright` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','is_web')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `is_web` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','is_web_explain')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `is_web_explain` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','kefumobile')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `kefumobile` varchar(40) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','kefu_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `kefu_time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','sitename')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `sitename` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','start_price')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `start_price` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','sstart_mileage')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `sstart_mileage` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','skm_price')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `skm_price` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','bkm_price')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `bkm_price` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','bstart_mileage')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `bstart_mileage` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','localkey')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `localkey` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_appid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_appid` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_secret')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_secret` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_ywym_status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_ywym_status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','gzh_ywym_filename')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_ywym_filename` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_ywym_filecontent')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_ywym_filecontent` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_wysq_status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_wysq_status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','gzh_wysq_filename')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_wysq_filename` tinyint(1) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_wysq_filecontent')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_wysq_filecontent` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','car_owner_share')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `car_owner_share` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yb_pc_config','gzh_token')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_token` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_template1')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_template1` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_template2')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_template2` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','gzh_template3')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `gzh_template3` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms16')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms16` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms17')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms17` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms18')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms18` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms19')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms19` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms20')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms20` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms21')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms21` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms22')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms22` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','appname')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `appname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `addtime` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','ali_sms_sms23')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ali_sms_sms23` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','max_upload_size')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `max_upload_size` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','oss_access_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `oss_access_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','oss_access_key')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `oss_access_key` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','oss_endpoint')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `oss_endpoint` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','oss_bucket')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `oss_bucket` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','oss_web_site')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `oss_web_site` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','upload_type')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `upload_type` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','qiniu_ak')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `qiniu_ak` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','qiniu_sk')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `qiniu_sk` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','qiniu_site')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `qiniu_site` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','qiniu_bucket')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `qiniu_bucket` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','is_autoprice')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `is_autoprice` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','is_ordercanel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `is_ordercanel` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','ordercaneltime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `ordercaneltime` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','piansheng_title')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `piansheng_title` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','piansheng_email')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `piansheng_email` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','piansheng_qq')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `piansheng_qq` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_config','station_num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `station_num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','co_awards_status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `co_awards_status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','co_awards_type')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `co_awards_type` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','co_awards_value')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `co_awards_value` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','passenger_awards_status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `passenger_awards_status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','passenger_awards_type')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `passenger_awards_type` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_config','passenger_awards_value')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `passenger_awards_value` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_config','piansheng_content')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `piansheng_content` text");}
if(!pdo_fieldexists('yb_pc_config','mobileshow_status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_config')." ADD   `mobileshow_status` tinyint(1) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_fzsm` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `addtime` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_fzsm','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_fzsm')." ADD 
  `nid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_fzsm','title')) {pdo_query("ALTER TABLE ".tablename('yb_pc_fzsm')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_fzsm','content')) {pdo_query("ALTER TABLE ".tablename('yb_pc_fzsm')." ADD   `content` text");}
if(!pdo_fieldexists('yb_pc_fzsm','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_fzsm')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_fzsm','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_fzsm')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_gzh_member` (
  `nid` bigint(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL,
  `unionid` varchar(100) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `headimgurl` varchar(1000) DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_gzh_member','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_gzh_member')." ADD 
  `nid` bigint(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_gzh_member','openid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_gzh_member')." ADD   `openid` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_gzh_member','unionid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_gzh_member')." ADD   `unionid` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_gzh_member','nickname')) {pdo_query("ALTER TABLE ".tablename('yb_pc_gzh_member')." ADD   `nickname` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_gzh_member','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_gzh_member')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_gzh_member','headimgurl')) {pdo_query("ALTER TABLE ".tablename('yb_pc_gzh_member')." ADD   `headimgurl` varchar(1000) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_gzh_member','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_gzh_member')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_invitation` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` bigint(20) DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '1',
  `referee_id` bigint(20) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `m_id` bigint(20) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_invitation','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_invitation')." ADD 
  `nid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_invitation','orderid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_invitation')." ADD   `orderid` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_invitation','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_invitation')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_invitation','referee_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_invitation')." ADD   `referee_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_invitation','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_invitation')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_invitation','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_invitation')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_invitation','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_invitation')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_member` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) CHARACTER SET utf8 DEFAULT '',
  `wx_province` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `wx_city` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `wx_country` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `wx_gender` tinyint(1) DEFAULT '1',
  `wx_nickname` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `wx_headimg` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `openid` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `session_key` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `expires_in` int(11) DEFAULT '0',
  `regtime` datetime DEFAULT NULL,
  `deposit` float DEFAULT '0',
  `account_amount` float DEFAULT '0',
  `nclass` tinyint(1) DEFAULT '0',
  `referee_id` bigint(20) DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '1',
  `isfirst` tinyint(1) DEFAULT '0',
  `session3r` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  `login_time` datetime DEFAULT NULL,
  `area` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `form_id` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `form_id_expires_in` int(11) DEFAULT '0',
  `redpacked` float DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `car_number` varchar(50) DEFAULT NULL,
  `car_model` varchar(255) DEFAULT NULL,
  `car_color` varchar(255) DEFAULT NULL,
  `is_audit` tinyint(1) DEFAULT '0',
  `driving_license` varchar(100) DEFAULT NULL,
  `vehicle_license` varchar(100) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT '0',
  `wx` varchar(255) DEFAULT NULL,
  `truename` varchar(255) DEFAULT NULL,
  `unionid` varchar(100) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_member','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_member','mobile')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `mobile` varchar(11) CHARACTER SET utf8 DEFAULT ''");}
if(!pdo_fieldexists('yb_pc_member','wx_province')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `wx_province` varchar(32) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','wx_city')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `wx_city` varchar(32) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','wx_country')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `wx_country` varchar(32) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','wx_gender')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `wx_gender` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_member','wx_nickname')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `wx_nickname` varchar(32) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','wx_headimg')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `wx_headimg` varchar(300) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','openid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `openid` varchar(32) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','session_key')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `session_key` varchar(32) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','expires_in')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `expires_in` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','regtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `regtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','deposit')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `deposit` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','account_amount')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `account_amount` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','nclass')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `nclass` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','referee_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `referee_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_member','isfirst')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `isfirst` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','session3r')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `session3r` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','login_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `login_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','area')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `area` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','form_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `form_id` varchar(30) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','form_id_expires_in')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `form_id_expires_in` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','redpacked')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `redpacked` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','car_number')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `car_number` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','car_model')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `car_model` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','car_color')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `car_color` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','is_audit')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `is_audit` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','driving_license')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `driving_license` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','vehicle_license')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `vehicle_license` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','province')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `province` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','city')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `city` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','country')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `country` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','gender')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `gender` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member','wx')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `wx` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','truename')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `truename` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member','unionid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member')." ADD   `unionid` varchar(100) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_member_binding_mobile` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `smscode` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `nstatus` tinyint(1) DEFAULT '1',
  `m_id` bigint(20) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_member_binding_mobile','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_binding_mobile')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_member_binding_mobile','mobile')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_binding_mobile')." ADD   `mobile` varchar(11) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_binding_mobile','smscode')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_binding_mobile')." ADD   `smscode` varchar(6) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_binding_mobile','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_binding_mobile')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_binding_mobile','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_binding_mobile')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_member_binding_mobile','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_binding_mobile')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member_binding_mobile','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_binding_mobile')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_member_complain` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) DEFAULT '0',
  `cood_id` bigint(20) DEFAULT '0',
  `picpath` text,
  `addtime` datetime DEFAULT NULL,
  `nstatus` tinyint(1) DEFAULT '1',
  `note` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `nclass` tinyint(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_member_complain','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_member_complain','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member_complain','cood_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD   `cood_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member_complain','picpath')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD   `picpath` text");}
if(!pdo_fieldexists('yb_pc_member_complain','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_complain','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_member_complain','note')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD   `note` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_complain','nclass')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD   `nclass` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_member_complain','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_complain')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_member_formid` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `form_id_expires_in` int(11) DEFAULT '0',
  `ntype` tinyint(1) DEFAULT '1',
  `num` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `m_id` bigint(20) NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_member_formid','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_formid')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_member_formid','form_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_formid')." ADD   `form_id` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_formid','form_id_expires_in')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_formid')." ADD   `form_id_expires_in` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member_formid','ntype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_formid')." ADD   `ntype` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_member_formid','num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_formid')." ADD   `num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member_formid','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_formid')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_formid','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_formid')." ADD   `m_id` bigint(20) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member_formid','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_formid')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_member_log` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) DEFAULT '0',
  `ip` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `mobile` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_member_log','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_log')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_member_log','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_log')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member_log','ip')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_log')." ADD   `ip` varchar(20) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_log','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_log')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_log','mobile')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_log')." ADD   `mobile` varchar(15) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_log')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_member_verycode_log` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `smscode` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `totime` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `veri_time` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_member_verycode_log','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_verycode_log')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_member_verycode_log','mobile')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_verycode_log')." ADD   `mobile` varchar(12) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_verycode_log','smscode')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_verycode_log')." ADD   `smscode` varchar(10) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_verycode_log','totime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_verycode_log')." ADD   `totime` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_member_verycode_log','status')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_verycode_log')." ADD   `status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_member_verycode_log','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_verycode_log')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_verycode_log','veri_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_verycode_log')." ADD   `veri_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_member_verycode_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_member_verycode_log')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_notice` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `contents` varchar(1000) DEFAULT NULL,
  `nstatus` tinyint(1) DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `m_id` bigint(20) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_notice','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_notice')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_notice','title')) {pdo_query("ALTER TABLE ".tablename('yb_pc_notice')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_notice','contents')) {pdo_query("ALTER TABLE ".tablename('yb_pc_notice')." ADD   `contents` varchar(1000) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_notice','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_notice')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_notice','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_notice')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_notice','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_notice')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_notice','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_notice')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_passenger_order` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) DEFAULT '0',
  `starting_place` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `end_place` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `nstatus` tinyint(1) DEFAULT '1',
  `ispay` tinyint(1) DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `isreceipt` tinyint(1) DEFAULT '1',
  `number` int(11) DEFAULT '0',
  `note` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `money` float DEFAULT '0',
  `co_id` bigint(20) DEFAULT '0',
  `area_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `transaction_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `istransfer` tinyint(1) DEFAULT '1',
  `ismatching` tinyint(1) DEFAULT '1',
  `iscancel` tinyint(1) DEFAULT '0',
  `isflag` tinyint(1) DEFAULT '0',
  `isdel1` tinyint(1) DEFAULT '0',
  `isdel2` tinyint(1) DEFAULT '0',
  `form_id` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `isstart` tinyint(1) DEFAULT '1',
  `apply` tinyint(1) DEFAULT '0',
  `redpacked` float DEFAULT '0',
  `num` int(11) DEFAULT '0',
  `paytype` tinyint(1) NOT NULL DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  `b_lnglat` varchar(255) DEFAULT NULL,
  `e_lnglat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `begin_addr` varchar(500) DEFAULT NULL,
  `end_addr` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_passenger_order','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_passenger_order','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','starting_place')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `starting_place` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','end_place')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `end_place` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','begin_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','end_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_passenger_order','ispay')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `ispay` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_passenger_order','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','isreceipt')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `isreceipt` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_passenger_order','number')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `number` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','note')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `note` varchar(300) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','money')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `money` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','co_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `co_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','area_name')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `area_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `transaction_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','ordernum')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','transaction_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `transaction_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','istransfer')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `istransfer` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_passenger_order','ismatching')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `ismatching` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_passenger_order','iscancel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `iscancel` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','isflag')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `isflag` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','isdel1')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `isdel1` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','isdel2')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `isdel2` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','form_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `form_id` varchar(30) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','isstart')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `isstart` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_passenger_order','apply')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `apply` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','redpacked')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `redpacked` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','paytype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `paytype` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_passenger_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_passenger_order','b_lnglat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `b_lnglat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','e_lnglat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `e_lnglat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','lng')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `lng` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','lat')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `lat` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','begin_addr')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `begin_addr` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_passenger_order','end_addr')) {pdo_query("ALTER TABLE ".tablename('yb_pc_passenger_order')." ADD   `end_addr` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_platform_income` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `money` float DEFAULT '0',
  `ntype` tinyint(1) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `m_id` bigint(20) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_platform_income','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_platform_income')." ADD 
  `id` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_platform_income','money')) {pdo_query("ALTER TABLE ".tablename('yb_pc_platform_income')." ADD   `money` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_platform_income','ntype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_platform_income')." ADD   `ntype` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_platform_income','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_platform_income')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_platform_income','ordernum')) {pdo_query("ALTER TABLE ".tablename('yb_pc_platform_income')." ADD   `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_platform_income','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_platform_income')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_platform_income','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_platform_income')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_redpacked_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) DEFAULT '0',
  `money` float DEFAULT '0',
  `ntype` tinyint(1) DEFAULT '0',
  `addtime` datetime DEFAULT NULL COMMENT '间',
  `note` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_redpacked_detail','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_detail')." ADD 
  `id` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_redpacked_detail','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_detail')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_redpacked_detail','money')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_detail')." ADD   `money` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_redpacked_detail','ntype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_detail')." ADD   `ntype` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_redpacked_detail','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_detail')." ADD   `addtime` datetime DEFAULT NULL COMMENT '间'");}
if(!pdo_fieldexists('yb_pc_redpacked_detail','note')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_detail')." ADD   `note` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_redpacked_detail','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_detail')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_redpacked_withdraw` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) DEFAULT '0',
  `money` float DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `transaction_id` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `isdel` tinyint(1) NOT NULL DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_redpacked_withdraw','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `money` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `transaction_id` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','transaction_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `transaction_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','ordernum')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `ordernum` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `isdel` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_redpacked_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_redpacked_withdraw')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_revenue_detail` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `money` float DEFAULT '0',
  `nclass` tinyint(1) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `m_id` bigint(20) DEFAULT '0',
  `seat_num` int(11) DEFAULT '0',
  `price` float DEFAULT '0',
  `pid` bigint(20) DEFAULT '0',
  `isdel` tinyint(1) DEFAULT '0',
  `ntype` tinyint(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_revenue_detail','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_revenue_detail','money')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `money` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_revenue_detail','nclass')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `nclass` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_revenue_detail','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_revenue_detail','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_revenue_detail','seat_num')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `seat_num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_revenue_detail','price')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `price` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_revenue_detail','pid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `pid` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_revenue_detail','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `isdel` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_revenue_detail','ntype')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `ntype` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_revenue_detail','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_revenue_detail')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_withdrawals` (
  `nid` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) DEFAULT '0',
  `amount_cash` float DEFAULT '0',
  `nstatus` tinyint(1) DEFAULT '1',
  `playmoney_time` datetime DEFAULT NULL,
  `reason` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `famount_cash` float DEFAULT '0',
  `eamount_cash` float DEFAULT '0',
  `isdel` tinyint(1) DEFAULT '1',
  `nclass` tinyint(1) DEFAULT '0',
  `ordernum` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `transaction_id` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_withdrawals','nid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD 
  `nid` bigint(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_withdrawals','m_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `m_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_withdrawals','amount_cash')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `amount_cash` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_withdrawals','nstatus')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `nstatus` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_withdrawals','playmoney_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `playmoney_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_withdrawals','reason')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `reason` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_withdrawals','addtime')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_withdrawals','famount_cash')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `famount_cash` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_withdrawals','eamount_cash')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `eamount_cash` float DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_withdrawals','isdel')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `isdel` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('yb_pc_withdrawals','nclass')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `nclass` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_withdrawals','ordernum')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `ordernum` varchar(32) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_withdrawals','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `transaction_id` varchar(40) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_withdrawals','transaction_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `transaction_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_withdrawals','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_withdrawals')." ADD   `uniacid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `yb_pc_wxapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yb_pc_wxapp','id')) {pdo_query("ALTER TABLE ".tablename('yb_pc_wxapp')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yb_pc_wxapp','uniacid')) {pdo_query("ALTER TABLE ".tablename('yb_pc_wxapp')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yb_pc_wxapp','name')) {pdo_query("ALTER TABLE ".tablename('yb_pc_wxapp')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yb_pc_wxapp','create_time')) {pdo_query("ALTER TABLE ".tablename('yb_pc_wxapp')." ADD   `create_time` int(11) DEFAULT '0'");}
