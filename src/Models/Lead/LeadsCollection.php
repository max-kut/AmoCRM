<?php

namespace AmoPRO\AmoCRM\Models\Lead;

use AmoPRO\AmoCRM\Data\Collection;
use AmoPRO\AmoCRM\Models\FormattableToRequest;
use AmoPRO\AmoCRM\Models\HasErrorsInCollection;

final class LeadsCollection extends Collection
{
    use HasErrorsInCollection;
    use FormattableToRequest;

    public function getNestedClassName(): string
    {
        return Lead::class;
    }
}