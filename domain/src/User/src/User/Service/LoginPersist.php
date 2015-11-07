<?php 
namespace Domain\User\Service;
use Doctrine\ORM\EntityManager;

use Infrastructure\Service\Crypt;
use Infrastructure\Service\Persist;

class LoginPersist extends Persist{

    private $cryptService;

	public function __construct(EntityManager $em, Crypt $cryptService) {

		$this->entity = 'Domain\User\Entity\Login';
        $this->cryptService = $cryptService;

		parent::__construct($em);

    }

    public function insert(array $data){

        if(isset($data['userId']) && !($data['userId'] InstanceOf \Domain\User\Entity\User)){
            $data['userId'] = $this->getEm()->getRepository("Domain\User\Entity\User")->find($data['userId']);
        }

        $data['token'] = $this->cryptService->hash(time(), $data['userId']->getSalt());
        $data['access'] = $this->cryptService->hash((time() * 2), $data['userId']->getSalt());


    	$this->response = parent::insert($data);

        if($this->response['status']){
            $this->response['data'] = $this->response['data']->toArray();
        }

        return $this->response;
    }

    public function update(array $data){

        if(isset($data['userId'])){
            unset($data['userId']);
        }


        return parent::update($data);

    }
}