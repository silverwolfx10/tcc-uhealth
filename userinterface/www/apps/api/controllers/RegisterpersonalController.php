<?php

namespace Multiple\Api\Controllers;

use Phalcon\Mvc\Controller;

class RegisterpersonalController extends Controller
{

	public function indexAction()
	{

        $return = $this->di->get('api')->post($this->request->getPut(), '/v1/registerPersonal');

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

	}
}
