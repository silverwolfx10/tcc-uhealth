<?php

namespace Api\Controllers;

use BaseDomain\Services\TokenService;
use \Api\Exceptions\HTTPException;
use \UserDomain\Services\UserPersistService;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterCallbackController extends RESTController
{

    public function get()
    {
        $oauth_token = $this->request->get('oauth_token');
        $oauth_verifier = $this->request->get('oauth_verifier');

        $twitterService = new \Api\Services\Twitter();
        $return = $twitterService->getUserInformation($oauth_token, $oauth_verifier);

        if(!$return['status']){
            return $return;
        }

        $userService = $this->di->get('Application\User\Service\UserTwitter');
        $return = $userService->save($return['data']);

        if(!$return['status']){
            return $return;
        }

        $redirect = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
        $this->response->redirect($redirect . '?access=' . $return['data']['access'] . '&type=' . $return['data']['type'], true);

    }




}
