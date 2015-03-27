<?php
//module/Auth/Module.php
namespace Auth;
 
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
 
class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
        /*common code*/}
    public function getConfig() { 
        return include __DIR__ . '/config/module.config.php';
    }
     
    public function getServiceConfig()
    {
        return array(
            'factories'=>array(
                'Auth\Model\MyAuthStorage' => function($sm){
                    return new \Auth\Model\MyAuthStorage('zf_tutorial'); 
                },
         
                'AuthService' => function($sm) {
                    //My assumption, you've alredy set dbAdapter
                    //and has users table with columns : user_name and pass_word
                    //that password hashed with md5
                    $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter,
                                          'user','user_name','pass_word', 'MD5(?)');

                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('Auth\Model\MyAuthStorage'));

                    return $authService;
                },
            ),
        );
    }
 
}