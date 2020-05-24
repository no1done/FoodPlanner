<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1590335780.
 * Generated on 2020-05-24 15:56:20 by root
 */
class PropelMigration_1590335780
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
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

CREATE TABLE `shopping_list_item`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `shopping_list_id` INTEGER NOT NULL,
    `item_id` INTEGER NOT NULL,
    `quantity` FLOAT(10,2) NOT NULL,
    `ref` VARCHAR(20),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_shopping_list_item_1` (`shopping_list_id`),
    INDEX `fi_shopping_list_item_2` (`item_id`),
    CONSTRAINT `fk_shopping_list_item_1`
        FOREIGN KEY (`shopping_list_id`)
        REFERENCES `shopping_list` (`id`),
    CONSTRAINT `fk_shopping_list_item_2`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`id`)
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

DROP TABLE IF EXISTS `shopping_list_item`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}