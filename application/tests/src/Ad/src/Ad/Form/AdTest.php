<?php
namespace Application\Ad\Form;
/**
 * Class UnitTest
 */
class AdTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Application\Ad\Form\Ad';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Form Ad nao existe');
    }

    //verifica se classe existe
    public function testVerifyInValidate()
    {
        $form = new $this->classTested();
        $form->setData([]);

        $this->assertTrue(!$form->isValid(), 'Form Ad nao validou corretamente');
    }

    //verifica se classe existe
    public function testVerifyValidate()
    {
        $data = [
            'personalId' => 1,
            'graduate' => 'text',
            'rules' => 'text2',
            'rate' => 0
        ];
        $form = new $this->classTested();
        $form->setData($data);

        $this->assertTrue($form->isValid(), 'Form Ad nao validou corretamente');
        $this->assertEquals($data, $form->getData(), 'Form nao retornou os dados corretamente');
    }

    //verifica se classe existe
    public function testVerifyValidateEdit()
    {
        $data = [
            'id' => 1,
            'personalId' => 1,
            'graduate' => 'text',
            'rules' => 'text2',
            'rate' => 0
        ];
        $form = new $this->classTested('edit');
        $form->setData($data);

        $this->assertTrue($form->isValid(), 'Form Ad nao validou corretamente');
        $this->assertEquals($data, $form->getData(), 'Form nao retornou os dados corretamente');
    }


}