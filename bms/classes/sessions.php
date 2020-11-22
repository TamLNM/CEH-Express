<?php
//Writen by Do Thanh Hai
//Copyright EDAJSC@2006	
class sessions {
	var $session_prefix;
	//Init session
	function sessions() {
            global $action;
            $this->session_prefix="";
            /*if(isset($_GET['user'])) {
                if(file_exists("bms/users/".$_GET['user'])) {
                    $this->session_prefix = $_GET['user'];
                } else {
                    header("Location:/");
                    exit(0);
                }
            } else if(str_replace ("www.","",$_SERVER['HTTP_HOST'])!='bms.talaweb.com') {
                include("bms/users/usermap.php");
                if(isset($usermap[str_replace ("www.","",$_SERVER['HTTP_HOST'])])) {
                    $this->session_prefix=$usermap[str_replace ("www.","",$_SERVER['HTTP_HOST'])];
                }
            }*/
	}
	//Register session
	function reg_session($session_var, $session_val) {
		global $_SESSION;
		$sname = $this->session_prefix . $session_var;
		if (! isset ( $_SESSION [$sname] )) {
			//session_register ( $sname );
			$_SESSION [$sname] = $session_val;
		}
	}
	//Get session value
	function get_session($session_var) {
		global $_SESSION;
		$sname = $this->session_prefix . $session_var;
		return isset ( $_SESSION [$sname] ) ? $_SESSION [$sname] : '';
	}
	//Set value for session variable
	function set_session($session_var, $session_val) {
		global $_SESSION;
		$sname = $this->session_prefix . $session_var;
		//if (! isset ( $_SESSION [$sname] )) {
		//	session_register ( $sname );
		//}
		$_SESSION [$sname] = $session_val;
	}
	//Release session variable
	function kill_session($session_var) {
		global $_SESSION;
		$sname = $this->session_prefix . $session_var;
		if (isset ( $_SESSION [$sname] )) {
                    unset($_SESSION [$sname]);
			//session_unregister ( $sname );
		}
	}
	function init_couter() {
		global $db, $sessions, $counter, $info;
		//mysql_connect("localhost",$info["eda_user"],$info["eda_password"]);
		//mysql_select_db($info["eda_db"]);
		$sql_select = "SELECT * FROM sessions WHERE session_id='" . session_id () . "'";
		$qry = $db->query ( $sql_select );
		if ($db->num_rows ( $qry ) == 0) {
			if ($sessions->get_session ( "login" ) == 'logined') {
				$sessions->set_session ( "login", "not_login" );
				$sessions->set_session ( "login2", "not_login" );
				$sessions->set_session ( "user_name", "Guest" );
				$sessions->set_session ( "user_id", "0" );
				$sessions->set_session ( "full_name", 'Guest' );
				$sessions->set_session ( "user_id", "0" );
				$sessions->set_session ( "email", "" );
				$sessions->set_session ( "account_type", "" );
			} else {
				$sessions->reg_session ( "login", "not_login" );
				$sessions->set_session ( "login2", "not_login" );
				$sessions->reg_session ( "user_name", "Guest" );
				$sessions->reg_session ( "user_id", "0" );
				$sessions->set_session ( "full_name", 'Guest' );
				$sessions->set_session ( "user_id", "0" );
				$sessions->set_session ( "email", "" );
				$sessions->set_session ( "account_type", "" );
				$sql_insert = "INSERT INTO sessions(session_id,start_time,user_id,ip) values('" . session_id () . "'," . time () . ",null,'" . $this->getip () . "')";
				$db->query ( $sql_insert );
			}
		} else {
			$s = $db->fetch_array ( $qry );
			if (time () - $s ['start_time'] < $info ["session_timeout"])
				$qry = $db->query ( "update sessions set start_time='" . time () . "' where session_id='" . session_id () . "'" );
			else {
				$sessions->set_session ( "login", "not_login" );
				$sessions->set_session ( "login2", "not_login" );
				$sessions->set_session ( "user_name", "Guest" );
				$sessions->set_session ( "user_id", "0" );
				$sessions->set_session ( "full_name", 'Guest' );
				$sessions->set_session ( "user_id", "0" );
				$sessions->set_session ( "email", "" );
				$sessions->set_session ( "account_type", "" );
			}
		}
		$prevtime = time () - $info ["session_timeout"];
		$sql_delete = "DELETE FROM sessions WHERE start_time<" . $prevtime;
		$db->query ( $sql_delete );
		//$db=new mysql();
	//$db->connect();
	//$db->selectdb();
	}
	function getip() {
		if (getenv ( "HTTP_CLIENT_IP" ) && strcasecmp ( getenv ( "HTTP_CLIENT_IP" ), "unknown" ))
			$ip = getenv ( "HTTP_CLIENT_IP" );
		else if (getenv ( "HTTP_X_FORWARDED_FOR" ) && strcasecmp ( getenv ( "HTTP_X_FORWARDED_FOR" ), "unknown" ))
			$ip = getenv ( "HTTP_X_FORWARDED_FOR" );
		else if (getenv ( "REMOTE_ADDR" ) && strcasecmp ( getenv ( "REMOTE_ADDR" ), "unknown" ))
			$ip = getenv ( "REMOTE_ADDR" );
		else if (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], "unknown" ))
			$ip = $_SERVER ['REMOTE_ADDR'];
		else
			$ip = "unknown";
		return ($ip);
	}
}