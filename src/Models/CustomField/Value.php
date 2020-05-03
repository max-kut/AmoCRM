<?php

namespace AmoPRO\AmoCRM\Models\CustomField;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property mixed $value
 * @property int $enum идентифиакатор ENUM значения поля
 * @property string $subtype - only for address field type
 */
final class Value extends Obj
{
    public function schema(): array
    {
        return [
            'value'   => Attribute::TYPE_RAW,
            'enum'    => Attribute::TYPE_INT,
            'subtype' => Attribute::TYPE_STRING,
        ];
    }
}