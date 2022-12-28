<?php

namespace Lib\Map;

use Lib\ShoppingListItem;
use Lib\ShoppingListItemQuery;
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
 * This class defines the structure of the 'shopping_list_item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class ShoppingListItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Lib.Map.ShoppingListItemTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'shopping_list_item';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'ShoppingListItem';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Lib\\ShoppingListItem';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Lib.ShoppingListItem';

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
    public const COL_ID = 'shopping_list_item.id';

    /**
     * the column name for the shopping_list_id field
     */
    public const COL_SHOPPING_LIST_ID = 'shopping_list_item.shopping_list_id';

    /**
     * the column name for the item_id field
     */
    public const COL_ITEM_ID = 'shopping_list_item.item_id';

    /**
     * the column name for the quantity field
     */
    public const COL_QUANTITY = 'shopping_list_item.quantity';

    /**
     * the column name for the ref field
     */
    public const COL_REF = 'shopping_list_item.ref';

    /**
     * the column name for the purchased field
     */
    public const COL_PURCHASED = 'shopping_list_item.purchased';

    /**
     * the column name for the created_at field
     */
    public const COL_CREATED_AT = 'shopping_list_item.created_at';

    /**
     * the column name for the updated_at field
     */
    public const COL_UPDATED_AT = 'shopping_list_item.updated_at';

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
        self::TYPE_PHPNAME       => ['Id', 'ShoppingListId', 'ItemId', 'Quantity', 'Ref', 'Purchased', 'CreatedAt', 'UpdatedAt', ],
        self::TYPE_CAMELNAME     => ['id', 'shoppingListId', 'itemId', 'quantity', 'ref', 'purchased', 'createdAt', 'updatedAt', ],
        self::TYPE_COLNAME       => [ShoppingListItemTableMap::COL_ID, ShoppingListItemTableMap::COL_SHOPPING_LIST_ID, ShoppingListItemTableMap::COL_ITEM_ID, ShoppingListItemTableMap::COL_QUANTITY, ShoppingListItemTableMap::COL_REF, ShoppingListItemTableMap::COL_PURCHASED, ShoppingListItemTableMap::COL_CREATED_AT, ShoppingListItemTableMap::COL_UPDATED_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'shopping_list_id', 'item_id', 'quantity', 'ref', 'purchased', 'created_at', 'updated_at', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'ShoppingListId' => 1, 'ItemId' => 2, 'Quantity' => 3, 'Ref' => 4, 'Purchased' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'shoppingListId' => 1, 'itemId' => 2, 'quantity' => 3, 'ref' => 4, 'purchased' => 5, 'createdAt' => 6, 'updatedAt' => 7, ],
        self::TYPE_COLNAME       => [ShoppingListItemTableMap::COL_ID => 0, ShoppingListItemTableMap::COL_SHOPPING_LIST_ID => 1, ShoppingListItemTableMap::COL_ITEM_ID => 2, ShoppingListItemTableMap::COL_QUANTITY => 3, ShoppingListItemTableMap::COL_REF => 4, ShoppingListItemTableMap::COL_PURCHASED => 5, ShoppingListItemTableMap::COL_CREATED_AT => 6, ShoppingListItemTableMap::COL_UPDATED_AT => 7, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'shopping_list_id' => 1, 'item_id' => 2, 'quantity' => 3, 'ref' => 4, 'purchased' => 5, 'created_at' => 6, 'updated_at' => 7, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'ShoppingListItem.Id' => 'ID',
        'id' => 'ID',
        'shoppingListItem.id' => 'ID',
        'ShoppingListItemTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'shopping_list_item.id' => 'ID',
        'ShoppingListId' => 'SHOPPING_LIST_ID',
        'ShoppingListItem.ShoppingListId' => 'SHOPPING_LIST_ID',
        'shoppingListId' => 'SHOPPING_LIST_ID',
        'shoppingListItem.shoppingListId' => 'SHOPPING_LIST_ID',
        'ShoppingListItemTableMap::COL_SHOPPING_LIST_ID' => 'SHOPPING_LIST_ID',
        'COL_SHOPPING_LIST_ID' => 'SHOPPING_LIST_ID',
        'shopping_list_id' => 'SHOPPING_LIST_ID',
        'shopping_list_item.shopping_list_id' => 'SHOPPING_LIST_ID',
        'ItemId' => 'ITEM_ID',
        'ShoppingListItem.ItemId' => 'ITEM_ID',
        'itemId' => 'ITEM_ID',
        'shoppingListItem.itemId' => 'ITEM_ID',
        'ShoppingListItemTableMap::COL_ITEM_ID' => 'ITEM_ID',
        'COL_ITEM_ID' => 'ITEM_ID',
        'item_id' => 'ITEM_ID',
        'shopping_list_item.item_id' => 'ITEM_ID',
        'Quantity' => 'QUANTITY',
        'ShoppingListItem.Quantity' => 'QUANTITY',
        'quantity' => 'QUANTITY',
        'shoppingListItem.quantity' => 'QUANTITY',
        'ShoppingListItemTableMap::COL_QUANTITY' => 'QUANTITY',
        'COL_QUANTITY' => 'QUANTITY',
        'shopping_list_item.quantity' => 'QUANTITY',
        'Ref' => 'REF',
        'ShoppingListItem.Ref' => 'REF',
        'ref' => 'REF',
        'shoppingListItem.ref' => 'REF',
        'ShoppingListItemTableMap::COL_REF' => 'REF',
        'COL_REF' => 'REF',
        'shopping_list_item.ref' => 'REF',
        'Purchased' => 'PURCHASED',
        'ShoppingListItem.Purchased' => 'PURCHASED',
        'purchased' => 'PURCHASED',
        'shoppingListItem.purchased' => 'PURCHASED',
        'ShoppingListItemTableMap::COL_PURCHASED' => 'PURCHASED',
        'COL_PURCHASED' => 'PURCHASED',
        'shopping_list_item.purchased' => 'PURCHASED',
        'CreatedAt' => 'CREATED_AT',
        'ShoppingListItem.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'shoppingListItem.createdAt' => 'CREATED_AT',
        'ShoppingListItemTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'shopping_list_item.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'ShoppingListItem.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'shoppingListItem.updatedAt' => 'UPDATED_AT',
        'ShoppingListItemTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'shopping_list_item.updated_at' => 'UPDATED_AT',
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
        $this->setName('shopping_list_item');
        $this->setPhpName('ShoppingListItem');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Lib\\ShoppingListItem');
        $this->setPackage('Lib');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('shopping_list_id', 'ShoppingListId', 'INTEGER', 'shopping_list', 'id', true, null, null);
        $this->addForeignKey('item_id', 'ItemId', 'INTEGER', 'item', 'id', true, null, null);
        $this->addColumn('quantity', 'Quantity', 'FLOAT', true, 10, null);
        $this->addForeignKey('ref', 'Ref', 'VARCHAR', 'list_recipe', 'ref', false, 100, null);
        $this->addColumn('purchased', 'Purchased', 'BOOLEAN', false, 1, false);
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
        $this->addRelation('Item', '\\Lib\\Item', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':item_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('ListRecipe', '\\Lib\\ListRecipe', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':ref',
    1 => ':ref',
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
        return $withPrefix ? ShoppingListItemTableMap::CLASS_DEFAULT : ShoppingListItemTableMap::OM_CLASS;
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
     * @return array (ShoppingListItem object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = ShoppingListItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ShoppingListItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ShoppingListItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ShoppingListItemTableMap::OM_CLASS;
            /** @var ShoppingListItem $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ShoppingListItemTableMap::addInstanceToPool($obj, $key);
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
            $key = ShoppingListItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ShoppingListItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ShoppingListItem $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ShoppingListItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ShoppingListItemTableMap::COL_ID);
            $criteria->addSelectColumn(ShoppingListItemTableMap::COL_SHOPPING_LIST_ID);
            $criteria->addSelectColumn(ShoppingListItemTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(ShoppingListItemTableMap::COL_QUANTITY);
            $criteria->addSelectColumn(ShoppingListItemTableMap::COL_REF);
            $criteria->addSelectColumn(ShoppingListItemTableMap::COL_PURCHASED);
            $criteria->addSelectColumn(ShoppingListItemTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ShoppingListItemTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.shopping_list_id');
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.quantity');
            $criteria->addSelectColumn($alias . '.ref');
            $criteria->addSelectColumn($alias . '.purchased');
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
            $criteria->removeSelectColumn(ShoppingListItemTableMap::COL_ID);
            $criteria->removeSelectColumn(ShoppingListItemTableMap::COL_SHOPPING_LIST_ID);
            $criteria->removeSelectColumn(ShoppingListItemTableMap::COL_ITEM_ID);
            $criteria->removeSelectColumn(ShoppingListItemTableMap::COL_QUANTITY);
            $criteria->removeSelectColumn(ShoppingListItemTableMap::COL_REF);
            $criteria->removeSelectColumn(ShoppingListItemTableMap::COL_PURCHASED);
            $criteria->removeSelectColumn(ShoppingListItemTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(ShoppingListItemTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.shopping_list_id');
            $criteria->removeSelectColumn($alias . '.item_id');
            $criteria->removeSelectColumn($alias . '.quantity');
            $criteria->removeSelectColumn($alias . '.ref');
            $criteria->removeSelectColumn($alias . '.purchased');
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
        return Propel::getServiceContainer()->getDatabaseMap(ShoppingListItemTableMap::DATABASE_NAME)->getTable(ShoppingListItemTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a ShoppingListItem or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or ShoppingListItem object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ShoppingListItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Lib\ShoppingListItem) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ShoppingListItemTableMap::DATABASE_NAME);
            $criteria->add(ShoppingListItemTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ShoppingListItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ShoppingListItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ShoppingListItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shopping_list_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return ShoppingListItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ShoppingListItem or Criteria object.
     *
     * @param mixed $criteria Criteria or ShoppingListItem object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShoppingListItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ShoppingListItem object
        }

        if ($criteria->containsKey(ShoppingListItemTableMap::COL_ID) && $criteria->keyContainsValue(ShoppingListItemTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ShoppingListItemTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ShoppingListItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
