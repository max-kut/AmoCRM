<?php

namespace AmoPRO\AmoCRM\Models\Catalog;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property int[] $id
 */
final class CatalogElements extends Obj
{
    public function schema(): array
    {
        return [
            'id' => Attribute::TYPE_ARRAY_INT
        ];
    }
}