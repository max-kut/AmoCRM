<?php

namespace AmoPRO\AmoCRM\Models;

use DateTimeInterface;
use JsonSerializable;

trait FormattableEntityToRequest
{
    /**
     * @param array $availableKeys
     * @return array
     */
    protected function getAttributesForRequest(array $availableKeys): array
    {
        $attributes = [];

        foreach ($availableKeys as $key) {
            $value = $this->__get($key);
            if (is_null($value)) {
                continue;
            }

            if($value instanceof DateTimeInterface){
                $attributes[$key] = $value->getTimestamp();
            } else if($value instanceof SeparatableOfCommas){
                $attributes[$key] = $value->toString();
            } else if($value instanceof JsonSerializable){
                $attributes[$key] = $value->jsonSerialize();
            } else {
                $attributes[$key] = $value;
            }
        }

        return $attributes;
    }
}