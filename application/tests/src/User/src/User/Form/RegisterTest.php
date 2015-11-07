<?php
namespace Application\User\Form;
/**
 * Class UnitTest
 */
class RegisterTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Application\User\Form\Register';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Form Register nao existe');
    }

    //verifica se classe existe
    public function testVerifyInValidate()
    {
        $form = new $this->classTested();
        $form->setData([]);

        $this->assertTrue(!$form->isValid(), 'Form Register nao validou corretamente');
    }

    public function testVerifyValidate()
    {
        $data = [
            'name' => 'teste',
            'email' => 'teste@teste.com.br',
            'password' => '123456',
            'repeatPassword' => '123456',
        ];
        $form = new $this->classTested();
        $form->setData($data);

        $this->assertTrue($form->isValid(), 'Form Register nao validou corretamente');
        $this->assertEquals($data, $form->getData(), 'Form nao retornou os dados corretamente');
    }

    public function testVerifyValidateEdit()
    {
        $data = [
            'id' => 1,
            'name' => 'teste',
            'email' => 'teste@teste.com.br',
            'password' => '123456',
            'repeatPassword' => '123456',
        ];
        $form = new $this->classTested('edit');
        $form->setData($data);

        $this->assertTrue($form->isValid(), 'Form Register nao validou corretamente');
        $this->assertEquals($data, $form->getData(), 'Form nao retornou os dados corretamente');
    }

    public function testVerifyValidateEmailInvalid()
    {
        $data = [
            'id' => 1,
            'name' => 'teste',
            'email' => 'teste@teste',
            'password' => '123456',
            'repeatPassword' => '123456',
        ];
        $form = new $this->classTested();
        $form->setData($data);

        $this->assertTrue(!$form->isValid(), 'Form Register nao validou corretamente');
        $this->assertTrue(is_array($form->getMessages()['email']), 'Form nao retornou os dados corretamente');
    }

    public function testVerifyValidateRepeatPasswordInvalid()
    {
        $data = [
            'id' => 1,
            'name' => 'teste',
            'email' => 'teste@teste.com.br',
            'password' => '123456',
            'repeatPassword' => '1234567',
        ];
        $form = new $this->classTested();
        $form->setData($data);

        $this->assertTrue(!$form->isValid(), 'Form Register nao validou corretamente');
        $this->assertTrue(is_array($form->getMessages()['repeatPassword']), 'Form nao retornou os dados corretamente');
    }


}