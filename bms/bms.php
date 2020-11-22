<?php
session_start ();
define("ROOT_DIR", str_replace('bms', '', __DIR__)) . "/";
include ("bms/classes/app.php");
//$app = new app ( );
/*$f = fopen ( "includes/license.txt", "r" );
if ($f) {
	$lc = fread ( $f, filesize ( "includes/license.txt" ) );
	if(md5("haidtedatha".getMAC())==trim($lc)) {
		$app->run ();
	} else {
		echo 'Hãy liên hệ đăng ký bản quyền support@eda.vn';
	}
} else {
	echo 'Hãy liên hệ đăng ký bản quyền support@eda.vn';
}*/
//$app->run ();
//$app->app_close ();
?>