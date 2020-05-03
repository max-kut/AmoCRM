<?php

namespace AmoPRO\AmoCRM\Models\CustomField;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property int $id
 * @property string $name
 * @property \AmoPRO\AmoCRM\Models\CustomField\Values|\AmoPRO\AmoCRM\Models\CustomField\Value[] $values
 * @property-read bool $is_system
 */
final class CustomField extends Obj
{
    public function schema(): array
    {
        return [
            'id'        => Attribute::TYPE_INT,
            'name'      => Attribute::TYPE_STRING,
            'values'    => Values::class,
            'is_system' => Attribute::TYPE_BOOL
        ];
    }
}