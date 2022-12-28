<?php

namespace Lib\Map;

use Lib\Recipe;
use Lib\RecipeQuery;
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
 * This class defines the structure of the 'recipe' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class RecipeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Lib.Map.RecipeTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'recipe';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Recipe';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Lib\\Recipe';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Lib.Recipe';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'recipe.id';

    /**
     * the column name for the name field
     */
    public const COL_NAME = 'recipe.name';

    /**
     * the column name for the calories field
     */
    public const COL_CALORIES = 'recipe.calories';

    /**
     * the column name for the instructions field
     */
    public const COL_INSTRUCTIONS = 'recipe.instructions';

    /**
     * the column name for the removed field
     */
    public const COL_REMOVED = 'recipe.removed';

    /**
     * the column name for the created_at field
     */
    public const COL_CREATED_AT = 'recipe.created_at';

    /**
     * the column name for the updated_at field
     */
    public const COL_UPDATED_AT = 'recipe.updated_at';

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
        self::TYPE_PHPNAME       => ['Id', 'Name', 'Calories', 'Instructions', 'Removed', 'CreatedAt', 'UpdatedAt', ],
        self::TYPE_CAMELNAME     => ['id', 'name', 'calories', 'instructions', 'removed', 'createdAt', 'updatedAt', ],
        self::TYPE_COLNAME       => [RecipeTableMap::COL_ID, RecipeTableMap::COL_NAME, RecipeTableMap::COL_CALORIES, RecipeTableMap::COL_INSTRUCTIONS, RecipeTableMap::COL_REMOVED, RecipeTableMap::COL_CREATED_AT, RecipeTableMap::COL_UPDATED_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'name', 'calories', 'instructions', 'removed', 'created_at', 'updated_at', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Name' => 1, 'Calories' => 2, 'Instructions' => 3, 'Removed' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'name' => 1, 'calories' => 2, 'instructions' => 3, 'removed' => 4, 'createdAt' => 5, 'updatedAt' => 6, ],
        self::TYPE_COLNAME       => [RecipeTableMap::COL_ID => 0, RecipeTableMap::COL_NAME => 1, RecipeTableMap::COL_CALORIES => 2, RecipeTableMap::COL_INSTRUCTIONS => 3, RecipeTableMap::COL_REMOVED => 4, RecipeTableMap::COL_CREATED_AT => 5, RecipeTableMap::COL_UPDATED_AT => 6, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'name' => 1, 'calories' => 2, 'instructions' => 3, 'removed' => 4, 'created_at' => 5, 'updated_at' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Recipe.Id' => 'ID',
        'id' => 'ID',
        'recipe.id' => 'ID',
        'RecipeTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Name' => 'NAME',
        'Recipe.Name' => 'NAME',
        'name' => 'NAME',
        'recipe.name' => 'NAME',
        'RecipeTableMap::COL_NAME' => 'NAME',
        'COL_NAME' => 'NAME',
        'Calories' => 'CALORIES',
        'Recipe.Calories' => 'CALORIES',
        'calories' => 'CALORIES',
        'recipe.calories' => 'CALORIES',
        'RecipeTableMap::COL_CALORIES' => 'CALORIES',
        'COL_CALORIES' => 'CALORIES',
        'Instructions' => 'INSTRUCTIONS',
        'Recipe.Instructions' => 'INSTRUCTIONS',
        'instructions' => 'INSTRUCTIONS',
        'recipe.instructions' => 'INSTRUCTIONS',
        'RecipeTableMap::COL_INSTRUCTIONS' => 'INSTRUCTIONS',
        'COL_INSTRUCTIONS' => 'INSTRUCTIONS',
        'Removed' => 'REMOVED',
        'Recipe.Removed' => 'REMOVED',
        'removed' => 'REMOVED',
        'recipe.removed' => 'REMOVED',
        'RecipeTableMap::COL_REMOVED' => 'REMOVED',
        'COL_REMOVED' => 'REMOVED',
        'CreatedAt' => 'CREATED_AT',
        'Recipe.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'recipe.createdAt' => 'CREATED_AT',
        'RecipeTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'recipe.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'Recipe.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'recipe.updatedAt' => 'UPDATED_AT',
        'RecipeTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'recipe.updated_at' => 'UPDATED_AT',
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
        $this->setName('recipe');
        $this->setPhpName('Recipe');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Lib\\Recipe');
        $this->setPackage('Lib');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 150, null);
        $this->addColumn('calories', 'Calories', 'INTEGER', false, null, null);
        $this->addColumn('instructions', 'Instructions', 'LONGVARCHAR', false, null, null);
        $this->addColumn('removed', 'Removed', 'BOOLEAN', false, 1, false);
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
        $this->addRelation('ListRecipe', '\\Lib\\ListRecipe', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':recipe_id',
    1 => ':id',
  ),
), null, null, 'ListRecipes', false);
        $this->addRelation('RecipeItem', '\\Lib\\RecipeItem', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':recipe_id',
    1 => ':id',
  ),
), null, null, 'RecipeItems', false);
        $this->addRelation('DayPlanRecipe', '\\Lib\\DayPlanRecipe', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':recipe_id',
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
        return $withPrefix ? RecipeTableMap::CLASS_DEFAULT : RecipeTableMap::OM_CLASS;
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
     * @return array (Recipe object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = RecipeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RecipeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RecipeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RecipeTableMap::OM_CLASS;
            /** @var Recipe $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RecipeTableMap::addInstanceToPool($obj, $key);
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
            $key = RecipeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RecipeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Recipe $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RecipeTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(RecipeTableMap::COL_ID);
            $criteria->addSelectColumn(RecipeTableMap::COL_NAME);
            $criteria->addSelectColumn(RecipeTableMap::COL_CALORIES);
            $criteria->addSelectColumn(RecipeTableMap::COL_INSTRUCTIONS);
            $criteria->addSelectColumn(RecipeTableMap::COL_REMOVED);
            $criteria->addSelectColumn(RecipeTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(RecipeTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.calories');
            $criteria->addSelectColumn($alias . '.instructions');
            $criteria->addSelectColumn($alias . '.removed');
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
            $criteria->removeSelectColumn(RecipeTableMap::COL_ID);
            $criteria->removeSelectColumn(RecipeTableMap::COL_NAME);
            $criteria->removeSelectColumn(RecipeTableMap::COL_CALORIES);
            $criteria->removeSelectColumn(RecipeTableMap::COL_INSTRUCTIONS);
            $criteria->removeSelectColumn(RecipeTableMap::COL_REMOVED);
            $criteria->removeSelectColumn(RecipeTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(RecipeTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.name');
            $criteria->removeSelectColumn($alias . '.calories');
            $criteria->removeSelectColumn($alias . '.instructions');
            $criteria->removeSelectColumn($alias . '.removed');
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
        return Propel::getServiceContainer()->getDatabaseMap(RecipeTableMap::DATABASE_NAME)->getTable(RecipeTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Recipe or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Recipe object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(RecipeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Lib\Recipe) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RecipeTableMap::DATABASE_NAME);
            $criteria->add(RecipeTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = RecipeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RecipeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RecipeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the recipe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return RecipeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Recipe or Criteria object.
     *
     * @param mixed $criteria Criteria or Recipe object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecipeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Recipe object
        }

        if ($criteria->containsKey(RecipeTableMap::COL_ID) && $criteria->keyContainsValue(RecipeTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RecipeTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = RecipeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
