<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;
use AmoPRO\AmoCRM\Models\CustomField\CFType;

/**
 * Class CustomField
 *
 * @property-read int $id id дополнительного поля
 * @property-read string $name Имя дополнительного поля
 * @property-read \AmoPRO\AmoCRM\Models\CustomField\CFType $field_type Тип дополнительного поля
 * @property-read int $sort Порядковый номер при отображении
 * @property-read string $code
 * @property-read bool $is_multiple Обозначение, отвечающие за то является ли доп. поле списком или нет
 * @property-read bool $is_system Является ли доп. поле системным
 * @property-read bool $is_editable Можно ли редактировать поле
 * @property-read bool $is_required
 * @property-read bool $is_deletable
 * @property-read bool $is_visible
 * @property-read array $params
 * @property-read array $enums
 */
final class CustomField extends Obj
{
    public function schema(): array
    {
        return [
            'id'           => Attribute::TYPE_INT,
            'name'         => Attribute::TYPE_STRING,
            'code'         => Attribute::TYPE_STRING,
            'field_type'   => CFType::class,
            'sort'         => Attribute::TYPE_INT,
            'is_multiple'  => Attribute::TYPE_BOOL,
            'is_system'    => Attribute::TYPE_BOOL,
            'is_editable'  => Attribute::TYPE_BOOL,
            'is_required'  => Attribute::TYPE_BOOL,
            'is_deletable' => Attribute::TYPE_BOOL,
            'is_visible'   => Attribute::TYPE_BOOL,
            'params'       => Attribute::TYPE_RAW,
            'enums'        => Attribute::TYPE_RAW,
        ];
    }
}