<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Zend\Db\Adapter\Driver\ResultInterface;
//use Zend\Db\ResultSet\ResultSet;
use User\Model\UserTable;
use User\Model\RoleTable;
use User\Form\UserAdd;

class UserController extends AbstractActionController {
    
    public function indexAction() {   
//        $sm = $this->getServiceLocator(); 
//        $dbAdapter = $sm->get('Application/Model/UserTable');
//        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $adapter = $this->_getAdapter();
        $userTable = new UserTable($adapter);
        $resultSet = $userTable->getData();
        $resultSet2 = $userTable->getDataById(2);
        $where = array('user_name' => 'admin', 'id' => 1);
        $r3 = $userTable->getDataBy($where);
        
        return new ViewModel(array("users" => $resultSet,
                                   "users2" => $resultSet2,
                                   "users3" => $r3
            ));
    }
    
    public function roleAction() {
        $adapter = $this->_getAdapter();
        $roleTable = new RoleTable($adapter);
        $result = $roleTable->getData();
        return new ViewModel(
                array('roles' => $result)
        );
    }


    public function addAction() {
        $adapter = $this->_getAdapter();
        $form = new UserAdd();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $adapter = $this->_getAdapter();
            $userTable = new UserTable($adapter);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $userTable->insert($request->getPost());

                // Redirect to list of albums
                //return $this->redirect()->toRoute('album');
            }
        }
        return array('form' => $form);
    }
    
    public function _getAdapter() {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//        $dbAdapter = $sm->get('User/Model/UserTable');
        return $dbAdapter;
    }
}