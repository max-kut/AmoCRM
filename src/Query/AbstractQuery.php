<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Contracts\Arrayable;

abstract class AbstractQuery implements Arrayable
{
    protected $params = [];

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_filter($this->params);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return http_build_query($this->toArray());
    }
}