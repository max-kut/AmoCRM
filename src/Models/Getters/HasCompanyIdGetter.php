<?php

namespace AmoPRO\AmoCRM\Models\Getters;

trait HasCompanyIdGetter
{
    /**
     * @return int|null
     */
    private function getCompanyIdAttribute(): ?int
    {
        if ($company = $this->company) {
            return $company->id;
        }

        return null;
    }
}