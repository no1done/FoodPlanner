<?php

namespace Lib\Base;

use \Exception;
use \PDO;
use Lib\Recipe as ChildRecipe;
use Lib\RecipeQuery as ChildRecipeQuery;
use Lib\Map\RecipeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `recipe` table.
 *
 * @method     ChildRecipeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRecipeQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildRecipeQuery orderByCalories($order = Criteria::ASC) Order by the calories column
 * @method     ChildRecipeQuery orderByInstructions($order = Criteria::ASC) Order by the instructions column
 * @method     ChildRecipeQuery orderByRemoved($order = Criteria::ASC) Order by the removed column
 * @method     ChildRecipeQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildRecipeQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildRecipeQuery groupById() Group by the id column
 * @method     ChildRecipeQuery groupByName() Group by the name column
 * @method     ChildRecipeQuery groupByCalories() Group by the calories column
 * @method     ChildRecipeQuery groupByInstructions() Group by the instructions column
 * @method     ChildRecipeQuery groupByRemoved() Group by the removed column
 * @method     ChildRecipeQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildRecipeQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildRecipeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRecipeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRecipeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRecipeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRecipeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRecipeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRecipeQuery leftJoinListRecipe($relationAlias = null) Adds a LEFT JOIN clause to the query using the ListRecipe relation
 * @method     ChildRecipeQuery rightJoinListRecipe($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ListRecipe relation
 * @method     ChildRecipeQuery innerJoinListRecipe($relationAlias = null) Adds a INNER JOIN clause to the query using the ListRecipe relation
 *
 * @method     ChildRecipeQuery joinWithListRecipe($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ListRecipe relation
 *
 * @method     ChildRecipeQuery leftJoinWithListRecipe() Adds a LEFT JOIN clause and with to the query using the ListRecipe relation
 * @method     ChildRecipeQuery rightJoinWithListRecipe() Adds a RIGHT JOIN clause and with to the query using the ListRecipe relation
 * @method     ChildRecipeQuery innerJoinWithListRecipe() Adds a INNER JOIN clause and with to the query using the ListRecipe relation
 *
 * @method     ChildRecipeQuery leftJoinRecipeItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecipeItem relation
 * @method     ChildRecipeQuery rightJoinRecipeItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecipeItem relation
 * @method     ChildRecipeQuery innerJoinRecipeItem($relationAlias = null) Adds a INNER JOIN clause to the query using the RecipeItem relation
 *
 * @method     ChildRecipeQuery joinWithRecipeItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RecipeItem relation
 *
 * @method     ChildRecipeQuery leftJoinWithRecipeItem() Adds a LEFT JOIN clause and with to the query using the RecipeItem relation
 * @method     ChildRecipeQuery rightJoinWithRecipeItem() Adds a RIGHT JOIN clause and with to the query using the RecipeItem relation
 * @method     ChildRecipeQuery innerJoinWithRecipeItem() Adds a INNER JOIN clause and with to the query using the RecipeItem relation
 *
 * @method     ChildRecipeQuery leftJoinDayPlanRecipe($relationAlias = null) Adds a LEFT JOIN clause to the query using the DayPlanRecipe relation
 * @method     ChildRecipeQuery rightJoinDayPlanRecipe($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DayPlanRecipe relation
 * @method     ChildRecipeQuery innerJoinDayPlanRecipe($relationAlias = null) Adds a INNER JOIN clause to the query using the DayPlanRecipe relation
 *
 * @method     ChildRecipeQuery joinWithDayPlanRecipe($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DayPlanRecipe relation
 *
 * @method     ChildRecipeQuery leftJoinWithDayPlanRecipe() Adds a LEFT JOIN clause and with to the query using the DayPlanRecipe relation
 * @method     ChildRecipeQuery rightJoinWithDayPlanRecipe() Adds a RIGHT JOIN clause and with to the query using the DayPlanRecipe relation
 * @method     ChildRecipeQuery innerJoinWithDayPlanRecipe() Adds a INNER JOIN clause and with to the query using the DayPlanRecipe relation
 *
 * @method     \Lib\ListRecipeQuery|\Lib\RecipeItemQuery|\Lib\DayPlanRecipeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRecipe|null findOne(?ConnectionInterface $con = null) Return the first ChildRecipe matching the query
 * @method     ChildRecipe findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildRecipe matching the query, or a new ChildRecipe object populated from the query conditions when no match is found
 *
 * @method     ChildRecipe|null findOneById(int $id) Return the first ChildRecipe filtered by the id column
 * @method     ChildRecipe|null findOneByName(string $name) Return the first ChildRecipe filtered by the name column
 * @method     ChildRecipe|null findOneByCalories(int $calories) Return the first ChildRecipe filtered by the calories column
 * @method     ChildRecipe|null findOneByInstructions(string $instructions) Return the first ChildRecipe filtered by the instructions column
 * @method     ChildRecipe|null findOneByRemoved(boolean $removed) Return the first ChildRecipe filtered by the removed column
 * @method     ChildRecipe|null findOneByCreatedAt(string $created_at) Return the first ChildRecipe filtered by the created_at column
 * @method     ChildRecipe|null findOneByUpdatedAt(string $updated_at) Return the first ChildRecipe filtered by the updated_at column
 *
 * @method     ChildRecipe requirePk($key, ?ConnectionInterface $con = null) Return the ChildRecipe by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOne(?ConnectionInterface $con = null) Return the first ChildRecipe matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRecipe requireOneById(int $id) Return the first ChildRecipe filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByName(string $name) Return the first ChildRecipe filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByCalories(int $calories) Return the first ChildRecipe filtered by the calories column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByInstructions(string $instructions) Return the first ChildRecipe filtered by the instructions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByRemoved(boolean $removed) Return the first ChildRecipe filtered by the removed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByCreatedAt(string $created_at) Return the first ChildRecipe filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByUpdatedAt(string $updated_at) Return the first ChildRecipe filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRecipe[]|Collection find(?ConnectionInterface $con = null) Return ChildRecipe objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildRecipe> find(?ConnectionInterface $con = null) Return ChildRecipe objects based on current ModelCriteria
 *
 * @method     ChildRecipe[]|Collection findById(int|array<int> $id) Return ChildRecipe objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildRecipe> findById(int|array<int> $id) Return ChildRecipe objects filtered by the id column
 * @method     ChildRecipe[]|Collection findByName(string|array<string> $name) Return ChildRecipe objects filtered by the name column
 * @psalm-method Collection&\Traversable<ChildRecipe> findByName(string|array<string> $name) Return ChildRecipe objects filtered by the name column
 * @method     ChildRecipe[]|Collection findByCalories(int|array<int> $calories) Return ChildRecipe objects filtered by the calories column
 * @psalm-method Collection&\Traversable<ChildRecipe> findByCalories(int|array<int> $calories) Return ChildRecipe objects filtered by the calories column
 * @method     ChildRecipe[]|Collection findByInstructions(string|array<string> $instructions) Return ChildRecipe objects filtered by the instructions column
 * @psalm-method Collection&\Traversable<ChildRecipe> findByInstructions(string|array<string> $instructions) Return ChildRecipe objects filtered by the instructions column
 * @method     ChildRecipe[]|Collection findByRemoved(boolean|array<boolean> $removed) Return ChildRecipe objects filtered by the removed column
 * @psalm-method Collection&\Traversable<ChildRecipe> findByRemoved(boolean|array<boolean> $removed) Return ChildRecipe objects filtered by the removed column
 * @method     ChildRecipe[]|Collection findByCreatedAt(string|array<string> $created_at) Return ChildRecipe objects filtered by the created_at column
 * @psalm-method Collection&\Traversable<ChildRecipe> findByCreatedAt(string|array<string> $created_at) Return ChildRecipe objects filtered by the created_at column
 * @method     ChildRecipe[]|Collection findByUpdatedAt(string|array<string> $updated_at) Return ChildRecipe objects filtered by the updated_at column
 * @psalm-method Collection&\Traversable<ChildRecipe> findByUpdatedAt(string|array<string> $updated_at) Return ChildRecipe objects filtered by the updated_at column
 *
 * @method     ChildRecipe[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildRecipe> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class RecipeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Lib\Base\RecipeQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Lib\\Recipe', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRecipeQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRecipeQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildRecipeQuery) {
            return $criteria;
        }
        $query = new ChildRecipeQuery();
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
     * @return ChildRecipe|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RecipeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RecipeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildRecipe A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, calories, instructions, removed, created_at, updated_at FROM recipe WHERE id = :p0';
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
            /** @var ChildRecipe $obj */
            $obj = new ChildRecipe();
            $obj->hydrate($row);
            RecipeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildRecipe|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(RecipeTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(RecipeTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(RecipeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RecipeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(RecipeTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(RecipeTableMap::COL_NAME, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the calories column
     *
     * Example usage:
     * <code>
     * $query->filterByCalories(1234); // WHERE calories = 1234
     * $query->filterByCalories(array(12, 34)); // WHERE calories IN (12, 34)
     * $query->filterByCalories(array('min' => 12)); // WHERE calories > 12
     * </code>
     *
     * @param mixed $calories The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCalories($calories = null, ?string $comparison = null)
    {
        if (is_array($calories)) {
            $useMinMax = false;
            if (isset($calories['min'])) {
                $this->addUsingAlias(RecipeTableMap::COL_CALORIES, $calories['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calories['max'])) {
                $this->addUsingAlias(RecipeTableMap::COL_CALORIES, $calories['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(RecipeTableMap::COL_CALORIES, $calories, $comparison);

        return $this;
    }

    /**
     * Filter the query on the instructions column
     *
     * Example usage:
     * <code>
     * $query->filterByInstructions('fooValue');   // WHERE instructions = 'fooValue'
     * $query->filterByInstructions('%fooValue%', Criteria::LIKE); // WHERE instructions LIKE '%fooValue%'
     * $query->filterByInstructions(['foo', 'bar']); // WHERE instructions IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $instructions The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInstructions($instructions = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($instructions)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(RecipeTableMap::COL_INSTRUCTIONS, $instructions, $comparison);

        return $this;
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
     * @param bool|string $removed The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByRemoved($removed = null, ?string $comparison = null)
    {
        if (is_string($removed)) {
            $removed = in_array(strtolower($removed), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        $this->addUsingAlias(RecipeTableMap::COL_REMOVED, $removed, $comparison);

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
                $this->addUsingAlias(RecipeTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(RecipeTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(RecipeTableMap::COL_CREATED_AT, $createdAt, $comparison);

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
                $this->addUsingAlias(RecipeTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(RecipeTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(RecipeTableMap::COL_UPDATED_AT, $updatedAt, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Lib\ListRecipe object
     *
     * @param \Lib\ListRecipe|ObjectCollection $listRecipe the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByListRecipe($listRecipe, ?string $comparison = null)
    {
        if ($listRecipe instanceof \Lib\ListRecipe) {
            $this
                ->addUsingAlias(RecipeTableMap::COL_ID, $listRecipe->getRecipeId(), $comparison);

            return $this;
        } elseif ($listRecipe instanceof ObjectCollection) {
            $this
                ->useListRecipeQuery()
                ->filterByPrimaryKeys($listRecipe->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByListRecipe() only accepts arguments of type \Lib\ListRecipe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ListRecipe relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinListRecipe(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
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
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
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
     * Use the ListRecipe relation ListRecipe object
     *
     * @param callable(\Lib\ListRecipeQuery):\Lib\ListRecipeQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withListRecipeQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useListRecipeQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to ListRecipe table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Lib\ListRecipeQuery The inner query object of the EXISTS statement
     */
    public function useListRecipeExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Lib\ListRecipeQuery */
        $q = $this->useExistsQuery('ListRecipe', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to ListRecipe table for a NOT EXISTS query.
     *
     * @see useListRecipeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Lib\ListRecipeQuery The inner query object of the NOT EXISTS statement
     */
    public function useListRecipeNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\ListRecipeQuery */
        $q = $this->useExistsQuery('ListRecipe', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to ListRecipe table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Lib\ListRecipeQuery The inner query object of the IN statement
     */
    public function useInListRecipeQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Lib\ListRecipeQuery */
        $q = $this->useInQuery('ListRecipe', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to ListRecipe table for a NOT IN query.
     *
     * @see useListRecipeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Lib\ListRecipeQuery The inner query object of the NOT IN statement
     */
    public function useNotInListRecipeQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\ListRecipeQuery */
        $q = $this->useInQuery('ListRecipe', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Lib\RecipeItem object
     *
     * @param \Lib\RecipeItem|ObjectCollection $recipeItem the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByRecipeItem($recipeItem, ?string $comparison = null)
    {
        if ($recipeItem instanceof \Lib\RecipeItem) {
            $this
                ->addUsingAlias(RecipeTableMap::COL_ID, $recipeItem->getRecipeId(), $comparison);

            return $this;
        } elseif ($recipeItem instanceof ObjectCollection) {
            $this
                ->useRecipeItemQuery()
                ->filterByPrimaryKeys($recipeItem->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByRecipeItem() only accepts arguments of type \Lib\RecipeItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RecipeItem relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinRecipeItem(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RecipeItem');

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
            $this->addJoinObject($join, 'RecipeItem');
        }

        return $this;
    }

    /**
     * Use the RecipeItem relation RecipeItem object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\RecipeItemQuery A secondary query class using the current class as primary query
     */
    public function useRecipeItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRecipeItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RecipeItem', '\Lib\RecipeItemQuery');
    }

    /**
     * Use the RecipeItem relation RecipeItem object
     *
     * @param callable(\Lib\RecipeItemQuery):\Lib\RecipeItemQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withRecipeItemQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useRecipeItemQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to RecipeItem table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Lib\RecipeItemQuery The inner query object of the EXISTS statement
     */
    public function useRecipeItemExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Lib\RecipeItemQuery */
        $q = $this->useExistsQuery('RecipeItem', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to RecipeItem table for a NOT EXISTS query.
     *
     * @see useRecipeItemExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Lib\RecipeItemQuery The inner query object of the NOT EXISTS statement
     */
    public function useRecipeItemNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\RecipeItemQuery */
        $q = $this->useExistsQuery('RecipeItem', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to RecipeItem table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Lib\RecipeItemQuery The inner query object of the IN statement
     */
    public function useInRecipeItemQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Lib\RecipeItemQuery */
        $q = $this->useInQuery('RecipeItem', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to RecipeItem table for a NOT IN query.
     *
     * @see useRecipeItemInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Lib\RecipeItemQuery The inner query object of the NOT IN statement
     */
    public function useNotInRecipeItemQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Lib\RecipeItemQuery */
        $q = $this->useInQuery('RecipeItem', $modelAlias, $queryClass, 'NOT IN');
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
                ->addUsingAlias(RecipeTableMap::COL_ID, $dayPlanRecipe->getRecipeId(), $comparison);

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
     * @param ChildRecipe $recipe Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($recipe = null)
    {
        if ($recipe) {
            $this->addUsingAlias(RecipeTableMap::COL_ID, $recipe->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the recipe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecipeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RecipeTableMap::clearInstancePool();
            RecipeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RecipeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RecipeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RecipeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RecipeTableMap::clearRelatedInstancePool();

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
        $this->addUsingAlias(RecipeTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by update date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        $this->addDescendingOrderByColumn(RecipeTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by update date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        $this->addAscendingOrderByColumn(RecipeTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by create date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        $this->addDescendingOrderByColumn(RecipeTableMap::COL_CREATED_AT);

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
        $this->addUsingAlias(RecipeTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by create date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        $this->addAscendingOrderByColumn(RecipeTableMap::COL_CREATED_AT);

        return $this;
    }

}
