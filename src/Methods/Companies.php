<?php

namespace AmoPRO\AmoCRM\Methods;

use AmoPRO\AmoCRM\Models\Company\CompaniesCollection;
use AmoPRO\AmoCRM\Query\CompaniesQuery;
use AmoPRO\AmoCRM\Support\Arr;
use GuzzleHttp\Psr7\Request;

final class Companies extends AbstractMethod
{
    public function get(?CompaniesQuery $query): CompaniesCollection
    {
        $headers = $query ? $query->getHeaders() : [];
        $request = new Request('GET', '/api/v2/companies?' . $query, $headers);

        return CompaniesCollection::make(Arr::get($this->prepareResponse($request), '_embedded.items'));
    }

    public function post(CompaniesCollection $companies, bool $actualize = false): CompaniesCollection
    {
        $request = new Request('POST', '/api/v2/companies', [], json_encode($companies->toRequest()));

        $response = $this->prepareResponse($request);
        $result = CompaniesCollection::make(Arr::get($response, '_embedded.items'));
        $errors = Arr::get($response, '_embedded.errors', []);

        if ($actualize) {
            $query = (new CompaniesQuery($result->count()))->id(...Arr::pluck($result->all(), 'id'));

            return $this->get($query)->setErrors($errors);
        }

        return $result->setErrors($errors);
    }
}