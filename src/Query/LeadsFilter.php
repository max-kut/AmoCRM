<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Query\Filters\DatesFilter;
use InvalidArgumentException;

/**
 * @link https://www.amocrm.ru/developers/content/api/leads
 */
final class LeadsFilter extends AbstractFilter
{
    /**
     * Выбрать сделки без задач – 1; Выбрать сделки с невыполенными задачами – 2
     *
     * @param int|null $value
     * @return static
     */
    public function tasks(?int $value)
    {
        if (is_null($value) || in_array($value, [1, 2])) {
            $this->params['tasks'] = $value;

            return $this;
        }

        throw new InvalidArgumentException('Wrong "tasks" filter param. must be null, 1 or 2');
    }

    /**
     * Выбрать все активные сделки – 1
     *
     * @param int|null $value
     * @return static
     */
    public function active(?int $value)
    {
        if (is_null($value) || $value == 1) {
            $this->params['active'] = $value;

            return $this;
        }

        throw new InvalidArgumentException('Wrong "active" filter param. must be null or 1');
    }


    /**
     * Выбрать сделки по дате создания
     *
     * @param \AmoPRO\AmoCRM\Query\Filters\DatesFilter|null ...$filters
     * @return static
     */
    public function dateCreate(?DatesFilter $filter, ?DatesFilter ...$filters)
    {
        $this->params['date_create'] = $this->formatDates($this->filterDates($filter, ...$filters));

        return $this;
    }

    /**
     * Выбрать сделки по дате изменения
     *
     * @param \AmoPRO\AmoCRM\Query\Filters\DatesFilter|null ...$filters
     * @return static
     */
    public function dateModify(?DatesFilter $filter, ?DatesFilter ...$filters)
    {
        $this->params['date_modify'] = $this->formatDates($this->filterDates($filter, ...$filters));

        return $this;
    }

    private function formatDates(DatesFilter ...$filters): array
    {
        return array_map(function(DatesFilter $filter){
            return $filter->toArray();
        }, $filters);
    }

    /**
     * @param \AmoPRO\AmoCRM\Query\Filters\DatesFilter|null ...$filters
     * @return array
     */
    private function filterDates(?DatesFilter ...$filters): array
    {
        return array_values(array_filter($filters, function (?DatesFilter $filter) {
            return !is_null($filter) && !$filter->isEmpty();
        }));
    }
}