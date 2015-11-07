<?php
namespace Application\User\Form;

use \Application\Base\Form\Form;
use \Application\Base\Form\Element\Text;

class Login extends Form
{
    public function __construct()
    {
        parent::__construct('loginForm');
        $this->setInputFilter(new Filter\Login());

        $email = new Text("email");
        $this->add($email);

        $password = new Text("password");
        $this->add($password);

    }
}
