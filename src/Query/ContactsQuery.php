<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Query\Params\HasQueryParam;
use AmoPRO\AmoCRM\Query\Params\HasResponsibleUserParam;

/**
 * @link https://www.amocrm.ru/developers/content/api/contacts
 */
final class ContactsQuery extends AbstractEntityQuery
{
    use HasQueryParam;
    use HasResponsibleUserParam;
}