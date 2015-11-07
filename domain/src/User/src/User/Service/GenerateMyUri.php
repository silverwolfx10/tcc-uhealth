<?php 
namespace Domain\User\Service;

use Doctrine\ORM\EntityManager;

class GenerateMyUri{

    private $em;

	public function __construct(EntityManager $em) {

        $this->em = $em;

    }

    public function generate($name){

        $name = str_replace(' ', '', ucfirst($name));
        $repository = $this->em->getRepository('Domain\User\Entity\User');

        while($repository->findOneByMyUri($name)){
            $name .= rand(1, 100);
        }

        return strtolower($name);
    }
}