<?php

namespace AmoPRO\AmoCRM\Query\Filters;

use AmoPRO\AmoCRM\Contracts\Arrayable;
use DateTimeInterface;

final class DatesFilter implements Arrayable
{
    protected $attributes = [
        'type' => null,
        'from' => null,
        'to'   => null
    ];

    /**
     * DatesFilter constructor.
     *
     * @param \DateTimeInterface|null $from
     * @param \DateTimeInterface|null $to
     * @param \AmoPRO\AmoCRM\Query\Filters\DateFilterType|null $type
     */
    public function __construct(?DateTimeInterface $from = null, ?DateTimeInterface $to = null, ?DateFilterType $type = null)
    {
        $this->attributes = [
            'from' => $from,
            'to'   => $to,
            'type' => $type,
        ];
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->attributes['from']) && empty($this->attributes['to']);
    }

    /**
     * @return bool
     */
    public function hasType(): bool
    {
        return !empty($this->attributes['type']);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter(array_map(function ($filter) {
            if ($filter instanceof DateTimeInterface) {
                return $filter->format('Y-m-d H:i:s');
            }
            if ($filter instanceof DateFilterType) {
                return $filter->getValue();
            }

            return null;
        }, $this->attributes));
    }
}