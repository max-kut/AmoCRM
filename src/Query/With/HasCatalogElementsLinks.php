<?php

namespace AmoPRO\AmoCRM\Query\With;

trait HasCatalogElementsLinks
{
    /**
     * Данный параметр добавит к сделке/покупателю информацию о связанных элементах каталогов
     * (id каталога, id элемента каталога, количество).
     *
     * @param bool $yes
     * @return static
     */
    public function catalogElementsLinks(bool $yes = true)
    {
        $this->attributes['catalog_elements_links'] = $yes;

        return $this;
    }
}