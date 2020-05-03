<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * Class Group
 *
 * @property-read int $id
 * @property-read string $name
 */
final class Group extends Obj
{
    public function schema(): array
    {
        return [
            'id'   => Attribute::TYPE_INT,
            'name' => Attribute::TYPE_STRING
        ];
    }
}