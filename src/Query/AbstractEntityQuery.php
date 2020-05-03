<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Query\Params\HasIdParam;
use AmoPRO\AmoCRM\Query\Params\HasLimitOffsetParam;
use AmoPRO\AmoCRM\Query\Params\HasLimitRowsParam;

abstract class AbstractEntityQuery extends AbstractQuery
{
    use HasIfModifiedSince;
    use HasIdParam;
    use HasLimitRowsParam;
    use HasLimitOffsetParam;

    /**
     * LeadsQuery constructor.
     *
     * @param int $limit_rows
     */
    public function __construct(int $limit_rows = 50)
    {
        $this->limitRows($limit_rows);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        if ($ifModifiedSince = $this->getIfModifiedSince()) {
            return ['IF-MODIFIED-SINCE' => $ifModifiedSince->format('D, d M Y H:i:s')];
        }

        return [];
    }
}