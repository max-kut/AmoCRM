<?php

namespace AmoPRO\AmoCRM\Methods;

use AmoPRO\AmoCRM\Models\Lead\LeadsCollection;
use AmoPRO\AmoCRM\Query\LeadsQuery;
use AmoPRO\AmoCRM\Support\Arr;
use GuzzleHttp\Psr7\Request;

/**
 * @link https://www.amocrm.ru/developers/content/api/leads
 */
final class Leads extends AbstractMethod
{
    /**
     * @param \AmoPRO\AmoCRM\Query\LeadsQuery|null $query
     * @return \AmoPRO\AmoCRM\Models\Lead\LeadsCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function get(?LeadsQuery $query = null): LeadsCollection
    {
        $headers = [];
        if ($query && ($ifModifiedSince = $query->getIfModifiedSince())) {
            $headers['IF-MODIFIED-SINCE'] = $ifModifiedSince->format('D, d M Y H:i:s');
        }

        $request = new Request('GET', '/api/v2/leads?' . $query, $headers);

        return LeadsCollection::make(Arr::get($this->prepareResponse($request), '_embedded.items'));
    }

    /**
     * @param \AmoPRO\AmoCRM\Models\Lead\LeadsCollection|\AmoPRO\AmoCRM\Models\Lead\Lead[] $leads
     * @param bool $actualize Извлечь информацию по сделкам, которые были добавлены или обновлены и вернуть ее
     * @return \AmoPRO\AmoCRM\Models\Lead\LeadsCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function post(LeadsCollection $leads, bool $actualize = false): LeadsCollection
    {
        $request = new Request('POST', '/api/v2/leads', [], json_encode($leads->toRequest()));

        $response = $this->prepareResponse($request);
        /** @var \AmoPRO\AmoCRM\Models\Lead\LeadsCollection $result */
        $result = LeadsCollection::make(Arr::get($response, '_embedded.items'));
        $errors = Arr::get($response, '_embedded.errors', []);

        if ($actualize) {
            $query = (new LeadsQuery($result->count()))->id(...Arr::pluck($result->all(),'id'));

            return $this->get($query)->setErrors($errors);
        }

        return $result->setErrors($errors);
    }
}