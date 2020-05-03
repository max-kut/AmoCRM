<?php

namespace AmoPRO\AmoCRM\Models\Getters;

trait HasLeadsIdGetter
{
    /**
     * @return array
     */
    private function getLeadsIdAttribute(): array
    {
        /** @var \AmoPRO\AmoCRM\Models\Simple\Leads|null $leads */
        if($leads = $this->leads){
            return $leads->id;
        }

        return [];
    }
}