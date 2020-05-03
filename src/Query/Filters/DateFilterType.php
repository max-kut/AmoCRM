<?php

namespace AmoPRO\AmoCRM\Query\Filters;

use AmoPRO\AmoCRM\Data\Enum;

/**
 * @method static static CREATE() Выбрать элемент по дате создания
 * @method static static MODIFY() Выбрать элемент по дате редактирования
 */
final class DateFilterType extends Enum
{
    public static function values(): array
    {
        return [
            'CREATE' => 'create',
            'MODIFY' => 'modify'
        ];
    }
}