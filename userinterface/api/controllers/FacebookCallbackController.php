<?php

namespace Api\Controllers;

use BaseDomain\Services\TokenService;
use \Api\Exceptions\HTTPException;
use \UserDomain\Services\UserPersistService;

class FacebookCallbackController extends RESTController
{

    public function get()
    {

        $facebookService = new \Api\Services\Facebook();
        $return = $facebookService->getUserInformation();

        if(!$return['status']){
            return $return;
        }

        $userService = $this->di->get('Application\User\Service\UserFacebook');
        $return = $userService->save($return['data']);

       if(!$return['status']){
            return $return;
       }

        $redirect = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
        $this->response->redirect($redirect . '?access=' . $return['data']['access'] . '&type=' . $return['data']['type'], true);
    }


}
