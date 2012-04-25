<?php

namespace SocialMediaAuth\Auth\Adapter;

use Zend\Session\Container;

use SocialMediaAuth\Auth\Configuration\ConfigurationException;

use Zend\Config\Config;

use Zend\OAuth\Consumer;

use SocialMediaAuth\Auth\Adapter\AbstractAdapter;

abstract class OAuthAdapter extends AbstractAdapter
{
	
	protected $key;
	protected $secret;
	protected $accessToken;
	protected $accessTokenSecret;
	protected $accessTokenResult;
	
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


	public function setConsumerKey($key)
	{
		$this->key = $key;
	}
	
	public function setConsumerSecret($secret)
	{
		$this->secret = $secret;
	}
	
	/**
	 * @return Access 
	 */
	
	public function getAccessTokenResult()
	{
		return $this->accessTokenResult;
	}
	
	/**
	 * @return Config
	 */
	
	public function getConfig()
	{
		
		$options = array(
			'consumerKey' 		=> $this->key,
			'consumerSecret' 	=> $this->secret,
			'siteUrl'			=> $this->getSiteUrl()
		);
		
		if ($this->callbackUrl) {
			$options['callbackUrl']	= $this->callbackUrl;
		}
		
		$config = new Config(
			$options
		);
		
		return $config;		
	}
	
	public function handleInitialRequest()
	{

		$config = $this->getConfig();
		$oauth = new Consumer($config);
		$token = $oauth->getRequestToken();
		
		$session = new Container(get_class($this));
		$session['token'] = $token;
		
		$oauth->redirect();
	}

	public function isValidLogin() 
	{
		$token = null;
		
		try {
			$session = new Container(get_class($this));
			$config = $this->getConfig();
			$oauth = new Consumer($config);
			
			$token = $oauth->getAccessToken(
				$this->request->query()->toArray(),
				$session['token']
			);
		} catch (\Exception $e) {
			return false;
		}
		if ($token) {
			$this->accessTokenResult = $token;
			return true;
		} else {
			return false;
		}
	}
}