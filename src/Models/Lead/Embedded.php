<?php

namespace AmoPRO\AmoCRM\Models\Lead;

use AmoPRO\AmoCRM\Data\Obj;
use AmoPRO\AmoCRM\Models\Catalog\CatalogElementsLinks;

/**
 * @property-read \AmoPRO\AmoCRM\Models\Catalog\CatalogElementsLinks $catalog_elements_links
 */
final class Embedded extends Obj
{
    public function schema(): array
    {
        return [
            'catalog_elements_links' => CatalogElementsLinks::class
        ];
    }
}