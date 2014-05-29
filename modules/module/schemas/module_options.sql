CREATE  TABLE IF NOT EXISTS `module_options` (
  `module_orl` BIGINT(11) NOT NULL ,
  `name` VARCHAR(80) NOT NULL ,
  `value` TEXT NULL ,
  PRIMARY KEY (`module_orl`, `name`) )
ENGINE = InnoDB