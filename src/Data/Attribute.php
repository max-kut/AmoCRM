<?php

namespace AmoPRO\AmoCRM\Data;

use AmoPRO\AmoCRM\Support\Arr;
use AmoPRO\AmoCRM\Support\Str;
use Carbon\Carbon;
use DateTimeInterface;
use InvalidArgumentException;
use function array_key_exists;
use function class_exists;
use function class_parents;

final class Attribute
{
    const TYPE_RAW = 'raw';
    const TYPE_INT = 'int';
    const TYPE_ARRAY_INT = 'int[]';
    const TYPE_STRING = 'string';
    const TYPE_BOOL = 'bool';
    const TYPE_TIMESTAMP = 'timestamp';

    /**
     * @var \AmoPRO\AmoCRM\Data\Obj
     */
    private $object;

    /**
     * Attribute constructor.
     *
     * @param \AmoPRO\AmoCRM\Data\Obj $object
     */
    public function __construct(Obj $object)
    {
        $this->object = $object;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if ($this->isset($key)) {
            $value = $this->getAttribute($key);

            return $this->hasMutator('get', $key) ? $this->mutateAttribute('get', $key, $value) : $value;
        }
        throw new InvalidArgumentException(sprintf('Undefined property "%s" in %s', $key, get_class($this->object)));
    }


    /**
     * @param string $key
     * @param $value
     * @return \AmoPRO\AmoCRM\Data\Obj|mixed
     */
    public function set(string $key, $value)
    {
        if ($this->hasMutator('set', $key)) {
            return $this->mutateAttribute('set', $key, $value);
        }
        if (array_key_exists($key, $this->object->schema())) {
            return $this->castAttribute($key, $value);
        }

        return $this->object;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isset(string $key)
    {
        return array_key_exists($key, $this->object->schema()) ||
            $this->hasMutator('get', $key) ||
            $this->hasMutator('set', $key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function getAttribute(string $key)
    {
        return (function (string $key) {
            return $this->attributes[$key] ?? null;
        })->call($this->object, $key);
    }

    /**
     * @param string $key
     * @param $value
     * @return \AmoPRO\AmoCRM\Data\Obj
     * @noinspection PhpUndefinedFieldInspection
     */
    private function setAttribute(string $key, $value)
    {
        (function (string $key, $value) {
            $this->attributes[$key] = $value;
        })->call($this->object, $key, $value);

        return $this->object;
    }

    /**
     * @param string $type
     * @param string $key
     * @return bool
     */
    private function hasMutator(string $type, string $key): bool
    {
        if ($type !== 'get' && $type !== 'set') {
            throw new InvalidArgumentException('Mutator must be "get" or "set"');
        }

        return method_exists($this->object, $type . Str::studly($key) . 'Attribute');
    }

    /**
     * @param string $type
     * @param string $key
     * @param $value
     * @return mixed
     */
    private function mutateAttribute(string $type, string $key, $value)
    {
        return (function ($type, $key, $value) {
            return $this->{$type . Str::studly($key) . 'Attribute'}($value);
        })->call($this->object, $type, $key, $value);
    }

    /**
     * @param string $key
     * @param $value
     * @return \AmoPRO\AmoCRM\Data\Obj
     */
    public function castAttribute(string $key, $value)
    {
        $type = Arr::get($this->object->schema(), $key);
        switch (true) {
            case $type === self::TYPE_RAW || is_null($value):
                return $this->setAttribute($key, $value);
            case $type === self::TYPE_INT:
                if (!is_numeric($value)) {
                    throw new InvalidArgumentException(sprintf('Attribute "%s" must be numeric', $key));
                }

                return $this->setAttribute($key, (int)$value);
            case $type === self::TYPE_ARRAY_INT:
                if (!is_array($value)) {
                    throw new InvalidArgumentException(sprintf('Attribute "%s" must be an array of numeric', $key));
                }

                return $this->setAttribute($key, array_map(function ($val) use ($key) {
                    if (!is_numeric($val)) {
                        throw new InvalidArgumentException(sprintf('Attribute "%s" must be an array of numeric values', $key));
                    }

                    return (int)$val;
                }, $value));
            case $type === self::TYPE_STRING:
                return $this->setAttribute($key, (string)$value);
            case $type === self::TYPE_BOOL:
                return $this->setAttribute($key, (bool)$value);
            case $type === self::TYPE_TIMESTAMP:
                return $this->setAttribute($key, $this->castTimestamp($value));
            case class_exists($type):
                $parents = class_parents($type);
                if (array_key_exists(Obj::class, $parents) || array_key_exists(Collection::class, $parents)) {
                    return $this->setAttribute($key, new $type((array)$value));
                }
                if (array_key_exists(Enum::class, $parents)) {
                    return $this->setAttribute($key, new $type($value));
                }
        }

        throw new InvalidArgumentException(sprintf('Undefined type "%s"', $type));
    }

    /**
     * @param $value
     * @return \Carbon\Carbon|int
     */
    private function castTimestamp($value)
    {
        if ($value instanceof DateTimeInterface) {
            return Carbon::createFromTimestamp($value->getTimestamp());
        }

        if (is_numeric($value)) {
            return $value == 0 ? 0 : Carbon::createFromTimestamp($value);
        }

        return 0;
    }
}