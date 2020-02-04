--
-- Base Table
--
CREATE TABLE `worktime` (
  `Worktime_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `worktime`
  ADD PRIMARY KEY (`Worktime_ID`);

ALTER TABLE `worktime`
  MODIFY `Worktime_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Worktime\\Controller\\WorktimeController', 'Add', '', '', 0),
('edit', 'OnePlace\\Worktime\\Controller\\WorktimeController', 'Edit', '', '', 0),
('index', 'OnePlace\\Worktime\\Controller\\WorktimeController', 'Index', 'Worktimes', '/worktime', 1),
('list', 'OnePlace\\Worktime\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Worktime\\Controller\\WorktimeController', 'View', '', '', 0),
('dump', 'OnePlace\\Worktime\\Controller\\ExportController', 'Excel Dump', '', '', 0),
('index', 'OnePlace\\Worktime\\Controller\\SearchController', 'Search', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('worktime-single', 'Worktime', 'OnePlace\\Worktime\\Model\\Worktime', 'OnePlace\\Worktime\\Model\\WorktimeTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('worktime-index', 'worktime-single', 'Worktime Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('worktime-base', 'worktime-single', 'Worktime', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Worktime', 'fas fa-save', 'Save Worktime', '#', 'primary saveForm', '', 'worktime-single', 'link', '', ''),
(NULL, 'Edit Worktime', 'fas fa-edit', 'Edit Worktime', '/worktime/edit/##ID##', 'primary', '', 'worktime-view', 'link', '', ''),
(NULL, 'Add Worktime', 'fas fa-plus', 'Add Worktime', '/worktime/add', 'primary', '', 'worktime-index', 'link', '', ''),
(NULL, 'Export Worktimes', 'fas fa-file-excel', 'Export Worktimes', '/worktime/export', 'primary', '', 'worktime-index', 'link', '', ''),
(NULL, 'Find Worktimes', 'fas fa-searh', 'Find Worktimes', '/worktime/search', 'primary', '', 'worktime-index', 'link', '', ''),
(NULL, 'Export Worktimes', 'fas fa-file-excel', 'Export Worktimes', '#', 'primary initExcelDump', '', 'worktime-search', 'link', '', ''),
(NULL, 'New Search', 'fas fa-searh', 'New Search', '/worktime/search', 'primary', '', 'worktime-search', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'worktime-base', 'worktime-single', 'col-md-3', '/worktime/view/##ID##', '', 0, 1, 0, '', '', '');

--
-- Default Widgets
--
INSERT INTO `core_widget` (`Widget_ID`, `widget_name`, `label`, `permission`) VALUES
(NULL, 'worktime_dailystats', 'Worktime - Daily Stats', 'index-Worktime\\Controller\\WorktimeController'),
(NULL, 'worktime_taginfo', 'Worktime - Tag Info', 'index-Worktime\\Controller\\WorktimeController');

--
-- User XP Activity
--
INSERT INTO `user_xp_activity` (`Activity_ID`, `xp_key`, `label`, `xp_base`) VALUES
(NULL, 'worktime-add', 'Add New Worktime', '50'),
(NULL, 'worktime-edit', 'Edit Worktime', '5'),
(NULL, 'worktime-export', 'Edit Worktime', '5');

COMMIT;