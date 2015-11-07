<?php 
namespace Application\User\Service;

use \Domain\User\Service\UserPersist;
use \Domain\User\Service\LoginPersist;
use \Infrastructure\Interfaces\Hydrator;
use \Application\User\Form\Register as RegisterForm;

class Register {

    private $userPersist;
    private $userRepository;
    private $hydrator;
    private $registerForm;
    private $loginPersist;
    private $response = [
        'data' => null,
        'messages' => null,
        'status' => true
    ];

	public function __construct(UserPersist $userPersist, $userRepository, Hydrator $hydrator, RegisterForm $registerForm, LoginPersist $loginPersist) {

        $this->userPersist = $userPersist;
        $this->userRepository = $userRepository;
        $this->hydrator = $hydrator;
        $this->registerForm = $registerForm;
        $this->loginPersist = $loginPersist;
    }

    public function insert($data){

        $this->registerForm->setData($data);
        if(!$this->registerForm->isValid()){
            $this->response['status'] = false;
            $this->response['messages'] = $this->registerForm->getMessages();
            return $this->response;
        }

        $user = $this->userPersist->insert($this->registerForm->getData());

        if(!$user['status']){
            return $user;
        }
        $login = [
            'userId' => $user['data']['id'],
            'type' => 'create',
            'status' => 'waiting'
        ];

        return $this->loginPersist->insert($login);
    }

    public function update($data){

        $this->registerForm->setData($data);
        if(!$this->registerForm->isValid()){
            $this->response['status'] = false;
            $this->response['messages'] = $this->registerForm->getMessages();
            return $this->response;
        }

        return $this->userPersist->update($this->registerForm->getData());
    }
}