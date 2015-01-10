<?php

namespace WordpressGateway\Api\Posts\Schema;

use PSX\Data\SchemaAbstract;

class Post extends SchemaAbstract
{
	public function getDefinition()
	{
		$sb = $this->getSchemaBuilder('entry');
		$sb->integer('id')
			->setDescription('Unique id for each post');
		$sb->string('author')
			->setDescription('Name of the author');
		$sb->string('content')
			->setDescription('Content of the post may contain html');
		$sb->string('title')
			->setDescription('Distinct title of the post')
			->setMaxLength(256);
		$sb->string('status')
			->setDescription('Status of the post')
			->setEnumeration(array('publish', 'draft', 'private', 'trash'));
		$sb->dateTime('date')
			->setDescription('Date when the post was created');
		$sb->dateTime('modified')
			->setDescription('Date of the last modification');

		return $sb->getProperty();
	}
}
