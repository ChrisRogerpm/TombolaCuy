<?php

namespace App\ApiApuestaTotal;

class Curl
{
	protected $endpoint;
	protected $api_key;
	protected $token;
	protected $headers = [];

	public function __construct($password){
		$this->endpoint = "https://api.apuestatotal.com";
		$this->api_key = "H4ofnr4pg02Vgd39lnLaa30kFGdKNqjp";
		$this->token = $this->api_key.":".$password;
		$this->headers[] = 'Content-Type:application/json';
		$this->headers[] = "Accept-Language: en-US,en;q=0.9,es;q=0.8,pt;q=0.7,gl;q=0.6";
		$this->headers[] = "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36";
	}

	public function post($data, $uri=""){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'canhazip.com');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);

		$ch = curl_init($this->endpoint.$uri);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->token);

		$response =  json_decode(curl_exec($ch), true);

		curl_close($ch);

		return $response;
	}

}

?>