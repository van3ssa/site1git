<?php 

/**
 * 
 * 
 * @category    App1
 * @package     Core
 */

class AuthController extends Zend_Controller_Action
{
    
    public function loginAction()
    {
        $form = new Core_Form_Login();
        $form->setAction('');
        
        if ($this->getRequest()->isPost()) {
            
            if ($form->isValid($_POST)) {
                $username = $form->getValue('username');
                $password = $form->getValue('pass');
                
                $adapter = new Zend_Auth_Adapter_DbTable();
                $adapter->setTableName('user')
                        ->setIdentityColumn('user_login')
                        ->setCredentialColumn('user_password')
                        ->setIdentity($username)
                        ->setCredential($password);
                
                $auth = Zend_Auth::getInstance();
                $authResult = $auth->authenticate($adapter);
                
                if ($authResult->getCode() == 1) {
                    $userRow = $adapter->getResultRowObject();
                    
                    $user = new Core_Model_User();
                    $user->setUserId($userRow->user_id);
                    $user->setRoleId($userRow->role_id);
                    $user->setUserLogin($userRow->user_login);
                    
                    $auth->getStorage()->write($user);
                }
                $this->_redirect('/accueil.html');
            }
        } 
        
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/login.html');
    }
}