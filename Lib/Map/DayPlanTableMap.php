<?php

namespace Lib\Map;

use Lib\DayPlan;
use Lib\DayPlanQuery;
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
 * This class defines the structure of the 'day_plan' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class DayPlanTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Lib.Map.DayPlanTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'day_plan';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'DayPlan';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Lib\\DayPlan';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Lib.DayPlan';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'day_plan.id';

    /**
     * the column name for the shopping_list_id field
     */
    public const COL_SHOPPING_LIST_ID = 'day_plan.shopping_list_id';

    /**
     * the column name for the complete field
     */
    public const COL_COMPLETE = 'day_plan.complete';

    /**
     * the column name for the created_at field
     */
    public const COL_CREATED_AT = 'day_plan.created_at';

    /**
     * the column name for the updated_at field
     */
    public const COL_UPDATED_AT = 'day_plan.updated_at';

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
        self::TYPE_PHPNAME       => ['Id', 'ShoppingListId', 'Complete', 'CreatedAt', 'UpdatedAt', ],
        self::TYPE_CAMELNAME     => ['id', 'shoppingListId', 'complete', 'createdAt', 'updatedAt', ],
        self::TYPE_COLNAME       => [DayPlanTableMap::COL_ID, DayPlanTableMap::COL_SHOPPING_LIST_ID, DayPlanTableMap::COL_COMPLETE, DayPlanTableMap::COL_CREATED_AT, DayPlanTableMap::COL_UPDATED_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'shopping_list_id', 'complete', 'created_at', 'updated_at', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'ShoppingListId' => 1, 'Complete' => 2, 'CreatedAt' => 3, 'UpdatedAt' => 4, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'shoppingListId' => 1, 'complete' => 2, 'createdAt' => 3, 'updatedAt' => 4, ],
        self::TYPE_COLNAME       => [DayPlanTableMap::COL_ID => 0, DayPlanTableMap::COL_SHOPPING_LIST_ID => 1, DayPlanTableMap::COL_COMPLETE => 2, DayPlanTableMap::COL_CREATED_AT => 3, DayPlanTableMap::COL_UPDATED_AT => 4, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'shopping_list_id' => 1, 'complete' => 2, 'created_at' => 3, 'updated_at' => 4, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'DayPlan.Id' => 'ID',
        'id' => 'ID',
        'dayPlan.id' => 'ID',
        'DayPlanTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'day_plan.id' => 'ID',
        'ShoppingListId' => 'SHOPPING_LIST_ID',
        'DayPlan.ShoppingListId' => 'SHOPPING_LIST_ID',
        'shoppingListId' => 'SHOPPING_LIST_ID',
        'dayPlan.shoppingListId' => 'SHOPPING_LIST_ID',
        'DayPlanTableMap::COL_SHOPPING_LIST_ID' => 'SHOPPING_LIST_ID',
        'COL_SHOPPING_LIST_ID' => 'SHOPPING_LIST_ID',
        'shopping_list_id' => 'SHOPPING_LIST_ID',
        'day_plan.shopping_list_id' => 'SHOPPING_LIST_ID',
        'Complete' => 'COMPLETE',
        'DayPlan.Complete' => 'COMPLETE',
        'complete' => 'COMPLETE',
        'dayPlan.complete' => 'COMPLETE',
        'DayPlanTableMap::COL_COMPLETE' => 'COMPLETE',
        'COL_COMPLETE' => 'COMPLETE',
        'day_plan.complete' => 'COMPLETE',
        'CreatedAt' => 'CREATED_AT',
        'DayPlan.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'dayPlan.createdAt' => 'CREATED_AT',
        'DayPlanTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'day_plan.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'DayPlan.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'dayPlan.updatedAt' => 'UPDATED_AT',
        'DayPlanTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'day_plan.updated_at' => 'UPDATED_AT',
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
        $this->setName('day_plan');
        $this->setPhpName('DayPlan');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Lib\\DayPlan');
        $this->setPackage('Lib');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('shopping_list_id', 'ShoppingListId', 'INTEGER', 'shopping_list', 'id', true, null, null);
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
        $this->addRelation('ShoppingList', '\\Lib\\ShoppingList', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':shopping_list_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('DayPlanRecipe', '\\Lib\\DayPlanRecipe', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':day_plan_id',
    1 => ':id',
  ),
), null, null, 'DayPlanRecipes', false);
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
        return $withPrefix ? DayPlanTableMap::CLASS_DEFAULT : DayPlanTableMap::OM_CLASS;
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
     * @return array (DayPlan object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = DayPlanTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DayPlanTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DayPlanTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DayPlanTableMap::OM_CLASS;
            /** @var DayPlan $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DayPlanTableMap::addInstanceToPool($obj, $key);
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
            $key = DayPlanTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DayPlanTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DayPlan $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DayPlanTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DayPlanTableMap::COL_ID);
            $criteria->addSelectColumn(DayPlanTableMap::COL_SHOPPING_LIST_ID);
            $criteria->addSelectColumn(DayPlanTableMap::COL_COMPLETE);
            $criteria->addSelectColumn(DayPlanTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(DayPlanTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.shopping_list_id');
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
            $criteria->removeSelectColumn(DayPlanTableMap::COL_ID);
            $criteria->removeSelectColumn(DayPlanTableMap::COL_SHOPPING_LIST_ID);
            $criteria->removeSelectColumn(DayPlanTableMap::COL_COMPLETE);
            $criteria->removeSelectColumn(DayPlanTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(DayPlanTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.shopping_list_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(DayPlanTableMap::DATABASE_NAME)->getTable(DayPlanTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a DayPlan or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or DayPlan object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DayPlanTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Lib\DayPlan) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DayPlanTableMap::DATABASE_NAME);
            $criteria->add(DayPlanTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DayPlanQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DayPlanTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DayPlanTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the day_plan table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return DayPlanQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DayPlan or Criteria object.
     *
     * @param mixed $criteria Criteria or DayPlan object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DayPlanTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DayPlan object
        }

        if ($criteria->containsKey(DayPlanTableMap::COL_ID) && $criteria->keyContainsValue(DayPlanTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DayPlanTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DayPlanQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
