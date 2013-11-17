<?php

namespace Application\Form\Filter;

use \Zend\InputFilter\InputFilter;


class UserForm extends InputFilter
{
    /**
     * @var ServiceManager
     */
    protected $sm = null;

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $address;
    public $birthday;

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

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->firstname = (isset($data['firstname'])) ? $data['firstname'] : null;
        $this->lastname  = (isset($data['lastname']))  ? $data['lastname']  : null;
        $this->email  = (isset($data['email']))  ? $data['email']  : null;
        $this->password  = (isset($data['password']))  ? $data['password']  : null;
        $this->birthday  = (isset($data['birthday']))  ? $data['birthday']  : null;
        $this->address  = (isset($data['address']))  ? $data['address']  : null;
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