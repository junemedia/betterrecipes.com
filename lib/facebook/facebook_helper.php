<?php
	class Facebook_helper extends Facebook
	{
		protected $friend_array;
		protected $facebook;
		protected $gigya;
		protected $user;

		public function __construct($gigya, $user)
		{
			$this->gigya = $gigya;
			$this->user = $user;
			$init_array['appId'] = sfConfig::get('app_facebook_appid');
			$init_array['secret'] = sfConfig::get('app_facebook_appsecret');
			if( $user->getRegSourceAttribute('auth_token') )
			{
				$init_array['access_token'] = $user->getRegSourceAttribute('auth_token');
			}
		    $this->facebook = new Facebook($init_array);
		    $this->facebook->setAccessToken($user->getRegSourceAttribute('auth_token'));
		}

		public function get_friends_using_app()
		{
			if( !$this->friend_array )
			{
				$friend_array = $this->get_friends();
			}else
			{
				$friend_array = $this->friend_array;
			}
			$using_array = null;
			foreach($friend_array as $friend)
			{
				foreach ($friend as $array) 
				{
					if( isset($array['installed']) && !isset($array['https://graph.facebook.com']) )
					{
						$using_array[] = $array;
					}
				}
			}
			return $using_array;
		}

		public function get_friends_ids_using_app()
		{
			$friends_array = $this->get_friends_using_app();
			$friend_id_array = null;
			// note: need to chek if the array is filled (there are FB users who have no friends using the app)
			if (sizeof($friends_array)>0) {
			    foreach ($friends_array as $friend) 
			    {
			    	$friend_id_array[] = $friend['id'];
			    }
			}
		    return $friend_id_array;
		}

		public function get_friends()
		{
			$memcache = sfContext::getInstance()->getMemcache();
      		$key = sfContext::getInstance()->getMemcacheKey('fb_friends', array('%facebook_id%' => $this->getUser()->getSocial('loginProviderUID') ));
      		if( $memcache->has($key) )
      		{
      			$this->friend_array = $memcache->get($key);
      		}else
      		{
				$this->friend_array = $this->facebook->api('me/friends?fields=installed,name,picture');
				$memcache->set($key, $this->friend_array, time() + (7*24*60*60) );
			}
			return $this->friend_array;
		}

		public function post_to_wall($message)
		{
			$gigya_params_array = array(
				'uid' => $this->user->getRegSourceAttribute('gigya_UID'),
				'graphPath' => '/me/feed',
				'method' => 'POST',
				'graphParams' => json_encode(array('message' => $message)),
				);

			$res = $this->gigya->request('socialize.facebookGraphOperation', $gigya_params_array );

			//create message with token gained before
			/*$post =  array(
			    'access_token' => $this->facebook->getAccessToken(),
			    'message' => $message
			);

			//and make the request
			$res = $this->facebook->api('/me/feed', 'POST', $post);*/
			return $res;
		}

		public function post_action_recipe($action_name, $link)
		{
			$gigya_params_array = array(
				'uid' => $this->user->getRegSourceAttribute('gigya_UID'),
				'graphPath' => '/me/' . sfConfig::get('app_facebook_appnamespace') . ':' . $action_name,
				'method' => 'POST',
				'graphParams' => json_encode(array('recipe' => $link)),
				);

			$res = $this->gigya->request('socialize.facebookGraphOperation', $gigya_params_array );
			try
			{
				$error['error'] = $res->getString('errorDetails');
				return $error;
			}
			catch(Exception $e)
			{

			}

			try
			{
				$graphResponse = $res->getString('graphResponse')->serialize();
				//$response['id'] = $graphResponse['id'];
				return $graphResponse['id'];
			}
			catch(Exception $e)
			{

			}
			
			//$graphResponse = $res->getString('graphResponse')->serialize();
			
			/*
			$url = 'me/';
			$url .= sfConfig::get('app_facebook_appnamespace');
			$url .= ":" . $action_name;
			//$url .= "?recipe=" . $link . "&access_token=" . $this->facebook->getAccessToken();
			$params_array = array('recipe' => $link, 'access_token' => $this->facebook->getAccessToken());
			//and make the request
			$res = $this->facebook->api($url, 'POST', $params_array);
			*/
			//return $graphResponse['id'];
		}

		public function post_action_recipe_contest($action_name, $link)
		{
			$gigya_params_array = array(
				'uid' => $this->user->getRegSourceAttribute('gigya_UID'),
				'graphPath' => '/me/' . sfConfig::get('app_facebook_appnamespace') . ':' . $action_name,
				'method' => 'POST',
				'graphParams' => json_encode(array('recipe_contest' => $link)),
				);

			$res = $this->gigya->request('socialize.facebookGraphOperation', $gigya_params_array );
			try
			{
				$error['error'] = $res->getString('errorDetails');
				return $error;
			}
			catch(Exception $e)
			{

			}

			try
			{
				$graphResponse = $res->getString('graphResponse')->serialize();
				//$response['id'] = $graphResponse['id'];
				return $graphResponse['id'];
			}
			catch(Exception $e)
			{

			}
		}

		/*
		*	$id_of_object has to be the unique ID of the object that has been posted to a users wall.
		*	$type_of_object: comments, likes, notes, links, events
		*	For posts to the users wall (status updates), type of object is not needed.
		* 	Reference: https://developers.facebook.com/docs/reference/api/
		*/

		public function delete_post($id_of_object, $type_of_object = NULL)
		{
			if( $type_of_object )
			{
				$path = $id_of_object . "/" . $type_of_object;
			}else
			{
				$path = $id_of_object;
			}

			$res = $this->facebook->api($path, 'DELETE');
			return $res;
		}
	}

?>