<?php
namespace Application\Ad\Form;
/**
 * Class UnitTest
 */
class PackageTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Application\Ad\Form\Package';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Form Package nao existe');
    }

    //verifica se classe existe
    public function testVerifyInValidate()
    {
        $form = new $this->classTested();
        $form->setData([]);

        $this->assertTrue(!$form->isValid(), 'Form Package nao validou corretamente');
    }

    //verifica se classe existe
    public function testVerifyValidate()
    {
        $data = [
            'adId' => 1,
            'personalId' => 1,
            'days' => 3,
            'hours' => 10,
            'value' => 39.5
        ];
        $form = new $this->classTested();
        $form->setData($data);
        $form->isValid();


        $this->assertTrue($form->isValid(), 'Form Package nao validou corretamente');
        $this->assertEquals($data, $form->getData(), 'Form nao retornou os dados corretamente');
    }

    //verifica se classe existe
    public function testVerifyValidateEdit()
    {
        $data = [
            'id' => 1,
            'adId' => 1,
            'personalId' => 1,
            'days' => 3,
            'hours' => 10,
            'value' => 39.5
        ];
        $form = new $this->classTested('edit');
        $form->setData($data);

        $this->assertTrue($form->isValid(), 'Form Package nao validou corretamente');
        $this->assertEquals($data, $form->getData(), 'Form nao retornou os dados corretamente');
    }


}