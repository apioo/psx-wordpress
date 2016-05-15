<?php

namespace WordpressGateway\Api\Posts;

use PSX\Framework\Controller\SchemaApiAbstract;
use WordpressGateway\Api\AuthenticationTrait;

class Entity extends SchemaApiAbstract
{
    use AuthenticationTrait;

    /**
     * @Inject
     * @var \WordpressGateway\Service\Posts
     */
    protected $postsService;

    /**
     * @Outgoing(code=200, schema="WordpressGateway\Schema\Post")
     */
    protected function doGet()
    {
        return $this->postsService->getPost($this->getUriFragment('id'));
    }

    /**
     * @Incoming(schema="WordpressGateway\Schema\Post")
     * @Outgoing(code=200, schema="WordpressGateway\Schema\Message")
     */
    protected function doPut($record)
    {
        $record->id = $this->getUriFragment('id');

        $this->postsService->update($this->userId, $record);

        return array(
            'success' => true,
            'message' => 'Update successful',
        );
    }

    /**
     * @Outgoing(code=200, schema="WordpressGateway\Schema\Message")
     */
    protected function doDelete($record)
    {
        $this->postsService->delete($this->userId, $this->getUriFragment('id'));

        return array(
            'success' => true,
            'message' => 'Delete successful',
        );
    }
}
