<?php

namespace Tests\Unit\Query;

use AmoPRO\AmoCRM\Query\Filters\DatesFilter;
use AmoPRO\AmoCRM\Query\LeadsFilter;
use AmoPRO\AmoCRM\Query\LeadsQuery;
use AmoPRO\AmoCRM\Query\LeadsWith;
use Carbon\Carbon;
use Tests\TestCase;

class LeadsQueryTest extends TestCase
{
    /**
     * @param string $result
     * @param \AmoPRO\AmoCRM\Query\LeadsQuery $query
     * @dataProvider queryProvider
     */
    public function testLeadsQuery(string $result, LeadsQuery $query)
    {
        $this->assertEquals($result, (string)$query);
    }

    /**
     * @return array
     */
    public function queryProvider()
    {
        return [
            [
                http_build_query(['limit_rows' => 100]),
                new LeadsQuery(100)
            ],
            [
                http_build_query(['limit_rows' => 50, 'limit_offset' => 10]),
                (new LeadsQuery())->limitOffset(10)
            ],
            [
                http_build_query(['limit_rows' => 50, 'id' => [10, 11]]),
                (new LeadsQuery())->id(10, 11)
            ],
            [
                http_build_query(['limit_rows' => 50, 'query' => 'search']),
                (new LeadsQuery())->query('search')
            ],
            [
                http_build_query(['limit_rows' => 50, 'responsible_user_id' => [10]]),
                (new LeadsQuery())->responsible(10)
            ],
            [
                http_build_query(['limit_rows' => 50, 'with' => 'is_price_modified_by_robot,loss_reason_name,catalog_elements_links']),
                (new LeadsQuery())->with(LeadsWith::all())
            ],
            [
                http_build_query([
                    'limit_rows' => 50,
                    'filter' => [
                        'date_create' => [['from' => '2019-10-10 00:00:00']]
                    ]
                ]),
                (new LeadsQuery())->filter(
                    (new LeadsFilter())->dateCreate(new DatesFilter(Carbon::create(2019, 10, 10)))
                )
            ],
            [
                http_build_query([
                    'limit_rows' => 50,
                    'filter' => [
                        'date_create' => [['from' => '2019-10-10 00:00:00']],
                        'tasks' => 1
                    ]
                ]),
                (new LeadsQuery())->filter(
                    (new LeadsFilter())->dateCreate(new DatesFilter(Carbon::create(2019, 10, 10)))->tasks(1)
                )
            ],
        ];
    }
}