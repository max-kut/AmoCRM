<?php

namespace AmoPRO\AmoCRM\Models\Customer;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;
use AmoPRO\AmoCRM\Models\Catalog\CatalogElements;
use AmoPRO\AmoCRM\Models\Company\Company;
use AmoPRO\AmoCRM\Models\Contact\Contact;
use AmoPRO\AmoCRM\Models\CustomField\CustomFieldsCollection;
use AmoPRO\AmoCRM\Models\FormattableEntityToRequest;
use AmoPRO\AmoCRM\Models\Getters\HasCatalogElementsIdAttribute;
use AmoPRO\AmoCRM\Models\Getters\HasCompanyIdGetter;
use AmoPRO\AmoCRM\Models\Getters\HasContactsIdGetter;
use AmoPRO\AmoCRM\Models\Simple\Contacts;
use AmoPRO\AmoCRM\Models\Tag\TagsCollection;

/**
 * @property int $id
 * @property string $name Название покупателя
 * @property int $responsible_user_id id пользователя ответственного за покупателя
 * @property int $created_by кем создан
 * @property int $updated_by кем обновлен
 * @property \DateTimeInterface $created_at Дата и время создания покупателя
 * @property \DateTimeInterface $updated_at Дата и время изменения покупателя
 * @property-read int $account_id
 * @property int $status_id
 * @property-read bool $is_deleted
 * @property-read \AmoPRO\AmoCRM\Models\Contact\Contact $main_contact
 * @property \AmoPRO\AmoCRM\Models\Tag\TagsCollection $tags
 * @property \AmoPRO\AmoCRM\Models\CustomField\CustomFieldsCollection $custom_fields
 * @property \AmoPRO\AmoCRM\Models\Simple\Contacts $contacts
 * @property \AmoPRO\AmoCRM\Models\Company\Company $company
 * @property \AmoPRO\AmoCRM\Models\Catalog\CatalogElements $catalog_elements
 * @property int|\DateTimeInterface $closest_task_at
 * @property int $next_price Ожидаемая сумма
 * @property int $periodicity Периодичность совершаемых покупок
 * @property int $period_id id периода цифровой воронки покупателя
 * @property int|\DateTimeInterface $next_date Дата и время следующей покупки
 * @property-read mixed $ltv - недокументированноый параметр
 * @property-read mixed $purchases_count - недокументированноый параметр
 * @property-read mixed $average_check - недокументированноый параметр
 * @property \AmoPRO\AmoCRM\Models\Customer\Unlink $unlink
 * @property bool $_delete - атрибут для пометки покупателя для удаления
 */
final class Customer extends Obj
{
    use HasCatalogElementsIdAttribute;
    use HasContactsIdGetter;
    use HasCompanyIdGetter;
    use FormattableEntityToRequest;

    public function schema(): array
    {
        return [
            'id'                  => Attribute::TYPE_INT,
            'name'                => Attribute::TYPE_STRING,
            'responsible_user_id' => Attribute::TYPE_INT,
            'created_by'          => Attribute::TYPE_INT,
            'updated_by'          => Attribute::TYPE_INT,
            'created_at'          => Attribute::TYPE_TIMESTAMP,
            'updated_at'          => Attribute::TYPE_TIMESTAMP,
            'account_id'          => Attribute::TYPE_INT,
            'status_id'           => Attribute::TYPE_INT,
            'is_deleted'          => Attribute::TYPE_BOOL,
            'main_contact'        => Contact::class,
            'tags'                => TagsCollection::class,
            'custom_fields'       => CustomFieldsCollection::class,
            'contacts'            => Contacts::class,
            'company'             => Company::class,
            'catalog_elements'    => CatalogElements::class,
            'closest_task_at'     => Attribute::TYPE_TIMESTAMP,
            'next_price'          => Attribute::TYPE_INT,
            'periodicity'         => Attribute::TYPE_INT,
            'period_id'           => Attribute::TYPE_INT,
            'next_date'           => Attribute::TYPE_TIMESTAMP,
            'ltv'                 => Attribute::TYPE_RAW,
            'purchases_count'     => Attribute::TYPE_RAW,
            'average_check'       => Attribute::TYPE_RAW,
            'unlink'              => Unlink::class,
            '_delete'             => Attribute::TYPE_BOOL
        ];
    }

    public function toRequest()
    {
        $availableKeys = [
            'id', 'name', 'created_at', 'updated_at', 'created_by', 'next_date', 'next_price', 'responsible_user_id',
            'periodicity', 'period_id', 'tags', 'contacts_id', 'company_id', 'custom_fields', 'catalog_elements_id',
            'unlink'
        ];

        /**
         * @uses \AmoPRO\AmoCRM\Models\Customer\Customer::getContactsIdAttribute()
         * @uses \AmoPRO\AmoCRM\Models\Customer\Customer::getCompanyIdAttribute()
         * @uses \AmoPRO\AmoCRM\Models\Customer\Customer::getCatalogElementsIdAttribute()
         */
        return $this->getAttributesForRequest($availableKeys);
    }
}