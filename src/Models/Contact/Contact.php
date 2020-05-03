<?php

namespace AmoPRO\AmoCRM\Models\Contact;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Models\BaseModel;
use AmoPRO\AmoCRM\Models\Company\Company;
use AmoPRO\AmoCRM\Models\CustomField\CustomFieldsCollection;
use AmoPRO\AmoCRM\Models\Getters\HasCompanyIdGetter;
use AmoPRO\AmoCRM\Models\Getters\HasCustomersIdGetter;
use AmoPRO\AmoCRM\Models\Getters\HasLeadsIdGetter;
use AmoPRO\AmoCRM\Models\Simple\Customers;
use AmoPRO\AmoCRM\Models\Simple\Leads;
use AmoPRO\AmoCRM\Models\Tag\TagsCollection;

/**
 * @property int $id
 * @property string $name
 * @property string $first_name
 * @property string $last_name
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 * @property int $responsible_user_id
 * @property int $created_by
 * @property int $updated_by
 * @property int $group_id
 * @property-read int $account_id
 * @property \AmoPRO\AmoCRM\Models\Company\Company $company
 * @property-read int $company_id
 * @property-read string $company_name
 * @property \AmoPRO\AmoCRM\Models\Tag\TagsCollection $tags
 * @property \AmoPRO\AmoCRM\Models\Simple\Leads $leads
 * @property-read int[] $leads_id
 * @property-read int|\DateTimeInterface $closest_task_at
 * @property \AmoPRO\AmoCRM\Models\CustomField\CustomFieldsCollection $custom_fields
 * @property \AmoPRO\AmoCRM\Models\Simple\Customers $customers
 * @property \AmoPRO\AmoCRM\Models\Contact\Unlink $unlink
 */
final class Contact extends BaseModel
{
    use HasLeadsIdGetter;
    use HasCustomersIdGetter;
    use HasCompanyIdGetter;

    public function schema(): array
    {
        return [
            'id'                  => Attribute::TYPE_INT,
            'name'                => Attribute::TYPE_STRING,
            'first_name'          => Attribute::TYPE_STRING,
            'last_name'           => Attribute::TYPE_STRING,
            'created_at'          => Attribute::TYPE_TIMESTAMP,
            'updated_at'          => Attribute::TYPE_TIMESTAMP,
            'responsible_user_id' => Attribute::TYPE_INT,
            'created_by'          => Attribute::TYPE_INT,
            'updated_by'          => Attribute::TYPE_INT,
            'group_id'            => Attribute::TYPE_INT,
            'account_id'          => Attribute::TYPE_INT,
            'company'             => Company::class,
            'tags'                => TagsCollection::class,
            'leads'               => Leads::class,
            'closest_task_at'     => Attribute::TYPE_TIMESTAMP,
            'custom_fields'       => CustomFieldsCollection::class,
            'customers'           => Customers::class,
            'unlink'              => Unlink::class,
        ];
    }

    /**
     * @return array
     */
    public function toRequest(): array
    {
        $availableKeys = [
            'id', 'name', 'first_name', 'last_name', 'created_at', 'updated_at',
            'responsible_user_id', 'created_by', 'leads_id', 'customers_id', 'unlink'
        ];

        /**
         * @uses \AmoPRO\AmoCRM\Models\Contact\Contact::getLeadsIdAttribute()
         * @uses \AmoPRO\AmoCRM\Models\Contact\Contact::getCustomersIdAttribute()
         */

        $attributes = $this->getAttributesForRequest($availableKeys);

        /** @uses \AmoPRO\AmoCRM\Models\Contact\Contact::getCompanyIdAttribute() */
        if ($companyId = $this->company_id) {
            $attributes['company_id'] = $companyId;
        } #
        /** @uses \AmoPRO\AmoCRM\Models\Contact\Contact::getCompanyNameAttribute() */
        else if ($companyName = $this->company_name) {
            $attributes['company_name'] = $companyName;
        }

        return $attributes;
    }

    /**
     * @return string|null
     */
    private function getCompanyNameAttribute(): ?string
    {
        if ($company = $this->company) {
            return $company->name;
        }

        return null;
    }
}