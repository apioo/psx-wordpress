<?php

namespace WordpressGateway\Schema;

use PSX\Schema\SchemaAbstract;

class Post extends SchemaAbstract
{
    public function getDefinition()
    {
        $sb = $this->getSchemaBuilder('author');
        $sb->string('displayName');
        $sb->string('url');
        $sb->dateTime('createdAt');
        $author = $sb->getProperty();

        $sb = $this->getSchemaBuilder('entry');
        $sb->string('id');
        $sb->string('content');
        $sb->string('title');
        $sb->string('excerpt');
        $sb->string('status');
        $sb->string('href');
        $sb->dateTime('createdAt');
        $sb->dateTime('updatedAt');
        $sb->integer('commentCount');
        $sb->complexType('author', $author);

        return $sb->getProperty();
    }
}
