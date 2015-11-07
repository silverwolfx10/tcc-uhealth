<?php
namespace Api\Services;

use \LinkedIn\LinkedIn as LinkedinOauth;

class Linkedin {

    private $response = [
        'status' => true,
        'messages' => [],
        'data' => []
    ];
	public function __construct(){
        $this->li = new LinkedinOauth(
            [
                'api_key' => '779id8kdtiau47',
                'api_secret' => 'k5pYbUOd58MQVu3C',
                'callback_url' => 'http://api.uhealth.com.br/v1/linkedinCallback'
            ]
        );
	}

    public function getUrlLogin(){

        return $this->li->getLoginUrl(
            array(
                \LinkedIn\LinkedIn::SCOPE_BASIC_PROFILE,
                \LinkedIn\LinkedIn::SCOPE_EMAIL_ADDRESS
            )
        );

    }

    public function getUserInformation($code){

        $this->li->getAccessToken($code);
        $this->li->getAccessTokenExpiration();

        $user = $this->li->get('/people/~:(picture-urls::(original),id,first-name,last-name,email-address)');
        $thumb = $this->li->get('/people/~:(picture-url)');

        $this->response['data'] = [
            'imagePath' => isset($user['pictureUrls']['values'][0]) ? $user['pictureUrls']['values'][0] : $thumb['pictureUrl'],
            'imageThumb' => $thumb['pictureUrl'],
            'linkedinId' => $user['id'],
            'name' => $user['firstName'] . ' ' . $user['lastName'],
            'email' => $user['emailAddress']
        ];

        return $this->response;
    }
}
