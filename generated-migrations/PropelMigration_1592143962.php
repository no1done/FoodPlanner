<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1592143962.
 * Generated on 2020-06-14 14:12:42 by root
 */
class PropelMigration_1592143962
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // pre-migration code
        $sql = "UPDATE list_recipe SET ref = null WHERE ref = '';";
        $pdo = $manager->getAdapterConnection('default');
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
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

CREATE INDEX `i_referenced_fk_shopping_list_item_3_1` ON `list_recipe` (`ref`);

CREATE UNIQUE INDEX `list_recipe_u_513e82` ON `list_recipe` (`ref`(100));

CREATE INDEX `fi_shopping_list_item_3` ON `shopping_list_item` (`ref`);

ALTER TABLE `shopping_list_item` ADD CONSTRAINT `fk_shopping_list_item_3`
    FOREIGN KEY (`ref`)
    REFERENCES `list_recipe` (`ref`);

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

DROP INDEX `i_referenced_fk_shopping_list_item_3_1` ON `list_recipe`;

DROP INDEX `list_recipe_u_513e82` ON `list_recipe`;

ALTER TABLE `shopping_list_item` DROP FOREIGN KEY `fk_shopping_list_item_3`;

DROP INDEX `fi_shopping_list_item_3` ON `shopping_list_item`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}