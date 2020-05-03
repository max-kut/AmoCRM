<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class StatusesCollection extends Collection
{
    function getNestedClassName(): string
    {
        return Status::class;
    }
}