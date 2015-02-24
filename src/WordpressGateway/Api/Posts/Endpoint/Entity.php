<?php

namespace WordpressGateway\Api\Posts\Endpoint;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
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
		$builder = new View\Builder(View::STATUS_ACTIVE, $this->context->get(Context::KEY_PATH));
		$builder->setGet($this->schemaManager->getSchema('WordpressGateway\Api\Posts\Schema\Post'));

		return new Documentation\Simple($builder->getView());
	}

	protected function doGet(Version $version)
	{
		$post = $this->postManager->getPostById($this->getUriFragment('id'));

		if(empty($post))
		{
			throw new HttpException\NotFoundException('Invalid post');
		}

		return $post;
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
	}

	protected function doUpdate(RecordInterface $record, Version $version)
	{
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
	}
}
