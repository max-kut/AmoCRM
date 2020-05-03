<?php

namespace AmoPRO\AmoCRM\Models\Getters;

trait HasCustomersIdGetter
{
    /**
     * @return array
     */
    private function getCustomersIdAttribute(): array
    {
        /** @var \AmoPRO\AmoCRM\Models\Simple\Customers|null $customers */
        if($customers = $this->customers){
            return $customers->id;
        }

        return [];
    }
}