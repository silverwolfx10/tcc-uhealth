<?php
namespace Domain\Ad\Service;
/**
 * Class UnitTest
 */
class SkillPersistTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\Ad\Service\SkillPersist';
        parent::setUp($di);

    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Service SkillPersist existe');
    }

   
    public function testVerifyInsert(){

        $data = [
            'skill' => 'Personal Runner'
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