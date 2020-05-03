<?php

namespace AmoPRO\AmoCRM\Models\CustomField;

use AmoPRO\AmoCRM\Data\Collection;

final class Values extends Collection
{
    public function getNestedClassName(): string
    {
        return Value::class;
    }
}