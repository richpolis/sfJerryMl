<?php
class twitterOAuthPlugin{

    public static function sendTweet($message = null) {	

        if(!$message)
		$message = "The datetime is ".date('Y-m-d H:i:s');
		
        $consumer_key = sfConfig::get('app_twitter_consumer_key');
        $consumer_secret = sfConfig::get('app_twitter_consumer_secret');
        $accessToken = sfConfig::get('app_twitter_access_token');
        $accessTokenSecret = sfConfig::get('app_twitter_access_token_secret');
		
		//Debug:
		#echo "consumer_key = $consumer_key<br/>";
        #echo "consumer_secret = $consumer_secret<br/>";
        #echo "accessToken = $accessToken<br/>";
        #echo "accessTokenSecret = $accessTokenSecret<br/>";
		#echo "message = $message<br/>";
		
		

// Create our twitter API object
        $oauth = new TwitterOAuth($consumer_key, $consumer_secret, $accessToken, $accessTokenSecret);

// Send an API request to verify credentials
        $credentials = $oauth->get("account/verify_credentials");
        echo "Connected as @" . $credentials->screen_name;

// Post our new "hello world" status
        $posted = $oauth->post('statuses/update', array('status' => $message));
		
		//Debug:
		#var_dump($posted);
		
    }
    public static function getMisTwitters($screen_name='jerryml',$debug=false) {	

        	
        $consumer_key =         sfConfig::get('app_twitter_consumer_key');
        $consumer_secret =      sfConfig::get('app_twitter_consumer_secret');
        $accessToken =          sfConfig::get('app_twitter_access_token');
        $accessTokenSecret =    sfConfig::get('app_twitter_access_token_secret');
		
        //Debug:
	#echo "consumer_key = $consumer_key<br/>";
        #echo "consumer_secret = $consumer_secret<br/>";
        #echo "accessToken = $accessToken<br/>";
        #echo "accessTokenSecret = $accessTokenSecret<br/>";
	#echo "message = $message<br/>";
		
		

// Create our twitter API object
        $oauth = new TwitterOAuth($consumer_key, $consumer_secret, $accessToken, $accessTokenSecret);

// Send an API request to verify credentials
        $credentials = $oauth->get("account/verify_credentials");
        if($debug){
            echo "Connected as @" . $credentials->screen_name;
        }

// Post our new "hello world" status
        $twitters= $oauth->get('statuses/user_timeline',array('count'=>10,'screen_name'=>$screen_name));
		
		//Debug:
        if($debug){
            var_dump($twitters);
        }   
		#var_dump($posted);
        return $twitters;
		
    }
    public static function getMisTwitterFollowersIds($debug=false) {	

        	
        $consumer_key = sfConfig::get('app_twitter_consumer_key');
        $consumer_secret = sfConfig::get('app_twitter_consumer_secret');
        $accessToken = sfConfig::get('app_twitter_access_token');
        $accessTokenSecret = sfConfig::get('app_twitter_access_token_secret');
		
// Create our twitter API object
        $oauth = new TwitterOAuth($consumer_key, $consumer_secret, $accessToken, $accessTokenSecret);

// Send an API request to verify credentials
        $credentials = $oauth->get("account/verify_credentials");
        if($debug){
            echo "Connected as @" . $credentials->screen_name;
        }

// Post our new "hello world" status
        $ids= $oauth->get('friends/ids',array('include_entities'=>true));
		
		//Debug:
        if($debug){
            var_dump($ids);
        }   
		#var_dump($posted);
        return $ids;
		
    }
    public static function getUsersLookup($idUser,$debug=false) {


        $consumer_key = sfConfig::get('app_twitter_consumer_key');
        $consumer_secret = sfConfig::get('app_twitter_consumer_secret');
        $accessToken = sfConfig::get('app_twitter_access_token');
        $accessTokenSecret = sfConfig::get('app_twitter_access_token_secret');

// Create our twitter API object
        $oauth = new TwitterOAuth($consumer_key, $consumer_secret, $accessToken, $accessTokenSecret);

// Send an API request to verify credentials
        $credentials = $oauth->get("account/verify_credentials");
        if($debug){
            echo "Connected as @" . $credentials->screen_name;
        }

// Post our new "hello world" status
        $ids= $oauth->get('users/lookup',array('user_id'=>$idUser,'include_entities'=>true));
		
		//Debug:
        if($debug){
            var_dump($ids);
        }
		#var_dump($posted);
        return $ids;

    }
    public static function getTwitterForId($idUserTwitter,$debug=false) {


        $consumer_key = sfConfig::get('app_twitter_consumer_key');
        $consumer_secret = sfConfig::get('app_twitter_consumer_secret');
        $accessToken = sfConfig::get('app_twitter_access_token');
        $accessTokenSecret = sfConfig::get('app_twitter_access_token_secret');



// Create our twitter API object
        $oauth = new TwitterOAuth($consumer_key, $consumer_secret, $accessToken, $accessTokenSecret);

// Send an API request to verify credentials
        $credentials = $oauth->get("account/verify_credentials");
        if($debug){
            echo "Connected as @" . $credentials->screen_name;
        }

// Post our new "hello world" status
        $twitters= $oauth->get('statuses/retweets/'.$idUserTwitter,array('count'=>5,'include_entities'=>true));

		//Debug:
        if($debug){
            var_dump($twitters);
        }
		#var_dump($posted);
        return $twitters;

    }





}