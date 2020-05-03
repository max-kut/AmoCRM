<?php

namespace AmoPRO\AmoCRM\Query\Params;

trait HasResponsibleUserParam
{
    /**
     * Дополнительный фильтр поиска, по ответственному пользователю
     *
     * @param int ...$responsible_user_id
     * @return static
     */
    public function responsible(int ...$responsible_user_id)
    {
        $this->params['responsible_user_id'] = array_filter($responsible_user_id);

        return $this;
    }
}