<?php

namespace Lib\Map;

use Lib\DayPlanRecipe;
use Lib\DayPlanRecipeQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'day_plan_recipe' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class DayPlanRecipeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Lib.Map.DayPlanRecipeTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'day_plan_recipe';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'DayPlanRecipe';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Lib\\DayPlanRecipe';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Lib.DayPlanRecipe';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'day_plan_recipe.id';

    /**
     * the column name for the day_plan_id field
     */
    public const COL_DAY_PLAN_ID = 'day_plan_recipe.day_plan_id';

    /**
     * the column name for the recipe_id field
     */
    public const COL_RECIPE_ID = 'day_plan_recipe.recipe_id';

    /**
     * the column name for the category_id field
     */
    public const COL_CATEGORY_ID = 'day_plan_recipe.category_id';

    /**
     * the column name for the servers field
     */
    public const COL_SERVERS = 'day_plan_recipe.servers';

    /**
     * the column name for the complete field
     */
    public const COL_COMPLETE = 'day_plan_recipe.complete';

    /**
     * the column name for the created_at field
     */
    public const COL_CREATED_AT = 'day_plan_recipe.created_at';

    /**
     * the column name for the updated_at field
     */
    public const COL_UPDATED_AT = 'day_plan_recipe.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'DayPlanId', 'RecipeId', 'CategoryId', 'Servers', 'Complete', 'CreatedAt', 'UpdatedAt', ],
        self::TYPE_CAMELNAME     => ['id', 'dayPlanId', 'recipeId', 'categoryId', 'servers', 'complete', 'createdAt', 'updatedAt', ],
        self::TYPE_COLNAME       => [DayPlanRecipeTableMap::COL_ID, DayPlanRecipeTableMap::COL_DAY_PLAN_ID, DayPlanRecipeTableMap::COL_RECIPE_ID, DayPlanRecipeTableMap::COL_CATEGORY_ID, DayPlanRecipeTableMap::COL_SERVERS, DayPlanRecipeTableMap::COL_COMPLETE, DayPlanRecipeTableMap::COL_CREATED_AT, DayPlanRecipeTableMap::COL_UPDATED_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'day_plan_id', 'recipe_id', 'category_id', 'servers', 'complete', 'created_at', 'updated_at', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['Id' => 0, 'DayPlanId' => 1, 'RecipeId' => 2, 'CategoryId' => 3, 'Servers' => 4, 'Complete' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'dayPlanId' => 1, 'recipeId' => 2, 'categoryId' => 3, 'servers' => 4, 'complete' => 5, 'createdAt' => 6, 'updatedAt' => 7, ],
        self::TYPE_COLNAME       => [DayPlanRecipeTableMap::COL_ID => 0, DayPlanRecipeTableMap::COL_DAY_PLAN_ID => 1, DayPlanRecipeTableMap::COL_RECIPE_ID => 2, DayPlanRecipeTableMap::COL_CATEGORY_ID => 3, DayPlanRecipeTableMap::COL_SERVERS => 4, DayPlanRecipeTableMap::COL_COMPLETE => 5, DayPlanRecipeTableMap::COL_CREATED_AT => 6, DayPlanRecipeTableMap::COL_UPDATED_AT => 7, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'day_plan_id' => 1, 'recipe_id' => 2, 'category_id' => 3, 'servers' => 4, 'complete' => 5, 'created_at' => 6, 'updated_at' => 7, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'DayPlanRecipe.Id' => 'ID',
        'id' => 'ID',
        'dayPlanRecipe.id' => 'ID',
        'DayPlanRecipeTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'day_plan_recipe.id' => 'ID',
        'DayPlanId' => 'DAY_PLAN_ID',
        'DayPlanRecipe.DayPlanId' => 'DAY_PLAN_ID',
        'dayPlanId' => 'DAY_PLAN_ID',
        'dayPlanRecipe.dayPlanId' => 'DAY_PLAN_ID',
        'DayPlanRecipeTableMap::COL_DAY_PLAN_ID' => 'DAY_PLAN_ID',
        'COL_DAY_PLAN_ID' => 'DAY_PLAN_ID',
        'day_plan_id' => 'DAY_PLAN_ID',
        'day_plan_recipe.day_plan_id' => 'DAY_PLAN_ID',
        'RecipeId' => 'RECIPE_ID',
        'DayPlanRecipe.RecipeId' => 'RECIPE_ID',
        'recipeId' => 'RECIPE_ID',
        'dayPlanRecipe.recipeId' => 'RECIPE_ID',
        'DayPlanRecipeTableMap::COL_RECIPE_ID' => 'RECIPE_ID',
        'COL_RECIPE_ID' => 'RECIPE_ID',
        'recipe_id' => 'RECIPE_ID',
        'day_plan_recipe.recipe_id' => 'RECIPE_ID',
        'CategoryId' => 'CATEGORY_ID',
        'DayPlanRecipe.CategoryId' => 'CATEGORY_ID',
        'categoryId' => 'CATEGORY_ID',
        'dayPlanRecipe.categoryId' => 'CATEGORY_ID',
        'DayPlanRecipeTableMap::COL_CATEGORY_ID' => 'CATEGORY_ID',
        'COL_CATEGORY_ID' => 'CATEGORY_ID',
        'category_id' => 'CATEGORY_ID',
        'day_plan_recipe.category_id' => 'CATEGORY_ID',
        'Servers' => 'SERVERS',
        'DayPlanRecipe.Servers' => 'SERVERS',
        'servers' => 'SERVERS',
        'dayPlanRecipe.servers' => 'SERVERS',
        'DayPlanRecipeTableMap::COL_SERVERS' => 'SERVERS',
        'COL_SERVERS' => 'SERVERS',
        'day_plan_recipe.servers' => 'SERVERS',
        'Complete' => 'COMPLETE',
        'DayPlanRecipe.Complete' => 'COMPLETE',
        'complete' => 'COMPLETE',
        'dayPlanRecipe.complete' => 'COMPLETE',
        'DayPlanRecipeTableMap::COL_COMPLETE' => 'COMPLETE',
        'COL_COMPLETE' => 'COMPLETE',
        'day_plan_recipe.complete' => 'COMPLETE',
        'CreatedAt' => 'CREATED_AT',
        'DayPlanRecipe.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'dayPlanRecipe.createdAt' => 'CREATED_AT',
        'DayPlanRecipeTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'day_plan_recipe.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'DayPlanRecipe.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'dayPlanRecipe.updatedAt' => 'UPDATED_AT',
        'DayPlanRecipeTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'day_plan_recipe.updated_at' => 'UPDATED_AT',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('day_plan_recipe');
        $this->setPhpName('DayPlanRecipe');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Lib\\DayPlanRecipe');
        $this->setPackage('Lib');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('day_plan_id', 'DayPlanId', 'INTEGER', 'day_plan', 'id', true, null, null);
        $this->addForeignKey('recipe_id', 'RecipeId', 'INTEGER', 'recipe', 'id', true, null, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'category', 'id', true, null, null);
        $this->addColumn('servers', 'Servers', 'INTEGER', true, null, null);
        $this->addColumn('complete', 'Complete', 'BOOLEAN', false, 1, false);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('DayPlan', '\\Lib\\DayPlan', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':day_plan_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Recipe', '\\Lib\\Recipe', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':recipe_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Category', '\\Lib\\Category', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':category_id',
    1 => ':id',
  ),
), null, null, null, false);
    }

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array<string, array> Associative array (name => parameters) of behaviors
     */
    public function getBehaviors(): array
    {
        return [
            'timestampable' => ['create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false'],
        ];
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? DayPlanRecipeTableMap::CLASS_DEFAULT : DayPlanRecipeTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (DayPlanRecipe object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = DayPlanRecipeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DayPlanRecipeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DayPlanRecipeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DayPlanRecipeTableMap::OM_CLASS;
            /** @var DayPlanRecipe $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DayPlanRecipeTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = DayPlanRecipeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DayPlanRecipeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DayPlanRecipe $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DayPlanRecipeTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(DayPlanRecipeTableMap::COL_ID);
            $criteria->addSelectColumn(DayPlanRecipeTableMap::COL_DAY_PLAN_ID);
            $criteria->addSelectColumn(DayPlanRecipeTableMap::COL_RECIPE_ID);
            $criteria->addSelectColumn(DayPlanRecipeTableMap::COL_CATEGORY_ID);
            $criteria->addSelectColumn(DayPlanRecipeTableMap::COL_SERVERS);
            $criteria->addSelectColumn(DayPlanRecipeTableMap::COL_COMPLETE);
            $criteria->addSelectColumn(DayPlanRecipeTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(DayPlanRecipeTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.day_plan_id');
            $criteria->addSelectColumn($alias . '.recipe_id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.servers');
            $criteria->addSelectColumn($alias . '.complete');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(DayPlanRecipeTableMap::COL_ID);
            $criteria->removeSelectColumn(DayPlanRecipeTableMap::COL_DAY_PLAN_ID);
            $criteria->removeSelectColumn(DayPlanRecipeTableMap::COL_RECIPE_ID);
            $criteria->removeSelectColumn(DayPlanRecipeTableMap::COL_CATEGORY_ID);
            $criteria->removeSelectColumn(DayPlanRecipeTableMap::COL_SERVERS);
            $criteria->removeSelectColumn(DayPlanRecipeTableMap::COL_COMPLETE);
            $criteria->removeSelectColumn(DayPlanRecipeTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(DayPlanRecipeTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.day_plan_id');
            $criteria->removeSelectColumn($alias . '.recipe_id');
            $criteria->removeSelectColumn($alias . '.category_id');
            $criteria->removeSelectColumn($alias . '.servers');
            $criteria->removeSelectColumn($alias . '.complete');
            $criteria->removeSelectColumn($alias . '.created_at');
            $criteria->removeSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(DayPlanRecipeTableMap::DATABASE_NAME)->getTable(DayPlanRecipeTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a DayPlanRecipe or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or DayPlanRecipe object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DayPlanRecipeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Lib\DayPlanRecipe) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DayPlanRecipeTableMap::DATABASE_NAME);
            $criteria->add(DayPlanRecipeTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DayPlanRecipeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DayPlanRecipeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DayPlanRecipeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the day_plan_recipe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return DayPlanRecipeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DayPlanRecipe or Criteria object.
     *
     * @param mixed $criteria Criteria or DayPlanRecipe object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DayPlanRecipeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DayPlanRecipe object
        }

        if ($criteria->containsKey(DayPlanRecipeTableMap::COL_ID) && $criteria->keyContainsValue(DayPlanRecipeTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DayPlanRecipeTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DayPlanRecipeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
