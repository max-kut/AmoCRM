<?php

namespace AmoPRO\AmoCRM\Models;

use AmoPRO\AmoCRM\Data\Obj;

abstract class BaseModel extends Obj implements CanAddOrUpdate
{
    use FormattableEntityToRequest;

    /**
     * @return array|string[]
     */
    public function requiredAttributesForAdd(): array
    {
        return ['name'];
    }

    /**
     * @return array|string[]
     */
    public function requiredAttributesForUpdate(): array
    {
        return ['id', 'updated_at'];
    }
}