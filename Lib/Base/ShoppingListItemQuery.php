<?php

namespace Lib\Base;

use \Exception;
use \PDO;
use Lib\ShoppingListItem as ChildShoppingListItem;
use Lib\ShoppingListItemQuery as ChildShoppingListItemQuery;
use Lib\Map\ShoppingListItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shopping_list_item' table.
 *
 *
 *
 * @method     ChildShoppingListItemQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildShoppingListItemQuery orderByShoppingListId($order = Criteria::ASC) Order by the shopping_list_id column
 * @method     ChildShoppingListItemQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildShoppingListItemQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildShoppingListItemQuery orderByRef($order = Criteria::ASC) Order by the ref column
 * @method     ChildShoppingListItemQuery orderByPurchased($order = Criteria::ASC) Order by the purchased column
 * @method     ChildShoppingListItemQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildShoppingListItemQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildShoppingListItemQuery groupById() Group by the id column
 * @method     ChildShoppingListItemQuery groupByShoppingListId() Group by the shopping_list_id column
 * @method     ChildShoppingListItemQuery groupByItemId() Group by the item_id column
 * @method     ChildShoppingListItemQuery groupByQuantity() Group by the quantity column
 * @method     ChildShoppingListItemQuery groupByRef() Group by the ref column
 * @method     ChildShoppingListItemQuery groupByPurchased() Group by the purchased column
 * @method     ChildShoppingListItemQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildShoppingListItemQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildShoppingListItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShoppingListItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShoppingListItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShoppingListItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildShoppingListItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildShoppingListItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildShoppingListItemQuery leftJoinShoppingList($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShoppingList relation
 * @method     ChildShoppingListItemQuery rightJoinShoppingList($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShoppingList relation
 * @method     ChildShoppingListItemQuery innerJoinShoppingList($relationAlias = null) Adds a INNER JOIN clause to the query using the ShoppingList relation
 *
 * @method     ChildShoppingListItemQuery joinWithShoppingList($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ShoppingList relation
 *
 * @method     ChildShoppingListItemQuery leftJoinWithShoppingList() Adds a LEFT JOIN clause and with to the query using the ShoppingList relation
 * @method     ChildShoppingListItemQuery rightJoinWithShoppingList() Adds a RIGHT JOIN clause and with to the query using the ShoppingList relation
 * @method     ChildShoppingListItemQuery innerJoinWithShoppingList() Adds a INNER JOIN clause and with to the query using the ShoppingList relation
 *
 * @method     ChildShoppingListItemQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildShoppingListItemQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildShoppingListItemQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildShoppingListItemQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildShoppingListItemQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildShoppingListItemQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildShoppingListItemQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     \Lib\ShoppingListQuery|\Lib\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildShoppingListItem findOne(ConnectionInterface $con = null) Return the first ChildShoppingListItem matching the query
 * @method     ChildShoppingListItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShoppingListItem matching the query, or a new ChildShoppingListItem object populated from the query conditions when no match is found
 *
 * @method     ChildShoppingListItem findOneById(int $id) Return the first ChildShoppingListItem filtered by the id column
 * @method     ChildShoppingListItem findOneByShoppingListId(int $shopping_list_id) Return the first ChildShoppingListItem filtered by the shopping_list_id column
 * @method     ChildShoppingListItem findOneByItemId(int $item_id) Return the first ChildShoppingListItem filtered by the item_id column
 * @method     ChildShoppingListItem findOneByQuantity(double $quantity) Return the first ChildShoppingListItem filtered by the quantity column
 * @method     ChildShoppingListItem findOneByRef(string $ref) Return the first ChildShoppingListItem filtered by the ref column
 * @method     ChildShoppingListItem findOneByPurchased(boolean $purchased) Return the first ChildShoppingListItem filtered by the purchased column
 * @method     ChildShoppingListItem findOneByCreatedAt(string $created_at) Return the first ChildShoppingListItem filtered by the created_at column
 * @method     ChildShoppingListItem findOneByUpdatedAt(string $updated_at) Return the first ChildShoppingListItem filtered by the updated_at column *

 * @method     ChildShoppingListItem requirePk($key, ConnectionInterface $con = null) Return the ChildShoppingListItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingListItem requireOne(ConnectionInterface $con = null) Return the first ChildShoppingListItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShoppingListItem requireOneById(int $id) Return the first ChildShoppingListItem filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingListItem requireOneByShoppingListId(int $shopping_list_id) Return the first ChildShoppingListItem filtered by the shopping_list_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingListItem requireOneByItemId(int $item_id) Return the first ChildShoppingListItem filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingListItem requireOneByQuantity(double $quantity) Return the first ChildShoppingListItem filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingListItem requireOneByRef(string $ref) Return the first ChildShoppingListItem filtered by the ref column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingListItem requireOneByPurchased(boolean $purchased) Return the first ChildShoppingListItem filtered by the purchased column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingListItem requireOneByCreatedAt(string $created_at) Return the first ChildShoppingListItem filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShoppingListItem requireOneByUpdatedAt(string $updated_at) Return the first ChildShoppingListItem filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShoppingListItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShoppingListItem objects based on current ModelCriteria
 * @method     ChildShoppingListItem[]|ObjectCollection findById(int $id) Return ChildShoppingListItem objects filtered by the id column
 * @method     ChildShoppingListItem[]|ObjectCollection findByShoppingListId(int $shopping_list_id) Return ChildShoppingListItem objects filtered by the shopping_list_id column
 * @method     ChildShoppingListItem[]|ObjectCollection findByItemId(int $item_id) Return ChildShoppingListItem objects filtered by the item_id column
 * @method     ChildShoppingListItem[]|ObjectCollection findByQuantity(double $quantity) Return ChildShoppingListItem objects filtered by the quantity column
 * @method     ChildShoppingListItem[]|ObjectCollection findByRef(string $ref) Return ChildShoppingListItem objects filtered by the ref column
 * @method     ChildShoppingListItem[]|ObjectCollection findByPurchased(boolean $purchased) Return ChildShoppingListItem objects filtered by the purchased column
 * @method     ChildShoppingListItem[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildShoppingListItem objects filtered by the created_at column
 * @method     ChildShoppingListItem[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildShoppingListItem objects filtered by the updated_at column
 * @method     ChildShoppingListItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShoppingListItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Lib\Base\ShoppingListItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Lib\\ShoppingListItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShoppingListItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShoppingListItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShoppingListItemQuery) {
            return $criteria;
        }
        $query = new ChildShoppingListItemQuery();
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
     * @return ChildShoppingListItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShoppingListItemTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ShoppingListItemTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildShoppingListItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, shopping_list_id, item_id, quantity, ref, purchased, created_at, updated_at FROM shopping_list_item WHERE id = :p0';
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
            /** @var ChildShoppingListItem $obj */
            $obj = new ChildShoppingListItem();
            $obj->hydrate($row);
            ShoppingListItemTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildShoppingListItem|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_ID, $id, $comparison);
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
     * @param     mixed $shoppingListId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByShoppingListId($shoppingListId = null, $comparison = null)
    {
        if (is_array($shoppingListId)) {
            $useMinMax = false;
            if (isset($shoppingListId['min'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_SHOPPING_LIST_ID, $shoppingListId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shoppingListId['max'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_SHOPPING_LIST_ID, $shoppingListId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_SHOPPING_LIST_ID, $shoppingListId, $comparison);
    }

    /**
     * Filter the query on the item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemId(1234); // WHERE item_id = 1234
     * $query->filterByItemId(array(12, 34)); // WHERE item_id IN (12, 34)
     * $query->filterByItemId(array('min' => 12)); // WHERE item_id > 12
     * </code>
     *
     * @see       filterByItem()
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query on the ref column
     *
     * Example usage:
     * <code>
     * $query->filterByRef('fooValue');   // WHERE ref = 'fooValue'
     * $query->filterByRef('%fooValue%', Criteria::LIKE); // WHERE ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ref The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByRef($ref = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ref)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_REF, $ref, $comparison);
    }

    /**
     * Filter the query on the purchased column
     *
     * Example usage:
     * <code>
     * $query->filterByPurchased(true); // WHERE purchased = true
     * $query->filterByPurchased('yes'); // WHERE purchased = true
     * </code>
     *
     * @param     boolean|string $purchased The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByPurchased($purchased = null, $comparison = null)
    {
        if (is_string($purchased)) {
            $purchased = in_array(strtolower($purchased), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_PURCHASED, $purchased, $comparison);
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
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ShoppingListItemTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShoppingListItemTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Lib\ShoppingList object
     *
     * @param \Lib\ShoppingList|ObjectCollection $shoppingList The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByShoppingList($shoppingList, $comparison = null)
    {
        if ($shoppingList instanceof \Lib\ShoppingList) {
            return $this
                ->addUsingAlias(ShoppingListItemTableMap::COL_SHOPPING_LIST_ID, $shoppingList->getId(), $comparison);
        } elseif ($shoppingList instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShoppingListItemTableMap::COL_SHOPPING_LIST_ID, $shoppingList->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByShoppingList() only accepts arguments of type \Lib\ShoppingList or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShoppingList relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function joinShoppingList($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
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
     * Filter the query by a related \Lib\Item object
     *
     * @param \Lib\Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Lib\Item) {
            return $this
                ->addUsingAlias(ShoppingListItemTableMap::COL_ITEM_ID, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShoppingListItemTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \Lib\Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Item');

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
            $this->addJoinObject($join, 'Item');
        }

        return $this;
    }

    /**
     * Use the Item relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Lib\ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\Lib\ItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShoppingListItem $shoppingListItem Object to remove from the list of results
     *
     * @return $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function prune($shoppingListItem = null)
    {
        if ($shoppingListItem) {
            $this->addUsingAlias(ShoppingListItemTableMap::COL_ID, $shoppingListItem->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shopping_list_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShoppingListItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShoppingListItemTableMap::clearInstancePool();
            ShoppingListItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShoppingListItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShoppingListItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShoppingListItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShoppingListItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ShoppingListItemTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ShoppingListItemTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ShoppingListItemTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ShoppingListItemTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ShoppingListItemTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildShoppingListItemQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ShoppingListItemTableMap::COL_CREATED_AT);
    }

} // ShoppingListItemQuery
