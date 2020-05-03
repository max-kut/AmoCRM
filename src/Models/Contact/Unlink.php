<?php

namespace AmoPRO\AmoCRM\Models\Contact;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property int[] $leads_id
 * @property int $company_id
 * @property int[] $customers_id
 */
final class Unlink extends Obj
{
    public function schema(): array
    {
        return [
            'leads_id'     => Attribute::TYPE_ARRAY_INT,
            'company_id'   => Attribute::TYPE_INT,
            'customers_id' => Attribute::TYPE_ARRAY_INT
        ];
    }
}