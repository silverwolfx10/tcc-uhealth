<?php 
namespace Domain\User\Service;
use Doctrine\ORM\EntityManager;

use Infrastructure\Service\Crypt;
use Infrastructure\Service\Persist;
use Domain\User\Service\GenerateMyUri;

class UserPersist extends Persist{

    private $generateMyUri;
    private $cryptService;

	public function __construct(EntityManager $em, GenerateMyUri $generateMyUri, Crypt $cryptService) {

		$this->entity = 'Domain\User\Entity\User';
        $this->generateMyUri = $generateMyUri;
        $this->cryptService = $cryptService;

		parent::__construct($em);

    }

    public function insert(array $data){

        if(!isset($data['myUri']) ||  !$data['myUri']){
            $data['myUri'] = $this->generateMyUri->generate($data['name']);
        }

        if($this->getEm()->getRepository($this->entity)->findOneByEmail($data['email'])){
            $this->response['messages'] = ['Email ja consta em nosso banco de dados'];
            $this->response['status'] = false;

            return $this->response;
        }

        if(isset($data['password']) && $data['password']){
            $entity = new $this->entity();

            $data['salt'] = $entity->getSalt();
            $data['password'] = $this->cryptService->hash($data['password'], $data['salt']);
        }

    	$this->response = parent::insert($data);

        if($this->response['status']){
            $this->response['data'] = $this->response['data']->toArrayApi();
        }

        return $this->response;
    }

    public function update(array $data){

        if(($user = $this->getEm()->getRepository($this->entity)->findOneByEmail($data['email'])) && $user->getId() != $data['id']){

            $this->response['messages'] = ['Email ja consta em nosso banco de dados'];
            $this->response['status'] = false;

            return $this->response;
        }

        $this->response = parent::update($data);

        if($this->response['status']){
            $this->response['data'] = $this->response['data']->toArrayApi();
        }

        return $this->response;
    }
}