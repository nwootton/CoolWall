DROP SCHEMA IF EXISTS `HeatMap` ;
CREATE SCHEMA IF NOT EXISTS `HeatMap` DEFAULT CHARACTER SET utf8 ;
USE `HeatMap` ;

-- -----------------------------------------------------
-- Table `HeatMap`.`Card`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HeatMap`.`Card` ;

CREATE  TABLE IF NOT EXISTS `HeatMap`.`Card` (
  `CardID` INT(11) NOT NULL AUTO_INCREMENT ,
  `CardName` VARCHAR(255) NOT NULL ,
  `CardDescription` VARCHAR(4000) NOT NULL ,
  `UserID` INT(11) NOT NULL ,
  `StatusID` INT NOT NULL DEFAULT 1 ,
  `ColourID` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`CardID`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `HeatMap`.`UserInfo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HeatMap`.`UserInfo` ;

CREATE  TABLE IF NOT EXISTS `HeatMap`.`UserInfo` (
  `UserID` INT(11) NOT NULL AUTO_INCREMENT ,
  `UserName` VARCHAR(255) NOT NULL ,
  `UserEmail` VARCHAR(1000) NOT NULL ,
  PRIMARY KEY (`UserID`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `HeatMap`.`CardPosition`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HeatMap`.`CardPosition` ;

CREATE  TABLE IF NOT EXISTS `HeatMap`.`CardPosition` (
  `PositionID` INT NOT NULL AUTO_INCREMENT ,
  `CardID` INT NOT NULL ,
  `X` INT NOT NULL DEFAULT 10 ,
  `Y` INT NOT NULL DEFAULT 10 ,
  PRIMARY KEY (`PositionID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `HeatMap`.`Titles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HeatMap`.`Titles` ;

CREATE  TABLE IF NOT EXISTS `HeatMap`.`Titles` (
  `TitleID` INT NOT NULL AUTO_INCREMENT ,
  `TitleText` VARCHAR(45) NOT NULL ,
  `X` INT NOT NULL DEFAULT 0 ,
  `Y` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`TitleID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `HeatMap`.`Board`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HeatMap`.`Board` ;

CREATE  TABLE IF NOT EXISTS `HeatMap`.`Board` (
  `BoardID` INT NOT NULL AUTO_INCREMENT ,
  `BoardName` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`BoardID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `HeatMap`.`BoardCard`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HeatMap`.`BoardCard` ;

CREATE  TABLE IF NOT EXISTS `HeatMap`.`BoardCard` (
  `BoardCardID` INT NOT NULL AUTO_INCREMENT ,
  `CardID` INT NOT NULL ,
  `BoardID` INT NOT NULL ,
  PRIMARY KEY (`BoardCardID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `HeatMap`.`BoardTitles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HeatMap`.`BoardTitles` ;

CREATE  TABLE IF NOT EXISTS `HeatMap`.`BoardTitles` (
  `BoardTitleD` INT NOT NULL AUTO_INCREMENT ,
  `BoardID` INT NOT NULL ,
  `TitleID` INT NOT NULL ,
  PRIMARY KEY (`BoardTitleD`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `HeatMap`.`Update`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HeatMap`.`Update` ;

CREATE  TABLE IF NOT EXISTS `HeatMap`.`Update` (
  `UpdateID` INT NOT NULL AUTO_INCREMENT ,
  `BoardID` INT NOT NULL ,
  `bUpdate` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`UpdateID`) )
ENGINE = InnoDB;

USE `HeatMap`;

DELIMITER $$

USE `HeatMap`$$
DROP TRIGGER IF EXISTS `HeatMap`.`setPosition` $$
USE `HeatMap`$$


CREATE TRIGGER setPosition AFTER INSERT ON Card
  FOR EACH ROW BEGIN
    INSERT INTO CardPosition 
    SET CardID = NEW.CardID, X=10, Y=10;
    
  END;
$$


DELIMITER ;

