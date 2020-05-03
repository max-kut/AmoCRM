<?php

namespace AmoPRO\AmoCRM\Models\Catalog;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read int $id
 * @property-read int $catalog_id
 * @property-read int $quantity
 */
class CatalogElementLink extends Obj
{
    public function schema(): array
    {
        return [
            'id'         => Attribute::TYPE_INT,
            'catalog_id' => Attribute::TYPE_INT,
            'quantity'   => Attribute::TYPE_INT,
        ];
    }
}