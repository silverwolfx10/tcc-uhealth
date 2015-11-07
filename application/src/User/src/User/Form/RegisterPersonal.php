<?php
namespace Application\User\Form;

use \Application\Base\Form\Form;
use \Application\Base\Form\Element\Text;
use \Application\Base\Form\Element\TextArea;

class RegisterPersonal extends Form
{
    public function __construct()
    {

        parent::__construct('registerPersonalForm');
        $this->setInputFilter(new Filter\RegisterPersonal());

        $id = new Text("id");
        $this->add($id);

        $cpf = new Text("cpf");
        $this->add($cpf);

        $cref = new Text("cref");
        $this->add($cref);

        $moip = new Text("moip");
        $this->add($moip);

    }
}
