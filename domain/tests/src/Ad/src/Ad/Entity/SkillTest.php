<?php
namespace Domain\Ad\Entity;
/**
 * Class UnitTest
 */
class SkillTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\Ad\Entity\Skill';
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
            ['skill', 'Condicionamento físico para idosos']
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
     * @expectedExceptionMessage Invalid value for Skill
     */
    public function testVerifySkillWrong(){
        $entity = new $this->classTested();
        $entity->setSkill(" ");
    }

    public function testVerifyHydrator(){
        $data = [
            'skill' => 'Leandro'
        ];

        $entity = new $this->classTested($data);
        $this->assertEquals($entity->getSkill(), $data['skill']);
    }

    public function testVerifyToArray(){

        $entity = new $this->classTested();
        $entity->setSkill('Leandro');
        $data = $entity->toArray();
        $this->assertTrue(is_array($data));
        $this->assertEquals($entity->getSkill(), $data['skill']);

    }
}