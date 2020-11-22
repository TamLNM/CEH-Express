<?php
require_once("bms/library/include/PHPMailerAutoload.php");

class Email extends PHPMailer {
    public function __construct() {
        parent::__construct();
    }
}