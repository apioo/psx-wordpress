<?php

namespace WordpressGateway\Schema;

use PSX\Schema\SchemaAbstract;

class Create extends SchemaAbstract
{
    public function getDefinition()
    {
        $entry = $this->getSchema('WordpressGateway\Schema\Post');
        $entry->get('content')->setRequired(true);
        $entry->get('title')->setRequired(true);

        return $entry;
    }
}
