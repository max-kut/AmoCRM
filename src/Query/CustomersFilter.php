<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Query\Filters\DatesFilter;
use InvalidArgumentException;

final class CustomersFilter extends AbstractFilter
{
    /**
     * @param int ...$id
     * @return static
     */
    public function mainUser(int ...$id)
    {
        $this->params['main_user'] = array_filter($id);

        return $this;
    }

    /**
     * @param \AmoPRO\AmoCRM\Query\Filters\DatesFilter $filter
     * @return static
     */
    public function date(DatesFilter $filter)
    {
        if ($filter->isEmpty()) {
            throw new InvalidArgumentException('Filter "date" must be not empty from or to dates');
        }
        if (!$filter->hasType()) {
            throw new InvalidArgumentException('Filter "date" must be with type');
        }
        $this->params['date'] = $filter->toArray();

        return $this;
    }

    /**
     * @param \AmoPRO\AmoCRM\Query\Filters\DatesFilter $filter
     * @return static
     */
    public function nextDate(DatesFilter $filter)
    {
        if ($filter->isEmpty()) {
            throw new InvalidArgumentException('Filter "date" must be not empty from or to dates');
        }

        $this->params['next_date'] = $filter->toArray();

        return $this;
    }
}