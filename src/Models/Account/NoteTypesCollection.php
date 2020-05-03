<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Collection;

final class NoteTypesCollection extends Collection
{
    function getNestedClassName(): string
    {
        return NoteType::class;
    }
}