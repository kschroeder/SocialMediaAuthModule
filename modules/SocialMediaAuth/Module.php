<?php

namespace SocialMediaAuth;

use Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{

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

}
