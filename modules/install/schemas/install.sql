CREATE  TABLE IF NOT EXISTS `install` (
  `install_orl` BIGINT(11) NOT NULL AUTO_INCREMENT ,
  `module` VARCHAR(150) NOT NULL ,
  `status` CHAR(1) NULL DEFAULT 'N' ,
  `reg_datetime` CHAR(14) NULL ,
  `update_datetime` CHAR(14) NULL ,
  PRIMARY KEY (`install_orl`) ,
  INDEX `idx_module` (`module` ASC) ,
  UNIQUE INDEX `module_UNIQUE` (`module` ASC) )
ENGINE = InnoDB