<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read int $id
 * @property-read string $code
 * @property-read bool $is_editable
 */
final class NoteType extends Obj
{
    public function schema(): array
    {
        return [
            'id'          => Attribute::TYPE_INT,
            'code'        => Attribute::TYPE_STRING,
            'is_editable' => Attribute::TYPE_BOOL
        ];
    }
}