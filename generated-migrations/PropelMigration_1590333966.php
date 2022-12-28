<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1590333966.
 * Generated on 2020-05-24 15:26:06 by root
 */
class PropelMigration_1590333966
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

RENAME TABLE `recipe_ingredient` TO `recipe_item`;

RENAME TABLE `ingredient` TO `item`;

ALTER TABLE `list_recipe`

  ADD `ref` VARCHAR(20) NOT NULL AFTER `recipe_id`;

# Drop Indexed and foriegn keys 
ALTER TABLE `recipe_item` 
DROP FOREIGN KEY `fk_recipe_ingredient_2`,
DROP FOREIGN KEY `fk_recipe_ingredient_1`;
ALTER TABLE `recipe_item` 
DROP INDEX `fi_recipe_ingredient_2` ,
DROP INDEX `fi_recipe_ingredient_1` ;

# Change column name to item_id
ALTER TABLE `recipe_item` CHANGE `ingredient_id` `item_id` INTEGER NOT NULL;

# Create new indexes
CREATE INDEX `fi_recipe_item_1` ON `recipe_item` (`recipe_id`);
CREATE INDEX `fi_recipe_item_2` ON `recipe_item` (`item_id`);

ALTER TABLE `recipe_item` ADD CONSTRAINT `fk_recipe_item_1`
    FOREIGN KEY (`recipe_id`)
    REFERENCES `recipe` (`id`);

ALTER TABLE `recipe_item` ADD CONSTRAINT `fk_recipe_item_2`
    FOREIGN KEY (`item_id`)
    REFERENCES `item` (`id`);

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

DROP TABLE IF EXISTS `recipe_item`;

RENAME TABLE `item` TO `ingredient`;

ALTER TABLE `list_recipe`

  DROP `ref`;

CREATE TABLE `recipe_ingredient`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `recipe_id` INTEGER NOT NULL,
    `ingredient_id` INTEGER NOT NULL,
    `quantity` FLOAT(10,2) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_recipe_ingredient_1` (`recipe_id`),
    INDEX `fi_recipe_ingredient_2` (`ingredient_id`),
    CONSTRAINT `fk_recipe_ingredient_1`
        FOREIGN KEY (`recipe_id`)
        REFERENCES `recipe` (`id`),
    CONSTRAINT `fk_recipe_ingredient_2`
        FOREIGN KEY (`ingredient_id`)
        REFERENCES `ingredient` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}