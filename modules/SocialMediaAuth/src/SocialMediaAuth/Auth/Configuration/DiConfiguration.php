<?php

namespace SocialMediaAuth\Auth\Configuration;


use SocialMediaAuth\Auth\Adapter\AbstractAdapter;

use Zend\Di\Locator;

use Zend\Loader\LocatorAware;

use SocialMediaAuth\Auth\Configuration\Configurator;

class DiConfiguration implements Configurator, LocatorAware
{
	
	protected $activeAuthAdapters = array();
	protected $locator;
	
	public function activateAuthAdapter(AbstractAdapter $adapter)
	{
		throw new InvalidCommandException('Cannot modify configuration');
	}

	public function deactivateAuthAdapter(AbstractAdapter $adapter)
	{
		throw new InvalidCommandException('Cannot modify configuration');
	}

	public function getActiveAuthAdapters()
	{
		return $this->activeAuthAdapters;
	}
	
	/* 
	 * @return \Zend\Di\Locator
	 */
	public function getLocator()
	{
		return $this->locator;
	}

	public function setLocator(Locator $locator)
	{
		$this->locator = $locator;
	}
	
	public function addActiveAuthAdapter($adapter)
	{
		if (is_string($adapter)) {
			$this->activeAuthAdapters[] = $adapter;
		}
	}

	public function setActiveAuthAdapters(array $activeAdapters)
	{
		$this->activeAuthAdapters = array();
		foreach ($activeAdapters as $adapter) {
			$this->addActiveAuthAdapter($adapter);
		}
	}
	
	public function getNamedAuthAdapter($name)
	{
		$name = ucfirst($name);
		$className = 'SocialMediaAuth\Auth\Adapter\\' . $name;
		// Check to see if it's activated first.
		if (!in_array($name, $this->activeAuthAdapters)
			&& !in_array($className, $this->activeAuthAdapters)) {
			return null;
		}
		$adapter = null;
		// First check for a custom/FQ adapter
		if (strpos($name, '\\') === false) {
			try {
				$adapter = $this->getLocator()->get($className);
			} catch (\Zend\Di\Exception\ClassNotFoundException $e) {
				try {
					$adapter = $this->getLocator()->get($name);
				} catch (\Zend\Di\Exception\ClassNotFoundException $e) {}	
			}
		} else {
			try {
				$adapter = $this->getLocator()->get($name);
			} catch (\Zend\Di\Exception\ClassNotFoundException $e) {
			}
		}
		// Null or adapter does not extend AuthAdapter
		if (!$adapter instanceof AbstractAdapter) {
			throw new InvalidAdapterException();
		}
		return $adapter;
	}
	
}