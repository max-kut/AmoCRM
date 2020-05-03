<?php /** @noinspection PhpUnitTestsInspection */

namespace Tests\Unit\Methods;

use AmoPRO\AmoCRM\Models\Account\Account;
use Tests\TestCase;

class AccountTest extends TestCase
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function testAccount()
    {
        $account = $this->client->account->account();
        $this->assertInstanceOf(Account::class, $account);
        $this->assertTrue(!is_null($account->getUsers()));
        $this->assertTrue(!is_null($account->getGroups()));
        $this->assertTrue(!is_null($account->getCustomFields()));
        $this->assertTrue(!is_null($account->getNoteTypes()));
        $this->assertTrue(!is_null($account->getTaskTypes()));
        $this->assertTrue(!is_null($account->getPipelines()));
    }
}