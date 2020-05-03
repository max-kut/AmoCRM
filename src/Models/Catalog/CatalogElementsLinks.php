<?php

namespace AmoPRO\AmoCRM\Models\Catalog;

use AmoPRO\AmoCRM\Data\Collection;

final class CatalogElementsLinks extends Collection
{
    public function getNestedClassName(): string
    {
        return CatalogElementLink::class;
    }
}