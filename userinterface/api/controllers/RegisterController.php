<?php

namespace Api\Controllers;


class RegisterController extends RESTController
{

    public function get()
    {

        $this->response->setStatusCode(401, 'Unauthorized')->sendHeaders();

        return ['messages' => ['Opção inválida']];
    }


    //registro de usuário
    public function post()
    {
        $registerService = $this->di->get('Application\User\Service\Register');
        $return = $registerService()->insert($this->request->getPost());

        if(!$return['status']){
            return $return;
        }

        $this->response->setStatusCode(201)->sendHeaders();
        $return['data']['redirect'] = 'http://www.uhealth.com.br/api/authorization?access=' . $return['data']['access'] . '&type=' . $return['data']['type'];

        return $return;
    }

    //continuando registro de usuário
    public function put()
    {
        $registerService = $this->di->get('Application\User\Service\Register');
        return $registerService('edit')->update($this->request->getPut());

    }

}
