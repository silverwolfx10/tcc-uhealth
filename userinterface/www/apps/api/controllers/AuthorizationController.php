<?php

namespace Multiple\Api\Controllers;

use Phalcon\Mvc\Controller;

class AuthorizationController extends Controller
{

	public function indexAction()
	{
        $return = $this->di->get('api')->get('/v1/login/me?access=' . $this->request->get('access'));

        if(!$return['status']){
            $this->response->redirect('http://www.uhealth.com.br/login', true);
        }
        $_SESSION['token'] = $return['data']['token'];
        unset($return['data']['token']);
        unset($return['data']['access']);

        $_SESSION['user'] = $return['data'];

        $redirect = $this->request->get('type') == 'create' ? 'http://www.uhealth.com.br/cadastro/completo' : 'http://www.uhealth.com.br';

        $this->response->redirect($redirect, true);

	}

    public function meAction(){

        $this->response->setJsonContent($_SESSION['user']);

        return $this->response;
    }

    public function loginAction(){
        $return = $this->di->get('api')->post($this->request->getPut(), '/v1/login');
        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

       return $this->response;
    }

    public function outAction(){
        $token  = $_SESSION['token'];
        $this->di->get('api')->get('/v1/login/out?token=' . $token);
        session_destroy();

        $this->response->redirect('http://www.uhealth.com.br', true);
    }
}
