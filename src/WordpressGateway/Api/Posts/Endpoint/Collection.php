<?php

namespace WordpressGateway\Api\Posts\Endpoint;

use PSX\Api\Documentation as ApiDocumentation;
use PSX\Api\Version;
use PSX\Api\Resource;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Loader\Context;
use PSX\Util\Api\FilterParameter;

class Collection extends SchemaApiAbstract
{
	use AuthenticationTrait;

	/**
	 * @Inject
	 * @var WordpressGateway\Service\PostManager
	 */
	protected $postManager;

	/**
	 * @Inject
	 * @var PSX\Data\SchemaManager
	 */
	protected $schemaManager;

	public function getDocumentation()
	{
		$resource = new Resource(Resource::STATUS_ACTIVE, $this->context->get(Context::KEY_PATH));

		$resource->addMethod(Resource\Factory::getMethod('GET')
			->addResponse(200, $this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Collection')));

		$resource->addMethod(Resource\Factory::getMethod('POST')
			->setRequest($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Create'))
			->addResponse(201, $this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Message')));

		return new ApiDocumentation\Simple($resource);
	}

	protected function doGet(Version $version)
	{
		return array(
			'entry' => $this->postManager->getPosts(),
		);
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
		$this->postManager->insert($this->userId, $record);

		return array(
			'success' => true,
			'message' => 'Create successful',
		);
	}

	protected function doUpdate(RecordInterface $record, Version $version)
	{
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
	}
}
