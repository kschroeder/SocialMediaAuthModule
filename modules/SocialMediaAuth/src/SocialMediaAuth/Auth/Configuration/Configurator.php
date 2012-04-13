<?php
namespace SocialMediaAuth\Auth\Configuration;

use SocialMediaAuth\Auth\AuthAdapter;

interface Configurator
{
	
	public function getActiveAuthAdapters();
	public function getNamedAuthAdapter($name);
	public function activateAuthAdapter(AuthAdapter $adapter);
	public function deactivateAuthAdapter(AuthAdapter $adapter);
	
}
