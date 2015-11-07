<?php

namespace Multiple\Api\Controllers;

use Phalcon\Mvc\Controller;

class AdController extends Controller
{

	public function registerInformationAction()
	{

        $return = $this->di->get('api')->get('/v1/ad/registerinformation');

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

	}

    public function getByUserAction()
    {
        $user = $_SESSION['user'];
        $return = $this->di->get('api')->get('/v1/ad/user/' . $user['userId']['id']);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }

    public function updateAction()
    {
        $data = $this->request->getPut();

        $user = $_SESSION['user'];

        if(!isset($data['id'])){
            $this->response->setJsonContent(['status'=>false, 'messages'=>['id deve ser informado'], 'data'=>null]);
            return $this->response;
        }
        $id = $data['id'];
        $data['personalId'] = $user['userId']['id'];

        $return = $this->di->get('api')->put($data, '/v1/ad/' . $id);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }

    public function myuriAction()
    {

        $return = $this->di->get('api')->get('/v1/ad/' . $this->dispatcher->getParams()[0]);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }
}
