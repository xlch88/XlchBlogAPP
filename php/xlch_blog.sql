CREATE TABLE `xlch_app_log` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deviceInfo` text,
  `appVersion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xlch_app_user` (
  `id` int(11) NOT NULL,
  `uuid` varchar(300) NOT NULL,
  `lastDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastIP` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `xlch_app_log`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `xlch_app_user`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `xlch_app_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `xlch_app_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;