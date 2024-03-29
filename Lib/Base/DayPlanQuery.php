<?php

namespace Lib\Base;

use \Exception;
use \PDO;
use Lib\DayPlan as ChildDayPlan;
use Lib\DayPlanQuery as ChildDayPlanQuery;
use Lib\Map\DayPlanTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `day_plan` table.
 *
 * @method     ChildDayPlanQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDayPlanQuery orderByShoppingListId($order = Criteria::ASC) Order by the shopping_list_id column
 * @method     ChildDayPlanQuery orderByComplete($order = Criteria::ASC) Order by the complete column
 * @method     ChildDayPlanQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildDayPlanQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildDayPlanQuery groupById() Group by the id column
 * @method     ChildDayPlanQuery groupByShoppingListId() Group by the shopping_list_id column
 * @method     ChildDayPlanQuery groupByComplete() Group by the complete column
 * @method     ChildDayPlanQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildDayPlanQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildDayPlanQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDayPlanQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDayPlanQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDayPlanQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDayPlanQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDayPlanQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDayPlanQuery leftJoinShoppingList($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShoppingList relation
 * @method     ChildDayPlanQuery rightJoinShoppingList($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShoppingList relation
 * @method     ChildDayPlanQuery innerJoinShoppingList($relationAlias = null) Adds a INNER JOIN clause to the query using the ShoppingList relation
 *
 * @method     ChildDayPlanQuery joinWithShoppingList($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ShoppingList relation
 *
 * @method     ChildDayPlanQuery leftJoinWithShoppingList() Adds a LEFT JOIN clause and with to the query using the ShoppingList relation
 * @method     ChildDayPlanQuery rightJoinWithShoppingList() Adds a RIGHT JOIN clause and with to the query using the ShoppingList relation
 * @method     ChildDayPlanQuery innerJoinWithShoppingList() Adds a INNER JOIN clause and with to the query using the ShoppingList relation
 *
 * @method     ChildDayPlanQuery leftJoinDayPlanRecipe($relationAlias = null) Adds a LEFT JOIN clause to the query using the DayPlanRecipe relation
 * @method     ChildDayPlanQuery rightJoinDayPlanRecipe($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DayPlanRecipe relation
 * @method     ChildDayPlanQuery innerJoinDayPlanRecipe($relationAlias = null) Adds a INNER JOIN clause to the query using the DayPlanRecipe relation
 *
 * @method     ChildDayPlanQuery joinWithDayPlanRecipe($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DayPlanRecipe relation
 *
 * @method     ChildDayPlanQuery leftJoinWithDayPlanRecipe() Adds a LEFT JOIN clause and with to the query using the DayPlanRecipe relation
 * @method     ChildDayPlanQuery rightJoinWithDayPlanRecipe() Adds a RIGHT JOIN clause and with to the query using the DayPlanRecipe relation
 * @method     ChildDayPlanQuery innerJoinWithDayPlanRecipe() Adds a INNER JOIN clause and with to the query using the DayPlanRecipe relation
 *
 * @method     \Lib\ShoppingListQuery|\Lib\DayPlanRecipeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDayPlan|null findOne(?ConnectionInterface $con = null) Return the first ChildDayPlan matching the query
 * @method     ChildDayPlan findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildDayPlan matching the query, or a new ChildDayPlan object populated from the query conditions when no match is found
 *
 * @method     ChildDayPlan|null findOneById(int $id) Return the first ChildDayPlan filtered by the id column
 * @method     ChildDayPlan|null findOneByShoppingListId(int $shopping_list_id) Return the first ChildDayPlan filtered by the shopping_list_id column
 * @method     ChildDayPlan|null findOneByComplete(boolean $complete) Return the first ChildDayPlan filtered by the complete column
 * @method     ChildDayPlan|null findOneByCreatedAt(string $created_at) Return the first ChildDayPlan filtered by the created_at column
 * @method     ChildDayPlan|null findOneByUpdatedAt(string $updated_at) Return the first ChildDayPlan filtered by the updated_at column
 *
 * @method     ChildDayPlan requirePk($key, ?ConnectionInterface $con = null) Return the ChildDayPlan by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlan requireOne(?ConnectionInterface $con = null) Return the first ChildDayPlan matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDayPlan requireOneById(int $id) Return the first ChildDayPlan filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlan requireOneByShoppingListId(int $shopping_list_id) Return the first ChildDayPlan filtered by the shopping_list_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlan requireOneByComplete(boolean $complete) Return the first ChildDayPlan filtered by the complete column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlan requireOneByCreatedAt(string $created_at) Return the first ChildDayPlan filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlan requireOneByUpdatedAt(string $updated_at) Return the first ChildDayPlan filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDayPlan[]|Collection find(?ConnectionInterface $con = null) Return ChildDayPlan objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildDayPlan> find(?ConnectionInterface $con = null) Return ChildDayPlan objects based on current ModelCriteria
 *
 * @method     ChildDayPlan[]|Collection findById(int|array<int> $id) Return ChildDayPlan objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildDayPlan> findById(int|array<int> $id) Return ChildDayPlan objects filtered by the id column
 * @method     ChildDayPlan[]|Collection findByShoppingListId(int|array<int> $shopping_list_id) Return ChildDayPlan objects filtered by the shopping_list_id column
 * @psalm-method Collection&\Traversable<ChildDayPlan> findByShoppingListId(int|array<int> $shopping_list_id) Return ChildDayPlan objects filtered by the shopping_list_id column
 * @method     ChildDayPlan[]|Collection findByComplete(boolean|array<boolean> $complete) Return ChildDayPlan objects filtered by the complete column
 * @psalm-method Collection&\Traversable<ChildDayPlan> findByComplete(boolean|array<boolean> $complete) Return ChildDayPlan objects filtered by the complete column
 * @method     ChildDayPlan[]|Collection findByCreatedAt(string|array<string> $created_at) Return ChildDayPlan objects filtered by the created_at column
 * @psalm-method Collection&\Traversable<ChildDayPlan> findByCreatedAt(string|array<string> $created_at) Return ChildDayPlan objects filtered by the created_at column
 * @method     ChildDayPlan[]|Collection findByUpdatedAt(string|array<string> $updated_at) Return ChildDayPlan objects filtered by the updated_at column
 * @psalm-method Collection&\Traversable<ChildDayPlan> findByUpdatedAt(string|array<string> $updated_at) Return ChildDayPlan objects filtered by the updated_at column
 *
 * @method     ChildDayPlan[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildDayPlan> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class DayPlanQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Lib\Base\DayPlanQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Lib\\DayPlan', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDayPlanQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDayPlanQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildDayPlanQuery) {
            return $criteria;
        }
        $query = new ChildDayPlanQuery();
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
     * @return ChildDayPlan|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DayPlanTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DayPlanTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDayPlan A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, shopping_list_id, complete, created_at, updated_at FROM day_plan WHERE id = :p0';
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
            /** @var ChildDayPlan $obj */
            $obj = new ChildDayPlan();
            $obj->hydrate($row);
            DayPlanTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildDayPlan|array|mixed the result, formatted by the current formatter
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
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(DayPlanTableMap::COL_ID, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(DayPlanTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
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
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DayPlanTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DayPlanTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the shopping_list_id column
     *
     * Example usage:
     * <code>
     * $query->filterByShoppingListId(1234); // WHERE shopping_list_id = 1234
     * $query->filterByShoppingListId(array(12, 34)); // WHERE shopping_list_id IN (12, 34)
     * $query->filterByShoppingListId(array('min' => 12)); // WHERE shopping_list_id > 12
     * </code>
     *
     * @see       filterByShoppingList()
     *
     * @param mixed $shoppingListId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByShoppingListId($shoppingListId = null, ?string $comparison = null)
    {
        if (is_array($shoppingListId)) {
            $useMinMax = false;
            if (isset($shoppingListId['min'])) {
                $this->addUsingAlias(DayPlanTableMap::COL_SHOPPING_LIST_ID, $shoppingListId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shoppingListId['max'])) {
                $this->addUsingAlias(DayPlanTableMap::COL_SHOPPING_LIST_ID, $shoppingListId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanTableMap::COL_SHOPPING_LIST_ID, $shoppingListId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the complete column
     *
     * Example usage:
     * <code>
     * $query->filterByComplete(true); // WHERE complete = true
     * $query->filterByComplete('yes'); // WHERE complete = true
     * </code>
     *
     * @param bool|string $complete The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByComplete($complete = null, ?string $comparison = null)
    {
        if (is_string($complete)) {
            $complete = in_array(strtolower($complete), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        $this->addUsingAlias(DayPlanTableMap::COL_COMPLETE, $complete, $comparison);

        return $this;
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
     * @param mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, ?string $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(DayPlanTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(DayPlanTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanTableMap::COL_CREATED_AT, $createdAt, $comparison);

        return $this;
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
     * @param mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, ?string $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(DayPlanTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(DayPlanTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanTableMap::COL_UPDATED_AT, $updatedAt, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Lib\ShoppingList object
     *
     * @param \Lib\ShoppingList|ObjectCollection $shoppingList The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByShoppingList($shoppingList, ?string $comparison = null)
    {
        if ($shoppingList instanceof \Lib\ShoppingList) {
            return $this
                ->addUsingAlias(DayPlanTableMap::COL_SHOPPING_LIST_ID, $shoppingList->getId(), $comparison);
        } elseif ($shoppingList instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(DayPlanTableMap::COL_SHOPPING_LIST_ID, $shoppingList->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByShoppingList() only accepts arguments of type \Lib\ShoppingList or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShoppingList relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinShoppingList(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShoppingList');

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
            $this->addJoinObject($join, 'ShoppingList');
        }

        return $this;
    }

    /**
     * Use the ShoppingList relation ShoppingList object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\ShoppingListQuery A secondary query class using the current class as primary query
     */
    public function useShoppingListQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShoppingList($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShoppingList', '\Lib\ShoppingListQuery');
    }

    /**
     * Use the ShoppingList relation ShoppingList object
     *
     * @param callable(\Lib\ShoppingListQuery):\Lib\ShoppingListQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withShoppingListQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useShoppingListQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to ShoppingList table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Lib\ShoppingListQuery The inner query object of the EXISTS statement
     */
    public function useShoppingListExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Lib\ShoppingListQuery */
        $q = $this->useExistsQuery('ShoppingList', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to ShoppingList table for a NOT EXISTS query.
     *
     * @see useShoppingListExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Lib\ShoppingListQuery The inner query object of the NOT EXISTS statement
     */
    public function useShoppingListNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\ShoppingListQuery */
        $q = $this->useExistsQuery('ShoppingList', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to ShoppingList table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Lib\ShoppingListQuery The inner query object of the IN statement
     */
    public function useInShoppingListQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Lib\ShoppingListQuery */
        $q = $this->useInQuery('ShoppingList', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to ShoppingList table for a NOT IN query.
     *
     * @see useShoppingListInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Lib\ShoppingListQuery The inner query object of the NOT IN statement
     */
    public function useNotInShoppingListQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\ShoppingListQuery */
        $q = $this->useInQuery('ShoppingList', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Lib\DayPlanRecipe object
     *
     * @param \Lib\DayPlanRecipe|ObjectCollection $dayPlanRecipe the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDayPlanRecipe($dayPlanRecipe, ?string $comparison = null)
    {
        if ($dayPlanRecipe instanceof \Lib\DayPlanRecipe) {
            $this
                ->addUsingAlias(DayPlanTableMap::COL_ID, $dayPlanRecipe->getDayPlanId(), $comparison);

            return $this;
        } elseif ($dayPlanRecipe instanceof ObjectCollection) {
            $this
                ->useDayPlanRecipeQuery()
                ->filterByPrimaryKeys($dayPlanRecipe->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByDayPlanRecipe() only accepts arguments of type \Lib\DayPlanRecipe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DayPlanRecipe relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinDayPlanRecipe(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DayPlanRecipe');

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
            $this->addJoinObject($join, 'DayPlanRecipe');
        }

        return $this;
    }

    /**
     * Use the DayPlanRecipe relation DayPlanRecipe object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\DayPlanRecipeQuery A secondary query class using the current class as primary query
     */
    public function useDayPlanRecipeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDayPlanRecipe($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DayPlanRecipe', '\Lib\DayPlanRecipeQuery');
    }

    /**
     * Use the DayPlanRecipe relation DayPlanRecipe object
     *
     * @param callable(\Lib\DayPlanRecipeQuery):\Lib\DayPlanRecipeQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withDayPlanRecipeQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useDayPlanRecipeQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to DayPlanRecipe table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Lib\DayPlanRecipeQuery The inner query object of the EXISTS statement
     */
    public function useDayPlanRecipeExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Lib\DayPlanRecipeQuery */
        $q = $this->useExistsQuery('DayPlanRecipe', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to DayPlanRecipe table for a NOT EXISTS query.
     *
     * @see useDayPlanRecipeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Lib\DayPlanRecipeQuery The inner query object of the NOT EXISTS statement
     */
    public function useDayPlanRecipeNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\DayPlanRecipeQuery */
        $q = $this->useExistsQuery('DayPlanRecipe', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to DayPlanRecipe table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Lib\DayPlanRecipeQuery The inner query object of the IN statement
     */
    public function useInDayPlanRecipeQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Lib\DayPlanRecipeQuery */
        $q = $this->useInQuery('DayPlanRecipe', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to DayPlanRecipe table for a NOT IN query.
     *
     * @see useDayPlanRecipeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Lib\DayPlanRecipeQuery The inner query object of the NOT IN statement
     */
    public function useNotInDayPlanRecipeQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\DayPlanRecipeQuery */
        $q = $this->useInQuery('DayPlanRecipe', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildDayPlan $dayPlan Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($dayPlan = null)
    {
        if ($dayPlan) {
            $this->addUsingAlias(DayPlanTableMap::COL_ID, $dayPlan->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the day_plan table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DayPlanTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DayPlanTableMap::clearInstancePool();
            DayPlanTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DayPlanTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DayPlanTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DayPlanTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DayPlanTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param int $nbDays Maximum age of the latest update in days
     *
     * @return $this The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        $this->addUsingAlias(DayPlanTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by update date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        $this->addDescendingOrderByColumn(DayPlanTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by update date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        $this->addAscendingOrderByColumn(DayPlanTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by create date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        $this->addDescendingOrderByColumn(DayPlanTableMap::COL_CREATED_AT);

        return $this;
    }

    /**
     * Filter by the latest created
     *
     * @param int $nbDays Maximum age of in days
     *
     * @return $this The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        $this->addUsingAlias(DayPlanTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by create date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        $this->addAscendingOrderByColumn(DayPlanTableMap::COL_CREATED_AT);

        return $this;
    }

}
