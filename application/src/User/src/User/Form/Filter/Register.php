<?php

namespace Application\User\Form\Filter;

use  \Application\Base\Form\InputFilter;

class Register  extends InputFilter
{
    public function __construct($type = 'insert')
    {
        $verify = $type === 'insert';
        if($type === 'edit') {
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
        }

        $this->add(array(
            'name'=>'name',
            'required'=>$verify,
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Application\Base\Form\Validator\NotEmpty::IS_EMPTY => 'O campo nome deve ser preenchido',
                        ),
                    ),
                )
            )
        ));


        $this->add(array(
            'name'=>'email',
            'required'=> $verify,
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
            'required'=>$verify,
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

        $this->add(array(
            'name'=>'repeatPassword',
            'required'=>$verify ,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'Identical',
                    'options'=>array(
                        'token'=>'password',
                        'messages'=>array(\Application\Base\Form\Validator\Identical::NOT_SAME=>'As senhas devem ser idênticas')
                    ),

                ),
                array(
                    'name'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>array(
                            'isEmpty'=>'Confirmação de senha não pode estar em branco'
                        )
                    )
                )
            )
        ));

    }

}
