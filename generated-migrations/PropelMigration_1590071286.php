<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1590071286.
 * Generated on 2020-05-21 14:28:06 by root
 */
class PropelMigration_1590071286
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

CREATE INDEX `fi_list_recipe_1` ON `list_recipe` (`shopping_list_id`);

CREATE INDEX `fi_list_recipe_2` ON `list_recipe` (`recipe_id`);

ALTER TABLE `list_recipe` ADD CONSTRAINT `fk_list_recipe_1`
    FOREIGN KEY (`shopping_list_id`)
    REFERENCES `shopping_list` (`id`);

ALTER TABLE `list_recipe` ADD CONSTRAINT `fk_list_recipe_2`
    FOREIGN KEY (`recipe_id`)
    REFERENCES `recipe` (`id`);

CREATE INDEX `fi_recipe_ingredient_1` ON `recipe_ingredient` (`recipe_id`);

CREATE INDEX `fi_recipe_ingredient_2` ON `recipe_ingredient` (`ingredient_id`);

ALTER TABLE `recipe_ingredient` ADD CONSTRAINT `fk_recipe_ingredient_1`
    FOREIGN KEY (`recipe_id`)
    REFERENCES `recipe` (`id`);

ALTER TABLE `recipe_ingredient` ADD CONSTRAINT `fk_recipe_ingredient_2`
    FOREIGN KEY (`ingredient_id`)
    REFERENCES `ingredient` (`id`);

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

ALTER TABLE `list_recipe` DROP FOREIGN KEY `fk_list_recipe_1`;

ALTER TABLE `list_recipe` DROP FOREIGN KEY `fk_list_recipe_2`;

DROP INDEX `fi_list_recipe_1` ON `list_recipe`;

DROP INDEX `fi_list_recipe_2` ON `list_recipe`;

ALTER TABLE `recipe_ingredient` DROP FOREIGN KEY `fk_recipe_ingredient_1`;

ALTER TABLE `recipe_ingredient` DROP FOREIGN KEY `fk_recipe_ingredient_2`;

DROP INDEX `fi_recipe_ingredient_1` ON `recipe_ingredient`;

DROP INDEX `fi_recipe_ingredient_2` ON `recipe_ingredient`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}