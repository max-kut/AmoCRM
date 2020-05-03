<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class CustomFieldsCollection extends Collection
{
    function getNestedClassName(): string
    {
        return CustomField::class;
    }
}