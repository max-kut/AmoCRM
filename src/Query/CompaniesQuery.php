<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Query\Params\HasQueryParam;
use AmoPRO\AmoCRM\Query\Params\HasResponsibleUserParam;

/**
 * @link https://www.amocrm.ru/developers/content/api/companies
 */
final class CompaniesQuery extends AbstractEntityQuery
{
    use HasQueryParam;
    use HasResponsibleUserParam;
}