CREATE  TABLE IF NOT EXISTS `document_readed_log` (
  `document_orl` BIGINT(11) NOT NULL ,
  `member_orl` BIGINT(11) NOT NULL ,
  `module_orl` BIGINT(11) NOT NULL ,
  `reg_datetime` CHAR(14) NOT NULL ,
  `ipaddress` VARCHAR(128) NOT NULL ,
  INDEX `idx_document_orl` (`document_orl` ASC) ,
  INDEX `idx_member_orl` (`member_orl` ASC) ,
  INDEX `idx_reg_datetime` (`reg_datetime` ASC) ,
  INDEX `idx_ipaddress` (`ipaddress` ASC) ,
  PRIMARY KEY (`document_orl`, `member_orl`) )
ENGINE = InnoDB