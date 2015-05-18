-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema cdnl_livinghell
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema cdnl_livinghell
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cdnl_livinghell` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `cdnl_livinghell` ;

-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`quiz`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`quiz` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`quiz` (
  `id_quiz` INT NOT NULL,
  `nom` VARCHAR(45) NULL,
  `maj` DATETIME NULL,
  PRIMARY KEY (`id_quiz`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`tag` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`tag` (
  `id_tag` INT NOT NULL,
  `nom` VARCHAR(45) NULL,
  `icone` VARCHAR(45) NULL,
  PRIMARY KEY (`id_tag`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`quest_tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`quest_tag` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`quest_tag` (
  `id_quiz` INT NOT NULL,
  `id_tag` INT NOT NULL,
  PRIMARY KEY (`id_quiz`, `id_tag`),
  INDEX `fk_questionnaire_has_tag_tag1_idx` (`id_tag` ASC),
  INDEX `fk_questionnaire_has_tag_questionnaire_idx` (`id_quiz` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`question` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`question` (
  `id_question` INT NOT NULL AUTO_INCREMENT,
  `contenu` VARCHAR(255) NULL,
  `media` VARCHAR(45) NULL,
  `niveau` INT NULL,
  PRIMARY KEY (`id_question`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`question_reponse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`question_reponse` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`question_reponse` (
  `id_question` INT NOT NULL,
  `id_tag` INT NOT NULL,
  `contenu` VARCHAR(45) NULL,
  `explication` VARCHAR(45) NULL,
  INDEX `fk_question_has_reponse_question1_idx` (`id_question` ASC),
  PRIMARY KEY (`id_question`, `id_tag`),
  INDEX `fk_question_reponse_tag1_idx` (`id_tag` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`quest_question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`quest_question` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`quest_question` (
  `id_quiz` INT NOT NULL,
  `id_question` INT NOT NULL,
  PRIMARY KEY (`id_quiz`, `id_question`),
  INDEX `fk_quest_has_question_question1_idx` (`id_question` ASC),
  INDEX `fk_quest_has_question_quest1_idx` (`id_quiz` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`tag_question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`tag_question` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`tag_question` (
  `id_tag` INT NOT NULL,
  `id_question` INT NOT NULL,
  PRIMARY KEY (`id_tag`, `id_question`),
  INDEX `fk_tag_has_question_question1_idx` (`id_question` ASC),
  INDEX `fk_tag_has_question_tag1_idx` (`id_tag` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`utilisateur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`utilisateur` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`utilisateur` (
  `id_uti` INT NOT NULL,
  `login` VARCHAR(45) NULL,
  `mail` VARCHAR(45) NULL,
  `pwd` VARCHAR(45) NULL,
  `avatar` VARCHAR(45) NULL,
  `niveau` VARCHAR(45) NULL,
  `xp` INT NULL,
  PRIMARY KEY (`id_uti`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`score`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`score` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`score` (
  `id_score` INT NOT NULL AUTO_INCREMENT,
  `id_question` INT NOT NULL,
  `id_uti` INT NOT NULL,
  `note` INT NULL,
  `maj` DATETIME NULL,
  PRIMARY KEY (`id_score`),
  INDEX `fk_score_question1_idx` (`id_question` ASC),
  INDEX `fk_score_utilisateur1_idx` (`id_uti` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`badge`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`badge` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`badge` (
  `id_badge` INT NOT NULL,
  `contenu` VARCHAR(45) NULL,
  `id_tag` INT NOT NULL,
  PRIMARY KEY (`id_badge`),
  INDEX `fk_badge_tag1_idx` (`id_tag` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`utilisateur_badge`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`utilisateur_badge` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`utilisateur_badge` (
  `id_uti` INT NOT NULL,
  `id_badge` INT NOT NULL,
  PRIMARY KEY (`id_uti`, `id_badge`),
  INDEX `fk_utilisateur_has_badge_badge1_idx` (`id_badge` ASC),
  INDEX `fk_utilisateur_has_badge_utilisateur1_idx` (`id_uti` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`niveau`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`niveau` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`niveau` (
  `id_niveau` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NULL,
  PRIMARY KEY (`id_niveau`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cdnl_livinghell`.`utilisateur_niveau`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cdnl_livinghell`.`utilisateur_niveau` ;

CREATE TABLE IF NOT EXISTS `cdnl_livinghell`.`utilisateur_niveau` (
  `id_uti` INT NOT NULL,
  `id_niveau` INT NOT NULL,
  `maj` DATETIME NULL,
  PRIMARY KEY (`id_uti`, `id_niveau`),
  INDEX `fk_utilisateur_has_niveau_niveau1_idx` (`id_niveau` ASC),
  INDEX `fk_utilisateur_has_niveau_utilisateur1_idx` (`id_uti` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
