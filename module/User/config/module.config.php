<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\Account' => 'User\Controller\AccountController',
            'User\Controller\Log'     => 'User\Controller\LogController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Account',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'account' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/account/[:action[/:id]]',
                            'defaults' => array(
                                'controller' => 'User\Controller\Account',
                                'action' => 'index',
                            )
                        )
                    ),
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'entity-manager' => 'Application\Service\Factory\EntityManager',
            'auth' 	       => 'User\Service\Factory\Authentication',
        ),
        'invokables' => array(
            'user-entity' => 'Application\Entity\User',
            'auth-adapter' 	=> 'User\Authentication\Adapter',
        ),
        'shared' => array(
            'user-entity' => false,
        )
    ),
);
