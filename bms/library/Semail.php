<?php

class Semail{
    public function __construct() {
        
    }

public function send1($toemail,$title,$Subject,$noidung,$image="",$email){


$xnoidung = str_replace("%26", "&",$noidung);
$xnoidung = str_replace("%40", "@",$xnoidung);

//return $this->sv_send_mail($title,$xnoidung,$toemail,$fromemail,$fromname);//tat gui mail bang sv phu
  if (filter_var($toemail, FILTER_VALIDATE_EMAIL)) {
            
    if(!class_exists("PHPMailer"))
require_once("bms/library/include/PHPMailerAutoload.php");
$mail = new PHPMailer();
ini_set ( 'max_execution_time', 1200);
date_default_timezone_set('Etc/UTC');
$user=array();
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->CharSet = 'UTF-8';
$mail->Debugoutput = 'html';
$mail->SMTPAuth = true;
$mail->SMTPSecure = $email[0]['SMTPSecure'];
$mail->Host = $email[0]['host'];//"smtp.gmail.com";
$mail->Port = $email[0]['port'];//587;
$mail->IsHTML(true);

$from = $email[0]['email'];//'doanvanhieu.info@gmail.com';
$mail->Username = $from;
$mail->Password = $email[0]['password'];//"nixxvtwcfzpxalld";

$mail->SetFrom($from,$title);

$mail->Subject = $Subject;

$mail->msgHTML($xnoidung);
$mail->AddAddress($toemail);

if(!$mail->Send())
{
return false;
}
else
{
return true;
}
    }
    
}


	public function send($toemail,$title,$Subject,$noidung,$image="",$email){
		$url = 'http://phuongnam.hethongdulieu.com/test.php';
	    $curl = curl_init();  

	    $post['toemail'] 	= $toemail;
	    $post['title'] 		= $title;
	    $post['Subject']	= $Subject;
	    $post['noidung'] 	= $noidung;
	    $post['image'] 		= $image;
	    $post['email'] 		= $email[0]['email'];
	    $post['password'] 	= $email[0]['password'];
	    $post['host'] 		= $email[0]['host'];
	    $post['port'] 		= $email[0]['port'];
	    $post['SMTPSecure'] = $email[0]['SMTPSecure'];

	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt ($curl, CURLOPT_POST, TRUE);
	    curl_setopt ($curl, CURLOPT_POSTFIELDS, $post); 

	    curl_setopt($curl, CURLOPT_USERAGENT, 'api');

	    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
	    curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
	    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
	    curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10); 
	    curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

	    $ff=curl_exec($curl);
	    curl_close($curl);
	}
}