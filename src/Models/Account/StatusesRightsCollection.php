<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class StatusesRightsCollection extends Collection
{
    public function getNestedClassName(): string
    {
        return StatusRights::class;
    }
}