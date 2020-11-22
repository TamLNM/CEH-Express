<?php
//Writen by Do Thanh Hai
//Copyright EDAJSC@2006	
class actions {
	var $eda_act; //Current action
	var $eda_code; //Command parameter
	var $eda_decode; //Decode
	var $eda_pid; //Parent id
	var $eda_cid; //Category id
	var $eda_id; //id - Identification of somthing
	var $eda_page; //Page
	var $eda_module; //Module
	var $eda_type; //Type
	var $choice; //List of modules
	var $title;
        var $script='';
	//Init action
	function actions() {
		global $sessions;
		$sessions->reg_session ( "cur_act", "" );
		$sessions->reg_session ( "return_act", "" );
		$this->choice = array ();
	}
	//Translate action (md5 encode to module name)
	function decode_module() {
		$this->choice = array (md5 ( "homepage" ) => "homepage", md5 ( "waranty" ) => "waranty", md5 ( "sell" ) => "sell", md5 ( "finance" ) => "finance", md5 ( "general" ) => "general", md5 ( "manufacturing" ) => "manufacturing", md5 ( "tariff" ) => "tariff", md5 ( "user_manager" ) => "user_manager", md5("warehouse_management") => "warehouse_management");
	}
	//Get parameter for action
	function translate_message() {
		global $_GET, $sessions;
		//Get parameter
		$this->eda_act = isset ( $_GET ["eda_act"] ) ? data_pre ( $_GET ["eda_act"] ) : md5 ( "homepage" );
		$this->eda_cid = isset ( $_GET ["eda_cid"] ) ? data_pre ( $_GET ["eda_cid"] ) : 0;
		$this->eda_id = isset ( $_GET ["eda_id"] ) ? intval ( $_GET ["eda_id"] ) : 0;
		$this->eda_pid = isset ( $_GET ["eda_pid"] ) ? intval ( $_GET ["eda_pid"] ) : 0;
		$this->eda_code = isset ( $_GET ["eda_code"] ) ? data_pre ( $_GET ["eda_code"] ) : "";
		$this->eda_module = isset ( $_GET ["eda_module"] ) ? data_pre ( $_GET ["eda_module"] ) : "";
		$this->eda_type = isset ( $_GET ["eda_type"] ) ? data_pre ( $_GET ["eda_type"] ) : "";
		$this->eda_page = isset ( $_GET ["eda_page"] ) ? intval ( $_GET ["eda_page"] ) : "1";
		$this->title = "Express - Dịch vụ gửi hàng và chuyển phát nhanh quốc tế";
		if ($this->eda_page == 0)
			$this->eda_page = 1;
			//Translate action (md5 encode to module name)
		$this->decode_module ();
		//Check action exists, if not exists then return underconstruction
		if ($this->eda_act == md5 ( "exit" ))
			$this->eda_act = "exit";
		elseif (! array_key_exists ( $this->eda_act, $this->choice )) {
			$this->eda_act = "homepage";
			$sessions->set_session ( "cur_act", $this->eda_act );
		} else if (isset ( $this->choice [$this->eda_act] ) || file_exists ( "classes/" . $this->choice [$this->eda_act] . ".php" ) || $this->eda_act == md5 ( "savepath" )) {
			if ($this->eda_act != md5 ( "search" ) && $this->eda_act != md5 ( "savepath" ))
				$sessions->set_session ( "cur_act", $this->choice [$this->eda_act] );
			$this->eda_act = $this->choice [$this->eda_act];
		} else {
			//$sessions->set_session("cur_act",$this->choice[$this->eda_act]);
			$this->eda_act = "underconstruction";
		}
		call_productStocksPull();
	}
}