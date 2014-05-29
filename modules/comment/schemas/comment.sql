CREATE  TABLE IF NOT EXISTS `comment` (
  `comment_orl` BIGINT(11) NOT NULL AUTO_INCREMENT ,
  `module_orl` BIGINT(11) NOT NULL ,
  `target_orl` BIGINT(11) NOT NULL ,
  `parent_orl` BIGINT(11) NULL DEFAULT 0 ,
  `reply_group` BIGINT(11) NULL ,
  `reply_depth` BIGINT(11) NULL DEFAULT 0 ,
  `reply_seq` BIGINT(11) NULL DEFAULT 0 ,
  `member_orl` BIGINT(11) NULL ,
  `user_id` VARCHAR(100) NULL ,
  `nickname` VARCHAR(100) NULL ,
  `content` LONGTEXT NOT NULL ,
  `content_text` LONGTEXT NOT NULL ,
  `good_count` BIGINT(11) NULL DEFAULT 0 ,
  `bad_count` BIGINT(11) NULL DEFAULT 0 ,
  `accuse_count` BIGINT(11) NULL DEFAULT 0 ,
  `is_mobile` CHAR(1) NULL DEFAULT 'N' ,
  `state` TINYINT(1) NULL DEFAULT 0 ,
  `ipaddress` VARCHAR(128) NULL ,
  `reg_datetime` CHAR(14) NULL ,
  `update_datetime` CHAR(14) NULL ,
  `listorder` BIGINT(11) NULL ,
  PRIMARY KEY (`comment_orl`) )
ENGINE = InnoDB