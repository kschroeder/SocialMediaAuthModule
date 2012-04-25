<?php

return array(
	'di' => array(
		'instance' => array(
			'alias'	=> array(
				'auth'	=> 'SocialMediaAuth\Controller\SocialMediaAuthController'
			),
			'preferences'	=> array(
				'SocialMediaAuth\Auth\Configuration\Configurator'
					=> 'SocialMediaAuth\Auth\Configuration\DiConfiguration'
			),
			'SocialMediaAuth\Auth\Configuration\DiConfiguration' => array(
				'parameters'	=> array(
					'activeAdapters' => array('Twitter')
				)
			),
			'Zend\Mvc\Router\RouteStack' => array(
				'parameters' => array(
					'routes' => array(
						'smauth' => array(
							'type'    => 'Zend\Mvc\Router\Http\Segment',
							'options' => array(
								'route'    => '/smauth/[:controller[/:action]]',
								'constraints' => array(
									'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
									'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
								),
								'defaults' => array(
									'controller' => 'SocialMediaAuth\Controller\SocialMediaAuthController',
									'action'     => 'index',
								),
							),
						),
					),
				),
			),

			// Using the PhpRenderer, which just handles html produced by php
			// scripts
			'Zend\View\Renderer\PhpRenderer' => array(
				'parameters' => array(
					'resolver' => 'Zend\View\Resolver\AggregateResolver',
				),
			),
			'Zend\View\Resolver\TemplatePathStack' => array(
				'parameters' => array(
					'paths'  => array(
						'socialmediaauth' => __DIR__ . '/../views',
					),
				),
			),
		),
	),
);