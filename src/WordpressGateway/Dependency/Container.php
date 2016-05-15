<?php

namespace WordpressGateway\Dependency;

use PSX\Framework\Dependency\DefaultContainer;
use PSX\Framework\Oauth2\GrantTypeFactory;
use WordpressGateway\Authentication\ClientCredentials;
use WordpressGateway\Service\Posts;

class Container extends DefaultContainer
{
    public function getOauth2GrantTypeFactory()
    {
        $factory = new GrantTypeFactory();
        $factory->add(new ClientCredentials($this->get('connection')));

        return $factory;
    }

    public function getPostsService()
    {
        return new Posts(
            $this->get('table_manager')->getTable('WordpressGateway\Table\Posts')
        );
    }
}
