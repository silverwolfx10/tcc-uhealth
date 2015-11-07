<?php
namespace Api\Services;

class Facebook {
    private $fb;
    private $response = [
        'status' => true,
        'messages' => [],
        'data' => []
    ];
	public function __construct(){
		$this->fb = new \Facebook\Facebook([
            'app_id' => '492837350896357',
            'app_secret' => 'da3cce97558035e9d27f31ac0b1f7ce3',
            'default_graph_version' => 'v2.4',
        ]);
	}

    public function getUrlLogin(){

        $helper = $this->fb->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl('http://api.uhealth.com.br/v1/facebookCallback', ['email', 'user_birthday']);

        return $loginUrl;
    }

    public function getUserInformation(){

        $helper = $this->fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            $this->response['status'] = false;
            $this->response['status']['messages'][] = 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            $this->response['status'] = false;
            $this->response['status']['messages'][] = 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                $this->response['status'] = false;
                $this->response['status']['messages'][] = 'Sem permissão';
            } else {
                $this->response['status'] = false;
                $this->response['status']['messages'][] = 'Tente novamente';
            }
            exit;
        }


        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $this->fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('492837350896357');
        // If you know the user ID this access token belongs to, you can validate it here
        // $tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                $this->response['status'] = false;
                $this->response['status']['messages'][] = 'Error getting long-lived access token: ' . $helper->getMessage();
                exit;
            }
        }

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $this->fb->get('/me?fields=id,name,email,picture,birthday', $accessToken);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            $this->response['status'] = false;
            $this->response['status']['messages'][] = 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            $this->response['status'] = false;
            $this->response['status']['messages'][] = 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();

        $this->response['data'] = [
            'imageThumb' => $user['picture']->getUrl(),
            'imagePath' => 'https://graph.facebook.com/' . $user['id'] . '/picture?height=350&width=350',
            'facebookId' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'birthDay' => $user['birthday'],
        ];

        return $this->response;
    }
}
