CREATE  TABLE IF NOT EXISTS `comment_voted_log` (
  `comment_orl` BIGINT(11) NOT NULL ,
  `member_orl` BIGINT(11) NOT NULL ,
  `module_orl` BIGINT(11) NOT NULL ,
  `target_orl` BIGINT(11) NOT NULL ,
  `vote` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 : 추천,-1: 비추' ,
  `reg_datetime` CHAR(14) NOT NULL ,
  `ipaddress` VARCHAR(128) NOT NULL ,
  INDEX `idx_document_orl` (`comment_orl` ASC) ,
  INDEX `idx_member_orl` (`member_orl` ASC) ,
  INDEX `idx_reg_datetime` (`reg_datetime` ASC) ,
  INDEX `idx_ipaddress` (`ipaddress` ASC) ,
  PRIMARY KEY (`comment_orl`, `member_orl`) ,
  INDEX `idx_vote` (`vote` ASC) )
ENGINE = InnoDB