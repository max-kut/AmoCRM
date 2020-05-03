<?php

namespace AmoPRO\AmoCRM\Data;

use AmoPRO\AmoCRM\Support\Arr;
use AmoPRO\AmoCRM\Support\Helpers;
use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;
use Traversable;
use function class_parents;

abstract class Collection implements ArrayAccess, JsonSerializable, Countable, IteratorAggregate
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection.
     *
     * @param mixed $items
     *
     * @return void
     */
    public function __construct($items = [])
    {
        $this->items = $this->getNestedItems($items);
    }

    abstract public function getNestedClassName(): string;

    /**
     * @param array|static $attributes
     *
     * @return static
     */
    public static function make($attributes = [])
    {
        return new static($attributes);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @param $items
     *
     * @return array
     * @uses makeNestedItem
     */
    protected function getNestedItems($items): array
    {
        if (is_string($items)) {
            return array_map([$this, 'makeNestedItem'], json_decode($items, true));
        }

        if (is_array($items)) {
            return array_map([$this, 'makeNestedItem'], $items);
        }

        if ($items instanceof self) {
            return $items->all();
        }

        return (array)$items;
    }

    /**
     * @param $nestedItem
     *
     * @return mixed
     */
    protected function makeNestedItem($nestedItem)
    {
        $className = $this->getNestedClassName();
        if (class_exists($className)) {
            $parents = class_parents($className);
            if (array_key_exists(Obj::class, $parents) || array_key_exists(Collection::class, $parents)) {
                return new $className($nestedItem);
            }
        }
        throw new InvalidArgumentException(sprintf('Nested item "%s" must extended %s',
            $className, Obj::class
        ));
    }

    /**
     * Get the first item from the enumerable passing the given truth test.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        $iterator = $this->getIterator();

        if (is_null($callback)) {
            if (! $iterator->valid()) {
                return Helpers::value($default);
            }

            return $iterator->current();
        }

        foreach ($iterator as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return Helpers::value($default);
    }

    /**
     * Determine if the collection is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Run a filter over each of the items.
     *
     * @param callable|null $callback
     * @return static
     */
    public function filter(callable $callback = null)
    {
        if ($callback) {
            return new static(Arr::where($this->items, $callback));
        }

        return new static(array_filter($this->items));
    }

    /**
     * Execute a callback over each item.
     *
     * @param callable $callback
     * @return $this
     */
    public function each(callable $callback)
    {
        foreach ($this as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * Key an associative array by a field or using a callback.
     *
     * @param callable|string $keyBy
     * @return static
     */
    public function keyBy($keyBy)
    {
        $keyBy = $this->valueRetriever($keyBy);

        $results = [];

        foreach ($this->items as $key => $item) {
            $resolvedKey = $keyBy($item, $key);

            if (is_object($resolvedKey)) {
                $resolvedKey = (string)$resolvedKey;
            }

            $results[$resolvedKey] = $item;
        }

        return new static($results);
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function push(Obj $value)
    {
        $this->offsetSet(null, $value);

        return $this;
    }

    /**
     * Get and remove the last item from the collection.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Push an item onto the beginning of the collection.
     *
     * @param mixed $value
     * @param mixed $key
     *
     * @return $this
     */
    public function prepend(Obj $value, $key = null)
    {
        $this->items = Arr::prepend($this->items, $value, $key);

        return $this;
    }

    /**
     * Get and remove an item from the collection.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function pull($key, $default = null)
    {
        return Arr::pull($this->items, $key, $default);
    }

    /**
     * Put an item in the collection by key.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return $this
     */
    public function put($key, Obj $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * Reverse items order.
     *
     * @return static
     */
    public function reverse()
    {
        return new static(array_reverse($this->items, true));
    }

    /**
     * Get and remove the first item from the collection.
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Reset the keys on the underlying array.
     *
     * @return static
     */
    public function values()
    {
        return new static(array_values($this->items));
    }

    /**
     * Run a map over each of the items.
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback)
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    /**
     * Slice the underlying collection array.
     *
     * @param int $offset
     * @param int|null $length
     * @return static
     */
    public function slice($offset, $length = null)
    {
        return new static(array_slice($this->items, $offset, $length, true));
    }

    /**
     * Splice a portion of the underlying collection array.
     *
     * @param int $offset
     * @param int|null $length
     * @param mixed $replacement
     * @return static
     */
    public function splice($offset, $length = null, $replacement = [])
    {
        if (func_num_args() === 1) {
            return new static(array_splice($this->items, $offset));
        }

        return new static(array_splice($this->items, $offset, $length, $replacement));
    }

    /**
     * Get the keys of the collection items.
     *
     * @return static
     */
    public function keys()
    {
        return new static(array_keys($this->items));
    }

    /**
     * "Paginate" the collection by slicing it into a smaller collection.
     *
     * @param int $page
     * @param int $perPage
     * @return static
     */
    public function forPage($page, $perPage)
    {
        $offset = max(0, ($page - 1) * $perPage);

        return $this->slice($offset, $perPage);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $value = $this->makeNestedItem($value);
        if ($key === null) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param string $key
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array_map(function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            }

            return $value;
        }, $this->items);
    }

    /**
     * Count elements of an object
     *
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Retrieve an external iterator
     *
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Determine if the given value is callable, but not a string.
     *
     * @param mixed $value
     * @return bool
     */
    protected function useAsCallable($value)
    {
        return !is_string($value) && is_callable($value);
    }

    /**
     * Get a value retrieving callback.
     *
     * @param callable|string|null $value
     * @return callable
     */
    protected function valueRetriever($value)
    {
        if ($this->useAsCallable($value)) {
            return $value;
        }

        return function ($item) use ($value) {
            return Helpers::data_get($item, $value);
        };
    }
}