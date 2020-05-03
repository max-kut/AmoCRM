<?php

namespace AmoPRO\AmoCRM\Models\Tag;

use AmoPRO\AmoCRM\Data\Collection;
use AmoPRO\AmoCRM\Models\SeparatableOfCommas;
use AmoPRO\AmoCRM\Support\Arr;

final class TagsCollection extends Collection implements SeparatableOfCommas
{
    public function getNestedClassName(): string
    {
        return Tag::class;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return implode(',', Arr::pluck($this->all(), 'name', []));
    }
}