<?php

namespace AmoPRO\AmoCRM\Models\Getters;

trait HasContactsIdGetter
{
    /**
     * @return array
     */
    private function getContactsIdAttribute(): array
    {
        /** @var \AmoPRO\AmoCRM\Models\Lead\Contacts|\AmoPRO\AmoCRM\Models\Simple\Contacts|null $contacts */
        if($contacts = $this->contacts){
            return $contacts->id;
        }

        return [];
    }
}