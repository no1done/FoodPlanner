<?php

namespace Lib\Base;

use \Exception;
use \PDO;
use Lib\DayPlanRecipe as ChildDayPlanRecipe;
use Lib\DayPlanRecipeQuery as ChildDayPlanRecipeQuery;
use Lib\Map\DayPlanRecipeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `day_plan_recipe` table.
 *
 * @method     ChildDayPlanRecipeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDayPlanRecipeQuery orderByDayPlanId($order = Criteria::ASC) Order by the day_plan_id column
 * @method     ChildDayPlanRecipeQuery orderByRecipeId($order = Criteria::ASC) Order by the recipe_id column
 * @method     ChildDayPlanRecipeQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildDayPlanRecipeQuery orderByServers($order = Criteria::ASC) Order by the servers column
 * @method     ChildDayPlanRecipeQuery orderByComplete($order = Criteria::ASC) Order by the complete column
 * @method     ChildDayPlanRecipeQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildDayPlanRecipeQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildDayPlanRecipeQuery groupById() Group by the id column
 * @method     ChildDayPlanRecipeQuery groupByDayPlanId() Group by the day_plan_id column
 * @method     ChildDayPlanRecipeQuery groupByRecipeId() Group by the recipe_id column
 * @method     ChildDayPlanRecipeQuery groupByCategoryId() Group by the category_id column
 * @method     ChildDayPlanRecipeQuery groupByServers() Group by the servers column
 * @method     ChildDayPlanRecipeQuery groupByComplete() Group by the complete column
 * @method     ChildDayPlanRecipeQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildDayPlanRecipeQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildDayPlanRecipeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDayPlanRecipeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDayPlanRecipeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDayPlanRecipeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDayPlanRecipeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDayPlanRecipeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDayPlanRecipeQuery leftJoinDayPlan($relationAlias = null) Adds a LEFT JOIN clause to the query using the DayPlan relation
 * @method     ChildDayPlanRecipeQuery rightJoinDayPlan($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DayPlan relation
 * @method     ChildDayPlanRecipeQuery innerJoinDayPlan($relationAlias = null) Adds a INNER JOIN clause to the query using the DayPlan relation
 *
 * @method     ChildDayPlanRecipeQuery joinWithDayPlan($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DayPlan relation
 *
 * @method     ChildDayPlanRecipeQuery leftJoinWithDayPlan() Adds a LEFT JOIN clause and with to the query using the DayPlan relation
 * @method     ChildDayPlanRecipeQuery rightJoinWithDayPlan() Adds a RIGHT JOIN clause and with to the query using the DayPlan relation
 * @method     ChildDayPlanRecipeQuery innerJoinWithDayPlan() Adds a INNER JOIN clause and with to the query using the DayPlan relation
 *
 * @method     ChildDayPlanRecipeQuery leftJoinRecipe($relationAlias = null) Adds a LEFT JOIN clause to the query using the Recipe relation
 * @method     ChildDayPlanRecipeQuery rightJoinRecipe($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Recipe relation
 * @method     ChildDayPlanRecipeQuery innerJoinRecipe($relationAlias = null) Adds a INNER JOIN clause to the query using the Recipe relation
 *
 * @method     ChildDayPlanRecipeQuery joinWithRecipe($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Recipe relation
 *
 * @method     ChildDayPlanRecipeQuery leftJoinWithRecipe() Adds a LEFT JOIN clause and with to the query using the Recipe relation
 * @method     ChildDayPlanRecipeQuery rightJoinWithRecipe() Adds a RIGHT JOIN clause and with to the query using the Recipe relation
 * @method     ChildDayPlanRecipeQuery innerJoinWithRecipe() Adds a INNER JOIN clause and with to the query using the Recipe relation
 *
 * @method     ChildDayPlanRecipeQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method     ChildDayPlanRecipeQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method     ChildDayPlanRecipeQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method     ChildDayPlanRecipeQuery joinWithCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Category relation
 *
 * @method     ChildDayPlanRecipeQuery leftJoinWithCategory() Adds a LEFT JOIN clause and with to the query using the Category relation
 * @method     ChildDayPlanRecipeQuery rightJoinWithCategory() Adds a RIGHT JOIN clause and with to the query using the Category relation
 * @method     ChildDayPlanRecipeQuery innerJoinWithCategory() Adds a INNER JOIN clause and with to the query using the Category relation
 *
 * @method     \Lib\DayPlanQuery|\Lib\RecipeQuery|\Lib\CategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDayPlanRecipe|null findOne(?ConnectionInterface $con = null) Return the first ChildDayPlanRecipe matching the query
 * @method     ChildDayPlanRecipe findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildDayPlanRecipe matching the query, or a new ChildDayPlanRecipe object populated from the query conditions when no match is found
 *
 * @method     ChildDayPlanRecipe|null findOneById(int $id) Return the first ChildDayPlanRecipe filtered by the id column
 * @method     ChildDayPlanRecipe|null findOneByDayPlanId(int $day_plan_id) Return the first ChildDayPlanRecipe filtered by the day_plan_id column
 * @method     ChildDayPlanRecipe|null findOneByRecipeId(int $recipe_id) Return the first ChildDayPlanRecipe filtered by the recipe_id column
 * @method     ChildDayPlanRecipe|null findOneByCategoryId(int $category_id) Return the first ChildDayPlanRecipe filtered by the category_id column
 * @method     ChildDayPlanRecipe|null findOneByServers(int $servers) Return the first ChildDayPlanRecipe filtered by the servers column
 * @method     ChildDayPlanRecipe|null findOneByComplete(boolean $complete) Return the first ChildDayPlanRecipe filtered by the complete column
 * @method     ChildDayPlanRecipe|null findOneByCreatedAt(string $created_at) Return the first ChildDayPlanRecipe filtered by the created_at column
 * @method     ChildDayPlanRecipe|null findOneByUpdatedAt(string $updated_at) Return the first ChildDayPlanRecipe filtered by the updated_at column
 *
 * @method     ChildDayPlanRecipe requirePk($key, ?ConnectionInterface $con = null) Return the ChildDayPlanRecipe by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlanRecipe requireOne(?ConnectionInterface $con = null) Return the first ChildDayPlanRecipe matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDayPlanRecipe requireOneById(int $id) Return the first ChildDayPlanRecipe filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlanRecipe requireOneByDayPlanId(int $day_plan_id) Return the first ChildDayPlanRecipe filtered by the day_plan_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlanRecipe requireOneByRecipeId(int $recipe_id) Return the first ChildDayPlanRecipe filtered by the recipe_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlanRecipe requireOneByCategoryId(int $category_id) Return the first ChildDayPlanRecipe filtered by the category_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlanRecipe requireOneByServers(int $servers) Return the first ChildDayPlanRecipe filtered by the servers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlanRecipe requireOneByComplete(boolean $complete) Return the first ChildDayPlanRecipe filtered by the complete column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlanRecipe requireOneByCreatedAt(string $created_at) Return the first ChildDayPlanRecipe filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDayPlanRecipe requireOneByUpdatedAt(string $updated_at) Return the first ChildDayPlanRecipe filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDayPlanRecipe[]|Collection find(?ConnectionInterface $con = null) Return ChildDayPlanRecipe objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> find(?ConnectionInterface $con = null) Return ChildDayPlanRecipe objects based on current ModelCriteria
 *
 * @method     ChildDayPlanRecipe[]|Collection findById(int|array<int> $id) Return ChildDayPlanRecipe objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> findById(int|array<int> $id) Return ChildDayPlanRecipe objects filtered by the id column
 * @method     ChildDayPlanRecipe[]|Collection findByDayPlanId(int|array<int> $day_plan_id) Return ChildDayPlanRecipe objects filtered by the day_plan_id column
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> findByDayPlanId(int|array<int> $day_plan_id) Return ChildDayPlanRecipe objects filtered by the day_plan_id column
 * @method     ChildDayPlanRecipe[]|Collection findByRecipeId(int|array<int> $recipe_id) Return ChildDayPlanRecipe objects filtered by the recipe_id column
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> findByRecipeId(int|array<int> $recipe_id) Return ChildDayPlanRecipe objects filtered by the recipe_id column
 * @method     ChildDayPlanRecipe[]|Collection findByCategoryId(int|array<int> $category_id) Return ChildDayPlanRecipe objects filtered by the category_id column
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> findByCategoryId(int|array<int> $category_id) Return ChildDayPlanRecipe objects filtered by the category_id column
 * @method     ChildDayPlanRecipe[]|Collection findByServers(int|array<int> $servers) Return ChildDayPlanRecipe objects filtered by the servers column
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> findByServers(int|array<int> $servers) Return ChildDayPlanRecipe objects filtered by the servers column
 * @method     ChildDayPlanRecipe[]|Collection findByComplete(boolean|array<boolean> $complete) Return ChildDayPlanRecipe objects filtered by the complete column
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> findByComplete(boolean|array<boolean> $complete) Return ChildDayPlanRecipe objects filtered by the complete column
 * @method     ChildDayPlanRecipe[]|Collection findByCreatedAt(string|array<string> $created_at) Return ChildDayPlanRecipe objects filtered by the created_at column
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> findByCreatedAt(string|array<string> $created_at) Return ChildDayPlanRecipe objects filtered by the created_at column
 * @method     ChildDayPlanRecipe[]|Collection findByUpdatedAt(string|array<string> $updated_at) Return ChildDayPlanRecipe objects filtered by the updated_at column
 * @psalm-method Collection&\Traversable<ChildDayPlanRecipe> findByUpdatedAt(string|array<string> $updated_at) Return ChildDayPlanRecipe objects filtered by the updated_at column
 *
 * @method     ChildDayPlanRecipe[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildDayPlanRecipe> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class DayPlanRecipeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Lib\Base\DayPlanRecipeQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Lib\\DayPlanRecipe', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDayPlanRecipeQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDayPlanRecipeQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildDayPlanRecipeQuery) {
            return $criteria;
        }
        $query = new ChildDayPlanRecipeQuery();
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
     * @return ChildDayPlanRecipe|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DayPlanRecipeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DayPlanRecipeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDayPlanRecipe A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, day_plan_id, recipe_id, category_id, servers, complete, created_at, updated_at FROM day_plan_recipe WHERE id = :p0';
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
            /** @var ChildDayPlanRecipe $obj */
            $obj = new ChildDayPlanRecipe();
            $obj->hydrate($row);
            DayPlanRecipeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDayPlanRecipe|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the day_plan_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDayPlanId(1234); // WHERE day_plan_id = 1234
     * $query->filterByDayPlanId(array(12, 34)); // WHERE day_plan_id IN (12, 34)
     * $query->filterByDayPlanId(array('min' => 12)); // WHERE day_plan_id > 12
     * </code>
     *
     * @see       filterByDayPlan()
     *
     * @param mixed $dayPlanId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDayPlanId($dayPlanId = null, ?string $comparison = null)
    {
        if (is_array($dayPlanId)) {
            $useMinMax = false;
            if (isset($dayPlanId['min'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_DAY_PLAN_ID, $dayPlanId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dayPlanId['max'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_DAY_PLAN_ID, $dayPlanId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_DAY_PLAN_ID, $dayPlanId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the recipe_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRecipeId(1234); // WHERE recipe_id = 1234
     * $query->filterByRecipeId(array(12, 34)); // WHERE recipe_id IN (12, 34)
     * $query->filterByRecipeId(array('min' => 12)); // WHERE recipe_id > 12
     * </code>
     *
     * @see       filterByRecipe()
     *
     * @param mixed $recipeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByRecipeId($recipeId = null, ?string $comparison = null)
    {
        if (is_array($recipeId)) {
            $useMinMax = false;
            if (isset($recipeId['min'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_RECIPE_ID, $recipeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recipeId['max'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_RECIPE_ID, $recipeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_RECIPE_ID, $recipeId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id > 12
     * </code>
     *
     * @see       filterByCategory()
     *
     * @param mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, ?string $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_CATEGORY_ID, $categoryId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the servers column
     *
     * Example usage:
     * <code>
     * $query->filterByServers(1234); // WHERE servers = 1234
     * $query->filterByServers(array(12, 34)); // WHERE servers IN (12, 34)
     * $query->filterByServers(array('min' => 12)); // WHERE servers > 12
     * </code>
     *
     * @param mixed $servers The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByServers($servers = null, ?string $comparison = null)
    {
        if (is_array($servers)) {
            $useMinMax = false;
            if (isset($servers['min'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_SERVERS, $servers['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($servers['max'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_SERVERS, $servers['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_SERVERS, $servers, $comparison);

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

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_COMPLETE, $complete, $comparison);

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
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_CREATED_AT, $createdAt, $comparison);

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
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(DayPlanRecipeTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DayPlanRecipeTableMap::COL_UPDATED_AT, $updatedAt, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Lib\DayPlan object
     *
     * @param \Lib\DayPlan|ObjectCollection $dayPlan The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDayPlan($dayPlan, ?string $comparison = null)
    {
        if ($dayPlan instanceof \Lib\DayPlan) {
            return $this
                ->addUsingAlias(DayPlanRecipeTableMap::COL_DAY_PLAN_ID, $dayPlan->getId(), $comparison);
        } elseif ($dayPlan instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(DayPlanRecipeTableMap::COL_DAY_PLAN_ID, $dayPlan->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByDayPlan() only accepts arguments of type \Lib\DayPlan or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DayPlan relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinDayPlan(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DayPlan');

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
            $this->addJoinObject($join, 'DayPlan');
        }

        return $this;
    }

    /**
     * Use the DayPlan relation DayPlan object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\DayPlanQuery A secondary query class using the current class as primary query
     */
    public function useDayPlanQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDayPlan($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DayPlan', '\Lib\DayPlanQuery');
    }

    /**
     * Use the DayPlan relation DayPlan object
     *
     * @param callable(\Lib\DayPlanQuery):\Lib\DayPlanQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withDayPlanQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useDayPlanQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to DayPlan table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Lib\DayPlanQuery The inner query object of the EXISTS statement
     */
    public function useDayPlanExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Lib\DayPlanQuery */
        $q = $this->useExistsQuery('DayPlan', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to DayPlan table for a NOT EXISTS query.
     *
     * @see useDayPlanExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Lib\DayPlanQuery The inner query object of the NOT EXISTS statement
     */
    public function useDayPlanNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\DayPlanQuery */
        $q = $this->useExistsQuery('DayPlan', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to DayPlan table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Lib\DayPlanQuery The inner query object of the IN statement
     */
    public function useInDayPlanQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Lib\DayPlanQuery */
        $q = $this->useInQuery('DayPlan', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to DayPlan table for a NOT IN query.
     *
     * @see useDayPlanInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Lib\DayPlanQuery The inner query object of the NOT IN statement
     */
    public function useNotInDayPlanQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\DayPlanQuery */
        $q = $this->useInQuery('DayPlan', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Lib\Recipe object
     *
     * @param \Lib\Recipe|ObjectCollection $recipe The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByRecipe($recipe, ?string $comparison = null)
    {
        if ($recipe instanceof \Lib\Recipe) {
            return $this
                ->addUsingAlias(DayPlanRecipeTableMap::COL_RECIPE_ID, $recipe->getId(), $comparison);
        } elseif ($recipe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(DayPlanRecipeTableMap::COL_RECIPE_ID, $recipe->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByRecipe() only accepts arguments of type \Lib\Recipe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Recipe relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinRecipe(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Recipe');

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
            $this->addJoinObject($join, 'Recipe');
        }

        return $this;
    }

    /**
     * Use the Recipe relation Recipe object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\RecipeQuery A secondary query class using the current class as primary query
     */
    public function useRecipeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRecipe($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Recipe', '\Lib\RecipeQuery');
    }

    /**
     * Use the Recipe relation Recipe object
     *
     * @param callable(\Lib\RecipeQuery):\Lib\RecipeQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withRecipeQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useRecipeQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Recipe table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Lib\RecipeQuery The inner query object of the EXISTS statement
     */
    public function useRecipeExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Lib\RecipeQuery */
        $q = $this->useExistsQuery('Recipe', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Recipe table for a NOT EXISTS query.
     *
     * @see useRecipeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Lib\RecipeQuery The inner query object of the NOT EXISTS statement
     */
    public function useRecipeNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\RecipeQuery */
        $q = $this->useExistsQuery('Recipe', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Recipe table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Lib\RecipeQuery The inner query object of the IN statement
     */
    public function useInRecipeQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Lib\RecipeQuery */
        $q = $this->useInQuery('Recipe', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Recipe table for a NOT IN query.
     *
     * @see useRecipeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Lib\RecipeQuery The inner query object of the NOT IN statement
     */
    public function useNotInRecipeQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\RecipeQuery */
        $q = $this->useInQuery('Recipe', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Lib\Category object
     *
     * @param \Lib\Category|ObjectCollection $category The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCategory($category, ?string $comparison = null)
    {
        if ($category instanceof \Lib\Category) {
            return $this
                ->addUsingAlias(DayPlanRecipeTableMap::COL_CATEGORY_ID, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(DayPlanRecipeTableMap::COL_CATEGORY_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByCategory() only accepts arguments of type \Lib\Category or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Category relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinCategory(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Category');

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
            $this->addJoinObject($join, 'Category');
        }

        return $this;
    }

    /**
     * Use the Category relation Category object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Category', '\Lib\CategoryQuery');
    }

    /**
     * Use the Category relation Category object
     *
     * @param callable(\Lib\CategoryQuery):\Lib\CategoryQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCategoryQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCategoryQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Category table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Lib\CategoryQuery The inner query object of the EXISTS statement
     */
    public function useCategoryExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Lib\CategoryQuery */
        $q = $this->useExistsQuery('Category', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Category table for a NOT EXISTS query.
     *
     * @see useCategoryExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Lib\CategoryQuery The inner query object of the NOT EXISTS statement
     */
    public function useCategoryNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\CategoryQuery */
        $q = $this->useExistsQuery('Category', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Category table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Lib\CategoryQuery The inner query object of the IN statement
     */
    public function useInCategoryQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Lib\CategoryQuery */
        $q = $this->useInQuery('Category', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Category table for a NOT IN query.
     *
     * @see useCategoryInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Lib\CategoryQuery The inner query object of the NOT IN statement
     */
    public function useNotInCategoryQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\CategoryQuery */
        $q = $this->useInQuery('Category', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildDayPlanRecipe $dayPlanRecipe Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($dayPlanRecipe = null)
    {
        if ($dayPlanRecipe) {
            $this->addUsingAlias(DayPlanRecipeTableMap::COL_ID, $dayPlanRecipe->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the day_plan_recipe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DayPlanRecipeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DayPlanRecipeTableMap::clearInstancePool();
            DayPlanRecipeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DayPlanRecipeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DayPlanRecipeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DayPlanRecipeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DayPlanRecipeTableMap::clearRelatedInstancePool();

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
        $this->addUsingAlias(DayPlanRecipeTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by update date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        $this->addDescendingOrderByColumn(DayPlanRecipeTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by update date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        $this->addAscendingOrderByColumn(DayPlanRecipeTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by create date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        $this->addDescendingOrderByColumn(DayPlanRecipeTableMap::COL_CREATED_AT);

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
        $this->addUsingAlias(DayPlanRecipeTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by create date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        $this->addAscendingOrderByColumn(DayPlanRecipeTableMap::COL_CREATED_AT);

        return $this;
    }

}
