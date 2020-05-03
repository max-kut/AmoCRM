<?php

namespace AmoPRO\AmoCRM\Models\Company;

use AmoPRO\AmoCRM\Data\Collection;
use AmoPRO\AmoCRM\Models\FormattableToRequest;
use AmoPRO\AmoCRM\Models\HasErrorsInCollection;

final class CompaniesCollection extends Collection
{
    use HasErrorsInCollection;
    use FormattableToRequest;

    public function getNestedClassName(): string
    {
        return Company::class;
    }
}