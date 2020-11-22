<?php
require_once "bms/classes/modules.php";

class user_manager extends modules {
    function user_manager() {}

    function child_run() {
        global $action, $sessions, $db, $file_tmp, $err_msg, $return_val, $transfer, $head;
        
        if ($sessions->get_session("login") != "logined" && $action->eda_code != md5("login") && $action->eda_code != md5("in") && $action->eda_code != md5("reg") && $action->eda_code != md5("forgot") && $transfer == false) {
            include("bms/templates/login.htm");
            $transfer = true;
        } 
        else {
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

                // Quản lý nhân viên                 
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

                // Phân quyền quản trị                   
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
            }
        }
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
                    $db->query("insert into users(user_name, full_name, address, tel, description, created_date, sex, email, password, dept_id, group_id) 
					values('" . $return_val ['user_name'] . "', '" . $return_val ['full_name'] . "', '" . $return_val ['address'] . "', '" . $return_val ['tel'] . "', '" . $return_val ['description'] .
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
                    $db->query("update users set user_name='" . $return_val ['user_name'] . "', full_name='" . $return_val ['full_name'] . "', address='" . $return_val ['address'] . "', tel='" . $return_val ['tel'] . "', description='" . $return_val ['description'] . "', sex='" . $return_val ['sex'] . "'" .
                            (!empty($return_val ["password"]) ? ", password='" . md5($return_val ['password']) . "'" : "") . ", dept_id='" . $return_val ['dept_id'] . "', group_id='" . $return_val ['group_id'] . "' where user_id='" . $action->eda_id . "'");
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