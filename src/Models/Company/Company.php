<?php

namespace AmoPRO\AmoCRM\Models\Company;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Models\BaseModel;
use AmoPRO\AmoCRM\Models\CustomField\CustomFieldsCollection;
use AmoPRO\AmoCRM\Models\Getters\HasContactsIdGetter;
use AmoPRO\AmoCRM\Models\Getters\HasCustomersIdGetter;
use AmoPRO\AmoCRM\Models\Getters\HasLeadsIdGetter;
use AmoPRO\AmoCRM\Models\Simple\Contacts;
use AmoPRO\AmoCRM\Models\Simple\Customers;
use AmoPRO\AmoCRM\Models\Simple\Leads;
use AmoPRO\AmoCRM\Models\Tag\TagsCollection;

/**
 * @property int $id
 * @property string $name
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 * @property int $responsible_user_id
 * @property int $created_by
 * @property int $updated_by
 * @property int $group_id
 * @property-read int $account_id
 * @property-read int|\DateTimeInterface $closest_task_at
 * @property \AmoPRO\AmoCRM\Models\CustomField\CustomFieldsCollection $custom_fields
 * @property \AmoPRO\AmoCRM\Models\Tag\TagsCollection $tags
 * @property \AmoPRO\AmoCRM\Models\Simple\Leads $leads
 * @property \AmoPRO\AmoCRM\Models\Simple\Contacts $contacts
 * @property \AmoPRO\AmoCRM\Models\Simple\Customers $customers
 * @property \AmoPRO\AmoCRM\Models\Company\Unlink $unlink
 * @property-read int[] $leads_id
 * @property-read int[] $customers_id
 * @property-read int[] $contacts_id
 */
final class Company extends BaseModel
{
    use HasLeadsIdGetter;
    use HasCustomersIdGetter;
    use HasContactsIdGetter;

    public function schema(): array
    {
        return [
            'id'                  => Attribute::TYPE_INT,
            'name'                => Attribute::TYPE_STRING,
            'created_at'          => Attribute::TYPE_TIMESTAMP,
            'updated_at'          => Attribute::TYPE_TIMESTAMP,
            'responsible_user_id' => Attribute::TYPE_INT,
            'created_by'          => Attribute::TYPE_INT,
            'updated_by'          => Attribute::TYPE_INT,
            'group_id'            => Attribute::TYPE_INT,
            'account_id'          => Attribute::TYPE_INT,
            'closest_task_at'     => Attribute::TYPE_TIMESTAMP,
            'custom_fields'       => CustomFieldsCollection::class,
            'tags'                => TagsCollection::class,
            'leads'               => Leads::class,
            'contacts'            => Contacts::class,
            'customers'           => Customers::class,
            'unlink'              => Unlink::class
        ];
    }

    /**
     * @return array
     */
    public function toRequest(): array
    {
        $availableKeys = [
            'id', 'name', 'created_at', 'updated_at', 'responsible_user_id', 'created_by', 'tags',
            'leads_id', 'customers_id', 'contacts_id', 'custom_fields', 'unlink'
        ];

        /**
         * @uses \AmoPRO\AmoCRM\Models\Company\Company::getLeadsIdAttribute()
         * @uses \AmoPRO\AmoCRM\Models\Company\Company::getContactsIdAttribute()
         * @uses \AmoPRO\AmoCRM\Models\Company\Company::getCustomersIdAttribute()
         */

        return $this->getAttributesForRequest($availableKeys);
    }
}