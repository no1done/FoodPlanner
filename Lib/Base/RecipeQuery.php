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
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'recipe' table.
 *
 *
 *
 * @method     ChildRecipeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRecipeQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildRecipeQuery orderByInstructions($order = Criteria::ASC) Order by the instructions column
 * @method     ChildRecipeQuery orderByRemoved($order = Criteria::ASC) Order by the removed column
 * @method     ChildRecipeQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildRecipeQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildRecipeQuery groupById() Group by the id column
 * @method     ChildRecipeQuery groupByName() Group by the name column
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
 * @method     ChildRecipeQuery leftJoinRecipeIngredient($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecipeIngredient relation
 * @method     ChildRecipeQuery rightJoinRecipeIngredient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecipeIngredient relation
 * @method     ChildRecipeQuery innerJoinRecipeIngredient($relationAlias = null) Adds a INNER JOIN clause to the query using the RecipeIngredient relation
 *
 * @method     ChildRecipeQuery joinWithRecipeIngredient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RecipeIngredient relation
 *
 * @method     ChildRecipeQuery leftJoinWithRecipeIngredient() Adds a LEFT JOIN clause and with to the query using the RecipeIngredient relation
 * @method     ChildRecipeQuery rightJoinWithRecipeIngredient() Adds a RIGHT JOIN clause and with to the query using the RecipeIngredient relation
 * @method     ChildRecipeQuery innerJoinWithRecipeIngredient() Adds a INNER JOIN clause and with to the query using the RecipeIngredient relation
 *
 * @method     \Lib\ListRecipeQuery|\Lib\RecipeIngredientQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRecipe findOne(ConnectionInterface $con = null) Return the first ChildRecipe matching the query
 * @method     ChildRecipe findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRecipe matching the query, or a new ChildRecipe object populated from the query conditions when no match is found
 *
 * @method     ChildRecipe findOneById(int $id) Return the first ChildRecipe filtered by the id column
 * @method     ChildRecipe findOneByName(string $name) Return the first ChildRecipe filtered by the name column
 * @method     ChildRecipe findOneByInstructions(string $instructions) Return the first ChildRecipe filtered by the instructions column
 * @method     ChildRecipe findOneByRemoved(boolean $removed) Return the first ChildRecipe filtered by the removed column
 * @method     ChildRecipe findOneByCreatedAt(string $created_at) Return the first ChildRecipe filtered by the created_at column
 * @method     ChildRecipe findOneByUpdatedAt(string $updated_at) Return the first ChildRecipe filtered by the updated_at column *

 * @method     ChildRecipe requirePk($key, ConnectionInterface $con = null) Return the ChildRecipe by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOne(ConnectionInterface $con = null) Return the first ChildRecipe matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRecipe requireOneById(int $id) Return the first ChildRecipe filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByName(string $name) Return the first ChildRecipe filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByInstructions(string $instructions) Return the first ChildRecipe filtered by the instructions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByRemoved(boolean $removed) Return the first ChildRecipe filtered by the removed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByCreatedAt(string $created_at) Return the first ChildRecipe filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRecipe requireOneByUpdatedAt(string $updated_at) Return the first ChildRecipe filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRecipe[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRecipe objects based on current ModelCriteria
 * @method     ChildRecipe[]|ObjectCollection findById(int $id) Return ChildRecipe objects filtered by the id column
 * @method     ChildRecipe[]|ObjectCollection findByName(string $name) Return ChildRecipe objects filtered by the name column
 * @method     ChildRecipe[]|ObjectCollection findByInstructions(string $instructions) Return ChildRecipe objects filtered by the instructions column
 * @method     ChildRecipe[]|ObjectCollection findByRemoved(boolean $removed) Return ChildRecipe objects filtered by the removed column
 * @method     ChildRecipe[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildRecipe objects filtered by the created_at column
 * @method     ChildRecipe[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildRecipe objects filtered by the updated_at column
 * @method     ChildRecipe[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RecipeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Lib\Base\RecipeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Lib\\Recipe', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRecipeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRecipeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
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
    public function findPk($key, ConnectionInterface $con = null)
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
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRecipe A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, instructions, removed, created_at, updated_at FROM recipe WHERE id = :p0';
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
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
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
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RecipeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RecipeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
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

        return $this->addUsingAlias(RecipeTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecipeTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the instructions column
     *
     * Example usage:
     * <code>
     * $query->filterByInstructions('fooValue');   // WHERE instructions = 'fooValue'
     * $query->filterByInstructions('%fooValue%', Criteria::LIKE); // WHERE instructions LIKE '%fooValue%'
     * </code>
     *
     * @param     string $instructions The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByInstructions($instructions = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($instructions)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecipeTableMap::COL_INSTRUCTIONS, $instructions, $comparison);
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
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByRemoved($removed = null, $comparison = null)
    {
        if (is_string($removed)) {
            $removed = in_array(strtolower($removed), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RecipeTableMap::COL_REMOVED, $removed, $comparison);
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
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
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

        return $this->addUsingAlias(RecipeTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
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

        return $this->addUsingAlias(RecipeTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Lib\ListRecipe object
     *
     * @param \Lib\ListRecipe|ObjectCollection $listRecipe the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByListRecipe($listRecipe, $comparison = null)
    {
        if ($listRecipe instanceof \Lib\ListRecipe) {
            return $this
                ->addUsingAlias(RecipeTableMap::COL_ID, $listRecipe->getRecipeId(), $comparison);
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
     * @return $this|ChildRecipeQuery The current query, for fluid interface
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
     * Filter the query by a related \Lib\RecipeIngredient object
     *
     * @param \Lib\RecipeIngredient|ObjectCollection $recipeIngredient the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRecipeQuery The current query, for fluid interface
     */
    public function filterByRecipeIngredient($recipeIngredient, $comparison = null)
    {
        if ($recipeIngredient instanceof \Lib\RecipeIngredient) {
            return $this
                ->addUsingAlias(RecipeTableMap::COL_ID, $recipeIngredient->getRecipeId(), $comparison);
        } elseif ($recipeIngredient instanceof ObjectCollection) {
            return $this
                ->useRecipeIngredientQuery()
                ->filterByPrimaryKeys($recipeIngredient->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRecipeIngredient() only accepts arguments of type \Lib\RecipeIngredient or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RecipeIngredient relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function joinRecipeIngredient($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RecipeIngredient');

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
            $this->addJoinObject($join, 'RecipeIngredient');
        }

        return $this;
    }

    /**
     * Use the RecipeIngredient relation RecipeIngredient object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\RecipeIngredientQuery A secondary query class using the current class as primary query
     */
    public function useRecipeIngredientQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRecipeIngredient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RecipeIngredient', '\Lib\RecipeIngredientQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRecipe $recipe Object to remove from the list of results
     *
     * @return $this|ChildRecipeQuery The current query, for fluid interface
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
    public function doDeleteAll(ConnectionInterface $con = null)
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
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
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
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(RecipeTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(RecipeTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(RecipeTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(RecipeTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(RecipeTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildRecipeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(RecipeTableMap::COL_CREATED_AT);
    }

} // RecipeQuery
