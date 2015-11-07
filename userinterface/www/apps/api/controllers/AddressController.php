<?php

namespace Multiple\Api\Controllers;

use Phalcon\Mvc\Controller;

class AddressController extends Controller
{

	public function cityAction()
	{
        $param = $this->dispatcher->getParams()[0];
        $return = $this->di->get('api')->get('/v1/address/city/' . $param);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

	}

    public function hoodAction()
    {
        $param = $this->dispatcher->getParams()[0];
        $return = $this->di->get('api')->get('/v1/address/hood/' . $param);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }

    public function streetAction()
    {
        $param = $this->dispatcher->getParams()[0];
        $return = $this->di->get('api')->get('/v1/address/street/' . $param);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }

    public function zipcodeAction()
    {
        $param = $this->dispatcher->getParams()[0];
        $return = $this->di->get('api')->get('/v1/address/zipcode/' . $param);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }

    public function zipcodeNumberAction()
    {

        $zipCode = $this->dispatcher->getParams()[0];
        $number = $this->dispatcher->getParams()[1];
        $return = $this->di->get('api')->get('/v1/address/zipcode/' . $zipCode . '/' . $number);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }

    public function locationAction()
    {

        $lat = $this->dispatcher->getParams()[0];
        $lng = $this->dispatcher->getParams()[1];
        $distance = $this->dispatcher->getParams()[2];
        $return = $this->di->get('api')->get('/v1/ad/location/' . $lat . '/' . $lng . '/' . $distance);

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }

    public function addressAction()
    {
        $address = $this->dispatcher->getParams()[0];

        $return = $this->di->get('api')->get('/v1/ad/search/address/' . urlencode($address));

        $this->response->setStatusCode($return['httpStatus'])->sendHeaders();

        unset($return['httpStatus']);
        $this->response->setJsonContent($return);

        return $this->response;

    }
}
