<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

class IndexController extends Controller
{
    private $hashMap = [
        '' => [
            'controller' => 'home',
            'url' => '/',
            'title' => 'uHealth'
        ],
        'login' => [
            'controller' => 'login',
            'url' => '/login',
            'title' => 'Login'
        ],
        'cadastro' => [
            'controller' => 'cadastro',
            'url' => '/cadastro',
            'title' => 'Criar uma conta'
        ],
        'minhaconta' => [
            'controller' => 'minhaconta',
            'url' => '/minhaconta',
            'title' => 'Minha conta'
        ],
        'personais' => [
            'controller' => 'personais',
            'url' => '/personais',
            'title' => 'Buscando Personais'
        ],
        'mapa' => [
            'controller' => 'mapa',
            'url' => '/mapa',
            'title' => 'Buscando Personais'
        ],
    ];
	public function indexAction()
	{


        if(strlen($this->dispatcher->getParams()[0]) == 2){


            $data['controller'] = $this->request->get('list') ? 'list' : 'mapa';
            $data['url'] = '';
            foreach($this->dispatcher->getParams() as $p){
                $data['url'] .= '/' . $p;
            }
            $data['url'] = $this->request->get('list') ? $data['url'] . '?list=true' : $data['url'];
            $data['action'] = '';
            $data['title'] = '';
            $data['uf'] = $this->dispatcher->getParams()[0];
            $data['city'] = $this->dispatcher->getParams()[1];
            $data['hood'] = $this->dispatcher->getParams()[2];
            $data['street'] = $this->dispatcher->getParams()[3];
            $data['number'] = $this->dispatcher->getParams()[4];

            $return = $this->di->get('api')->post($data, '/v1/address/geographic');

            $data['lat'] = $return['data']['lat'];
            $data['lng'] = $return['data']['lng'];


        }else if(isset($this->hashMap[$this->dispatcher->getParams()[0]])){
            $data = $this->hashMap[$this->dispatcher->getParams()[0]];
            $data['action'] = isset($this->dispatcher->getParams()[1]) ? $this->dispatcher->getParams()[1] : '';
            $data['url'] = $data['action'] ? $data['url'] . '/' . $data['action'] : $data['url'];
        }else if(preg_match('/@/', $this->dispatcher->getParams()[0])){
            $data['url'] = '/' . $this->dispatcher->getParams()[0];
            $data['controller'] = 'personal';
            $data['action'] = '';
            $data['title'] = '';
        }

        $this->view->setVars($data);

       return $this->view;

	}
}
