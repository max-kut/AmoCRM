<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class TaskTypesCollection extends Collection
{

    /**
     * @inheritDoc
     */
    function getNestedClassName(): string
    {
        return TaskType::class;
    }
}