SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `lastname` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `pwd` VARCHAR(90) NOT NULL ,
  `role` ENUM('admin','user') NOT NULL DEFAULT 'user' ,
  `active` TINYINT(1) NOT NULL DEFAULT 1 ,
  `created_at` DATETIME NOT NULL ,
  `created_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_user` (`created_by` ASC) ,
  CONSTRAINT `fk_user_user`
    FOREIGN KEY (`created_by` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
