<?php

namespace SocialMediaAuth\Auth\Adapter;

use Zend\Http\Response;

use Zend\Http\Request;

abstract class AbstractAdapter
{
	/**
	 * 
	 * @var Request
	 */
	
	protected $request;
	/**
	 *
	 * @var Response
	 */
	protected $response;
	protected $messages = array();
	protected $image;
	protected $text;
	protected $callbackUrl;
	
	public function setCallbackUrl($callbackUrl)
	{
		$this->callbackUrl = $callbackUrl;
	}
	
	public function getCallbackUrl()
	{
		return $this->callbackUrl;
	}
	
	public function setRequest(Request $request)
	{
		$this->request = $request;
	}
	
	public function setResponse(Response $response)
	{
		$this->response = $response;
	}
	
	public function getErrorMessages()
	{
		return $this->messages;
	}
	
	public function addErrorMessage($message)
	{
		$this->messages[] = $message;
	}
	
	public function setText($text)
	{
		$this->text = $text;
	}
	
	public function setImageUrl($imageUrl)
	{
		$this->image = $imageUrl;
	}
	
	public function getText()
	{
		return $this->text;
	}
	
	public function getImageUrl()
	{
		return $this->image;
	}
	
	public abstract function isValidLogin();
	public abstract function handleInitialRequest();
	
	
}