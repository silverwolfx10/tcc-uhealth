<?php 
namespace Infrastructure\Service;

/**
 * Serviço para executar chamadas REST
 **/
class RESTClient {

    private $baseUrl;
    private $token;
    private $headers;
    private $uri;

    public function __construct($baseUrl, $headers = []) {
        $this->baseUrl = $baseUrl;
        $this->headers = $headers;

        if(isset($_SESSION['token'])){
            $this->token = $_SESSION['token'];
        }
    }

    public function setUri($uri){
        $this->uri = $uri;
    }
    public function setToken($token){
        $this->token = $token;
    }

    public function get($uri = null){
        $uri = is_null($uri) ? $this->uri : $uri;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $this->setHeaders($ch);

        $output = curl_exec($ch);
        echo $output;
        die;

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $return = json_decode($output, true);

        $return['httpStatus'] = $httpcode;
        return $return;
    }

    public function post($data = [], $uri = null){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $uri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $this->setHeaders($ch);



        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);

        $return = json_decode($output, true);
        $return['httpStatus'] = $httpcode;
        return $return;
    }

    public function put($data = [], $uri = null){
        $ch = curl_init($this->baseUrl . $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->setHeaders($ch);

        $output = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $return = json_decode($output, true);
        $return['httpStatus'] = $httpcode;
        return $return;
    }

    public function delete($uri = null){
        $ch = curl_init($this->baseUrl . $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->setHeaders($ch);

        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $return = json_decode($output, true);
        $return['httpStatus'] = $httpcode;
        return $return;
    }

    private function setHeaders(&$ch){

        if($this->token) {
            $this->headers = array_merge($this->headers, ["Token" => $this->token]);
        }


        if(count($this->headers)){

            $aux = [];
            foreach($this->headers as $key => $header){
                $aux[] = $key . ': ' . $header;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aux);
        }
    }
} 