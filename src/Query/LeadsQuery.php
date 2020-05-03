<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Query\Params\HasQueryParam;
use AmoPRO\AmoCRM\Query\Params\HasResponsibleUserParam;

/**
 * @link https://www.amocrm.ru/developers/content/api/leads
 */
final class LeadsQuery extends AbstractEntityQuery
{
    use HasQueryParam;
    use HasResponsibleUserParam;

    /**
     * @param \AmoPRO\AmoCRM\Query\LeadsWith $with
     * @return $this
     */
    public function with(LeadsWith $with)
    {
        $this->params['with'] = (string)$with;

        return $this;
    }

    /**
     * @param int|null $id[, ...$id]
     * @return $this
     */
    public function status(?int ...$id)
    {
        $this->params['status'] = array_filter($id);

        return $this;
    }

    /**
     * @param \AmoPRO\AmoCRM\Query\LeadsFilter $filter
     * @return $this
     */
    public function filter(LeadsFilter $filter)
    {
        $this->params['filter'] = $filter->toArray();

        return $this;
    }
}