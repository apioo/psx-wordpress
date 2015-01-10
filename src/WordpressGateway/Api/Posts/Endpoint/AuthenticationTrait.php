<?php

namespace WordpressGateway\Api\Posts\Endpoint;

use WordpressGateway\Authentication\AuthenticationFilter;
use PSX\Dispatch\Filter\Condition\RequestMethodChoice;

/**
 * Simple trait which adds the authentication filter. Can be used on every 
 * controller where authentication is needed
 */
trait AuthenticationTrait
{
	/**
	 * @Inject
	 * @var Doctrine\DBAL\Connection
	 */
	protected $connection;

	/**
	 * ID of the authenticated user
	 *
	 * @var integer
	 */
	protected $userId;

	public function getPreFilter()
	{
		$allowedMethods = ['POST', 'PUT', 'DELETE'];
		$authFilter     = new AuthenticationFilter($this->connection, function($userId){

			$this->userId = $userId;

		});

		return [new RequestMethodChoice($allowedMethods, $authFilter)];
	}
}
