<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * Class TaskType
 *
 * @property-read int $id
 * @property-read string $name
 * @property-read string $color
 * @property-read int $icon_id
 */
final class TaskType extends Obj
{
    public function schema(): array
    {
        return [
            "id"      => Attribute::TYPE_INT,
            "name"    => Attribute::TYPE_STRING,
            "color"   => Attribute::TYPE_STRING,
            "icon_id" => Attribute::TYPE_INT,
        ];
    }
}