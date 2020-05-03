<?php

namespace AmoPRO\AmoCRM\Models\Lead;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property int[] $contacts_id
 * @property int $company_id
 */
final class Unlink extends Obj
{
    public function schema(): array
    {
        return [
            'contacts_id' => Attribute::TYPE_ARRAY_INT,
            'company_id'  => Attribute::TYPE_INT
        ];
    }
}