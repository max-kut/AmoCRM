<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class UsersCollection extends Collection
{
    function getNestedClassName(): string
    {
        return User::class;
    }
}