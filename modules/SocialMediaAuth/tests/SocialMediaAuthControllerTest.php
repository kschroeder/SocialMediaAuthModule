<?php

use Zend\Di\Configuration;

require_once 'SocialMediaAuthTestAdapter.php';

use SocialMediaAuth\Controller\SocialMediaAuthController;

use Zend\Di\Di;

use PHPUnit_Framework_TestCase as TestCase,
    Zend\EventManager\StaticEventManager,
    Zend\Http\Request,
    Zend\Http\Response,
    Zend\Mvc\Controller\PluginBroker,
    Zend\Mvc\MvcEvent,
    Zend\Mvc\Router\RouteMatch;

class SocialMediaAuthControllerTest extends TestCase
{
	
	public $controller;
	public $event;
	public $request;
	public $response;
	
	public function setUp()
	{
		$di = $this->getDiInstance();
		$this->controller = $di->get('SocialMediaAuth\Controller\IndexController');
		$this->request    = new Request();
		$this->response   = new Response();
		$this->routeMatch = new RouteMatch(array('controller' => 'index'));
		$this->event      = new MvcEvent();
		$this->event->setRouteMatch($this->routeMatch);
		$this->controller->setEvent($this->event);
	
		StaticEventManager::resetInstance();
	}
	
	public function testInitialRequest()
	{
		$this->routeMatch->setParam('action', 'index');
		$this->controller->dispatch($this->request, $this->response);
		$result = $this->request->getMetadata('requestHandled');
		$this->assertTrue($result);
	}
	
	public function testPostSocialRequest()
	{
		$this->routeMatch->setParam('action', 'auth');
		$this->controller->dispatch($this->request, $this->response);
		$result = $this->request->getMetadata('requestAuthed');
		$this->assertTrue($result);
		
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
								'activeAdapters' => array(
									'SocialMediaAuthTestAdapter'
								)
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

