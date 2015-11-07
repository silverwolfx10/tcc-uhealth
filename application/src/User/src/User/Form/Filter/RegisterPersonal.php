<?php

namespace Application\User\Form\Filter;

use  \Application\Base\Form\InputFilter;

class RegisterPersonal  extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'id',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Application\Base\Form\Validator\NotEmpty::IS_EMPTY => 'O campo id deve ser preenchido',
                        ),
                    ),
                )
            )
        ));

        $this->add(array(
            'name'=>'cpf',
            'required'=> true,
            'filters' => array(
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'name'=>'Application\Base\Form\Validator\CPF'
                ),
            )
        ));

        $this->add(array(
            'name'=>'cref',
            'required'=> true,
            'filters' => array(
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                ),
            )
        ));

        $this->add(array(
            'name' => 'moip',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Application\Base\Form\Validator\NotEmpty::IS_EMPTY => 'O campo moip deve ser preenchido',
                        ),
                    ),
                )
            )
        ));

    }

}
