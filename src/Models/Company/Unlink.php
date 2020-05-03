<?php

namespace AmoPRO\AmoCRM\Models\Company;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property int[] $contacts_id
 * @property int[] $leads_id
 * @property int[] $customers_id
 */
final class Unlink extends Obj
{
    public function schema(): array
    {
        return [
            'contacts_id'  => Attribute::TYPE_ARRAY_INT,
            'leads_id'     => Attribute::TYPE_ARRAY_INT,
            'customers_id' => Attribute::TYPE_ARRAY_INT,
        ];
    }
}