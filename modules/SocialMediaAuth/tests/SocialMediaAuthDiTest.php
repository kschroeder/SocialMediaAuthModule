<?php

use Zend\Di\DefinitionList;

use SocialMediaAuth\Auth\Configuration\DiConfiguration;

require_once 'SocialMediaAuthTestAdapter.php';

use SocialMediaAuth\Auth\AuthAdapter;

use Zend\Di\Configuration;

use Zend\Di\Di;

class SocialMediaAuthDiTest extends PHPUnit_Framework_TestCase
{

	public function testBasicConfig()
	{
		$di = $this->getDiInstance();
		
		$instance = $di->get('SocialMediaAuth\Auth\Configuration\DiConfiguration');
		$this->assertInstanceOf('SocialMediaAuth\Auth\Configuration\DiConfiguration', $instance);
		
		$instance = $di->get('SocialMediaAuth\Auth\AuthConfiguration');
		$this->assertInstanceOf('SocialMediaAuth\Auth\Configuration\DiConfiguration', $instance->getConfigurator());
		
	}
	
	public function testInjectedAuthAdapter()
	{
		$di = $this->getDiInstance();
		
		$instance = $di->get('SocialMediaAuth\Auth\AuthConfiguration');
		$activeAdapters = $instance->getActivatedAuthAdapters();
		$this->assertTrue(count($activeAdapters) === 1);
		
		$adapter = $instance->getAdapter('SocialMediaAuthTestAdapter');
		$this->assertInstanceOf('SocialMediaAuthTestAdapter', $adapter);

	}
	
	protected function getDiInstance()
	{
		
		$config = new Configuration(
			array(
				'instance' => array(
					'preferences'	=> array(
						'SocialMediaAuth\Auth\Configuration\Configurator'
							=> 'SocialMediaAuth\Auth\Configuration\DiConfiguration'
					),
					'SocialMediaAuth\Auth\Configuration\DiConfiguration' => 
						array(
							'parameters'	=> array(
								'SocialMediaAuth\Auth\Configuration\DiConfiguration::setActiveAuthAdapters:0' => array('SocialMediaAuthTestAdapter')
							)
					    )
				   )
			  )
		);
		
		$di = new Di();
		$di->configure($config);
		$di->instanceManager()->addTypePreference('Zend\Di\Locator' , $di);
		return $di;
	}
}
