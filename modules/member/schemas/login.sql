CREATE  TABLE IF NOT EXISTS `login` (
  `login_orl` BIGINT(11) NOT NULL AUTO_INCREMENT ,
  `member_orl` BIGINT(11) NOT NULL ,
  `sid` VARCHAR(250) NOT NULL ,
  `ipaddress` VARCHAR(128) NOT NULL ,
  `user_agent` VARCHAR(250) NOT NULL ,
  `reg_datetime` CHAR(14) NULL ,
  PRIMARY KEY (`login_orl`) )
ENGINE = InnoDB