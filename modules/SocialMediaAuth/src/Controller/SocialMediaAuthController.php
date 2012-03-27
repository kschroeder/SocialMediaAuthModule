<?php

namespace SocialMediaAuth\Controller;

use SocialMediaAuth\Auth\AuthAdapter;

use Zend\Mvc\Controller\ActionController;

class SocialMediaAuthController extends ActionController
{
	public function indexAction()
	{
		return array();
	}
	
	public function authAction()
	{
		$adapter = $this->getLocator()->get('SocialMediaAuth\Auth\AuthAdapter', array('setRequest', $this->getRequest()));
		if (!$adapter instanceof AuthAdapter) {
			throw new \Exception('Invalid adapter');
		}
		if ($adapter->isValidLogin()) {
			$this->events()->trigger('socialmediaauth.success');
		} else {
			$this->events()->trigger('socialmediaauth.failure', $adapter->getErrorMessages());
		}
	}
}
