<?php

namespace AmoPRO\AmoCRM\Data;

use InvalidArgumentException;

abstract class Enum
{
    /**
     * @return array associative values
     */
    abstract public static function values(): array;

    protected $value;

    /**
     * Enum constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        if($value instanceof self){
            $this->value = $value->getValue();
        } else {
            if (!in_array($value, static::values())) {
                throw new InvalidArgumentException(sprintf('undefined enum value "%s" in %s', $value, static::class));
            }

            $this->value = $value;
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return \AmoPRO\AmoCRM\Data\Enum
     */
    public static function __callStatic($name, $arguments): Enum
    {
        if (array_key_exists($name, static::values())) {
            return new static(static::values()[$name]);
        }

        throw new InvalidArgumentException(sprintf('undefined enum "%s" in %s', $name, static::class));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param \AmoPRO\AmoCRM\Data\Enum $enum
     * @return bool
     */
    public function sameAs(self $enum): bool
    {
        return $this->value === $enum->getValue();
    }
}