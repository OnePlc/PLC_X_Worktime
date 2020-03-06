INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'datetime', 'Start', 'startdatetime', 'worktime-base', 'worktime-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'datetime', 'Ende', 'enddatetime', 'worktime-base', 'worktime-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'textarea', 'Kommentar', 'worktimecomment', 'worktime-base', 'worktime-single', 'col-md-12', '', '', '0', '1', '0', '', '', ''),
(NULL, 'select', 'erfasster Benutzer', 'assigned_idfs', 'worktime-base', 'worktime-single', 'col-md-3', '', '/user/api/list/0', 0, 1, 0, 'user-single', 'OnePlace\\User\\Model\\UserTable','add-OnePlace\\User\\Controller\\UserController');
