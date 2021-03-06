<?php

namespace WordpressGateway\Schema;

use PSX\Schema\SchemaAbstract;

class Message extends SchemaAbstract
{
    public function getDefinition()
    {
        $sb = $this->getSchemaBuilder('message');
        $sb->boolean('success');
        $sb->string('message');

        return $sb->getProperty();
    }
}
