<?php

namespace AmoPRO\AmoCRM\Models\Tag;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property int $id
 * @property string $name
 */
final class Tag extends Obj
{
    public function schema(): array
    {
        return [
            'id'   => Attribute::TYPE_INT,
            'name' => Attribute::TYPE_STRING
        ];
    }
}