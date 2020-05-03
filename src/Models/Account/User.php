<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read int $id
 * @property-read int $group_id
 * @property-read string $name
 * @property-read string $last_name
 * @property-read string $login
 * @property-read string $language
 * @property-read string $phone_number
 * @property-read bool $is_active
 * @property-read bool $is_free
 * @property-read bool $is_admin
 * @property-read \AmoPRO\AmoCRM\Models\Account\Rights $rights
 */
final class User extends Obj
{
    public function schema(): array
    {
        return [
            'id'           => Attribute::TYPE_INT,
            'name'         => Attribute::TYPE_STRING,
            'last_name'    => Attribute::TYPE_STRING,
            'login'        => Attribute::TYPE_STRING,
            'language'     => Attribute::TYPE_STRING,
            'phone_number' => Attribute::TYPE_STRING,
            'group_id'     => Attribute::TYPE_INT,
            'is_active'    => Attribute::TYPE_BOOL,
            'is_free'      => Attribute::TYPE_BOOL,
            'is_admin'     => Attribute::TYPE_BOOL,
            'rights'       => Rights::class
        ];
    }
}