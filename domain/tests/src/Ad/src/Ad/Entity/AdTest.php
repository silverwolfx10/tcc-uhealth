<?php
namespace Domain\Ad\Entity;

use Infrastructure\Service\ArrayCollection;
/**
 * Class UnitTest
 */
class AdTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\Ad\Entity\Ad';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Entidade User nao existe');
    }

    //insert feliz
    public function dataProviderValidAttributes(){

        $skills = new ArrayCollection();
        $skills[1] = (new Skill(['id' => 1]));

        $availables = new ArrayCollection();
        $availables[1] = (new Available(['id' => 1]));

        $packages = new ArrayCollection();
        $packages[1] = (new Package(['id' => 1]));

        $addresses = new ArrayCollection();
        $addresses[1] = (new Address(['id' => 1]));

        return array(
            ['id', 1],
            ['personalId', (new \Domain\User\Entity\User())],
            ['graduate', 'Formado em Sistemas de Informação pela FIAP'],
            ['rules', 'Não atendo idosos no periodo noturno'],
            ['rate', 9.5],
            ['skills', $skills],
            ['availables', $availables],
            ['packages', $packages],
            ['addresses', $addresses],
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
     * @expectedExceptionMessage Invalid value for Graduate
     */
    public function testVerifyGraduateWrong(){
        $entity = new $this->classTested();
        $entity->setGraduate(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Rules
     */
    public function testVerifyRulesWrong(){
        $entity = new $this->classTested();
        $entity->setRules(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Rate, must be a float value
     */
    public function testVerifyRateWrong(){
        $entity = new $this->classTested();
        $entity->setRate(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Skills, must be an instance of Infrastructure\Service\ArrayCollection
     */
    public function testVerifySkillsWrong(){
        $entity = new $this->classTested();
        $entity->setSkills(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Skills, ArrayCollection must be empty or populated with instances of Domain\Ad\Entity\Skill
     */
    public function testVerifySkillsWrongCollection(){
        $entity = new $this->classTested();

        $availables = new ArrayCollection();
        $availables[] = (new Available(['id' => 1]));
        $availables[] = (new Available(['id' => 2]));

        $entity->setSkills($availables);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Availables, must be an instance of Infrastructure\Service\ArrayCollection
     */
    public function testVerifyAvailablesWrong(){
        $entity = new $this->classTested();
        $entity->setAvailables(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Availables, ArrayCollection must be empty or populated with instances of Domain\Ad\Entity\Available
     */
    public function testVerifyAvailablesWrongCollection(){
        $entity = new $this->classTested();

        $skills = new ArrayCollection();
        $skills[] = (new Skill(['id' => 1]));
        $skills[] = (new Skill(['id' => 2]));

        $entity->setAvailables($skills);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Packages, must be an instance of Infrastructure\Service\ArrayCollection
     */
    public function testVerifyPackagesWrong(){
        $entity = new $this->classTested();
        $entity->setPackages(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Packages, ArrayCollection must be empty or populated with instances of Domain\Ad\Entity\Package
     */
    public function testVerifyPackagesWrongCollection(){
        $entity = new $this->classTested();

        $skills = new ArrayCollection();
        $skills[] = (new Skill(['id' => 1]));
        $skills[] = (new Skill(['id' => 2]));

        $entity->setPackages($skills);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Addresses, must be an instance of Infrastructure\Service\ArrayCollection
     */
    public function testVerifyAddressesWrong(){
        $entity = new $this->classTested();
        $entity->setAddresses(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for Addresses, ArrayCollection must be empty or populated with instances of Domain\Ad\Entity\Address
     */
    public function testVerifyAddressesWrongCollection(){
        $entity = new $this->classTested();

        $skills = new ArrayCollection();
        $skills[] = (new Skill(['id' => 1]));
        $skills[] = (new Skill(['id' => 2]));

        $entity->setAddresses($skills);
    }

     public function testVerifyHydrator(){
        $data = [
            'graduate' => 'Formado em Sistemas de Informação pela FIAP'
        ];

        $entity = new $this->classTested($data);
        $this->assertEquals($entity->getGraduate(), $data['graduate']);
     }

    public function testVerifyToArray(){

        $entity = new $this->classTested();
        $entity->setGraduate('Formado em Sistemas de Informação pela FIAP');
        $data = $entity->toArray();
        $this->assertTrue(is_array($data));
        $this->assertEquals($entity->getGraduate(), $data['graduate']);

    }
}