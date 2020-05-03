<?php

namespace AmoPRO\AmoCRM\Models\CustomField;

use AmoPRO\AmoCRM\Data\Enum;

/**
 * @method static static TEXT() Обычное текстовое поле
 * @method static static NUMERIC() Текстовое поле с возможностью передавать только цифры
 * @method static static CHECKBOX() Поле обозначающее только наличие или отсутствие свойства (например: “да”/”нет”)
 * @method static static SELECT() Поле типа список с возможностью выбора одного элемента
 * @method static static MULTISELECT() Поле типа список c возможностью выбора нескольких элементов списка
 * @method static static DATE() Поле типа дата возвращает и принимает значения в формате (Y-m-d H:i:s)
 * @method static static URL() Обычное текстовое поле предназначенное для ввода URL адресов
 * @method static static MULTITEXT() Поле textarea содержащее большое количество текста
 * @method static static TEXTAREA() Поле textarea содержащее большое количество текста
 * @method static static RADIOBUTTON() Поле типа переключатель
 * @method static static STREETADDRESS() Короткое поле адрес
 * @method static static SMART_ADDRESS() Поле адрес (в интерфейсе является набором из нескольких полей)
 * @method static static BIRTHDAY() Поле типа дата поиск по которому осуществляется без учета года, значения в формате
 *     (Y-m-d H:i:s)
 * @method static static LEGAL_ENTITY() Поле юридическое лицо (в интерфейсе является набором из нескольких полей)
 * @method static static ITEMS() Поле состав каталога (поле доступно только в пользовательских списках)
 * @method static static ORG_LEGAL_NAME() Поле организации
 * @method static static DATETIME()
 */
final class CFType extends Enum
{
    public static function values(): array
    {
        return [
            'TEXT'           => 1,
            'NUMERIC'        => 2,
            'CHECKBOX'       => 3,
            'SELECT'         => 4,
            'MULTISELECT'    => 5,
            'DATE'           => 6,
            'URL'            => 7,
            'MULTITEXT'      => 8,
            'TEXTAREA'       => 9,
            'RADIOBUTTON'    => 10,
            'STREETADDRESS'  => 11,
            'SMART_ADDRESS'  => 13,
            'BIRTHDAY'       => 14,
            'LEGAL_ENTITY'   => 15,
            'ITEMS'          => 16,
            'ORG_LEGAL_NAME' => 17,
            'DATETIME'       => 19,
        ];
    }
}