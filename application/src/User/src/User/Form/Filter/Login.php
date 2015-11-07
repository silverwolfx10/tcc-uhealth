<?php

namespace Application\User\Form\Filter;

use  \Application\Base\Form\InputFilter;

class Login  extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'=>'email',
            'required'=> true,
            'validators' => array(
                array(
                    'name'=>'EmailAddress',
                    'options'=>array(
                        'messages' => array(
                            \Application\Base\Form\Validator\EmailAddress::INVALID_FORMAT => 'Endereço de email inválido'
                        )
                    )
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Application\Base\Form\Validator\NotEmpty::IS_EMPTY => 'O campo email deve ser preenchido',
                        ),
                    ),
                )
            )
        ));

        $this->add(array(
            'name'=>'password',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>array(
                            'isEmpty'=>'Senha não pode estar em branco'
                        )
                    )
                )
            )
        ));
    }

}
