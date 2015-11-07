<?php

namespace Multiple\Api\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

	public function indexAction()
	{
        die('api');
        $return = $this->di->get('api')->post([], '/v1/register');

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

	}
}
