<?php
namespace SocialMediaAuth\Auth;


use SocialMediaAuth\Auth\Configuration\Configurator;

use Zend\Db\Adapter\Adapter;

use Zend\Code\Reflection\FileReflection;

use Zend\Code\Reflection\ClassReflection;

use Zend\Code\Scanner\DirectoryScanner;

class AuthConfiguration 
{

	/**
	 * @var SocialMediaAuth\Auth\Configuration\Configurator
	 */
	
	protected $configurator;
	
	public function setConfigurator(Configurator $config)
	{
		$this->configurator = $config;
	}
	
	public function getAllAuthAdapters()
	{
		$authAdapters[] = array();
		$scanner = new DirectoryScanner();
		$scanner->addDirectory(__DIR__);
		$classes = $scanner->getClasses();
		foreach ($classes as $classScanner) {
			/* @var $classScanner Zend\Code\Scanner\FileScanner */
			$r = new FileReflection($classScanner->getFile());
			$class = $r->getClass();
			if ($class->isSubclassOf('SocialMediaAuth\Auth\AuthAdapter') && $class->isInstantiable()) {
				$authAdapters[] = $class->newInstance();
			}
		}
		return $authAdapters;
	}
	
	public function getActivatedAuthAdapters()
	{
		
	}
}