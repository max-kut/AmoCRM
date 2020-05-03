<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read int $sort
 * @property-read bool $is_main
 * @property-read \AmoPRO\AmoCRM\Models\Account\StatusesCollection $statuses
 */
final class Pipeline extends Obj
{
    public function schema(): array
    {
        return [
            'id'       => Attribute::TYPE_INT,
            'name'     => Attribute::TYPE_STRING,
            'sort'     => Attribute::TYPE_INT,
            'is_main'  => Attribute::TYPE_BOOL,
            'statuses' => StatusesCollection::class,
        ];
    }
}