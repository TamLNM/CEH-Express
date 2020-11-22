<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/barcode/BarcodeGenerator.php";
require_once APPPATH."/barcode/BarcodeGeneratorPNG.php";

class Barcode {
    public function __construct() {
        
    }
    public function make_base64_url($code){
    	$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        return 'data:image/png;base64,' . base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128)) . '';
    }
}