<?php 
namespace Application\User\Service;

use \Domain\User\Service\LoginPersist;
use \Application\User\Form\Login as LoginForm;
use Infrastructure\Service\Crypt;

class Login {

    private $loginPersist;
    private $loginRepository;
    private $userRepository;
    private $cryptService;
    private $loginForm;

    private $response = [
        'data' => null,
        'messages' => null,
        'status' => true
    ];

	public function __construct(LoginPersist $loginPersist, $loginRepository, LoginForm $loginForm, $userRepository, Crypt $cryptService) {

        $this->loginPersist = $loginPersist;
        $this->loginRepository = $loginRepository;
        $this->userRepository = $userRepository;
        $this->cryptService = $cryptService;
        $this->loginForm = $loginForm;

    }

    public function authenticateByAccess($access){

        if($login = $this->loginRepository->findOneBy(['access'=> $access, 'status' => 'waiting'])){
            $login->setStatus('active');
            return $this->loginPersist->update($login->toArray());
        }

        $this->response['messages'] = ['Access expirado'];
        $this->response['status'] = false;

        return $this->response;

    }

    public function authenticateByEmailAndPassword($data){

        $this->loginForm->setData($data);
        if(!$this->loginForm->isValid()){
            $this->response['messages'] = $this->loginForm->getMessages();
            $this->response['status'] = false;
            return $this->response;
        }

        $data = $this->loginForm->getData();

        if($user = $this->userRepository->findOneByEmail(['email'=> $data['email'], 'status' => 'active'])){
            if($user->getPassword() == $this->cryptService->hash($data['password'], $user->getSalt())){
                return $this->loginPersist->insert([
                    'userId' => $user->getId(),
                    'type' => 'login',
                    'status' => 'waiting'
                ]);
            }
       }

        $this->response['messages'] = ['Usuário e senha incorretos'];
        $this->response['status'] = false;

        return $this->response;
    }

    public function out($token){

        if($login = $this->loginRepository->findOneBy(['token'=> $token])){
            $login->setStatus('expired');
            return $this->loginPersist->update($login->toArray());
        }

        return $this->response;

    }

}