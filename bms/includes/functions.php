<?php
include("crm_insert.php");
function check_func($fn) {
    global $sessions;
    if ($sessions->get_session('user_name') == 'admin') {
        return true;
    } else {
        $fmenu = get_data("select fmenu.fmenu_id from user_group_permission ugp, function_menu fmenu where fmenu.fmenu_act='" . $fn . "' and ugp.fmenu_id=fmenu.fmenu_id and ugp.user_id='" . $sessions->get_session('user_id') . "' limit 1");
        if (count($fmenu) == 0) {
            $fmenu_chk = get_data("select fmenu.fmenu_id from user_group_permission ugp, function_menu fmenu where ugp.fmenu_id=fmenu.fmenu_id and ugp.user_id='" . $sessions->get_session('user_id') . "' limit 1");
            if (count($fmenu_chk) == 0) {
                $fmenu = get_data("select fmenu.fmenu_id from user_group_permission ugp, function_menu fmenu where fmenu.fmenu_act='" . $fn . "' and ugp.fmenu_id=fmenu.fmenu_id and ugp.group_id='" . $sessions->get_session('group_id') . "' limit 1");
            } else {
                $fmenu = array();
            }
        }
        if (count($fmenu) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
function getDebtCusId($cus_id,$date=0){
if($date==-1)$date=time();
    $cus=get_data("select * from customers where cus_id = '{$cus_id}'");
    if(is_array($cus) && count($cus)>0){
        $cus=$cus[0];
        $inv=get_data("select cus.cus_name,cus.debt,cus.max_debt,(select sum(cn.price) from congno cn where cn.target_id=cus.cus_id and cn.type_of=1 and cn.tg<=$date) notien,
        (select (sum(IFNULL(oinv.total,0)-IFNULL(oinv.payment,0))-IFNULL((select sum(IFNULL(binv.amount,0)) from budget_invoices binv where created_date<=$date and binv.cus_id=oinv.cus_id and binv.oinv_id is null),0)) from out_invoices oinv where oinv.created_date<=$date and oinv.cus_id=cus.cus_id and oinv.max_time<=".time().") quahan, 
        cus.cus_id,cus.address, cus.tel,IFNULL(sum_inv.amount,0) inv_amount,IFNULL(sum_inv.vat_price,0) vat_price,IFNULL(sum_bin.amount,0) bin_amount,IFNULL(sum_return.amount,0) return_amount, (IFNULL(sum_inv.amount,0)-IFNULL(sum_bin.amount,0)+cus.debt-IFNULL(sum_return.amount,0)) amount from customers cus
    left join (select inv.cus_id, sum(inv.total) amount, sum(inv.vat_price) vat_price  from out_invoices inv where inv.created_date<=$date and ifnull(inv.draft,0)=0  group by inv.cus_id) sum_inv  
    on cus.cus_id=sum_inv.cus_id
    left join (select bin.cus_id, sum(IFNULL(bin.amount,0)) amount from budget_invoices bin where bin.created_date<=$date and (bin.bin_type=0) group by bin.cus_id) sum_bin 
    on cus.cus_id=sum_bin.cus_id 
        left join (select inv.cus_id, sum(IFNULL(inv.total,0)) amount from mat_return_invoices inv where inv.created_date<=$date and inv.paid_type=1 group by inv.cus_id) sum_return
    on cus.cus_id=sum_return.cus_id
        where cus.cus_id={$cus['cus_id']} and IFNULL(sum_inv.amount,0)-IFNULL(sum_bin.amount,0)+cus.debt-IFNULL(sum_return.amount,0)!=0 and cus.cus_id='{$cus_id}'");
        $rt=array();
        $rt['debt_final']=(float)@$inv[0]['inv_amount']+(float)@$inv[0]['debt'];//tổng nợ
        $rt['paid']=(float)@(@$inv[0]['bin_amount']-@$inv[0]['return_amount']);//tổng trả
        $rt['total_outdate']=(float)@$inv[0]['quahan'];//tiền nợ quá hạn thanh toán
        $rt['total_sales']=(float)@$inv[0]['amount'];//tổng nợ trong kỳ
        $rt['debt_limit']=(float)@$inv[0]['max_debt'];//tổng tiền có thể nợ
        return $rt;
    }
    else
    {
        return false;
    }

}
function getDebtCusPSId($cus_id,$fdate=0,$todate=0){
if($fdate==-1)$fdate=time();
    $cus=get_data("select * from customers where cus_id = '{$cus_id}'");
    if(is_array($cus) && count($cus)>0){
        $cus=$cus[0];
        $inv=get_data("select cus.cus_name,cus.debt,cus.max_debt,(select sum(cn.price) from congno cn where cn.target_id=cus.cus_id and cn.type_of=1 and cn.tg>=$fdate and cn.tg<=$todate) notien,
        (select (sum(IFNULL(oinv.total,0)-IFNULL(oinv.payment,0))-IFNULL((select sum(IFNULL(binv.amount,0)) from budget_invoices binv where binv.created_date>=$fdate and binv.created_date<=$todate and binv.cus_id=oinv.cus_id and binv.oinv_id is null),0)) from out_invoices oinv where oinv.created_date>=$fdate and oinv.created_date<=$todate and oinv.cus_id=cus.cus_id and oinv.max_time<=".time().") quahan, 
        cus.cus_id,cus.address, cus.tel,IFNULL(sum_inv.amount,0) inv_amount,IFNULL(sum_inv.vat_price,0) vat_price,IFNULL(sum_bin.amount,0) bin_amount,IFNULL(sum_return.amount,0) return_amount, (IFNULL(sum_inv.amount,0)-IFNULL(sum_bin.amount,0)-IFNULL(sum_return.amount,0)) amount from customers cus
    left join (select inv.cus_id, sum(inv.total) amount, sum(inv.vat_price) vat_price  from out_invoices inv where inv.created_date>=$fdate and inv.created_date<=$todate and ifnull(inv.draft,0)=0  group by inv.cus_id) sum_inv  
    on cus.cus_id=sum_inv.cus_id
    left join (select bin.cus_id, sum(IFNULL(bin.amount,0)) amount from budget_invoices bin where bin.created_date>=$fdate and bin.created_date<=$todate and (bin.bin_type=0) group by bin.cus_id) sum_bin 
    on cus.cus_id=sum_bin.cus_id 
        left join (select inv.cus_id, sum(IFNULL(inv.total,0)) amount from mat_return_invoices inv where inv.created_date>=$fdate and inv.created_date<=$todate and inv.paid_type=1 group by inv.cus_id) sum_return
    on cus.cus_id=sum_return.cus_id
        where cus.cus_id='{$cus_id}'");
        $rt=array();
        $rt['debt_final']=(float)@$inv[0]['inv_amount'];//tổng nợ
        $rt['paid']=(float)@(@$inv[0]['bin_amount']-@$inv[0]['return_amount']);//tổng trả
        $rt['total_outdate']=(float)@$inv[0]['quahan'];//tiền nợ quá hạn thanh toán
        $rt['total_sales']=(float)@$inv[0]['amount'];//tổng nợ trong kỳ
        $rt['debt_limit']=(float)@$inv[0]['max_debt'];//tổng tiền có thể nợ
        return $rt;
    }
    else
    {
        return false;
    }

}
function getDebtCus($cus_code,$date=0){
if($date==-1)$date=time();
    $cus=get_data("select * from customers where cus_code = '{$cus_code}'");
    if(is_array($cus) && count($cus)>0){
        $cus=$cus[0];
        $inv=get_data("select cus.cus_name,cus.debt,cus.max_debt,(select sum(cn.price) from congno cn where cn.target_id=cus.cus_id and cn.type_of=1 and cn.tg<=$date) notien,
        (select (sum(IFNULL(oinv.total,0)-IFNULL(oinv.payment,0))-IFNULL((select sum(IFNULL(binv.amount,0)) from budget_invoices binv where created_date<=$date and binv.cus_id=oinv.cus_id and binv.oinv_id is null),0)) from out_invoices oinv where oinv.created_date<=$date and oinv.cus_id=cus.cus_id and oinv.max_time<=".time().") quahan, 
        cus.cus_id,cus.address, cus.tel,IFNULL(sum_inv.amount,0) inv_amount,IFNULL(sum_inv.vat_price,0) vat_price,IFNULL(sum_bin.amount,0) bin_amount,IFNULL(sum_return.amount,0) return_amount, (IFNULL(sum_inv.amount,0)-IFNULL(sum_bin.amount,0)+cus.debt-IFNULL(sum_return.amount,0)) amount from customers cus
    left join (select inv.cus_id, sum(inv.total) amount, sum(inv.vat_price) vat_price  from out_invoices inv where inv.created_date<=$date and ifnull(inv.draft,0)=0  group by inv.cus_id) sum_inv  
    on cus.cus_id=sum_inv.cus_id
    left join (select bin.cus_id, sum(IFNULL(bin.amount,0)) amount from budget_invoices bin where bin.created_date<=$date and (bin.bin_type=0) group by bin.cus_id) sum_bin 
    on cus.cus_id=sum_bin.cus_id 
        left join (select inv.cus_id, sum(IFNULL(inv.total,0)) amount from mat_return_invoices inv where inv.created_date<=$date and inv.paid_type=1 group by inv.cus_id) sum_return
    on cus.cus_id=sum_return.cus_id
        where cus.cus_id={$cus['cus_id']} and IFNULL(sum_inv.amount,0)-IFNULL(sum_bin.amount,0)+cus.debt-IFNULL(sum_return.amount,0)!=0 and cus.cus_code='{$cus_code}'");
        $rt=array();
        $rt['debt_final']=(float)@$inv[0]['inv_amount']+(float)@$inv[0]['debt'];//tổng nợ
        $rt['paid']=(float)@(@$inv[0]['bin_amount']-@$inv[0]['return_amount']);//tổng trả
        $rt['total_outdate']=(float)@$inv[0]['quahan'];//tiền nợ quá hạn thanh toán
        $rt['total_sales']=(float)@$inv[0]['amount'];//tổng nợ trong kỳ
        $rt['debt_limit']=(float)@$inv[0]['max_debt'];//tổng tiền có thể nợ
        return $rt;
    }
    else
    {
        return false;
    }

}


function getDebtCusPS($cus_code,$fdate=0,$todate=0){
if($fdate==-1)$fdate=time();
    $cus=get_data("select * from customers where cus_code = '{$cus_code}'");
    if(is_array($cus) && count($cus)>0){
        $cus=$cus[0];
        $inv=get_data("select cus.cus_name,cus.debt,cus.max_debt,(select sum(cn.price) from congno cn where cn.target_id=cus.cus_id and cn.type_of=1 and cn.tg>=$fdate and cn.tg<=$todate) notien,
        (select (sum(IFNULL(oinv.total,0)-IFNULL(oinv.payment,0))-IFNULL((select sum(IFNULL(binv.amount,0)) from budget_invoices binv where binv.created_date>=$fdate and binv.created_date<=$todate and binv.cus_id=oinv.cus_id and binv.oinv_id is null),0)) from out_invoices oinv where oinv.created_date>=$fdate and oinv.created_date<=$todate and oinv.cus_id=cus.cus_id and oinv.max_time<=".time().") quahan, 
        cus.cus_id,cus.address, cus.tel,IFNULL(sum_inv.amount,0) inv_amount,IFNULL(sum_inv.vat_price,0) vat_price,IFNULL(sum_bin.amount,0) bin_amount,IFNULL(sum_return.amount,0) return_amount, (IFNULL(sum_inv.amount,0)-IFNULL(sum_bin.amount,0)-IFNULL(sum_return.amount,0)) amount from customers cus
    left join (select inv.cus_id, sum(inv.total) amount, sum(inv.vat_price) vat_price  from out_invoices inv where inv.created_date>=$fdate and inv.created_date<=$todate and ifnull(inv.draft,0)=0  group by inv.cus_id) sum_inv  
    on cus.cus_id=sum_inv.cus_id
    left join (select bin.cus_id, sum(IFNULL(bin.amount,0)) amount from budget_invoices bin where bin.created_date>=$fdate and bin.created_date<=$todate and (bin.bin_type=0) group by bin.cus_id) sum_bin 
    on cus.cus_id=sum_bin.cus_id 
        left join (select inv.cus_id, sum(IFNULL(inv.total,0)) amount from mat_return_invoices inv where inv.created_date>=$fdate and inv.created_date<=$todate and inv.paid_type=1 group by inv.cus_id) sum_return
    on cus.cus_id=sum_return.cus_id
        where cus.cus_code='{$cus_code}'");
        $rt=array();
        $rt['debt_final']=(float)@$inv[0]['inv_amount'];//tổng nợ
        $rt['paid']=(float)@(@$inv[0]['bin_amount']-@$inv[0]['return_amount']);//tổng trả
        $rt['total_outdate']=(float)@$inv[0]['quahan'];//tiền nợ quá hạn thanh toán
        $rt['total_sales']=(float)@$inv[0]['amount'];//tổng nợ trong kỳ
        $rt['debt_limit']=(float)@$inv[0]['max_debt'];//tổng tiền có thể nợ
        return $rt;
    }
    else
    {
        return false;
    }

}
function get_instock($mat, $todate, $stock_id=0) {
        global $db;
        //print_r($mat);die();
        $mms_id = $mat['mms_id'];
        $quantity = 0;
        if(!isset($mat["mat_id"]) || !isset($mat["msu_id"])){
            $mat = get_data("select * from mat_msu where mms_id=".intval($mat["mms_id"]));
            if(intval(@count($mat))>0){
                $mat=$mat[0];
            }
        }
        if(intval(@count($mat))<=0)
         return array('sum'=>0,'instock'=>0,'mat_out'=>0,'mat_in'=>0,'ps_mat_out'=>0,'ps_mat_in'=>0,'s_mat_out'=>0,'s_mat_in'=>0);

        if (intval($stock_id)==0) {

            $mat_in = get_data("select sum(invd.mat_quantity) quantity from invoices inv, invoice_details invd  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $todate . " and invd.mms_id ='" . $mms_id . "' and inv.inv_type<=1");
            $mat_out = get_data("select sum(invd.mat_quantity) quantity from out_invoices inv, out_invoice_details invd, stock_mat_msu smm where ifnull(inv.draft,0) = 0 and inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.created_date<=" . $todate);
            $mat_return = get_data("select sum(invd.mat_quantity) quantity from mat_return_invoices inv, mat_return_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.created_date<=" . $todate);
            $mat_return_sup = get_data("select sum(invd.mat_quantity) quantity from mat_return_invoices inv, mat_return_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.sup_id is not null and inv.created_date<=" . $todate);            
            $mat_imo = get_data("select sum(IFNULL(imod.quantity,0)-IFNULL(imod.back_quantity,0)) from imo_details imod, instock_modify imo where smm_id in (select smm_id from stock_mat_msu where mms_id='" . $mms_id . "') and imo.imo_id=imod.imo_id and imo.created_date<=" . $todate);
        } else {
            //die($stock_id."â");
            //$chk_stock = get_data("select stock_id from stocks where stock_id='" . $stock_id . "' and user_id is null");
           
            $mat_imo = get_data("select sum(IFNULL(imod.quantity,0)-IFNULL(imod.back_quantity,0))  from imo_details imod, instock_modify imo where smm_id in (select smm_id from stock_mat_msu where mms_id='" . $mms_id . "'  and stock_id='" . $stock_id . "') and imo.imo_id=imod.imo_id and imo.created_date<=" . $todate);
            $mat_move_in = get_data("select sum(invd.mat_quantity) quantity from mat_move_invoices inv, mat_move_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.stock_id_to='" . $stock_id . "' and inv.created_date<=" . $todate);
            $mat_move_out = get_data("select sum(invd.mat_quantity) quantity from mat_move_invoices inv, mat_move_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.stock_id='" . $stock_id . "' and inv.created_date<=" . $todate);
            //if (count($chk_stock) > 0) {
                //$mat_in = get_data("select sum(invd.mat_quantity) quantity from invoices inv, invoice_details invd  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $todate . " and inv.stock_id='" . $stock_id . "' and invd.mms_id ='" . $mms_id . "' and inv.inv_type=1");
                $mat_in = get_data("select sum(invd.mat_quantity) quantity from invoices inv, invoice_details invd  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $todate . " and invd.stock_id='" . $stock_id . "' and ((invd.smm_id in(select smm_id from stock_mat_msu where mms_id='" . $mms_id . "' and stock_id!='" . $stock_id . "') and inv.inv_type=2) or (invd.mms_id ='" . $mms_id . "' and inv.inv_type<=2))");
                //print_r("select sum(invd.mat_quantity) quantity from invoices inv, invoice_details invd  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $todate . " and invd.stock_id='" . $stock_id . "' and ((invd.smm_id in(select smm_id from stock_mat_msu where mms_id='" . $mms_id . "' and stock_id!='" . $stock_id . "') and inv.inv_type=2) or (invd.mms_id ='" . $mms_id . "' and inv.inv_type<=2))");
                $mat_out = get_data("select sum(invd.mat_quantity) quantity from out_invoices inv, out_invoice_details invd, stock_mat_msu smm where ifnull(inv.draft,0) = 0 and inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.created_date<=" . $todate . " and smm.stock_id='" . $stock_id . "'");
                $mat_move = get_data("select sum(invd.mat_quantity) quantity from invoices inv, invoice_details invd, stock_mat_msu smm  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $todate . " and smm.stock_id='" . $stock_id . "' and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.inv_type=2");
                $mat_return = get_data("select sum(invd.mat_quantity) quantity from mat_return_invoices inv, mat_return_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.created_date<=" . $todate . " and inv.stock_id='" . $stock_id . "'");
                $mat_return_emp = get_data("select sum(invd.mat_quantity) quantity from mat_return_invoices inv, mat_return_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.emp_stock_id='" . $stock_id . "' and inv.created_date<=" . $todate);
                $mat_return_sup = get_data("select sum(invd.mat_quantity) quantity from mat_return_invoices inv, mat_return_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and smm.stock_id='" . $stock_id . "' and inv.sup_id is not null and inv.created_date<=" . $todate);
            /*} else {
                $mat_in = get_data("select sum(invd.mat_quantity) quantity from invoices inv, invoice_details invd  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $todate . " and inv.stock_id='" . $stock_id . "' and ((invd.smm_id in(select smm_id from stock_mat_msu where mms_id='" . $mms_id . "' and stock_id!='" . $stock_id . "') and inv.inv_type=2) or (invd.mms_id ='" . $mms_id . "' and inv.inv_type=1))");
                $mat_out = get_data("select sum(invd.mat_quantity) quantity from out_invoices inv, out_invoice_details invd, stock_mat_msu smm where ifnull(inv.draft,0) = 0 and inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.created_date<=" . $todate . " and smm.stock_id='" . $stock_id . "'");
                $mat_move = get_data("select sum(invd.mat_quantity) quantity from invoices inv, invoice_details invd, stock_mat_msu smm  where inv.inv_id=invd.inv_id  and inv.created_date<=" . $todate . " and smm.stock_id='" . $stock_id . "' and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.inv_type=2");
                $mat_return = get_data("select sum(invd.mat_quantity) quantity from mat_return_invoices inv, mat_return_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.cus_id is not null and inv.created_date<=" . $todate . " and inv.stock_id='" . $stock_id . "'");
                $mat_return_emp = get_data("select sum(invd.mat_quantity) quantity from mat_return_invoices inv, mat_return_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and inv.emp_stock_id='" . $stock_id . "' and inv.stock_id!='" . $stock_id . "'  and inv.created_date<=" . $todate);
                $mat_return_sup = get_data("select sum(invd.mat_quantity) quantity from mat_return_invoices inv, mat_return_invoice_details invd, stock_mat_msu smm where inv.inv_id=invd.inv_id and invd.smm_id=smm.smm_id and smm.mms_id='" . $mms_id . "' and smm.stock_id='" . $stock_id . "' and inv.sup_id is not null and inv.created_date<=" . $todate);
            }*/
        }
        $v = array();
        if (count($mat_in) > 0) {
            $quantity = $mat_in[0][0];
            $v['mat_in'] = $mat_in[0][0];
        } else {
            $v['mat_in'] = 0;
        }
        if (count($mat_out) > 0) {
            $quantity-=$mat_out[0][0];
            $v['mat_out'] = $mat_out[0][0];
        } else {
            $v['mat_out'] = 0;
        }
        if (count($mat_return) > 0) {
            $quantity+=$mat_return[0][0];
            $v['mat_out'] = $v['mat_out'] - $mat_return[0][0];
        }


        $v['s_mat_in']=$v['mat_in'];
        $v['s_mat_out']=$v['mat_out'];
        $v['ps_mat_in']=0;
        $v['ps_mat_out']=0;
        if (isset($mat_move_in)) {
            if (count($mat_move_in) > 0) {
                $quantity+=$mat_move_in[0][0];
                $v['mat_in'] = $v['mat_in'] + $mat_move_in[0][0];
                $v['ps_mat_in']=$mat_move_in[0][0];
            }
        }
        if (isset($mat_move_out)) {
            if (count($mat_move_out) > 0) {
                $quantity-=$mat_move_out[0][0];
                $v['mat_out'] = $v['mat_out'] + $mat_move_out[0][0];
                $v['ps_mat_out']+=$mat_move_out[0][0];
            }
        }
        if (isset($mat_move)) {
            if (count($mat_move) > 0) {
                $quantity-=$mat_move[0][0];
                $v['mat_out'] = $v['mat_out'] + $mat_move[0][0];
                $v['ps_mat_out']+=$mat_move[0][0];
            }
        }
        if (isset($mat_return_sup)) {
            if (count($mat_return_sup) > 0) {
                $quantity-=$mat_return_sup[0][0];
                $v['mat_in'] = $v['mat_in'] - $mat_return_sup[0][0];
                $v['ps_mat_in'] -= $mat_return_sup[0][0];
            }
        }
        if (isset($mat_return_emp)) {
            if (count($mat_return_emp) > 0) {
                $quantity-=$mat_return_emp[0][0];
                $v['mat_in'] = $v['mat_in'] - $mat_return_emp[0][0];
                $v['ps_mat_in'] -= $mat_return_emp[0][0];
            }
        }
        
        if (count($mat_imo) > 0) {
            $quantity+=$mat_imo[0][0];
            $v['mat_out'] = $v['mat_out'] - $mat_imo[0][0];
            $v['ps_mat_out'] -= $mat_imo[0][0];
        }
        if (intval(@$stock_id)>0) {
            $instock = get_data("select instock from stock_mat_msu where mms_id='" . $mms_id . "' and stock_id='" . $stock_id . "'");
        } else {
            $instock = get_data("select sum(instock) instock from stock_mat_msu where mms_id='" . $mms_id . "' and stock_id in (select stock_id from stocks)");
        }
        if (count($instock) > 0) {
            $instock = $instock[0][0];
        } else {
            $instock = 0;
        }

        $count_msp = get_data("select count(*), sum(msu1.msu_multiple/msu2.msu_multiple) quantity from mat_split msp, stock_mat_msu smm, mat_msu mms, meansure msu1, meansure msu2 where msp.smm_id=smm.smm_id  and smm.mms_id=mms.mms_id and mms.mat_id='" . $mat["mat_id"] . "' " . (!empty($stock_id) ? " and smm.stock_id = '" . $stock_id . "'" : "") . "  and " . $mat["msu_id"] . " in(msp.msu_list) and mms.msu_id=msu1.msu_id and msu1.msu_parid=msu2.msu_id");
        //var_export($count_msp);
        if ($count_msp[0][0] > 0) {
            $msu = get_data("select * from meansure where msu_id='" . $mat["msu_id"] . "'");
            $v['mat_in'] += $count_msp[0]['quantity'];
            $quantity+=$count_msp[0]['quantity'];
        }
        $v['instock'] = $instock;
        $v['sum'] = $quantity + $instock;
        if ($todate ==mktime(23, 59, 59, date('m'), date('d'), date('Y')) && (!empty($stock_id) || intval(@$stock_id)==0)) {
            $db->query("update stock_mat_msu set quantity=" . $v['sum'] . " where mms_id='" . $mat ["mms_id"] . "' and stock_id='" . $stock_id . "'");
            global $MATLIST;$MATLIST[]=$mat["mms_id"];
        }        
        return $v;
    }
function productPull($mms_id,$old_qc="",$old_gai=""){
    $mats = get_data("select mat.*,msu.msu_name,mms.price mms_price, cat.cat_name from materials mat ,mat_msu mms,meansure msu,categories cat where cat.cat_id=mat.cat_id and mms.mat_id=mat.mat_id and mms.msu_id=msu.msu_id and mms.mms_id=$mms_id");
    $result="";
    foreach ($mats as $key => $mat) {
        
        $data=array();

        $data['name']=$mat['qc'];
        $data['gai']=$mat['gai'];
        $data['price']=$mat['mms_price']*((100+$mat['vat'])/100);
        $data['category_code']=$mat['cat_id'];
        $data['category_name']=$mat['cat_name'];
        $data['description']=$mat['mat_desc'];
        $data['is_tyre']=$mat['is_tyre'];
        $data['is_intestine']=$mat['is_intestine'];
        $data['is_coveralls']=$mat['is_coveralls'];

        if($old_qc=="" || $old_gai=="")
        {
            $old_qc=$data['name'];
            $old_gai=$data['gai'];
        }
        $apiurl="https://dev.api.vinhkhanhtire.vn/api/v1/integrate/products";
        $json=json_encode($data,true);
        $trueSignalKey=sha1("name={$old_qc}&gai={$old_gai}&secretKey=".SECRET_KEY);
        $apiurl.="?name=".urlencode($old_qc)."&gai=".urlencode($old_gai)."&signalKey=".$trueSignalKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $apiurl );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $json ); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain','token: '.TOKEN)); 

        $result=curl_exec($ch);

    }
    return $result;
}
function add_productStocksPull($mms_id){
    global $MATLIST;
    $MATLIST[]=$mms_id;
}
function call_productStocksPull(){
global $db;


$result="";
$data=array();

    $mmss=get_data("select mms_id from product_stock_update");
    if(is_array(@$mmss) && count(@$mmss)>0){
        foreach ($mmss as $key => $matrow) {
    $mms_id=$matrow["mms_id"];
    $mats = get_data("select mat.*,msu.msu_name,mms.mms_id from materials mat ,mat_msu mms,meansure msu,categories cat where cat.cat_id=mat.cat_id and mms.mat_id=mat.mat_id and mms.msu_id=msu.msu_id and mms.mms_id=$mms_id");
    $dtstock=get_data("select stock_code,stock_id from stocks");
    $result="";
    foreach ($mats as $key => $mat) {
        
        $ins=array();
        $ins['name']=$mat['qc'];
        $ins['gai']=$mat['gai'];
        $ins['TV']=0;
        $ins['Q8']=0;
        $ins['VL']=0;
        $ins['PY']=0;
        
    foreach ($dtstock as $key => $st) {
        $instock=get_instock($mat,time(),$st['stock_id']);
        $ins[$st['stock_code']]=intval(@$instock['sum']);
    }
    

        $data[]=$ins;

    }
    
}

    }

if(count(@$data)>0){
    //print_r($data);die();
        $apiurl="https://dev.api.vinhkhanhtire.vn/api/v1/integrate/productStocks";
        $json=json_encode($data,true);
        $trueSignalKey=sha1("secretKey=".SECRET_KEY);
        $apiurl.="?signalKey=".$trueSignalKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $apiurl );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $json ); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain','token: '.TOKEN));
        $result=curl_exec($ch);
        //die($result);
}
$mmss=$db->query("delete from product_stock_update");

return $result;



}






function productStocksPull($matlist){


$result="";
$data=array();
if(is_array(@$matlist) && count(@$matlist)>0)
foreach ($matlist as $key => $matrow) {
    $mms_id=$matrow;
    $mats = get_data("select mat.*,msu.msu_name,mms.mms_id from materials mat ,mat_msu mms,meansure msu,categories cat where cat.cat_id=mat.cat_id and mms.mat_id=mat.mat_id and mms.msu_id=msu.msu_id and mms.mms_id=$mms_id");
    $dtstock=get_data("select stock_code,stock_id from stocks");
    $result="";
    foreach ($mats as $key => $mat) {
        
        $ins=array();
        $ins['name']=$mat['qc'];
        $ins['gai']=$mat['gai'];
        
    foreach ($dtstock as $key => $st) {
        $instock=$this->get_instock($mat[0],time(),$st['stock_id']);
        $ins[$st['stock_code']]=intval(@$instock['sum']);
    }
    

        $data[]=$ins;

    }
    
}
if(count(@$data)>0){
        $apiurl="https://dev.api.vinhkhanhtire.vn/api/v1/integrate/productStocks";
        $json=json_encode($data,true);
        $trueSignalKey=sha1("secretKey=".SECRET_KEY);
        $apiurl.="?signalKey=".$trueSignalKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $apiurl );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $json ); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain','token: '.TOKEN));
        $result=curl_exec($ch);
}


return $result;

    
}




function customerTransactionsPull($bin_id){


$result="";
$data=array();
$cus_code="";
    $mats = get_data("select bin.*, cus.cus_code,cus.cus_name from budget_invoices bin,customers cus where cus.cus_id=bin.cus_id and bin.bin_id=$bin_id");
    $result="";

// "date": "2020-02-01 09:00:01",
//   "credit": 129928775,
//   "number": "PT0111",
//   "note": "Mẩu",
//   "category_name": "",
//   "stock_name": ""

if(is_array(@$mats) && count(@$mats)>0)
    foreach ($mats as $key => $bin) {
        $ins=array();
        $ins['date']=$bin['created_date'];
        $ins['credit']=$bin['amount'];
        $ins['number']=$bin['bin_code'];
        $ins['note']=$bin['comment'];
        $ins['cus_code']=$bin['cus_code'];
        $cus_code=$bin['cus_code'];
        $ins['cus_name']=$bin['cus_name'];
        $ins['category_name']="";
        $ins['stock_name']="";
        $data[]=$ins;
    }
    
if(count(@$data)>0){
        $apiurl="https://dev.api.vinhkhanhtire.vn/api/v1/integrate/customerTransactions";
        $json=json_encode($data,true);
        $trueSignalKey=sha1("code={$cus_code}&secretKey=".SECRET_KEY);
        $apiurl.="?code=$cus_code&signalKey=".$trueSignalKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $apiurl );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $json ); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain','token: '.TOKEN));
        $result=curl_exec($ch);
}


return $result;

    
}










function safe_str($str){
    global $db;
    return $db->real_escape_string(trim($str));
}

function add_socai($tk,$tk_du,$no,$co,$item_id,$item_type,$created_date=0) {
    global $sessions;
    if($created_date==0)$created_date=time();
    $user_id=intval(@$sessions->get_session('user_id'));
    $db->query("insert into socai(tk,tk_du,no,co,item_id,item_type,created_date) values ('$tk','$tk_du','$no','$co','$item_id','$item_type','$created_date')");
}
function rmv_socai($item_id,$item_type) {
    global $sessions;
    if($created_date==0)$created_date=time();
    $user_id=intval(@$sessions->get_session('user_id'));
    $db->query("delete from socai where item_id='$item_id' and item_type='$item_type')");
}

function loadloop($parent=0){
  $data=array();
  $load = get_data("select * from fund_type where fund_type.parent_id='" . intval($parent) . "' order by fund_type_code asc ");
  if(is_array($load) && count($load)>0){
    $data=$load;
    foreach ($load as $key => $ftype) {
        if($data[$key]['ft_level']>0)
      $data[$key]['text']="[".$data[$key]['fund_type_code']."] ".$data[$key]['fund_type_name'];
  else
    $data[$key]['text']=$data[$key]['fund_type_name'];
      $load2 = loadloop(intval($ftype['fund_type_id']) );
      if(is_array($load2) && count($load2)>0){
        $data[$key]['items']=$load2;
      }
      else
        $data[$key]['items']=array();
    }
  }
  return $data;

}


function dequy_fund_type($item,$hash=0){
                            $html=array();
                            if(count($item)>0)
                            {
                                
                              foreach ($item as $key => $ite) {
                                  $ite['fund_type_name']=str_repeat("&nbsp;",$hash)." [".$ite['fund_type_code']."] ".$ite['fund_type_name'];

                                  $html[]=$ite;
                                  if(count($ite['items'])>0)
                                  {
                                      $html=array_merge($html,dequy_fund_type($ite['items'],$hash+1));
                                  }
                              }
                                
                            }
                            return $html;
}


function get_fund_parent($id){
    $rt=array();
    $rt['id_list']=array();
    $rt['level']=0;
    $rt['parent']=array();
    $rt['loop']=false;
    $id=intval($id);
    $pid=intval($id);
    while ($pid>0) {
        $fmenu = get_data("select * from fund_type where fund_type_id=".$pid);
        if(is_array($fmenu) && count($fmenu)>0){
            if(in_array($fmenu[0]['fund_type_id'], $rt['id_list'])){
                $rt['loop']=true;
                return $rt;
            }
            else{
                $rt['id_list'][]=$fmenu[0]['fund_type_id'];
                $rt['parent'][]=$fmenu[0];
                $pid=$fmenu[0]['parent_id'];
                $rt['level']++;
            }
            
        }
        else
        $pid=0;
    }
    return $rt;
    
}

function create_barcode($text = "") {
    global $sessions;
    ini_set("memory_limit", "256M");
    require_once('bms/classes/barcode/class/BCGFontFile.php');
    require_once('bms/classes/barcode/class/BCGColor.php');
    require_once('bms/classes/barcode/class/BCGDrawing.php');

// Including the barcode technology
    require_once('bms/classes/barcode/class/BCGcode128.barcode.php');

// Loading Font
    $font = new BCGFontFile(__DIR__.'/../classes/barcode/class/font/Arial.ttf', 6);

// The arguments are R, G, B for color.
    $color_black = new BCGColor(0, 0, 0);
    $color_white = new BCGColor(255, 255, 255);

    $drawException = null;
    try {
        $code = new BCGcode128();
        $code->setScale(1); // Resolution
        $code->setThickness(20); // Thickness
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->setFont($font); // Font (or 0)
        $code->parse($text); // Text
    } catch (Exception $exception) {
        $drawException = $exception;
    }

    /* Here is the list of the arguments
      1 - Filename (empty : display on screen)
      2 - Background color */
    $drawing = new BCGDrawing('', $color_white);
    if ($drawException) {
        $drawing->drawException($drawException);
    } else {
        $drawing->setBarcode($code);
        $drawing->draw();
    }

// Header that says it is an image (remove it if you save the barcode to a file)
//header('Content-Type: image/png');
// Draw (or save) the image into PNG format.
    $drawing->setFilename('data/barcode/' .($sessions->session_prefix==''?'':$sessions->session_prefix."_"). $text . '.png');
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
//die('data/barcode/' .($sessions->session_prefix==''?'':$sessions->session_prefix."_"). $text . '.png');
    /* $im = imagecreatetruecolor(strlen($text)*10+4, 50);
      $white = imagecolorallocate($im, 255, 255, 255);
      $black = imagecolorallocate($im, 0, 0, 0);
      imagefilledrectangle($im, 0, 0, strlen($text)*10+4, 50, $white);
      $font = 'skins/homepage/fonts/BarcodeFont.ttf';
      imagettftext($im,44, 0, 2, 40, $black, $font, $text);
      $text_width = imagefontwidth(3)*strlen($text);
      $center = ceil(strlen($text)*5);
      $x = $center - (ceil($text_width/2));
      //imagestring($im, 3, $x, 36, $text, $black);
      imagepng($im,'barcode/'.$text.'.png');
      ImageDestroy($im); */
}

function insertlog($act) {
    global $sessions, $db;
    $db->query("INSERT INTO logs( start_time,user_id,ip,agent,action) VALUES(" . time() . ",'" . $sessions->get_session("user_id") . "','" . $sessions->getip() . "','" . $_SERVER['HTTP_USER_AGENT'] . "','" . $act . "')");
}

function creat_filename($strfile, $ext) {
    $filename = "";
    // GET THE TYPE OF IMAGE . EX: .GIF , .JPG ,....
    $start = substr($strfile, 0, - 4);
    $type = substr($strfile, - 4);
    if (strtolower($type) != ".bmp" && strtolower($type) != ".gif" && strtolower($type) != ".jpg" && strtolower($type) != ".png" && strtolower($type) != ".swf" && $ext == "img") {
        return false;
    }
    if (strtolower($type) != ".zip" && strtolower($type) != ".gz" && strtolower($type) != ".tar" && strtolower($type) != ".rar" && strtolower($type) != ".doc" && strtolower($type) != ".pdf" && strtolower($type) != "docx" && strtolower($type) != ".odt" && strtolower($type) != ".ods" && strtolower($type) != "xlsx" && $ext == "doc") {
        return false;
    }
    if (strtolower($type) != ".dat" && strtolower($type) != ".wma" && strtolower($type) != ".wmv" && strtolower($type) != ".flv" && strtolower($type) != ".wav" && strtolower($type) != ".mp3" && $ext == "music") {
        return false;
    }
    //----------------------------------------------
    $chars = array('a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J', 'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T', 'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
    $max_chars = count($chars) - 1;
    for ($i = 0; $i < 4; $i++) {
        $filename = ($i == 0) ? $chars [rand(0, $max_chars)] : $filename . $chars [rand(0, $max_chars)];
    }
    $filename = "eda_t" . time() . "_" . $filename . $type;
    return $filename;
}

function rand_alpha() {
    $a = array('1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'X', 'W', 'Y', 'Z');
    $b = "";
    for ($i = 0; $i < 12; $i++)
        $b .= $a [rand(0, count($a) - 1)];
    return $b;
}

function test($t) {
    echo "<script>alert('$t');</script>";
}

function data_pre($data) {
    if (is_array($data)) {
        for ($i = 0; $i < count($data); $i++)
            $temp [$i] = replace(strip_script($data [$i]));
    } else
        $temp = replace(strip_script($data));
    return $temp;
}

function get_ext($filename) {
    $ext = substr($filename, strpos($filename, ".") + 1, strlen($filename));
    if (file_exists(__DIR__."/../images/ext/" . $ext . '.jpg'))
        return strtolower($ext);
    else
        return "other";
}

function strip_script($string) {
    // Prevent inline scripting
    $string = preg_replace("#<script[^>]*>.*?</script>#is", "", $string);
    // Prevent linking to source files
    $string = preg_replace("#<script[^>]*>#is", "", $string);
    return $string;
}

function go_page($url) {
    if (!headers_sent()) {
        header("Location: " . $url);
    } else {
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
    }
}

function dateCmp($a, $b) {
    if ($a ["post_date"] == $b ["post_date"])
        return 0;
    if ($a ["post_date"] < $b ["post_date"])
        return - 1;
    return 1;
}

function replace($str) {
    $str = str_replace("\'", "'", $str);
    $str = str_replace('\"', '"', $str);
    $str = str_replace("'", "\'", $str);
    /* $str = str_replace("<","[",$str);
      $str = str_replace("&lt;","[",$str);
      $str = str_replace(">","]",$str);
      $str = str_replace("&gt;","]",$str);
      $str = str_replace("[b]","<b>",$str);
      $str = str_replace("[/b]","</b>",$str);
      $str = str_replace("[u]","<u>",$str);
      $str = str_replace("[/u]","</u>",$str);
      $str = str_replace("[i]","<i>",$str);
      $str = str_replace("[/i]","</i>",$str);
      $str = str_replace("[/url]","</a>",$str);
      $str = str_replace("[/a]","</a>",$str);
      while (($ind=strpos($str,"[img"))){
      $str = substr_replace($str,"<img",$ind,4);
      $ind = strpos($str,"]",$ind+1);
      if ($ind){
      $str = substr_replace($str,">",$ind,1);
      }
      }
      while (($ind=strpos($str,"[url="))){
      $str = substr_replace($str,"<a href=",$ind,5);
      $ind = strpos($str,"]",$ind+1);
      if ($ind){
      $str = substr_replace($str,">",$ind,1);
      }
      }

      while (($ind=strpos($str,"[a href="))){
      $str = substr_replace($str,"<a href=",$ind,8);
      $ind = strpos($str,"]",$ind+1);
      if ($ind){
      $str = substr_replace($str,">",$ind,1);
      }
      }
     */
    return $str;
}

function check_email($email, $dm = 0) {
    if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
        list($username, $domain) = explode('@', $email);
        if ($dm == 0) {
            if (!checkdnsrr($domain, 'MX')) {
                return false;
            }
        }
        return true;
    }
    return false;
}

function page_transfer($msg, $page = "index.php") {
    $showtext = $msg;
    $page_transfer = $page;
    include ("bms/templates/transfer.htm");
    //exit();
}

function is_image($f) {
    if (strtoupper(substr($f, - 3)) == "JPG" || strtoupper(substr($f, - 3)) == "GIF" || strtoupper(substr($f, - 3)) == "PNG")
        return true;
    else
        return false;
}

function get_data($sql) {
    global $db;
    $sql_query = $db->query($sql);
    $d_count = 0;
    $d = array();
    while ($result = $db->fetch_array($sql_query)) {
        $d [$d_count] = $result;
        $d_count++;
    }
    $db->free_result($sql_query);
    return $d;
}

function parsedate($value) {
    // If it looks like a UK date dd/mm/yy, reformat to US date mm/dd/yy so strtotime can parse it.
    $reformatted = preg_replace("/^\s*([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", "\\2/\\1/\\3", $value);
    return strtotime($reformatted);
}

function getmaclinux() {
    // This code is under the GNU Public Licence
    // Written by michael_stankiewicz {don't spam} at yahoo {no spam} dot com
    // Tested only on linux, please report bugs
    // WARNING: the commands 'which' and 'arp' should be executable
    // by the apache user; on most linux boxes the default configuration
    // should work fine
    // get the arp executable path
    $location = `which arp`;
    $location = rtrim($location);
    // Execute the arp command and store the output in $arpTable
    $arpTable = `$location -n`;
    // Split the output so every line is an entry of the $arpSplitted array
    $arpSplitted = split("\n", $arpTable);
    // get the remote ip address (the ip address of the client, the browser)
    $remoteIp = getenv('REMOTE_ADDR');
    $remoteIp = str_replace(".", "\\.", $remoteIp);
    // Cicle the array to find the match with the remote ip address
    foreach ($arpSplitted as $value) {
        // Split every arp line, this is done in case the format of the arp
        // command output is a bit different than expected
        $valueSplitted = split(" ", $value);
        $ipFound = false;
        foreach ($valueSplitted as $spLine) {
            if (preg_match("/$remoteIp/", $spLine)) {
                $ipFound = true;
            }
            // The ip address has been found, now rescan all the string
            // to get the mac address
            if ($ipFound) {
                // Rescan all the string, in case the mac address, in the string
                // returned by arp, comes before the ip address
                // (you know, Murphy's laws)
                reset($valueSplitted);
                foreach ($valueSplitted as $spLine) {
                    if (preg_match("/[0-9a-f][0-9a-f][:-]" .
                                    "[0-9a-f][0-9a-f][:-]" .
                                    "[0-9a-f][0-9a-f][:-]" .
                                    "[0-9a-f][0-9a-f][:-]" .
                                    "[0-9a-f][0-9a-f][:-]" .
                                    "[0-9a-f][0-9a-f]/i", $spLine)) {
                        return $spLine;
                    }
                }
            }
            $ipFound = false;
        }
    }
    return false;
}

function getMAC() {
    $str = `/sbin/ifconfig`;
    $str = str_replace("\n", "", $str);
    $str = str_replace(" ", "", $str);
    $str = strtolower($str);
    $pos = strpos($str, "hwaddr");
    if ($pos) {
        $str = substr($str, $pos + 6, 17);
        if (strlen($str) == 17) {
            return $str;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getmacwin() {
    //First get the IP address then use the
    //DOS command + only get row with client IP address
    //This takes only one line of the ARP table instead
    //of what could be a very large table of data to
    //hopefull give a small speed/performance advantage

    $remoteIp = rtrim($_SERVER['REMOTE_ADDR']);
    $location = rtrim(`arp -a $remoteIp`);
    //var_export($remoteIp.$location);
    //reduce no of white spaces then
    //Split up into array element by white space
    $location = preg_replace('/\s+/', 's', $location);
    $location = split('\s', $location); //

    $num = count($location); //get num of array elements
    $loop = 0; //start at array element 0
    while ($loop < $num) {
        //mac address is always one after the
        //IP after inserting the firstline
        //(preg_replace) line above.
        if ($location[$loop] == $remoteIp) {
            $loop = $loop + 1;
            //echo "<h1>Client MAC Address:- ".$location[$loop]."</h1>";
            //$_SESSION['MAC'] = $loop;
            return $location[$loop];
        } else {
            $loop = $loop + 1;
        }
    }
}

function doc_so($so_vao) {
    $thu_tu = array();
    $i = 1;
    $thu_tu[1] = "";
    $thu_tu[2] = "nghìn";
    $thu_tu[3] = "triệu";
    $thu_tu[4] = "tỷ";
    $thu_tu[5] = "nghìn tỷ";
    $thu_tu[6] = "triệu tỷ";
    $thu_tu[7] = "tỷ tỷ";
    if (empty($so_vao)) {
        return 'Không';
    }
    $so_vao = str_replace(',', '', $so_vao);
    if ($so_vao < 0) {
        $so = abs($so_vao);
    } else {
        $so = $so_vao;
    }
    $so = number_format(str_replace(" ", "", $so), 2, ".", "");
    $docso = "phẩy " . dochangtram(substr($so, -2));
    if ($docso == "phẩy ") {
        $docso = "";
    }
    $so = substr($so, 0, strlen($so) - 3);
    $dk = true;
    while ($dk) {
        if (strlen($so) > 3) {
            $du = substr($so, -3);
        } else {
            $du = $so;
        }
        $tram = dochangtram($du);
        $docso = (empty($tram) ? '' : $tram . " " . $thu_tu[$i]) . " " . $docso;
        $i = $i + 1;
        if (strlen($so) > 3) {
            $so = substr($so, 0, strlen($so) - 3);
        } else {
            $doc_so = $docso;
            $dk = false;
            if (floatval(number_format(str_replace(" ", "", $so_vao), 2, ".", "")) < 0) {
                return "âm " . $doc_so;
            }
            return $doc_so;
        }
    }
    if (floatval(number_format(str_replace(" ", "", $so_vao), 2, ".", "")) < 0) {
        return "âm " . $doc_so;
    }
    return $doc_so;
}

function numF($n) {
    if (empty($n)) {
        $n = 0;
    }
    if (!is_numeric($n)) {
        $n = str_replace(',', '', $n);
    }
    return number_format($n, is_float($n + 1) ? 0 : 0, ".", ",");
}
function numN($n,$a=1,$b=2,$c=3,$d=4) {
    if (empty($n)) {
        $n = 0;
    }
    if (!is_numeric($n)) {
        $n = str_replace(',', '', $n);
    }
    if(floatval($n)==0){
        return "";
    }
    return number_format($n, is_float($n + 1) ? 3 : 0, ".", ",");
}
function numR($n) {
    $n=str_replace(',', '', $n);
    $n=str_replace(' ', '', $n);
    return str_replace(',', '', $n);
}

function dochangtram($so) {
    $chuso = array();
    $chuso[1] = "một";
    $chuso[5] = "năm";
    $chuso[2] = "hai";
    $chuso[6] = "sáu";
    $chuso[3] = "ba";
    $chuso[7] = "bảy";
    $chuso[4] = "bốn";
    $chuso[8] = "tám";
    $chuso[9] = "chín";
    $donvi = $so % 10;
    $tram = floor($so / 100);
    $chuc = floor(($so - 100 * $tram) / 10);
    $docso = "";
    if ($chuc == 0) {
        if ($tram == 0) {
            if ($donvi != 0) {
                $docso = $chuso[$donvi];
            }
            return $docso;
        } else if ($donvi != 0) {
            $docso = $chuso[$tram] . " trăm linh " . $chuso[$donvi];
            return $docso;
        } else {
            $docso = $chuso[$tram] . " trăm";
        }
    } else if ($chuc == 1) {
        if ($donvi == 5) {
            $docso = "m­ười lăm";
        } else {
            $docso = "m­ười " . ($donvi != 0 ? $chuso[$donvi] : '');
        }
        if ($tram != 0) {
            $docso = $chuso[$tram] . " trăm " . $docso;
        }
    } else {
        if ($donvi == 5) {
            $docso = $chuso[$chuc] . " mươi lăm";
        } else if ($donvi == 1) {
            $docso = $chuso[$chuc] . " mươi mốt";
        } else {
            $docso = $chuso[$chuc] . " mươi " . ($donvi != 0 ? $chuso[$donvi] : '');
        }
        if ($tram != 0) {
            $docso = $chuso[$tram] . " trăm " . $docso;
        }
    }
    return $docso;
}

?>
