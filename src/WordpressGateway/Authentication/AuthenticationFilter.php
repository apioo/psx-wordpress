<?php

namespace WordpressGateway\Authentication;

use Closure;
use Doctrine\DBAL\Connection;
use PSX\Framework\Filter\Oauth2Authentication;

class AuthenticationFilter extends Oauth2Authentication
{
    protected $connection;

    public function __construct(Connection $connection, Closure $callback)
    {
        parent::__construct(function ($accessToken) {
            return $this->validate($accessToken);
        });

        $this->connection = $connection;
        $this->callback   = $callback;
    }

    protected function validate($accessToken)
    {
        $sql = 'SELECT user_id,
                       access_token,
                       expires,
                       insert_date
                  FROM wp_access_token
                 WHERE access_token = :token';

        $accessToken = $this->connection->fetchAssoc($sql, array('token' => $accessToken));

        if (!empty($accessToken)) {
            // @TODO check expire date etc.

            // call the callback so that the controller knows the assigned user.
            // Instead of an id this could also be an user object or something
            // else which represents the user
            call_user_func($this->callback, $accessToken['user_id']);

            return true;
        }

        return false;
    }
}
