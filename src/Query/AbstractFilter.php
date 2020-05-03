<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Contracts\Arrayable;

abstract class AbstractFilter implements Arrayable
{
    protected $params = [];

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter($this->params);
    }
}