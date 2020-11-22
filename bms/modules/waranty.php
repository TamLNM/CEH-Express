<?php

include ("bms/classes/modules.php");

class waranty extends modules {

    function waranty() {
        
    }

    function child_run() {
        global $action, $sessions, $db, $file_tmp, $err_msg, $return_val, $transfer,$head;
        if ($sessions->get_session("login") != "logined" && $action->eda_code != md5("login") && $action->eda_code != md5("in") && $action->eda_code != md5("reg") && $action->eda_code != md5("forgot") && $transfer == false) {
            include("bms/templates/login.htm");
            $transfer=true;
        } else {
            switch ($action->eda_code) {
                case md5("search_mat_waranty") :
                    include ("bms/templates/waranty/search_mat_waranty_result.htm");
                    break;
                case md5("waranty_in") :
                    $max_inv = get_data("select max(inv_id) from waranty_invoices");
                    $action->eda_decode = "waranty_in";
                    $return_val ['inv_no'] = (isset($head['BH_code'])?$head['BH_code']:'BH') . str_pad($max_inv [0] [0] + 1, 8, '0', STR_PAD_LEFT);
                    $file_tmp = "waranty/waranty_in.htm";
                    break;
                case md5("waranty_in_sm") :
                    $this->waranty_in_sm();
                    $action->eda_decode = "waranty_in";
                    if (empty($err_msg)) {
                        $max_inv = get_data("select max(inv_id) from waranty_invoices");
                        page_transfer("Lập phiếu bảo hành thành công", "?eda_act=" . md5("waranty") . "&eda_code=" . md5("waranty_in_finish") . "&eda_id=" . $max_inv [0] [0]);
                        $transfer = true;
                        $file_tmp = "waranty/view_waranty_in.htm";
                    } else
                        $file_tmp = "waranty/waranty_in.htm";
                    break;
                case md5("waranty_in_finish") :
                    $action->title = "Lập phiếu bảo hành thành công";
                    $action->eda_decode = "waranty_in";
                    $file_tmp = "waranty/view_waranty_in.htm";
                    break;
                case md5("view_waranty_in") :
                    $action->title = "Xem phiếu bảo hành";
                    $action->eda_decode = "waranty_man";
                    $file_tmp = "waranty/view_waranty_in.htm";
                    break;
                case md5("waranty_process") :
                    $action->eda_decode = "waranty_process";
                    if(empty($action->eda_id)) {
                        $return_url['waranty_process'] = $_SERVER['REQUEST_URI'];
                        $sessions->set_session('return_url', serialize($return_url));
                    }
                    $file_tmp = "waranty/waranty_process.htm";
                    break;
                case md5("waranty_process_sm") :
                    $this->waranty_process_sm();
                    $action->eda_decode = "waranty_process";
                    if (empty($err_msg)) {
                        page_transfer("Xử lý phiếu bảo hành thành công", "?eda_act=".md5("waranty")."&eda_code=".md5("view_waranty_process")."&eda_id=".$action->eda_id);
                        $transfer = true;
                    }                   
                    $file_tmp = "waranty/waranty_process.htm";
                    break;
                case md5("view_waranty_process") :
                    $action->eda_decode = "waranty_process";
                    $return_url=unserialize($sessions->get_session("return_url"));
                    $file_tmp = "waranty/view_waranty_process.htm";
                    break;
                case md5("waranty_out") :
                    $bh = isset($_GET['bh']) ? $_GET['bh'] : '';
                    $action->eda_decode = "waranty_out";
                    $inv_code = isset($_GET['inv_code']) ? $_GET['inv_code'] : '';
                    if ($bh == 'tra') {
                        $db->query("update waranty_invoice_details set return_date='" . time() . "',warn_status=3 where invd_id='" . $action->eda_pid . "'");
                        $db->query("update waranty_invoices set created_user='" . $sessions->get_session('user_id') . "' where inv_code='" . $inv_code . "'");
                    } else if ($bh == 'thoi') {
                        $db->query("update waranty_invoice_details set return_date=null,warn_status=0  where invd_id='" . $action->eda_pid . "'");
                        $db->query("update waranty_invoices set created_user='" . $sessions->get_session('user_id') . "' where inv_code='" . $inv_code . "'");
                    }
                    $file_tmp = "waranty/waranty_out.htm";
                    break;
                case md5("waranty_man") :
                    $return_url['waranty_man'] = $_SERVER['REQUEST_URI'];
                    $action->eda_decode = "waranty_man";
                    $sessions->set_session('return_url', serialize($return_url));
                    $action->title = "Quản lý phiếu bảo hành";
                    $file_tmp = "waranty/waranty_man.htm";
                    break;
                case md5("waranty_man_inv") :
                    $action->eda_decode=isset($_GET['eda_decode'])?$_GET['eda_decode']:'';
                    $return_url['waranty_man'] = str_replace("eda_type=ajax&eda_act=af2c7ba7b91ff0513d92a07eef8e0707&eda_code=a23ef2824504c9bdaf168a13516f7579", "?eda_act=af2c7ba7b91ff0513d92a07eef8e0707&eda_code=8232481baaefc74afd761c3bf100b683", $_SERVER['QUERY_STRING']);
                    $sessions->set_session('return_url', serialize($return_url));
                    include( "bms/templates/waranty/waranty_man_inv.htm");
                    break;
                case md5("waranty_man_edit") :
                    $action->title = "Sửa thông tin phiếu bảo hành";
                    $action->eda_decode = "waranty_man";
                    $output = get_data("select * from waranty_invoices where inv_id='" . $action->eda_id . "'");
                    if (!check_func('edit_waranty')) {
                        $file_tmp = "access_deny.htm";                   
                    } else if (count($output) > 0) {
                        $return_val = $output [0];
                        $return_val ['inv_no'] = $return_val ['inv_code'];
                        $return_val ['date'] = date('d/m/Y', $return_val ['created_date']);
                        $return_val ['hour'] = date('H', $return_val ['created_date']);
                        $return_val ['minute'] = date('i', $return_val ['created_date']);
                        if (!empty($return_val ['cus_id'])) {
                            $cus = get_data("select cus_name from customers where cus_id='" . $return_val ['cus_id'] . "'");
                            if (count($cus) > 0)
                                $return_val ['cus_name'] = $cus [0] [0];
                        }
                        $mat=get_data("select warnd.*, matd.mat_name mat_name2, matd.mat_waranty mat_waranty2, matd.msu_name, matd.inv_code inv_code2, matd.created_date from (select * from waranty_invoice_details where inv_id='".$return_val['inv_id']."') warnd left join (select mat.mat_name, mat.mat_waranty, msu.msu_name, oinvd.invd_id, inv.inv_code, inv.created_date from stock_mat_msu smm, mat_msu mms, materials mat, meansure msu, out_invoices inv, out_invoice_details oinvd where oinvd.inv_id=inv.inv_id and oinvd.smm_id=smm.smm_id and smm.mms_id=mms.mms_id and mms.mat_id=mat.mat_id and mms.msu_id=msu.msu_id) matd on warnd.oinvd_id=matd.invd_id");
                        //$mat = get_data("select invd.*, mat.mat_name, inv.inv_code, inv.created_date, mat.mat_waranty, msu.msu_name from waranty_invoice_details invd, stock_mat_msu smm, mat_msu mms, materials mat, meansure msu, out_invoices inv, out_invoice_details oinvd where invd.inv_id='" . $return_val['inv_id'] . "' and invd.oinvd_id=oinvd.invd_id and oinvd.inv_id=inv.inv_id and oinvd.smm_id=smm.smm_id and smm.mms_id=mms.mms_id and mms.mat_id=mat.mat_id and mms.msu_id=msu.msu_id");
                        $return_val ['inv_code'] = array();
                        for ($i = 0; $i < count($mat); $i++) {
                            $return_val['mat_name'][$i] = !empty($mat[$i]['oinvd_id'])?$mat[$i]['mat_name2']:$mat[$i]['mat_name'];
                            $return_val['invd_id'][$i] = $mat[$i]['invd_id'];
                            $return_val['oinvd_id'][$i] = $mat[$i]['oinvd_id'];
                            $return_val['quantity'][$i] = $mat[$i]['mat_quantity'];
                            $return_val['serial'][$i] = $mat[$i]['serial'];
                            $return_val['warn_desc'][$i] = $mat[$i]['warn_desc'];
                        }
                        $file_tmp = "waranty/waranty_man_edit.htm";
                    } else {
                        page_transfer("Không tìm thấy phiếu bảo hành", "?eda_act=" . md5("waranty") . "&eda_code=" . md5("waranty_man_edit") . "&eda_id=" . $action->eda_id);
                        $transfer = true;
                    }
                    break;
                case md5("waranty_man_edit_sm") :
                    $this->waranty_man_edit_sm();
                    $action->eda_decode = "waranty_man";
                    if (empty($err_msg)) {
                        page_transfer("Sửa phiếu bảo hành thành công", "?eda_act=" . md5("waranty") . "&eda_code=" . md5("view_waranty_in") . "&eda_id=" . $action->eda_id);
                        $transfer = true;
                        $file_tmp = "waranty/view_waranty_in.htm";
                    } else
                        $file_tmp = "waranty/waranty_mat_edit.htm";
                    break;
                case md5("waranty_man_del") :
                    $action->eda_decode = "waranty_man";
                    if (!check_func('del_waranty')) {
                        $file_tmp = "access_deny.htm";                   
                    } else {
                        $db->query("delete from waranty_invoices where inv_id='" . $action->eda_id . "'");
                        $return_url = unserialize($sessions->get_session('return_url'));
                        page_transfer("Xoá phiếu bảo hành thành công", $return_url['waranty_man']);
                        $transfer = true;
                        $file_tmp = "waranty/view_waranty_in.htm";
                    }
                    break;
                case md5 ( "dept" ) :
                        $action->title = "Quản lý Bộ phận xử lý Bảo hành - Dịch vụ";
                        $action->eda_decode="dept";
                        $file_tmp = "waranty/dept.htm";
                        break;
                case md5 ( "dept_sm" ) :
                        $this->dept_sm ();
                        $action->eda_decode="dept";
                        if (empty ( $err_msg )) {
                                page_transfer ( "Thêm Bộ phận xử lý Bảo hành - Dịch vụ thành công", "?eda_act=" . md5 ( "waranty" ) . "&eda_code=" . md5 ( "dept" ) );
                                $transfer = true;
                        }
                        $file_tmp = "waranty/dept.htm";
                        break;
                case md5 ( 'del_dept' ) :
                        $chk = get_data ( "select dept_id from waranty_invoices where dept_id ='" . $action->eda_id . "' limit 0,1" );
                        if (count ( $chk ) > 0) {
                                page_transfer ( 'Không xoá được Bộ phận xử lý Bảo hành - Dịch vụ vì đã tồn tại phiếu Bảo hành - Dịch vụ', "?eda_act=" . md5 ( "waranty" ) . "&eda_code=" . md5 ( "dept" ) );
                                $transfer = true;
                        } else {
                                $db->query ( "delete from waranty_dept where dept_id='" . $action->eda_id . "' " );
                                page_transfer ( "Xoá Bộ phận xử lý Bảo hành - Dịch vụ thành công", "?eda_act=" . md5 ( "waranty" ) . "&eda_code=" . md5 ( "dept" ) );
                                $transfer = true;
                        }
                        $action->eda_decode="dept";
                        $file_tmp = "waranty/dept.htm";
                        break;
                case md5 ( "edit_dept" ) :
                        $action->title = "Sửa thông tin Bộ phận xử lý Bảo hành - Dịch vụ";
                        $action->eda_decode="dept";
                        $file_tmp = "waranty/edit_dept.htm";
                        break;
                case md5 ( "edit_dept_sm" ) :
                        $this->edit_dept_sm ();
                        if (empty ( $err_msg )) {
                                page_transfer ( "Sửa thông tin Bộ phận xử lý Bảo hành - Dịch vụ thành công", "?eda_act=" . md5 ( "waranty" ) . "&eda_code=" . md5 ( "dept" ) );
                                $transfer = true;
                        }
                        $action->eda_decode="dept";
                        $file_tmp = "waranty/edit_dept.htm";
                        break;
            }
        }
    }

    function waranty_in_sm() {
        global $err_msg, $db, $info, $sessions, $return_val;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time ();
        $chk = get_data("select inv_code from waranty_invoices where  inv_code='" . $return_val ["inv_no"] . "'");
        if (count($chk) > 0) {
            $err_msg = "Số phiếu này đã tồn tại trên hệ thống";
        } else if ((!empty($return_val ["cus_id"]) || !empty($return_val ["cus_name"])) && (!empty($return_val ["oinvd_id"][0]) || !empty($return_val ["mat_name"][0]))) {
            if (empty($err_msg)) {
                $db->query("begin");
                $db->query("insert into waranty_invoices(created_date, inv_code, cus_id, user_id, created_user, comment, cus_name, dept_id, tel, address) values('" . $created_date . "','" . $return_val ["inv_no"] . "','" . $return_val ["cus_id"] . "','" . $return_val ["user_id"] . "','" . $return_val ['created_user'] . "','" . $return_val ["comment"] . "','" . $return_val ["cus_name"] . "','" . $return_val ["dept_id"] . "','" . $return_val ["tel"] . "','" . $return_val ["address"] . "')");
                $max_inv = get_data("select max(inv_id) from waranty_invoices");
                for ($i = 0; $i < count($return_val ["oinvd_id"]); $i++) {
                    $db->query("insert into waranty_invoice_details(inv_id, oinvd_id, mat_name, mat_quantity, serial, warn_desc) values('" . ($max_inv [0] [0]) . "',".(empty($return_val ["oinvd_id"] [$i])?'null':$return_val ["oinvd_id"] [$i]).",'" . $return_val ["mat_name"] [$i] . "','" . $return_val ["quantity"] [$i] . "','" . $return_val ["serial"] [$i] . "','" . $return_val ["warn_desc"] [$i] . "')");
                }
                $db->query("commit");
                insertlog("Lập phiếu bảo hành ". $return_val ['inv_no']);
            }
        } else {
            $err_msg = "Hãy nhập tên khách hàng và sản phẩm bảo hành";
        }
    }

    function waranty_man_edit_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time ();
        if ((!empty($return_val ["cus_id"]) || !empty($return_val ["cus_name"])) && (!empty($return_val ["oinvd_id"][0]) || !empty($return_val ["mat_name"][0]))) {
            $db->query("update waranty_invoices set created_date='" . $created_date . "', cus_id='" . $return_val ["cus_id"] . "', user_id='" . $return_val ["user_id"] . "', created_user='" . $return_val ["created_user"] . "', comment='" . $return_val ["comment"] . "', dept_id='" . $return_val ["dept_id"] . "', cus_name='" . $return_val ["cus_name"] . "', tel='" . $return_val ["tel"] . "', address='" . $return_val ["address"] . "' where inv_id='" . $action->eda_id . "'");
            $db->query("delete from waranty_invoice_details where inv_id='" . $action->eda_id . "'");
            for ($i = 0; $i < count($return_val ["oinvd_id"]); $i++) {
                if (!empty($return_val ["oinvd_id"] [$i])) {
                    $db->query("insert into waranty_invoice_details(inv_id, oinvd_id, mat_name, mat_quantity, serial) values('" . ($action->eda_id) . "','" . $return_val ["oinvd_id"] [$i] . "','" . $return_val ["mat_name"] [$i] . "','" . $return_val ["quantity"] [$i] . "','" . $return_val ["serial"] [$i] . "')");
                } else if (!empty($return_val ["mat_name"] [$i])) {
                    $db->query("insert into waranty_invoice_details(inv_id, mat_name, mat_quantity, serial, warn_desc) values('" . ($action->eda_id) . "','" . $return_val ["mat_name"] [$i] . "','" . $return_val ["quantity"] [$i] . "','" . $return_val ["serial"] [$i] . "','" . $return_val ["warn_desc"] [$i] . "')");
                }
            }
            insertlog("Sửa phiếu bảo hành ". $return_val ['inv_no']);
        } else {
            $err_msg = "Hãy nhập tên khách hàng và sản phẩm bảo hành";
        }
    }
//Bộ phận xử lý bảo hành - dịch vụ
	function dept_sm() {
		global $err_msg, $db, $info, $sessions, $return_val, $action;
		if (! empty ( $return_val ["dept_name"] )) {
			$db->query ( "insert into waranty_dept(dept_name) values('" . $return_val ['dept_name'] . "')" );
		} else
			$err_msg = "Hãy nhập tên bộ phận";
	}
	function edit_dept_sm() {
		global $err_msg, $db, $info, $sessions, $return_val, $action;
		if (! empty ( $return_val ["dept_name"] )) {
			$db->query ( "update waranty_dept set dept_name='" . $return_val ['dept_name'] . "' where dept_id='" . $action->eda_id . "'" );
		} else
			$err_msg = "Hãy nhập tên bộ phận";
	}
    function waranty_process_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time ();
        $db->query("update waranty_invoices set accept_date='" . $created_date . "',  user_accept='" . $return_val ["user_id"] . "', comment='" . $return_val ["comment"] . "' where inv_id='" . $action->eda_id . "'");
        $inv=get_data("select inv_code from waranty_invoices where inv_id='" . $action->eda_id . "'");
        insertlog("Xử lý phiếu bảo hành ". $inv[0]['inv_code']);        
        for ($i = 0; $i < count($return_val ["invd_id"]); $i++) {
           $db->query("update waranty_invoice_details set service_type='" . $return_val ["service_type"][$i] . "', service_fee='" . str_replace(",","",$return_val ["service_fee"][$i]) . "', warn_status='" . $return_val ["warn_status"][$i] . "', warn_desc='" . $return_val ["warn_desc"][$i] . "', inv_date='" . $return_val ["inv_date"][$i]."'".($return_val ["warn_status"][$i]==3?", return_date=".time():", return_date=NULL") . " where invd_id=".$return_val ["invd_id"][$i]);
           $db->query("delete from waranty_services where invd_id=".$return_val ["invd_id"][$i]);
           $db->query("delete from waranty_materials where invd_id=".$return_val ["invd_id"][$i]);
           for($j=0;$j<count($return_val ["service_name_".$i]);$j++) {
                if(@!empty($return_val ["service_name_".$i][$j])) {
                    $db->query("insert into waranty_services(invd_id, service_name, service_desc, service_fee) values('".$return_val ["invd_id"][$i]."','".$return_val ["service_name_".$i][$j]."','".$return_val ["service_desc_".$i][$j]."','".str_replace(",","",$return_val ["service_fee_".$i][$j])."')");
                }
           }
           for($j=0;$j<count($return_val ["mat_name_".$i]);$j++) {
                if(@!empty($return_val ["mat_name_".$i][$j])) {
                    $db->query("insert into waranty_materials(invd_id, mat_id, mat_name, mat_status, waranty, quantity, price) values('".$return_val ["invd_id"][$i]."',".(empty($return_val ["mat_id_".$i][$j])?'null':"'".$return_val ["mat_id_".$i][$j]."'").",'".$return_val ["mat_name_".$i][$j]."','".$return_val ["mat_status_".$i][$j]."','".$return_val ["waranty_".$i][$j]."','".str_replace(",","",$return_val ["quantity_".$i][$j])."','".str_replace(",","",$return_val ["amount_".$i][$j])."')");
                }
           }
        }
    }
}

?>
