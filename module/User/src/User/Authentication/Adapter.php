<?php
namespace User\Authentication;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Adapter extends AbstractAdapter implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function authenticate() {
        $entityManager = $this->serviceLocator->get('entity-manager');
        $userEntityClassName = get_class($this->serviceLocator->get('user-entity'));

        $user = $entityManager->getRepository($userEntityClassName)->findOneByUsername($this->identity);

        if($user && $user->verifyPassword($this->credential)) {
            return new Result(Result::SUCCESS,$user);
        }

        return new Result(Result::FAILURE,$this->identity);
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}