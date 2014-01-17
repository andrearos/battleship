<?php
namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;

class EntityManager implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        $doctrineDbConfig = (array)$config['doctrine']['connection']['orm_default']['params'];
        $doctrinePathConfig = Setup::createAnnotationMetadataConfiguration($config['doctrine']['entity_path'],true);

        $entityManager = DoctrineEntityManager::create($doctrineDbConfig,$doctrinePathConfig);
        $entityManager->getConfiguration()->addEntityNamespace('e','Application\Entity');;

        return $entityManager;
    }
}