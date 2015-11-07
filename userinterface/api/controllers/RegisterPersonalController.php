<?php

namespace Api\Controllers;


class RegisterPersonalController extends RESTController
{

    public function get()
    {

        $this->response->setStatusCode(401, 'Unauthorized')->sendHeaders();

        return ['messages' => ['Opção inválida']];
    }


    //registro de usuário
    public function post()
    {
        $registerPersonalService = $this->di->get('Application\User\Service\RegisterPersonal');
        $return = $registerPersonalService->insert($this->request->getPut());

        if($return['status']){
            $this->response->setStatusCode(202)->sendHeaders();
        }

        return $return;

    }

    //continuando registro de usuário
    public function put()
    {
        $registerPersonalService = $this->di->get('Application\User\Service\RegisterPersonal');
        return $registerPersonalService->update($this->request->getPut());

    }

}
