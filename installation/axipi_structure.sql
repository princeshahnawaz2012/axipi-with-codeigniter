-- --------------------------------------------------------

--
-- Table structure for table `cmp`
--

CREATE TABLE IF NOT EXISTS `cmp` (
  `cmp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lay_id` int(10) unsigned DEFAULT NULL,
  `cmp_code` varchar(100) NOT NULL,
  `cmp_prepend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_prependordering` mediumint(9) NOT NULL DEFAULT '0',
  `cmp_append` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_appendordering` mediumint(9) NOT NULL DEFAULT '0',
  `cmp_ispage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_isexcludepage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_iselement` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_isexcludeelement` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_isdisplay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_isrelation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_issearch` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_createdby` int(10) unsigned DEFAULT NULL,
  `cmp_datecreated` datetime DEFAULT NULL,
  `cmp_modifiedby` int(10) unsigned DEFAULT NULL,
  `cmp_datemodified` datetime DEFAULT NULL,
  `cmp_publishedby` int(10) unsigned DEFAULT NULL,
  `cmp_datepublished` datetime DEFAULT NULL,
  `cmp_unpublishedby` int(10) unsigned DEFAULT NULL,
  `cmp_dateunpublished` datetime DEFAULT NULL,
  `cmp_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmp_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cmp_id`),
  UNIQUE KEY `cmp_code` (`cmp_code`),
  KEY `lay_id` (`lay_id`),
  KEY `cmp_ispublished` (`cmp_ispublished`),
  KEY `cmp_ispage` (`cmp_ispage`),
  KEY `cmp_iszone` (`cmp_iselement`),
  KEY `cmp_isrelation` (`cmp_isrelation`),
  KEY `cmp_isdisplay` (`cmp_isdisplay`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='components' AUTO_INCREMENT=1137 ;

-- --------------------------------------------------------

--
-- Table structure for table `cmp_stg`
--

CREATE TABLE IF NOT EXISTS `cmp_stg` (
  `cmp_id` int(10) unsigned NOT NULL,
  `stg_id` int(10) unsigned NOT NULL,
  `cmp_stg_value` varchar(255) DEFAULT NULL,
  `cmp_stg_createdby` int(10) unsigned DEFAULT NULL,
  `cmp_stg_datecreated` datetime DEFAULT NULL,
  `cmp_stg_modifiedby` int(10) unsigned DEFAULT NULL,
  `cmp_stg_datemodified` datetime DEFAULT NULL,
  `cmp_stg_publishedby` int(10) unsigned DEFAULT NULL,
  `cmp_stg_datepublished` datetime DEFAULT NULL,
  `cmp_stg_unpublishedby` int(10) unsigned DEFAULT NULL,
  `cmp_stg_dateunpublished` datetime DEFAULT NULL,
  `cmp_stg_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cmp_id`,`stg_id`),
  KEY `cmp_stg_ispublished` (`cmp_stg_ispublished`),
  KEY `cmp_id` (`cmp_id`),
  KEY `stg_id` (`stg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='components_settings';

-- --------------------------------------------------------

--
-- Table structure for table `cou`
--

CREATE TABLE IF NOT EXISTS `cou` (
  `cou_id` int(10) unsigned NOT NULL,
  `cou_alpha2` char(2) NOT NULL,
  `cou_alpha3` char(3) NOT NULL,
  `cou_ordering` mediumint(9) NOT NULL DEFAULT '0',
  `cou_createdby` int(10) unsigned DEFAULT NULL,
  `cou_datecreated` datetime DEFAULT NULL,
  `cou_modifiedby` int(10) unsigned DEFAULT NULL,
  `cou_datemodified` datetime DEFAULT NULL,
  `cou_publishedby` int(10) unsigned DEFAULT NULL,
  `cou_datepublished` datetime DEFAULT NULL,
  `cou_unpublishedby` int(10) unsigned DEFAULT NULL,
  `cou_dateunpublished` datetime DEFAULT NULL,
  `cou_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cou_islocked` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`cou_id`),
  UNIQUE KEY `cou_alpha2` (`cou_alpha2`),
  UNIQUE KEY `cou_alpha3` (`cou_alpha3`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='countries';

-- --------------------------------------------------------

--
-- Table structure for table `cou_sub`
--

CREATE TABLE IF NOT EXISTS `cou_sub` (
  `cou_sub_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cou_id` int(10) unsigned NOT NULL,
  `cou_sub_code` varchar(6) NOT NULL,
  `cou_sub_title` varchar(255) NOT NULL,
  `cou_sub_createdby` int(10) unsigned DEFAULT NULL,
  `cou_sub_datecreated` datetime DEFAULT NULL,
  `cou_sub_modifiedby` int(10) unsigned DEFAULT NULL,
  `cou_sub_datemodified` datetime DEFAULT NULL,
  `cou_sub_publishedby` int(10) unsigned DEFAULT NULL,
  `cou_sub_datepublished` datetime DEFAULT NULL,
  `cou_sub_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cou_sub_id`),
  KEY `cou_sub_code` (`cou_sub_code`),
  KEY `cou_sub_title` (`cou_sub_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='countries_subdivisions' AUTO_INCREMENT=1206 ;

-- --------------------------------------------------------

--
-- Table structure for table `cou_trl`
--

CREATE TABLE IF NOT EXISTS `cou_trl` (
  `cou_id` int(10) unsigned NOT NULL,
  `lng_id` int(10) unsigned NOT NULL,
  `cou_trl_title` varchar(255) NOT NULL,
  `cou_trl_createdby` int(10) unsigned DEFAULT NULL,
  `cou_trl_datecreated` datetime DEFAULT NULL,
  `cou_trl_modifiedby` int(10) unsigned DEFAULT NULL,
  `cou_trl_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`cou_id`,`lng_id`),
  KEY `lng_id` (`lng_id`),
  KEY `cou_trl_title` (`cou_trl_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='countries_translations';

-- --------------------------------------------------------

--
-- Table structure for table `grp`
--

CREATE TABLE IF NOT EXISTS `grp` (
  `grp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grp_code` varchar(100) NOT NULL,
  `grp_isitem` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grp_isuser` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grp_ispermission` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grp_isnotification` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grp_isorganization` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grp_ordering` mediumint(9) NOT NULL DEFAULT '0',
  `grp_createdby` int(10) unsigned DEFAULT NULL,
  `grp_datecreated` datetime DEFAULT NULL,
  `grp_modifiedby` int(10) unsigned DEFAULT NULL,
  `grp_datemodified` datetime DEFAULT NULL,
  `grp_publishedby` int(10) unsigned DEFAULT NULL,
  `grp_datepublished` datetime DEFAULT NULL,
  `grp_unpublishedby` int(10) unsigned DEFAULT NULL,
  `grp_dateunpublished` datetime DEFAULT NULL,
  `grp_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grp_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`grp_id`),
  UNIQUE KEY `grp_code` (`grp_code`),
  KEY `grp_ispublished` (`grp_ispublished`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='groups' AUTO_INCREMENT=1004 ;

-- --------------------------------------------------------

--
-- Table structure for table `grp_itm`
--

CREATE TABLE IF NOT EXISTS `grp_itm` (
  `grp_id` int(10) unsigned NOT NULL,
  `itm_id` int(10) unsigned NOT NULL,
  `grp_itm_createdby` int(10) unsigned DEFAULT NULL,
  `grp_itm_datecreated` datetime DEFAULT NULL,
  `grp_itm_modifiedby` int(10) unsigned DEFAULT NULL,
  `grp_itm_datemodified` datetime DEFAULT NULL,
  `grp_itm_publishedby` int(10) unsigned DEFAULT NULL,
  `grp_itm_datepublished` datetime DEFAULT NULL,
  `grp_itm_unpublishedby` int(10) unsigned DEFAULT NULL,
  `grp_itm_dateunpublished` datetime DEFAULT NULL,
  `grp_itm_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`grp_id`,`itm_id`),
  KEY `grp_itm_ispublished` (`grp_itm_ispublished`),
  KEY `grp_id` (`grp_id`),
  KEY `itm_id` (`itm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='groups_items';

-- --------------------------------------------------------

--
-- Table structure for table `grp_per`
--

CREATE TABLE IF NOT EXISTS `grp_per` (
  `grp_id` int(10) unsigned NOT NULL,
  `per_id` int(10) unsigned NOT NULL,
  `grp_per_createdby` int(10) unsigned DEFAULT NULL,
  `grp_per_datecreated` datetime DEFAULT NULL,
  `grp_per_modifiedby` int(10) unsigned DEFAULT NULL,
  `grp_per_datemodified` datetime DEFAULT NULL,
  `grp_per_publishedby` int(10) unsigned DEFAULT NULL,
  `grp_per_datepublished` datetime DEFAULT NULL,
  `grp_per_unpublishedby` int(10) unsigned DEFAULT NULL,
  `grp_per_dateunpublished` datetime DEFAULT NULL,
  `grp_per_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grp_per_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`grp_id`,`per_id`),
  KEY `grp_id` (`grp_id`),
  KEY `per_id` (`per_id`),
  KEY `grp_per_ispublished` (`grp_per_ispublished`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='groups_permissions';

-- --------------------------------------------------------

--
-- Table structure for table `grp_trl`
--

CREATE TABLE IF NOT EXISTS `grp_trl` (
  `grp_id` int(10) unsigned NOT NULL,
  `lng_id` int(10) unsigned NOT NULL,
  `grp_trl_title` varchar(255) NOT NULL,
  `grp_trl_createdby` int(10) unsigned DEFAULT NULL,
  `grp_trl_datecreated` datetime DEFAULT NULL,
  `grp_trl_modifiedby` int(10) unsigned DEFAULT NULL,
  `grp_trl_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`grp_id`,`lng_id`),
  KEY `lng_id` (`lng_id`),
  KEY `grp_trl_title` (`grp_trl_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='groups_translations';

-- --------------------------------------------------------

--
-- Table structure for table `grp_usr`
--

CREATE TABLE IF NOT EXISTS `grp_usr` (
  `grp_id` int(10) unsigned NOT NULL,
  `usr_id` int(10) unsigned NOT NULL,
  `grp_usr_title` varchar(100) DEFAULT NULL,
  `grp_usr_keyregister` char(14) DEFAULT NULL,
  `grp_usr_origin` varchar(100) DEFAULT NULL,
  `grp_usr_createdby` int(10) unsigned DEFAULT NULL,
  `grp_usr_datecreated` datetime DEFAULT NULL,
  `grp_usr_modifiedby` int(10) unsigned DEFAULT NULL,
  `grp_usr_datemodified` datetime DEFAULT NULL,
  `grp_usr_publishedby` int(10) unsigned DEFAULT NULL,
  `grp_usr_datepublished` datetime DEFAULT NULL,
  `grp_usr_unpublishedby` int(10) unsigned DEFAULT NULL,
  `grp_usr_dateunpublished` datetime DEFAULT NULL,
  `grp_usr_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grp_usr_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`grp_id`,`usr_id`),
  KEY `grp_id` (`grp_id`),
  KEY `usr_id` (`usr_id`),
  KEY `grp_usr_ispublished` (`grp_usr_ispublished`),
  KEY `grp_usr_keyregister` (`grp_usr_keyregister`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='groups_users';

-- --------------------------------------------------------

--
-- Table structure for table `hst`
--

CREATE TABLE IF NOT EXISTS `hst` (
  `hst_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lay_id` int(10) unsigned DEFAULT NULL,
  `hst_code` varchar(100) NOT NULL,
  `hst_url` varchar(255) NOT NULL,
  `hst_rewrite` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hst_gzhandler` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hst_debug` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hst_environment` varchar(100) DEFAULT NULL,
  `hst_createdby` int(10) unsigned DEFAULT NULL,
  `hst_datecreated` datetime DEFAULT NULL,
  `hst_modifiedby` int(10) unsigned DEFAULT NULL,
  `hst_datemodified` datetime DEFAULT NULL,
  `hst_publishedby` int(10) unsigned DEFAULT NULL,
  `hst_datepublished` datetime DEFAULT NULL,
  `hst_unpublishedby` int(10) unsigned DEFAULT NULL,
  `hst_dateunpublished` datetime DEFAULT NULL,
  `hst_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hst_islocked` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`hst_id`),
  UNIQUE KEY `hst_code` (`hst_code`),
  KEY `lay_id` (`lay_id`),
  KEY `hst_ispublished` (`hst_ispublished`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='hosts' AUTO_INCREMENT=1001 ;

-- --------------------------------------------------------

--
-- Table structure for table `hst_stg`
--

CREATE TABLE IF NOT EXISTS `hst_stg` (
  `hst_id` int(10) unsigned NOT NULL,
  `stg_id` int(10) unsigned NOT NULL,
  `hst_stg_value` varchar(255) DEFAULT NULL,
  `hst_stg_createdby` int(10) unsigned DEFAULT NULL,
  `hst_stg_datecreated` datetime DEFAULT NULL,
  `hst_stg_modifiedby` int(10) unsigned DEFAULT NULL,
  `hst_stg_datemodified` datetime DEFAULT NULL,
  `hst_stg_publishedby` int(10) unsigned DEFAULT NULL,
  `hst_stg_datepublished` datetime DEFAULT NULL,
  `hst_stg_unpublishedby` int(10) unsigned DEFAULT NULL,
  `hst_stg_dateunpublished` datetime DEFAULT NULL,
  `hst_stg_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`hst_id`,`stg_id`),
  KEY `hst_id` (`hst_id`),
  KEY `stg_id` (`stg_id`),
  KEY `hst_stg_ispublished` (`hst_stg_ispublished`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='hosts_settings';

-- --------------------------------------------------------

--
-- Table structure for table `hst_trl`
--

CREATE TABLE IF NOT EXISTS `hst_trl` (
  `hst_id` int(10) unsigned NOT NULL,
  `lng_id` int(10) unsigned NOT NULL,
  `hst_trl_defaultitem` int(10) unsigned NOT NULL,
  `hst_trl_createdby` int(10) unsigned DEFAULT NULL,
  `hst_trl_datecreated` datetime DEFAULT NULL,
  `hst_trl_modifiedby` int(10) unsigned DEFAULT NULL,
  `hst_trl_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`hst_id`,`lng_id`),
  KEY `hst_id` (`hst_id`),
  KEY `lng_id` (`lng_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='hosts_translations';

-- --------------------------------------------------------

--
-- Table structure for table `itm`
--

CREATE TABLE IF NOT EXISTS `itm` (
  `itm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cmp_id` int(10) unsigned NOT NULL,
  `cou_id` int(10) unsigned DEFAULT NULL,
  `lay_id` int(10) unsigned DEFAULT NULL,
  `lng_id` int(10) unsigned NOT NULL,
  `sct_id` int(10) unsigned NOT NULL,
  `itm_code` varchar(100) NOT NULL,
  `itm_virtualcode` varchar(100) DEFAULT NULL,
  `itm_parent` int(10) unsigned DEFAULT NULL,
  `itm_title` varchar(255) NOT NULL,
  `itm_titlehead` varchar(255) DEFAULT NULL,
  `itm_titleheadfull` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `itm_description` text,
  `itm_keywords` text,
  `itm_summary` text,
  `itm_content` mediumtext,
  `itm_version` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `itm_versioncomment` text,
  `itm_access` varchar(100) NOT NULL DEFAULT 'all',
  `itm_latitude` double DEFAULT NULL,
  `itm_longitude` double DEFAULT NULL,
  `itm_ordering` mediumint(9) NOT NULL DEFAULT '0',
  `itm_publishstartdate` datetime NOT NULL,
  `itm_publishenddate` datetime DEFAULT NULL,
  `itm_link` varchar(255) DEFAULT NULL,
  `itm_file` varchar(100) DEFAULT NULL,
  `itm_filetype` varchar(100) DEFAULT NULL,
  `itm_filesize` int(10) unsigned DEFAULT NULL,
  `itm_mediasmall` varchar(100) DEFAULT NULL,
  `itm_mediamedium` varchar(100) DEFAULT NULL,
  `itm_medialarge` varchar(100) DEFAULT NULL,
  `itm_createdby` int(10) unsigned DEFAULT NULL,
  `itm_datecreated` datetime DEFAULT NULL,
  `itm_modifiedby` int(10) unsigned DEFAULT NULL,
  `itm_datemodified` datetime DEFAULT NULL,
  `itm_publishedby` int(10) unsigned DEFAULT NULL,
  `itm_datepublished` datetime DEFAULT NULL,
  `itm_unpublishedby` int(10) unsigned DEFAULT NULL,
  `itm_dateunpublished` datetime DEFAULT NULL,
  `itm_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `itm_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itm_id`),
  UNIQUE KEY `itm_code` (`itm_code`),
  KEY `cmp_id` (`cmp_id`),
  KEY `cou_id` (`cou_id`),
  KEY `lay_id` (`lay_id`),
  KEY `lng_id` (`lng_id`),
  KEY `sct_id` (`sct_id`),
  KEY `itm_ispublished` (`itm_ispublished`),
  KEY `itm_publishstartdate` (`itm_publishstartdate`),
  KEY `itm_parent` (`itm_parent`),
  FULLTEXT KEY `itm_summary` (`itm_summary`),
  FULLTEXT KEY `itm_content` (`itm_content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='items' AUTO_INCREMENT=1085 ;

-- --------------------------------------------------------

--
-- Table structure for table `itm_rel`
--

CREATE TABLE IF NOT EXISTS `itm_rel` (
  `itm_id` int(10) unsigned NOT NULL,
  `rel_id` int(10) unsigned NOT NULL,
  `itm_rel_parent` int(10) unsigned DEFAULT NULL,
  `itm_rel_title` varchar(255) DEFAULT NULL,
  `itm_rel_ordering` mediumint(9) NOT NULL DEFAULT '0',
  `itm_rel_file` varchar(100) DEFAULT NULL,
  `itm_rel_mediasmall` varchar(100) DEFAULT NULL,
  `itm_rel_mediamedium` varchar(100) DEFAULT NULL,
  `itm_rel_medialarge` varchar(100) DEFAULT NULL,
  `itm_rel_createdby` int(10) unsigned DEFAULT NULL,
  `itm_rel_datecreated` datetime DEFAULT NULL,
  `itm_rel_modifiedby` int(10) unsigned DEFAULT NULL,
  `itm_rel_datemodified` datetime DEFAULT NULL,
  `itm_rel_publishedby` int(10) unsigned DEFAULT NULL,
  `itm_rel_datepublished` datetime DEFAULT NULL,
  `itm_rel_unpublishedby` int(10) unsigned DEFAULT NULL,
  `itm_rel_dateunpublished` datetime DEFAULT NULL,
  `itm_rel_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itm_id`,`rel_id`),
  KEY `itm_id` (`itm_id`),
  KEY `rel_id` (`rel_id`),
  KEY `itm_rel_ispublished` (`itm_rel_ispublished`),
  KEY `itm_rel_parent` (`itm_rel_parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='items_relations';

-- --------------------------------------------------------

--
-- Table structure for table `itm_stg`
--

CREATE TABLE IF NOT EXISTS `itm_stg` (
  `itm_id` int(10) unsigned NOT NULL,
  `stg_id` int(10) unsigned NOT NULL,
  `itm_stg_value` varchar(255) DEFAULT NULL,
  `itm_stg_createdby` int(10) unsigned DEFAULT NULL,
  `itm_stg_datecreated` datetime DEFAULT NULL,
  `itm_stg_modifiedby` int(10) unsigned DEFAULT NULL,
  `itm_stg_datemodified` datetime DEFAULT NULL,
  `itm_stg_publishedby` int(10) unsigned DEFAULT NULL,
  `itm_stg_datepublished` datetime DEFAULT NULL,
  `itm_stg_unpublishedby` int(10) unsigned DEFAULT NULL,
  `itm_stg_dateunpublished` datetime DEFAULT NULL,
  `itm_stg_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itm_id`,`stg_id`),
  KEY `itm_id` (`itm_id`),
  KEY `stg_id` (`stg_id`),
  KEY `itm_stg_ispublished` (`itm_stg_ispublished`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='items_settings';

-- --------------------------------------------------------

--
-- Table structure for table `itm_trl`
--

CREATE TABLE IF NOT EXISTS `itm_trl` (
  `itm_id` int(10) unsigned NOT NULL,
  `trl_id` int(10) unsigned NOT NULL,
  `itm_trl_createdby` int(10) unsigned DEFAULT NULL,
  `itm_trl_datecreated` datetime DEFAULT NULL,
  `itm_trl_modifiedby` int(10) unsigned DEFAULT NULL,
  `itm_trl_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`itm_id`,`trl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='items_translations';

-- --------------------------------------------------------

--
-- Table structure for table `itm_zon`
--

CREATE TABLE IF NOT EXISTS `itm_zon` (
  `itm_id` int(10) unsigned NOT NULL,
  `zon_id` int(10) unsigned NOT NULL,
  `itm_zon_ordering` mediumint(9) NOT NULL DEFAULT '0',
  `itm_zon_display` varchar(100) NOT NULL DEFAULT 'all',
  `itm_zon_createdby` int(10) unsigned DEFAULT NULL,
  `itm_zon_datecreated` datetime DEFAULT NULL,
  `itm_zon_modifiedby` int(10) unsigned DEFAULT NULL,
  `itm_zon_datemodified` datetime DEFAULT NULL,
  `itm_zon_publishedby` int(10) unsigned DEFAULT NULL,
  `itm_zon_datepublished` datetime DEFAULT NULL,
  `itm_zon_unpublishedby` int(10) unsigned DEFAULT NULL,
  `itm_zon_dateunpublished` datetime DEFAULT NULL,
  `itm_zon_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itm_id`,`zon_id`),
  KEY `itm_zon_ispublished` (`itm_zon_ispublished`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='items_zones';

-- --------------------------------------------------------

--
-- Table structure for table `lay`
--

CREATE TABLE IF NOT EXISTS `lay` (
  `lay_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lay_code` varchar(100) NOT NULL,
  `lay_type` varchar(100) NOT NULL,
  `lay_createdby` int(10) unsigned DEFAULT NULL,
  `lay_datecreated` datetime DEFAULT NULL,
  `lay_modifiedby` int(10) unsigned DEFAULT NULL,
  `lay_datemodified` datetime DEFAULT NULL,
  `lay_publishedby` int(10) unsigned DEFAULT NULL,
  `lay_datepublished` datetime DEFAULT NULL,
  `lay_unpublishedby` int(10) unsigned DEFAULT NULL,
  `lay_dateunpublished` datetime DEFAULT NULL,
  `lay_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lay_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lay_id`),
  UNIQUE KEY `lay_code` (`lay_code`),
  KEY `lay_ispublished` (`lay_ispublished`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='layouts' AUTO_INCREMENT=1002 ;

-- --------------------------------------------------------

--
-- Table structure for table `lng`
--

CREATE TABLE IF NOT EXISTS `lng` (
  `lng_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lay_id` int(10) unsigned DEFAULT NULL,
  `lng_code` char(2) NOT NULL,
  `lng_title` varchar(255) NOT NULL,
  `lng_defaultitem` int(10) unsigned NOT NULL,
  `lng_createdby` int(10) unsigned DEFAULT NULL,
  `lng_datecreated` datetime DEFAULT NULL,
  `lng_modifiedby` int(10) unsigned DEFAULT NULL,
  `lng_datemodified` datetime DEFAULT NULL,
  `lng_publishedby` int(10) unsigned DEFAULT NULL,
  `lng_datepublished` datetime DEFAULT NULL,
  `lng_unpublishedby` int(10) unsigned DEFAULT NULL,
  `lng_dateunpublished` datetime DEFAULT NULL,
  `lng_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lng_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lng_id`),
  UNIQUE KEY `lng_code` (`lng_code`),
  KEY `lng_ispublished` (`lng_ispublished`),
  KEY `lng_title` (`lng_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='languages' AUTO_INCREMENT=1002 ;

-- --------------------------------------------------------

--
-- Table structure for table `lng_stg`
--

CREATE TABLE IF NOT EXISTS `lng_stg` (
  `lng_id` int(10) unsigned NOT NULL,
  `stg_id` int(10) unsigned NOT NULL,
  `lng_stg_value` varchar(255) DEFAULT NULL,
  `lng_stg_createdby` int(10) unsigned DEFAULT NULL,
  `lng_stg_datecreated` datetime DEFAULT NULL,
  `lng_stg_modifiedby` int(10) unsigned DEFAULT NULL,
  `lng_stg_datemodified` datetime DEFAULT NULL,
  `lng_stg_publishedby` int(10) unsigned DEFAULT NULL,
  `lng_stg_datepublished` datetime DEFAULT NULL,
  `lng_stg_unpublishedby` int(10) unsigned DEFAULT NULL,
  `lng_stg_dateunpublished` datetime DEFAULT NULL,
  `lng_stg_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lng_id`,`stg_id`),
  KEY `lng_id` (`lng_id`),
  KEY `stg_id` (`stg_id`),
  KEY `lng_stg_ispublished` (`lng_stg_ispublished`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='languages_settings';

-- --------------------------------------------------------

--
-- Table structure for table `per`
--

CREATE TABLE IF NOT EXISTS `per` (
  `per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_code` varchar(100) NOT NULL,
  `per_createdby` int(10) unsigned DEFAULT NULL,
  `per_datecreated` datetime DEFAULT NULL,
  `per_modifiedby` int(10) unsigned DEFAULT NULL,
  `per_datemodified` datetime DEFAULT NULL,
  `per_publishedby` int(10) unsigned DEFAULT NULL,
  `per_datepublished` datetime DEFAULT NULL,
  `per_unpublishedby` int(10) unsigned DEFAULT NULL,
  `per_dateunpublished` datetime DEFAULT NULL,
  `per_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `per_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`per_id`),
  UNIQUE KEY `per_code` (`per_code`),
  KEY `per_ispublished` (`per_ispublished`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='permissions' AUTO_INCREMENT=1009 ;

-- --------------------------------------------------------

--
-- Table structure for table `per_trl`
--

CREATE TABLE IF NOT EXISTS `per_trl` (
  `per_id` int(10) unsigned NOT NULL,
  `lng_id` int(10) unsigned NOT NULL,
  `per_trl_title` varchar(255) NOT NULL,
  `per_trl_createdby` int(10) unsigned DEFAULT NULL,
  `per_trl_datecreated` datetime DEFAULT NULL,
  `per_trl_modifiedby` int(10) unsigned DEFAULT NULL,
  `per_trl_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`per_id`,`lng_id`),
  KEY `lng_id` (`lng_id`),
  KEY `per_trl_title` (`per_trl_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='permissions_translations';

-- --------------------------------------------------------

--
-- Table structure for table `sct`
--

CREATE TABLE IF NOT EXISTS `sct` (
  `sct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lay_id` int(10) unsigned NOT NULL,
  `sct_code` varchar(100) NOT NULL,
  `sct_virtualcode` varchar(100) DEFAULT NULL,
  `sct_createdby` int(10) unsigned DEFAULT NULL,
  `sct_datecreated` datetime DEFAULT NULL,
  `sct_modifiedby` int(10) unsigned DEFAULT NULL,
  `sct_datemodified` datetime DEFAULT NULL,
  `sct_publishedby` int(10) unsigned DEFAULT NULL,
  `sct_datepublished` datetime DEFAULT NULL,
  `sct_unpublishedby` int(10) unsigned DEFAULT NULL,
  `sct_dateunpublished` datetime DEFAULT NULL,
  `sct_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sct_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sct_id`),
  UNIQUE KEY `sct_code` (`sct_code`),
  KEY `sct_ispublished` (`sct_ispublished`),
  KEY `lay_id` (`lay_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='sections' AUTO_INCREMENT=1002 ;

-- --------------------------------------------------------

--
-- Table structure for table `sct_stg`
--

CREATE TABLE IF NOT EXISTS `sct_stg` (
  `sct_id` int(10) unsigned NOT NULL,
  `stg_id` int(10) unsigned NOT NULL,
  `sct_stg_value` varchar(255) DEFAULT NULL,
  `sct_stg_createdby` int(10) unsigned DEFAULT NULL,
  `sct_stg_datecreated` datetime DEFAULT NULL,
  `sct_stg_modifiedby` int(10) unsigned DEFAULT NULL,
  `sct_stg_datemodified` datetime DEFAULT NULL,
  `sct_stg_publishedby` int(10) unsigned DEFAULT NULL,
  `sct_stg_datepublished` datetime DEFAULT NULL,
  `sct_stg_unpublishedby` int(10) unsigned DEFAULT NULL,
  `sct_stg_dateunpublished` datetime DEFAULT NULL,
  `sct_stg_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sct_id`,`stg_id`),
  KEY `sct_id` (`sct_id`),
  KEY `stg_id` (`stg_id`),
  KEY `sct_stg_ispublished` (`sct_stg_ispublished`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='sections_settings';

-- --------------------------------------------------------

--
-- Table structure for table `sct_trl`
--

CREATE TABLE IF NOT EXISTS `sct_trl` (
  `lng_id` int(10) unsigned NOT NULL,
  `sct_id` int(10) unsigned NOT NULL,
  `sct_trl_title` varchar(255) NOT NULL,
  `sct_trl_description` text,
  `sct_trl_keywords` text,
  `sct_trl_createdby` int(10) unsigned DEFAULT NULL,
  `sct_trl_datecreated` datetime DEFAULT NULL,
  `sct_trl_modifiedby` int(10) unsigned DEFAULT NULL,
  `sct_trl_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`lng_id`,`sct_id`),
  KEY `lng_id` (`lng_id`),
  KEY `sct_id` (`sct_id`),
  KEY `sct_trl_title` (`sct_trl_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='sections_translations';

-- --------------------------------------------------------

--
-- Table structure for table `stg`
--

CREATE TABLE IF NOT EXISTS `stg` (
  `stg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stg_code` varchar(100) NOT NULL,
  `stg_value` varchar(255) DEFAULT NULL,
  `stg_isuser` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stg_issection` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stg_islanguage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stg_ishost` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stg_isorganization` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stg_iscomponent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stg_isglobal` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stg_createdby` int(10) unsigned DEFAULT NULL,
  `stg_datecreated` datetime DEFAULT NULL,
  `stg_modifiedby` int(10) unsigned DEFAULT NULL,
  `stg_datemodified` datetime DEFAULT NULL,
  `stg_publishedby` int(10) unsigned DEFAULT NULL,
  `stg_datepublished` datetime DEFAULT NULL,
  `stg_unpublishedby` int(10) unsigned DEFAULT NULL,
  `stg_dateunpublished` datetime DEFAULT NULL,
  `stg_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stg_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`stg_id`),
  UNIQUE KEY `stg_code` (`stg_code`),
  KEY `stg_ispublished` (`stg_ispublished`),
  KEY `stg_isglobal` (`stg_isglobal`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='settings' AUTO_INCREMENT=1050 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_trl`
--

CREATE TABLE IF NOT EXISTS `stg_trl` (
  `stg_id` int(10) unsigned NOT NULL,
  `lng_id` int(10) unsigned NOT NULL,
  `stg_trl_title` varchar(255) NOT NULL,
  `stg_trl_createdby` int(10) unsigned DEFAULT NULL,
  `stg_trl_datecreated` datetime DEFAULT NULL,
  `stg_trl_modifiedby` int(10) unsigned DEFAULT NULL,
  `stg_trl_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`lng_id`,`stg_id`),
  KEY `lng_id` (`lng_id`),
  KEY `sct_trl_title` (`stg_trl_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='settings_translations';

-- --------------------------------------------------------

--
-- Table structure for table `stg_usr`
--

CREATE TABLE IF NOT EXISTS `stg_usr` (
  `stg_id` int(10) unsigned NOT NULL,
  `usr_id` int(10) unsigned NOT NULL,
  `stg_usr_value` varchar(255) DEFAULT NULL,
  `stg_usr_createdby` int(10) unsigned DEFAULT NULL,
  `stg_usr_datecreated` datetime DEFAULT NULL,
  `stg_usr_modifiedby` int(10) unsigned DEFAULT NULL,
  `stg_usr_datemodified` datetime DEFAULT NULL,
  `stg_usr_publishedby` int(10) unsigned DEFAULT NULL,
  `stg_usr_datepublished` datetime DEFAULT NULL,
  `stg_usr_unpublishedby` int(10) unsigned DEFAULT NULL,
  `stg_usr_dateunpublished` datetime DEFAULT NULL,
  `stg_usr_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`stg_id`,`usr_id`),
  KEY `stg_id` (`stg_id`),
  KEY `usr_id` (`usr_id`),
  KEY `stg_usr_ispublished` (`stg_usr_ispublished`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='settings_users';

-- --------------------------------------------------------

--
-- Table structure for table `trl_zon`
--

CREATE TABLE IF NOT EXISTS `trl_zon` (
  `zon_id` int(10) unsigned NOT NULL,
  `lng_id` int(10) unsigned NOT NULL,
  `trl_zon_title` varchar(255) NOT NULL,
  `trl_zon_createdby` int(10) unsigned DEFAULT NULL,
  `trl_zon_datecreated` datetime DEFAULT NULL,
  `trl_zon_modifiedby` int(10) unsigned DEFAULT NULL,
  `trl_zon_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`lng_id`,`zon_id`),
  KEY `lng_id` (`lng_id`),
  KEY `trl_zon_title` (`trl_zon_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='translations_zones';

-- --------------------------------------------------------

--
-- Table structure for table `usr`
--

CREATE TABLE IF NOT EXISTS `usr` (
  `usr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cou_id` int(10) unsigned DEFAULT NULL,
  `cou_sub_id` int(10) unsigned DEFAULT NULL,
  `lng_id` int(10) unsigned DEFAULT NULL,
  `usr_email` varchar(100) DEFAULT NULL,
  `usr_protectedpassword` char(32) DEFAULT NULL,
  `usr_plainpassword` varchar(16) DEFAULT NULL,
  `usr_timezone` tinyint(1) NOT NULL,
  `usr_courtesy` varchar(100) DEFAULT NULL,
  `usr_lastname` varchar(100) DEFAULT NULL,
  `usr_firstname` varchar(100) DEFAULT NULL,
  `usr_nickname` varchar(100) DEFAULT NULL,
  `usr_gender` tinyint(1) unsigned DEFAULT NULL,
  `usr_address1` varchar(100) DEFAULT NULL,
  `usr_address2` varchar(100) DEFAULT NULL,
  `usr_address3` varchar(100) DEFAULT NULL,
  `usr_zipcode` varchar(100) DEFAULT NULL,
  `usr_city` varchar(100) DEFAULT NULL,
  `usr_latitude` double DEFAULT NULL,
  `usr_longitude` double DEFAULT NULL,
  `usr_website` varchar(255) DEFAULT NULL,
  `usr_phone` varchar(100) DEFAULT NULL,
  `usr_mobile` varchar(100) DEFAULT NULL,
  `usr_fax` varchar(100) DEFAULT NULL,
  `usr_keypassword` char(14) DEFAULT NULL,
  `usr_keyregister` char(14) DEFAULT NULL,
  `usr_logincount` int(10) unsigned NOT NULL DEFAULT '0',
  `usr_loginlast` datetime DEFAULT NULL,
  `usr_optin` datetime DEFAULT NULL,
  `usr_doubleoptin` datetime DEFAULT NULL,
  `usr_unsubscribe` datetime DEFAULT NULL,
  `usr_hardbounce` datetime DEFAULT NULL,
  `usr_referer` varchar(255) DEFAULT NULL,
  `usr_origin` varchar(100) DEFAULT NULL,
  `usr_file` varchar(100) DEFAULT NULL,
  `usr_mediasmall` varchar(100) DEFAULT NULL,
  `usr_mediamedium` varchar(100) DEFAULT NULL,
  `usr_medialarge` varchar(100) DEFAULT NULL,
  `usr_createdby` int(10) unsigned DEFAULT NULL,
  `usr_datecreated` datetime DEFAULT NULL,
  `usr_modifiedby` int(10) unsigned DEFAULT NULL,
  `usr_datemodified` datetime DEFAULT NULL,
  `usr_publishedby` int(10) unsigned DEFAULT NULL,
  `usr_datepublished` datetime DEFAULT NULL,
  `usr_unpublishedby` int(10) unsigned DEFAULT NULL,
  `usr_dateunpublished` datetime DEFAULT NULL,
  `usr_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `usr_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_email` (`usr_email`),
  KEY `cou_id` (`cou_id`),
  KEY `lng_id` (`lng_id`),
  KEY `usr_ispublished` (`usr_ispublished`),
  KEY `usr_keyregister` (`usr_keyregister`),
  KEY `usr_keypassword` (`usr_keypassword`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='users' AUTO_INCREMENT=1001 ;

-- --------------------------------------------------------

--
-- Table structure for table `wtd`
--

CREATE TABLE IF NOT EXISTS `wtd` (
  `wtd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wtd_key` char(32) NOT NULL,
  `wtd_content` text NOT NULL,
  `wtd_datecreated` datetime NOT NULL,
  `wtd_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`wtd_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='watchdog' AUTO_INCREMENT=1002 ;

-- --------------------------------------------------------

--
-- Table structure for table `zon`
--

CREATE TABLE IF NOT EXISTS `zon` (
  `zon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lay_id` int(10) unsigned NOT NULL,
  `zon_code` varchar(100) NOT NULL,
  `zon_ordering` mediumint(9) NOT NULL DEFAULT '0',
  `zon_createdby` int(10) unsigned DEFAULT NULL,
  `zon_datecreated` datetime DEFAULT NULL,
  `zon_modifiedby` int(10) unsigned DEFAULT NULL,
  `zon_datemodified` datetime DEFAULT NULL,
  `zon_publishedby` int(10) unsigned DEFAULT NULL,
  `zon_datepublished` datetime DEFAULT NULL,
  `zon_unpublishedby` int(10) unsigned DEFAULT NULL,
  `zon_dateunpublished` datetime DEFAULT NULL,
  `zon_ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `zon_islocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`zon_id`),
  UNIQUE KEY `lay_zon` (`lay_id`,`zon_code`),
  KEY `zon_ispublished` (`zon_ispublished`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='zones' AUTO_INCREMENT=1014 ;
