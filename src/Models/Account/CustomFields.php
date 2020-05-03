<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Obj;

/**
 * Class CustomFields
 *
 * @property-read \AmoPRO\AmoCRM\Models\Account\CustomFieldsCollection $contacts
 * @property-read \AmoPRO\AmoCRM\Models\Account\CustomFieldsCollection $leads
 * @property-read \AmoPRO\AmoCRM\Models\Account\CustomFieldsCollection $companies
 * @property-read \AmoPRO\AmoCRM\Models\Account\CustomFieldsCollection $customers
 */
final class CustomFields extends Obj
{
    public function schema(): array
    {
        return [
            'contacts'  => CustomFieldsCollection::class,
            'leads'     => CustomFieldsCollection::class,
            'companies' => CustomFieldsCollection::class,
            'customers' => CustomFieldsCollection::class,
        ];
    }
}