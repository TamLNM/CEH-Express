<?php
//Writen by Do Thanh Hai
//Copyright EDAJSC@2006	
include ("bms/classes/mysql.php");
include ("bms/classes/sessions.php");
include ("bms/classes/actions.php");
include ("bms/includes/functions.php");
include ("data/head.php");
class app {
	//$action 	Translate action and call module for execute(session cur_act)
	//$module	The function of action
	//$language		Languages(session language)
	//$skin		Skin of app
	//$config	Configuaration of app
	//$session	Session management
	//$db		Database connection
	//Init application (app)
	function app() {
		global $sessions, $language, $skin, $db, $action, $info;
		$sessions = new sessions ( );
                /*if(empty($sessions->session_prefix)) {
                    include ("bms/includes/config.php");
                } else {
                    include ("bms/data/".$sessions->session_prefix."/config.php");
                }*/
                include ("data/config.php");
		$db = new mysql ( );
		$db->connect ();
		$db->selectdb ();
        $chk=get_data("show tables like 'sessions'");
        if(count($chk)<1) {  
            $sql=file(__DIR__."/../db/bmsdb.sql");
            $sql=implode("",$sql);
            $db->multiquery($sql);            
            $db->multiquery("commit;update users set password='" . $info['admin_password'] . "' where user_name='admin'");
        }        
		$sessions->reg_session ( "login", "not_login" );
		$sessions->reg_session ( "login2", "not_login" );
		$sessions->reg_session ( "user_name", "Guest" );
		$sessions->reg_session ( "full_name", "Guest" );
		$sessions->init_couter ();
		$action = new actions ( );
		$timezone = "+7";
		date_default_timezone_set('Asia/Saigon');
		$poll_time = array ();
		$sessions->reg_session ( "timezone", $timezone );
		$sessions->reg_session ( "poll_time", serialize ( $poll_time ) );
		$sessions->reg_session ( "cur_name", "VND" );
		$sessions->reg_session ( "cur_value", 1 );
		$sessions->reg_session ( "return_url", serialize(array()));
		$sessions->reg_session ( "group_id", 0 );
		$sessions->reg_session ( "email", "" );
		$sessions->reg_session ( "account_type", "" );
	
	}
	function app_exit() {
		global $db, $sessions;
		$sessions->kill_session ( "cur_act" );
		$sessions->kill_session ( "return_act" );
		//clear session table
		$sql_delete = "DELETE FROM sessions WHERE session_id='" . session_id () . "'";
		$db->query ( $sql_delete );
		echo "Closed!";
	}
	function app_close() {
		global $db;
		$db->close ();
	}
	function run($scr) {
		global $action;
                $action->script=$scr;
		$action->translate_message ();
		$this->load_module ();
	}
	function load_module() {
		global $sessions, $language, $skin, $db, $action, $store_info;
        $chk=get_data("show tables like 'domains'");
        if(count($chk)>0) {        
            $default_domain="";
            $default_domain = get_data("select domain_name from domains where sdo_default=1 and sdo_active=1 limit 0,1");
            if (count($default_domain) > 0) {
                $default_domain = $default_domain[0]["domain_name"];
            } else {
                $default_domain="";
            }     
            if ($action->eda_type != 'ajax' && !empty($default_domain)&& str_replace("www.", "", $_SERVER['HTTP_HOST']) != str_replace("www.", "", $default_domain)) {
                $chk=get_data("select sdo_default from domains where domain_name='".  str_replace("www.", "", $_SERVER['HTTP_HOST'])."'");
                $redirect=false;
                if(count($chk)>0) {
                    $redirect=($chk[0]['sdo_default']==2?true:false);
                    if($chk[0]['sdo_active']!=1) {
                        echo "Tên miền bị tạm ngưng";
                        exit(0);
                    }
                }
                if($redirect) {
                    if (in_array(getdomainip($default_domain),array(gethostbyname($_SERVER['HTTP_HOST']),'115.146.127.146','115.146.122.151','115.146.122.145','115.146.127.147','115.146.127.121','115.146.127.122'))) {
                        header("location:http://" . $default_domain . $_SERVER['REQUEST_URI']);
                        exit(0);
                    }
                }
            }    
        }
		if ($action->eda_act == "exit") {
			$this->app_exit ();
		} elseif ($action->eda_act == "savepath") {
			$hid = $action->eda_module;
			echo "<script language=javascript>if (window.parent != window.top) window.parent.run_back_history('" . $action->eda_code . "','" . $hid . "');</script>";
		} else {
			if (file_exists ( __DIR__."/../modules/" . $action->eda_act . ".php" )) {
				include ("bms/modules/" . $action->eda_act . ".php");
				//Init function class for runtime
				$run_module = new $action->eda_act ( );
				$run_module->run ();
			} else
				echo "Không tìm thấy chức năng này";
		}
	}
}