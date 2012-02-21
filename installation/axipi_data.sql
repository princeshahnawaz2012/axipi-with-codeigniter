--
-- Dumping data for table `cmp`
--

INSERT INTO `cmp` (`cmp_id`, `lay_id`, `cmp_code`, `cmp_prepend`, `cmp_prependordering`, `cmp_append`, `cmp_appendordering`, `cmp_ispage`, `cmp_isexcludepage`, `cmp_iselement`, `cmp_isexcludeelement`, `cmp_isdisplay`, `cmp_isrelation`, `cmp_issearch`, `cmp_createdby`, `cmp_datecreated`, `cmp_modifiedby`, `cmp_datemodified`, `cmp_publishedby`, `cmp_datepublished`, `cmp_unpublishedby`, `cmp_dateunpublished`, `cmp_ispublished`, `cmp_islocked`) VALUES
(1000, NULL, 'axipi_core/blank', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1001, NULL, 'axipi_core/error403', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1002, NULL, 'axipi_core/error404', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1003, NULL, 'axipi_dynamic/components', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1004, NULL, 'axipi_dynamic/items', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1005, NULL, 'axipi_core/debug', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

--
-- Dumping data for table `itm`
--

INSERT INTO `itm` (`itm_id`, `cmp_id`, `cou_id`, `lay_id`, `lng_id`, `sct_id`, `itm_code`, `itm_virtualcode`, `itm_parent`, `itm_title`, `itm_titlehead`, `itm_titleheadfull`, `itm_description`, `itm_keywords`, `itm_summary`, `itm_content`, `itm_version`, `itm_versioncomment`, `itm_access`, `itm_latitude`, `itm_longitude`, `itm_ordering`, `itm_publishstartdate`, `itm_publishenddate`, `itm_link`, `itm_file`, `itm_filetype`, `itm_filesize`, `itm_mediasmall`, `itm_mediamedium`, `itm_medialarge`, `itm_createdby`, `itm_datecreated`, `itm_modifiedby`, `itm_datemodified`, `itm_publishedby`, `itm_datepublished`, `itm_unpublishedby`, `itm_dateunpublished`, `itm_ispublished`, `itm_islocked`) VALUES
(1000, 1000, NULL, NULL, 1000, 1000, 'axipi', NULL, NULL, 'axipi', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 'all', NULL, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1001, 1001, NULL, NULL, 1000, 1000, 'error403', NULL, NULL, 'Error 403', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 'all', NULL, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1002, 1002, NULL, NULL, 1000, 1000, 'error404', NULL, NULL, 'Error 404', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 'all', NULL, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1003, 1003, NULL, NULL, 1000, 1000, 'axipi/dynamic/components', NULL, NULL, 'Components', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 'all', NULL, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1004, 1004, NULL, NULL, 1000, 1000, 'axipi/dynamic/items', NULL, NULL, 'Items', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 'all', NULL, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(1005, 1005, NULL, NULL, 1000, 1000, 'axipi/core/debug', NULL, NULL, 'Debug', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 'all', NULL, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

--
-- Dumping data for table `lay`
--

INSERT INTO `lay` (`lay_id`, `lay_code`, `lay_type`, `lay_createdby`, `lay_datecreated`, `lay_modifiedby`, `lay_datemodified`, `lay_publishedby`, `lay_datepublished`, `lay_unpublishedby`, `lay_dateunpublished`, `lay_ispublished`, `lay_islocked`) VALUES
(1000, 'axipi', 'text/html', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

--
-- Dumping data for table `lng`
--

INSERT INTO `lng` (`lng_id`, `lay_id`, `lng_code`, `lng_title`, `lng_defaultitem`, `lng_createdby`, `lng_datecreated`, `lng_modifiedby`, `lng_datemodified`, `lng_publishedby`, `lng_datepublished`, `lng_unpublishedby`, `lng_dateunpublished`, `lng_ispublished`, `lng_islocked`) VALUES
(1000, NULL, 'en', 'English', 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

--
-- Dumping data for table `sct`
--

INSERT INTO `sct` (`sct_id`, `lay_id`, `sct_code`, `sct_virtualcode`, `sct_createdby`, `sct_datecreated`, `sct_modifiedby`, `sct_datemodified`, `sct_publishedby`, `sct_datepublished`, `sct_unpublishedby`, `sct_dateunpublished`, `sct_ispublished`, `sct_islocked`) VALUES
(1000, 1000, 'axipi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);
