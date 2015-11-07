<?php 
namespace Application\User\Service;

use Domain\Ad\Service\AdPersist;
use \Domain\User\Service\UserPersist;
use \Infrastructure\Interfaces\Hydrator;
use \Application\User\Form\RegisterPersonal as RegisterPersonalForm;

class RegisterPersonal {

    private $userPersist;
    private $userRepository;
    private $hydrator;
    private $registerPersonalForm;
    private $response = [
        'data' => null,
        'messages' => null,
        'status' => true
    ];

	public function __construct(
        UserPersist $userPersist,
        $userRepository,
        Hydrator $hydrator,
        RegisterPersonalForm $registerPersonalForm,
        AdPersist $adPersist

    ) {

        $this->adPersist = $adPersist;
        $this->userPersist = $userPersist;
        $this->userRepository = $userRepository;
        $this->hydrator = $hydrator;
        $this->registerPersonalForm = $registerPersonalForm;

    }

    public function insert($data){

        $this->registerPersonalForm->setData($data);
        if(!$this->registerPersonalForm->isValid()){
            $this->response['status'] = false;
            $this->response['messages'] = $this->registerPersonalForm->getMessages();
            return $this->response;
        }

        $data = $this->registerPersonalForm->getData();
        $data['type'] = 'personal';
        $personal = $this->userRepository->findOneById($data['id']);
        $this->hydrator->hydrate($data, $personal);

        //insere o anúncio vazio
        $this->adPersist->insert(['personalId' => $personal]);

        return $this->userPersist->update($personal->toArray());
    }

    public function update($data){

        $this->registerPersonalForm->setData($data);
        if(!$this->registerPersonalForm->isValid()){
            $this->response['status'] = false;
            $this->response['messages'] = $this->registerPersonalForm->getMessages();
            return $this->response;
        }

        $data = $this->registerPersonalForm->getData();
        $data['type'] = 'personal';
        $personal = $this->userRepository->findOneById($data['id']);
        $this->hydrator->hydrate($data, $personal);

        return $this->userPersist->update($personal->toArray());
    }
}