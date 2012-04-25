<?php

namespace SocialMediaAuth\Auth\Adapter;

use SocialMediaAuth\Auth\Adapter\OAuthAdapter;

class Twitter extends OAuthAdapter
{
	public function getSiteUrl()
	{
		return 'https://api.twitter.com/oauth/';	
	}	
}
