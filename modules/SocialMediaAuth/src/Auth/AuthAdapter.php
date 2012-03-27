<?php

namespace SocialMediaAuth\Auth;

use Zend\Http\Request;

abstract class AuthAdapter
{
	
	protected $request;
	protected $messages = array();
	
	public function setRequest(Request $request)
	{
		$this->request = $request;
	}
	
	public function getErrorMessages()
	{
		return $this->messages;
	}
	
	public function addErrorMessage($message)
	{
		$this->messages[] = $message;
	}
	
	public abstract function isValidLogin();
	public abstract function handleInitialRequest();
	
}