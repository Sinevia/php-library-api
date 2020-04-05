<?php

namespace Tests\Unit;

include_once dirname(__DIR__) . '/BaseTest.php';

class ApiTest extends \Tests\BaseTest
{

    /**
     * Test toArray response contains all required data
     * @return void
     */
    public function testArrayResponse()
    {
        $response = new \Sinevia\ApiResponse();
        $response->setId('ID');
        $response->setStatus('success');
        $response->setMessage('Message');
        $response->setData('Data');
        $array = $response->toArray();
        $this->assertIsArray($array);
        $this->assertEquals($array["id"],"ID");
        $this->assertEquals($array["status"],"success");
        $this->assertEquals($array["message"],"Message");
        $this->assertEquals($array["data"],"Data");
    }

    /**
     * Test toJSON response containes all required data
     * @return void
     */
    public function testJsonResponse()
    {
        $response = new \Sinevia\ApiResponse();
        $response->setId('ID');
        $response->setStatus('success');
        $response->setMessage('Message');
        $response->setData('Data');
        $json = $response->toJson();
        $this->assertJSON($json);
        $this->assertStringContainsString('"id":"ID"', $json);
        $this->assertStringContainsString('"status":"success"', $json);
        $this->assertStringContainsString('"message":"Message"', $json);
        $this->assertStringContainsString('"data":"Data"', $json);
    }
}