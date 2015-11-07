<?php
namespace Api\Responses;

class JSONResponse extends Response{

	protected $snake = true;
	protected $envelope = true;
    protected $serializer;

	public function __construct(){
		parent::__construct();

        $this->serializer = new \Infrastructure\Service\Serializer();
	}

	public function send($records, $error=false){

		// Error's come from HTTPException.  This helps set the proper envelope data
		$response = $this->di->get('response');
		$success = ($error) ? 'ERROR' : 'SUCCESS';

		// If the query string 'envelope' is set to false, do not use the envelope.
		// Instead, return headers.
		$request = $this->di->get('request');
		if($request->get('envelope', null, null) === 'false'){
			$this->envelope = false;
		}

		// Most devs prefer camelCase to snake_Case in JSON, but this can be overriden here
		if($this->snake){
			$records = $this->arrayKeysToSnake($records);
		}

		$etag = md5(serialize($records));


        $response->setHeader('X-Record-Count', count($records));
        $response->setHeader('X-Status', $success);
        $message = [];


        $message['messages'] = isset($records['messages']) && is_array($records['messages']) ? $records['messages'] : null;
        $message['data'] = isset($records['data']) ? $records['data'] : null;
        $message['status'] = isset($records['status']) ? $records['status'] : false;


		$response->setContentType('application/json');
		$response->setHeader('E-Tag', $etag);
		$response->setHeader('X-Men', $this->memory(memory_get_usage(true)));

		// HEAD requests are detected in the parent constructor. HEAD does everything exactly the
		// same as GET, but contains no body.

		if(!$this->head){
			$response->setContent($this->serializer->serialize($message, 'json'));
		}

		$response->send();

		return $this;
	}

	public function convertSnakeCase($snake){
		$this->snake = (bool) $snake;
		return $this;
	}

	public function useEnvelope($envelope){
		$this->envelope = (bool) $envelope;
		return $this;
	}

	public function memory($size){
		$unit=array('b','kb','mb','gb','tb','pb');
    	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}

}
