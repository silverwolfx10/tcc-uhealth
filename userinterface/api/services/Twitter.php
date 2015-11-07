<?php
namespace Api\Services;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter {

    private $response = [
        'status' => true,
        'messages' => [],
        'data' => []
    ];
	public function __construct(){
		$this->consumer_key = 'wL6MeMIHS2JWWBjFbmVz4R4s0';
        $this->consumer_secret = 'oz0KV9WfOaUdt7hhVjv1OGOp2zN9GwJZ7PBLi0ycvI1RHG4t57';
	}

    public function getUrlLogin(){

        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
        $request_token = $connection->oauth('oauth/request_token', ['oauth_callback' => 'http://api.uhealth.com.br/v1/twitterCallback']);

        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

        return $connection->url('oauth/authorize', ['oauth_token' => $request_token['oauth_token']]);
    }

    public function getUserInformation($user_oauth_token, $user_oauth_verifier){

        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $user_oauth_token, $_SESSION['oauth_token_secret']);

        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $user_oauth_verifier]);

        $connection2 = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        $user = $connection2->get("account/verify_credentials");

        $this->response['data'] = [
            'imagePath' => str_replace('_normal', '', $user->profile_image_url),
            'imageThumb' => $user->profile_image_url,
            'twitterId' => $user->id,
            'name' => $user->name,
        ];

        return $this->response;
    }
}
