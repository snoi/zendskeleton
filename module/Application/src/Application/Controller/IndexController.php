<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
//use Zend\Mvc\Controller\Plugin\Redirect;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $msg = '';
        if (!$this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            $msg = 'Sorry, You do not have access to this page.';
            $this->flashmessenger()->addMessage($msg);
//            return $this->redirect()->toUrl('auth/login');
            return $this->redirect()->toRoute('login/process', array(
                'action' => 'login',
                'params' => 3
            ));
//            return $this->redirect()->toRoute('login',  array(
//                "__NAMESPACE__" => "Auth\Controller",
//                "controller" => "auth",
//                "action" => 'login',
//                'param1' => 'aaaa'));
        }
        $identity = $this->getServiceLocator()
                 ->get('AuthService')->getIdentity();
        print_r($identity);
//        $sessionConfig = new SessionConfig();
//        $sessionConfig->setOptions($config);
//        $sessionManager = new SessionManager($sessionConfig);
//        $sessionManager->start();
//        Container::setDefaultManager($sessionManager);
//        $sessionTimer = new Container('timer');
//        if ($sessionTimer && $sessionTimer->executionTime) {
//            return sprintf(
//                "Page rendered in %s seconds.", 
//                $sessionTimer->executionTime
//            );
//        }
        return new ViewModel();
    }
    
    public function messageAction() {
        
        //return $this->redirect()->toRoute('application/message');
    }
}
