<?php

namespace AmoPRO\AmoCRM\Query\Params;

trait HasLimitOffsetParam
{
    /**
     * Сдвиг выборки (с какой строки выбирать). Работает, только при условии, что limit_rows тоже указан
     *
     * @param int $limit_offset
     * @return static
     */
    public function limitOffset(int $limit_offset)
    {
        $this->params['limit_offset'] = $limit_offset;

        return $this;
    }
}