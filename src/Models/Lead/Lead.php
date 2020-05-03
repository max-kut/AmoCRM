<?php

namespace AmoPRO\AmoCRM\Models\Lead;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Models\BaseModel;
use AmoPRO\AmoCRM\Models\Catalog\CatalogElements;
use AmoPRO\AmoCRM\Models\Company\Company;
use AmoPRO\AmoCRM\Models\Contact\Contact;
use AmoPRO\AmoCRM\Models\CustomField\CustomFieldsCollection;
use AmoPRO\AmoCRM\Models\Getters\HasCatalogElementsIdAttribute;
use AmoPRO\AmoCRM\Models\Getters\HasCompanyIdGetter;
use AmoPRO\AmoCRM\Models\Getters\HasContactsIdGetter;
use AmoPRO\AmoCRM\Models\Tag\TagsCollection;

/**
 * @property int $id
 * @property string $name
 * @property int $responsible_user_id
 * @property int $created_by
 * @property int $updated_by
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 * @property-read int $account_id
 * @property int $pipeline_id
 * @property int $status_id
 * @property-read bool $is_deleted
 * @property-read \AmoPRO\AmoCRM\Models\Contact\Contact $main_contact
 * @property-read int[] $contacts_id
 * @property \AmoPRO\AmoCRM\Models\Lead\Contacts $contacts
 * @property \AmoPRO\AmoCRM\Models\Tag\TagsCollection $tags
 * @property \AmoPRO\AmoCRM\Models\CustomField\CustomFieldsCollection $custom_fields
 * @property-read int $group_id
 * @property-read int $loss_reason_id 0 или идентификатор причины отказа (только для неуспешно закрытых сделлок)
 * @property-read string $loss_reason_name имя причины отказа (только для неуспешно закрытых сделок и если передан
 *     параметр with=loss_reason_name @see \AmoPRO\AmoCRM\Query\LeadsWith::lossReasonName()
 * @property \AmoPRO\AmoCRM\Models\Company\Company $company
 * @property \AmoPRO\AmoCRM\Models\Catalog\CatalogElements $catalog_elements
 * @property array|null $catalog_elements_id
 * @property-read \AmoPRO\AmoCRM\Models\Lead\Embedded $_embedded
 */
final class Lead extends BaseModel
{
    use HasCompanyIdGetter;
    use HasContactsIdGetter;
    use HasCatalogElementsIdAttribute;

    public function schema(): array
    {
        return [
            'id'                         => Attribute::TYPE_INT,
            'name'                       => Attribute::TYPE_STRING,
            'responsible_user_id'        => Attribute::TYPE_INT,
            'created_by'                 => Attribute::TYPE_INT,
            'updated_by'                 => Attribute::TYPE_INT,
            'created_at'                 => Attribute::TYPE_TIMESTAMP,
            'updated_at'                 => Attribute::TYPE_TIMESTAMP,
            'account_id'                 => Attribute::TYPE_INT,
            'pipeline_id'                => Attribute::TYPE_INT,
            'status_id'                  => Attribute::TYPE_INT,
            'is_deleted'                 => Attribute::TYPE_BOOL,
            'main_contact'               => Contact::class,
            'contacts'                   => Contacts::class,
            'custom_fields'              => CustomFieldsCollection::class,
            'tags'                       => TagsCollection::class,
            'group_id'                   => Attribute::TYPE_INT,
            'company'                    => Company::class,
            'closed_at'                  => Attribute::TYPE_TIMESTAMP,
            'closest_task_at'            => Attribute::TYPE_TIMESTAMP,
            'is_price_modified_by_robot' => Attribute::TYPE_BOOL,
            'sale'                       => Attribute::TYPE_INT,
            'unlink'                     => Unlink::class,
            'catalog_elements'           => CatalogElements::class,
            'loss_reason_id'             => Attribute::TYPE_INT,
            'loss_reason_name'           => Attribute::TYPE_STRING,
            '_embedded'                  => Embedded::class,
        ];
    }

    /**
     * @return array
     */
    public function toRequest(): array
    {
        $availableKeys = [
            'id', 'name', 'created_at', 'updated_at', 'status_id', 'pipeline_id', 'responsible_user_id', 'sale',
            'contacts_id', 'company_id', 'tags', 'custom_fields', 'catalog_elements_id', 'unlink'
        ];

        /**
         * @uses \AmoPRO\AmoCRM\Models\Lead\Lead::getCompanyIdAttribute()
         * @uses \AmoPRO\AmoCRM\Models\Lead\Lead::getContactsIdAttribute()
         * @uses \AmoPRO\AmoCRM\Models\Lead\Lead::getCatalogElementsIdAttribute()
         */
        return $this->getAttributesForRequest($availableKeys);
    }
}