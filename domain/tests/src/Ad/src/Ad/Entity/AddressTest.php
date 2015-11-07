<?php
namespace Domain\Ad\Entity;
/**
 * Class UnitTest
 */
class AddressTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\Ad\Entity\Address';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Entidade Address nao existe');
    }

    //insert feliz
    public function dataProviderValidAttributes(){
        return array(
            ['id', 1],
            ['adId', (new Ad())],
            ['CEP', '06823465'],
            ['number', 416],
            ['streetId', 3],
            ['hoodId', 83],
            ['hoodName', 'Jardim Santo Eduardo'],
            ['cityId', 3],
            ['cityName', 'Embu das Artes'],
            ['ufId', 3],
            ['ufName', 'SP'],
            ['lat', 4515151.3],
            ['lng', 5451515.8]

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
     * @expectedExceptionMessage Invalid value for CEP
     */
    public function testVerifyCEPWrong(){
        $entity = new $this->classTested();
        $entity->setCEP(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Number, must be an integer value
     */
    public function testVerifyNumberWrong(){
        $entity = new $this->classTested();
        $entity->setNumber(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for StreetId, must be an integer value
     */
    public function testVerifyStreetIdWrong(){
        $entity = new $this->classTested();
        $entity->setStreetId(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for HoodId, must be an integer value
     */
    public function testVerifyHoodIdWrong(){
        $entity = new $this->classTested();
        $entity->setHoodId(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for HoodName
     */
    public function testVerifyHoodNameWrong(){
        $entity = new $this->classTested();
        $entity->setHoodName(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for CityId, must be an integer value
     */
    public function testVerifyCityIdWrong(){
        $entity = new $this->classTested();
        $entity->setCityId(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for CityName
     */
    public function testVerifyCityNameWrong(){
        $entity = new $this->classTested();
        $entity->setCityName(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for UfId, must be an integer value
     */
    public function testVerifyUfIdWrong(){
        $entity = new $this->classTested();
        $entity->setUfId(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for UfName
     */
    public function testVerifyUfNameWrong(){
        $entity = new $this->classTested();
        $entity->setUfName(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Lat, must be an float value
     */
    public function testVerifyLatWrong(){
        $entity = new $this->classTested();
        $entity->setLat(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Lng, must be an float value
     */
    public function testVerifyLngWrong(){
        $entity = new $this->classTested();
        $entity->setLng(" ");
    }

    public function testVerifyHydrator(){
        $data = [
            'lat' => 5.56568,
            'lng' => 5.87894
        ];

        $entity = new $this->classTested($data);
        $this->assertEquals($entity->getLat(), $data['lat']);
        $this->assertEquals($entity->getLng(), $data['lng']);
    }

    public function testVerifyToArray(){

        $entity = new $this->classTested();
        $entity->setLat(3.888);
        $data = $entity->toArray();
        $this->assertTrue(is_array($data));
        $this->assertEquals($entity->getLat(), $data['lat']);

    }
}