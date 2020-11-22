<?php
require_once ("bms/classes/modules.php");
require_once ("bms/phpqrcode/qrlib.php");
require_once ("bms/library/Qrmaker.php");
require_once ("bms/library/Semail.php");

class sell extends modules {
    public function __construct() {
        
    }

    function child_run() {
        global $action, $sessions, $db, $file_tmp, $err_msg, $return_val, $transfer, $head;

        if ($action->eda_code == md5('load_order_info')){
            include("bms/templates/sell/tariff_info.htm");
            die();
            return;
        }

        if ($sessions->get_session("login") != "logined" && $action->eda_code != md5("login") && $action->eda_code != md5("in") && $action->eda_code != md5("reg") && $action->eda_code != md5("forgot") && $transfer == false) {
            include("bms/templates/login.htm");
            $transfer=true;
        } else {
            switch ($action->eda_code) {
                // Tính cước Order
                case md5('tariff'):
                    $action->title = "Tính cước theo Order";
                    $action->eda_decode = "tariff";
                    $file_tmp = "sell/tariff.htm";
                    break;

                case md5('tariff_confirm'):
                    $action->title = "Duyệt tính cước order";
                    $action->eda_decode = "tariff_confirm";
                    $file_tmp = "sell/tariff_confirm.htm";
                    break;
                    
                case md5("stock_management"):
                    $action->title = "Quản lý tồn kho";
                    $action->eda_decode = "stock_management";
                    $file_tmp = "sell/stock_management.htm";  
                    break;

                case md5("transport_internal_warehouse"):
                    $action->title = "Chuyển kho nội bộ";
                    $action->eda_decode = "transport_internal_warehouse";
                    $file_tmp = "sell/transport_internal_warehouse.htm";  
                    break;

                case md5('check_import_stock'):
                    $action->title = "Kiểm tra nhâp hàng";
                    $action->eda_decode = "check_import_stock";
                    $file_tmp = "sell/check_import_stock.htm";  
                    break;

                case md5('check_import_stock_HT'):
                    include("bms/templates/sell/check_import_stock_HT.htm");
                    die();
                    break;

                 // Báo cáo nhập kho
                case md5('import_report'):
                    $action->title = "Báo cáo nhập kho";
                    $action->eda_decode = "import_report";
                    $file_tmp = "sell/import_report.htm";
                    break;

                // Nhận hàng - Thanh toán
                case md5('checkout'):
                    $action->title = "Nhận hàng - Thanh toán";
                    $action->eda_decode = "checkout";
                    $file_tmp = "sell/checkout.htm";
                    break;
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

    public function send_mail($order_code){                   
        $url            = ROOT_URL."?eda_act=".md5('sell')."&eda_code=".md5('load_order_info')."&order_code=".$order_code;
        $QRCodeURL      = $this->getQRCode($url);
        $data           = get_data("select * from ord_tariff where ord_trf_code='" . $order_code . "'");
        $sender_name    = $data[0]['sender_name'];
        $receiver_name  = $data[0]['receiver_name'];
        $sender_email   = $data[0]['sender_email'];
        $receiver_email = $data[0]['receiver_email'];
        $create_time    = $data[0]['create_time'];

        $sendMailContent = '<body>
            <div style="padding: 40px;">
            <div style="background-color: green; border-top-left-radius:4px; border-top-right-radius:4px; height: 45px;">
                <label style="margin-top: 7.5px; margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff; float: left">THÔNG TIN ĐĂNG KÝ VẬN CHUYỂN HÀNG HÓA</label>
            </div>
            <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
            <div style="padding:10px 20px 10px 20px; font-family:Tahoma,serif;color:#030303;line-height:26px">
            <b>Kính gửi: Quý khách hàng ' .  $sender_name . '</b>
            <br>
            <span>Thông tin đăng ký đơn hàng của quý khách như sau: </span>
            </div>
            <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
                <img style="float: right; margin-left:25px; margin-right: 10px; height: 75px; width: 75px; margin-top: auto; margin-bottom: auto;" src="' . $QRCodeURL . '"></img>

                <ul style="list-style:disc; float: left">
                    <li>Mã order: <b>' . $order_code . '</b></li>
                    <li>Thời gian đăng ký: <b>' . $create_time . '</b></li>                            
                </ul>


            </div>
            <div style="padding:10px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
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

        $receivedMailContent ='<body>
            <div style="padding: 40px;">
            <div style="background-color: green; border-top-left-radius:4px; border-top-right-radius:4px; height: 45px;">
                <label style="margin-top: 7.5px; margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff; float: left">THÔNG TIN ĐĂNG KÝ VẬN CHUYỂN HÀNG HÓA</label>
            </div>
            <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
            <div style="padding:10px 20px 10px 20px; font-family:Tahoma,serif;color:#030303;line-height:26px">
            <b>Kính gửi: Quý khách hàng ' .  $receiver_name . '</b>
            <br>
            <span>Thông tin đăng ký đơn hàng của quý khách như sau: </span>
            </div>
            <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
                <img style="float: right; margin-left:25px; margin-right: 10px; height: 75px; width: 75px; margin-top: auto; margin-bottom: auto;" src="' . $QRCodeURL . '"></img>

                <ul style="list-style:disc; float: left">
                    <li>Mã order: <b>' . $order_code . '</b></li>
                    <li>Thời gian đăng ký: <b>' . $create_time . '</b></li>                            
                </ul>


            </div>
            <div style="padding:10px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
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
        $temp->send('15520756@gm.uit.edu.vn', '[EXPRESS TRANSPORT CENTER] Thông tin đăng ký vận chuyển đơn hàng', '[EXPRESS TRANSPORT CENTER] Thông tin đăng ký vận chuyển đơn hàng', $sendMailContent, '');       

        $temp  = new Semail();
        $temp->send($receiver_email, '[EXPRESS TRANSPORT CENTER] Thông tin đăng ký vận chuyển đơn hàng', '[EXPRESS TRANSPORT CENTER] Thông tin đăng ký vận chuyển đơn hàng', $receivedMailContent , '');           
    }
}
?>