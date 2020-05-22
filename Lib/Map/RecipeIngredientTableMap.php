<?php

namespace Lib\Map;

use Lib\RecipeIngredient;
use Lib\RecipeIngredientQuery;
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
 * This class defines the structure of the 'recipe_ingredient' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class RecipeIngredientTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Lib.Map.RecipeIngredientTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'recipe_ingredient';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Lib\\RecipeIngredient';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Lib.RecipeIngredient';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'recipe_ingredient.id';

    /**
     * the column name for the recipe_id field
     */
    const COL_RECIPE_ID = 'recipe_ingredient.recipe_id';

    /**
     * the column name for the ingredient_id field
     */
    const COL_INGREDIENT_ID = 'recipe_ingredient.ingredient_id';

    /**
     * the column name for the quantity field
     */
    const COL_QUANTITY = 'recipe_ingredient.quantity';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'recipe_ingredient.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'recipe_ingredient.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'RecipeId', 'IngredientId', 'Quantity', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'recipeId', 'ingredientId', 'quantity', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(RecipeIngredientTableMap::COL_ID, RecipeIngredientTableMap::COL_RECIPE_ID, RecipeIngredientTableMap::COL_INGREDIENT_ID, RecipeIngredientTableMap::COL_QUANTITY, RecipeIngredientTableMap::COL_CREATED_AT, RecipeIngredientTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'recipe_id', 'ingredient_id', 'quantity', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'RecipeId' => 1, 'IngredientId' => 2, 'Quantity' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'recipeId' => 1, 'ingredientId' => 2, 'quantity' => 3, 'createdAt' => 4, 'updatedAt' => 5, ),
        self::TYPE_COLNAME       => array(RecipeIngredientTableMap::COL_ID => 0, RecipeIngredientTableMap::COL_RECIPE_ID => 1, RecipeIngredientTableMap::COL_INGREDIENT_ID => 2, RecipeIngredientTableMap::COL_QUANTITY => 3, RecipeIngredientTableMap::COL_CREATED_AT => 4, RecipeIngredientTableMap::COL_UPDATED_AT => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'recipe_id' => 1, 'ingredient_id' => 2, 'quantity' => 3, 'created_at' => 4, 'updated_at' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('recipe_ingredient');
        $this->setPhpName('RecipeIngredient');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Lib\\RecipeIngredient');
        $this->setPackage('Lib');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('recipe_id', 'RecipeId', 'INTEGER', 'recipe', 'id', true, null, null);
        $this->addForeignKey('ingredient_id', 'IngredientId', 'INTEGER', 'ingredient', 'id', true, null, null);
        $this->addColumn('quantity', 'Quantity', 'FLOAT', true, 10, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Recipe', '\\Lib\\Recipe', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':recipe_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Ingredient', '\\Lib\\Ingredient', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':ingredient_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
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
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
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
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? RecipeIngredientTableMap::CLASS_DEFAULT : RecipeIngredientTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (RecipeIngredient object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RecipeIngredientTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RecipeIngredientTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RecipeIngredientTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RecipeIngredientTableMap::OM_CLASS;
            /** @var RecipeIngredient $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RecipeIngredientTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = RecipeIngredientTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RecipeIngredientTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var RecipeIngredient $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RecipeIngredientTableMap::addInstanceToPool($obj, $key);
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
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(RecipeIngredientTableMap::COL_ID);
            $criteria->addSelectColumn(RecipeIngredientTableMap::COL_RECIPE_ID);
            $criteria->addSelectColumn(RecipeIngredientTableMap::COL_INGREDIENT_ID);
            $criteria->addSelectColumn(RecipeIngredientTableMap::COL_QUANTITY);
            $criteria->addSelectColumn(RecipeIngredientTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(RecipeIngredientTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.recipe_id');
            $criteria->addSelectColumn($alias . '.ingredient_id');
            $criteria->addSelectColumn($alias . '.quantity');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(RecipeIngredientTableMap::DATABASE_NAME)->getTable(RecipeIngredientTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RecipeIngredientTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RecipeIngredientTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RecipeIngredientTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a RecipeIngredient or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or RecipeIngredient object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecipeIngredientTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Lib\RecipeIngredient) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RecipeIngredientTableMap::DATABASE_NAME);
            $criteria->add(RecipeIngredientTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = RecipeIngredientQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RecipeIngredientTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RecipeIngredientTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the recipe_ingredient table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RecipeIngredientQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a RecipeIngredient or Criteria object.
     *
     * @param mixed               $criteria Criteria or RecipeIngredient object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecipeIngredientTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from RecipeIngredient object
        }

        if ($criteria->containsKey(RecipeIngredientTableMap::COL_ID) && $criteria->keyContainsValue(RecipeIngredientTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RecipeIngredientTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = RecipeIngredientQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RecipeIngredientTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RecipeIngredientTableMap::buildTableMap();
