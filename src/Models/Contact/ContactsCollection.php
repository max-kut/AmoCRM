<?php

namespace AmoPRO\AmoCRM\Models\Contact;

use AmoPRO\AmoCRM\Data\Collection;
use AmoPRO\AmoCRM\Models\FormattableToRequest;
use AmoPRO\AmoCRM\Models\HasErrorsInCollection;

final class ContactsCollection extends Collection
{
    use HasErrorsInCollection;
    use FormattableToRequest;

    public function getNestedClassName(): string
    {
        return Contact::class;
    }
}