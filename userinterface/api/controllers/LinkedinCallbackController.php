<?php

namespace Api\Controllers;

use BaseDomain\Services\TokenService;
use \Api\Exceptions\HTTPException;
use \UserDomain\Services\UserPersistService;
use Abraham\TwitterOAuth\TwitterOAuth;

class LinkedinCallbackController extends RESTController
{
    public function get()
    {
        $code = $this->request->get('code');

        $twitterService = new \Api\Services\Linkedin();
        $return = $twitterService->getUserInformation($code);

        if(!$return['status']){
            return $return;
        }

        $userService = $this->di->get('Application\User\Service\UserLinkedin');
        $return = $userService->save($return['data']);

        if(!$return['status']){
            return $return;
        }

        $redirect = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
        $this->response->redirect($redirect . '?access=' . $return['data']['access'] . '&type=' . $return['data']['type'], true);
    }




}
