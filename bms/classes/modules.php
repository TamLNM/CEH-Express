<?php
class modules {

    function modules() {
        
    }
    function safe_str($str) {
        $str=str_replace("'", "&#39;", $str);
        $str=str_replace("\"", "&#34;", $str);
       return $str;
    }
    function run() {
        global $action, $file_tmp, $transfer, $sessions, $return_val, $err_msg, $info;
        while (list ( $key, $val ) = each($_POST))
        {
            if(!is_array($val))
            {
                $return_val[$key] = preg_replace("/(?<!\\\\)'/", "\'", $val);
            }
            if(is_array($val))
            {
                $return_val[$key]=$this->safe_str($_POST[$key]);
                //$_POST[$key]=$return_val[$key];
            }
        }
        while (list ( $key, $val ) = each($_GET))
        {
            if(!is_array($val))
            {
                $return_val[$key] = preg_replace("/(?<!\\\\)'/", "\'", $val);
            }
            if(is_array($val))
            {
                $return_val[$key]=$this->safe_str($_GET[$key]);
                //$_GET[$key]=$return_val[$key];
            }
        }
        $transfer = false;
        $_SESSION ["validate"] = "yes";
        switch ($action->eda_code) {
            case md5("login") :
                $uname = isset($_POST ["user_name"]) ? $_POST ["user_name"] : "";
                $passwrd = isset($_POST ["pass"]) ? $_POST ["pass"] : "";
                include ("bms/modules/login.php");
                $login = new login ( );
                $err = $login->execute('in', $uname, $passwrd, 'admin');
                if ($err != "") {
                    page_transfer('Lỗi: ' . $err, '?');
                    $transfer = true;
                }
                $file_tmp = "welcome.htm";
                break;
            case md5("logout") :
                $uname = isset($_POST ["user_name"]) ? $_POST ["user_name"] : "";
                $passwrd = isset($_POST ["pass"]) ? $_POST ["pass"] : "";
                include ("bms/modules/login.php");
                $login = new login ( );
                $login->execute('out', $uname, $passwrd, 'admin');
                //exec("mysqldump -h ".$info['db_host']." -u ".$info['db_username']." -p".$info['db_password']." ".$info['db_name']."|gzip>".(empty($sessions->session_prefix)?"":"users/".$sessions->session_prefix."/")."db/bms_".date('Ymd',time()).".sql.gz");
                page_transfer('Đang thoát khỏi hệ thống', '?');
                $transfer = true;
                $path = explode('/', $action->script);
                if (isset($path[2])){
                    $user = $path[2];
                    if (!file_exists(ROOT_DIR . "bms/tmp/backuplist/" . $user)) {
                        $f = fopen(ROOT_DIR . "bms/tmp/backuplist/" . $user, "w");
                        fwrite($f, $info['db_name']);
                        fclose($f);
                    }
                }
                break;
                
            default :
                $has = $this->child_run();
                break;
        }
        if ($action->eda_type != 'ajax' && $transfer == false) {
            $this->draw_head();
            $mnu = get_data("select count(*) c from function_menu fmenu, user_group_permission ugp where fmenu.fmenu_id=ugp.fmenu_id  and ugp.user_id='" . $sessions->get_session('user_id') . "' order by order_by");
            if ($mnu[0]['c'] > 0) {
                $fmenu = get_data("select fmenu.fmenu_id from user_group_permission ugp, function_menu fmenu where fmenu.fmenu_act='" . $action->eda_decode . "' and ugp.fmenu_id=fmenu.fmenu_id and ugp.user_id='" . $sessions->get_session('user_id') . "' limit 1");
            } else {
                $fmenu = get_data("select fmenu.fmenu_id from user_group_permission ugp, function_menu fmenu where fmenu.fmenu_act='" . $action->eda_decode . "' and ugp.fmenu_id=fmenu.fmenu_id and ugp.group_id='" . $sessions->get_session('group_id') . "' limit 1");
            }
            if (count($fmenu) == 0 && !empty($action->eda_decode) && $sessions->get_session('user_name') != 'admin') {
                $file_tmp = "access_deny.htm";
            }
            include ("bms/templates/homepage.htm");
            $this->draw_footer();
        }
    }

    function draw_head() {
        global $language, $action, $sessions, $skin, $info, $kinds;
        include ("bms/templates/header.htm");
    }

    function draw_footer() {
        global $language, $action, $sessions, $skin, $kinds;
        include ("bms/templates/footer.htm");
    }

    function run_sub_module() {
        
    }

    function child_run() {
        $this->draw_head();
        $this->draw_center();
        $this->draw_footer();
        return false;
    }

    function draw_center() {
        global $action, $info, $sessions, $language, $info;
        include ("bms/templates/login.htm");
    }

    function get_instock($mat, $todate, $stock_id=0) {
        //global $db;
        return get_instock($mat, $todate, $stock_id);
    }
    function get_emp_debt($uid,$d=0) {
        $sum=0;
        $out= get_data("select sum(bin.amount) amount from budget_invoices bin, fund f where bin.bin_type=0 and bin.cus_id is not null and bin.fund_id=f.fund_id and f.user_id=$uid".(!empty($d)?' and bin.created_date<'.$d:''));
        if(count($out)>0) {
            $sum+=$out[0]['amount'];
        } 
        $out= get_data("select sum(finv.amount) amount from fund_invoices finv, fund f where finv.fund_from=f.fund_id and f.user_id=$uid".(!empty($d)?' and finv.created_date<'.$d:''));
        if(count($out)>0) {
            $sum-=$out[0]['amount'];
        }    
        $out= get_data("select sum(finv.amount) amount from fund_invoices finv, fund f where finv.fund_to=f.fund_id and f.user_id=$uid".(!empty($d)?' and finv.created_date<'.$d:''));
        if(count($out)>0) {
            $sum+=$out[0]['amount'];
        }
        return $sum;
    }    
    function get_cus_debt($uid,$d=0) {
        $debt=get_data("select sum(IFNULL(total,0)) amount  from out_invoices where ifnull(draft,0)=0 ".(!empty($d)?' and created_date<'.$d:'')." group by cus_id  having cus_id='".$uid."'");
	$debt2=get_data("select  sum(IFNULL(bin.amount,0)) amount from budget_invoices bin where (bin.bin_type=0) ".(!empty($d)?' and bin.created_date<'.$d:'')." group by bin.cus_id having cus_id='".$uid."'");
        $debt3=get_data("select sum(IFNULL(total,0)) amount  from mat_return_invoices where paid_type=1 ".(!empty($d)?' and created_date<'.$d:'')." group by cus_id  having cus_id='".$uid."'");
        $debt4=get_data("select sum(IFNULL(cn.price,0)) amount  from congno cn,out_invoices inv where inv.payment<inv.total and inv.inv_id=cn.inv_id and cn.type_of=1 ".(!empty($d)?' and inv.created_date<'.$d:'')." group by target_id  having target_id='".$uid."'");
	if(count($debt)>0) {
		$debt=$debt[0][0];
	} else {
		$debt=0;
	}
	if(count($debt2)>0) {
		$debt-=$debt2[0][0];
	}
        if(count($debt3)>0) {
		$debt-=$debt3[0][0];
	}
    if(count($debt4)>0) {
        $debt+=$debt4[0][0];
    }
        return $debt;
    }
    
    function get_sup_debt($uid,$d=0) {
        $debt=get_data("select sum(IFNULL(i.amount,0)) amount from 
			(select inv.sup_id, sum(inv.total) amount from invoices inv where ifnull(inv.draft,0)=0 and inv.inv_type=1 and inv.sup_id='".$uid."' ".(!empty($d)?' and inv.created_date<'.$d:'')." group by inv.sup_id 
				union  select bin.sup_id, sum(bin.amount) amount from budget_invoices bin, item_type itt where bin.bin_type=0 ".(!empty($d)?' and bin.created_date<'.$d:'')." and bin.item_id=itt.item_id and itt.item_type=0 and itt.budget_type='VAY'   and bin.sup_id='".$uid."'  group by bin.sup_id
			) i group by i.sup_id");
	$debt2=get_data("select  sum(bin.amount) amount from budget_invoices bin, item_type itt where ((bin.bin_type=1 and bin.item_id=itt.item_id and itt.item_type=1 and itt.budget_type='VAY')  or (bin.bin_type=1 and bin.item_id=itt.item_id and itt.item_type=1 and itt.budget_type='CN') or (bin.bin_type=3 and bin.item_id=itt.item_id and itt.item_type=0 and itt.budget_type='CN' )) ".(!empty($d)?' and bin.created_date<'.$d:'')." and bin.sup_id='".$uid."' group by bin.sup_id");
        $debt3=get_data("select sum(IFNULL(total,0)) amount  from mat_return_invoices where paid_type=1 ".(!empty($d)?' and created_date<'.$d:'')." group by sup_id  having sup_id='".$uid."'");
	if(count($debt)>0) {
		$debt=$debt[0][0];
	} else {
		$debt=0;
	}
	if(count($debt2)>0) {
		$debt-=$debt2[0][0];
	}
        if(count($debt3)>0) {
		$debt-=$debt3[0][0];
	}
        return $debt;
    }
}