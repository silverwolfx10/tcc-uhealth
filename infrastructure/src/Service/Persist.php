<?php 
namespace Infrastructure\Service;

use Zend\Stdlib\Hydrator\ClassMethods as ZendHydrator;
use Doctrine\ORM\EntityManager;
use Domain\Base\Interfaces\Entity;
use Infrastructure\Service\Hydrator;
/**
 * Para não depender diretamente de uma lib de terceiros
 **/
class Persist {

	protected $em;
	protected $entity;
    protected $response = [
        'status' => true,
        'messages' => null,
        'data' => null
    ];

	public function __construct(EntityManager $em) {
		$this->em = $em;
    }

 	public function getEm(){
        return $this->em;
    }

  	public function insert(array $data)
    {
        unset($data['id']);

        $entity = new $this->entity($data);
        
        $this->em->persist($entity);
        $this->em->flush();

        $this->response['data'] = $entity;
        return $this->response;
    }
    
    public function update(array $data)
    {
        if(!isset($data['id']))
            throw new \InvalidArgumentException('Key ID é obrigatória dentro do Array');

        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator())->hydrate($data, $entity);
        
        $this->em->persist($entity);
        $this->em->flush();

        $this->response['data'] = $entity;
        return $this->response;
    }
    
    public function delete($id)
    {
        $entity = $this->em->getReference($this->entity, $id);
        if($entity)
        {
            $this->em->remove($entity);
            $this->em->flush();
            return $id;
        }
    }
} 