<?php 

class Core_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch (Zend_Controller_Request_Abstract $request)
	{
		//RÃ©cupÃ©ration des erreurs si existante
		$errors = $request->getParam('error_handler');
		
		if (! $errors || ! $errors instanceof ArrayObject) {
			$this->_handleAccess($request);
		}
	}

	/**
	 * Check if the controller/action can be accessed by the current user
	 */
	protected function _handleAccess (Zend_Controller_Request_Abstract $request)
	{
		$module = $request->getModuleName();
		if($module == null) $module = Zend_Controller_Front::getInstance()->getDispatcher()->getDefaultModule();
		
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		$acl = Zend_Registry::get('Zend_Acl');
		
		//RÃ©cupÃ©ration de l'authentification de l'utilisateur
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$userAuth = $auth->getIdentity();
		} else {
			//Initialisation avec un Role User correspondant Ã  GUEST (Non connectÃ©)
			$userAuth = new Core_Model_User();
			$userAuth->setRoleId(Core_Model_User::GUEST);
		}
			
		$roleAuth = $userAuth->getRoleid();
		

        // action/resource does not exist in ACL -> 404
        if (! $acl->has($module . '::' . $controller . '::' . $action)) {
			throw new Zend_Controller_Dispatcher_Exception('_ERR_page_not_found');
		} else if (! $acl->isAllowed($userAuth, $module . '::' . $controller . '::' . $action)) { // resource does exist, check ACL
			throw new Zend_Acl_Exception($module . '::' . $controller . '::' . $action);
		}
	}
}