<?php

namespace Lib\Base;

use \Exception;
use \PDO;
use Lib\ShoppingList as ChildShoppingList;
use Lib\ShoppingListQuery as ChildShoppingListQuery;
use Lib\Map\ShoppingListTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shopping_list' table.
 *
 *
 *
 * @method     ChildShoppingListQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildShoppingListQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildShoppingListQuery orderByRemoved($order = Criteria::ASC) Order by the removed column
 * @method     ChildShoppingListQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildShoppingListQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildShoppingListQuery groupById() Group by the id column
 * @method     ChildShoppingListQuery groupByName() Group by the name column
 * @method     ChildShoppingListQuery groupByRemoved() Group by the removed column
 * @method     ChildShoppingListQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildShoppingListQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildShoppingListQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShoppingListQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShoppingListQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShoppingListQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildShoppingListQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildShoppingListQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildShoppingListQuery leftJoinListRecipe($relationAlias = null) Adds a LEFT JOIN clause to the query using the ListRecipe relation
 * @method     ChildShoppingListQuery rightJoinListRecipe($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ListRecipe relation
 * @method     ChildShoppingListQuery innerJoinListRecipe($relationAlias = null) Adds a INNER JOIN clause to the query using the ListRecipe relation
 *
 * @method     ChildShoppingListQuery joinWithListRecipe($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ListRecipe relation
 *
 * @method     ChildShoppingListQuery leftJoinWithListRecipe() Adds a LEFT JOIN clause and with to the query using the ListRecipe relation
 * @method     ChildShoppingListQuery rightJoinWithListRecipe() Adds a RIGHT JOIN clause and with to the query using the ListRecipe relation
 * @method     ChildShoppingListQuery innerJoinWithListRecipe() Adds a INNER JOIN clause and with to the query using the ListRecipe relation
 *
 * @method     \Lib\ListRecipeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildShoppingList findOne(ConnectionInterface $con = null) Return the first ChildShoppingList matching the query
 * @method     ChildShoppingList findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShoppingList matching the query, or a new ChildShoppingList object populated from the query conditions when no match is found
 *
 * @method     ChildShoppingList findOneById(int $id) Return the first ChildShoppingList filtered by the id column
 * @method     ChildShoppingList findOneByName(string $name) Return the first ChildShoppingList filtered by the name column
 * @method     ChildShoppingList findOneByRemoved(boolean $removed) Return the first ChildShoppingList filtered by the removed column
 * @method     ChildShoppingList findOneByCreatedAt(string $created_at) Return the first ChildShoppingList filtered by the created_at column
 * @method     ChildShoppingList findOneByUpdatedAt(string $updated_at) Return the first ChildShoppingList filtered by the updated_at column *

 * @method     ChildShoppingList requirePk($key, ConnectionInterface $con = null) Return the ChildShoppingList by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingList requireOne(ConnectionInterface $con = null) Return the first ChildShoppingList matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShoppingList requireOneById(int $id) Return the first ChildShoppingList filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingList requireOneByName(string $name) Return the first ChildShoppingList filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingList requireOneByRemoved(boolean $removed) Return the first ChildShoppingList filtered by the removed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingList requireOneByCreatedAt(string $created_at) Return the first ChildShoppingList filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingList requireOneByUpdatedAt(string $updated_at) Return the first ChildShoppingList filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShoppingList[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShoppingList objects based on current ModelCriteria
 * @method     ChildShoppingList[]|ObjectCollection findById(int $id) Return ChildShoppingList objects filtered by the id column
 * @method     ChildShoppingList[]|ObjectCollection findByName(string $name) Return ChildShoppingList objects filtered by the name column
 * @method     ChildShoppingList[]|ObjectCollection findByRemoved(boolean $removed) Return ChildShoppingList objects filtered by the removed column
 * @method     ChildShoppingList[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildShoppingList objects filtered by the created_at column
 * @method     ChildShoppingList[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildShoppingList objects filtered by the updated_at column
 * @method     ChildShoppingList[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShoppingListQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Lib\Base\ShoppingListQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Lib\\ShoppingList', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShoppingListQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShoppingListQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShoppingListQuery) {
            return $criteria;
        }
        $query = new ChildShoppingListQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildShoppingList|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShoppingListTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ShoppingListTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShoppingList A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, removed, created_at, updated_at FROM shopping_list WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildShoppingList $obj */
            $obj = new ChildShoppingList();
            $obj->hydrate($row);
            ShoppingListTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildShoppingList|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ShoppingListTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ShoppingListTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ShoppingListTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ShoppingListTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the removed column
     *
     * Example usage:
     * <code>
     * $query->filterByRemoved(true); // WHERE removed = true
     * $query->filterByRemoved('yes'); // WHERE removed = true
     * </code>
     *
     * @param     boolean|string $removed The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function filterByRemoved($removed = null, $comparison = null)
    {
        if (is_string($removed)) {
            $removed = in_array(strtolower($removed), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ShoppingListTableMap::COL_REMOVED, $removed, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ShoppingListTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ShoppingListTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ShoppingListTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ShoppingListTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Lib\ListRecipe object
     *
     * @param \Lib\ListRecipe|ObjectCollection $listRecipe the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShoppingListQuery The current query, for fluid interface
     */
    public function filterByListRecipe($listRecipe, $comparison = null)
    {
        if ($listRecipe instanceof \Lib\ListRecipe) {
            return $this
                ->addUsingAlias(ShoppingListTableMap::COL_ID, $listRecipe->getShoppingListId(), $comparison);
        } elseif ($listRecipe instanceof ObjectCollection) {
            return $this
                ->useListRecipeQuery()
                ->filterByPrimaryKeys($listRecipe->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByListRecipe() only accepts arguments of type \Lib\ListRecipe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ListRecipe relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function joinListRecipe($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ListRecipe');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ListRecipe');
        }

        return $this;
    }

    /**
     * Use the ListRecipe relation ListRecipe object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\ListRecipeQuery A secondary query class using the current class as primary query
     */
    public function useListRecipeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinListRecipe($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ListRecipe', '\Lib\ListRecipeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShoppingList $shoppingList Object to remove from the list of results
     *
     * @return $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function prune($shoppingList = null)
    {
        if ($shoppingList) {
            $this->addUsingAlias(ShoppingListTableMap::COL_ID, $shoppingList->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shopping_list table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShoppingListTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShoppingListTableMap::clearInstancePool();
            ShoppingListTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShoppingListTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShoppingListTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShoppingListTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShoppingListTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ShoppingListTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ShoppingListTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ShoppingListTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ShoppingListTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ShoppingListTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildShoppingListQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ShoppingListTableMap::COL_CREATED_AT);
    }

} // ShoppingListQuery
