<?php


namespace App\Traits;


use App\User;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * @property ResourceServer server
 */
trait AuthUser
{

    /**
     * @param Request $request
     * @return null
     */
    function getUser(Request $request)
    {
        $psr = (new DiactorosFactory)->createRequest($request);

        try {
            $psr = $this->server->validateAuthenticatedRequest($psr);
            return User::find($psr->getAttribute('oauth_user_id'));
        } catch (OAuthServerException $e) {
//            throw new AuthenticationException;
            return null;
        }
    }

}
