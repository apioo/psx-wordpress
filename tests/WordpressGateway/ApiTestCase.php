<?php

namespace WordpressGateway;

use PSX\Framework\Test\ControllerDbTestCase;
use PSX\Json\Parser;

class ApiTestCase extends ControllerDbTestCase
{
    protected static $accessToken;

    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/../api_fixture.xml');
    }

    protected function getAccessToken()
    {
        if (self::$accessToken !== null) {
            return self::$accessToken;
        }

        $response = $this->sendRequest('http://127.0.0.1/token', 'POST', ['Authorization' => 'Basic ' . base64_encode('test:test123')], 'grant_type=client_credentials');
        $data     = (string) $response->getBody();
        $token    = Parser::decode($data);

        if (isset($token->access_token)) {
            return self::$accessToken = $token->access_token;
        } else {
            $this->fail('Could not request access token' . "\n" . $data);
        }
    }

    protected function getPaths()
    {
        return array(
            [['GET', 'POST', 'PUT', 'DELETE'], '/posts', 'WordpressGateway\Api\Posts\Collection'],
            [['GET', 'POST', 'PUT', 'DELETE'], '/posts/:id', 'WordpressGateway\Api\Posts\Entity'],
            [['GET', 'POST'], '/token', 'WordpressGateway\Api\Authentication\Token'],
        );
    }
}
