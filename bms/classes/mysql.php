<?php
//Writen by Do Thanh Hai
//Copyright EDAJSC@2006
class mysql {
	var $db_host = ""; //Host name
	var $db_name = ""; //Database name
	var $db_username = ""; //User name
	var $db_password = ""; //Password
	

	var $serverconn = 0;
	var $dbconn = 0;
	
	var $query_id = 0;
	var $result = array ();
	var $query_count = 0;
	var $maximum_time = 0;
	var $timestamp;
	//Init mysql connection
	function mysql() {
		global $info;
		if (! isset ( $info )) {
			$this->halt ( "Can't connect to database..." );
		}
		$this->timestamp = time ();
		if (! $this->maximum_time) {
			$this->maximum_time = ini_get ( 'max_execution_time' );
		}
		
		$this->db_host = $info ["db_host"];
		$this->db_name = $info ["db_name"];
		$this->db_username = $info ["db_username"];
		$this->db_password = $info ["db_password"];
	}

	//Connect to database
	function connect() {
		$this->serverconn = mysqli_connect ( $this->db_host, $this->db_username, $this->db_password ) or $this->halt ( "Không kết nối được với CSDL." );
		@mysqli_query ($this->serverconn,"SET NAMES utf8");
		@DEFINE ( '_ISO', 'charset=utf-8' );
	}
	function escape_string($string){
		return mysqli_real_escape_string($this->serverconn,$string);
	}
	function real_escape_string($string) {
                return mysqli_real_escape_string($this->serverconn, $string);
        }
    function safe_str($string) {
                return mysqli_real_escape_string($this->serverconn, $string);
        }
	function selectdb($database = "") {
		if ($database != "")
			$this->db_name = $database;
		$this->dbconn = mysqli_select_db ($this->serverconn, $this->db_name ) or $this->halt ( "Không kết nối được với CSDL:" . $this->db_name );
	}
	
	function query($query_string = "") {
		global $sessions;
		$this->timestamp = time ();
		if ($query_string != "") {
			//$this->query_id = mysql_query($query_string) or $this->halt(($_SESSION["user_name"]=="admin"?mysql_error():"")." Không thực hiện được ". ($_SESSION["user_name"]=="admin"?$query_string:""));
			$this->query_id = mysqli_query ($this->serverconn, $query_string ) or $this->halt ( mysqli_error ($this->serverconn) . " Không thực hiện được " . $query_string );
			$this->query_count ++;
		}
		return $this->query_id;
	}
	function multiquery($query_string = "") {
		global $sessions;
		$this->timestamp = time ();
		if ($query_string != "") {
			//$this->query_id = mysql_query($query_string) or $this->halt(($_SESSION["user_name"]=="admin"?mysql_error():"")." Không thực hiện được ". ($_SESSION["user_name"]=="admin"?$query_string:""));
			$this->query_id = mysqli_multi_query ($this->serverconn, $query_string ) or $this->halt ( mysqli_error ($this->serverconn) . " Không thực hiện được " . $query_string );
			$this->query_count ++;
		}
                while (mysqli_next_result($this->serverconn)) {;}
		return $this->query_id;
	}	
	function fetch_array($query_id = false) {
		if ($query_id)
			$this->query_id = $query_id;
		$this->result = mysqli_fetch_array ( $this->query_id);
		return $this->result;
	}
	

	
	function num_rows($query_id = false) {
		if ($query_id)
			$this->query_id = $query_id;
		return mysqli_num_rows ( $this->query_id );
	}
        
        function free_result($sql_query) {
            mysqli_free_result($sql_query);
        }
	
	function check_exist($fromtable, $checkname, $checkvalue) {
		$sql_query = "SELECT user_id FROM $fromtable WHERE $checkname='" . $checkvalue . "'";
		$this->query ( $sql_query );
		if ($this->num_rows () > 0)
			return 1;
		
		return 0;
	}
	
	function close() {
		return mysqli_close ( $this->serverconn );
	}
	
	function halt($msg) {
		global $info;
		echo $msg;
		echo "<br>Hãy <a href='mailto:admin@eda.vn'>liên hệ</a> với quản trị để thông báo về lỗi này!<br> <a href='javascript:history.go(-1);'>Quay lại</a>";
		die ();
	}
	
	function timeout() {
		if (! $this->maximum_time) {
			return false;
		} elseif ((time () - $this->timestamp) > ($this->maximum_time - 5)) {
			return true;
		} else {
			return false;
		}
	}
	function insert_id() {
		return mysqli_insert_id($this->serverconn);
	}
	function affected_rows(){
		//return mysql_affected_rows();
		return $this->serverconn->affected_rows;
	}
	
	function getmax($table, $field) {
		$qry = $this->query ( "select max($field) as c from $table" );
		$result = $this->fetch_array ( $qry );
		if ($result ["c"] != "")
			return $result ["c"];
		else
			return 0;
	}
	function getval($table, $field, $where) {
		$qry = $this->query ( "select $field from $table $where" );
		if ($this->num_rows ()) {
			$result = $this->fetch_array ( $qry );
			return $result ["$field"];
		} else
			return 0;
	}
}