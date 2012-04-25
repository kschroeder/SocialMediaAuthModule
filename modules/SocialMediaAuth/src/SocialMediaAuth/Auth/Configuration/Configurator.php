<?php
namespace SocialMediaAuth\Auth\Configuration;

use SocialMediaAuth\Auth\Adapter\AbstractAdapter;

interface Configurator
{
	
	public function getActiveAuthAdapters();
	public function getNamedAuthAdapter($name);
	public function activateAuthAdapter(AbstractAdapter $adapter);
	public function deactivateAuthAdapter(AbstractAdapter $adapter);
	
}
