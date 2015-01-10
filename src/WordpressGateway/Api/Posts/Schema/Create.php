<?php

namespace WordpressGateway\Api\Posts\Schema;

use PSX\Data\SchemaAbstract;

class Create extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('WordpressGateway\Api\Posts\Schema\Post');
		$entry->getChild('content')->setRequired(true);
		$entry->getChild('title')->setRequired(true);
		$entry->getChild('status')->setRequired(true);

		return $entry;
	}
}
