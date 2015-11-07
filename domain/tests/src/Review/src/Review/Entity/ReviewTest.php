<?php
namespace Domain\Review\Entity;
/**
 * Class UnitTest
 */
class ReviewTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\Review\Entity\Review';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Entidade Review nao existe');
    }

    //insert feliz
    public function dataProviderValidAttributes(){
        return array(
            ['id', 1],
            ['userId', (new \Domain\User\Entity\User())],
            ['personalId', (new \Domain\User\Entity\User())],
            ['rate', 9.9],
            ['comment', 'Personal muito atencioso, voltarei a fazer negócios com ele'],
        );
    }

    /**
     * @dataProvider dataProviderValidAttributes
     */
    public function testVerifyGettersAndSetters($field, $value){
        $entity = new $this->classTested();

        $set = 'set' . ucfirst($field);
        $get = 'get' . ucfirst($field);

        $entity->$set($value);

        $this->assertEquals($entity->$get(), $value);

    }
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for personalId, must be an instance of Domain\User\Entity\User
     */
    public function testVerifyPersonalIdWrong(){
        $entity = new $this->classTested();
        $entity->setPersonalId(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for userId, must be an instance of Domain\User\Entity\User
     */
    public function testVerifyUserIdWrong(){
        $entity = new $this->classTested();
        $entity->setUserId(" ");
    }


    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for comment
     */
    public function testVerifyCommentWrong(){
        $entity = new $this->classTested();
        $entity->setComment(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid rate for value, must be a float value
     */
    public function testVerifyRateWrong(){
        $entity = new $this->classTested();
        $entity->setRate(" ");
    }


    public function testVerifyHydrator(){
        $data = [
            'rate' => 1.5
        ];

        $entity = new $this->classTested($data);
        $this->assertEquals($entity->getRate(), $data['rate']);
    }

    public function testVerifyToArray(){

        $entity = new $this->classTested();
        $entity->setRate(3.8);
        $data = $entity->toArray();
        $this->assertTrue(is_array($data));
        $this->assertEquals($entity->getRate(), $data['rate']);

    }
}