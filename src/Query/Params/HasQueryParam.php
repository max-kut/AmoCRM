<?php

namespace AmoPRO\AmoCRM\Query\Params;

trait HasQueryParam
{
    /**
     * Поисковый запрос (Осуществляет поиск по заполненым полям сущности)
     *
     * @param string $query
     * @return static
     */
    public function query(string $query)
    {
        $this->params['query'] = $query;

        return $this;
    }
}