<?php

namespace WordpressGateway\Api\Posts\Schema;

use PSX\Data\SchemaAbstract;
use PSX\Data\Schema\Property;

class Collection extends SchemaAbstract
{
	public function getDefinition()
	{
		$sb = $this->getSchemaBuilder('collection');
		$sb->arrayType('entry')
			->setPrototype($this->getSchema('WordpressGateway\Api\Posts\Schema\Post'));

		return $sb->getProperty();
	}
}
