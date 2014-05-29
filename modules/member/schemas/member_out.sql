CREATE  TABLE IF NOT EXISTS `member_out` (
  `out_orl` BIGINT(11) NOT NULL AUTO_INCREMENT ,
  `member_orl` BIGINT(11) NOT NULL ,
  `memo` TEXT NULL ,
  `status` TINYINT(1) NULL DEFAULT 0 ,
  `reg_datetime` CHAR(14) NOT NULL ,
  PRIMARY KEY (`out_orl`) )
ENGINE = InnoDB