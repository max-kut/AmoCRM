<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read \AmoPRO\AmoCRM\Models\Account\PipelinesRightsCollection $leads
 */
final class RightsByStatus extends Obj
{
    public function schema(): array
    {
        return [
            'leads' => PipelinesRightsCollection::class
        ];
    }
}