<?php 
namespace Application\User\Service;
use Doctrine\ORM\EntityManager;

use \Domain\User\Service\UserPersist;
use \Infrastructure\Interfaces\Hydrator;
use \Domain\User\Service\LoginPersist;

class UserFacebook {

    private $userPersist;
    private $userRepository;
    private $loginPersist;
    private $hydrator;
	public function __construct(UserPersist $userPersist, $userRepository, Hydrator $hydrator, LoginPersist $loginPersist) {

        $this->userPersist = $userPersist;
        $this->userRepository = $userRepository;
        $this->hydrator = $hydrator;
        $this->loginPersist = $loginPersist;

    }

    public function save($data){

        if($user = $this->userRepository->findOneByFacebookId($data['facebookId'])){

            $this->hydrator->hydrate($data, $user);
            $return = $this->userPersist->update($user->toArray());
            $typeLogin = 'login';
        }

        if($user = $this->userRepository->findOneByEmail($data['email'])){
            $this->hydrator->hydrate($data, $user);
            $return = $this->userPersist->update($user->toArray());
            $typeLogin = 'login';
        }

        if(is_null($return)) {
            $return = $this->userPersist->insert($data);
            $typeLogin = 'create';
        }

        if(!$return['status']){
            return $return;
        }

        $login = [
            'userId' => $return['data']['id'],
            'type' => $typeLogin,
            'status' => 'waiting'
        ];

        return $this->loginPersist->insert($login);

    }

}