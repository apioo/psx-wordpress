<?php

namespace WordpressGateway\Api;

use PSX\Framework\Test\Environment;
use WordpressGateway\ApiTestCase;

class CollectionTest extends ApiTestCase
{
    public function testGetAll()
    {
        $response = $this->sendRequest('http://127.0.0.1/posts', 'GET');

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "entry": [
        {
            "id": "356a192b-7913-504c-9445-574d18c28d46",
            "content": "Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!",
            "title": "Hello world!",
            "excerpt": "",
            "status": "publish",
            "href": "http:\/\/127.0.0.1\/tests\/wordpress\/?p=1",
            "createdAt": "2015-02-24T19:22:43Z",
            "updatedAt": "2015-02-24T19:22:43Z",
            "commentCount": 0,
            "author": {
                "displayName": "test",
                "url": "",
                "createdAt": "2015-02-24T19:22:42Z"
            }
        }
    ]
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);
    }

    public function testPost()
    {
        $payload = json_encode([
            'title'   => 'lorem ipsum',
            'content' => 'lorem ipsum',
        ]);

        $headers  = ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $this->getAccessToken()];
        $response = $this->sendRequest('http://127.0.0.1/posts', 'POST', $headers, $payload);

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "success": true,
    "message": "Create successful"
}
JSON;

        $this->assertEquals(201, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);

        // check database
        $sql = Environment::getService('connection')->createQueryBuilder()
            ->select('ID', 'post_author', 'post_title', 'post_content', 'post_status')
            ->from('wp_posts')
            ->orderBy('id', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getSQL();

        $result = Environment::getService('connection')->fetchAll($sql);
        $expect = [
            ['ID' => 2, 'post_author' => 1, 'post_title' => 'lorem ipsum', 'post_content' => 'lorem ipsum', 'post_status' => 'publish'],
        ];

        $this->assertEquals($expect, $result);
    }

    public function testPut()
    {
        $headers  = ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $this->getAccessToken()];
        $response = $this->sendRequest('http://127.0.0.1/posts', 'PUT', $headers);

        $body = (string) $response->getBody();

        $this->assertEquals(405, $response->getStatusCode(), $body);
    }

    public function testDelete()
    {
        $headers  = ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $this->getAccessToken()];
        $response = $this->sendRequest('http://127.0.0.1/posts', 'DELETE', $headers);

        $body = (string) $response->getBody();

        $this->assertEquals(405, $response->getStatusCode(), $body);
    }
}
