<?php

namespace SocialMediaAuth\Auth;

use SocialMediaAuth\Auth\OAuthAdapter;

class TwitterAdapter extends OAuthAdapter
{
	public function getSiteUrl()
	{
		return 'https://api.twitter.com/oauth/';	
	}	
}
