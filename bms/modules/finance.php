<?php

include ("bms/classes/modules.php");

class finance extends modules {

    function finance() {
        
    }

    function child_run() {
        global $action, $sessions, $db, $file_tmp, $err_msg, $return_val, $transfer, $head;
        if ($sessions->get_session("login") != "logined" && $action->eda_code != md5("login") && $action->eda_code != md5("in") && $action->eda_code != md5("reg") && $action->eda_code != md5("forgot") && $transfer == false) {
            include("bms/templates/login.htm");
            $transfer=true;
        } else {
            switch ($action->eda_code) {
                case md5('budget_input') :
                    $action->title = "Lập phiếu thu";
                    $action->eda_decode = "budget_input";
                    $max_bin = get_data("select max(bin_id) from budget_invoices");
                    $return_val ['bin_code'] = (isset($head['PT_code'])?$head['PT_code']:'PT') . str_pad($max_bin [0] [0] + 1, 8, '0', STR_PAD_LEFT);
                    $file_tmp = "finance/budget_input.htm";
                    break;
                case md5('budget_input_sm') :
                    $this->budget_input_sm();
                    $action->eda_decode = "budget_input";
                    if (empty($err_msg)) {
                        $bin_id = get_data("select max(bin_id) from budget_invoices where bin_type=0");
                        customerTransactionsPull($bin_id[0][0]);
                        page_transfer("Lưu phiếu thu thành công", "?eda_act=" . md5("finance") . "&eda_code=" . md5("budget_input_finish") . "&eda_id=" . $bin_id [0] [0]);
                        $transfer = true;
                    }
                    $file_tmp = "finance/budget_input.htm";
                    break;
                case md5('budget_input_finish') :
                    $return_url['budget_report'] = "?eda_act=" . md5('finance') . "&eda_code=" . md5('budget_report');
                    $action->eda_decode = "budget_input";
                    $sessions->set_session('return_url', serialize($return_url));
                    $action->title = "Lập phiếu thu thành công";
                    $file_tmp = "finance/view_budget_input.htm";
                    break;
                case md5('view_budget_input') :
                    $action->title = "Xem phiếu thu";
                    $action->eda_decode = "budget_input";
                    $file_tmp = "finance/view_budget_input.htm";
                    break;
                case md5('budget_input_edit') :
                    $action->title = "Sửa phiếu thu";
                    $action->eda_decode = "budget_report";
                    $bin = get_data("select * from budget_invoices where bin_id='" . $action->eda_id . "'");
                    if (!check_func('edit_budget_input')) {
                        $file_tmp = "access_deny.htm";                   
                    } else if (count($bin) > 0) {
                        $return_val = $bin [0];
                        $return_val ['date'] = date('d/m/Y', $return_val ['created_date']);
                        $return_val ['hour'] = date('H', $return_val ['created_date']);
                        $return_val ['minute'] = date('i', $return_val ['created_date']);
                        $return_val ['cus_name'] = $return_val ['user_name'];
                        if (!empty($return_val ['cus_id'])) {
                            $cus = get_data("select cus_name from customers where cus_id='" . $return_val ['cus_id'] . "'");
                            if (count($cus) > 0)
                                $return_val ['cus_name'] = $cus [0] [0];
                        }
                        if (!empty($return_val ['sup_id'])) {
                            $sup = get_data("select sup_name from supliers where sup_id='" . $return_val ['sup_id'] . "'");
                            if (count($sup) > 0)
                                $return_val ['cus_name'] = $sup [0] [0];
                            $return_val ['cus_id'] = $return_val ['sup_id'];
                        }
                        if (!empty($return_val ['emp_id'])) {
                            $return_val ['cus_id'] = $return_val ['emp_id'];
                        }
                    } else {
                        page_transfer("Không tìm thấy phiếu thu", "?eda_act=" . md5("finance") . "&eda_code=" . md5("view_budget_input") . "&eda_id=" . $action->eda_id);
                        $transfer = true;
                    }
                    $file_tmp = "finance/edit_budget_input.htm";
                    break;
                case md5('budget_input_edit_sm') :
                    $action->title = "Sửa phiếu thu";
                    $action->eda_decode = "budget_report";
                    $this->edit_budget_input_sm();
                    if (empty($err_msg)) {
                        page_transfer("Lưu phiếu thu thành công", "?eda_act=" . md5("finance") . "&eda_code=" . md5("view_budget_input") . "&eda_id=" . $action->eda_id);
                        customerTransactionsPull($action->eda_id);
                        $transfer = true;
                    }
                    $file_tmp = "finance/edit_budget_input.htm";
                    break;
                case md5('budget_input_del') :
                    $action->eda_decode = "budget_report";
                    if (!check_func('edit_budget_input')) {
                        $file_tmp = "access_deny.htm";                   
                    } else {
                        $db->query("delete from budget_invoices where bin_id='" . $action->eda_id . "'");
                        $binds=get_data("select * from budget_invoice_details where bin_id='" . $action->eda_id . "'");
                        foreach ($binds as $key => $bind) {
                            switch ($bind['doituong']) {
                                case 'out_invoices':
                                    $db->query("update out_invoices set payment=payment-{$bind['price']} where inv_id='" . $bind['item_id'] . "'");
                                    break;
                                case 'invoices':
                                    $db->query("update invoices set payment=payment-{$bind['price']} where inv_id='" . $bind['item_id'] . "'");
                                    break;
                            }
                        }
                        $db->query("delete from budget_invoice_details where bin_id='" . $action->eda_id . "'");
                        $return_url = unserialize($sessions->get_session('return_url'));
                        page_transfer("Thực hiện xoá phiếu thu thành công", $return_url['budget_report']);
                        $transfer = true;
                        $file_tmp = "finance/view_budget_input.htm";
                    }
                    break;
                case md5('budget_output') :
                    $action->title = "Lập phiếu chi";
                    $action->eda_decode = "budget_output";
                    $max_bin = get_data("select max(bin_id) from budget_invoices");
                    $return_val ['bin_code'] = (isset($head['PC_code'])?$head['PC_code']:'PC') . str_pad($max_bin [0] [0] + 1, 8, '0', STR_PAD_LEFT);
                    $file_tmp = "finance/budget_output.htm";
                    break;
                case md5('budget_output_sm') :
                    $this->budget_output_sm();
                    $action->eda_decode = "budget_output";
                    if (empty($err_msg)) {
                        $bin_id = get_data("select max(bin_id) from budget_invoices where bin_type=1");
                        page_transfer("Lưu phiếu chi thành công", "?eda_act=" . md5("finance") . "&eda_code=" . md5("budget_output_finish") . "&eda_id=" . $bin_id[0][0]);
                        $transfer = true;
                    }
                    $file_tmp = "finance/budget_output.htm";
                    break;
                case md5('budget_output_finish') :
                    $return_url['budget_report'] = "?eda_act=" . md5('finance') . "&eda_code=" . md5('budget_report');
                    $action->eda_decode = "budget_output";
                    $sessions->set_session('return_url', serialize($return_url));
                    $action->title = "Lập phiếu chi thành công";
                    $file_tmp = "finance/view_budget_output.htm";
                    break;
                case md5('view_budget_output') :
                    $action->title = "Xem phiếu chi";
                    $action->eda_decode = "budget_output";
                    $file_tmp = "finance/view_budget_output.htm";
                    break;
                case md5('budget_output_edit') :
                    $action->title = "Sửa phiếu chi";
                    $action->eda_decode = "budget_report";
                    $bin = get_data("select * from budget_invoices where bin_id='" . $action->eda_id . "'");
                    if (!check_func('edit_budget_output')) {
                        $file_tmp = "access_deny.htm";                   
                    } else if (count($bin) > 0) {
                        $return_val = $bin [0];
                        $return_val ['date'] = date('d/m/Y', $return_val ['created_date']);
                        $return_val ['hour'] = date('H', $return_val ['created_date']);
                        $return_val ['minute'] = date('i', $return_val ['created_date']);
                        $return_val ['cus_name'] = $return_val ['user_name'];
                        if (!empty($return_val ['cus_id'])) {
                            $cus = get_data("select cus_name from customers where cus_id='" . $return_val ['cus_id'] . "'");
                            if (count($cus) > 0)
                                $return_val ['cus_name'] = $cus [0] [0];
                        }
                        if (!empty($return_val ['sup_id'])) {
                            $sup = get_data("select sup_name from supliers where sup_id='" . $return_val ['sup_id'] . "'");
                            if (count($sup) > 0)
                                $return_val ['cus_name'] = $sup [0] [0];
                            $return_val ['cus_id'] = $return_val ['sup_id'];
                        }
                        if (!empty($return_val ['emp_id'])) {
                            $return_val ['cus_id'] = $return_val ['emp_id'];
                        }
                    } else {
                        page_transfer("Không tìm thấy phiếu chi", "?eda_act=" . md5("finance") . "&eda_code=" . md5("view_budget_output") . "&eda_id=" . $action->eda_id);
                        $transfer = true;
                    }
                    $file_tmp = "finance/edit_budget_output.htm";
                    break;
                case md5('budget_output_edit_sm') :
                    $action->title = "Sửa phiếu chi";
                    $action->eda_decode = "budget_report";
                    $this->edit_budget_output_sm();
                    if (empty($err_msg)) {
                        page_transfer("Lưu phiếu chi thành công", "?eda_act=" . md5("finance") . "&eda_code=" . md5("view_budget_output") . "&eda_id=" . $action->eda_id);
                        $transfer = true;
                    }
                    $file_tmp = "finance/edit_budget_output.htm";
                    break;
                case md5('budget_output_del') :
                    $action->eda_decode = "budget_report";
                    if (!check_func('edit_budget_input')) {
                        $file_tmp = "access_deny.htm";                   
                    } else {
                        $db->query("delete from budget_invoices where bin_id='" . $action->eda_id . "'");
                        $return_url = unserialize($sessions->get_session('return_url'));
                        page_transfer("Thực hiện xoá phiếu chi thành công", $return_url['budget_report']);
                        $transfer = true;
                        $file_tmp = "finance/view_budget_output.htm";
                    }
                    break;
                case md5('budget_report') :
                    $return_url['budget_report'] = "?" . $_SERVER['QUERY_STRING'];
                    $action->eda_decode = "budget_report";
                    $sessions->set_session('return_url', serialize($return_url));
                    $action->title = "Báo cáo Thu/Chi";
                    $file_tmp = "finance/budget_report.htm";
                    break;
                case md5('load_debtsum') :
                    include ("bms/templates/finance/debtsum_" . $return_val ['debt_type'] . ".htm");
                    break;
                case md5('debtsum') :
                    $action->title = "Thống kê công nợ";
                    $file_tmp = "finance/debtsum.htm";
                    break;
                case md5('debt_cus') :
                    $action->title = "Công nợ khách hàng";
                    $action->eda_decode = "debt_cus";
                    $file_tmp = "finance/debt_cus.htm";
                    break;
                case md5('debt_sup') :
                    $action->title = "Công nợ nhà cung cấp";
                    $action->eda_decode = "debt_sup";
                    $file_tmp = "finance/debt_sup.htm";
                    break;
                case md5('debt_sup_all') :
                    $action->title = "Công nợ tất cả nhà cung cấp";
                    $action->eda_decode = "debt_sup_all";
                    $file_tmp = "finance/debt_sup_all.htm";
                    break;
                case md5('debt_emp') :
                    $action->title = "Công nợ nhân viên";
                    $action->eda_decode = "debt_emp";
                    $file_tmp = "finance/debt_emp.htm";
                    break;
                case md5("get_sup_debt") :
                    if ($return_val['budget_type'] == 'VAY') {
                        $sup_debt = get_data("select sum_in.total-IFNULL(sum_bin.total,0) as total from 
						(select sti_inv.sup_id, sum(sti_inv.total) total from  
							(select bin.sup_id, sum(amount) as total from budget_invoices bin, item_type itt where bin.bin_type=0 and bin.item_id=itt.item_id and itt.item_type=0 and itt.budget_type='VAY'  and bin.sup_id='" . $action->eda_id . "' group by bin.sup_id) sti_inv group by sti_inv.sup_id
						) sum_in
						left join (select bin.sup_id, sum(IFNULL(bin.amount,0)) as total from budget_invoices bin, item_type itt where bin.bin_type=1 and bin.item_id=itt.item_id and itt.item_type=1 and itt.budget_type='VAY' and bin.sup_id='" . $action->eda_id . "' group by bin.sup_id) sum_bin
						on sum_in.sup_id=sum_bin.sup_id	inner join 	supliers sup on sup.sup_id=sum_in.sup_id where IFNULL(sum_in.total,0)!=IFNULL(sum_bin.total,0) and sup.sup_id='" . $action->eda_id . "'");
                    } else {
                        $sup_debt = get_data("select sum_in.total-IFNULL(sum_bin.total,0)-IFNULL(sum_return.amount,0) as total from 
						(select sti_inv.sup_id, sum(sti_inv.total) total from  
							(select inv.sup_id, sum(inv.total) as total from invoices inv where ifnull(draft,0)=0 and inv_type=1 and inv.sup_id='" . $action->eda_id . "' group by inv.sup_id) sti_inv group by sti_inv.sup_id
						) sum_in
						left join (select bin.sup_id, sum(IFNULL(bin.amount,0)) as total from budget_invoices bin, item_type itt where ((bin.bin_type=1 and bin.item_id=itt.item_id and itt.item_type=1 and itt.budget_type='CN')) and bin.sup_id='" . $action->eda_id . "' group by bin.sup_id) sum_bin
						on sum_in.sup_id=sum_bin.sup_id	
                                                left join (select inv.sup_id, sum(IFNULL(inv.total,0)) amount from mat_return_invoices inv where inv.paid_type=1 group by inv.sup_id) sum_return
                                                on sum_in.sup_id=sum_return.sup_id
                                                inner join supliers sup on sup.sup_id=sum_in.sup_id where IFNULL(sum_in.total,0)!=IFNULL(sum_bin.total,0) and sup.sup_id='" . $action->eda_id . "'");
                    }
                    $debt = get_data("select debt from supliers where sup_id='" . $action->eda_id . "'");
                    if (count($sup_debt) > 0)
                        echo $sup_debt [0] [0] + $debt[0][0];
                    else
                        echo $debt[0][0];
                    break;
                case md5("load_debt_cus") :
                    include ("bms/templates/finance/debt_cus_inv.htm");
                    break;
                case md5("load_debt_sup") :
                    include ("bms/templates/finance/debt_sup_inv.htm");
                    break;
                case md5("load_debt_sup_all") :
                    include ("bms/templates/finance/debt_sup_all_inv.htm");
                    break;
                case md5("load_debt_emp") :
                    include ("bms/templates/finance/debt_emp_inv.htm");
                    break;
                case md5("interest_sum") :
                    $action->title = "Báo cáo lãi/lỗ";
                    $action->eda_decode = "interest_sum";
                    $file_tmp = "finance/interest_sum.htm";
                    break;
                case md5('move_fund') :
                    $action->title = "Lập phiếu chuyển Quỹ/Tài khoản";
                    $action->eda_decode = "move_fund";
                    $max_bin = get_data("select max(inv_id) from fund_invoices");
                    $return_val ['inv_code'] = (isset($head['CQ_code'])?$head['CQ_code']:'CQ') . str_pad($max_bin [0] [0] + 1, 8, '0', STR_PAD_LEFT);
                    $file_tmp = "finance/move_fund.htm";
                    break;
                case md5('move_fund_sm') :
                    $this->move_fund_sm();
                    $action->eda_decode = "move_fund";
                    if (empty($err_msg)) {
                        $bin_id = get_data("select max(inv_id) from fund_invoices");
                        page_transfer("Lưu phiếu chuyển Quỹ/Tài khoản thành công", "?eda_act=" . md5("finance") . "&eda_code=" . md5("move_fund_view") . "&eda_id=" . $bin_id [0] [0]);
                        $transfer = true;
                    }
                    $file_tmp = "finance/move_fund.htm";
                    break;
                case md5('move_fund_view') :
                    $action->title = "Xem phiếu chuyển Quỹ/Tài khoản";
                    $action->eda_decode = "move_fund";
                    $file_tmp = "finance/move_fund_view.htm";
                    break;
                    case md5('baocao') :
                    $action->eda_decode = "fund_invoices";
                    $action->title = "Dòng tiền Quỹ/Tài khoản";
                    $return_url['fund_invoices'] = "?" . $_SERVER['QUERY_STRING'];
                    $sessions->set_session('return_url', serialize($return_url));
                    $file_tmp = "finance/baocao.htm";
                    break;
                    case md5('bc_vat') :
                    
                    $action->eda_decode = "bc_vat";
                    $action->title = "Báo Cáo Khoản VAT";
                    $return_url['bc_vat'] = "?" . $_SERVER['QUERY_STRING'];
                    $sessions->set_session('return_url', serialize($return_url));
                    $file_tmp = "finance/bc_vat.htm";
                    break;
                case md5('fund_invoices') :
                    $action->eda_decode = "fund_invoices";
                    $action->title = "Thống kê chuyển Quỹ/Tài khoản";
                    $return_url['fund_invoices'] = "?" . $_SERVER['QUERY_STRING'];
                    $sessions->set_session('return_url', serialize($return_url));
                    $file_tmp = "finance/fund_invoices.htm";
                    break;
                case md5('fund_invoices_del') :
                    $inv = get_data("select * from fund_invoices where inv_id='" . $action->eda_id . "'");
                    $action->eda_decode = "fund_invoices";
                    if (!check_func('del_movefund')) {
                        $file_tmp = "access_deny.htm";                   
                    } else if (count($inv) > 0) {
                        $db->query("update fund set sum=sum+" . $inv[0]['amount'] . " where fund_id='" . $inv[0]['fund_from'] . "'");
                        $db->query("update fund set sum=sum-" . $inv[0]['amount'] . " where fund_id='" . $inv[0]['fund_to'] . "'");
                        $db->query("delete from fund_invoices where inv_id='" . $action->eda_id . "'");
                        $return_url = unserialize($sessions->get_session('return_url'));
                        page_transfer("Thực hiện xoá phiếu giao dịch  thành công", $return_url['fund_invoices']);
                        $transfer = true;
                    }
                    $file_tmp = "finance/view_budget_input.htm";
                    break;
                case md5('fund_invoices_edit') :
                    $action->title = "Sửa phiếu chuyển Quỹ/Tài khoản";
                    $action->eda_decode = "fund_invoices";
                    $return_val = get_data("select * from fund_invoices where inv_id='" . $action->eda_id . "'");
                    if (!check_func('edit_movefund')) {
                        $file_tmp = "access_deny.htm";                   
                    } else if (count($return_val) > 0) {
                        $return_val = $return_val[0];
                    } else {
                        $return_url = unserialize($sessions->get_session('return_url'));
                        page_transfer("Không tìm thấy phiếu cần sửa", $return_url['fund_invoices']);
                        $transfer = true;
                    }
                    $file_tmp = "finance/move_fund_edit.htm";
                    break;
                case md5('fund_invoices_edit_sm') :
                    $this->move_fund_edit();
                    $action->eda_decode = "fund_invoices";
                    if (empty($err_msg)) {
                        $return_url = unserialize($sessions->get_session('return_url'));
                        page_transfer("Thực hiện sửa phiếu giao dịch  thành công", $return_url['fund_invoices']);
                        $transfer = true;
                    }
                    $file_tmp = "finance/move_fund_edit.htm";
                    break;
            }
        }
    }

    function budget_input_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time();
        $return_val ['amount']=numR(@$return_val ['amount']);
        if (empty($return_val ['fund_id']) || empty($return_val ['item_id']) || empty($return_val ['amount']) || empty($return_val ['user_id']) || (empty($return_val ['cus_name']) && empty($return_val ['emp_id'])) || empty($return_val ['bin_code']))
            $err_msg = "Vui lòng nhập đầy đủ thông tin bắt buộc (*)";
        else {
            $chk = get_data("select bin_id from budget_invoices where bin_code='" . $return_val ['bin_code'] . "'");
            if (count($chk) > 0) {
                $err_msg = "Mã phiếu này đã tồn tại trên hệ thống";
            } else {
                if ($return_val ['budget_type'] == "CN") {
                    if (empty($return_val ['cus_id']))
                        $err_msg = "Hãy chọn người nộp tiền từ danh sách";
                    else {
                        $sqls="insert into budget_invoices(created_user, user_id, created_date, item_id, bin_code, cus_id, amount, comment, bin_type, fund_id)
                                    values('" . $sessions->get_session('user_id') . "','" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['item_id'] . "','" . $return_val ['bin_code'] . "','" . $return_val ['cus_id'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "',0,'" . $return_val['fund_id'] . "')";
                        if(intval(@$return_val['inv_id'])>0){
                            $chkinv = get_data("select * from out_invoices where inv_id='" . intval($return_val['inv_id']) . "'");
                            if(count(@$chkinv)>0){
                                $item_type = get_data("select item_id from item_type where budget_type='BH' and item_type=0");
                                $sqls="insert into budget_invoices(user_id, created_user, created_date, item_id, bin_code, cus_id, amount, comment, bin_type, oinv_id, fund_id)
                                values('" . $return_val ["user_id"] . "', '" . $sessions->get_session('user_id') . "','" . $created_date . "','" . $item_type [0] [0] . "','" . $return_val ['bin_code'] . "','" . $return_val ['cus_id'] . "','" . $return_val['amount'] . "','" . "Nộp tiền bán hàng phiếu " . @$chkinv[0]['inv_code'] . "',0,'" . $chkinv[0]['inv_id'] . "'," . $return_val['fund_id'] . ")";
                                $db->query("update out_invoices set payment=payment+" . floatval($return_val['amount']) . " where payment<total and inv_id=" . $chkinv[0]['inv_id']);
                            }
                        }
                        else
                        {
                        $db->query($sqls);
                        $bin_id=$db->insert_id();
                        $db->query("update fund set sum=sum+" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
$tongtien=floatval($return_val['amount']);
$chkinv=array(1);
while(is_array($chkinv) && count($chkinv)>0 && $tongtien>0){
    $chkinv = get_data("select (total-payment) cantra,inv_id from out_invoices where total>payment and cus_id='" . $return_val ['cus_id'] . "' order by created_date asc limit 1");
    if(count(@$chkinv)>0){
        foreach ($chkinv as $key => $inv) {
            if($tongtien>floatval($inv['cantra']))
                $tongtien=$tongtien-floatval($inv['cantra']);
            else
            { 
                $inv['cantra']=$tongtien;
                $tongtien=0;
            }
            $item_type = get_data("select item_id from item_type where budget_type='BH' and item_type=0");                     
            $db->query("update out_invoices set payment=payment+" . floatval($inv['cantra']) . " where payment<total and inv_id=" . $inv['inv_id']);
            $db->query("insert into budget_invoice_details(bin_id,item_id,item_type,doituong,price) values (".$bin_id.",".$inv['inv_id'].",'inv_id','out_invoices',".$inv['cantra'].")");
        }
    }
}



                        }
                        
                    }
                } else if ($return_val ['budget_type'] == "GC") {
                    if (empty($return_val ['emp_id']))
                        $err_msg = "Hãy chọn người nộp tiền từ danh sách";
                    else {
                        $db->query("insert into budget_invoices(created_user, user_id, created_date, item_id, bin_code, emp_id, amount, comment, bin_type, fund_id)
									values('" . $sessions->get_session('user_id') . "','" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['item_id'] . "','" . $return_val ['bin_code'] . "','" . $return_val ['emp_id'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "',0,'" . $return_val['fund_id'] . "')");
                        $db->query("update fund set sum=sum+" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                    }
                } else if ($return_val ['budget_type'] == "VAY") {
                    if (empty($return_val ['cus_id']))
                        $err_msg = "Hãy chọn người nộp tiền từ danh sách";
                    else {
                        $db->query("insert into budget_invoices(created_user, user_id, created_date, item_id, bin_code, sup_id, amount, comment, bin_type, fund_id)
									values('" . $sessions->get_session('user_id') . "','" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['item_id'] . "','" . $return_val ['bin_code'] . "','" . $return_val ['cus_id'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "',0,'" . $return_val['fund_id'] . "')");
                        $db->query("update fund set sum=sum+" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                    }
                } else {
                    $db->query("insert into budget_invoices(created_user, user_id, created_date, item_id, bin_code, user_name, amount, comment, bin_type, fund_id)
								values('" . $sessions->get_session('user_id') . "','" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['item_id'] . "','" . $return_val ['bin_code'] . "','" . $return_val ['cus_name'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "',0,'" . $return_val['fund_id'] . "')");
                    $db->query("update fund set sum=sum+" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                }
                insertlog("Lập phiếu thu ". $return_val ['bin_code']);
            }
        }
    }

    function edit_budget_input_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time();
            $return_val['amount']=numR(@$return_val['amount']);
        if (empty($return_val ['fund_id']) || empty($return_val ['item_id']) || empty($return_val ['amount']) || empty($return_val ['user_id']) || (empty($return_val ['cus_name']) && empty($return_val ['emp_id'])) || empty($return_val ['bin_code']))
            $err_msg = "Vui lòng nhập đầy đủ thông tin bắt buộc (*)";
        else {
            if ($return_val ['budget_type'] == "CN") {
                if (empty($return_val ['cus_id']))
                    $err_msg = "Hãy chọn người nộp tiền từ danh sách";
                else {
                        $binds=get_data("select * from budget_invoice_details where bin_id='" . $action->eda_id . "'");
                        foreach ($binds as $key => $bind) {
                            switch ($bind['doituong']) {
                                case 'out_invoices':
                                    $db->query("update out_invoices set payment=payment-{$bind['price']} where inv_id='" . $bind['item_id'] . "'");
                                    break;
                                case 'invoices':
                                    $db->query("update invoices set payment=payment-{$bind['price']} where inv_id='" . $bind['item_id'] . "'");
                                    break;
                            }
                        }
                    $db->query("delete from budget_invoice_details where bin_id='" . $action->eda_id . "'");
                    $fund = get_data("select fund_id, amount from budget_invoices where  bin_id='" . $action->eda_id . "'");
                    $db->query("update fund set sum=sum-" . intval($fund [0]['amount']) . " where fund_id=" . $fund[0]['fund_id']);
                    $db->query("update budget_invoices set user_id='" . $return_val ['user_id'] . "', created_date='" . $created_date . "', item_id='" . $return_val ['item_id'] . "', bin_code='" . $return_val ['bin_code'] . "', 
								sup_id=null, emp_id=null, cus_id='" . $return_val ['cus_id'] . "', user_name=null, fund_id='" . $return_val['fund_id'] . "', amount='" . $return_val ['amount'] . "', comment='" . $return_val ['comment'] . "' where bin_id='" . $action->eda_id . "'");
                    $db->query("update fund set sum=sum+" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                    $bin_id=$action->eda_id;
                    $tongtien=floatval($return_val['amount']);
                    $chkinv=array(1);
                    while(is_array($chkinv) && count($chkinv)>0 && $tongtien>0){
                        $chkinv = get_data("select (total-payment) cantra,inv_id from out_invoices where total>payment and cus_id='" . $return_val ['cus_id'] . "' order by created_date asc limit 1");
                        if(count(@$chkinv)>0){
                            foreach ($chkinv as $key => $inv) {
                                if($tongtien>floatval($inv['cantra']))
                                    $tongtien=$tongtien-floatval($inv['cantra']);
                                else
                                { 
                                    $inv['cantra']=$tongtien;
                                    $tongtien=0;
                                }
                                $item_type = get_data("select item_id from item_type where budget_type='BH' and item_type=0");                     
                                $db->query("update out_invoices set payment=payment+" . floatval($inv['cantra']) . " where payment<total and inv_id=" . $inv['inv_id']);
                                $db->query("insert into budget_invoice_details(bin_id,item_id,item_type,doituong,price) values (".$bin_id.",".$inv['inv_id'].",'inv_id','out_invoices',".$inv['cantra'].")");
                            }
                        }
                    }
                }
            } else if ($return_val ['budget_type'] == "GC") {
                if (empty($return_val ['emp_id']))
                    $err_msg = "Hãy chọn người nộp tiền từ danh sách";
                else {
                    $fund = get_data("select fund_id, amount from budget_invoices where  bin_id='" . $action->eda_id . "'");
                    $db->query("update fund set sum=sum-" . intval($fund [0]['amount']) . " where fund_id=" . $fund[0]['fund_id']);
                    $db->query("update budget_invoices set user_id='" . $return_val ['user_id'] . "', created_date='" . $created_date . "', item_id='" . $return_val ['item_id'] . "', bin_code='" . $return_val ['bin_code'] . "', 
								sup_id=null, emp_id='" . $return_val ['cus_id'] . "', cus_id=null, user_name=null, fund_id='" . $return_val['fund_id'] . "', amount='" . $return_val ['amount'] . "', comment='" . $return_val ['comment'] . "' where bin_id='" . $action->eda_id . "'");
                    $db->query("update fund set sum=sum+" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                }
            } else if ($return_val ['budget_type'] == "VAY") {
                if (empty($return_val ['cus_id']))
                    $err_msg = "Hãy chọn người nộp tiền từ danh sách";
                else {
                    $fund = get_data("select fund_id, amount from budget_invoices where  bin_id='" . $action->eda_id . "'");
                    $db->query("update fund set sum=sum-" . intval($fund [0]['amount']) . " where fund_id=" . $fund[0]['fund_id']);
                    $db->query("update budget_invoices set user_id='" . $return_val ['user_id'] . "', created_date='" . $created_date . "', item_id='" . $return_val ['item_id'] . "', bin_code='" . $return_val ['bin_code'] . "', 
								sup_id='" . $return_val ['cus_id'] . "', emp_id=null, cus_id=null, user_name=null, fund_id='" . $return_val['fund_id'] . "', amount='" . $return_val ['amount'] . "', comment='" . $return_val ['comment'] . "' where bin_id='" . $action->eda_id . "'");
                    $db->query("update fund set sum=sum+" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                }
            } else {
                $fund = get_data("select fund_id, amount from budget_invoices where  bin_id='" . $action->eda_id . "'");
                $db->query("update fund set sum=sum-" . intval($fund [0]['amount']) . " where fund_id=" . $fund[0]['fund_id']);
                $db->query("update budget_invoices set user_id='" . $return_val ['user_id'] . "', created_date='" . $created_date . "', item_id='" . $return_val ['item_id'] . "', bin_code='" . $return_val ['bin_code'] . "', 
								sup_id=null, emp_id=null, cus_id=null, fund_id='" . $return_val['fund_id'] . "', user_name='" . $return_val ['cus_name'] . "', amount='" . $return_val ['amount'] . "', comment='" . $return_val ['comment'] . "' where bin_id='" . $action->eda_id . "'");
                $db->query("update fund set sum=sum+" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
            }
            insertlog("Sửa phiếu thu ". $return_val ['bin_code']);
        }
    }

    function budget_output_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time();
            $return_val['amount']=numR(@$return_val['amount']);
        if (empty($return_val ['fund_id']) || empty($return_val ['item_id']) || empty($return_val ['amount']) || empty($return_val ['user_id']) || empty($return_val ['cus_name']) || empty($return_val ['bin_code']))
            $err_msg = "Vui lòng nhập đầy đủ thông tin bắt buộc (*)";
        else {
            $chk = get_data("select bin_id from budget_invoices where bin_code='" . $return_val ['bin_code'] . "'");
            if (count($chk) > 0) {
                $err_msg = "Mã phiếu này đã tồn tại trên hệ thống";
            } else {
                $chkitem = get_data("select * from item_type where item_id='" . $return_val ['item_id'] . "'");
                if ($return_val ['budget_type'] == "CN" || $return_val ['budget_type'] == "VAY") {
                    if (empty($return_val ['cus_id']))
                        $err_msg = "Hãy chọn người nhận tiền từ danh sách";
                    else {
                        $db->query("insert into budget_invoices(created_user, user_id, created_date, item_id, bin_code, sup_id, amount, comment, bin_type, fund_id)
									values('" . $sessions->get_session('user_id') . "','" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['item_id'] . "','" . $return_val ['bin_code'] . "','" . $return_val ['cus_id'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "',1,'" . $return_val ['fund_id'] . "')");
                        $db->query("update fund set sum=sum-" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                    }
                }
                else
if (@$chkitem[0]['item_name'] == "Đóng VAT") {
                    if (empty($return_val ['inv_id']))
                        $err_msg = "Hãy chọn đơn hàng";
                    else {
                        $db->query("insert into budget_invoices(created_user, user_id, created_date, item_id, bin_code, amount, comment, bin_type, fund_id,oinv_id)
                                    values('" . $sessions->get_session('user_id') . "','" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['item_id'] . "','" . $return_val ['bin_code'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "',1,'" . $return_val ['fund_id'] . "','" . $return_val ['inv_id'] . "')");
                        $db->query("update fund set sum=sum-" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                    }
                }
                else
if (@$chkitem[0]['item_name'] == "Chi Phụ Phí Đơn Hàng") {
                    if (empty($return_val ['inv_id']))
                        $err_msg = "Hãy chọn đơn hàng";
                    else {
                        $db->query("insert into budget_invoices(created_user, user_id, created_date, item_id, bin_code, amount, comment, bin_type, fund_id,oinv_id)
                                    values('" . $sessions->get_session('user_id') . "','" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['item_id'] . "','" . $return_val ['bin_code'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "',1,'" . $return_val ['fund_id'] . "','" . $return_val ['inv_id'] . "')");
                        $db->query("update fund set sum=sum-" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                    }
                }
                else {
                    $db->query("insert into budget_invoices(created_user, user_id, created_date, item_id, bin_code, user_name, amount, comment, bin_type, fund_id)
								values('" . $sessions->get_session('user_id') . "','" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['item_id'] . "','" . $return_val ['bin_code'] . "','" . $return_val ['cus_name'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "',1,'" . $return_val ['fund_id'] . "')");
                    $db->query("update fund set sum=sum-" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                    insertlog("Lập phiếu chi ". $return_val ['bin_code']);
                }
            }
        }
    }

    function edit_budget_output_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time();
            $return_val['amount']=numR(@$return_val['amount']);
        if (empty($return_val ['fund_id']) || empty($return_val ['item_id']) || empty($return_val ['amount']) || empty($return_val ['user_id']) || empty($return_val ['cus_name']) || empty($return_val ['bin_code']))
            $err_msg = "Vui lòng nhập đầy đủ thông tin bắt buộc (*)";
        else {
            if ($return_val ['budget_type'] == "CN") {
                if (empty($return_val ['cus_id']))
                    $err_msg = "Hãy chọn người nhận tiền từ danh sách";
                else {
                    $fund = get_data("select fund_id, amount from budget_invoices  where bin_id='" . $action->eda_id . "'");
                    $db->query("update fund set sum=sum+" . intval($fund [0]['amount']) . " where fund_id=" . $fund[0]['fund_id']);
                    $db->query("update budget_invoices set user_id='" . $return_val ['user_id'] . "', created_date='" . $created_date . "', item_id='" . $return_val ['item_id'] . "', bin_code='" . $return_val ['bin_code'] . "', 
								sup_id='" . $return_val ['cus_id'] . "', user_name=null, fund_id='" . $return_val['fund_id'] . "', amount='" . $return_val ['amount'] . "', comment='" . $return_val ['comment'] . "' where bin_id='" . $action->eda_id . "'");
                    $db->query("update fund set sum=sum-" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
                }
            } else {
                $fund = get_data("select fund_id, amount from budget_invoices  where bin_id='" . $action->eda_id . "'");
                $db->query("update fund set sum=sum+" . intval($fund [0]['amount']) . " where fund_id=" . $fund[0]['fund_id']);
                $db->query("update budget_invoices set user_id='" . $return_val ['user_id'] . "', created_date='" . $created_date . "', item_id='" . $return_val ['item_id'] . "', bin_code='" . $return_val ['bin_code'] . "', 
								sup_id=null, user_name='" . $return_val ['cus_name'] . "', fund_id='" . $return_val['fund_id'] . "', amount='" . $return_val ['amount'] . "', comment='" . $return_val ['comment'] . "' where bin_id='" . $action->eda_id . "'");
                $db->query("update fund set sum=sum-" . intval($return_val ['amount']) . " where fund_id=" . $return_val['fund_id']);
            }
            insertlog("Sửa phiếu chi ". $return_val ['bin_code']);
        }
    }

    function move_fund_sm() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time();
        if (empty($return_val ['fund_from']) || empty($return_val ['fund_to']) || empty($return_val ['amount']) || empty($return_val ['user_id']) || empty($return_val ['inv_code']))
            $err_msg = "Vui lòng nhập đầy đủ thông tin bắt buộc (*)";
        else if ($return_val ['fund_from'] == $return_val ['fund_to']) {
            $err_msg = "Bạn không thể chuyển trên cùng một tài khoản";
        } else {
            $chk = get_data("select inv_id from fund_invoices where inv_code='" . $return_val ['inv_code'] . "'");
            if (count($chk) > 0) {
                $err_msg = "Mã phiếu này đã tồn tại trên hệ thống";
            } else {
                /* $chk=get_data("select sum from fund where fund_id='".$return_val['fund_from']."'");
                  if($chk[0]['sum']<$return_val['amount']) {
                  $err_msg = "Quỹ/Tài khoản không đủ để chuyển đi";
                  } else { */
                $db->query("insert into fund_invoices(user_id, created_date, fund_from, fund_to, inv_code, amount, comment)
					values('" . $return_val ['user_id'] . "','" . $created_date . "','" . $return_val ['fund_from'] . "','" . $return_val ['fund_to'] . "','" . $return_val ['inv_code'] . "','" . $return_val ['amount'] . "','" . $return_val ['comment'] . "')");
                $db->query("update fund set sum=sum-" . $return_val['amount'] . " where fund_id='" . $return_val['fund_from'] . "'");
                $db->query("update fund set sum=sum+" . $return_val['amount'] . " where fund_id='" . $return_val['fund_to'] . "'");
                insertlog("Chuyển quỹ/tài khoản ". $return_val ['inv_code']);
                //}
            }
        }
    }

    function move_fund_edit() {
        global $err_msg, $db, $info, $sessions, $return_val, $action;
        $sdate = explode("/", $return_val ["date"]);
        if ($sdate [0] > 0 && $sdate [0] <= 31 && $sdate [1] > 0 && $sdate [1] <= 12 && $sdate [2] <= date('Y')) {
            $sdate = mktime($return_val ["hour"], $return_val ["minute"], date('i'), $sdate [1], $sdate [0], $sdate [2]);
            $created_date = $sdate;
        } else
            $created_date = time();
        if (empty($return_val ['fund_from']) || empty($return_val ['fund_to']) || empty($return_val ['amount']) || empty($return_val ['user_id']) || empty($return_val ['inv_code']))
            $err_msg = "Vui lòng nhập đầy đủ thông tin bắt buộc (*)";
        else if ($return_val ['fund_from'] == $return_val ['fund_to']) {
            $err_msg = "Bạn không thể chuyển trên cùng một tài khoản";
        } else {
            /* $chk=get_data("select sum from fund where fund_id='".$return_val['fund_from']."'");
              if($chk[0]['sum']<$return_val['amount']) {
              $err_msg = "Quỹ/Tài khoản không đủ để chuyển đi";
              } else { */
            $inv = get_data("select * from fund_invoices where inv_id='" . $action->eda_id . "'");
            if (count($inv) > 0) {
                $db->query("update fund set sum=sum+" . $inv[0]['amount'] . " where fund_id='" . $inv[0]['fund_from'] . "'");
                $db->query("update fund set sum=sum-" . $inv[0]['amount'] . " where fund_id='" . $inv[0]['fund_to'] . "'");
            }
            $db->query("update fund_invoices set user_id='" . $return_val ['user_id'] . "', created_date='" . $created_date . "', fund_from='" . $return_val ['fund_from'] . "', 
				fund_to='" . $return_val ['fund_to'] . "', inv_code='" . $return_val ['inv_code'] . "', amount='" . $return_val ['amount'] . "', comment='" . $return_val ['comment'] . "' where inv_id='" . $action->eda_id . "'");
            $db->query("update fund set sum=sum-" . $return_val['amount'] . " where fund_id='" . $return_val['fund_from'] . "'");
            $db->query("update fund set sum=sum+" . $return_val['amount'] . " where fund_id='" . $return_val['fund_to'] . "'");
            insertlog("Sửa chuyển quỹ/tài khoản ". $return_val ['inv_code']);
            //}
        }
    }

}

?>
