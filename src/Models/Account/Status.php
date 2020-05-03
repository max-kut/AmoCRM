<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $color
 * @property-read int $sort
 * @property-read bool $is_editable
 */
final class Status extends Obj
{
    public function schema(): array
    {
        return [
            'id'          => Attribute::TYPE_INT,
            'name'        => Attribute::TYPE_STRING,
            'color'       => Attribute::TYPE_STRING,
            'sort'        => Attribute::TYPE_INT,
            'is_editable' => Attribute::TYPE_BOOL,
        ];
    }
}