<?php
namespace Domain\Ad\Entity;
/**
 * Class UnitTest
 */
class AvailableTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\Ad\Entity\Available';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Entidade Available nao existe');
    }

    //insert feliz
    public function dataProviderValidAttributes(){
        return array(
            ['id', 1],
            ['adId', (new Ad())],
            ['day', 'sunday'],
            ['hourIni', 2],
            ['hourEnd', 3]
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
     * @expectedExceptionMessage Invalid value for Day
     */
    public function testVerifyDayWrong(){
        $entity = new $this->classTested();
        $entity->setDay(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Day is not in array, must be sunday, monday, tuesday, wednesday, thursday, friday or saturday
     */
    public function testVerifyDayInexistentWrong(){
        $entity = new $this->classTested();
        $entity->setDay("Segunda");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for HourIni
     */
    public function testVerifyHourIniWrong(){
        $entity = new $this->classTested();
        $entity->setHourIni(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage HourIni must be in a range between 0 to 23
     */
    public function testVerifyHourIniInexistentWrong(){
        $entity = new $this->classTested();
        $entity->setHourIni(25);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for HourEnd
     */
    public function testVerifyHourEndWrong(){
        $entity = new $this->classTested();
        $entity->setHourEnd(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage HourEnd must be in a range between 0 to 23
     */
    public function testVerifyHourEndInexistentWrong(){
        $entity = new $this->classTested();
        $entity->setHourEnd(25);
    }

    public function testVerifyHydrator(){
        $data = [
            'hourIni' => 5,
            'hour_end' => 5
        ];

        $entity = new $this->classTested($data);
        $this->assertEquals($entity->getHourIni(), $data['hourIni']);
        $this->assertEquals($entity->getHourEnd(), $data['hour_end']);
    }

    public function testVerifyToArray(){

        $entity = new $this->classTested();
        $entity->setHourIni(3);
        $data = $entity->toArray();
        $this->assertTrue(is_array($data));
        $this->assertEquals($entity->getHourIni(), $data['hourIni']);

    }
}