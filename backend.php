<?php

class isitup {
	private $url = null;
	private $result = array('status', 'message');
	
	//class constructor
	function __construct($url = null) {
		if ($url) {
			$this->setUrl($url);
		}
   	}
	
	//cleanup and set the url
	public function setUrl($url){
		$url = trim($url);
		if (strpos($url, 'http') !== 0) {
			$url = 'http://'.$url;
		}
		$this->url = $url;
	}

	//see is it up or not
	public function check() {
		//if short string that can not be URL return error message
		if (!$this->url OR strlen($this->url)<3) {
			$this->result['status'] = false;
			$this->result['message'] = 'The URL is too short!';
		} else {
			//get only headers not the full page and formate the result as array
			$headers = get_headers($this->url);
			
			//if === false then the website is down or does not exists
			if ($headers === false) {
				$this->result['status'] = false;
				$this->result['message'] = $this->url . ' is down <img src="./img/sad-face.png">';
			} else {
				$this->result['status'] = true;
				$this->result['message'] = '<a href="'.$this->url.'">'.$this->url.'</a> is up <img src="./img/smiling-face.png">';
			}
		}
		return json_encode($this->result);
	}
}
$url = isset($_POST['url'])?$_POST['url']:null;
$isitup = new isitup($url);
$result = $isitup->check();
echo $result;