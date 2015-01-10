<?php

namespace WordpressGateway\Api\Posts\Endpoint;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
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
		$message = $this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Message');

		$view = new View();
		$view->setGet($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Collection'));
		$view->setPost($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Create'), $message);
		$view->setPut($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Update'), $message);
		$view->setDelete($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Delete'), $message);

		return new Documentation\Simple($view);
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
		$this->postManager->update($this->userId, $record);

		return array(
			'success' => true,
			'message' => 'Update successful',
		);
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
		$this->postManager->delete($this->userId, $record);

		return array(
			'success' => true,
			'message' => 'Delete successful',
		);
	}
}
