<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // Init Session
        $this->bootstrapSession($e);

        // Init language
        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, function($e) {
                    $container = new Container('zfcuser');
                    if (!isset($container->locale)) {
                        $container->locale = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
                        $container->fallbackLocale = 'fr_FR';
                    }

                    $lang = $e->getRouteMatch()->getParam('lang');
                    $translator = $e->getApplication()->getServiceManager()->get('translator');
                    var_dump($lang);
                    if (!in_array($lang, array('fr', 'en'))) {
                        $lang = substr($container->locale, 0, 2);
                        var_dump($lang);
                        $application = $e->getApplication();
                        $sm = $application->getServiceManager();
                        $sharedManager = $application->getEventManager()->getSharedManager();
                        $router = $sm->get('router');
                        $request = $sm->get('request');
                        $routeMatch = $router->match($request);
                        $routeMatch->setParam('lang', $lang);
                    }
                    switch ($lang) {
                        case 'fr' :
                            //echo 'francais';
                            $translator->setLocale('fr_FR');
                            $container->locale = 'fr_FR';
                            //Locale::setDefault('fr_FR');
                            break;
                        case 'en' :
                            //echo 'francais';
                            $translator->setLocale('en_US');
                            $container->locale = 'en_US';
                            //Locale::setDefault('en_US');
                            break;
                        default :
                            $translator->setLocale('fr_FR');
                            $container->locale = 'fr_FR';
                            //Locale::setDefault('fr_FR');
                            break;
                    }


                    $serviceManager = $e->getApplication()->getServiceManager();
                    $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
                    $viewModel->langSite = $lang;
                });
    }

    public function bootstrapSession($e)
    {
//        $session = $e->getApplication()
//                     ->getServiceManager()
//                     ->get('Zend\Session\SessionManager');
//                     
//        $session->start();
        // lwd contient infos de l'application
        //$container = new \Zend\Session\Container('zfcuser');
        $container = new Container('zfcuser');
        $session = $container->getManager();

        // initialisation
        if (!isset($container->init)) {
            $session->regenerateId(true);
            $container->init = 1;
        }
    }

//    public function setLocale(MvcEvent $e) {
//        // query lang in url
//        $container = new Container('lwd');
//        $translator = $e->getApplication()->getServiceManager()->get('translator');
//        $translator->setLocale($container->locale)
//                   ->setFallbackLocale($container->fallbackLocale);
//    }
//    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Session\SessionManager' => function ($sm) {
                    $config = $sm->get('config');
                    if (isset($config['session'])) {
                        $session = $config['session'];

                        $sessionConfig = null;
                        if (isset($session['config'])) {
                            $class = isset($session['config']['class']) ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                            $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                            $sessionConfig = new $class();
                            $sessionConfig->setOptions($options);
                        }

                        $sessionStorage = null;
                        if (isset($session['storage'])) {
                            $class = $session['storage'];
                            $sessionStorage = new $class();
                        }

                        $sessionSaveHandler = null;
                        if (isset($session['save_handler'])) {
                            // class should be fetched from service manager since it will require constructor arguments
                            $sessionSaveHandler = $sm->get($session['save_handler']);
                        }

                        $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);

                        if (isset($session['validators'])) {
                            $chain = $sessionManager->getValidatorChain();
                            foreach ($session['validators'] as $validator) {
                                $validator = new $validator();
                                $chain->attach('session.validate', array($validator, 'isValid'));
                            }
                        }
                    } else {
                        $sessionManager = new SessionManager();
                    }
                    Container::setDefaultManager($sessionManager);
                    return $sessionManager;
                },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
//                'Application\View\Helper\CurrentRoute' => function() {
//                    $helper = new \Application\View\Helper\CurrentRoute();
//                    return $helper;
//                },
//                'Application\View\Helper\CurrentParameters' => function() {
//                    $helper = new \Application\View\Helper\CurrentParameters();
//                    return $helper;
//                },
                'picture_50x50' => function() {
                    $helper = new \Admin\View\Helper\Picture50x50();
                    return $helper;
                },
                'picture_80x80' => function() {
                    $helper = new \Admin\View\Helper\Picture80x80();
                    return $helper;
                },
                'picture_180x180' => function() {
                    $helper = new \Admin\View\Helper\Picture180x180();
                    return $helper;
                },
                'picture_310x310' => function() {
                    $helper = new \Admin\View\Helper\Picture310x310();
                    return $helper;
                },
                'picture_w620' => function() {
                    $helper = new \Admin\View\Helper\PictureW620();
                    return $helper;
                },
            )
        );
    }

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

}
