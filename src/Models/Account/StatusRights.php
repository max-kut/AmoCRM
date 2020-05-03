<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $view
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $edit
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $delete
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $export
 */
final class StatusRights extends Obj
{
    public function schema(): array
    {
        return [
            'view' => Right::class,
            'edit' => Right::class,
            'delete' => Right::class,
            'export' => Right::class,
        ];
    }
}