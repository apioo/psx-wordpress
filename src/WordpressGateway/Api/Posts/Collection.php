<?php

namespace WordpressGateway\Api\Posts;

use PSX\Framework\Controller\SchemaApiAbstract;
use WordpressGateway\Api\AuthenticationTrait;

class Collection extends SchemaApiAbstract
{
    use AuthenticationTrait;

    /**
     * @Inject
     * @var \WordpressGateway\Service\Posts
     */
    protected $postsService;

    /**
     * @Outgoing(code=200, schema="WordpressGateway\Schema\Collection")
     */
    protected function doGet()
    {
        return $this->postsService->getPosts();
    }

    /**
     * @Incoming(schema="WordpressGateway\Schema\Create")
     * @Outgoing(code=201, schema="WordpressGateway\Schema\Message")
     */
    protected function doPost($record)
    {
        $this->postsService->insert($this->userId, $record);

        return array(
            'success' => true,
            'message' => 'Create successful',
        );
    }
}
