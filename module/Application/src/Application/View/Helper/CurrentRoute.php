<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class CurrentRoute extends AbstractHelper implements ServiceLocatorAwareInterface
{

    public function __invoke()
    {
        $services = $this->getServiceLocator()->getServiceLocator();
        $router = $services->get('router');
        $request = $services->get('request');
        $routeMatch = $router->match($request);
        //var_dump($routeMatch);
        if ($routeMatch instanceof \Zend\Mvc\Router\Http\RouteMatch) {
            if ($routeMatch->getMatchedRouteName()) {
                return $routeMatch->getMatchedRouteName();
            }
        }
        return null;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

}