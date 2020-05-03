<?php

namespace Tests\Unit\Query;

use AmoPRO\AmoCRM\Query\Filters\DatesFilter;
use AmoPRO\AmoCRM\Query\LeadsFilter;
use Carbon\Carbon;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function array_key_exists;

class LeadsFilterTest extends TestCase
{

    public function testTasks()
    {
        $filter = new LeadsFilter();

        $filter->tasks(null);
        $this->assertTrue(false === array_key_exists('tasks', $filter->toArray()));

        $filter->tasks(1);
        $this->assertEquals(1, $filter->toArray()['tasks']);
        $filter->tasks(2);
        $this->assertEquals(2, $filter->toArray()['tasks']);

        try {
            $filter->tasks(0);
        } catch (Exception $exception) {
            $this->assertTrue($exception instanceof InvalidArgumentException);
        }
    }

    public function testActive()
    {
        $filter = new LeadsFilter();
        $filter->active(null);
        $this->assertTrue(false === array_key_exists('active', $filter->toArray()));

        $filter->active(1);
        $this->assertEquals(1, $filter->toArray()['active']);

        try {
            $filter->active(0);
        } catch (Exception $exception) {
            $this->assertTrue($exception instanceof InvalidArgumentException);
        }
    }

    public function testDateCreate()
    {
        $filter = new LeadsFilter();

        $filter->dateCreate(null);
        $this->assertTrue(false === array_key_exists('date_create', $filter->toArray()));

        $filter->dateCreate(new DatesFilter());
        $this->assertTrue(false === array_key_exists('date_create', $filter->toArray()));

        $filter->dateCreate(new DatesFilter(Carbon::now()->subYear()));
        $this->assertTrue(array_key_exists('date_create', $filter->toArray()));
    }

    public function testDateModify()
    {
        $filter = new LeadsFilter();

        $filter->dateModify(null);
        $this->assertFalse(array_key_exists('date_modify', $filter->toArray()));

        $filter->dateModify(new DatesFilter());
        $this->assertFalse(array_key_exists('date_modify', $filter->toArray()));

        $filter->dateModify(new DatesFilter(Carbon::now()->subYear()));
        $this->assertTrue(array_key_exists('date_modify', $filter->toArray()));
    }
}