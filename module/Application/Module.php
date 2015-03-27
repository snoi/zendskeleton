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
use Zend\Session\Config\SessionConfig; //For session
use Zend\Session\Container; //For session
use Zend\Session\SessionManager;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $this -> initAcl($e);
        $e->getApplication()->getEventManager()->attach('route', array($this, 'checkAcl'));
        
        //For session
        $this->initSession(array(
            'remember_me_seconds' => 180,
            'use_cookies' => true,
            'cookie_httponly' => true,
        ));
        
        //For session - create a new container and store some data
        $sessionTimer = new Container('cihuy');
        $sessionTimer->ada = 'test';
        $sessionTimer->endTime = (float) array_sum(explode(' ', microtime()));
        
        //For session - retrieve data
        $sessionTimer = new Container('cihuy');
        print_r($sessionTimer->ada);
        if ($sessionTimer && $sessionTimer->executionTime) {
            return sprintf(
                "Page rendered in %s seconds.", 
                $sessionTimer->executionTime
            );
        }
    }

    //For session
    public function initSession($config)
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
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
    
    public function initAcl(MvcEvent $e) {
 
    $acl = new \Zend\Permissions\Acl\Acl();
    $roles = include __DIR__ . '/config/module.acl.roles.php';
    $allResources = array();
//    print_r($roles);
    foreach ($roles as $role => $resources) {
 
        $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
        $acl -> addRole($role);
 
        $allResources = array_merge($resources, $allResources);
 
        //adding resources
        foreach ($resources as $resource) {
             // Edit 4
             if(!$acl ->hasResource($resource))
                $acl -> addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
        }
        //adding restrictions
//        foreach ($allResources as $resource) { //INHERITANCE
        foreach ($resources as $resource) {
            $acl -> allow($role, $resource);
        }
    }
//    $acl->deny('admin', 'usery', 'add');
    //testing
    //var_dump($acl->isAllowed('admin','home'));
    //true
 
    //setting to view
    $e -> getViewModel() -> acl = $acl;
 
}
 
public function checkAcl(MvcEvent $e) {
    $route = $e -> getRouteMatch() -> getMatchedRouteName();
    //you set your role
    $userRole = 'admin';
    print $route;
//    if (!$e -> getViewModel() -> acl -> isAllowed($userRole, $route)) { // jika ada route yg belum didefinisikan di resource, akan error
    if ($e -> getViewModel() -> acl ->hasResource($route) && !$e -> getViewModel() -> acl -> isAllowed($userRole, $route, 'add')) { //jika belum didefinisikan di resource, bisa diakses oleh semua
        $response = $e -> getResponse();
        //location to page or what ever
        $response -> getHeaders() -> addHeaderLine('Location', $e -> getRequest() -> getBaseUrl() . '/404');
        $response -> setStatusCode(404);
 
    }
}
}
