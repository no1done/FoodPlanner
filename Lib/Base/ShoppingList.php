<?php

namespace Lib\Base;

use \DateTime;
use \Exception;
use \PDO;
use Lib\DayPlan as ChildDayPlan;
use Lib\DayPlanQuery as ChildDayPlanQuery;
use Lib\ListRecipe as ChildListRecipe;
use Lib\ListRecipeQuery as ChildListRecipeQuery;
use Lib\ShoppingList as ChildShoppingList;
use Lib\ShoppingListItem as ChildShoppingListItem;
use Lib\ShoppingListItemQuery as ChildShoppingListItemQuery;
use Lib\ShoppingListQuery as ChildShoppingListQuery;
use Lib\Map\DayPlanTableMap;
use Lib\Map\ListRecipeTableMap;
use Lib\Map\ShoppingListItemTableMap;
use Lib\Map\ShoppingListTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'shopping_list' table.
 *
 *
 *
 * @package    propel.generator.Lib.Base
 */
abstract class ShoppingList implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Lib\\Map\\ShoppingListTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the removed field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean|null
     */
    protected $removed;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime|null
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     *
     * @var        DateTime|null
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildListRecipe[] Collection to store aggregation of ChildListRecipe objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildListRecipe> Collection to store aggregation of ChildListRecipe objects.
     */
    protected $collListRecipes;
    protected $collListRecipesPartial;

    /**
     * @var        ObjectCollection|ChildShoppingListItem[] Collection to store aggregation of ChildShoppingListItem objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildShoppingListItem> Collection to store aggregation of ChildShoppingListItem objects.
     */
    protected $collShoppingListItems;
    protected $collShoppingListItemsPartial;

    /**
     * @var        ObjectCollection|ChildDayPlan[] Collection to store aggregation of ChildDayPlan objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildDayPlan> Collection to store aggregation of ChildDayPlan objects.
     */
    protected $collDayPlans;
    protected $collDayPlansPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildListRecipe[]
     * @phpstan-var ObjectCollection&\Traversable<ChildListRecipe>
     */
    protected $listRecipesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShoppingListItem[]
     * @phpstan-var ObjectCollection&\Traversable<ChildShoppingListItem>
     */
    protected $shoppingListItemsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDayPlan[]
     * @phpstan-var ObjectCollection&\Traversable<ChildDayPlan>
     */
    protected $dayPlansScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues(): void
    {
        $this->removed = false;
    }

    /**
     * Initializes internal state of Lib\Base\ShoppingList object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>ShoppingList</code> instance.  If
     * <code>obj</code> is an instance of <code>ShoppingList</code>, delegates to
     * <code>equals(ShoppingList)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [removed] column value.
     *
     * @return boolean|null
     */
    public function getRemoved()
    {
        return $this->removed;
    }

    /**
     * Get the [removed] column value.
     *
     * @return boolean|null
     */
    public function isRemoved()
    {
        return $this->getRemoved();
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getCreatedAt($format = null)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getUpdatedAt($format = null)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ShoppingListTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [name] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ShoppingListTableMap::COL_NAME] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [removed] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param bool|integer|string|null $v The new value
     * @return $this The current object (for fluent API support)
     */
    public function setRemoved($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->removed !== $v) {
            $this->removed = $v;
            $this->modifiedColumns[ShoppingListTableMap::COL_REMOVED] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ShoppingListTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ShoppingListTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
            if ($this->removed !== false) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ShoppingListTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ShoppingListTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ShoppingListTableMap::translateFieldName('Removed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->removed = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ShoppingListTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ShoppingListTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = ShoppingListTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Lib\\ShoppingList'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShoppingListTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildShoppingListQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collListRecipes = null;

            $this->collShoppingListItems = null;

            $this->collDayPlans = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see ShoppingList::setDeleted()
     * @see ShoppingList::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShoppingListTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildShoppingListQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShoppingListTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(ShoppingListTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt($highPrecision);
                }
                if (!$this->isColumnModified(ShoppingListTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ShoppingListTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ShoppingListTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con): int
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->listRecipesScheduledForDeletion !== null) {
                if (!$this->listRecipesScheduledForDeletion->isEmpty()) {
                    \Lib\ListRecipeQuery::create()
                        ->filterByPrimaryKeys($this->listRecipesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->listRecipesScheduledForDeletion = null;
                }
            }

            if ($this->collListRecipes !== null) {
                foreach ($this->collListRecipes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->shoppingListItemsScheduledForDeletion !== null) {
                if (!$this->shoppingListItemsScheduledForDeletion->isEmpty()) {
                    \Lib\ShoppingListItemQuery::create()
                        ->filterByPrimaryKeys($this->shoppingListItemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->shoppingListItemsScheduledForDeletion = null;
                }
            }

            if ($this->collShoppingListItems !== null) {
                foreach ($this->collShoppingListItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dayPlansScheduledForDeletion !== null) {
                if (!$this->dayPlansScheduledForDeletion->isEmpty()) {
                    \Lib\DayPlanQuery::create()
                        ->filterByPrimaryKeys($this->dayPlansScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dayPlansScheduledForDeletion = null;
                }
            }

            if ($this->collDayPlans !== null) {
                foreach ($this->collDayPlans as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;

        $this->modifiedColumns[ShoppingListTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ShoppingListTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ShoppingListTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ShoppingListTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(ShoppingListTableMap::COL_REMOVED)) {
            $modifiedColumns[':p' . $index++]  = 'removed';
        }
        if ($this->isColumnModified(ShoppingListTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(ShoppingListTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO shopping_list (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);

                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);

                        break;
                    case 'removed':
                        $stmt->bindValue($identifier, (int) $this->removed, PDO::PARAM_INT);

                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ShoppingListTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();

            case 1:
                return $this->getName();

            case 2:
                return $this->getRemoved();

            case 3:
                return $this->getCreatedAt();

            case 4:
                return $this->getUpdatedAt();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['ShoppingList'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['ShoppingList'][$this->hashCode()] = true;
        $keys = ShoppingListTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getRemoved(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getUpdatedAt(),
        ];
        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collListRecipes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'listRecipes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'list_recipes';
                        break;
                    default:
                        $key = 'ListRecipes';
                }

                $result[$key] = $this->collListRecipes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collShoppingListItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'shoppingListItems';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shopping_list_items';
                        break;
                    default:
                        $key = 'ShoppingListItems';
                }

                $result[$key] = $this->collShoppingListItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDayPlans) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dayPlans';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'day_plans';
                        break;
                    default:
                        $key = 'DayPlans';
                }

                $result[$key] = $this->collDayPlans->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ShoppingListTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setRemoved($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ShoppingListTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRemoved($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatedAt($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUpdatedAt($arr[$keys[4]]);
        }

        return $this;
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(ShoppingListTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ShoppingListTableMap::COL_ID)) {
            $criteria->add(ShoppingListTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ShoppingListTableMap::COL_NAME)) {
            $criteria->add(ShoppingListTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ShoppingListTableMap::COL_REMOVED)) {
            $criteria->add(ShoppingListTableMap::COL_REMOVED, $this->removed);
        }
        if ($this->isColumnModified(ShoppingListTableMap::COL_CREATED_AT)) {
            $criteria->add(ShoppingListTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(ShoppingListTableMap::COL_UPDATED_AT)) {
            $criteria->add(ShoppingListTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildShoppingListQuery::create();
        $criteria->add(ShoppingListTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \Lib\ShoppingList (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setName($this->getName());
        $copyObj->setRemoved($this->getRemoved());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getListRecipes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addListRecipe($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getShoppingListItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShoppingListItem($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDayPlans() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDayPlan($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Lib\ShoppingList Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName): void
    {
        if ('ListRecipe' === $relationName) {
            $this->initListRecipes();
            return;
        }
        if ('ShoppingListItem' === $relationName) {
            $this->initShoppingListItems();
            return;
        }
        if ('DayPlan' === $relationName) {
            $this->initDayPlans();
            return;
        }
    }

    /**
     * Clears out the collListRecipes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addListRecipes()
     */
    public function clearListRecipes()
    {
        $this->collListRecipes = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collListRecipes collection loaded partially.
     *
     * @return void
     */
    public function resetPartialListRecipes($v = true): void
    {
        $this->collListRecipesPartial = $v;
    }

    /**
     * Initializes the collListRecipes collection.
     *
     * By default this just sets the collListRecipes collection to an empty array (like clearcollListRecipes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initListRecipes(bool $overrideExisting = true): void
    {
        if (null !== $this->collListRecipes && !$overrideExisting) {
            return;
        }

        $collectionClassName = ListRecipeTableMap::getTableMap()->getCollectionClassName();

        $this->collListRecipes = new $collectionClassName;
        $this->collListRecipes->setModel('\Lib\ListRecipe');
    }

    /**
     * Gets an array of ChildListRecipe objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildShoppingList is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildListRecipe[] List of ChildListRecipe objects
     * @phpstan-return ObjectCollection&\Traversable<ChildListRecipe> List of ChildListRecipe objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getListRecipes(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collListRecipesPartial && !$this->isNew();
        if (null === $this->collListRecipes || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collListRecipes) {
                    $this->initListRecipes();
                } else {
                    $collectionClassName = ListRecipeTableMap::getTableMap()->getCollectionClassName();

                    $collListRecipes = new $collectionClassName;
                    $collListRecipes->setModel('\Lib\ListRecipe');

                    return $collListRecipes;
                }
            } else {
                $collListRecipes = ChildListRecipeQuery::create(null, $criteria)
                    ->filterByShoppingList($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collListRecipesPartial && count($collListRecipes)) {
                        $this->initListRecipes(false);

                        foreach ($collListRecipes as $obj) {
                            if (false == $this->collListRecipes->contains($obj)) {
                                $this->collListRecipes->append($obj);
                            }
                        }

                        $this->collListRecipesPartial = true;
                    }

                    return $collListRecipes;
                }

                if ($partial && $this->collListRecipes) {
                    foreach ($this->collListRecipes as $obj) {
                        if ($obj->isNew()) {
                            $collListRecipes[] = $obj;
                        }
                    }
                }

                $this->collListRecipes = $collListRecipes;
                $this->collListRecipesPartial = false;
            }
        }

        return $this->collListRecipes;
    }

    /**
     * Sets a collection of ChildListRecipe objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $listRecipes A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setListRecipes(Collection $listRecipes, ?ConnectionInterface $con = null)
    {
        /** @var ChildListRecipe[] $listRecipesToDelete */
        $listRecipesToDelete = $this->getListRecipes(new Criteria(), $con)->diff($listRecipes);


        $this->listRecipesScheduledForDeletion = $listRecipesToDelete;

        foreach ($listRecipesToDelete as $listRecipeRemoved) {
            $listRecipeRemoved->setShoppingList(null);
        }

        $this->collListRecipes = null;
        foreach ($listRecipes as $listRecipe) {
            $this->addListRecipe($listRecipe);
        }

        $this->collListRecipes = $listRecipes;
        $this->collListRecipesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ListRecipe objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related ListRecipe objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countListRecipes(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collListRecipesPartial && !$this->isNew();
        if (null === $this->collListRecipes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collListRecipes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getListRecipes());
            }

            $query = ChildListRecipeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByShoppingList($this)
                ->count($con);
        }

        return count($this->collListRecipes);
    }

    /**
     * Method called to associate a ChildListRecipe object to this object
     * through the ChildListRecipe foreign key attribute.
     *
     * @param ChildListRecipe $l ChildListRecipe
     * @return $this The current object (for fluent API support)
     */
    public function addListRecipe(ChildListRecipe $l)
    {
        if ($this->collListRecipes === null) {
            $this->initListRecipes();
            $this->collListRecipesPartial = true;
        }

        if (!$this->collListRecipes->contains($l)) {
            $this->doAddListRecipe($l);

            if ($this->listRecipesScheduledForDeletion and $this->listRecipesScheduledForDeletion->contains($l)) {
                $this->listRecipesScheduledForDeletion->remove($this->listRecipesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildListRecipe $listRecipe The ChildListRecipe object to add.
     */
    protected function doAddListRecipe(ChildListRecipe $listRecipe): void
    {
        $this->collListRecipes[]= $listRecipe;
        $listRecipe->setShoppingList($this);
    }

    /**
     * @param ChildListRecipe $listRecipe The ChildListRecipe object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeListRecipe(ChildListRecipe $listRecipe)
    {
        if ($this->getListRecipes()->contains($listRecipe)) {
            $pos = $this->collListRecipes->search($listRecipe);
            $this->collListRecipes->remove($pos);
            if (null === $this->listRecipesScheduledForDeletion) {
                $this->listRecipesScheduledForDeletion = clone $this->collListRecipes;
                $this->listRecipesScheduledForDeletion->clear();
            }
            $this->listRecipesScheduledForDeletion[]= clone $listRecipe;
            $listRecipe->setShoppingList(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ShoppingList is new, it will return
     * an empty collection; or if this ShoppingList has previously
     * been saved, it will retrieve related ListRecipes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ShoppingList.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildListRecipe[] List of ChildListRecipe objects
     * @phpstan-return ObjectCollection&\Traversable<ChildListRecipe}> List of ChildListRecipe objects
     */
    public function getListRecipesJoinRecipe(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildListRecipeQuery::create(null, $criteria);
        $query->joinWith('Recipe', $joinBehavior);

        return $this->getListRecipes($query, $con);
    }

    /**
     * Clears out the collShoppingListItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addShoppingListItems()
     */
    public function clearShoppingListItems()
    {
        $this->collShoppingListItems = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collShoppingListItems collection loaded partially.
     *
     * @return void
     */
    public function resetPartialShoppingListItems($v = true): void
    {
        $this->collShoppingListItemsPartial = $v;
    }

    /**
     * Initializes the collShoppingListItems collection.
     *
     * By default this just sets the collShoppingListItems collection to an empty array (like clearcollShoppingListItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initShoppingListItems(bool $overrideExisting = true): void
    {
        if (null !== $this->collShoppingListItems && !$overrideExisting) {
            return;
        }

        $collectionClassName = ShoppingListItemTableMap::getTableMap()->getCollectionClassName();

        $this->collShoppingListItems = new $collectionClassName;
        $this->collShoppingListItems->setModel('\Lib\ShoppingListItem');
    }

    /**
     * Gets an array of ChildShoppingListItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildShoppingList is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildShoppingListItem[] List of ChildShoppingListItem objects
     * @phpstan-return ObjectCollection&\Traversable<ChildShoppingListItem> List of ChildShoppingListItem objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getShoppingListItems(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collShoppingListItemsPartial && !$this->isNew();
        if (null === $this->collShoppingListItems || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collShoppingListItems) {
                    $this->initShoppingListItems();
                } else {
                    $collectionClassName = ShoppingListItemTableMap::getTableMap()->getCollectionClassName();

                    $collShoppingListItems = new $collectionClassName;
                    $collShoppingListItems->setModel('\Lib\ShoppingListItem');

                    return $collShoppingListItems;
                }
            } else {
                $collShoppingListItems = ChildShoppingListItemQuery::create(null, $criteria)
                    ->filterByShoppingList($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collShoppingListItemsPartial && count($collShoppingListItems)) {
                        $this->initShoppingListItems(false);

                        foreach ($collShoppingListItems as $obj) {
                            if (false == $this->collShoppingListItems->contains($obj)) {
                                $this->collShoppingListItems->append($obj);
                            }
                        }

                        $this->collShoppingListItemsPartial = true;
                    }

                    return $collShoppingListItems;
                }

                if ($partial && $this->collShoppingListItems) {
                    foreach ($this->collShoppingListItems as $obj) {
                        if ($obj->isNew()) {
                            $collShoppingListItems[] = $obj;
                        }
                    }
                }

                $this->collShoppingListItems = $collShoppingListItems;
                $this->collShoppingListItemsPartial = false;
            }
        }

        return $this->collShoppingListItems;
    }

    /**
     * Sets a collection of ChildShoppingListItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $shoppingListItems A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setShoppingListItems(Collection $shoppingListItems, ?ConnectionInterface $con = null)
    {
        /** @var ChildShoppingListItem[] $shoppingListItemsToDelete */
        $shoppingListItemsToDelete = $this->getShoppingListItems(new Criteria(), $con)->diff($shoppingListItems);


        $this->shoppingListItemsScheduledForDeletion = $shoppingListItemsToDelete;

        foreach ($shoppingListItemsToDelete as $shoppingListItemRemoved) {
            $shoppingListItemRemoved->setShoppingList(null);
        }

        $this->collShoppingListItems = null;
        foreach ($shoppingListItems as $shoppingListItem) {
            $this->addShoppingListItem($shoppingListItem);
        }

        $this->collShoppingListItems = $shoppingListItems;
        $this->collShoppingListItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ShoppingListItem objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related ShoppingListItem objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countShoppingListItems(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collShoppingListItemsPartial && !$this->isNew();
        if (null === $this->collShoppingListItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collShoppingListItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getShoppingListItems());
            }

            $query = ChildShoppingListItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByShoppingList($this)
                ->count($con);
        }

        return count($this->collShoppingListItems);
    }

    /**
     * Method called to associate a ChildShoppingListItem object to this object
     * through the ChildShoppingListItem foreign key attribute.
     *
     * @param ChildShoppingListItem $l ChildShoppingListItem
     * @return $this The current object (for fluent API support)
     */
    public function addShoppingListItem(ChildShoppingListItem $l)
    {
        if ($this->collShoppingListItems === null) {
            $this->initShoppingListItems();
            $this->collShoppingListItemsPartial = true;
        }

        if (!$this->collShoppingListItems->contains($l)) {
            $this->doAddShoppingListItem($l);

            if ($this->shoppingListItemsScheduledForDeletion and $this->shoppingListItemsScheduledForDeletion->contains($l)) {
                $this->shoppingListItemsScheduledForDeletion->remove($this->shoppingListItemsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildShoppingListItem $shoppingListItem The ChildShoppingListItem object to add.
     */
    protected function doAddShoppingListItem(ChildShoppingListItem $shoppingListItem): void
    {
        $this->collShoppingListItems[]= $shoppingListItem;
        $shoppingListItem->setShoppingList($this);
    }

    /**
     * @param ChildShoppingListItem $shoppingListItem The ChildShoppingListItem object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeShoppingListItem(ChildShoppingListItem $shoppingListItem)
    {
        if ($this->getShoppingListItems()->contains($shoppingListItem)) {
            $pos = $this->collShoppingListItems->search($shoppingListItem);
            $this->collShoppingListItems->remove($pos);
            if (null === $this->shoppingListItemsScheduledForDeletion) {
                $this->shoppingListItemsScheduledForDeletion = clone $this->collShoppingListItems;
                $this->shoppingListItemsScheduledForDeletion->clear();
            }
            $this->shoppingListItemsScheduledForDeletion[]= clone $shoppingListItem;
            $shoppingListItem->setShoppingList(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ShoppingList is new, it will return
     * an empty collection; or if this ShoppingList has previously
     * been saved, it will retrieve related ShoppingListItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ShoppingList.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShoppingListItem[] List of ChildShoppingListItem objects
     * @phpstan-return ObjectCollection&\Traversable<ChildShoppingListItem}> List of ChildShoppingListItem objects
     */
    public function getShoppingListItemsJoinItem(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShoppingListItemQuery::create(null, $criteria);
        $query->joinWith('Item', $joinBehavior);

        return $this->getShoppingListItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ShoppingList is new, it will return
     * an empty collection; or if this ShoppingList has previously
     * been saved, it will retrieve related ShoppingListItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ShoppingList.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShoppingListItem[] List of ChildShoppingListItem objects
     * @phpstan-return ObjectCollection&\Traversable<ChildShoppingListItem}> List of ChildShoppingListItem objects
     */
    public function getShoppingListItemsJoinListRecipe(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShoppingListItemQuery::create(null, $criteria);
        $query->joinWith('ListRecipe', $joinBehavior);

        return $this->getShoppingListItems($query, $con);
    }

    /**
     * Clears out the collDayPlans collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addDayPlans()
     */
    public function clearDayPlans()
    {
        $this->collDayPlans = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collDayPlans collection loaded partially.
     *
     * @return void
     */
    public function resetPartialDayPlans($v = true): void
    {
        $this->collDayPlansPartial = $v;
    }

    /**
     * Initializes the collDayPlans collection.
     *
     * By default this just sets the collDayPlans collection to an empty array (like clearcollDayPlans());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDayPlans(bool $overrideExisting = true): void
    {
        if (null !== $this->collDayPlans && !$overrideExisting) {
            return;
        }

        $collectionClassName = DayPlanTableMap::getTableMap()->getCollectionClassName();

        $this->collDayPlans = new $collectionClassName;
        $this->collDayPlans->setModel('\Lib\DayPlan');
    }

    /**
     * Gets an array of ChildDayPlan objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildShoppingList is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDayPlan[] List of ChildDayPlan objects
     * @phpstan-return ObjectCollection&\Traversable<ChildDayPlan> List of ChildDayPlan objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getDayPlans(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collDayPlansPartial && !$this->isNew();
        if (null === $this->collDayPlans || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collDayPlans) {
                    $this->initDayPlans();
                } else {
                    $collectionClassName = DayPlanTableMap::getTableMap()->getCollectionClassName();

                    $collDayPlans = new $collectionClassName;
                    $collDayPlans->setModel('\Lib\DayPlan');

                    return $collDayPlans;
                }
            } else {
                $collDayPlans = ChildDayPlanQuery::create(null, $criteria)
                    ->filterByShoppingList($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDayPlansPartial && count($collDayPlans)) {
                        $this->initDayPlans(false);

                        foreach ($collDayPlans as $obj) {
                            if (false == $this->collDayPlans->contains($obj)) {
                                $this->collDayPlans->append($obj);
                            }
                        }

                        $this->collDayPlansPartial = true;
                    }

                    return $collDayPlans;
                }

                if ($partial && $this->collDayPlans) {
                    foreach ($this->collDayPlans as $obj) {
                        if ($obj->isNew()) {
                            $collDayPlans[] = $obj;
                        }
                    }
                }

                $this->collDayPlans = $collDayPlans;
                $this->collDayPlansPartial = false;
            }
        }

        return $this->collDayPlans;
    }

    /**
     * Sets a collection of ChildDayPlan objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $dayPlans A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setDayPlans(Collection $dayPlans, ?ConnectionInterface $con = null)
    {
        /** @var ChildDayPlan[] $dayPlansToDelete */
        $dayPlansToDelete = $this->getDayPlans(new Criteria(), $con)->diff($dayPlans);


        $this->dayPlansScheduledForDeletion = $dayPlansToDelete;

        foreach ($dayPlansToDelete as $dayPlanRemoved) {
            $dayPlanRemoved->setShoppingList(null);
        }

        $this->collDayPlans = null;
        foreach ($dayPlans as $dayPlan) {
            $this->addDayPlan($dayPlan);
        }

        $this->collDayPlans = $dayPlans;
        $this->collDayPlansPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DayPlan objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related DayPlan objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countDayPlans(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collDayPlansPartial && !$this->isNew();
        if (null === $this->collDayPlans || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDayPlans) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDayPlans());
            }

            $query = ChildDayPlanQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByShoppingList($this)
                ->count($con);
        }

        return count($this->collDayPlans);
    }

    /**
     * Method called to associate a ChildDayPlan object to this object
     * through the ChildDayPlan foreign key attribute.
     *
     * @param ChildDayPlan $l ChildDayPlan
     * @return $this The current object (for fluent API support)
     */
    public function addDayPlan(ChildDayPlan $l)
    {
        if ($this->collDayPlans === null) {
            $this->initDayPlans();
            $this->collDayPlansPartial = true;
        }

        if (!$this->collDayPlans->contains($l)) {
            $this->doAddDayPlan($l);

            if ($this->dayPlansScheduledForDeletion and $this->dayPlansScheduledForDeletion->contains($l)) {
                $this->dayPlansScheduledForDeletion->remove($this->dayPlansScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDayPlan $dayPlan The ChildDayPlan object to add.
     */
    protected function doAddDayPlan(ChildDayPlan $dayPlan): void
    {
        $this->collDayPlans[]= $dayPlan;
        $dayPlan->setShoppingList($this);
    }

    /**
     * @param ChildDayPlan $dayPlan The ChildDayPlan object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeDayPlan(ChildDayPlan $dayPlan)
    {
        if ($this->getDayPlans()->contains($dayPlan)) {
            $pos = $this->collDayPlans->search($dayPlan);
            $this->collDayPlans->remove($pos);
            if (null === $this->dayPlansScheduledForDeletion) {
                $this->dayPlansScheduledForDeletion = clone $this->collDayPlans;
                $this->dayPlansScheduledForDeletion->clear();
            }
            $this->dayPlansScheduledForDeletion[]= clone $dayPlan;
            $dayPlan->setShoppingList(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->removed = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
            if ($this->collListRecipes) {
                foreach ($this->collListRecipes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collShoppingListItems) {
                foreach ($this->collShoppingListItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDayPlans) {
                foreach ($this->collDayPlans as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collListRecipes = null;
        $this->collShoppingListItems = null;
        $this->collDayPlans = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ShoppingListTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return $this The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ShoppingListTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
