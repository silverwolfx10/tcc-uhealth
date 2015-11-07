<?php
namespace Domain\Ad\Service;
use Infrastructure\Service\ArrayCollection;
use \Domain\Ad\Entity\Skill;
use \Domain\Ad\Entity\Available;
use \Domain\Ad\Entity\Package;
use \Domain\Ad\Entity\Address;


/**
 * Class UnitTest
 */
class AdPersistTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\Ad\Service\AdPersist';
        parent::setUp($di);

    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Service AdPersist existe');
    }

   
    public function testVerifyInsert(){
        $skills = [];
        $skills[] = (new Skill(['id' => 1, 'skill' => 'ok']));

        $availables = new ArrayCollection();
        $availables[1] = (new Available(['id' => 1]));

        $packages = new ArrayCollection();
        $packages[1] = (new Package(['id' => 1]));

        $addresses = new ArrayCollection();
        $addresses[1] = (new Address(['id' => 1]));


        $data = [
            'personalId' => 1,
            'graduate' => 'Formado em Sistemas de Informação pela FIAP',
            'rules' => 'Não atendo finais de semana',
            'skills' => $skills,
            'availables' => $availables,
            'packages' => $packages,
            'addresses' => $addresses

        ];
        $persister = new $this->classTested($this->di->get('entityManager'));
        $persister->insert($data);

    }
    // /**
    //  * @expectedException InvalidArgumentException
    //  * @expectedExceptionMessage Invalid value for Name
    //  */
    // public function testVerifyNameWrong(){
    //     $entity = new $this->classTested();
    //     $entity->setName(" ");
    // }

    // /**
    //  * @expectedException InvalidArgumentException
    //  * @expectedExceptionMessage Invalid value for MyUri
    //  */
    // public function testVerifyMyUriWrong(){
    //     $entity = new $this->classTested();
    //     $entity->setMyUri(" ");
    // }

    //  /**
    //  * @expectedException InvalidArgumentException
    //  * @expectedExceptionMessage Invalid value for Email
    //  */
    // public function testVerifyEmailWrong(){
    //     $entity = new $this->classTested();
    //     $entity->setEmail(" ");
    // }

   

    //  /**
    //  * @expectedException InvalidArgumentException
    //  * @expectedExceptionMessage Invalid value for Moip
    //  */
    // public function testVerifyMoipWrong(){
    //     $entity = new $this->classTested();
    //     $entity->setMoip(" ");
    // }

    //  /**
    //  * @expectedException InvalidArgumentException
    //  * @expectedExceptionMessage Invalid value for Type
    //  */
    // public function testVerifyTypeWrong(){
    //     $entity = new $this->classTested();
    //     $entity->setType(" ");
    // }

    //  *
    //  * @expectedException InvalidArgumentException
    //  * @expectedExceptionMessage Type is not in array, must be user or personal
     
    // public function testVerifyTypeInexistentWrong(){
    //     $entity = new $this->classTested();
    //     $entity->setType("Usuário");
    // }

    //  /**
    //  * @expectedException InvalidArgumentException
    //  * @expectedExceptionMessage Invalid value for Status
    //  */
    // public function testVerifyStatusWrong(){
    //     $entity = new $this->classTested();
    //     $entity->setStatus(" ");
    // }

    // /**
    //  * @expectedException InvalidArgumentException
    //  * @expectedExceptionMessage Status is not in array, must be active, inactive or blocked
    //  */
    // public function testVerifyStatusInexistentWrong(){
    //     $entity = new $this->classTested();
    //     $entity->setStatus("Ativo");
    // }


    //  public function testVerifyHydrator(){
    //     $data = [
    //         'name' => 'Leandro',
    //         'email' => 'leandro@uhealth.com',
    //     ];

    //     $entity = new $this->classTested($data);
    //     $this->assertEquals($entity->getName(), $data['name']);
    //     $this->assertEquals($entity->getEmail(), $data['email']);
    // }

    // public function testVerifyToArray(){
       
    //     $entity = new $this->classTested();
    //     $entity->setName('Leandro');
    //     $data = $entity->toArray();
    //     $this->assertTrue(is_array($data));
    //     $this->assertEquals($entity->getName(), $data['name']);
        
    // }
}