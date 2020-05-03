<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * Class DatePattern
 *
 * @property-read string $date
 * @property-read string $time
 * @property-read string $date_time
 * @property-read string $time_full
 */
final class DatePattern extends Obj
{
    public function schema(): array
    {
        return [
            'date'      => Attribute::TYPE_STRING,
            'time'      => Attribute::TYPE_STRING,
            'date_time' => Attribute::TYPE_STRING,
            'time_full' => Attribute::TYPE_STRING,
        ];
    }
}