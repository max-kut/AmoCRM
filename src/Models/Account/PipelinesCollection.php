<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class PipelinesCollection extends Collection
{
    function getNestedClassName(): string
    {
        return Pipeline::class;
    }
}