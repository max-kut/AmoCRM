<?php

namespace AmoPRO\AmoCRM\Models\CustomField;

use AmoPRO\AmoCRM\Data\Collection;

final class CustomFieldsCollection extends Collection
{
    public function getNestedClassName(): string
    {
        return CustomField::class;
    }
}