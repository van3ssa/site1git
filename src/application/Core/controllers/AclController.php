<?php

class AclController extends Zend_Controller_Action{
	
	public function indexAction(){
	
		$acl = Zend_Registry::get('Zend_Acl');
		
		if($acl->isAllowed('guest', 'livre', 'lire')){
			echo 'Je peux lire';
		}else{
			echo 'Je ne peux pas lire';
		}	
	}
	
	public function conversationAction(){
		
		$this->_helper->viewRenderer->setNoRender();

		$acl = Zend_Registry::get('Zend_Acl');
		
		if($acl->isAllowed('author', 'author', 'discuter')){
			echo 'Je peux communiquer avec un autre autheur.';
		}else{
			echo 'Je ne peux pas communiquer avec un autre auteur.';
		}		
	}
}