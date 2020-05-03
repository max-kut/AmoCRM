<?php

namespace AmoPRO\AmoCRM\Models;

interface CanAddOrUpdate
{
    /**
     * @return array
     */
    public function requiredAttributesForAdd(): array;

    /**
     * @return array
     */
    public function requiredAttributesForUpdate(): array;

    /**
     * @return array
     */
    public function toRequest(): array;
}