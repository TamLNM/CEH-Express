<?php

include ("bms/classes/modules.php");

class manufacturing extends modules {

    function manufacturing() {

    }

    function child_run() {
        global $action, $sessions, $db, $file_tmp, $err_msg, $return_val, $transfer;
        if ($sessions->get_session("login") != "logined" && $action->eda_code != md5("login") && $action->eda_code != md5("in") && $action->eda_code != md5("reg") && $action->eda_code != md5("forgot") && $transfer == false) {
            include("bms/templates/login.htm");
            $transfer=true;
        } else {
            switch ($action->eda_code) {

//Quản lý sản xuất
                case md5("man_declare") :
                    $action->title = "Khai báo sản xuất";
                    $action->eda_decode = "man_declare";
                    $file_tmp = "manufacturing/man_declare.htm";
                    break;
                case md5('add_man') :
                    $action->title = "Khai báo sản xuất mới";
                    $action->eda_decode = "man_declare";
                    $file_tmp = "manufacturing/add_man.htm";
                    break;
                case md5('add_man_sm') :
                    $this->add_man_sm();
                    $action->eda_decode = "man_manager";
                    if (empty($err_msg)) {
                        page_transfer("Thêm sản xuất mới thành công", "?eda_act=" . md5("general") . "&eda_code=" . md5("man_manager"));
                        $transfer = true;
                    }
                    $file_tmp = "manufacturing/add_man.htm";
                    break;
                case md5('del_man') :
                    $db->query("delete from manufactures where man_id='" . $action->eda_id . "'");
                    if (empty($err_msg)) {
                        page_transfer("Thực hiện xoá thông tin sản xuất thành công", "?eda_act=" . md5("general") . "&eda_code=" . md5("man_manager"));
                        $transfer = true;
                    }
                    $action->eda_decode = "man_manager";
                    $file_tmp = "manufacturing/man_manager.htm";
                    break;
                case md5('edit_man') :
                    $action->title = "Sửa thông tin sản xuất";
                    $action->eda_decode = "man_manager";
                    $man = get_data("select * from manufactures where man_id='" . $action->eda_id . "'");
                    if (count($man) > 0) {
                        $return_val = $man [0];
                        $return_val ['cat_list'] = @explode(',', $return_val ['cat_list']);
                        $file_tmp = "manufacturing/edit_man.htm";
                    } else {
                        page_transfer('Không tìm thấy thông tin sản xuất', "?eda_act=" . md5("general") . "&eda_code=" . md5("sup_manager"));
                        $transfer = true;
                    }
                    $file_tmp = "manufacturing/edit_man.htm";
                    break;
                case md5('edit_man_sm') :
                    $this->edit_man_sm();
                    if (empty($err_msg)) {
                        page_transfer("Sửa thông tin sản xuất thành công", "?eda_act=" . md5("general") . "&eda_code=" . md5("man_manager"));
                        $transfer = true;
                    }
                    $action->eda_decode = "man_manager";
                    $file_tmp = "manufacturing/edit_man.htm";
                    break;
                case md5("view_man") :
                    $action->title = "Xem thông tin sản xuất";
                    $action->eda_decode = "man_manager";
                    $file_tmp = "manufacturing/view_man.htm";
                    break;
            }
        }
    }

    //Hãng sản xuất
    function add_man_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $chk = get_data("select man_name from manufactures where man_name='" . $return_val ["man_name"] . "'");
        if (count($chk) > 0) {
            $err_msg = "Tên hãng đã tồn tại trên hệ thống";
        } else if (!empty($return_val ["man_name"])) {
            $db->query("insert into manufactures(man_name, address, tel, description, email, website, cat_list)
			values('" . $return_val ['man_name'] . "', '" . $return_val ['address'] . "', '" . $return_val ['tel'] . "', '" . $return_val ['description'] . "', '" . $return_val ['email'] . "', '" . $return_val ['website'] . "', '" . implode(',', $return_val ['cat_list']) . "')");
        } else
            $err_msg = "Hãy nhập ít nhất tên nhà cung cấp cần thêm";
    }

    function edit_man_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        if (!empty($return_val ["man_name"])) {
            $db->query("update manufactures set man_name='" . $return_val ['man_name'] . "', address='" . $return_val ['address'] . "', tel='" . $return_val ['tel'] . "', description='" . $return_val ['description'] . "',
						email='" . $return_val ['email'] . "', website='" . $return_val ['website'] . "', cat_list='" . implode(',', $return_val ['cat_list']) . "' where man_id='" . $action->eda_id . "'");
        } else
            $err_msg = "Hãy nhập ít nhất tên nhà cung cấp cần thêm";
    }

}

?>
