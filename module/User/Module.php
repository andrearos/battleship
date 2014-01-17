<?php
namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'protectPage'), -100);
    }

    public function protectPage(MvcEvent $event)
    {
        $match = $event->getRouteMatch();
        if(!$match) {
            // we cannot do anything without a resolved route
            return;
        }

        $controller = $match->getParam('controller');
        $action     = $match->getParam('action');
        $namespace  = $match->getParam('__NAMESPACE__');

        $services = $event->getApplication()->getServiceManager();
        $auth = $services->get('auth');
        if (!$auth->hasIdentity()) {
            // Set the response code to HTTP 401: Auth Required
            $response = $event->getResponse();
            $response->setStatusCode(401);

            $match->setParam('controller', 'User\Controller\Log');
            $match->setParam('action', 'in');
        }
    }
}
