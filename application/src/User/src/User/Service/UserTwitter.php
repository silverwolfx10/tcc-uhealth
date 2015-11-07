<?php 
namespace Application\User\Service;
use Doctrine\ORM\EntityManager;

use \Domain\User\Service\UserPersist;
use \Infrastructure\Interfaces\Hydrator;
use \Domain\User\Service\LoginPersist;

class UserTwitter {

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

        if($user = $this->userRepository->findOneByTwitterId($data['twitterId'])){

            $this->hydrator->hydrate($data, $user);
            $user = $user->toArray();
            unset($user['email']);
            $return = $this->userPersist->update($user);
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