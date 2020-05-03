<?php

namespace AmoPRO\AmoCRM\Query\With;

trait HasLossReasonName
{
    /**
     * Вернёт помимо id, название причины отказа
     *
     * @param bool $yes
     * @return static
     */
    public function lossReasonName(bool $yes = true)
    {
        $this->attributes['loss_reason_name'] = $yes;

        return $this;
    }
}