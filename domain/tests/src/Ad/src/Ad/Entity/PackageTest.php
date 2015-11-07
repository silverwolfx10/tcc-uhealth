<?php
namespace Domain\Ad\Entity;
/**
 * Class UnitTest
 */
class PackageTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\Ad\Entity\Package';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Entidade Skill nao existe');
    }

    //insert feliz
    public function dataProviderValidAttributes(){
        return array(
            ['id', 1],
            ['adId', (new Ad())],
            ['personalId', (new \Domain\User\Entity\User())],
            ['days', 2],
            ['hours', 2],
            ['value', 125.60]
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
     * @expectedExceptionMessage Invalid value for AdId, must be an instance of Domain\Ad\Entity\Ad
     */
    public function testVerifyAdIdWrong(){
        $entity = new $this->classTested();
        $entity->setAdId(" ");
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
     * @expectedExceptionMessage Invalid value for days, must be an integer value
     */
    public function testVerifyDaysWrong(){
        $entity = new $this->classTested();
        $entity->setDays(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for hours, must be an integer value
     */
    public function testVerifyHoursWrong(){
        $entity = new $this->classTested();
        $entity->setHours(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for value, must be a float value
     */
    public function testVerifyValueWrong(){
        $entity = new $this->classTested();
        $entity->setValue(" ");
    }


    public function testVerifyHydrator(){
        $data = [
            'value' => 1.5
        ];

        $entity = new $this->classTested($data);
        $this->assertEquals($entity->getValue(), $data['value']);
    }

    public function testVerifyToArray(){

        $entity = new $this->classTested();
        $entity->setValue(3.8);
        $data = $entity->toArray();
        $this->assertTrue(is_array($data));
        $this->assertEquals($entity->getValue(), $data['value']);

    }
}