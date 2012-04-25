<?php

namespace SocialMediaAuth;

use Zend\Mvc\Controller\ActionController;

use Zend\EventManager\Event;

use Zend\Mvc\MvcEvent;

use Zend\Module\Listener\ConfigListener;

use Zend\Module\Manager;

use Zend\EventManager\StaticEventManager;

use Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{

	public function init(Manager $moduleManager)
	{
		$events = StaticEventManager::getInstance();
		$events->attach('Zend\Mvc\Controller\ActionController', 'socialmediaauth', function(Event $e) {
			if (!$e->getTarget() instanceof ActionController) {
				throw new \Exception('I need a controller as the target!');
			}
			$target = $e->getTarget();
			/* @var $target ActionController */
			$target->getEvent()->setParam(
				'adapter',
				$e->getParam('adapter')
			);
			$e->getTarget()->forward()->dispatch(
				'SocialMediaAuth\Controller\SocialMediaAuthController',
				array('action' => 'index')	
			);
		});
	}
	
    public function getAutoloaderConfig()
    {
        return array(

            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
        
    }
    
    public function registerBaseUrl($e)
    {
    	$config  = $e->getParam('config');
    	$app     = $e->getParam('application');
    	$router  = $app->getRouter();
    	$router->setBaseUrl($config->baseUrl);
    }
    
    public function getConfig()
    {
    	return include __DIR__ . '/config/module.config.php';
    }

}
