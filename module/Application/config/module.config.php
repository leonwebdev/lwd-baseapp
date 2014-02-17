<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '[/:lang]/',
                    'constraints' => array(
                        'lang' => '(en|fr)?',
                    ),
                    'defaults' => array(
                        //'lang' => 'fr',
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
            /* Routes for user */
            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\User',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'show' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/show/:id',
                            'constraints' => array(
                                'id' => '[1-9][0-9]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\User',
                                'action' => 'show',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'list' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/list',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\User',
                                'action' => 'list',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'transfer' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/transfer',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\User',
                                'action' => 'transfer',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'transfertable' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/transfertable',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\User',
                                'action' => 'transferTable',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
            /* Change route Zfcuser with lang */
            'zfcuser' => array(
                'type' => 'Segment',
                'priority' => 1000,
                'options' => array(
                    //'route' => '/user',
                    'route' => '[/:lang]/user',
                    'constraints' => array(
                        'lang' => '(dt|en|fr)?',
                    ),
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action' => 'index',
                        'lang' => 'dt'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'authenticate',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'register',
                            ),
                        ),
                    ),
                    'changepassword' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-password',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changepassword',
                            ),
                        ),
                    ),
                    'changeemail' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-email',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changeemail',
                            ),
                        ),
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
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
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'view_helpers' => array(
      'invokables' => array(
         'current_route' => '\Application\View\Helper\CurrentRoute',
         'current_parameters' => '\Application\View\Helper\CurrentParameters',
      ),
   ),
    // Navigation
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
            ),
//            array(
//                'label' => 'User',
//                'route' => 'zfcuser',
//                'pages' => array(
//                    array(
//                        'label' => 'Home',
//                        'route' => 'zfcuser',
//                        'action' => 'index',
//                    ),
////                    array(
////                        'label' => 'Edit',
////                        'route' => 'album',
////                        'action' => 'edit',
////                    ),
////                    array(
////                        'label' => 'Delete',
////                        'route' => 'album',
////                        'action' => 'delete',
////                    ),
//                ),
//            ),
        ),
        'user' => array(
            array(
                'label' => 'Home',
                'route' => 'zfcuser',
            ),
            array(
                'label' => 'User',
                'route' => 'zfcuser',
                'pages' => array(
                    array(
                        'label' => 'Home',
                        'route' => 'zfcuser',
                        'action' => 'index',
                    ),
//                    array(
//                        'label' => 'Edit',
//                        'route' => 'album',
//                        'action' => 'edit',
//                    ),
//                    array(
//                        'label' => 'Delete',
//                        'route' => 'album',
//                        'action' => 'delete',
//                    ),
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            // Template Menu Zfcuser
            'menu/logout' => __DIR__ . '/../view/layout/menu/logout.phtml',
            'menu/login-register' => __DIR__ . '/../view/layout/menu/login-register.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            // Template zfc-user login ovveride
            'zfc-user/user/login' => __DIR__ . '/../view/zfc-user/user/login.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
