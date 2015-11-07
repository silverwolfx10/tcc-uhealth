<?php

namespace Api\Controllers;

use BaseDomain\Services\TokenService;
use \Api\Exceptions\HTTPException;


class LoginController extends RESTController
{

    private $oAuthServices = [
        'facebook' => 'Api\Services\Facebook',
        'twitter' => 'Api\Services\Twitter',
        'linkedin' => 'Api\Services\Linkedin'
    ];

    public function get()
    {
        $type = $this->request->get('type');
        $_SESSION['redirect'] = $this->request->get('redirect');

        if(isset($this->oAuthServices[$type])) {

            $service = new $this->oAuthServices[$type]();

            $this->response->redirect($service->getUrlLogin(), true);
            return;
        }

        $this->response->setStatusCode(401, 'Unauthorized')->sendHeaders();

        return ['messages' => ['Opção inválida']];
    }


    //identifica o usuário pelo access
    public function me()
    {
        $loginService = $this->di->get('Application\User\Service\Login');

        $return = $loginService->authenticateByAccess($this->request->get('access'));

        if(!$return['status']){
            return $return;
        }

        $return['data'] = $return['data']->toArray();

        return $return;

    }

    //logout
    public function out()
    {
        $loginService = $this->di->get('Application\User\Service\Login');
        $return = $loginService->out($this->request->get('token'));

        if(!$return['status']){
            return $return;
        }

        $return['data'] = $return['data']->toArray();

        return $return;

    }

    public function post(){
        $loginService = $this->di->get('Application\User\Service\Login');
        $data = $this->request->getPost();

        $return = $loginService->authenticateByEmailAndPassword($data);

        if(!$return['status']){
            $this->response->setStatusCode(401)->sendHeaders();
            return $return;
        }

        $this->response->setStatusCode(200)->sendHeaders();
        $return['data']['redirect'] = 'http://www.uhealth.com.br/api/authorization?access=' . $return['data']['access'] . '&type=' . $return['data']['type'];

        return $return;
    }

}
