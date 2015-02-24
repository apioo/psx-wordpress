<?php

namespace WordpressGateway\Api\Posts\Endpoint;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
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
		$message = $this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Message');

		$builder = new View\Builder(View::STATUS_ACTIVE, $this->context->get(Context::KEY_PATH));
		$builder->setGet($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Collection'));
		$builder->setPost($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Create'), $message);
		$builder->setPut($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Update'), $message);
		$builder->setDelete($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Delete'), $message);

		return new Documentation\Simple($builder->getView());
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
