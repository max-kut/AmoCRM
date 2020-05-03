<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Enum;

/**
 * @method static static ACCESS()
 * @method static static RESPONSIBLE()
 * @method static static DISABLED()
 * @method static static GROUP()
 */
final class Right extends Enum
{
    public static function values(): array
    {
        return [
            'ACCESS'      => 'A',
            'RESPONSIBLE' => 'M',
            'DISABLED'    => 'D',
            'GROUP'       => 'G'
        ];
    }
}