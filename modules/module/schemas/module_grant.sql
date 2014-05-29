CREATE  TABLE IF NOT EXISTS `module_grant` (
  `module_orl` BIGINT(11) NOT NULL ,
  `name` VARCHAR(20) NOT NULL ,
  `group_orl` BIGINT(11) NOT NULL ,
  PRIMARY KEY (`module_orl`, `name`) )
ENGINE = InnoDB