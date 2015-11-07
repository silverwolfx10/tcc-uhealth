<?php
namespace Application\User\Form;

use \Application\Base\Form\Form;
use \Application\Base\Form\Element\Text;

class Register extends Form
{
    public function __construct($type = 'insert')
    {

        parent::__construct('userForm');
        $this->setInputFilter(new Filter\Register($type));

        if($type === 'edit') {
            $id = new Text("id");
            $this->add($id);
        }

        $name = new Text("name");
        $this->add($name);

        $email = new Text("email");
        $this->add($email);

        $password = new Text("password");
        $this->add($password);

        $repeatPassword = new Text("repeatPassword");
        $this->add($repeatPassword);


    }
}
