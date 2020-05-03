<?php

namespace AmoPRO\AmoCRM\Query\With;

trait HasIsPriceModifiedByRobot
{
    /**
     * Вернёт информацию в соответствующем поле сделок/покупателей, было ли изменено поле бюджет пользователем роботом (user_id = 0)
     *
     * @param bool $yes
     * @return static
     */
    public function isPriceModifiedByRobot(bool $yes = true)
    {
        $this->attributes['is_price_modified_by_robot'] = $yes;

        return $this;
    }
}