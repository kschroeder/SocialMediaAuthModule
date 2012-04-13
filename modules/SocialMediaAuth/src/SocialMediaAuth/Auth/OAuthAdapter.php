<?php

namespace SocialMediaAuth\Auth;

use Zend\Session\Container;

use SocialMediaAuth\Auth\Configuration\ConfigurationException;

use Zend\Config\Config;

use Zend\OAuth\Consumer;

use SocialMediaAuth\Auth\AuthAdapter;

abstract class OAuthAdapter extends AuthAdapter
{
	
	protected $key;
	protected $secret;
	protected $accessToken;
	protected $accessTokenSecret;
	protected $callbackUrl;
	
	public abstract function getSiteUrl();
	
	
	public function getConsumerKey() 
	{
		return $this->key;
	}
	
	public function getSecret() 
	{
		return $this->secret;
	}

	public function getAccessToken() 
	{
		return $this->accessToken;
	}

	public function getAccessTokenSecret() 
	{
		return $this->accessTokenSecret;
	}

	public function getCallbackUrl() 
	{
		return $this->callbackUrl;
	}

	public function setCallbackUrl($callbackUrl) {
		$this->callbackUrl = $callbackUrl;
	}

	public function setConsumerKey($key)
	{
		$this->key = $key;
	}
	
	public function setConsumerSecret($secret)
	{
		$this->secret = $secret;
	}
	
	/**
	 * @return Config
	 */
	
	public function getConfig()
	{
		$config = new Config(
			array(
				'consumerKey' 		=> $this->key,
				'consumerSecret' 	=> $this->secret
			)
		);
		
		if ($this->callbackUrl) {
			$config['callbackUrl'] = $this->callbackUrl;
		}
		return $config;		
	}
	
	public function handleInitialRequest()
	{

		$config = $this->getConfig();
		$oauth = new Consumer($config);
		$token = $oauth->getRequestToken();
		
		$session = new Container(get_class($this));
		$session->token = $token;
		
		$oauth->redirect();		
	}

	public function isValidLogin() 
	{
		$session = new Container(get_class($this));
		$config = $this->getConfig();
		$oauth = new Consumer($config);
		
		$token = $oauth->getAccessToken(
			$this->request->query(),
			$session->token
		);
		if ($token) {
			$this->accessToken = $token;
			return true;
		} else {
			return false;
		}
	}
}