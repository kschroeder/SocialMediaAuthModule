<?php


/*
 * Set error reporting to the level to which Zend Framework code must comply.
 */
use SocialMediaAuth\Module;

error_reporting( E_ALL | E_STRICT );

$zf2Library = realpath(__DIR__ . "/../../../../ZF2/library");
$tests   = __DIR__;

$path = array(
    $zf2Library,
    $tests,
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $path));

require_once 'Zend/Loader/AutoloaderFactory.php';

Zend\Loader\AutoloaderFactory::factory();

require_once '../Module.php';

$module = new Module();
Zend\Loader\AutoloaderFactory::factory(
	$module->getAutoloaderConfig()
);