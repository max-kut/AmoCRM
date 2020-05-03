<?php

namespace AmoPRO\AmoCRM\Models\Lead;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;
use AmoPRO\AmoCRM\Exceptions\Models\TooManyContactsException;

/**
 * @property int[] $id
 */
final class Contacts extends Obj
{
    public function schema(): array
    {
        return [
            /** @uses \AmoPRO\AmoCRM\Models\Lead\Contacts::setIdAttribute() */
            'id' => Attribute::TYPE_ARRAY_INT
        ];
    }

    /**
     * @param array $value
     */
    private function setIdAttribute(array $value)
    {
        if (($countContacts = count($value)) > 40) {
            throw new TooManyContactsException('Too many contacts on lead: ' . $countContacts);
        }

        return $this->castAttribute('id', $value);
    }
}