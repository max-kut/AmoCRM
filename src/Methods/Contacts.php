<?php

namespace AmoPRO\AmoCRM\Methods;

use AmoPRO\AmoCRM\Models\Contact\ContactsCollection;
use AmoPRO\AmoCRM\Query\ContactsQuery;
use AmoPRO\AmoCRM\Support\Arr;
use GuzzleHttp\Psr7\Request;

final class Contacts extends AbstractMethod
{
    /**
     * @param \AmoPRO\AmoCRM\Query\ContactsQuery|null $query
     * @return \AmoPRO\AmoCRM\Models\Contact\ContactsCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function get(?ContactsQuery $query): ContactsCollection
    {
        $headers = $query ? $query->getHeaders() : [];
        $request = new Request('GET', '/api/v2/contacts?' . $query, $headers);

        return ContactsCollection::make(Arr::get($this->prepareResponse($request), '_embedded.items'));
    }

    /**
     * @param \AmoPRO\AmoCRM\Models\Contact\ContactsCollection|\AmoPRO\AmoCRM\Models\Contact\Contact[] $contacts
     * @param bool $actualize
     * @return \AmoPRO\AmoCRM\Models\Contact\ContactsCollection
     */
    public function post(ContactsCollection $contacts, bool $actualize = false): ContactsCollection
    {
        $request = new Request('POST', '/api/v2/contacts', [], json_encode($contacts->toRequest()));

        $response = $this->prepareResponse($request);
        $result = ContactsCollection::make(Arr::get($response, '_embedded.items'));
        $errors = Arr::get($response, '_embedded.errors', []);

        if ($actualize) {
            $query = (new ContactsQuery($result->count()))->id(...Arr::pluck($result->all(), 'id'));

            return $this->get($query)->setErrors($errors);
        }

        return $result->setErrors($errors);
    }
}