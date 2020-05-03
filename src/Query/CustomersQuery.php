<?php

namespace AmoPRO\AmoCRM\Query;

final class CustomersQuery extends AbstractEntityQuery
{
    /**
     * @param \AmoPRO\AmoCRM\Query\CustomersWith $with
     * @return static
     */
    public function with(CustomersWith $with)
    {
        $this->params['with'] = (string)$with;

        return $this;
    }

    /**
     * @param \AmoPRO\AmoCRM\Query\CustomersFilter $filter
     * @return static
     */
    public function filter(CustomersFilter $filter)
    {
        $this->params['filter'] = $filter->toArray();

        return $this;
    }
}