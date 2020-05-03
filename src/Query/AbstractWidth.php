<?php

namespace AmoPRO\AmoCRM\Query;

abstract class AbstractWidth
{
    protected $attributes = [];

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(',', array_keys(array_filter($this->attributes)));
    }
}