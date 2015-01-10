<?php

namespace WordpressGateway\Authentication;

use Doctrine\DBAL\Connection;
use Hautelook\Phpass\PasswordHash;
use PSX\Oauth2\Provider\GrantType\ClientCredentialsAbstract;
use PSX\Oauth2\Provider\Credentials;
use PSX\Oauth2\AccessToken;
use PSX\Oauth2\Authorization\Exception\ServerErrorException;

class ClientCredentials extends ClientCredentialsAbstract
{
	protected $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	protected function generate(Credentials $credentials, $scope)
	{
		$sql = 'SELECT ID, 
				       user_login, 
				       user_pass
			      FROM wp_users
			     WHERE user_login = :user';

		$user = $this->connection->fetchAssoc($sql, array('user' => $credentials->getClientId()));

		if(!empty($user))
		{
			$wpHasher = new PasswordHash(8, TRUE);

			if($wpHasher->CheckPassword($credentials->getClientSecret(), $user['user_pass']))
			{
				// @TODO check how many access keys are already requested for
				// the user and ip and probably limit the amount

				// generate access token
				$accessToken = hash('sha256', uniqid());

				$sql = 'INSERT INTO wp_access_token
								SET user_id = :user_id, 
								    access_token = :access_token, 
								    expires = :expires, 
								    remote_addr = :remote_addr, 
								    insert_date = NOW()';

			    $this->connection->executeUpdate($sql, array(
			    	'user_id'      => $user['ID'],
			    	'access_token' => $accessToken,
			    	'expires'      => 'P6M',
			    	'remote_addr'  => $_SERVER['REMOTE_ADDR'],
		    	));

			    $expires = new \DateTime();
			    $expires->add(new \DateInterval('P6M'));

				$token = new AccessToken();
				$token->setAccessToken($accessToken);
				$token->setTokenType('bearer');
				$token->setExpiresIn($expires->getTimestamp());

				return $token;
			}
			else
			{
				throw new ServerErrorException('Invalid password');
			}
		}
		else
		{
			throw new ServerErrorException('Unknown user');
		}
	}
}
