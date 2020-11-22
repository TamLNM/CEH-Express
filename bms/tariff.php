<?php
require_once 'bms/classes/modules.php';
require_once 'bms/excel_classes/PHPExcel.php';
require_once 'bms/excel_classes/PHPExcel/IOFactory.php';
require_once ("bms/phpqrcode/qrlib.php");
require_once ("bms/library/Qrmaker.php");
require_once ("bms/library/Semail.php");

class tariff extends modules {
    function tariff() {
    }

    function child_run() {
        global $action, $sessions, $db, $file_tmp, $err_msg, $return_val, $transfer, $head;
        
        if ($sessions->get_session("login") != "logined" && $action->eda_code != md5("login") && $action->eda_code != md5("in") && $action->eda_code != md5("reg") && $action->eda_code != md5("forgot") && $transfer == false) {
            include("bms/templates/login.htm");
            $transfer = true;
        } 
        else {
        	switch ($action->eda_code) {
                // Biểu cước vận chuyển
                case md5("trf_transport"):
                	$action->title = "Biểu cước vận chuyển";
                    $action->eda_decode = "trf_transport";
                    $file_tmp = "tariff/trf_transport.htm";  
              		break;

                // Quản lý loại hàng
                case md5('stock_type'):
                    $action->title = "Quản lý loại hàng";
                    $action->eda_decode = "stock_type";
                    $file_tmp = "tariff/stock_type.htm";
                    break;

                // Hợp đồng
                case md5('contract'):
                    $action->title = "Hợp đồng";
                    $action->eda_decode = "contract";
                    $file_tmp = "tariff/contract.htm";
                    break;

                // Thêm dữ liệu Tính cước Order 
                case md5('add_ord_tariff_data'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->add_ord_tariff_data($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;
                case md5('edit_ord_tariff_data'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->edit_ord_tariff_data($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;
                case md5('update_status_ord_tariff_data'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->update_status_ord_tariff_details_data($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('add_ord_tariff_details_data'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->add_ord_tariff_details_data($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;        
                case md5('edit_ord_tariff_details_data'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->edit_ord_tariff_details_data($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;               
                case md5('create_template_file_for_stocktype'):
                    $this->xxx();
                    break;

                case md5('update_transported_internal_warehouse_data'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->update_transported_internal_warehouse_data($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('update_ORD_TRF_Details'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->update_ORD_TRF_Details($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('update_ORD_TRF_on_release'):
                    $data       = $_POST['data'] ? $_POST['data'] : array();
                    $ordIDList  = $_POST['ordIDList'] ? $_POST['ordIDList'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->update_ORD_TRF_on_release($data, $ordIDList);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('update_ORD_TRF_on_shipping'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->update_ORD_TRF_on_shipping($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('add_cus_by_trf'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->add_cus_by_trf($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('add_contract'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->add_contract($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('update_contract'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->update_contract($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('add_contract_details'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->add_contract_details($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('update_contract_details'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->update_contract_details($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('delete_contract_details'):
                    $data = $_POST['data'] ? $_POST['data'] : array();
                    $result['error'] = array();
                    $result['success'] = array();
                    $this->delete_contract_details($data);                   
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                case md5('load_contract_data'):
                    $warehouse_id_dep = $_POST['warehouse_id_dep'];
                    $warehouse_id_des = $_POST['warehouse_id_des'];
                    $query = get_data("select * from trf_transport a, stock_type b where a.warehouse_id_dep=b.warehouse_id and a.warehouse_id_dep='".$warehouse_id_dep."' and a.warehouse_id_des='".$warehouse_id_des."'");
                    $dtx=array();
                    $stt=0;
                    foreach($query as $item => $value){
                            $stt++;
                            $ins=array($stt, '', $value['trf_trs_id'], $value['trf_trs_code'], $value['trf_trs_name'], $value['stock_type_id'], $value['stock_type_name'], $value['stock_type_name'], $value['currency_id'], $value['currency_code'], $value['currency_name'], $value['include_vat'], $value['vat'], $value['air_freight_rates'], $value['air_freight_rates'], $value['sea_freight_rates'], $value['sea_freight_rates'], $value['road_freight_rates'], $value['road_freight_rates'], $value['iron_freight_rates'], $value['iron_freight_rates'], $value['expense'], $value['expense'], $value['warehouse_id_dep'], $value['warehouse_code_dep'], $value['warehouse_name_dep'], $value['warehouse_id_des'], $value['warehouse_code_des'], $value['warehouse_name_des']);
                            $dtx[]=$ins;
                    } 
                    echo(json_encode($dtx, false));
                    exit();
                    break;

                case md5('load_tariff_data'):
                    $warehouse_id_dep = $_POST['warehouse_id_dep'];
                    $warehouse_id_des = $_POST['warehouse_id_des'];
                    $query = get_data("select * from trf_transport where warehouse_id_dep='".$warehouse_id_dep."' and warehouse_id_des='".$warehouse_id_des."'");
                    $dtx=array();
                    $stt=0;
                    foreach($query as $item => $value){
                            $stt++;
                            $ins=array($stt, $value['trf_trs_id'], $value['trf_trs_code'], $value['trf_trs_name'], $value['warehouse_id_dep'], $value['warehouse_code_dep'], $value['warehouse_name_dep'], $value['warehouse_id_des'], $value['warehouse_code_des'], $value['warehouse_name_des'], $value['currency_id'], $value['currency_code'], $value['currency_name'], $value['vat'], $value['include_vat'], $value['air_freight_rates'], $value['sea_freight_rates'], $value['road_freight_rates'], $value['iron_freight_rates']);
                            $dtx[]=$ins;
                    } 
                    echo(json_encode($dtx, false));
                    exit();
                    break;

                case md5('load_stock_type_data'):
                    $warehouse_id_dep = $_POST['warehouse_id_dep'];
                    $warehouse_id_des = $_POST['warehouse_id_des'];
                    $query = get_data("select * from stock_type where warehouse_id='".$warehouse_id_dep."'");
                    $dtx=array();
                    $stt=0;
                    foreach($query as $item => $value){
                            $stt++;
                            $ins=array($stt, $value['stock_type_id'], $value['stock_type_code'], $value['stock_type_name'], $value['warehouse_id'], $value['warehouse_code'], $value['warehouse_name'], $value['expense_type'], $value['currency_id'], $value['currency_code'], $value['currency_name'], $value['expense'], $value['unit_id'], $value['unit_code'], $value['unit_name']);
                            $dtx[]=$ins;
                    } 
                    echo(json_encode($dtx, false));
                    exit();
                    break;

                case md5('load_sample_contract_data'):
                    $warehouse_id_dep = $_POST['warehouse_id_dep'];
                    $warehouse_id_des = $_POST['warehouse_id_des'];
                    $contract_code    = $_POST['contract_code'];
                    $query = get_data("select * from contract_details where contract_code='".$contract_code."' and warehouse_id_dep='".$warehouse_id_dep."' and warehouse_id_des='".$warehouse_id_des."'");
                    $dtx=array();
                    $stt=0;
                    foreach($query as $item => $value){
                            $stt++;
                            $ins=array($stt, $value['contract_details_id'], $value['trf_trs_id'], $value['trf_trs_code'], $value['trf_trs_name'], $value['stock_type_id'], $value['stock_type_name'], $value['stock_type_name'], $value['currency_id'], $value['currency_code'], $value['currency_name'], $value['include_vat'], $value['vat'], $value['air_freight_rates'], $value['air_freight_rates'], $value['sea_freight_rates'], $value['sea_freight_rates'], $value['road_freight_rates'], $value['road_freight_rates'], $value['iron_freight_rates'], $value['iron_freight_rates'], $value['expense'], $value['expense'], $value['warehouse_id_dep'], $value['warehouse_code_dep'], $value['warehouse_name_dep'], $value['warehouse_id_des'], $value['warehouse_code_des'], $value['warehouse_name_des']);
                            $dtx[]=$ins;
                    } 
                    echo(json_encode($dtx, false));
                    exit();
                    break;

             	default:
             		break;
        	}
    	}
	}

    function delete_contract_details($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        for ($i = 0; $i < count($data); $i++){
            $db->query("delete from contract_details where contract_details_id='" . $data [$i] . "'");
        }
    }

    function update_contract_details($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
//print_r($data); die('xxx');
        for ($i = 0; $i < count($data); $i++){
            $db->query("update contract_details set trf_trs_id='"   . $data [$i]['trf_trs_id'] 
                        . "', trf_trs_code='"       . $data [$i]['trf_trs_code'] 
                        . "', trf_trs_name='"       . $data [$i]['trf_trs_name']
                        . "', stock_type_id='"      . $data [$i]['stock_type_id']
                        . "', stock_type_code='"    . $data [$i]['stock_type_code'] 
                        . "', stock_type_name='"    . $data [$i]['stock_type_name'] 
                        . "', currency_id='"        . $data [$i]['currency_id'] 
                        . "', currency_code='"      . $data [$i]['currency_code'] 
                        . "', currency_name='"      . $data [$i]['currency_name'] 
                        . "', include_vat='"        . $data [$i]['include_vat'] 
                        . "', vat='"                . $data [$i]['vat']  
                        . "', air_freight_rates='"  . $data [$i]['air_freight_rates']  
                        . "', sea_freight_rates='"  . $data [$i]['sea_freight_rates']  
                        . "', road_freight_rates='" . $data [$i]['road_freight_rates']  
                        . "', iron_freight_rates='" . $data [$i]['iron_freight_rates']  
                        . "', expense='"            . $data [$i]['expense']  
                        . "', air_freight_rates_contract='"  . $data [$i]['air_freight_rates_contract']  
                        . "', sea_freight_rates_contract='"  . $data [$i]['sea_freight_rates_contract']  
                        . "', road_freight_rates_contract='" . $data [$i]['road_freight_rates_contract']  
                        . "', iron_freight_rates_contract='" . $data [$i]['iron_freight_rates_contract']  
                        . "', expense_contract='"            . $data [$i]['expense_contract']  
                        . "', warehouse_id_dep='"   . $data [$i]['warehouse_id_dep']  
                        . "', warehouse_code_dep='" . $data [$i]['warehouse_code_dep']  
                        . "', warehouse_name_dep='" . $data [$i]['warehouse_name_dep']  
                        . "', warehouse_id_des='"   . $data [$i]['warehouse_id_des']  
                        . "', warehouse_code_des='" . $data [$i]['warehouse_code_des']  
                        . "', warehouse_name_des='" . $data [$i]['warehouse_name_des']  
                        . "', updated_by='"         . $data [$i]['updated_by']  
                        . "', update_time='"        . $data [$i]['update_time']  
                        . "' where contract_details_id ='" . $data [$i]['contract_details_id'] . "'");
        }
    }

    function update_contract($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        
        for ($i = 0; $i < count($data); $i++){
            $db->query("update contract set contract_name='"   . $data [$i]['contract_name'] 
                        . "', start_time='"     . $data [$i]['start_time']
                        . "', finish_time='"    . $data [$i]['finish_time']
                        . "', cus_id='"         . $data [$i]['cus_id'] 
                        . "', cus_name='"       . $data [$i]['cus_name'] 
                        . "', cus_type_id='"    . $data [$i]['cus_type_id'] 
                        . "', cus_type_code='"  . $data [$i]['cus_type_code'] 
                        . "', cus_type_name='"  . $data [$i]['cus_type_name'] 
                        . "', nation_id='"      . $data [$i]['nation_id'] 
                        . "', nation_code='"    . $data [$i]['nation_code']  
                        . "', nation_name='"    . $data [$i]['nation_name']  
                        . "', city_id='"        . $data [$i]['city_id']  
                        . "', city_code='"      . $data [$i]['city_code']  
                        . "', city_name='"      . $data [$i]['city_name']  
                        . "', tax_no='"         . $data [$i]['tax_no']  
                        . "', fax='"            . $data [$i]['fax']  
                        . "', bank_acc='"       . $data [$i]['bank_acc']  
                        . "', bank_name='"      . $data [$i]['bank_name']  
                        . "', updated_by='"     . $data [$i]['updated_by']  
                        . "', update_time='"    . $data [$i]['update_time']  
                        . "' where contract_code ='" . $data [$i]['contract_code'] . "'");
        }
    }

    public function add_contract_details($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        for ($i = 0; $i < count($data); $i++){
            $db->query("insert into contract_details(
                contract_code      ,
                trf_trs_id         ,
                trf_trs_code       ,
                trf_trs_name       ,                
                stock_type_id      ,
                stock_type_code    ,
                stock_type_name    ,
                currency_id        ,
                currency_code      ,
                currency_name      ,
                include_vat        ,
                vat                ,
                air_freight_rates  ,
                sea_freight_rates  ,
                road_freight_rates ,
                iron_freight_rates ,
                air_freight_rates_contract  ,
                sea_freight_rates_contract  ,
                road_freight_rates_contract ,
                iron_freight_rates_contract ,
                expense            ,
                expense_contract   ,
                warehouse_id_dep   ,
                warehouse_code_dep ,
                warehouse_name_dep ,
                warehouse_id_des   ,
                warehouse_code_des ,
                warehouse_name_des ,
                created_by         ,
                create_time        ,
                updated_by          ,
                update_time)             
                values('" . $data[$i] ['contract_code'] 
                . "', '"  . $data[$i] ['trf_trs_id']
                . "', '"  . $data[$i] ['trf_trs_code']
                . "', '"  . $data[$i] ['trf_trs_name']
                . "', '"  . $data[$i] ['stock_type_id']
                . "', '"  . $data[$i] ['stock_type_code']
                . "', '"  . $data[$i] ['stock_type_name']
                . "', '"  . $data[$i] ['currency_id']
                . "', '"  . $data[$i] ['currency_code']
                . "', '"  . $data[$i] ['currency_name']
                . "', '"  . $data[$i] ['include_vat']
                . "', '"  . $data[$i] ['vat']
                . "', '"  . $data[$i] ['air_freight_rates']
                . "', '"  . $data[$i] ['sea_freight_rates']
                . "', '"  . $data[$i] ['road_freight_rates']
                . "', '"  . $data[$i] ['iron_freight_rates']
                . "', '"  . $data[$i] ['air_freight_rates_contract']
                . "', '"  . $data[$i] ['sea_freight_rates_contract']
                . "', '"  . $data[$i] ['road_freight_rates_contract']
                . "', '"  . $data[$i] ['iron_freight_rates_contract']
                . "', '"  . $data[$i] ['expense']
                . "', '"  . $data[$i] ['expense_contract']
                . "', '"  . $data[$i] ['warehouse_id_dep']
                . "', '"  . $data[$i] ['warehouse_code_dep']
                . "', '"  . $data[$i] ['warehouse_name_dep']
                . "', '"  . $data[$i] ['warehouse_id_des']
                . "', '"  . $data[$i] ['warehouse_code_des']
                . "', '"  . $data[$i] ['warehouse_name_des']
                . "', '"  . $data[$i] ['created_by']
                . "', '"  . $data[$i] ['create_time']
                . "', '"  . $data[$i] ['updated_by']
                . "', '"  . $data[$i] ['update_time'] . "')");
        }
    }

    public function add_contract($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        
        for ($i = 0; $i < count($data); $i++){
            //$chk = get_data("select * from contract where contract_code='".$data[$i]['contract_code']. "'");
            
            //if (count($chk) > 0) {}
            //else{
                $db->query("insert into contract(
                    contract_code    ,
                    contract_name    ,
                    start_time       ,
                    finish_time      ,
                    cus_id           ,
                    cus_name         ,
                    cus_type_id      ,
                    cus_type_code    ,
                    cus_type_name    ,
                    nation_id        ,
                    nation_code      ,
                    nation_name      ,
                    city_id          ,
                    city_code        ,
                    city_name        ,
                    tax_no           ,
                    fax              ,
                    bank_acc         ,
                    bank_name        ,
                    created_by        ,
                    create_time      ,
                    updated_by        ,
                    update_time)            
                    values('" . $data[$i] ['contract_code'] 
                    . "', '"  . $data[$i] ['contract_name']
                    . "', '"  . $data[$i] ['start_time']
                    . "', '"  . $data[$i] ['finish_time']
                    . "', '"  . $data[$i] ['cus_id']
                    . "', '"  . $data[$i] ['cus_name']
                    . "', '"  . $data[$i] ['cus_type_id']
                    . "', '"  . $data[$i] ['cus_type_code']
                    . "', '"  . $data[$i] ['cus_type_name']
                    . "', '"  . $data[$i] ['nation_id']
                    . "', '"  . $data[$i] ['nation_code']
                    . "', '"  . $data[$i] ['nation_name']
                    . "', '"  . $data[$i] ['city_id']
                    . "', '"  . $data[$i] ['city_code']
                    . "', '"  . $data[$i] ['city_name']
                    . "', '"  . $data[$i] ['tax_no']
                    . "', '"  . $data[$i] ['fax']
                    . "', '"  . $data[$i] ['bank_acc']
                    . "', '"  . $data[$i] ['bank_name']
                    . "', '"  . $data[$i] ['created_by']
                    . "', '"  . $data[$i] ['create_time']
                    . "', '"  . $data[$i] ['updated_by']
                    . "', '"  . $data[$i] ['update_time'] . "')");
            //}            
        }
    }

    public function add_cus_by_trf($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        for ($i = 0; $i < count($data); $i++){
            if ($data[$i]['email'] != ''){
                $chk = get_data("select * from customer where email='".$data[$i]['email']. "'");

                if (count($chk) > 0) {
                    /* Do nothing */
                }
                else{
                    $db->query("insert into customer(
                        cus_name    ,
                        tel         ,
                        email       ,
                        address)            
                        values('" . $data[$i] ['cus_name'] 
                        . "', '"  . $data[$i] ['tel']
                        . "', '"  . $data[$i] ['email']
                        . "', '"  . $data[$i] ['address'] . "')");
                }
            }
        }
    }

    public function make_base64_url($code){
        return 'data:image/png;base64,'.(base64_encode(QRcode::png($code)));
    }
    public function make_png($code,$file){
        return QRcode::png($code,$file);
    }

    public function getQRCode($order_code) {
        return ($this->make_base64_url($order_code));
    }

    public function send_TIWCQRCode($trs_internal_warehouse_code, $warehouse_id_des, $warehouse_name_des, $trs_internal_warehouse_time, $trs_internal_warehouse_by, $order_code){
        $QRCodeURL      = $this->getQRCode($trs_internal_warehouse_code);
        $warehouse_name = $warehouse_name_des;
        $time           = $trs_internal_warehouse_time;
        $reveicerEmail  = get_data("select * from ord_tariff a, email_management b where a.reality_warehouse_id_des='".$warehouse_id_des."' and (a.trs_internal_warehouse_code='".$trs_internal_warehouse_code."' or a.ord_trf_code='".$order_code."')");
        $email_info     = get_data("select * from ord_tariff a, email_management b where (a.trs_internal_warehouse_code='".$trs_internal_warehouse_code."' or a.ord_trf_code='".$order_code."') and a.warehouse_id_dep = b.warehouse_id");

        $mailContent = '<body>
            <div style="padding: 40px;">
            <div style="background-color: green; border-top-left-radius:4px; border-top-right-radius:4px; height: 45px;">
                <label style="margin-top: 7.5px; margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff; float: left">THÔNG TIN KHỞI TẠO CHỨNG TỪ</label>
            </div>
            <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
            <div style="padding:10px 20px 10px 20px; font-family:Tahoma,serif;color:#030303;line-height:26px">
            <b>Kính gửi: Nhân viên quản lý kho ' .  $warehouse_name . '</b>
            <br>
            <span>Thông tin đơn hàng của quý khách như sau: </span>
            </div>
            <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
                <img style="float: right; margin-left:25px; margin-right: 10px; height: 75px; width: 75px; margin-top: auto; margin-bottom: auto;" src="' . $QRCodeURL . '"></img>

                <ul style="list-style:disc; float: left">
                    <li>Thời gian thực hiện: <b>' . substr($time, 8, 2) . '/' . substr($time, 5, 2) . '/' . substr($time, 0,4) .substr($time, 10, strlen($time)) . '</b></li>                         
                    <li>Người thực hiện: <b>' . $trs_internal_warehouse_by . '</b></li>                         
                </ul>

            </div>
            <div style="padding:30px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
                <span>Trân trọng!</span>
                <br>
                <span><b>EXPRESS TRANSPORT CENTER</b></span>
            </div>
            </div>
            </div>
            </body>';
        $temp  = new Semail();
        $temp->send($reveicerEmail[0]['email'], '[EXPRESS TRANSPORT CENTER] Thông tin khởi tạo chứng từ', '[EXPRESS TRANSPORT CENTER] Thông tin khởi tạo chứng từ', $mailContent, '', $email_info);
    }

    public function send_mail($id){                   
        $data           = get_data("select * from ord_tariff where ord_trf_id='" . $id . "' or ord_trf_code='" . $id . "'");
        $order_code     = $data[0]['ord_trf_code'];
        $url            = ROOT_URL."?eda_act=".md5('sell')."&eda_code=".md5('load_order_info')."&order_code=".$order_code;
        $QRCodeURL      = $this->getQRCode($url);
        $sender_name    = $data[0]['sender_name'];
        $receiver_name  = $data[0]['receiver_name'];
        $sender_email   = $data[0]['sender_email'];
        $receiver_email = $data[0]['receiver_email'];
        $status         = $data[0]['status'];
        $email_info     = get_data("select * from ord_tariff a, email_management b where a.ord_trf_code='".$order_code."' and a.warehouse_id_dep = b.warehouse_id");

        switch($status){
            case 'KT':   
                $status = 'Khởi tạo';
                $time   = $data[0]['order_time'];
                break;
            case 'NK':
                $status = 'Nhập kho gửi';         
                $time   = $data[0]['confirm_order_time'];
                break;
            case 'CK':
                $status = 'Chuyển kho';;
                $time   = $data[0]['trs_internal_warehouse_time'];
                break;
            case 'NKN':
                $status = 'Nhập kho nhận';                 
                $time   = $data[0]['release_time'];
                break;                  
            case "GH":
                $status = 'Giao hàng';                     
                $time   = $data[0]['shipping_time'];
                break;
            case "HT":
                $status = 'Hoàn tất';
                $time   = $data[0]['complete_time'];
                break;
            default:
                break;
        }

        $sendMailContent = '<body>
            <div style="padding: 40px;">
            <div style="background-color: green; border-top-left-radius:4px; border-top-right-radius:4px; height: 45px;">
                <label style="margin-top: 7.5px; margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff; float: left">THÔNG TIN TRẠNG THÁI ĐƠN HÀNG</label>
            </div>
            <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
            <div style="padding:10px 20px 10px 20px; font-family:Tahoma,serif;color:#030303;line-height:26px">
            <b>Kính gửi: Quý khách hàng ' .  $sender_name . '</b>
            <br>
            <span>Thông tin đơn hàng của quý khách như sau: </span>
            </div>
            <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
                <img style="float: right; margin-left:25px; margin-right: 10px; height: 75px; width: 75px; margin-top: auto; margin-bottom: auto;" src="' . $QRCodeURL . '"></img>

                <ul style="list-style:disc; float: left">
                    <li>Mã order: <b>' . $order_code . '</b></li>
                    <li>Trạng thái: <b>' . $status . '</b></li>                         
                    <li>Thời gian thực hiện: <b>' . substr($time, 8, 2) . '/' . substr($time, 5, 2) . '/' . substr($time, 0,4) .substr($time, 10, strlen($time)) . '</b></li>                         
                </ul>

            </div>
            <div style="line-height: 30px; padding: 1px; display: inline-flex; width: 100%;">
                <div align="left" style="width: 50%;">
                    <ul style="list-style: disc; float: left;" ="" ="">
                        <li style="list-style: none; margin-left: 0 !important
                       ; font-weight: bolder;">Thông tin người gửi</li>

                        <li style="list-style-type: square;">Họ tên: <b>'.$sender_name.'</b></li>
                        <li style="list-style-type: square;">Số điện thoại: <b>'.$data[0]['sender_tel'].'</b></li>
                        <li style="list-style-type: square;">Email: <b>'.$data[0]['sender_email'].'</b></li>
                        <li style="list-style-type: square;">Địa chỉ: <b>'.$data[0]['sender_address'].'</b></li>
                    </ul>
                </div>

                <div align="left" style="width: 50%;">
                    <ul style="list-style: disc; float: left;" ="" ="">
                        <li style="list-style-type: square; list-style: none; margin-left: 0 !important
                       ; font-weight: bolder;">Thông tin người nhận</li>

                        <li style="list-style-type: square;">Họ tên: <b>'.$receiver_name.'</b></li>
                        <li style="list-style-type: square;">Số điện thoại: <b>'.$data[0]['receiver_tel'].'</b></li>
                        <li style="list-style-type: square;">Email: <b>'.$data[0]['receiver_email'].'</b></li>
                        <li style="list-style-type: square;">Địa chỉ: <b>'.$data[0]['receiver_address'].'</b></li>
                    </ul>
                </div>
            </div>
            <div style="padding:0px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
            <br>
            <span>Để tra cứu chi tiết order, Quý khách vui lòng nhấn nút:</span>
            <br><br>
            <div style="display:inline-flex">
            <a href="'.$url.'" style="margin-right:20px;font-family:Tahoma,serif;background-color:#ff9600;color:#ffffff;font-weight:500;padding:10px 50px 10px 50px;border-radius:4px;border-style:none;text-decoration:none" target="_blank" >TRA CỨU ORDER</a>
            </div>
            </div>
            <div style="padding:30px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
            <span>Trân trọng!</span>
            <br>
            <span><b>EXPRESS TRANSPORT CENTER</b></span>
            </div>
            </div>
            </div>
            </body>';    

        $receivedMailContent = '<body>
            <div style="padding: 40px;">
            <div style="background-color: green; border-top-left-radius:4px; border-top-right-radius:4px; height: 45px;">
                <label style="margin-top: 7.5px; margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff; float: left">THÔNG TIN TRẠNG THÁI ĐƠN HÀNG</label>
            </div>
            <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
            <div style="padding:10px 20px 10px 20px; font-family:Tahoma,serif;color:#030303;line-height:26px">
            <b>Kính gửi: Quý khách hàng ' .  $receiver_name . '</b>
            <br>
            <span>Thông tin đơn hàng của quý khách như sau: </span>
            </div>
            <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
                <img style="float: right; margin-left:25px; margin-right: 10px; height: 75px; width: 75px; margin-top: auto; margin-bottom: auto;" src="' . $QRCodeURL . '"></img>

                <ul style="list-style:disc; float: left">
                    <li>Mã order: <b>' . $order_code . '</b></li>
                    <li>Trạng thái: <b>' . $status . '</b></li>                         
                    <li>Thời gian thực hiện: <b>' . substr($time, 8, 2) . '/' . substr($time, 5, 2) . '/' . substr($time, 0,4) .substr($time, 10, strlen($time)) . '</b></li>                             
                </ul>
            </div>
            <div style="line-height: 30px; padding: 1px; display: inline-flex; width: 100%;">
                <div align="left" style="width: 50%;">
                    <ul style="list-style: disc; float: left;" ="" ="">
                        <li style="list-style: none; margin-left: 0 !important
                       ; font-weight: bolder;">Thông tin người gửi</li>

                        <li style="list-style-type: square;">Họ tên: <b>'.$sender_name.'</b></li>
                        <li style="list-style-type: square;">Số điện thoại: <b>'.$data[0]['sender_tel'].'</b></li>
                        <li style="list-style-type: square;">Email: <b>'.$data[0]['sender_email'].'</b></li>
                        <li style="list-style-type: square;">Địa chỉ: <b>'.$data[0]['sender_address'].'</b></li>
                    </ul>
                </div>

                <div align="left" style="width: 50%;">
                    <ul style="list-style: disc; float: left;" ="" ="">
                        <li style="list-style-type: square; list-style: none; margin-left: 0 !important
                       ; font-weight: bolder;">Thông tin người nhận</li>

                        <li style="list-style-type: square;">Họ tên: <b>'.$receiver_name.'</b></li>
                        <li style="list-style-type: square;">Số điện thoại: <b>'.$data[0]['receiver_tel'].'</b></li>
                        <li style="list-style-type: square;">Email: <b>'.$data[0]['receiver_email'].'</b></li>
                        <li style="list-style-type: square;">Địa chỉ: <b>'.$data[0]['receiver_address'].'</b></li>
                    </ul>
                </div>
            </div>
            <div style="padding:0px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
            <br>
            <span>Để tra cứu chi tiết order, Quý khách vui lòng nhấn nút:</span>
            <br><br>
            <div style="display:inline-flex">
            <a href="'.$url.'" style="margin-right:20px;font-family:Tahoma,serif;background-color:#ff9600;color:#ffffff;font-weight:500;padding:10px 50px 10px 50px;border-radius:4px;border-style:none;text-decoration:none" target="_blank" >TRA CỨU ORDER</a>
            </div>
            </div>
            <div style="padding:30px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
            <span>Trân trọng!</span>
            <br>
            <span><b>EXPRESS TRANSPORT CENTER</b></span>
            </div>
            </div>
            </div>
        </body>';  

        $temp  = new Semail();
        $temp->send($sender_email, '[EXPRESS TRANSPORT CENTER] Thông tin đăng ký vận chuyển đơn hàng', '[EXPRESS TRANSPORT CENTER] Thông tin đăng ký vận chuyển đơn hàng', $sendMailContent, '', $email_info);       

        $temp  = new Semail();
        $temp->send($receiver_email, '[EXPRESS TRANSPORT CENTER] Thông tin đăng ký vận chuyển đơn hàng', '[EXPRESS TRANSPORT CENTER] Thông tin đăng ký vận chuyển đơn hàng', $receivedMailContent , '', $email_info);           
    }

    function update_ORD_TRF_on_shipping($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        
        for ($i = 0; $i < count($data); $i++){
            $db->query("update ord_tariff set status='"   . $data [$i]['status'] 
                        . "', reality_receiver_name='"    . $data [$i]['reality_receiver_name'] 
                        . "', reality_receiver_tel='"     . $data [$i]['reality_receiver_tel']
                        . "', reality_receiver_address='" . $data [$i]['reality_receiver_address']
                        . "', shipping_fee='"             . $data [$i]['shipping_fee'] 
                        . "', shipping_time='"            . $data [$i]['shipping_time'] 
                        . "', shipping_currency_id='"     . $data [$i]['shipping_currency_id'] 
                        . "', shipping_currency_code='"   . $data [$i]['shipping_currency_code'] 
                        . "', shipping_currency_name='"   . $data [$i]['shipping_currency_name'] 
                        . "', updated_by='"               . $data [$i]['updated_by'] 
                        . "', update_time='"              . $data [$i]['update_time']  
                        . "', complete_time='"            . $data [$i]['complete_time']  
                        . "' where ord_trf_code ='"       . $data [$i]['ord_trf_code'] . "'");
            update_ord_status($data[$i] ['status'],$data [$i]['ord_trf_code'],0);
            $this->send_mail($data[$i]['ord_trf_id']);
        }
    }

    function update_ORD_TRF_on_release($data, $ordIDList){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $ddt=array();
        for ($i = 0; $i < count($data); $i++){
            $db->query("update ord_tariff set status='"   . $data [$i]['status'] 
                        . "', released_by='"              . $data [$i]['released_by'] 
                        . "', release_time='"             . $data [$i]['release_time']
                        . "', updated_by='"               . $data [$i]['updated_by'] 
                        . "', update_time='"              . $data [$i]['update_time']  
                        . "' where trs_internal_warehouse_code ='" . $data [$i]['trs_internal_warehouse_code'] . "'");
            $dt=get_data("select ord_trf_code from ord_tariff where trs_internal_warehouse_code='" . $data [$i]['trs_internal_warehouse_code'] . "'");
            if(is_array($dt) && count($dt)>0){

                foreach ($dt as $kk => $vl) {
                    $ddt[$vl['ord_trf_code']]=array("status"=>$data[$i]['status'],"ord_trf_code"=>$vl['ord_trf_code']);
                    update_ord_status($data[$i]['status'],$vl['ord_trf_code'],0);
                }
                
            }
            
            for ($k = 0; $k < count($ordIDList); $k++){
                $this->send_mail($ordIDList[$k]);
            }
        }
        foreach ($ddt as $kk => $vl) {
            update_ord_status($vl['status'],$vl['ord_trf_code'],0);
        }
    }

    function update_ORD_TRF_details($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        for ($i = 0; $i < count($data); $i++){
            $str1 = '';
            if (@$data[$i]['receive_numeric'] != ''){
                $str1 = "', receive_numeric='" . $data[$i]['receive_numeric'];
            }

            $str2 = '';
            if (@$data[$i]['receive_stock_weight'] != ''){
                $str2 = "', receive_stock_weight='" . $data[$i]['receive_stock_weight'];
            }
            
            $db->query("update ord_tariff_details set updated_by='" . $data[$i]['updated_by'] 
                        . "', update_time='". $data[$i]['update_time'] 
                        . $str1
                        . $str2
                        . "', remark='"     . $data[$i]['remark']                         
                        . "' where ord_trf_details_id ='" . $data[$i]['ord_trf_details_id'] . "'");
        }
    }

    function update_transported_internal_warehouse_data($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        
        for ($i = 0; $i < count($data); $i++){
            $db->query("update ord_tariff set trs_internal_warehouse_code='" . $data [$i]['trs_internal_warehouse_code'] 
                        . "', reality_warehouse_id_des='"       . $data [$i]['reality_warehouse_id_des'] 
                        . "', reality_warehouse_code_des='"     . $data [$i]['reality_warehouse_code_des'] 
                        . "', reality_warehouse_name_des='"     . $data [$i]['reality_warehouse_name_des'] 
                        . "', trs_internal_warehouse_by='"      . $data [$i]['trs_internal_warehouse_by'] 
                        . "', trs_internal_warehouse_time='"    . $data [$i]['trs_internal_warehouse_time'] 
                        . "', status='"                         . $data [$i]['status'] 
                        . "', updated_by='"                     . $data [$i]['updated_by'] 
                        . "', update_time='"                    . $data [$i]['update_time'] 
                        . "' where ord_trf_code ='"             . $data [$i]['ord_trf_code'] . "'");
            update_ord_status($data[$i] ['status'],'',$data[$i] ['ord_trf_id']);
            $this->send_mail($data[$i]['ord_trf_id']);
        }
        $this->send_TIWCQRCode($data[0]['trs_internal_warehouse_code'], $data[0]['reality_warehouse_id_des'], $data[0]['reality_warehouse_name_des'], $data[0]['trs_internal_warehouse_time'], $data[0]['trs_internal_warehouse_by'], $data [0]['ord_trf_code']);
    }

    function xxx() {
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);

        $warehouse_list = get_data("select * from warehouse order by warehouse_name");
        $unit_list      = get_data("select * from unit order by unit_name"); ;

        /* Set Header */
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mã loại hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Loại hàng');     
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Tên kho');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mã kho');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ID kho');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Loại phụ phí');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Loại tiền');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'ID Loại tiền');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Mã Loại tiền');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Phụ phí');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Đơn vị tính');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'ID đơn vị tính');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Mã đơn vị tính');

        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'ID kho');   
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Mã kho');   
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Tên kho'); 

        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'ID Đơn vị tính');   
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Mã Đơn vị tính');   
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Đơn vị tính');  

        $rowCount = 2;
        foreach ($warehouse_list as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['warehouse_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['warehouse_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['warehouse_name']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($unit_list as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['unit_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $element['unit_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $element['unit_name']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':Z'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'Z'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:Z100')->getAlignment()->setWrapText(true);

        // Set list box for Warehouse
        $warehouseArr = '"1, 2"';
        /*
        foreach ($warehouse_list as $item) {
            $warehouseArr .= ($item['warehouse_name'].",");
        }
        rtrim($warehouseArr, 'end');
        $warehouseArr = '"'.$warehouseArr.'"';
        */

        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($warehouseArr);
        }

        /* Auto fill index */
        for ($i = 2; $i <= 100; $i++)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . ($i-1) . ', "")');
        }

        /* Create excel file */
        $objPHPExcel->getActiveSheet()->setTitle('BanHang');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="BienBanGiaoNhan.xls"');
        $objWriter->save('php://output');
    }


    function edit_ord_tariff_details_data($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $db->query("update ord_tariff_details set stock_type_id='" . $data [0]['stock_type_id'] 
                        . "', stock_type_code='"        . $data [0]['stock_type_code'] 
                        . "', stock_type_name='"        . $data [0]['stock_type_name'] 
                        . "', stock_type_details='"     . $data [0]['stock_type_details'] 
                        . "', `numeric`='"              . $data [0]['numeric'] 
                        . "', stock_weight='"           . $data [0]['stock_weight'] 
                        . "', unit_id='"                . $data [0]['unit_id'] 
                        . "', unit_code='"              . $data [0]['unit_code'] 
                        . "', unit_name='"              . $data [0]['unit_name'] 
                        . "', price='"                  . $data [0]['price'] 
                        . "', currency_id='"            . $data [0]['currency_id'] 
                        . "', currency_code='"          . $data [0]['currency_code'] 
                        . "', currency_name='"          . $data [0]['currency_name'] 
                        . "', rates='"                  . $data [0]['rates'] 
                        . "', expense='"                . $data [0]['expense'] 
                        . "', total_money='"            . $data [0]['total_money'] 
                        . "', remark='"                 . $data [0]['remark']
                        . "', update_time='"            . $data [0]['update_time']
                        . "', updated_by='"             . $data [0]['updated_by']
                        . "' where ord_trf_details_id ='"   . $data [0]['ord_trf_details_id'] . "'");
    }
    
    function edit_ord_tariff_data($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $db->query("update ord_tariff set sender_id='" . $data [0]['sender_id'] 
                        . "', sender_name='"        . $data [0]['sender_name'] 
                        . "', sender_tel='"         . $data [0]['sender_tel'] 
                        . "', sender_email='"       . $data [0]['sender_email'] 
                        . "', sender_address='"     . $data [0]['sender_address'] 
                        . "', receiver_name='"      . $data [0]['receiver_name'] 
                        . "', receiver_tel='"       . $data [0]['receiver_tel'] 
                        . "', receiver_email='"     . $data [0]['receiver_email'] 
                        . "', receiver_address='"   . $data [0]['receiver_address'] 
                        . "', warehouse_id_dep='"   . $data [0]['warehouse_id_dep'] 
                        . "', warehouse_code_dep='" . $data [0]['warehouse_code_dep'] 
                        . "', warehouse_name_dep='" . $data [0]['warehouse_name_dep'] 
                        . "', warehouse_id_des='"   . $data [0]['warehouse_id_des'] 
                        . "', warehouse_code_des='" . $data [0]['warehouse_code_des'] 
                        . "', warehouse_name_des='" . $data [0]['warehouse_name_des'] 
                        . "', nation_id='"          . $data [0]['nation_id'] 
                        . "', nation_code='"        . $data [0]['nation_code'] 
                        . "', nation_name='"        . $data [0]['nation_name'] 
                        . "', city_id='"            . $data [0]['city_id'] 
                        . "', city_code='"          . $data [0]['city_code'] 
                        . "', city_name='"          . $data [0]['city_name'] 
                        . "', remark='"             . $data [0]['remark'] 
                        . "', create_time='"        . $data [0]['create_time'] 
                        . "', created_by='"         . $data [0]['created_by'] 
                        . "', update_time='"        . $data [0]['update_time'] 
                        . "', updated_by='"         . $data [0]['updated_by'] 
                        . "' where ord_trf_id ='"   . $data [0]['ord_trf_id'] . "'");
    }

    function update_status_ord_tariff_details_data($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        //print_r($data);die();
        $db->query("update ord_tariff set status='" . $data[0] ['status']
                . "', confirm_order_time='" . $data [0]['confirm_order_time']
                . "', confirmed_order_by='" . $data [0]['confirmed_order_by']
                . "' where ord_trf_id='" . $data[0] ['ord_trf_id'] . "'");
        update_ord_status($data[0] ['status'],'',$data[0] ['ord_trf_id']);
        $this->send_mail($data[0] ['ord_trf_id']);
    }

    function add_ord_tariff_details_data($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
$tongtien=0;
$details="";
        for ($i = 0; $i < count($data); $i++){
            $details.=$data[$i] ['stock_type_name']." x ".$data[$i] ['numeric']." nặng ".$data[$i] ['stock_weight']." kg giá vận chuyển ".$data[$i] ['total_money']."<br>";
            $db->query("insert into ord_tariff_details(
                ord_trf_code     ,
                stock_type_id    ,
                stock_type_code  ,
                stock_type_name  ,
                stock_type_details,
                `numeric`          ,
                stock_weight     ,
                unit_id          ,
                unit_code        ,
                unit_name        ,
                price            ,
                expense_type     ,
                currency_id      ,
                currency_code    ,
                currency_name    ,
                rates            ,
                expense          ,
                total_money      ,
                create_time,
                created_by,
                update_time,
                updated_by,
                remark)            
                values('" . $data[$i] ['ord_trf_code'] 
                . "', '"  . $data[$i] ['stock_type_id']
                . "', '"  . $data[$i] ['stock_type_code']
                . "', '"  . $data[$i] ['stock_type_name']
                . "', '"  . $data[$i] ['stock_type_details']
                . "', '"  . $data[$i] ['numeric']
                . "', '"  . $data[$i] ['stock_weight']
                . "', '"  . $data[$i] ['unit_id']
                . "', '"  . $data[$i] ['unit_code']
                . "', '"  . $data[$i] ['unit_name']
                . "', '"  . $data[$i] ['price']
                . "', '"  . $data[$i] ['expense_type']
                . "', '"  . $data[$i] ['currency_id']
                . "', '"  . $data[$i] ['currency_code']
                . "', '"  . $data[$i] ['currency_name']
                . "', '"  . $data[$i] ['rates']
                . "', '"  . $data[$i] ['expense']
                . "', '"  . $data[$i] ['total_money']
                . "', '"  . $data[$i] ['create_time']
                . "', '"  . $data[$i] ['created_by']
                . "', '"  . $data[$i] ['update_time']
                . "', '"  . $data[$i] ['updated_by']
                . "', '"  . $data[$i] ['remark'] . "')");
            $tongtien+=floatval(@$data[$i] ['total_money']);
        }
        if(count($data)>0){
            $checkItem = get_data("select * from ord_tariff where ord_trf_code = '".$data[0]['ord_trf_code']."'");

            if(is_array($checkItem) && count($checkItem)>0){
               $pj_id= crm_add_project($checkItem[0]['ord_trf_code'],$checkItem[0]['sender_email'],$tongtien,$details);
               //$dept=get_data("select dept.* from users,dept where dept.dept_id=users.dept_id and users.user_id=".$_SESSION['user_id']);
               $dept_id=crm_add_dept('Sales');
               $taskdata=array();
               $taskdata['name']="Duyệt Order [".$checkItem[0]['ord_trf_code']."]";
               $taskdata['description']="[".$checkItem[0]['ord_trf_code']."] Nhân viên thủ kho phải kiểm tra kho trong vòng 12 giờ.";
               $task_id=crm_add_pj_task($pj_id,$dept_id,$taskdata);
            }

        }
    }

    function add_ord_tariff_data($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        for ($i = 0; $i < count($data); $i++){
            $checkItem = get_data("select * from ord_tariff where ord_trf_code = '".$data[$i]['ord_trf_code']."'");

            if (count($checkItem) == 0){
                $db->query("insert into ord_tariff(
                                    ord_trf_code,      
                                    sender_id,         
                                    sender_name,       
                                    sender_tel,           
                                    sender_email,      
                                    sender_address,    
                                    receiver_name,      
                                    receiver_tel,       
                                    receiver_email,     
                                    receiver_address,   
                                    warehouse_id_dep,  
                                    warehouse_code_dep,
                                    warehouse_name_dep,
                                    warehouse_id_des,  
                                    warehouse_code_des,
                                    warehouse_name_des,
                                    nation_id,
                                    nation_code,
                                    nation_name,
                                    city_id,
                                    city_code,
                                    city_name,
                                    remark,
                                    order_time,
                                    ordered_by,
                                    create_time,
                                    created_by,
                                    update_time,
                                    updated_by,
                                    status)
                                    values('" . $data[$i] ['ord_trf_code'] 
                                    . "', '"  . $data[$i] ['sender_id']
                                    . "', '"  . $data[$i] ['sender_name']
                                    . "', '"  . $data[$i] ['sender_tel']
                                    . "', '"  . $data[$i] ['sender_email']
                                    . "', '"  . $data[$i] ['sender_address']
                                    . "', '"  . $data[$i] ['receiver_name']
                                    . "', '"  . $data[$i] ['receiver_tel']
                                    . "', '"  . $data[$i] ['receiver_email']
                                    . "', '"  . $data[$i] ['receiver_address']
                                    . "', '"  . $data[$i] ['warehouse_id_dep']
                                    . "', '"  . $data[$i] ['warehouse_code_dep']
                                    . "', '"  . $data[$i] ['warehouse_name_dep']
                                    . "', '"  . $data[$i] ['warehouse_id_des']
                                    . "', '"  . $data[$i] ['warehouse_code_des']
                                    . "', '"  . $data[$i] ['warehouse_name_des']
                                    . "', '"  . $data[$i] ['nation_id']
                                    . "', '"  . $data[$i] ['nation_code']
                                    . "', '"  . $data[$i] ['nation_name']
                                    . "', '"  . $data[$i] ['city_id']
                                    . "', '"  . $data[$i] ['city_code']
                                    . "', '"  . $data[$i] ['city_name']
                                    . "', '"  . $data[$i] ['remark']
                                    . "', '"  . $data[$i] ['order_time']
                                    . "', '"  . $data[$i] ['ordered_by']
                                    . "', '"  . $data[$i] ['create_time']
                                    . "', '"  . $data[$i] ['created_by']
                                    . "', '"  . $data[$i] ['update_time']
                                    . "', '"  . $data[$i] ['updated_by']
                                    . "', '"  . $data[$i] ['status'] . "')");
                $this->send_mail($data[$i]['ord_trf_code']);
            }
            else{
                $err_msg = "Thông tin tính cước đã tồn tại!";
            } 
        }
    }

    function add_tariff_codes(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        if (!empty($return_val["trf_code"]) && !empty($return_val["trf_name"])) {
            $chk = get_data("select * from trf_transport where trf_code='".$return_val['trf_code']. "' and trf_name='".$return_val['trf_name']."'");

            if (count($chk) > 0) {
                $err_msg = "Biểu cước đã tồn tại!";
            } 
            else{    
                if (!empty($return_val ["trf_name"])) {
                    $db->query("insert into trf_transport(
                                    trf_code, 
                                    trf_name, 
                                    warehouse_id_dep, 
                                    warehouse_id_des,
                                    vat,
                                    include_vat,
                                    currency_id,
                                    air_freight_rates,
                                    sea_freight_rates,
                                    road_freight_rates,
                                    iron_freight_rates)
                                    values('" . $return_val ['trf_code'] 
                                    . "', '"  . $return_val ['trf_name']
                                    . "', '"  . $return_val ['warehouse_id_dep']
                                    . "', '"  . $return_val ['warehouse_id_des']
                                    . "', '"  . $return_val ['vat']
                                    . "', '"  . $return_val ['include_vat']
                                    . "', '"  . $return_val ['currency_id']
                                    . "', '"  . $return_val ['air_freight_rates']
                                    . "', '"  . $return_val ['sea_freight_rates']
                                    . "', '"  . $return_val ['road_freight_rates']
                                    . "', '"  . $return_val ['iron_freight_rates'] . "')");
                        array_push($result['success'], 'Thêm mới thành công!');
                } 
                else{
                    $err_msg = "Nhập thông tin Kho cần thêm!";
                }
            }
        }
    }

    function edit_trf_transport() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from trf_transport where trf_code='" . $return_val['trf_code'] 
                                ."' and trf_name='"          . $return_val ['trf_name']
                                ."' and warehouse_id_dep='"  . $return_val ['warehouse_id_dep']
                                ."' and warehouse_id_des='"  . $return_val ['warehouse_id_des']
                                ."' and vat='"               . $return_val ['vat']
                                ."' and include_vat='"       . $return_val ['include_vat']
                                ."' and currency_id='"       . $return_val ['currency_id']
                                ."' and air_freight_rates='" . $return_val ['air_freight_rates']
                                ."' and sea_freight_rates='" . $return_val ['sea_freight_rates']
                                ."' and road_freight_rates='" . $return_val ['road_freight_rates']
                                ."' and iron_freight_rates='" . $return_val ['iron_freight_rates'] . "'");

        if (count($chk) > 0) {
            $err_msg = "Biểu cước đã tồn tại!";
        } 
        else if (!empty($return_val ["trf_code"]) && !empty($return_val ["trf_name"])) {
            $db->query("update trf_transport set trf_code='" . $return_val ['trf_code'] 
                        . "', trf_name='"           . $return_val ['trf_name'] 
                        . "', warehouse_id_dep='"   . $return_val ['warehouse_id_dep'] 
                        . "', warehouse_id_des='"   . $return_val ['warehouse_id_des'] 
                        . "', vat='"                . $return_val ['vat'] 
                        . "', include_vat='"        . $return_val ['include_vat'] 
                        . "', currency_id='"        . $return_val ['currency_id'] 
                        . "', air_freight_rates='"  . $return_val ['air_freight_rates'] 
                        . "', sea_freight_rates='"  . $return_val ['sea_freight_rates'] 
                        . "', road_freight_rates='" . $return_val ['road_freight_rates'] 
                        . "', iron_freight_rates='" . $return_val ['iron_freight_rates'] 
                        . "' where trf_id ='"       . $return_val['trf_id'] . "'");
        }
        else{
            $err_msg = "Vui lòng nhập thông tin Biểu cước!";
        }
    }
}