ALTER TABLE `worktime`
ADD `startdatetime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `label`,
ADD `enddatetime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `startdatetime`,
ADD `worktimecomment` TEXT NOT NULL DEFAULT '' AFTER `benutzer_idfs`,
ADD `assigned_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `worktimecomment`;