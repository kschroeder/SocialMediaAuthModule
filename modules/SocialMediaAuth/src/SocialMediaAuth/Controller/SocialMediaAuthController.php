<?php

namespace SocialMediaAuth\Controller;

use Zend\Session\Container;

use ZendTest\Captcha\TestAsset\SessionContainer;

use SocialMediaAuth\Auth\AuthConfiguration;

use SocialMediaAuth\Auth\Configuration\NoAdapterException;

use SocialMediaAuth\Auth\Configuration\InvalidAdapterException;

use Zend\Cache\Storage\PluginLoader;

use Zend\Loader\PluginBroker;

use SocialMediaAuth\Auth\AuthAdapter;

use Zend\Mvc\Controller\ActionController;

class SocialMediaAuthController extends ActionController
{
	public function indexAction()
	{
		$adapterName = $this->getEvent()->getParam('authAdapter');
		$auth = $this->getLocator()->get('SocialMediaAuth\Auth\AuthConfiguration');
		/* @var $auth \SocialMediaAuth\Auth\AuthConfiguration */
		if (!$adapterName) {
			$allAdapters = $auth->getActivatedAuthAdapters();
			if (count($allAdapters) === 0) {
				throw new NoAdapterException('Unable to find any activated adapters');
			} else if (count($allAdapters) === 1) {
				$adapterName = array_shift($allAdapters);
			} else {
				$this->forward('chooseauth');
			}
		}
			
		$adapter = $auth->getAdapter($adapterName);
		
		$session = new Container('socialmediaauth');
		$session->adapter = $adapterName;
		
		$adapter->setRequest($this->request);
		$adapter->setResponse($this->response);
		$adapter->setCallbackUrl(
			$this->url(
				array(
					'action'	=> 'auth'
				)
			)
		);
		
		$this->events()->trigger('socialmediaauth.prerequest', $adapter);
		$adapter->handleInitialRequest();		
		
	}
	
	public function chooseauthAction()
	{
		$auth = $this->getLocator()->get('SocialMediaAuth\Auth\AuthConfiguration');
		/* @var $auth \SocialMediaAuth\Auth\AuthConfiguration */
		$allAdapters = $auth->getActivatedAuthAdapters();
		$instAdapters = array();
		foreach ($allAdapters as $adapter) {
			$adapterInstance = $auth->getAdapter($adapter);
			$instAdapters[] = $adapterInstance;
		}
		return array(
			'adapters'	=> $instAdapters		
		);
	}
	
	public function authAction()
	{
		$config = $this->getLocator()->get('SocialMediaAuth\Auth\AuthConfiguration');
		if (!$config instanceof AuthConfiguration) {
			throw new InvalidAdapterException('Unable to find a configuration');
		}
		$session = new Container('socialmediaauth');
		$adapter = $config->getAdapter($session->adapter);
		
		if (!$adapter instanceof AuthAdapter) {
			throw new InvalidAdapterException('Invalid adapter specified');
		}
		
		$adapter->setRequest($this->request);
		$adapter->setResponse($this->response);
		if ($adapter->isValidLogin()) {
			$this->events()->trigger('socialmediaauth.success', $adapter);
		} else {
			$this->events()->trigger('socialmediaauth.failure', $adapter);
		}
	}
}
