<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class PipelinesRightsCollection extends Collection
{
    public function getNestedClassName(): string
    {
        return StatusesRightsCollection::class;
    }
}