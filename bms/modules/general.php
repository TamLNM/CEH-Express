<?php
require_once "bms/classes/modules.php";

class general extends modules {
    function general() {
        
    }

    function child_run() {
        global $action, $sessions, $db, $file_tmp, $err_msg, $return_val, $transfer, $head;
        if ($sessions->get_session("login") != "logined" && $action->eda_code != md5("login") && $action->eda_code != md5("in") && $action->eda_code != md5("reg") && $action->eda_code != md5("forgot") && $transfer == false) {
            include("bms/templates/login.htm");
            $transfer = true;
        } else {
            switch ($action->eda_code) {
                case md5("changepass_sm") :
                    $this->changepass();
                    insertlog("Đổi mật khẩu");
                    $action->eda_decode = "changepass";
                    $file_tmp = "general/changepass.htm";
                    break;
                case md5("changepass") :
                    $file_tmp = "general/changepass.htm";
                    $action->eda_decode = "changepass";
                    break;
                case md5("cats") :
                    $action->title = "Quản lý chủng loại hàng hoá";
                    $file_tmp = "general/cats.htm";
                    $action->eda_decode = "cats";
                    break;
                case md5("cats_sm") :
                    $this->cats_sm();
                    $action->eda_decode = "cats";
                    if (empty($err_msg)) {
                        insertlog("Thêm chủng loại sản phẩm");
                        page_transfer("Thêm chủng loại thành công", "?eda_act=" . md5("general") . "&eda_code=" . md5("cats"));
                        $transfer = true;
                    }
                    $file_tmp = "general/cats.htm";
                    break;

                // Quản lý khách hàng:
                case md5('cus_manager') :
                    $action->title = "Quản lý Khách hàng";
                    $action->eda_decode = "cus_manager";
                    $file_tmp = "general/cus_manager.htm";
                    break;          

                // Quản lý loại khách hàng:
                case md5('cus_type_manager') :
                    $action->title = "Quản lý loại khách hàng";
                    $action->eda_decode = "cus_type_manager";
                    $file_tmp = "general/cus_type_manager.htm";
                    break;      

                // Quản lý quốc gia
                case md5('nation'):
                    $action->title = "Quản lý danh mục Quốc gia";
                    $action->eda_decode = "nation";
                    $file_tmp = "general/nation.htm";
                    break;
            
                // Quản lý Tỉnh/ thành phố
                case md5('city'):
                    $action->title = "Quản lý danh mục Thành phố";
                    $action->eda_decode = "city";
                    $file_tmp = "general/city.htm";
                    break;
            
                // Quản lý Quận/ Huyện
                case md5('district'):
                    $action->title = "Quản lý danh mục Quận/ Huyện";
                    $action->eda_decode = "district";
                    $file_tmp = "general/district.htm";
                    break;
            
                // Quản lý loại kho
                case md5('warehouse_type'):
                    $action->title = "Quản lý loại kho";
                    $action->eda_decode = "warehouse_type";
                    $file_tmp = "general/warehouse_type.htm";
                    break;

                // Quản lý kho
                case md5('warehouse'):
                    $action->title = "Quản lý Kho";
                    $action->eda_decode = "warehouse";
                    $file_tmp = "general/warehouse.htm";
                    break;

                // Quản lý Hàng hóa
                case md5('stock'):
                    $action->title = "Quản lý Hàng hóa";
                    $action->eda_decode = "stock";
                    $file_tmp = "general/stock.htm";
                    break;

                // Công ty vận chuyển
                case md5('transport_company'):
                    $action->title = "Danh mục Công ty vận chuyển";
                    $action->eda_decode = "transport_company";
                    $file_tmp = "general/transport_company.htm";
                    break;

                // Quản lý Loại tiền:
                case md5('currency'):
                    $action->title = "Quản lý thông tin loại tiền";
                    $action->eda_decode = "currency";
                    $file_tmp = "general/currency.htm";
                    break;

                // Quản lý Đơn vị tính:
                case md5('unit'):
                    $action->title = "Quản lý Đơn vị tính";
                    $action->eda_decode = "unit";
                    $file_tmp = "general/unit.htm";
                    break;        

                // Cấu hình email
                case md5('email_management'):
                    $action->title = "Cấu hình Email";
                    $action->eda_decode = "email_management";
                    $file_tmp = "general/email_management.htm";
                    break;

                case md5('add_edit_email_management'):
                    $action = $_POST['action']  ? $_POST['action']  : array();
                    $data   = $_POST['data']    ? $_POST['data']    : array();

                    if ($action == 'add'){
                        $this->data['result'] = $this->add_email_setting($data);
                        echo json_encode($this->data);
                        exit;
                    }

                    if ($action = 'edit'){
                        $this->data['result'] = $this->edit_email_setting($data);
                        echo json_encode($this->data);
                        exit;
                    }
                    break;


                // Add, edit, delete data
                case md5('add_and_edit_data'):
                    $action = $_POST['action'] ? $_POST['action'] : array();
                    $saveData = $_POST['data'] ? $_POST['data'] : array();
                    $tableName = $_POST['table_name'] ? $_POST['table_name'] : array();

                    if ($action == 'add'){
                        $this->data['result'] = $this->insertData($saveData, $tableName);
                        echo json_encode($this->data);
                        exit;
                    }

                    if ($action == 'edit'){
                        $this->data['result'] = $this->updateData($saveData, $tableName);
                        echo json_encode($this->data);
                        exit;
                    }
                    break;
                case md5('delete_data'):
                    $queryList = $_POST['data'] ? $_POST['data'] : array();

                    $result['error'] = array();
                    $result['success'] = array();

                    for ($i = 0; $i < count($queryList); $i++){
                        $db->query($queryList[$i]);
                        array_push($result['success'], 'Xóa dữ liệu thành công!');
                    }
                    $this->data['result'] = $result;
                    echo json_encode($this->data);
                    exit;  
                    break;

                //Quản lý nhân viên                 
                case md5('emp_manager') :
                    $action->title = "Quản lý nhân viên";
                    $action->eda_decode = "emp_manager";
                    $file_tmp = "general/emp_manager.htm";
                    break;
                case md5('add_emp') :
                    $action->title = "Thêm nhân viên mới";
                    $action->eda_decode = "emp_manager";
                    $file_tmp = "general/add_emp.htm";
                    break;
                case md5('add_emp_sm') :
                    $this->add_emp_sm();
                    $action->eda_decode = "emp_manager";
                    if (empty($err_msg)) {
                        insertlog("Thêm nhân viên mới");
                        page_transfer("Thêm nhân viên mới thành công", "?eda_act=" . md5("general") . "&eda_code=" . md5("emp_manager"));
                        $transfer = true;
                    }
                    $file_tmp = "general/add_emp.htm";
                    break;
                case md5('del_emp') :
                    $chk = get_data("select user_id user_num from invoices where user_id ='" . $action->eda_id . "' union select user_id user_num from budget_invoices where user_id ='" . $action->eda_id . "'");
                    if (count($chk) > 0) {
                        page_transfer("Nhân viên đã tồn dữ liệu bán hàng. Bạn không thể thực hiện lệnh xoá.", "?eda_act=" . md5("general") . "&eda_code=" . md5("emp_manager"));
                        $transfer = true;
                    } else {
                        $chk = get_data("select user_id from stocks where user_id ='" . $action->eda_id . "'");
                        if (count($chk) > 0) {
                            page_transfer("Nhân viên đã tồn dữ liệu kho hàng. Bạn không thể thực hiện lệnh xoá.", "?eda_act=" . md5("general") . "&eda_code=" . md5("emp_manager"));
                            $transfer = true;
                        } else {
                            $db->query("delete from users where user_id='" . $action->eda_id . "'");
                            if (empty($err_msg)) {
                                insertlog("Xóa nhân viên");
                                page_transfer("Thực hiện xoá nhân viên thành công", "?eda_act=" . md5("general") . "&eda_code=" . md5("emp_manager"));
                                $transfer = true;
                            }
                        }
                    }
                    $action->eda_decode = "emp_manager";
                    $file_tmp = "general/emp_manager.htm";
                    break;
                case md5('edit_emp') :
                    $action->title = "Sửa thông tin nhân viên";
                    $action->eda_decode = "emp_manager";
                    $emp = get_data("select * from users where user_id='" . $action->eda_id . "'");
                    if (count($emp) > 0) {
                        $return_val = $emp [0];
                        $file_tmp = "general/edit_emp.htm";
                    } else {
                        page_transfer('Không tìm thấy thông tin nhân viên', "?eda_act=" . md5("general") . "&eda_code=" . md5("emp_manager"));
                        $transfer = true;
                    }
                    $file_tmp = "general/edit_emp.htm";
                    break;
                case md5('edit_emp_sm') :
                    $this->edit_emp_sm();
                    $action->eda_decode = "emp_manager";
                    if (empty($err_msg)) {
                        insertlog("Thay đổi thông tin nhân viên");
                        page_transfer("Thay đổi thông tin nhân viên thành công", "?eda_act=" . md5("general") . "&eda_code=" . md5("emp_manager"));
                        $transfer = true;
                    }
                    $file_tmp = "general/edit_emp.htm";
                    break;
                case md5("view_emp") :
                    $action->title = "Xem thông tin nhân viên";
                    $action->eda_decode = "emp_manager";
                    $file_tmp = "general/view_emp.htm";
                    break;

                //Phân quyền quản trị                   
                case md5('permission') :
                    $action->eda_decode = "permission";
                    if (isset($return_val['permission_sm'])) {
                        $this->permission_sm();
                        if (empty($err_msg)) {
                            insertlog("Thực hiện phân quyền quản trị");
                            page_transfer("Phân quyền quản trị thành công", "?eda_act=" . md5("general") . "&eda_code=" . md5("permission") . "&group_id=" . $return_val['group_id'] . "&user_id=" . $return_val['user_id']);
                            $transfer = true;
                        }
                    }
                    $action->title = "Phân quyền quản trị";
                    $file_tmp = "general/permission.htm";
                    break;

                default:
                    break;
            }
        }
    }

    function add_email_setting($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        for ($i = 0; $i < count($data); $i++){
            $db->query("insert into email_management(
                warehouse_id     ,
                warehouse_code   ,
                warehouse_name   ,
                email            ,
                password         ,
                SMTPSecure       ,
                host             ,
                port)            
                values('" . $data[$i] ['warehouse_id'] 
                . "', '"  . $data[$i] ['warehouse_code']
                . "', '"  . $data[$i] ['warehouse_name']
                . "', '"  . $data[$i] ['email']
                . "', '"  . $data[$i] ['password']
                . "', '"  . $data[$i] ['SMTPSecure']
                . "', '"  . $data[$i] ['host']
                . "', '"  . $data[$i] ['port'] . "')");
        }
    }

    function edit_email_setting($data){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        for ($i = 0; $i < count($data); $i++){
            $db->query("update email_management set email='". $data [$i]['email'] 
                        . "', password='"       . $data [$i]['password'] 
                        . "', SMTPSecure='"     . $data [$i]['SMTPSecure']
                        . "', host='"           . $data [$i]['host']
                        . "', port='"           . $data [$i]['port']  
                        . "' where warehouse_id ='". $data [$i]['warehouse_id'] . "'");
        }
    }
    
    function insertData($data, $tableName){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        for ($i = 0; $i < count($data); $i++){
            $chk = get_data("select * from ".$tableName." where ".$data[$i]['checkQuery']);

            if (count($chk) > 0) {
                $err_msg = "Error!";
            } 
            else{
                $db->query($data[$i]['insertQuery']);
            }
        }
    }

    function updateData($data, $tableName){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        for ($i = 0; $i < count($data); $i++){
            $db->query($data[$i]['editQuery']);
        }
    }

    // Loại Khách Hàng
    function add_cus_type() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select cus_type_name from customer_type where cus_type_name='" . $return_val ['cus_type_name'] . "'");
        if (count($chk) > 0) {
            $err_msg = "Loại khách hàng đã tồn tại!";
        } 
        else if (!empty($return_val ["cus_type_name"])) {
            $db->query("insert into customer_type(cus_type_name) values('" . $return_val ['cus_type_name'] . "')");
        } 
        else{
            $err_msg = "Nhập loại khách hàng cần thêm!";
        }
    }

    function edit_cus_type() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select * from customer_type where cus_type_name='" . $return_val ['cus_type_name'] . "'");

        if (count($chk) > 0) {
            $err_msg = "Loại khách hàng đã tồn tại!";
        } 
        else if (!empty($return_val ["cus_type_name"])) {
            $db->query("update customer_type set cus_type_name='" . $return_val ['cus_type_name'] . "' where cus_type_id='" . $action->eda_id . "'");
        }
        else{
            $err_msg = "Vui lòng nhập tên loại khách hàng!";
        }
    }

    // Quốc Gia
    function add_nation(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select nation_name from nation where nation_name='" . $return_val['nation_name']. "'");
        if (count($chk) > 0) {
            $err_msg = "Quốc gia đã tồn tại!";
        } 
        else if (!empty($return_val ["nation_name"])) {
            $db->query("insert into nation(nation_name) values('" . $return_val ['nation_name'] . "')");
        } 
        else{
            $err_msg = "Nhập tên Quốc gia cần thêm!";
        }
    }

    function edit_nation() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from nation where nation_name='" . $return_val ['nation_name'] . "'");

        if (count($chk) > 0) {
            $err_msg = "Quốc gia đã tồn tại!";
        } 
        else if (!empty($return_val ["nation_name"])) {
            $db->query("update nation set nation_name='" . $return_val ['nation_name'] . "' where nation_id='" . $action->eda_id . "'");
        }
        else{
            $err_msg = "Vui lòng nhập tên Quốc gia!";
        }
    }   

    // Loại kho
    function add_warehouse_type(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select warehouse_type_name from warehouse_type where warehouse_type_name='".$return_val['warehouse_type_name']. "'");
        if (count($chk) > 0) {
            $err_msg = "Loại kho đã tồn tại!";
        } 
        else if (!empty($return_val ["warehouse_type_name"])) {
            $db->query("insert into warehouse_type(warehouse_type_name) values('" . $return_val ['warehouse_type_name'] . "')");
        } 
        else{
            $err_msg = "Nhập tên Loại kho cần thêm!";
        }
    }
    function edit_warehouse_type() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from warehouse_type where warehouse_type_name='" . $return_val ['warehouse_type_name'] . "'");

        if (count($chk) > 0) {
            $err_msg = "Loại kho đã tồn tại!";
        } 
        else if (!empty($return_val ["warehouse_type_name"])) {
            $db->query("update warehouse_type set warehouse_type_name='" . $return_val ['warehouse_type_name'] . "' where warehouse_type_id='" . $action->eda_id . "'");
        }
        else{
            $err_msg = "Vui lòng nhập Loại kho!";
        }
    }

    // Danh mục Kho
    function add_warehouse(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select warehouse_name from warehouse where warehouse_name='".$return_val['warehouse_name']. "'");

        if (count($chk) > 0) {
            $err_msg = "Kho đã tồn tại!";
        } 
        else if (!empty($return_val ["warehouse_name"])) {
            $db->query("insert into warehouse(
                            warehouse_type_id, 
                            warehouse_code, 
                            warehouse_name, 
                            address,
                            nation_id,
                            city_id,
                            district_id) 
                            values('" . $return_val ['warehouse_type_id'] 
                            . "', '"  . $return_val ['warehouse_code']
                            . "', '"  . $return_val ['warehouse_name']
                            . "', '"  . $return_val ['address']
                            . "', '"  . $return_val ['nation_id']
                            . "', '"  . $return_val ['city_id']
                            . "', '"  . $return_val ['district_id'] . "')");
        } 
        else{
            $err_msg = "Nhập thông tin Kho cần thêm!";
        }
    }
    function edit_warehouse() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from warehouse where warehouse_code='" . $return_val['warehouse_code'] . "
        ' and warehouse_name='" . $return_val ['warehouse_name'] . "'");

        if (count($chk) > 0) {
            $err_msg = "Kho đã tồn tại!";
        } 
        else if (!empty($return_val ["warehouse_code"]) && !empty($return_val ["warehouse_name"])) {
            $db->query("update warehouse set warehouse_type_id='" . $return_val ['warehouse_type_id'] 
                        . "', warehouse_code='"     . $return_val ['warehouse_code'] 
                        . "', warehouse_name='"     . $return_val ['warehouse_name'] 
                        . "', address='"            . $return_val ['address'] 
                        . "', nation_id='"          . $return_val ['nation_id'] 
                        . "', city_id='"            . $return_val ['city_id'] 
                        ."', district_id='"         . $return_val ['district_id'] 
                        ."' where warehouse_id='"   . $return_val['warehouse_id'] . "'");
        }
        else{
            $err_msg = "Vui lòng nhập thông tin Kho!";
        }
    }


    // Loại hàng
    function add_stock_type(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select stock_type_name from stock_type where stock_type_name='".$return_val['stock_type_name']. "'");
        if (count($chk) > 0) {
            $err_msg = "Loại hàng đã tồn tại!";
        } 
        else if (!empty($return_val ["stock_type_name"])) {
            $db->query("insert into stock_type(stock_type_name) values('" . $return_val ['stock_type_name'] . "')");
        } 
        else{
            $err_msg = "Nhập tên Loại hàng cần thêm!";
        }
    }
    function edit_stock_type(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from stock_type where stock_type_name='" . $return_val ['stock_type_name'] . "'");

        if (count($chk) > 0) {
            $err_msg = "Loại hàng đã tồn tại!";
        } 
        else if (!empty($return_val ["stock_type_name"])) {
            $db->query("update stock_type set stock_type_name='" . $return_val ['stock_type_name'] . "' where stock_type_id='" . $action->eda_id . "'");
        }
        else{
            $err_msg = "Vui lòng nhập Loại hàng!";
        }
    }

    // Công ty vận chuyển 
    function add_transpot_company(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select * from transpot_company where trscomp_code='".$return_val['trscomp_code']. "' and trscomp_name='".$return_val['trscomp_name']."'");
        if (count($chk) > 0) {
            $err_msg = "Thông tin công ty đã tồn tại!";
        } 
        else if (!empty($return_val ["trscomp_code"]) && !empty($return_val ["trscomp_name"])) {
            $db->query("insert into transpot_company(
                                            trscomp_code,
                                            trscomp_name,
                                            address,
                                            tel,
                                            email,
                                            website,
                                            tax_no,
                                            reg_no,
                                            bank_acc,
                                            bank_name,
                                            debt,
                                            remark
                                        ) values('" . $return_val ['trscomp_code']
                                        ."', '" . $return_val ['trscomp_name'] 
                                        ."', '" . $return_val ['address'] 
                                        ."', '" . $return_val ['tel'] 
                                        ."', '" . $return_val ['email'] 
                                        ."', '" . $return_val ['website'] 
                                        ."', '" . $return_val ['tax_no'] 
                                        ."', '" . $return_val ['reg_no'] 
                                        ."', '" . $return_val ['bank_acc'] 
                                        ."', '" . $return_val ['bank_name'] 
                                        ."', '" . $return_val ['debt'] 
                                        ."', '" . $return_val ['remark'] ."')");
        } 
        else{
            $err_msg = "Nhập Thông tin công ty cần thêm!";
        }
    }
    function edit_transpot_company(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from transpot_company where trscomp_code='" . $return_val ['trscomp_code'] 
                            . "' and trscomp_name='" . $return_val ['trscomp_name'] 
                            . "' and address='" . $return_val ['address'] 
                            . "' and tel='" . $return_val ['tel'] 
                            . "' and email='" . $return_val ['email'] 
                            . "' and website='" . $return_val ['website'] 
                            . "' and tax_no='" . $return_val ['tax_no'] 
                            . "' and reg_no='" . $return_val ['reg_no'] 
                            . "' and bank_acc='" . $return_val ['bank_acc'] 
                            . "' and bank_name='" . $return_val ['bank_name'] 
                            . "' and debt='" . $return_val ['debt'] 
                            . "' and debt='" . $return_val ['debt'] 
                            . "' and remark='" . $return_val ['remark'] 
                            . "'");

        if (count($chk) > 0) {
            $err_msg = "Loại hàng đã tồn tại!";
        } 
        else if (!empty($return_val ["trscomp_code"]) && !empty($return_val ["trscomp_name"])) {
            $db->query("update transpot_company set trscomp_code='" . $return_val ['trscomp_code'] 
                                . "', trscomp_name = '" . $return_val ['trscomp_name'] 
                                . "', address = '" . $return_val ['address'] 
                                . "', tel = '" . $return_val ['tel'] 
                                . "', email = '" . $return_val ['email'] 
                                . "', website = '" . $return_val ['website'] 
                                . "', tax_no = '" . $return_val ['tax_no'] 
                                . "', reg_no = '" . $return_val ['reg_no'] 
                                . "', bank_acc = '" . $return_val ['bank_acc'] 
                                . "', bank_name = '" . $return_val ['bank_name'] 
                                . "', debt = '" . $return_val ['debt'] 
                                . "', remark = '" . $return_val ['remark'] 
                                . "' where trscomp_id='" . $return_val ['trscomp_id'] . "'");
        }
        else{
            $err_msg = "Vui lòng nhập thông tin Công ty vận chuyển!";
        }
    }

    // Hàng hóa
    function add_stock(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select * from stock where stock_name='".$return_val['stock_name']. "' and stock_code='".$return_val['stock_code']."' and stock_type_id='".$return_val['stock_type_id']."'");
        if (count($chk) > 0) {
            $err_msg = "Hàng hóa đã tồn tại!";
        } 
        else if (!empty($return_val ["stock_name"])) {
            $db->query("insert into stock(stock_code,
                                                stock_name,
                                                stock_type_id,
                                                warehouse_id, 
                                                price
                                            ) values('" . $return_val ['stock_code'] 
                                            ."', '". $return_val ['stock_name'] 
                                            ."', '". $return_val ['stock_type_id'] 
                                            ."', '". $return_val ['warehouse_id'] 
                                            ."', '". $return_val ['price'] . "')");
        } 
        else{
            $err_msg = "Vui lòng nhập đầy đủ thông tin hhàng cần thêm!";
        }
    }
    function edit_stock() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from stock where stock_code='" . $return_val['stock_code'] . "
        ' and stock_name='" . $return_val ['stock_name'] . "' and stock_type_id='" . $return_val ['stock_type_id']."'");

        if (count($chk) > 0) {
            $err_msg = "Kho đã tồn tại!";
        } 
        else if (!empty($return_val ["stock_code"]) && !empty($return_val ["stock_name"])) {
            $db->query("update stock set 
                            stock_code='" . $return_val ['stock_code'] 
                            . "', stock_name='" . $return_val ['stock_name'] 
                            . "', stock_type_id='" . $return_val ['stock_type_id'] 
                            ."', warehouse_id='" . $return_val ['warehouse_id'] 
                            ."', price='" . $return_val ['price'] 
                            ."' where stock_id='" . $return_val['stock_id'] . "'");
        }
        else{
            $err_msg = "Vui lòng nhập thông tin Hàng hóa!";
        }
    }

    // Quản lý Tỉnh/ Thành phố
    function add_city() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from city where city_name='" . $return_val ['city_name'] . "'");

        if (count($chk) > 0) {
            $err_msg = "Tỉnh/ Thành phố đã tồn tại!";
        } 
        else if (!empty($return_val ["city_name"]) && !empty($return_val ["nation_id"])) {
            $db->query("insert into city(nation_id, city_name) values (".$return_val ['nation_id'].", '".$return_val ['city_name']."')");
        }
        else{
            $err_msg = "Vui lòng nhập đầy đủ thông tin Tỉnh/ Thành phố!";
        }
    }
    function edit_city(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from city where city_name='" . $return_val ['city_name'] . "' and nation_id='" . $return_val ['nation_id'] . "'");

        if (count($chk) > 0) {
            $err_msg = "Tỉnh/ Thành phố đã tồn tại!";
        } 
        else if (!empty($return_val ["city_name"]) && !empty($return_val ["nation_id"])) {
            $db->query("update city set city_name='".$return_val ['city_name']."', nation_id = '". $return_val['nation_id']."' where city_id='".$return_val ["city_id"]."'");
        }
        else{
            $err_msg = "Vui lòng nhập thông tin Tỉnh/ Thành phố!";
        }
    }

    // Quản lý Quận/ Huyện
    function add_district(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        if (!isset($return_val['nation_id']) || !isset($return_val['city_id'])){
            $err_msg = "Vui lòng nhập đầy đủ thông tin Quận/ Huyện mới!";
        }
        else{
            $chk = get_data("select * from district where district_name='".$return_val['district_name']."' and nation_id='".$return_val['nation_id']."' and city_id='".$return_val['city_id']."'");

            if (count($chk) > 0) {
                $err_msg = "Quận/ Huyện đã tồn tại!";
            } 
            else if (!empty($return_val ["district_name"]) && !empty($return_val ["nation_id"]) && !empty($return_val ["city_id"])) 
            {
                $db->query("insert into district(district_name,nation_id, city_id) values ('".$return_val['district_name']."', '".$return_val['nation_id']."', '".$return_val['city_id']."')");
            }
            else{
                $err_msg = "Vui lòng nhập đầy đủ thông tin Tỉnh/ Thành phố!";
            }
        }
    }

    function edit_district(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        $chk = get_data("select * from district where district_name='".$return_val ['district_name']."' and nation_id='".$return_val ['nation_id']."' and city_id='".$return_val ['city_id']."'");

        if (count($chk) > 0) {
            $err_msg = "Quận/ Huyện đã tồn tại. Vui lòng thử lại!";
        } 
        else if (!empty($return_val ["district_name"])) {
            $db->query("update district set district_name='" . $return_val ['district_name'] . "' where district_id='" . $return_val ['district_id'] . "'");
        }
        else{
            $err_msg = "Vui lòng nhập tên Quyện/ Huyện cần chỉnh sửa!";
        }
    }

    /**/
    function cats_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select cat_id from categories where cat_name='" . $return_val ['cat_name'] . "'");
        if (count($chk) > 0) {
            $err_msg = "Tên chủng loại đã tồn tại trên hệ thống";
        } else if (!empty($return_val ["cat_name"])) {
            $db->query("insert into categories(cat_name) values('" . $return_val ['cat_name'] . "')");
        } else
            $err_msg = "Hãy nhập tên chủng loại";
    }

    function edit_cat_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select cat_id from categories where cat_name='" . $return_val ['cat_name'] . "'");
        if (count($chk) > 0) {
            $err_msg = "Tên chủng loại đã tồn tại trên hệ thống";
        } else if (!empty($return_val ["cat_name"])) {
            $db->query("update categories set cat_name='" . $return_val ['cat_name'] . "' where cat_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập tên chủng loại";
    }

    //Nhóm
    function group_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["group_name"])) {
            $db->query("insert into groups(group_name) values('" . $return_val ['group_name'] . "')");
        } else
            $err_msg = "Hãy nhập tên nhóm";
    }

    function edit_group_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["group_name"])) {
            $db->query("update groups set group_name='" . $return_val ['group_name'] . "' where group_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập tên nhóm làm việc";
    }

    //Phòng ban
    function dept_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["dept_name"])) {
            $db->query("insert into dept(dept_name) values('" . $return_val ['dept_name'] . "')");
        } else
            $err_msg = "Hãy nhập tên Phòng/Ban";
    }

    function edit_dept_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["dept_name"])) {
            $db->query("update dept set dept_name='" . $return_val ['dept_name'] . "' where dept_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập tên Phòng/Ban";
    }

    //Sản phẩm
    function add_mat_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $return_val ["mat_name"]=str_replace("'", '&apos;', $return_val ["mat_name"]);
        $return_val ["mat_name"]=str_replace("\"", '&quot;', $return_val ["mat_name"]);

        // if(@$return_val['qc']=="" && @$return_val['xuatxu']==""){
        //     $err_msg = "Số IMEI không được bỏ trống";
        //     goto end_func;
        // }
$is_tyre=0;
$is_coveralls=0;
$is_intestine=0;
        switch (intval(@$return_val['mat_type'])) {
            case 0:
                $is_tyre=1;
                break;
            case 1:
                $is_coveralls=1;
                break;
            case 2:
                $is_intestine=1;
                break;
        }


        if (!empty($return_val ["mat_name"]) && !empty($return_val ["cat_id"])) {
            $return_val ["mat_name"]=str_replace("\"", '&apos;', $return_val ["mat_name"]);
            $return_val ["mat_name"]=str_replace("\"", '&quot;', $return_val ["mat_name"]);
            
            $chk = get_data("select mat_model from materials where mat_name='" . $return_val ['mat_name'] . "' and cat_id='" . $return_val ['cat_id'] . "'");
            if (count($chk) > 0) {
                $err_msg = "Tên sản phẩm đã tồn tại trong chủng loại sản phẩm, vui lòng nhập tên sản phẩm khác";
            } else {
                $chk = get_data("select mat_model from materials where mat_model='" . $return_val ['mat_model'] . "'");
                if (!empty($return_val ['mat_model']) && count($chk) > 0) {
                    $err_msg = "Mã sản phẩm đã tồn tại, vui lòng nhập mã sản phẩm khác";
                } else {
                    $chk = get_data("select mat_model from materials where barcode='" . $return_val ['barcode'] . "'");
                    if (!empty($return_val ['barcode']) && count($chk) > 0) {
                        $err_msg = "Mã vạch của sản phẩm đã tồn tại, vui lòng nhập mã vạch khác";
                    } else {
                        $csql="";
                        if($return_val['qc']!="" || $return_val['gai']!="")
                            $csql="and qc='" . $return_val ['qc'] . "' and gai='" . $return_val ['gai'] . "'";
                    $chk = get_data("select mat_model from materials where 2=1 $csql ");
                    if (!empty($return_val ['qc']) && count($chk) > 0) {
                        $err_msg = "Sản phẩm đã tồn tại, vui lòng nhập quy cách và gai khác";
                    } else {

                        $return_val ['msu_id'] = array_unique($return_val ['msu_id']);
                        if (count($return_val ['msu_id']) > 0 && !empty($return_val ['msu_id'][0])) {
                            $db->query("insert into materials(vat,mat_name, mat_model, mat_desc, cat_id, mat_waranty,barcode,qc,xuatxu,pr,gai,tkvt,edit_tkvt,tkgv,tkdt,tktl,tkdd,tkcl,tkck,alert_qty,is_tyre,is_coveralls,is_intestine) 
				values('" . numR($return_val ['vat']) . "','" . $return_val ['mat_name'] . "', '" . $return_val ['mat_model'] . "', '" . $return_val ['mat_desc'] . "', '" . $return_val ['cat_id'] . "', '" . $return_val ['mat_waranty'] . "', '" . $return_val ['barcode'] . "', '" . $return_val ['qc'] . "', '" . $return_val ['xuatxu'] . "', '" . $return_val ['pr'] . "', '" . $return_val ['gai'] . "', '" . $return_val ['tkvt'] . "', '" . $return_val ['edit_tkvt'] . "', '" . $return_val ['tkgv'] . "', '" . $return_val ['tkdt'] . "', '" . $return_val ['tktl'] . "', '" . $return_val ['tkdd'] . "', '" . $return_val ['tkcl'] . "', '" . $return_val ['tkck'] . "', '" . $return_val ['alert_qty'] . "', '" . $return_val ['is_tyre'] . "', '" . $return_val ['is_coveralls'] . "', '" . $return_val ['is_intestine'] . "')");
                            insertlog("Thêm sản phẩm mới " . $return_val ['mat_name']);
                            $max_mat = get_data("select max(mat_id) from materials");
                            for ($i = 0; $i < count($return_val ['msu_id']); $i++)
                                if (!empty($return_val ['msu_id'] [$i])){
                                    $db->query("insert into mat_msu(mat_id, msu_id, price, price_dealer, price_dealer2, price_input,discount_input) values('" . $max_mat [0] [0] . "','" . $return_val ['msu_id'] [$i] . "','" . numR($return_val ['price'] [$i]) . "','" . numR($return_val ['price_seller'] [$i]) . "','" . numR($return_val ['price_seller2'] [$i]) . "','" . numR($return_val ['price_input'] [$i]) . "','" . numR($return_val ['discount_input'] [$i]) . "')");
                                    $mms_id=$db->insert_id();
                                    productPull($mms_id);
                                }
                            if (isset($return_val ['mfa']))
                                for ($i = 0; $i < count($return_val ['mfa']); $i++)
                                    $db->query("insert into mfa_mat(mat_id, mfa_id) values('" . $max_mat [0] [0] . "','" . $return_val ['mfa'] [$i] . "')");
                        } else {
                            $err_msg = "Hãy nhập đơn vị tính và giá bán cho sản phẩm";
                        }
                    }
                    }
                }
            }
        } else
            $err_msg = "Hãy nhập tên sản phẩm và chủng loại sản phẩm cần thêm";
        end_func:
    }

    function edit_mat_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $return_val ["mat_name"]=str_replace("'", '&apos;', $return_val ["mat_name"]);
        $return_val ["mat_name"]=str_replace("\"", '&quot;', $return_val ["mat_name"]);

        // if(@$return_val['qc']=="" && @$return_val['xuatxu']==""){
        //     $err_msg = "Số IMEI không được bỏ trống";
        //     goto end_mat_sm;
        // }
        $is_tyre=0;
$is_coveralls=0;
$is_intestine=0;
        switch (intval(@$return_val['mat_type'])) {
            case 0:
                $is_tyre=1;
                break;
            case 1:
                $is_coveralls=1;
                break;
            case 2:
                $is_intestine=1;
                break;
        }
        if (!empty($return_val ["mat_name"]) && !empty($return_val ["cat_id"])) {
            if (count($return_val ['msu_id']) > 0 && !empty($return_val ['msu_id'][0])) {
                $chk = get_data("select mat_model from materials where mat_model='" . $return_val ['mat_model'] . "' and mat_id!='" . $action->eda_id . "'");
                if (!empty($return_val ['mat_model']) && count($chk) > 0) {
                    $err_msg = "Mã sản phẩm đã tồn tại, vui lòng nhập mã sản phẩm khác";
                } else {
                    $chk = get_data("select mat_model from materials where barcode='" . $return_val ['barcode'] . "' and mat_id!='" . $action->eda_id . "'");
                    if (!empty($return_val ['barcode']) && count($chk) > 0) {
                        $err_msg = "Mã vạch của sản phẩm đã tồn tại, vui lòng nhập mã vạch khác";
                    } else {

                        $csql="";
                        if($return_val['qc']!="" || $return_val['gai']!="")
                            $csql="and qc='" . $return_val ['qc'] . "' and gai='" . $return_val ['gai'] . "'";
                    $chk = get_data("select mat_model from materials where (2=1 $csql) and mat_id!='" . $action->eda_id . "' ");
                    if (!empty($return_val ['qc']) && count($chk) > 0) {
                        $err_msg = "Sản phẩm đã tồn tại, vui lòng nhập quy cách hoặc gai khác";
                    } else {

                        $return_val ['msu_id'] = array_unique($return_val ['msu_id']);
                        $db->query("update materials set vat='" . numR($return_val ['vat']) . "', mat_name='" . $return_val ['mat_name'] . "', mat_waranty='" . $return_val ['mat_waranty'] . "', mat_model='" . $return_val ['mat_model'] . "', barcode='" . $return_val ['barcode'] . "', mat_desc='" . $return_val ['mat_desc'] . "', cat_id='" . $return_val ['cat_id'] . "', pr='" . $return_val ['pr'] . "', gai='" . $return_val ['gai'] . "', qc='" . $return_val ['qc'] . "', xuatxu='" . $return_val ['xuatxu'] . "'
, tkvt='" . $return_val ['tkvt'] . "'
, edit_tkvt='" . $return_val ['edit_tkvt'] . "'
, tkgv='" . $return_val ['tkgv'] . "'
, tkdt='" . $return_val ['tkdt'] . "'
, tktl='" . $return_val ['tktl'] . "'
, tkdd='" . $return_val ['tkdd'] . "'
, tkcl='" . $return_val ['tkcl'] . "'
, tkck='" . $return_val ['tkck'] . "'
, alert_qty='" . $return_val ['alert_qty'] . "'
, is_tyre='" . $is_tyre . "'
, is_coveralls='" . $is_coveralls . "'
, is_intestine='" . $is_intestine . "'
                         where mat_id='" . $action->eda_id . "'");
                        insertlog("Sửa thông tin sản phẩm " . $return_val ['mat_name']);
                        $chk = get_data("select mms_id from mat_msu where msu_id not in(" . implode(",", $return_val ['msu_id']) . "0) and mat_id='" . $action->eda_id . "'");
                        if (count($chk) > 0)
                            for ($i = 0; $i < count($chk); $i++) {
                                $chk_invd = get_data("select count(*) from invoice_details where IFNULL(mms_id,'')='" . $chk [$i] ['mms_id'] . "'");
                                if ($chk_invd [0] [0] > 0)
                                    $err_msg = "Bạn không thể xoá được một vài đơn vị tính vì đã tồn tại hoá đơn bán hàng/nhập hàng";
                                else
                                    $db->query("delete from mat_msu where mms_id='" . $chk [$i] ['mms_id'] . "'");
                            }
                        for ($i = 0; $i < count($return_val ['msu_id']); $i++)
                            if (!empty($return_val ['msu_id'] [$i])) {
                                $chk = get_data("select * from mat_msu where msu_id='" . $return_val ['msu_id'] [$i] . "' and mat_id='" . $action->eda_id . "'");
                                if (count($chk) > 0){
                                    $db->query("update mat_msu set price_input='" . numR($return_val ['price_input'] [$i]) . "',discount_input='" . numR($return_val ['discount_input'] [$i]) . "',price='" . numR($return_val ['price'] [$i]) . "', price_dealer='" . numR($return_val ['price_seller'] [$i]) . "', price_dealer2='" . numR($return_val ['price_seller2'] [$i]) . "' where msu_id='" . $return_val ['msu_id'] [$i] . "' and mat_id='" . $action->eda_id . "'");
                                    $mms_id=@get_data("select mms_id from mat_msu where msu_id='" . $return_val ['msu_id'] [$i] . "' and mat_id='" . $action->eda_id . "'")[0]['mms_id'];
                                    productPull($mms_id,$return_val['qc'],$return_val['gai']);
                                }
                                else{
                                    $db->query("insert into mat_msu(mat_id, msu_id, price, price_dealer, price_input, discount_input) values('" . $action->eda_id . "','" . $return_val ['msu_id'] [$i] . "','" . numR($return_val ['price'] [$i]) . "','" . numR($return_val ['price_seller'] [$i]) . "','" . numR($return_val ['price_input'] [$i]) . "','" . numR($return_val ['discount_input'] [$i]) . "')");
                                    $mms_id=$db->insert_id();
                                    productPull($mms_id);
                                }
                            }
                        $db->query("delete from mfa_mat where mat_id='" . $action->eda_id . "'");
                        if (isset($return_val ['mfa']))
                            for ($i = 0; $i < count($return_val ['mfa']); $i++)
                                $db->query("insert into mfa_mat(mat_id, mfa_id) values('" . $action->eda_id . "','" . $return_val ['mfa'] [$i] . "')");
                    }
                    }
                }
            } else {
                $err_msg = "Hãy nhập đơn vị tính và giá bán cho sản phẩm";
            }
        } else
            $err_msg = "Hãy nhập tên sản phẩm và chủng loại sản phẩm cần thêm";
    end_mat_sm:
    }

    //Khách hàng
    function add_cus() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["cus_name"]) && !empty($return_val ["cus_code"])) {
            $chk = get_data("select cus_name from customers where cus_name='" . $return_val ["cus_name"] . "' or cus_code='" . $return_val ["cus_code"] . "' limit 1");
            if (count($chk) > 0) {
                $err_msg = "Tên hoặc mã khách hàng đã tồn tại trên hệ thống";
            } 
            else{
                $db->query("insert into customers(cus_type_id, cus_name, cus_code, address, shipping_address, tel, tax_no, reg_no, fax, bank_acc, bank_name, email, website, debt, max_debt, representative, representative_phone_number, representative_position, remark) values ('" . $return_val ['cus_type_id'] . "', '" . $return_val ['cus_name'] . "', '" . $return_val ['cus_code'] . "', '" . $return_val ['address'] . "', '" . $return_val ['shipping_address'] . "', '" . $return_val ['tel'] . "', '" . $return_val ['tax_no'] . "', '". $return_val ['reg_no'] . "', '" . $return_val ['fax'] . "', '" . $return_val ['bank_acc'] . "', '" . $return_val ['bank_name'] . "', '" . $return_val ['email'] . "','" . $return_val ['website'] . "','" . $return_val ['debt'] . "','" . numR($return_val ['max_debt']) . "','" . $return_val ['representative'] . "','" . $return_val ['representative_phone_number'] . "','" . $return_val ['representative_position'] . "','" . $return_val ['remark']."')");
            }
        } else
            $err_msg = "Hãy nhập tên và mã khách hàng cần thêm";
    }

    function edit_cus() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;

        if (!empty($return_val ["cus_name"]) && !empty($return_val ["cus_code"])) {
            $chk = get_data("select cus_name from customers where cus_id != " . $action->eda_id . " and (cus_name='" . $return_val ["cus_name"] . "' or cus_code='" . $return_val ["cus_code"] . "') limit 1");
            if (count($chk) > 0) {
                $err_msg = "Tên hoặc mã khách hàng đã tồn tại trên hệ thống";
            } 
            else {
                $db->query("update customers set 
                              cus_type_id='" . $return_val ['cus_type_id'] . "'
                            , cus_name='" . $return_val ['cus_name'] . "'
                            , cus_code='" . $return_val ['cus_code'] . "'
                            , address='" . $return_val ['address'] . "'
                            , shipping_address='" . $return_val ['shipping_address'] . "'
                            , tel='" . $return_val ['tel'] . "'
                            , tax_no='" . $return_val ['tax_no'] . "'
                            , reg_no='" . $return_val ['reg_no'] . "'
                            , fax='" . (@$return_val ['fax']) . "'
                            , bank_acc='" . (@$return_val ['bank_acc']) . "'
                            , bank_name='" . (@$return_val ['bank_name']) . "'
                            , email='" . (@$return_val ['email']) . "'
                            , bank_name='" . (@$return_val ['bank_name']) . "'
                            , email='" . numR($return_val ['email']) . "'
                            , website='" . numR($return_val ['website']) . "'
                            , max_debt='" . numR($return_val ['max_debt']) . "'
                            , representative='" . (@$return_val ['representative']) . "'
                            , representative_phone_number='" . (@$return_val ['representative_phone_number']) . "'
                            , representative_position='" . (@$return_val ['representative_position']) . "'
                            , remark='" . (@$return_val ['remark']) . "'
				 where cus_id='" . $action->eda_id . "'");
            }
        } else
            $err_msg = "Hãy nhập tên và mã khách hàng cần thêm";
    }
	
    //Nhà cung cấp
    function add_sup_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["sup_name"]) && !empty($return_val ["sup_code"])) {
            $chk = get_data("select sup_name from supliers where sup_name='" . $return_val ["sup_name"] . "' or sup_code='" . $return_val ["sup_code"] . "' limit 1");
            if (count($chk) > 0) {
                $err_msg = "Tên hoặc mã nhà cung cấp đã tồn tại trên hệ thống";
            } else {
                $db->query("insert into supliers(sup_code, sup_name, tax_no, address, tel, description, email, website, reg_no, bank_acc, bank_name, debt,taikhoan,duno,duco,duno_nt,duco_nt,duno_dn,duco_dn,duno_ntdn,duco_ntdn) 
                            values('" . $return_val ['sup_code'] . "', '" . $return_val ['sup_name'] . "', '" . $return_val ['tax_no'] . "', '" . $return_val ['address'] . "', '" . $return_val ['tel'] . "', '" . $return_val ['description'] . "', '" . $return_val ['email'] . "', '" . $return_val ['website'] . "', '" . $return_val ['reg_no'] . "', 
                            '" . $return_val ['bank_acc'] . "', '" . $return_val ['bank_name'] . "','" . numR($return_val ['debt']) . "','" . ($return_val ['taikhoan']) . "','" . numR($return_val ['duno']) . "','" . numR($return_val ['duco']) . "','" . numR($return_val ['duno_nt']) . "','" . numR($return_val ['duco_nt']) . "','" . numR($return_val ['duno_dn']) . "','" . numR($return_val ['duco_dn']) . "','" . numR($return_val ['duno_ntdn']) . "','" . numR($return_val ['duco_ntdn']) . "')");
            }
        } else
            $err_msg = "Hãy nhập ít nhất tên và mã nhà cung cấp cần thêm";
    }

    function edit_sup_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["sup_name"]) && !empty($return_val ["sup_code"])) {
            $chk = get_data("select sup_name from supliers where sup_id!='" . $action->eda_id . "' and (sup_name='" . $return_val ["sup_name"] . "' or sup_code='" . $return_val ["sup_code"] . "') limit 1");
            if (count($chk) > 0) {
                $err_msg = "Tên hoặc mã nhà cung cấp đã tồn tại trên hệ thống";
            } else {
                $db->query("update supliers set sup_name='" . $return_val ['sup_name'] . "', tax_no='" . $return_val ['tax_no'] . "', address='" . $return_val ['address'] . "', tel='" . $return_val ['tel'] . "', description='" . $return_val ['description'] . "', 
                            sup_code='" . $return_val ['sup_code'] . "', email='" . $return_val ['email'] . "', website='" . $return_val ['website'] . "' , reg_no='" . $return_val ['reg_no'] . "', bank_acc='" . $return_val ['bank_acc'] . "', bank_name='" . $return_val ['bank_name'] . "', debt=" . numR($return_val ['debt']) . "
                            , taikhoan='" . (@$return_val ['taikhoan']) . "'
                            , duno=" . numR($return_val ['duno']) . "
                            , duco=" . numR($return_val ['duco']) . "
                            , duno_nt=" . numR($return_val ['duno_nt']) . "
                            , duco_nt=" . numR($return_val ['duco_nt']) . "
                            , duno_dn=" . numR($return_val ['duno_dn']) . "
                            , duco_dn=" . numR($return_val ['duco_dn']) . "
                            , duno_ntdn=" . numR($return_val ['duno_ntdn']) . "
                            , duco_ntdn=" . numR($return_val ['duco_ntdn']) . "
                            where sup_id='" . $action->eda_id . "'");
            }
        } else
            $err_msg = "Hãy nhập ít nhất tên và nhà cung cấp cần thêm";
    }

















//Nhà cung cấp
    function add_hddukien_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["stock_id"]) && !empty($return_val ["khhd"])) {
            $chk = get_data("select * from caidat_hoadon where stock_id='" . $return_val ["stock_id"] . "' and batdau='" . $return_val ["batdau"] . "' and ketthuc='" . $return_val ["ketthuc"] . "' and hientai='" . $return_val ["hientai"] . "' and khhd='" . $return_val ["khhd"] . "' limit 1");
            if (count($chk) > 0) {
                $err_msg = "đã tồn tại trên hệ thống";
            } else {
                $db->query("insert into caidat_hoadon(stock_id,batdau,ketthuc,hientai,khhd) 
                            values('" . intval($return_val ['stock_id']) . "', '" . intval($return_val ['batdau']) . "', '" . intval($return_val ['ketthuc']) . "', '" . intval($return_val ['hientai']) . "', '" . $return_val ['khhd'] . "')");
            }
        } else
            $err_msg = "Hãy nhập ít nhất tên và mã nhà cung cấp cần thêm";
    }

    function edit_hddukien_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["stock_id"]) && !empty($return_val ["khhd"])) {
            $chk = get_data("select * from caidat_hoadon where stock_id='" . $return_val ["stock_id"] . "' and batdau='" . $return_val ["batdau"] . "' and ketthuc='" . $return_val ["ketthuc"] . "' and hientai='" . $return_val ["hientai"] . "' and khhd='" . $return_val ["khhd"] . "' limit 1");
           {
                $db->query("update caidat_hoadon set
                             stock_id='" . (@$return_val ['stock_id']) . "'
                            , batdau=" . intval($return_val ['batdau']) . "
                            , ketthuc=" . intval($return_val ['ketthuc']) . "
                            , hientai=" . intval($return_val ['hientai']) . "
                            , khhd='" . ($return_val ['khhd']) . "'
                            where ch_id='" . $action->eda_id . "'");
            }
        } else
            $err_msg = "Hãy nhập ít nhất tên và nhà cung cấp cần thêm";
    }


















    //Hãng sản xuất
    function add_mfa_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select mfa_name from manufactures where mfa_name='" . $return_val ["mfa_name"] . "'");
        if (count($chk) > 0) {
            $err_msg = "Tên hãng đã tồn tại trên hệ thống";
        } else if (!empty($return_val ["mfa_name"])) {
            $db->query("insert into manufactures(mfa_name, address, tel, description, email, website, cat_list) 
			values('" . $return_val ['mfa_name'] . "', '" . $return_val ['address'] . "', '" . $return_val ['tel'] . "', '" . $return_val ['description'] . "', '" . $return_val ['email'] . "', '" . $return_val ['website'] . "', '" . implode(',', $return_val ['cat_list']) . "')");
        } else
            $err_msg = "Hãy nhập ít nhất tên nhà cung cấp cần thêm";
    }

    function edit_mfa_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["mfa_name"])) {
            $db->query("update manufactures set mfa_name='" . $return_val ['mfa_name'] . "', address='" . $return_val ['address'] . "', tel='" . $return_val ['tel'] . "', description='" . $return_val ['description'] . "', 
						email='" . $return_val ['email'] . "', website='" . $return_val ['website'] . "', cat_list='" . implode(',', $return_val ['cat_list']) . "' where mfa_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập ít nhất tên nhà cung cấp cần thêm";
    }

    //Khoản thu/chi
    function item_type_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["item_name"])) {
            $db->query("insert into item_type(item_name, item_type) values('" . $return_val ['item_name'] . "', '" . $return_val ['item_type'] . "')");
        } else
            $err_msg = "Hãy nhập tên khoản Thu/Chi";
    }

    function edit_item_type_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["item_name"])) {
            $db->query("update item_type set item_name='" . $return_val ['item_name'] . "', item_type='" . $return_val ['item_type'] . "' where item_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập tên khoản Thu/Chi";
    }

    //Nhân viên
    function add_emp_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["user_name"]) && !empty($return_val ["full_name"]) && !empty($return_val ["password"]) && !empty($return_val ["password_confirm"])) {
            if ($return_val ["password"] == $return_val ["password_confirm"]) {
                $chk = get_data("select user_id from users where user_name='" . $return_val ["user_name"] . "'");
                if (count($chk) > 0) {
                    $err_msg = "Tên đăng nhập đã tồn tại trên hệ thống";
                } else {
                    $db->query("insert into users(nation_id, nation_code, nation_name, city_id, city_code, city_name, user_name, full_name, address, tel, description, created_date, sex, email, password, dept_id, group_id) 
					values('" . $return_val ['nation_id'] . "', '" . $return_val ['nation_code'] . "', '"  . $return_val ['nation_name'] . "', '"  . $return_val ['city_id'] . "', '"  . $return_val ['city_code'] . "', '"  . $return_val ['city_name'] . "', '" 
                            . $return_val ['user_name'] . "', '" . $return_val ['full_name'] . "', '" . $return_val ['address'] . "', '" . $return_val ['tel'] . "', '" . $return_val ['description'] .
                            "'," . time() . ",'" . $return_val ['sex'] . "','" . $return_val ['email'] . "','" . md5($return_val ['password']) . "','" . $return_val ['dept_id'] . "','" . $return_val ['group_id'] . "')");
                }
            } else
                $err_msg = "Hãy nhập mật khẩu và nhập lại mật khẩu giống nhau";
        } else
            $err_msg = "Hãy nhập đầy đủ các thông tin bắt buộc trong dấu (*)";
    }

    function edit_emp_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["user_name"]) && !empty($return_val ["full_name"])) {
            if ($return_val ["password"] == $return_val ["password_confirm"]) {
                $chk = get_data("select user_id from users where user_name='" . $return_val ["user_name"] . "' and user_id!='" . $action->eda_id . "'");
                if (count($chk) > 0) {
                    $err_msg = "Tên đăng nhập đã tồn tại trên hệ thống";
                } else {
                    $chk = get_data("select password from users where user_id='" . $action->eda_id . "'");
                    $db->query("update users set user_name='" . $return_val ['user_name'] . "', full_name='" . $return_val ['full_name'] . "', email='" . $return_val ['email'] . "', address='" . $return_val ['address'] . "', tel='" . $return_val ['tel'] . "', description='" . $return_val ['description'] . "', sex='" . $return_val ['sex'] . "'" .
                            (!empty($return_val ["password"]) ? ", password='" . md5($return_val ['password']) . "'" : "") . ", dept_id='" . $return_val ['dept_id'] . "', group_id='" . $return_val ['group_id'] .  "', nation_id='" . $return_val ['nation_id'] . "', nation_code='" . $return_val ['nation_code'] .  "', nation_name='" . $return_val ['nation_name'] . "', city_id='" . $return_val ['city_id'] . "', city_code='" . $return_val ['city_code'] . "', city_name='" . $return_val ['city_name'] . "' where user_id='" . $action->eda_id . "'");
                }
            } else
                $err_msg = "Hãy nhập mật khẩu và nhập lại mật khẩu giống nhau";
        } else
            $err_msg = "Hãy nhập đầy đủ các thông tin bắt buộc";
    }

    //Đổi mật khẩu
    function changepass() {
        global $err_msg, $db, $info, $sessions, $return_val;
        $err_msg = "";
        $pass = get_data("select password from users where user_name='" . $sessions->get_session("user_name") . "'");
        $pass = $pass [0] ["password"];
        if ($return_val ["new_pass"] == "" || $return_val ["new_pass_verify"] == "" || $return_val ["cur_pass"] == "")
            $err_msg .= "Hãy nhập vào đầy đủ mật khẩu hiện tại và mật khẩu mới<br>";
        if (md5($return_val ["cur_pass"]) != $pass)
            $err_msg .= "Mật khẩu hiện tại không chính xác<br>";
        if ($return_val ["new_pass"] != $return_val ["new_pass_verify"])
            $err_msg .= "Mật khẩu mới và xác nhận mật khẩu mới phải giống nhau";
        if ($err_msg == "") {
            $err_msg = "Thay mật khẩu thành công";
            $db->query("update users set password='" . md5($return_val ["new_pass"]) . "'  where user_name='" . $sessions->get_session("user_name") . "'");
        }
    }

    //Tài khoản
    function fund_add_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["fund_name"]) && !empty($return_val ["fund_type"])) {
            $db->query("insert into fund(fund_name, fund_type, acc_no, bank_name, amount, sum, user_id) 
				values('" . $return_val ['fund_name'] . "', '" . $return_val ['fund_type'] . "', '" . $return_val ['acc_no'] . "', '" . (isset($return_val ['bank_name']) ? $return_val ['bank_name'] : '') . "','" . $return_val ['amount'] . "','" . $return_val ['amount'] . "'," . (!empty($return_val ['user_id']) ? $return_val ['user_id'] : 'null') . ")");
        } else
            $err_msg = "Hãy nhập đầy đủ các thông tin bắt buộc trong dấu (*)";
    }

    function fund_edit_sm(){
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if ($action->eda_id == 1) {
            $db->query("update fund set sum=sum+" . $return_val ['amount'] . "-amount, amount='" . $return_val ['amount'] . "' where fund_id='" . $action->eda_id . "'");
        } else if (!empty($return_val ["fund_name"]) && !empty($return_val ["fund_type"])) {
            $db->query("update fund set fund_name='" . $return_val ['fund_name'] . "', sum=sum+" . $return_val ['amount'] . "-amount, amount='" . $return_val ['amount'] . "', fund_type= '" . $return_val ['fund_type'] . "', acc_no='" . $return_val ['acc_no'] . "', 
				bank_name='" . (isset($return_val ['bank_name']) ? $return_val ['bank_name'] : '') . "', user_id=" . (!empty($return_val ['user_id']) ? $return_val ['user_id'] : 'null') . " 
				where fund_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập đầy đủ các thông tin bắt buộc trong dấu (*)";
    }

    //Kho
    function stock_add_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $return_val['stock_code']=preg_replace('/[^A-Za-z0-9\-\_]/', '',@$return_val['stock_code']);
        if (!empty($return_val ["stock_name"]) && $return_val['stock_code']!="") {


$chk = get_data("select stock_code from stocks where stock_code like '" . $return_val ['stock_code'] . "' ");
                if (count($chk) > 0) {
                    $err_msg = "Đã tồn tại mã kho <b>" . $chk[0][0] . "</b>";
                    return false;
                }

            if ($return_val ['stock_type'] == 'EMP' && intval(@$return_val['user_id'])==0) {
                $err_msg = "Hãy chọn nhân viên";
            } else {
                if (!isset($return_val['user_list'])) {
                    $return_val['user_list'] = array();
                }
                $chk = get_data("select stock_name from stocks where user_id='" . intval(@$return_val['user_id']) . "'");
                if (count($chk) > 0) {
                    $err_msg = "Nhân viên này đã tồn tại kho hàng <b>" . $chk[0][0] . "</b>";
                } else {


// ten_chi_nhanh='" . $return_val ['ten_chi_nhanh'] . "', 
//                         mst='" . $return_val ['mst'] . "', 
//                         sdt='" . $return_val ['sdt'] . "', 
//                         fax='" . $return_val ['fax'] . "', 
//                         stk='" . $return_val ['stk'] . "', 
//                         nganhang='" . $return_val ['nganhang'] . "', 

                    $db->query("insert into stocks(ten_chi_nhanh,mst,sdt,fax,stk,nganhang,stock_name,stock_code, address" . ($return_val ['stock_type'] == 'EMP' ? ', user_id, user_list' : '') . ") 
					values('" . $return_val ['ten_chi_nhanh'] . "','" . $return_val ['mst'] . "','" . $return_val ['sdt'] . "','" . $return_val ['fax'] . "','" . $return_val ['stk'] . "','" . $return_val ['nganhang'] . "','" . $return_val ['stock_name'] . "','" . $return_val ['stock_code'] . "', '" . $return_val ['address'] . "'" . ($return_val ['stock_type'] == 'EMP' ? ",'" . $return_val ['user_id'] . "','" . implode(",", $return_val['user_list']) . "'" : "") . ")");
                }
            }
        } else
            $err_msg = "Hãy nhập đầy đủ các thông tin bắt buộc trong dấu (*)";
    }

    function stock_edit_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $return_val['stock_code']=preg_replace('/[^A-Za-z0-9\-\_]/', '',@$return_val['stock_code']);
        if (!empty($return_val ["stock_name"]) && $return_val['stock_code']!="") {

$chk = get_data("select stock_code from stocks where stock_code like '" . $return_val ['stock_code'] . "' and stock_id!='" . $action->eda_id . "'");
                if (count($chk) > 0) {
                    $err_msg = "Đã tồn tại mã kho <b>" . $chk[0][0] . "</b>";
                    return false;
                }


            if ($return_val ['stock_type'] == 'EMP' && intval(@$return_val['user_id'])==0) {
                $err_msg = "Hãy chọn nhân viên";
            } else {
                $chk = get_data("select stock_name from stocks where user_id='" . intval(@$return_val['user_id']) . "' and stock_id!='" . $action->eda_id . "'");
                if (count($chk) > 0) {
                    $err_msg = "Nhân viên này đã tồn tại kho hàng <b>" . $chk[0][0] . "</b>";
                } else {
                    if (!isset($return_val['user_list'])) {
                        $return_val['user_list'] = array();
                    }
                    $db->query("update stocks set 
                        stock_name='" . $return_val ['stock_name'] . "',
                        stock_code='" . $return_val ['stock_code'] . "', 
                        ten_chi_nhanh='" . $return_val ['ten_chi_nhanh'] . "', 
                        mst='" . $return_val ['mst'] . "', 
                        sdt='" . $return_val ['sdt'] . "', 
                        fax='" . $return_val ['fax'] . "', 
                        stk='" . $return_val ['stk'] . "', 
                        nganhang='" . $return_val ['nganhang'] . "', 
                        address='" . $return_val ['address'] . "'" . ($return_val ['stock_type'] == 'EMP' ? ", user_id=" . $return_val ['user_id'] . ", user_list='" . implode(",", $return_val['user_list']) . "'" : ', user_id=null') . " 
					where stock_id='" . $action->eda_id . "'");
                }
            }
        } else
            $err_msg = "Hãy nhập đầy đủ các thông tin bắt buộc trong dấu (*)";
    }
function areas_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select area_id from areas where area_name='" . $return_val ['area_name'] . "'");
        if (count($chk) > 0) {
            $err_msg = "Tên khu vực đã tồn tại trên hệ thống";
        } else if (!empty($return_val ["area_name"])) {
            $db->query("insert into areas(area_name) values('" . $return_val ['area_name'] . "')");
        } else
            $err_msg = "Hãy nhập tên khu vực";
    }
    function edit_area_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select area_id from areas where area_name='" . $return_val ['area_name'] . "'");
        if (count($chk) > 0) {
            $err_msg = "Tên khu vực đã tồn tại trên hệ thống";
        } else if (!empty($return_val ["area_name"])) {
            $db->query("update areas set area_name='" . $return_val ['area_name'] . "' where area_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập tên khu vực";
    }








function plists_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select plist_id from plists where plist_name='" . $return_val ['plist_name'] . "'");
        if (count($chk) > 0) {
            $err_msg = "Tên loại thanh toán đã tồn tại trên hệ thống";
        } else if (!empty($return_val ["plist_name"])) {
            $db->query("insert into plists(plist_name) values('" . $return_val ['plist_name'] . "')");
        } else
            $err_msg = "Hãy nhập tên loại thanh toán";
    }
    function edit_plist_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select plist_id from plists where plist_name='" . $return_val ['plist_name'] . "'");
        if (count($chk) > 0) {
            $err_msg = "Tên loại thanh toán đã tồn tại trên hệ thống";
        } else if (!empty($return_val ["plist_name"])) {
            $db->query("update plists set plist_name='" . $return_val ['plist_name'] . "' where plist_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập tên loại thanh toán";
    }

    //Đơn vị tính
    function msu_add_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["msu_name"])) {
            if (!empty($return_val ['msu_parid'])) {
                if (empty($return_val ['msu_multiple'])) {
                    $err_msg = "Hãy nhập tỷ lệ";
                } else {
                    $db->query("insert into meansure(msu_name, msu_parid, msu_multiple) values('" . $return_val ['msu_name'] . "', '" . $return_val ['msu_parid'] . "', '" . $return_val ['msu_multiple'] . "')");
                }
            } else {
                $db->query("insert into meansure(msu_name, msu_multiple) values('" . $return_val ['msu_name'] . "',1)");
            }
        } else
            $err_msg = "Hãy nhập tên đơn vị tính";
    }

    function msu_edit_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["msu_name"])) {
            if (!empty($return_val ['msu_parid'])) {
                if (empty($return_val ['msu_multiple'])) {
                    $err_msg = "Hãy nhập tỷ lệ";
                } else {
                    $db->query("update meansure set msu_name='" . $return_val ['msu_name'] . "', msu_parid='" . $return_val ['msu_parid'] . "', msu_multiple='" . $return_val ['msu_multiple'] . "' where msu_id='" . $action->eda_id . "'");
                }
            } else {
                $db->query("update meansure set msu_name='" . $return_val ['msu_name'] . "', msu_parid=null, msu_multiple=1 where msu_id='" . $action->eda_id . "'");
            }
        } else
            $err_msg = "Hãy nhập tên đơn vị tính";
    }
    
    //Phân quyền quản trị
    function permission_sm() {
        global $user_id, $db, $sessions, $action, $err_msg, $return_val;
        if (empty($return_val ['group_id'])) {
            $err_msg = "Hãy chọn nhóm làm việc và quyền quản trị";
        } else {
            if (empty($return_val ['user_id'])) {
                $db->query("delete from user_group_permission where group_id='" . intval($return_val['group_id']) . "'");
                for ($i = 0; $i < count($return_val['fmenu_id']); $i++) {
                    if (!empty($return_val['fmenu_id'])) {
                        $db->query("insert into user_group_permission(group_id, fmenu_id) values('" . intval($return_val['group_id']) . "','" . intval($return_val['fmenu_id'][$i]) . "')");
                    }
                }
            } else {
                $db->query("delete from user_group_permission where user_id='" . intval($return_val['user_id']) . "'");
                for ($i = 0; $i < count($return_val['fmenu_id']); $i++) {
                    if (!empty($return_val['fmenu_id'])) {
                        $db->query("insert into user_group_permission(user_id,  fmenu_id) values('" . intval($return_val['user_id']) . "','" . intval($return_val['fmenu_id'][$i]) . "')");
                    }
                }
            }
        }
    }

}

?>
