<?php

namespace AmoPRO\AmoCRM\Models\Simple;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property int[] $id
 */
final class Leads extends Obj
{
    public function schema(): array
    {
        return [
            'id' => Attribute::TYPE_ARRAY_INT
        ];
    }
}