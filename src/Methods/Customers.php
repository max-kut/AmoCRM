<?php

namespace AmoPRO\AmoCRM\Methods;

use AmoPRO\AmoCRM\Models\Customer\CustomersCollection;
use AmoPRO\AmoCRM\Query\CustomersQuery;
use AmoPRO\AmoCRM\Support\Arr;
use GuzzleHttp\Psr7\Request;

/**
 * @link https://www.amocrm.ru/developers/content/api/customers
 */
final class Customers extends AbstractMethod
{
    /**
     * @param \AmoPRO\AmoCRM\Query\CustomersQuery|null $query
     * @return \AmoPRO\AmoCRM\Models\Customer\CustomersCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function get(?CustomersQuery $query): CustomersCollection
    {
        $headers = $query ? $query->getHeaders() : [];
        $request = new Request('GET', '/api/v2/customers?' . $query, $headers);

        return CustomersCollection::make(Arr::get($this->prepareResponse($request), '_embedded.items'));
    }

    /**
     * @param \AmoPRO\AmoCRM\Models\Customer\CustomersCollection $customers
     * @param bool $actualize
     * @return \AmoPRO\AmoCRM\Models\Customer\CustomersCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function post(CustomersCollection $customers, bool $actualize = false): CustomersCollection
    {
        $request = new Request('POST', '/api/v2/customers', [], json_encode($customers->toRequest()));

        $response = $this->prepareResponse($request);
        $deleted = Arr::pull($response, '_embedded.items.deleted');
        $result = CustomersCollection::make(Arr::get($response, '_embedded.items'));
        $errors = Arr::get($response, '_embedded.errors', []);

        if ($actualize) {
            $query = (new CustomersQuery($result->count()))->id(...Arr::pluck($result->all(), 'id'));

            return $this->get($query)->setErrors($errors)
                ->setDeleted($deleted ? CustomersCollection::make($deleted) : null);
        }

        return $result->setErrors($errors)->setDeleted($deleted ? CustomersCollection::make($deleted) : null);
    }
}