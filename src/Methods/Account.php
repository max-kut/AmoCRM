<?php

namespace AmoPRO\AmoCRM\Methods;

use AmoPRO\AmoCRM\Models\Account\Account as AccountModel;
use AmoPRO\AmoCRM\Query\AccountQuery;
use AmoPRO\AmoCRM\Query\AccountWith;
use GuzzleHttp\Psr7\Request;


final class Account extends AbstractMethod
{
    /**
     * @param array|null $with
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function buildAccountRequest(?AccountQuery $query): Request
    {
        return new Request('GET', '/api/v2/account?' . $query);
    }

    /**
     * @param array|null $with
     * @return \AmoPRO\AmoCRM\Models\Account\Account
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function account(?AccountQuery $query = null): AccountModel
    {
        $query = is_null($query) ? new AccountQuery(AccountWith::all()) : $query;
        return AccountModel::make($this->prepareResponse($this->buildAccountRequest($query)));
    }
}