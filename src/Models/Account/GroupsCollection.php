<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class GroupsCollection extends Collection
{
    function getNestedClassName(): string
    {
        return Group::class;
    }
}