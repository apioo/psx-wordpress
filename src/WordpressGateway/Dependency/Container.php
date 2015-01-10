<?php

namespace WordpressGateway\Dependency;

use PSX\Dependency\DefaultContainer;
use PSX\Oauth2\Provider\GrantTypeFactory;
use WordpressGateway\Authentication\ClientCredentials;
use WordpressGateway\Service\PostManager;

class Container extends DefaultContainer
{
	public function getOauth2GrantTypeFactory()
	{
		$factory = new GrantTypeFactory();
		$factory->add(new ClientCredentials($this->get('connection')));

		return $factory;
	}

	public function getPostManager()
	{
		$table = $this->get('table_manager')->getTable('WordpressGateway\Api\Posts\PostTable');

		return new PostManager($table);
	}
}
