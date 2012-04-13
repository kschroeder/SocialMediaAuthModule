<?php

use SocialMediaAuth\Auth\AuthAdapter;

class SocialMediaAuthTestAdapter extends AuthAdapter
{
	public function handleInitialRequest() {
		$this->request->setMetadata('requestHandled', true);
	}

	public function isValidLogin() {
		$this->request->setMetadata('requestAuthed', true);
		return $this->request->getMetadata('defaultAuthStatus', true);
	}
	
}