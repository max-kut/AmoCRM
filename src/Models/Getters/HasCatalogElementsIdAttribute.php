<?php

namespace AmoPRO\AmoCRM\Models\Getters;

use AmoPRO\AmoCRM\Exceptions\ValidationException;

trait HasCatalogElementsIdAttribute
{
    /**
     * @return array|null
     */
    private function getCatalogElementsIdAttribute(): ?array
    {
        return $this->attributes['catalog_elements_id'] ?? [];
    }

    /**
     * @param array $catalogElementsId
     * @noinspection PhpUnusedPrivateMethodInspection
     */
    private function setCatalogElementsIdAttribute(array $catalogElementsId)
    {
        $catalogIds = array_map(function ($catalogId) {
            if (!is_numeric($catalogId)) {
                throw new ValidationException('Catalog id must be a valid integer in ' . static::class);
            }

            return (int)$catalogId;
        }, array_keys($catalogElementsId));

        $this->attributes['catalog_elements_id'] = array_combine($catalogIds, array_map(function ($elements) {
            foreach ($elements as $elementId => $count) {
                if (!is_numeric($elementId)) {
                    throw new ValidationException('Catalog element id must be a valid integer in ' . static::class);
                }
                if (!is_numeric($count)) {
                    throw new ValidationException('Catalog element quantity must be a valid number in ' . static::class);
                }

                $elements[(int)$elementId] = $count;
            }

            return $elements;
        }, $catalogElementsId));
    }
}