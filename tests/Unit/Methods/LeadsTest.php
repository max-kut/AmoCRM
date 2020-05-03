<?php

namespace Tests\Unit\Methods;

use AmoPRO\AmoCRM\Exceptions\ValidationException;
use AmoPRO\AmoCRM\Models\Lead\Lead;
use AmoPRO\AmoCRM\Models\Lead\LeadsCollection;
use AmoPRO\AmoCRM\Query\LeadsQuery;
use AmoPRO\AmoCRM\Query\LeadsWith;
use Carbon\Carbon;
use Exception;
use Tests\TestCase;

class LeadsTest extends TestCase
{
    public function testGet()
    {
        $res = $this->client->leads->get((new LeadsQuery())->with(LeadsWith::all()));
        $this->assertInstanceOf(LeadsCollection::class, $res);
    }

    public function testValidation()
    {
        try {
            $this->client->leads->post(new LeadsCollection());
            // not executing
            $this->assertTrue(false);
        } catch (Exception $exception) {
            $this->assertInstanceOf(ValidationException::class, $exception);
        }

        try {
            // empty updated_at attribute
            $this->client->leads->post(new LeadsCollection(['id' => 1]));
            // not executing
            $this->assertTrue(false);
        } catch (Exception $exception) {
            $this->assertInstanceOf(ValidationException::class, $exception);
        }

        try {
            // empty required name when creating
            $this->client->leads->post(new LeadsCollection(['tags' => ['tag1']]));
            // not executing
            $this->assertTrue(false);
        } catch (Exception $exception) {
            $this->assertInstanceOf(ValidationException::class, $exception);
        }
    }

    public function testCreateLead()
    {
        $newLead = Lead::make(['name' => 'test create lead']);

        $leadCollection = (new LeadsCollection())->push($newLead);

        $res = $this->client->leads->post($leadCollection, true);
        $this->assertInstanceOf(LeadsCollection::class, $res);
        $this->assertEmpty($res->getErrors());
        $this->assertCount(1, $res);

        return $res;
    }

    /**
     * @depends testCreateLead
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function testUpdateLead(LeadsCollection $leads)
    {
        /** @var Lead $lead */
        $lead = $leads->first();
        $lead->name = 'test update lead';
        $lead->updated_at = Carbon::now();

        $res = $this->client->leads->post($leads, true);
        $this->assertEquals($lead->name, $res->first()->name);
    }

    public function testSetCatalogElementsId()
    {
        $lead = new Lead();

        $lead->catalog_elements_id = [
            // catalog_id => elements
            1000 => [
                // element_id => quantity
                2000 => 12
            ]
        ];

        $res = $lead->catalog_elements_id;

        $this->assertArrayHasKey(1000, $res);
        $this->assertArrayHasKey(2000, $res[1000]);
        $this->assertEquals(12, $res[1000][2000]);

        // test validation
        try {
            $lead->catalog_elements_id = ['not_number' => [2000 => 12]];
            throw new Exception('');
        } catch (ValidationException $exception){
            $this->assertTrue(true);
        } catch (Exception $exception){
            $this->assertTrue(false, 'Must throwing validation exception');
        }

        try {
            $lead->catalog_elements_id = [1000 => ['not_number' => 12]];
            throw new Exception('');
        } catch (ValidationException $exception){
            $this->assertTrue(true);
        } catch (Exception $exception){
            $this->assertTrue(false, 'Must throwing validation exception');
        }

        try {
            $lead->catalog_elements_id = [1000 => [2000 => 'not_number']];
            throw new Exception('');
        } catch (ValidationException $exception){
            $this->assertTrue(true);
        } catch (Exception $exception){
            $this->assertTrue(false, 'Must throwing validation exception');
        }
    }
}