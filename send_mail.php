<?php
require_once ("bms/library/Semail.php");

$toemail 	= $_POST['toemail'];
$title 		= $_POST['title'];
$Subject 	= $_POST['Subject'];
$noidung 	= $_POST['noidung'];
$image 		= $_POST['image'];
$host 		= $_POST['host'];
$port 		= $_POST['port'];
$SMTPSecure = $_POST['SMTPSecure'];
$email 		= $_POST['email'];
$password 	= $_POST['password'];

/*
$noidung 	= 'xxx';
$toemail 	= '15520756@gm.uit.edu.vn';
$title 		= 'xxx';
$Subject 	= 'xxx';
$image 		= '';
$host 		= 'smtp.gmail.com';
$port 		= '587';
$SMTPSecure = 'tls';
$email 		= 'doanvanhieu.info@gmail.com';
$password 	= 'nixxvtwcfzpxalld';
*/

$xnoidung = str_replace("%26", "&",$noidung);
$xnoidung = str_replace("%40", "@",$xnoidung);

if (filter_var($toemail, FILTER_VALIDATE_EMAIL)) {
            
if(!class_exists("PHPMailer")) require_once("bms/library/include/PHPMailerAutoload.php");

$mail = new PHPMailer();
ini_set ( 'max_execution_time', 1200);
date_default_timezone_set('Etc/UTC');
$user=array();
$mail->IsSMTP();
$mail->SMTPDebug = 1;
$mail->CharSet = 'UTF-8';
$mail->Debugoutput = 'html';
$mail->SMTPAuth = true;
$mail->SMTPSecure = $SMTPSecure;
$mail->Host = $host;//"smtp.gmail.com";
$mail->Port = $port;//587;
$mail->IsHTML(true);

$from = $email;//'doanvanhieu.info@gmail.com';
$mail->Username = $from;
$mail->Password = $password;//"nixxvtwcfzpxalld";

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
    