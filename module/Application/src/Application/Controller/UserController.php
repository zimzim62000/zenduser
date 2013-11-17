<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class UserController extends AbstractActionController
{
    public function listAction()
    {
        /* get parameters */
        $order_by = $this->params()->fromRoute('order_by');
        $order = $this->params()->fromRoute('order');

        /** @var $repoUser \Application\Mapper\User */
        $repoUser = $this->getServiceLocator()->get('entity_manager')
            ->getRepository('Application\Entity\User');

        return new ViewModel(array(
            'users' =>  $repoUser->fetchSortable($order_by, $order),
            'sortable' => $this->_setListSortable($order_by, $order)
        ));
    }

    public function addAction()
    {
        /* @var $form \Application\Form\UserForm */
        $form = $this->getServiceLocator()->get('formElementManager')->get('form.user');

        $data = $this->prg();

        if ($data instanceof \Zend\Http\PhpEnvironment\Response) {
            return $data;
        }

        if ($data != false) {
            $form->setData($data);
            if ($form->isValid()) {

                /* @var $user \Application\Entity\User */
                $user = $form->getData();

                /* @var $serviceUser \Application\Service\UserService */
                $serviceUser = $this->getServiceLocator()->get('application.service.user');

                $serviceUser->saveUser($user);

                $this->redirect()->toRoute('users');
            }
        }

        return new ViewModel(array(
            'form'  =>  $form
        ));
    }

    public function removeAction()
    {
        $em = $this->getServiceLocator()->get('entity_manager');

        /* @var $userTodelete \Application\Entity\User */
        $userTodelete = $em->getRepository('Application\Entity\User')
            ->find($this->params()->fromRoute('user_id'));

        /* @var $serviceuser \Application\Service\UserService */
        $serviceuser = $this->getServiceLocator()->get('application.service.user');

        if(isset($userTodelete)){
            $serviceuser->removeUser($userTodelete);
        }

        $this->redirect()->toRoute('users');
    }

    public function editAction()
    {
        $em = $this->getServiceLocator()->get('entity_manager');

        /* @var $form \Application\Form\UserForm */
        $form = $this->getServiceLocator()->get('formElementManager')->get('form.user');
        $userToEdit = $em->getRepository('Application\Entity\User')
            ->find($this->params()->fromRoute('user_id'));

        $form->bind($userToEdit);

        /* set profile field */
        $form->get('firstname')->setValue($userToEdit->getFirstName());
        $form->get('lastname')->setValue($userToEdit->getLastName());
        $form->get('address')->setValue($userToEdit->getAddress());
        $form->get('birthday')->setValue($userToEdit->getBirthday()->format('Y-m-d'));

        $data = $this->prg();

        if ($data instanceof \Zend\Http\PhpEnvironment\Response) {
            return $data;
        }

        if ($data != false) {
            /* if password empty no validate it*/
            if($data['password'] === ''){
                $form->setValidationGroup(array('firstname', 'lastname', 'email', 'address', 'birthday'));
            }
            $form->setData($data);
            if ($form->isValid()) {

                /* @var $user \Application\Entity\User */
                $user = $form->getData();

                /* @var $serviceuser \Application\Service\UserService */
                $serviceuser = $this->getServiceLocator()->get('application.service.user');
                $serviceuser->saveUser($user);

                $this->redirect()->toRoute('users');
            }
        }

        return new ViewModel(array(
            'form'  =>  $form
        ));
    }

    private function _setOrder($order)
    {
        if($order === 'ASC'){
            return 'DESC';
        }
        return 'ASC';
    }

    private function _setListSortable($order_by, $order)
    {
        $sortable = array(
            'id' => $this->url()->fromRoute('users', array(
                    'order_by' => 'u.id',
                    'order' => ($order_by == 'u.id' ? $this->_setOrder($order) : 'ASC'))
            ),
            'firstName' => $this->url()->fromRoute('users', array(
                    'order_by' => 'p.firstName',
                    'order' => ($order_by == 'p.firstName' ? $this->_setOrder($order) : 'ASC'))
            ),
            'lastName' => $this->url()->fromRoute('users', array(
                    'order_by' => 'p.lastName',
                    'order' => ($order_by == 'p.lastName' ? $this->_setOrder($order) : 'ASC'))
            ),
            'email' => $this->url()->fromRoute('users', array(
                    'order_by' => 'u.email',
                    'order' => ($order_by == 'u.email' ? $this->_setOrder($order) : 'ASC'))
            ),
            'birthday' => $this->url()->fromRoute('users', array(
                    'order_by' => 'p.birthday',
                    'order' => ($order_by == 'p.birthday' ? $this->_setOrder($order) : 'ASC'))
            ),
            'address' => $this->url()->fromRoute('users', array(
                    'order_by' => 'p.address',
                    'order' => ($order_by == 'p.address' ? $this->_setOrder($order) : 'ASC'))
            )
        );
        return $sortable;
    }
}