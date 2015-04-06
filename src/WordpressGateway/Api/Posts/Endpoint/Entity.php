<?php

namespace WordpressGateway\Api\Posts\Endpoint;

use PSX\Api\Documentation as ApiDocumentation;
use PSX\Api\Version;
use PSX\Api\Resource;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Http\Exception as HttpException;
use PSX\Loader\Context;
use PSX\Util\Api\FilterParameter;

class Entity extends SchemaApiAbstract
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
			->addResponse(200, $this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Post')));

		$resource->addMethod(Resource\Factory::getMethod('PUT')
			->setRequest($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Post'))
			->addResponse(200, $this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Message')));

		$resource->addMethod(Resource\Factory::getMethod('DELETE')
			->addResponse(200, $this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Message')));


		return new ApiDocumentation\Simple($resource);
	}

	protected function doGet(Version $version)
	{
		return $this->getPost();
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
	}

	protected function doUpdate(RecordInterface $record, Version $version)
	{
		$post = $this->getPost();

		$record->setId($post['id']);

		$this->postManager->update($this->userId, $record);

		return array(
			'success' => true,
			'message' => 'Update successful',
		);
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
		$post = $this->getPost();

		$record->setId($post['id']);

		$this->postManager->delete($this->userId, $record);

		return array(
			'success' => true,
			'message' => 'Delete successful',
		);
	}

	protected function getPost()
	{
		$post = $this->postManager->getPostById($this->getUriFragment('id'));

		if(empty($post))
		{
			throw new HttpException\NotFoundException('Invalid post');
		}

		return $post;
	}
}
