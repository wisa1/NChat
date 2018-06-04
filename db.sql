-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema fh_2018_scm4_s1610307026
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema fh_2018_scm4_s1610307026
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fh_2018_scm4_s1610307026` DEFAULT CHARACTER SET latin1 ;
USE `fh_2018_scm4_s1610307026` ;

-- -----------------------------------------------------
-- Table `fh_2018_scm4_s1610307026`.`channels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fh_2018_scm4_s1610307026`.`channels` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(250) NULL DEFAULT NULL,
  `lastActivity` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `fh_2018_scm4_s1610307026`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fh_2018_scm4_s1610307026`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `userName` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `passwordHash` VARCHAR(45) CHARACTER SET 'latin1' NULL DEFAULT NULL,
  `countryId` INT(11) NULL DEFAULT NULL,
  `email` VARCHAR(250) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `userName_UNIQUE` (`userName` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `fh_2018_scm4_s1610307026`.`channels_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fh_2018_scm4_s1610307026`.`channels_users` (
  `id_channel` INT(11) NOT NULL,
  `id_user` INT(11) NOT NULL,
  PRIMARY KEY (`id_channel`, `id_user`),
  INDEX `fk_users_idx` (`id_user` ASC),
  CONSTRAINT `fk_channels`
    FOREIGN KEY (`id_channel`)
    REFERENCES `fh_2018_scm4_s1610307026`.`channels` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users`
    FOREIGN KEY (`id_user`)
    REFERENCES `fh_2018_scm4_s1610307026`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `fh_2018_scm4_s1610307026`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fh_2018_scm4_s1610307026`.`posts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_user` INT(11) NOT NULL,
  `id_channel` INT(11) NOT NULL,
  `title` TEXT NOT NULL,
  `text` TEXT NULL DEFAULT NULL,
  `deleted` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idposts_UNIQUE` (`id` ASC),
  INDEX `fk_users_idx` (`id_user` ASC),
  INDEX `fk_channels_idx` (`id_channel` ASC),
  CONSTRAINT `posts_fk_channels`
    FOREIGN KEY (`id_channel`)
    REFERENCES `fh_2018_scm4_s1610307026`.`channels` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `posts_fk_users`
    FOREIGN KEY (`id_user`)
    REFERENCES `fh_2018_scm4_s1610307026`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 18
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
