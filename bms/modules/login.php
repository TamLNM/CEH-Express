<?php
class login {
	function login() {
	}
	function execute($code, $uname, $passwrd, $type) {
		global $sessions, $db, $action, $info;
		//mysql_connect($info["eda_host"],$info["eda_user"],$info["eda_password"]);
		//mysql_select_db($info["eda_db"]);
		if ($code == "in") {
			if (empty ( $uname ) || empty ( $passwrd )) {
				//$db=new mysql();
				//$db->connect();
				//$db->selectdb();
				

				return "Hãy nhập tên đăng nhập và mật khẩu";
			}
			
			/*
			if(!preg_match("/^([a-zA-Z0-9]+)$/", $uname)) {
				return "Tên đăng nhập không chính xác.";
			}
			*/
			
			//-----------------------------------------------------
			$db->query ( "select * from users where user_name='" . $uname . "'" );
			$result = $db->fetch_array ();
			$pass = $result ["password"];
			$id = $result ["user_id"];
			//-----------------------------------------------------
			

			//check password is correct ?
			if (md5 ( $passwrd ) != $pass) {
				//$db=new mysql();
				//$db->connect();
				//$db->selectdb();
				return "Sai mật khẩu";
			}
			
			$sql_delete = "DELETE FROM sessions WHERE session_id='" . session_id () . "'";
			$db->query ( $sql_delete );
			
			//----------- LOGIN -------------
			$sessions->set_session ( "login", "logined" );
			$sessions->set_session ( "user_name", $result ["user_name"] );
			$sessions->set_session ( "full_name", $result ["full_name"] );
			$sessions->set_session ( "user_id", $result ["user_id"] );
			$sessions->set_session ( "email", $result ["email"] );
			$sessions->set_session ( "group_id", $result ["group_id"] );
            $sessions->set_session ( "start_time", time () );
            $access_token=md5(time()."CEH".$result ["email"].$result ["user_id"]);

            setcookie('access_token', $access_token, time() + (86400 * 365), "/");
            $db->query("update users set access_token='{$access_token}' where user_id=".$result["user_id"]);
            
			//$sessions->set_session ( "account_type", $result ["account_type"] );
			$sql_delete = "DELETE FROM sessions WHERE user_id='" . $result ["user_id"] . "'";
			$db->query ( $sql_delete );
			$sql_insert = "INSERT INTO sessions(session_id,start_time,user_id,ip) VALUES('" . session_id () . "'," . time () . ",'" . $sessions->get_session ( "user_id" ) . "','" . getenv ( "REMOTE_ADDR" ) . "')";
			$db->query ( $sql_insert );
                        $db->query ( "INSERT INTO login_history( start_time,user_id,ip,agent) VALUES(" . $sessions->get_session ( "start_time" )  . ",'" . $sessions->get_session ( "user_id" ) . "','" . $sessions->getip () . "','".$_SERVER['HTTP_USER_AGENT']."')" );
                        /*$lhi=get_data ( "select lhi_id from login_history WHERE user_id='" . $sessions->get_session ( "user_id" ) . "'  order by lhi_id desc limit 20,1" );
                        if(count($lhi)>0) {
                                $db->query ( "delete from login_history WHERE lhi_id='" . $lhi[0][0] . "'" );
                        } */                       
			//$db=new mysql();
			//$db->connect();
			//$db->selectdb();
			
            //header("Location: https://www.google.com");
			return "";
		} else if ($code == "out") {
			//----------- LOGOUT -------------
                        if ($sessions->get_session ( "login" ) != 'not_login') {
                                $db->query("update login_history set end_time='".time()."' where user_id='" . $sessions->get_session ( "user_id" ) . "' and start_time='" . $sessions->get_session ( "start_time" )  . "'");
                                $sql_delete = "DELETE FROM sessions WHERE user_id='" . $sessions->get_session ( "user_id" ) . "' or session_id='" . session_id () . "'";
                                $db->query ( $sql_delete );                                
                        }                        
                        $sessions->set_session ( "login", "not_login" );
			//$db=new mysql();
			//$db->connect();
			//$db->selectdb();
			return "";
		}
		//$db=new mysql();
		//$db->connect();
		//$db->selectdb();
		

		return "";
	}
}
?>
