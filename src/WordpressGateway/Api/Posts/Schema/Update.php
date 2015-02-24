<?php

namespace WordpressGateway\Api\Posts\Schema;

use PSX\Data\SchemaAbstract;

class Update extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('WordpressGateway\Api\Posts\Schema\Post');
		$entry->get('id')->setRequired(true);

		return $entry;
	}
}
