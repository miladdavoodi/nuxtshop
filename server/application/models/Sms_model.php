<?php
	class Sms_model extends CI_Model{

	var $url = "http://onlinepanel.ir/post/send.asmx?wsdl";
	var $username = "hrohani";
	var $password = "003808400";
	var $from = "30002666666616";
	var $unicode = 'UTF-8//TRANSLIT';
	var $is_flash = false;
	
	
	public function convertToUTF8($str) {
    $enc = mb_detect_encoding($str);

    if ($enc && $enc != 'UTF-8') {
        return iconv($enc, 'UTF-8', $str);
    } else {
        return $str;
    }
	}
	
	function sendsms($to,$text){
			
		try {
			$client = new SoapClient($this->url);
			$parameters['username'] = $this->username;
			$parameters['password'] = $this->password;
			$parameters['from'] = $this->from;
			$parameters['to'] = array($to);
			$parameters['text'] = $this->convertToUTF8($text);
			$parameters['isflash'] = $this->is_flash;
			$parameters['udh'] = "";
			$parameters['recId'] = array(0);
			$parameters['status'] = 0x0;
			//
			$client->SendSms($parameters)->SendSmsResult;
		 } catch (SoapFault $ex) {
			$i = $ex->faultstring;
		}
		
		return $i."1";
	}


	
}
?>