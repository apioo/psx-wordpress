<?php

namespace WordpressGateway\Schema;

use PSX\Schema\SchemaAbstract;
use PSX\Schema\Property;

class Collection extends SchemaAbstract
{
    public function getDefinition()
    {
        $sb = $this->getSchemaBuilder('collection');
        $sb->arrayType('entry')
            ->setPrototype($this->getSchema('WordpressGateway\Schema\Post'));

        return $sb->getProperty();
    }
}
