<?php

namespace Tests\Unit\Auth;

use AmoPRO\AmoCRM\Auth\Auth;
use Tests\PHPUnitUtil;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @throws \AmoPRO\AmoCRM\Exceptions\WrongDomainException
     * @throws \ReflectionException
     */
    public function testPrepareDomain()
    {
        $obj = new Auth('test', $this->amoClientData);
        $equals = [
            'test' => 'https://test.amocrm.ru',
            'test.amocrm.ru' => 'https://test.amocrm.ru',
            'https://test.amocrm.ru' => 'https://test.amocrm.ru',
            'test.z1.amocrm.ru' => 'https://test.z1.amocrm.ru',
            'https://test.z1.amocrm.ru' => 'https://test.z1.amocrm.ru',
            'http://test.z1.amocrm.ru' => 'https://test.z1.amocrm.ru'
        ];

        foreach ($equals as $assertValue => $actual) {
            /** @uses \AmoPRO\AmoCRM\Auth\Auth::prepareDomain() */
            $this->assertEquals(PHPUnitUtil::callMethod($obj, 'prepareDomain', [$assertValue]), $actual);
        }
    }
}