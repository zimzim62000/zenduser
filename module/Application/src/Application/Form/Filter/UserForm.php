<?php

namespace Application\Form\Filter;

use \Zend\InputFilter\InputFilter;


class UserForm extends InputFilter
{
    /**
     * @var ServiceManager
     */
    protected $sm = null;

    /**
     * Set service manager
     *
     * @param ServiceManager $sm
     *
     * @return $this
     */
    public function setServiceManager(ServiceManager $sm)
    {
        $this->sm = $sm;
        return $this;
    }

    /*
     * Get service manager
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->sm;
    }

    public function __construct($sm)
    {
        $this->add(array(
            'name'  =>  'firstname',
            'required'  =>  true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 128,
                    ),
                ),
            )
        ));

        $this->add(array(
            'name'  =>  'lastname',
            'required'  =>  true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 128,
                    ),
                ),
            )
        ));

        $this->add(array(
            'name'  =>  'email',
            'required'  =>  true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'EmailAddress',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 128,
                    ),
                ),
            )
        ));

        $this->add(array(
            'name'  =>  'password',
            'required'  =>  true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 8,
                        'max'      => 15,
                    ),
                ),
            )
        ));


        $this->add(array(
            'name'  =>  'address',
            'required'  =>  false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            )
        ));


        $this->add(array(
            'name'  =>  'birthday',
            'required'  =>  false,
            'validators' => array(
                array( 'name' =>'date'),
            )
        ));
    }
}