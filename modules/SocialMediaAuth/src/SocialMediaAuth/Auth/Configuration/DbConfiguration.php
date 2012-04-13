<?php

namespace SocialMediaAuth\Auth\Configuration;

use Zend\Db\Adapter\AdapterAwareInterface;

use SocialMediaAuth\Auth\Configuration\Configurator;

class DbConfiguration implements Configurator, AdapterAwareInterface
{
	protected $adapter;
	
	public function activateAuthAdapter(AuthAdapter $adapter)
	{
	
	}

	public function deactivateAuthAdapter(AuthAdapter $adapter)
	{

	}

	public function getActiveAuthAdapters()
	{
		
	}
	
	public function getNamedAuthAdapter($name)
	{
	}

	public function setDbAdapter(Adapter $adapter)
	{
		$this->adapter = $adapter;
	}
	
	
}