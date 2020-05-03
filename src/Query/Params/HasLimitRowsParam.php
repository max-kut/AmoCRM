<?php

namespace AmoPRO\AmoCRM\Query\Params;

use InvalidArgumentException;

trait HasLimitRowsParam
{
    /**
     * Кол-во выбираемых строк (системное ограничение 500)
     *
     * @param int $limit_rows
     * @return static
     */
    public function limitRows(int $limit_rows)
    {
        if ($limit_rows > 500) {
            throw new InvalidArgumentException('Parameter "limit_rows" should not be more than 500 in ' . static::class);
        }
        $this->params['limit_rows'] = $limit_rows;

        return $this;
    }
}