<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;

class User extends Form
{
    public function __construct($name='user')
    {
        parent::__construct($name);

        $this->setAttribute('method','post');

        // definizione dell'elemento "email"
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email', // si può usare anche 'email'
            'options' => array(
                'label' => 'Email:'
            ),
            'attributes' => array(
                'type' => 'email',
                'required' => true,
                'placeholder' => 'Indirizzo email...',
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password:'
            ),
            'attributes' => array(
                'required' => true,
                'placeholder' => 'Inserisci una password...',
            )
        ));

        $this->add(array(
            'name' => 'password_verify',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password:'
            ),
            'attributes' => array(
                'required' => true,
                'placeholder' => 'Ripeti la password...',
            )
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Nome:'
            ),
            'attributes' => array(
                'required' => true,
                'placeholder' => 'Inserisci il nome...',
            )
        ));

        $this->add(array(
            'name' => 'phone',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Numero di telefono:'
            ),
            'attributes' => array(
                'type' => 'tel',
                'required' => true,
                'placeholder' => 'Inserisci il numero di telefono...',
                'pattern' => '^[\d-/]+$'
            ),
        ));

        $this->add(array(
            'name' => 'photo',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'La tua foto:'
            ),
            'attributes' => array(
                'required' => true,
                'id' => 'photo',
            ),
        ));

        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salva',
                'required' => false,
            )
        ));
    }

    public function getInputFilter()
    {
        if(!$this->filter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'messages' => array(
                                'emailAddressInvalidFormat' => 'Il formato dell\'indirizzo email non è valido'
                            )
                        )
                    ),
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'L\'indirizzo email è richiesto'
                            )
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'name',
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Il nome è richiesto'
                            )
                        )
                    ),
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'password',
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'La password è richiesta'
                            )
                        )
                    ),
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'password_verify',
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'identical',
                        'options' => array(
                            'token' => 'password',
                            'messages' => array(
                                'notSame' => 'Le password non corrispondono'
                            )
                        )
                    ),
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'photo',
                'filters' => array(
                    array(
                        'name' => 'filerenameupload',
                        'options' => array(
                            'target' => 'data/images/photos/',
                            'randomize' => true,
                        ),
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'filesize',
                        'options' => array(
                            'max' => 2097152, // 2 MB
                        ),
                    ),
                    array(
                        'name' => 'filemimetype',
                        'options' => array(
                            'mimeType' => 'image/png,image/x-png,image/jpg,image/jpeg,image/gif',
                        )
                    ),
                    array(
                        'name' => 'fileimagesize',
                        'options' => array(
                            'maxWidth' => 20000,
                            'maxHeight' => 20000
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'phone',
                'filters' => array(
                    array('name' => 'digits'),
                    array('name' => 'stringtrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/^[\d-\/]+$/'
                        )
                    )
                )
            )));

            $this->filter = $inputFilter;
        }
        return $this->filter;
    }

}