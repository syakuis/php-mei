CREATE  TABLE IF NOT EXISTS `layout` (
  `layout_orl` BIGINT(11) NOT NULL AUTO_INCREMENT ,
  `menu_orl` BIGINT(11) NULL ,
  `layout` VARCHAR(100) NULL ,
  `title` VARCHAR(250) NULL ,
  `header_script` TEXT NULL ,
  `extra_vars` TEXT NULL ,
  `is_mobile` CHAR(1) NULL DEFAULT 'N' ,
  `reg_datetime` CHAR(14) NULL ,
  PRIMARY KEY (`layout_orl`) )
ENGINE = InnoDB