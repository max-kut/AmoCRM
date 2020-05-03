<?php

namespace AmoPRO\AmoCRM\Models\Customer;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property int[] $contacts_id Массив id открепляемых контактов
 * @property int $company_id id открепляемой компании
 */
final class Unlink extends Obj
{
    public function schema(): array
    {
        return [
            'contacts_id' => Attribute::TYPE_ARRAY_INT,
            'company_id' => Attribute::TYPE_INT
        ];
    }
}