<?php

namespace AmoPRO\AmoCRM\Data;

use JsonSerializable;

abstract class Obj implements JsonSerializable
{
    /**
     * @var array
     */
    protected $attributes = [];
    /**
     * @var \AmoPRO\AmoCRM\Data\Attribute
     */
    private $attribute;

    /**
     * @return array
     * {
     *      "attribute": {
     *          "types": ["null","int","string","datetime","ClassName"],
     *          "writable": true,
     *      }
     * }
     */
    abstract public function schema(): array;

    /**
     * Obj constructor.
     *
     * @param array|static $attributes
     */
    public function __construct($attributes = [])
    {
        $this->attribute = new Attribute($this);

        foreach ($this->prepareAttributes($attributes) as $key => $attribute) {
            $this->__set($key, $attribute);
        }
    }

    private function prepareAttributes($attributes): array
    {
        if (is_string($attributes)) {
            return json_decode($attributes, true);
        }

        if($attributes instanceof self){
            return $attributes->jsonSerialize();
        }

        return (array)$attributes;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function make(array $attributes = [])
    {
        return new static($attributes);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->attribute->get($name);
    }

    /**
     * @param $name
     * @param $value
     * @return \AmoPRO\AmoCRM\Data\Obj|mixed
     */
    public function __set($name, $value)
    {
        return $this->attribute->set($name, $value);
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->attribute->isset($name);
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        unset($this->attributes[$name]);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return array_map(function($value){
            if($value instanceof JsonSerializable){
                return $value->jsonSerialize();
            }
            return $value;
        }, $this->attributes);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return static|mixed
     */
    protected function castAttribute(string $name, $value)
    {
        return $this->attribute->castAttribute($name, $value);
    }
}