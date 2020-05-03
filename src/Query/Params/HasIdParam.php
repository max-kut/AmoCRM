<?php

namespace AmoPRO\AmoCRM\Query\Params;

trait HasIdParam
{
    /**
     * Выбрать элемент с заданным ID (Если указан этот параметр, все остальные игнорируются)
     *
     * @param null|int $id [, ...$id]
     * @return static
     */
    public function id(?int ...$id)
    {
        $this->params['id'] = array_filter($id);

        return $this;
    }
}