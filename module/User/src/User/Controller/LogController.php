<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManager;

class LogController extends AbstractActionController
{

    public function outAction()
    {
        $auth = $this->serviceLocator->get('auth');
        $auth->clearIdentity();
        return $this->redirect()->toRoute('home');
    }

    public function inAction()
    {
        if (!$this->getRequest()->isPost()) {
            // @todo: just show the login form
            return array();
        }

        $username = $this->params()->fromPost('username');
        $password = $this->params()->fromPost('password');

        $auth = $this->serviceLocator->get('auth');
        $authAdapter = $auth->getAdapter();

        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);

        $result = $auth->authenticate();
        $isValid = $result->isValid();
        if($isValid) {
            // $user = $result->getIdentity();

            // @todo: upon successful validation store additional information about him in the auth storage

            // $this->flashmessenger()->addSuccessMessage(sprintf('Benvenuto %s.',$user->getName()));

            return $this->redirect()->toRoute('home');
        } else {
            $event = new EventManager('user');
            $event->trigger('log-fail', $this, array('username'=> $username));

            return array('errors' => $result->getMessages());
        }
    }
}
