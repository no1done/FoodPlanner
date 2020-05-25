<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1590414889.
 * Generated on 2020-05-25 13:54:49 by root
 */
class PropelMigration_1590414889
{
    public $comment = 'Insert categories after migration';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // post-migration code
        $sql = "
        INSERT INTO `category` (`name`, `key`, `created_at`) VALUES ('Breakfast', 'MEAL_BREAKFAST', '2020-05-25 15:01:42');
        INSERT INTO `category` (`name`, `key`, `created_at`) VALUES ('Lunch', 'MEAL_LUNCH', '2020-05-25 15:01:42');
        INSERT INTO `category` (`name`, `key`, `created_at`) VALUES ('Dinner', 'MEAL_DINNER', '2020-05-25 15:01:42');
        INSERT INTO `category` (`name`, `key`, `created_at`) VALUES ('Snack', 'MEAL_SNACK', '2020-05-25 15:01:42');";
        $pdo = $manager->getAdapterConnection('default');
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `category`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `key` VARCHAR(20) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `day_plan`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `shopping_list_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_day_plan_1` (`shopping_list_id`),
    CONSTRAINT `fk_day_plan_1`
        FOREIGN KEY (`shopping_list_id`)
        REFERENCES `shopping_list` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `day_plan_recipe`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `day_plan_id` INTEGER NOT NULL,
    `recipe_id` INTEGER NOT NULL,
    `category_id` INTEGER NOT NULL,
    `servers` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_day_plan_recipe_1` (`day_plan_id`),
    INDEX `fi_day_plan_recipe_2` (`recipe_id`),
    CONSTRAINT `fk_day_plan_recipe_1`
        FOREIGN KEY (`day_plan_id`)
        REFERENCES `day_plan` (`id`),
    CONSTRAINT `fk_day_plan_recipe_2`
        FOREIGN KEY (`recipe_id`)
        REFERENCES `recipe` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `category`;

DROP TABLE IF EXISTS `day_plan`;

DROP TABLE IF EXISTS `day_plan_recipe`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}