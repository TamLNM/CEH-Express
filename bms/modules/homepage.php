<?php

//Writen by Do Thanh Hai
//Copyright EDAJSC@2009	
include ("bms/classes/modules.php");

class homepage extends modules {

    function homepage() {
        
    }

    function child_run() {
        global $action, $sessions, $db, $file_tmp, $err_msg, $return_val, $transfer;
        switch ($action->eda_code) {
                case ("api"):
                header('Content-Type: application/json');
                if(file_exists("bms/templates/api/".preg_replace('/[^A-Za-z0-9\-]/', '', @$_GET['load']).".htm"))
                    include("bms/templates/api/".preg_replace('/[^A-Za-z0-9\-]/', '', @$_GET['load']).".htm");
                else
                    die('');
                $transfer=true;
                break;
        }
        if ($action->eda_module != "waranty/view_waranty_process" && $action->eda_code != md5("find_waranty") && $sessions->get_session("login") != "logined" && $action->eda_code != md5("login") && $action->eda_code != md5("in") && $action->eda_code != md5("reg") && $action->eda_code != md5("forgot") && $transfer == false) {
            include("bms/templates/login.htm");
            $transfer=true;
        } else {
            switch ($action->eda_code) {









case md5("phat_hanh_hd") :
                $sohd=intval(@$_POST['sohd']);
                $khhd=safe_str(@$_POST['khhd']);
                $inv_id=safe_str(@$_POST['inv_id']);
                $ghichu=safe_str(@$_POST['ghichu']);
                    $data = array();
                    if($inv_id<=0){
                        $data['err']="Thiếu dữ liệu đơn hàng !";
                    }
                    if($khhd==""){
                        $data['err']="Chưa nhập ký hiệu hóa đơn !";
                    }
                    if(isset($_POST['sohd']) && @$_POST['sohd']==""){
                        $data['err']="Chưa nhập số hóa đơn !";
                    }
                    if(@$data['err']!=""){
                        echo json_encode($data);die();
                    }
                    $inv=get_data("select * from out_invoices where inv_id='$inv_id' ");
                    $check=get_data("select * from out_invoices where khhd='$khhd' and sohd=$sohd ");
                    if(is_array($check) && count($check)>0){
                        if($inv_id!=$check[0]['inv_id']){
                            $data['err']="Số hóa đơn đã tồn tại !";
                        }
                        else
                        $data['err']="Không thể in lại hóa đơn !";
                    }
                    else
                    {
                        //$db->query("update out_invoices set khhd='$khhd', sohd='$sohd', phathanh=".time()." where inv_id=".$inv_id);
                        $db->query("update out_invoices set hd_note='$ghichu',khhd='$khhd', sohd='$sohd', phathanh=".time()." where inv_id=".$inv_id);
                        $db->query("update caidat_hoadon set hientai=$sohd where stock_id=".$inv[0]['stock_id']." and khhd='$khhd'");

                        $data['success']="Đã lưu thông tin hóa đơn !";
                    }
                    if(is_array($data))
                    echo json_encode($data);
                    else
                    echo "[]";
                    die();
                    break;



case md5("load_area_mat_price") :
                $area_id=intval(@$_POST['area_id']);
                    $area_price = get_data("select ap.*,mat.mat_name,mat.mat_id,mat.mat_model from area_price ap,mat_msu mms,materials mat where ap.mms_id=mms.mms_id and mms.mat_id=mat.mat_id and ap.area_id=".$area_id);
                    if(is_array($area_price))
                    echo json_encode($area_price);
                    else
                    echo "[]";
                    die();
                    break;
                    
case md5("save_area_mat_price") :
                $data=(@$_POST['matlist']);
                $area_id=intval(@$_POST['area_id']);
                if($area_id>0){
                    $db->query("delete from area_price where area_id=".$area_id);
foreach ($data as $key => $mat) {
                    if(intval($mat['price'])>0){
                        $check = get_data("select * from mat_msu where mms_id=".intval(@$mat['mms_id']));
                        if(is_array($check)){
                            $db->query("insert into area_price(area_id,mms_id,price,tg) values(".$area_id.",".intval(@$mat['mms_id']).",".numR(@$mat['price']).",".time().")");
                        }
                        else
                            die('{"deny":"Lỗi không có sản phẩm !"}');
                    }
                    else
                        die('{"deny":"Lỗi chưa ghi giá !"}');
                    }
                }
                else
                    die('{"deny":"Lỗi chưa chọn khu vực !"}');

                
                    
                    die('{"success":"Lưu thành công tất cả !"}');
                    break;



case md5("load_plist_mat_price") :
                $plist_id=intval(@$_POST['plist_id']);
                    $plist_price = get_data("select ap.*,mat.mat_name,mat.mat_id,mat.mat_model from plist_price ap,mat_msu mms,materials mat where ap.mms_id=mms.mms_id and mms.mat_id=mat.mat_id and ap.plist_id=".$plist_id);
                    if(is_array($plist_price))
                    echo json_encode($plist_price);
                    else
                    echo "[]";
                    die();
                    break;

case md5("save_plist_mat_price") :
                $data=(@$_POST['matlist']);
                $plist_id=intval(@$_POST['plist_id']);
                if($plist_id>0){
                    $db->query("delete from plist_price where plist_id=".$plist_id);
foreach ($data as $key => $mat) {
                    if(intval($mat['price'])>0){
                        $check = get_data("select * from mat_msu where mms_id=".intval(@$mat['mms_id']));
                        if(is_array($check)){
                            $db->query("insert into plist_price(plist_id,mms_id,price,tg) values(".$plist_id.",".intval(@$mat['mms_id']).",".numR(@$mat['price']).",".time().")");
                        }
                        else
                            die('{"deny":"Lỗi không có sản phẩm !"}');
                    }
                    else
                        die('{"deny":"Lỗi chưa ghi giá !"}');
                    }
                }
                else
                    die('{"deny":"Lỗi chưa chọn khu vực !"}');

                
                    
                    die('{"success":"Lưu thành công tất cả !"}');
                    break;



















                case md5("find_waranty"):
                    $file_tmp = "find_waranty.htm";
                    break;
                case md5("inprice_table"):
                    $mms_id=intval($_POST["key"]);
                    $chk = get_data("select invd.mms_id,invd.invd_id,invd.inv_id,mms.mat_id,mat.mat_name,inv.created_date,inv.inv_code,invd.price,invd.mat_quantity,invd.stock_id,stock.stock_name,msu.msu_name from invoices inv, invoice_details invd, meansure msu, materials mat, stocks stock, mat_msu mms where msu.msu_id=mms.msu_id and mms.mat_id=mat.mat_id and inv.inv_id=invd.inv_id and invd.stock_id=stock.stock_id and invd.mms_id=mms.mms_id and invd.mms_id='".$mms_id."'");
                    $rt=array();
                    
                    foreach ($chk as $key => $value) {
                    if(!isset($stock[$value['stock_id']]))
                        $stock[$value['stock_id']]=get_data("select smm_id from stock_mat_msu where mms_id=".intval($value['mms_id'])." and stock_id=".intval($value['stock_id']));
                    if(!isset($sum[$value['stock_id']]))
                        $sum[$value['stock_id']]=$this->get_instock($value,time(),$value['stock_id']);
                        $get_out=get_data("select sum(mat_quantity) tong from out_invoice_details where inv=".$value['invd_id']);
                        $has=$value['mat_quantity']-intval(@$get_out[0][0]);
                        $rt[]=array("has"=>$has,"smm_id"=>intval(@$stock[$value['stock_id']][0]['smm_id']),"sum"=>intval(@$sum[$value['stock_id']]['sum']),"info"=>$sum[$value['stock_id']],"invd_id"=>intval(@$value['invd_id']),"mat_name"=>$value['mat_name'],"created_date"=>date("d/m/Y H:i",$value['created_date']),"inv_code"=>($value['inv_code']),"price"=>$value['price'],"inv_id"=>$value['inv_id'],"stock_id"=>$value['stock_id'],"stock_name"=>$value['stock_name'],"msu_name"=>$value['msu_name'],"quantity"=>$value['mat_quantity']);
                    }



$chk = get_data("select smm.smm_id,sr.s_price ,sr.serial_end,sr.serial_start,sr.mms_id,mms.mat_id,mat.mat_name,stock.stock_name,stock.stock_id,msu.msu_name from serials sr,stock_mat_msu smm, meansure msu, materials mat, stocks stock, mat_msu mms where sr.mms_id=mms.mms_id and sr.mms_id=mms.mms_id and sr.smm_id=smm.smm_id and msu.msu_id=mms.msu_id and mms.mat_id=mat.mat_id and smm.stock_id=stock.stock_id and smm.mms_id=mms.mms_id and sr.mms_id='".$mms_id."' and sr.invd_id is null");

foreach ($chk as $key => $value) {
                    if(!isset($stock[$value['stock_id']]))
                        $stock[$value['stock_id']]=get_data("select smm_id from stock_mat_msu where mms_id=".intval($value['mms_id'])." and stock_id=".intval($value['stock_id']));
                    if(!isset($sum[$value['stock_id']]))
                        $sum[$value['stock_id']]=$this->get_instock($value,time(),$value['stock_id']);
                        $get_out=get_data("select count(serial_id) tong from out_serials osr,out_invoice_details invd where invd.invd_id=osr.invd_id and (".(intval($value['serial_end'])==0?"osr.serial_start=".$value['serial_start']." and osr.serial_end is null":"osr.serial_start>=".$value['serial_start']." and osr.serial_start<=".$value['serial_end']." and osr.serial_end is null")." ) ");
                        $has=1-intval(@$get_out[0][0]);
                        $rt[]=array("has"=>$has,"smm_id"=>intval(@$stock[$value['stock_id']][0]['smm_id']),"sum"=>intval(@$sum[$value['stock_id']]['sum']),"info"=>$sum[$value['stock_id']],"invd_id"=>(0-intval(@$value['serial_start'])),"mat_name"=>$value['mat_name'],"created_date"=>date("d/m/Y H:i",time()),"inv_code"=>"Hàng tách","price"=>$value['s_price'],"inv_id"=>(0-intval(@$value['serial_start'])),"stock_id"=>$value['stock_id'],"stock_name"=>$value['stock_name'],"msu_name"=>$value['msu_name'],"quantity"=>1);
                    }


                    echo json_encode($rt);die();
                    break;
    case md5("load_fund_type"):
                    $fundt_id=intval($_POST["key"]);
                    $chk = get_data("select * from fund_type where fund_type_id=".$fundt_id);
                    $rt=array();
                    if(is_array($chk) && count($chk)>0){
                        $rt=$chk[0];
                    }
                    echo json_encode($rt);die();
                    break;
    case md5("update_fund_type"):
                    $fund_type_id=intval(@$_POST["fund_type_id"]);
                    $fund_type_code=(@$_POST["fund_type_code"]);
                    $fund_type_name=(@$_POST["fund_type_name"]);
                    $orderby=intval($_POST["orderby"]);
                    $description=(@$_POST["description"]);
                    $ft_currency=(@$_POST["ft_currency"]);
                    $updated_time=time();
                    $updated_by=intval(@$_SESSION['user_id']);
                    if($updated_by<=0){
                        die('{"deny":"Error !"}');
                    }
                    $db->query("update fund_type set fund_type_code='$fund_type_code',orderby=$orderby,description='$description',updated_time='$updated_time',updated_by='$updated_by',ft_currency='$ft_currency',fund_type_name='$fund_type_name' where fund_type_id=$fund_type_id");
                    die('{"success":"Update Ok !"}');
                    break;


    case md5("save_mat"):
                    $data=$_POST['data'];
                    foreach ($data as $key => $value) {
                        $mms_id=intval(@$value['mms_id']);
                        $mat_name=@$value['mat_name'];
                        $mat_model=@$value['mat_model'];
                        $price=numR(@$value['price']);
                        $findmat=get_data("select * from mat_msu where mms_id=".$mms_id);
                        if( is_array($findmat) && count($findmat)>0){
                            $mms=$findmat[0];
                            $db->query("update mat_msu set price=$price where mms_id=".$mms['mms_id']);
                            $db->query("update materials set mat_name='$mat_name' , mat_model='$mat_model' where mat_id=".$mms['mat_id']);
                        }
                    }
                die('{"success":"Update Ok !"}');
    break;

case md5("save_cus"):
                    $data=$_POST['data'];
                    foreach ($data as $key => $value) {
                        //print_r($value);die();
                        $cus_id=intval(@$value['cus_id']);
                        $cus_code=@$value['cus_code'];
                        $cus_name=@$value['cus_name'];
                        $address=@$value['address'];
                        $tel=@$value['tel'];
                        $tax_no=@$value['tax_no'];
                        $comment=@$value['comment'];

                        $findmat=get_data("select * from customers where cus_id=".$cus_id);
                        if( is_array($findmat) && count($findmat)>0){
                            $mms=$findmat[0];
                            $db->query("update customers set comment='$comment',cus_code='$cus_code' , cus_name='$cus_name' , address='$address' , tel='$tel' , tax_no='$tax_no' where cus_id=".$mms['cus_id']);
                        }
                        else
                        die('{"deny":"không tồn tại !"}');
                    }
                die('{"success":"Update Ok !"}');
    break;

    case md5("add_fund_type"):
                    $fund_type_id=intval(@$_POST["fund_type_id"]);
                    $fund_type_code=(@$_POST["fund_type_code"]);
                    $fund_type_name=(@$_POST["fund_type_name"]);
                    $orderby=intval($_POST["orderby"]);
                    $description=(@$_POST["description"]);
                    $created_time=time();
                    $created_by=intval(@$_SESSION['user_id']);
                    $ft_level=0;
                    $ft_currency=(@$_POST["ft_currency"]);
                    $parent_id=intval(@$_POST["parent_id"]);
                    $query_list="";
                    if($parent_id>0){
                        $par = get_data("select * from fund_type where fund_type_id=".$fund_type_id);
                        if(is_array($par) && count($par)>0){
                            $ft_level=intval($par[0]['ft_level'])+1;
                        }
                        $prl=get_fund_parent($parent_id);
                        $ft_level=intval($prl['level']);
                        $query_list=join(",",$prl['id_list']);
                    }
                    if($created_by<=0){
                        die('{"deny":"Error !"}');
                    }
                    ///// chưa xong
                    $db->query("insert into fund_type(fund_type_code,fund_type_name,orderby,description,ft_level,query_list,parent_id,ft_currency,created_by,created_time) values ('$fund_type_code','$fund_type_name','$orderby','$description','$ft_level','$query_list','$parent_id','$ft_currency','$created_by','$created_time')");

                    die('{"success":"Add Ok !"}');

                    break;
case md5("get_alert") :
                $user_id=intval($_SESSION['user_id']);
                $reback=array();
                $reback['exp']=array();
                $reback['qty']=array();
                if(intval(@$user_id)<=0)die();
                $data2 = get_data("SELECT mat.mat_name,sum(smm.quantity) s_qty,mat.alert_qty FROM materials mat, mat_msu mms, stock_mat_msu smm                     
                 WHERE smm.mms_id=mms.mms_id and mms.mat_id=mat.mat_id and mat.alert_qty>=0 group by mms.mms_id having sum(smm.quantity)<=mat.alert_qty");
                
                if(intval(@count($data2))>0)
                {
                    $reback['qty']=$data2;
                }
                echo json_encode($reback);
                die();
                break;
    case md5("rmv_fund_type"):
                    $fund_type_id=intval(@$_POST["fund_type_id"]);
                    
                    $db->query("delete from fund_type where fund_type_id=".$fund_type_id);
                    die('{"success":"Delete Ok !"}');

                    break;
    case md5("inv_select"):
                    $cus_id=intval($_POST["key"]);
                    $chk = get_data("select * from out_invoices where payment<total and cus_id=".$cus_id);
                    $rt=array();
                    foreach ($chk as $key => $value) {
                        $chkppadd = get_data("select sum(pp_price) from phuphi where pp_show=0 and pp_type=0 and inv_id=".$value['inv_id']);
                        $chkpprmv = get_data("select sum(pp_price) from phuphi where pp_show=0 and pp_type=1 and inv_id=".$value['inv_id']);
                        $no=$value['total']-floatval($value['payment']);
                        $totalpay=$value['total']+floatval(@$chkppadd[0][0])-floatval(@$chkpprmv[0][0]);
                        $rt[]=array("inv_id"=>($value['inv_id']),"inv_code"=>($value['inv_code']),"vat_price"=>$value['vat_price'],"total"=>$value['total'],"created_date"=>date("d/m/Y H:i:s",$value['created_date']),"max_time"=>date("d/m/Y H:i:s",$value['max_time']),"pp_add"=>floatval(@$chkppadd[0][0]),"pp_rmv"=>floatval(@$chkpprmv[0][0]),"totalpay"=>floatval(@$no),"payment"=>floatval(@$value['payment']),"no"=>floatval(@$no),"comment"=>$value['comment']);
                    }
                    echo json_encode($rt);die();
                    break;
                case md5("inv_vat_select"):
                    $chk = get_data("select * from out_invoices inv where inv.total >0 and inv.inv_id not in (select oinv_id from budget_invoices bin,item_type itt where itt.item_id=bin.item_id and itt.item_name='Đóng VAT')");
                    $rt=array();
                    foreach ($chk as $key => $value) {
                        $chkppadd = get_data("select sum(pp_price) from phuphi where pp_show=0 and pp_type=0 and inv_id=".$value['inv_id']);
                        $chkpprmv = get_data("select sum(pp_price) from phuphi where pp_show=0 and pp_type=1 and inv_id=".$value['inv_id']);
                        $no=$value['total']-floatval($value['payment']);
                        $totalpay=$value['total']+floatval(@$chkppadd[0][0])-floatval(@$chkpprmv[0][0]);
                        $rt[]=array("inv_id"=>($value['inv_id']),"inv_code"=>($value['inv_code']),"vat_price"=>$value['vat_price'],"total"=>$value['total'],"created_date"=>date("d/m/Y H:i:s",$value['created_date']),"max_time"=>date("d/m/Y H:i:s",$value['max_time']),"pp_add"=>floatval(@$chkppadd[0][0]),"pp_rmv"=>floatval(@$chkpprmv[0][0]),"totalpay"=>floatval(@$no),"payment"=>floatval(@$value['payment']),"no"=>floatval(@$no),"comment"=>$value['comment']);
                    }
                    echo json_encode($rt);die();
                    break;
                case md5("findmat"):
                    $key=$db->escape_string($_POST["key"]);
                    $chk = get_data("select smm.quantity,mat.cat_id,mat.mat_name,mat.mat_id,stock.stock_name,stock.stock_id,mms.mms_id,smm.smm_id,msu.msu_id,msu.msu_name from meansure msu, materials mat,stocks stock,mat_msu mms,stock_mat_msu smm where msu.msu_id=mms.msu_id and smm.mms_id=mms.mms_id and stock.stock_id=smm.stock_id and mms.mat_id=mat.mat_id and smm.quantity>0 and mat.mat_name like '%".$key."%' limit 5");
                    $rt=array();
                    foreach ($chk as $key => $value) {
                        $rt[]=array("mat_name"=>($value['mat_name']),"mat_id"=>intval($value['mat_id']),"stock_name"=>$value['stock_name'],"stock_id"=>$value['stock_id'],"mms_id"=>$value['mms_id'],"smm_id"=>$value['smm_id'],"quantity"=>$value['quantity'],"msu_id"=>$value['msu_id'],"msu_name"=>$value['msu_name'],"cat_id"=>$value['cat_id']);
                    }
                    echo json_encode($rt);die();
                    break;
                case md5("load_seria"):
                    $chk = get_data("select * from serials invd where smm_id='" . $return_val['smm_id'] . "'");
                    $rt=array();
                    foreach ($chk as $key => $value) {
                        $getinv = get_data("select inv.inv_id,inv.inv_code from invoices inv,invoice_details invd where inv.inv_id=invd.inv_id and invd.invd_id='" . $value['invd_id'] . "'");
                        $inv_id=intval(@$getinv[0]['inv_id']);
                        $inv_code=(@$getinv[0]['inv_code']);
                        if($inv_id==0)
                            $inv_code="Sp được tách";
                        $rt[]=array("inv_id"=>intval(@$inv_id),"invd_id"=>intval(@$value['invd_id']),"inv_code"=>(@$inv_code),"serial_start"=>intval($value['serial_start']),"serial_start"=>intval($value['serial_start']),"serial_end"=>intval($value['serial_end']),"s_price"=>$value['s_price']);
                    }
                    echo json_encode($rt);die();
                    break;
                case md5("get_seria_price"):
                $return_val['mms_id']=intval(@$return_val['mms_id']);
                $mar=explode(";", $return_val['serial_list']);
                $ser=array();
                foreach ($mar as $key => $value) {
                    $value=preg_replace('/[^0-9\-]/', '', $value);
                    $ser[$value]=$value;
                }
                $rt=array();
                foreach ($ser as $key => $value) {
                    $mar=explode("-", $key);
                    if(count($mar)>1){
                        $chk = get_data("select * from serials where mms_id='" . $return_val['mms_id'] . "' and (serial_start<=".intval($mar[0])." and serial_end>=".intval($mar[1]).")");
                    }
                    else{
                        $chk = get_data("select * from serials where mms_id='" . $return_val['mms_id'] . "' and ((serial_start<=".intval($key)." and serial_end>=".intval($key)." and serial_end is not null) or (serial_start=".intval($key)." and serial_end is null))");
                    }            
                    
                    foreach ($chk as $key => $value) {
                        $rt[]=array("serial_start"=>intval(@$mar[0]),"serial_end"=>intval(@$mar[1]),"s_price"=>intval($value['s_price']));
                    }
                }
                    echo json_encode($rt);die();
                    break;
                case md5("add_cus"):
                    $chk = get_data("select cus_name from customers where cus_name='" . $return_val ['cus_name'] . "'");
                    if (count($chk) > 0) {
                        echo "duplicate";
                    } else {
                        $max_cus = get_data("select max(cus_id) from customers");
                        $return_val ['cus_code'] = 'KH' . str_pad($max_cus [0] [0] + 1, 8, '0', STR_PAD_LEFT);
                        $db->query("insert into customers(cus_name, cus_code, address, tel, cus_type, debt) 
                                    values('" . $return_val ['cus_name'] . "', '" . $return_val ['cus_code'] . "', '" . $return_val ['address'] . "', '" . $return_val ['tel'] . "', 'LE', 0)");
                        echo $return_val ['cus_code'];
                    }
                    break;
                case md5("add_sup"):
                    $chk = get_data("select sup_name from supliers where sup_name='" . $return_val ['sup_name'] . "'");
                    if (count($chk) > 0) {
                        echo "duplicate";
                    } else {
                        $db->query("insert into supliers(sup_name, address, tel) 
                                    values('" . $return_val ['sup_name'] . "', '" . $return_val ['address'] . "', '" . $return_val ['tel'] . "')");
                        echo $return_val ['sup_name'];
                    }
                    break;
                case md5("load_sup_mat") :
                    $mat = get_data("select mat.mat_id, mat.mat_name from materials mat, sup_mat sma, categories cat where sma.sup_id='" . $action->eda_id . "' and sma.mat_id=mat.mat_id and mat.cat_id=cat.cat_id and cat.cat_type='XD'");
                    for ($i = 0; $i < count($mat); $i++) {
                        echo $mat [$i] ['mat_id'] . '</value>' . $mat [$i] ['mat_name'] . '</name>';
                    }
                    break;
                case md5('getSup'):
                    $dt = get_data("select * from supliers where sup_id='" . $action->eda_id . "'");
                    $str = '[';
                    for ($i = 0; $i < count($dt); $i++) {
                        $str.='{';
                        foreach ($dt[$i] as $k => $v) {
                            $str.='"' . $k . '":"' . str_replace('"', '\"', $v) . '",';
                        }
                        $str = substr($str, 0, -1);
                        $str.='},';
                    }
                    $str = substr($str, 0, -1);
                    $str.=']';
                    echo $str;
                    break;
                case md5('getCus'):
                $dt=array();
                    if ($action->eda_id == 0) {
                        $dt = get_data("select * from customers where cus_name='Khách lẻ' limit 1");
                        if (count($dt) == 0) {
                            $max_cus = get_data("select max(cus_id) from customers");
                            $db->query("begin");
                            $db->query("insert into customers(cus_name, cus_code) values('Khách lẻ','KH" . str_pad($max_cus [0] [0] + 1, 8, '0', STR_PAD_LEFT) . "')");
                            $max_cus = get_data("select max(cus_id) from customers");
                            $action->eda_id = $max_cus[0][0];
                            $db->query("commit");
                            $dt = get_data("select * from customers where cus_id='" . $action->eda_id . "'");
                        }
                    } else {
                        $dt = get_data("select * from customers where cus_id='" . $action->eda_id . "'");
                    }
                    if(count($dt)>0){
                        $dt[0]['debt_info']=getDebtCusId($dt[0]['cus_id']);
                    }
                    
                    echo json_encode($dt,true);die();
                    break;
                case md5('get_stock_quantity'):
                $mms_id=intval(@$_POST['mms_id']);
                $stock_id=intval(@$_POST['stock_id']);
                $time=intval(@$_POST['time']);
                $oin=array("mms_id"=>$mms_id);
                if($time<=0)$time=time();
                $arrx=$this->get_instock($oin,$time,$stock_id);
                echo json_encode($arrx);
                die();
                    break;
                case md5('getCusCode'):
                    $max_cus = get_data("select max(cus_id) from customers");
                    $str = '[';
                    $str.='{';
                    $str.='"cus_code":"' . 'KH' . str_pad($max_cus [0] [0] + 1, 8, '0', STR_PAD_LEFT) . '"';
                    $str.='}';
                    $str.=']';
                    echo $str;
                    break;
                case md5('getSupCode'):
                    $max_sup = get_data("select max(sup_id) from supliers");
                    $str = '[';
                    $str.='{';
                    $str.='"sup_code":"' . 'NCC' . str_pad($max_sup [0] [0] + 1, 8, '0', STR_PAD_LEFT) . '"';
                    $str.='}';
                    $str.=']';
                    echo $str;
                    break;
                case md5("load_mfa") :
                    include ("bms/templates/load_mfa.htm");
                    break;
                case md5("load_stock_emp"):
                    $usr = get_data("select u.* from users u, stocks s where (s.user_id=u.user_id or concat(',',s.user_list,',') like concat('%,',u.user_id,',%')) and s.stock_id='" . $action->eda_id . "'");
                    for ($i = 0; $i < count($usr); $i++)
                        echo $usr [$i] ['user_id'] . '</value>' . $usr [$i] ['full_name'] . " (" . $usr [$i] ['user_name'] . ')</name>';
                    break;
                case md5("load_cat_mat") :
                    $mat = get_data("select mat_id, mat_name from materials mat where cat_id='" . $action->eda_id . "' " . (!empty($action->eda_cid) ? " and mat_id in(select mat_id from mfa_mat where mfa_id='" . $action->eda_cid . "') " : "") . "");
                    for ($i = 0; $i < count($mat); $i++) {
                        echo $mat [$i] ['mat_id'] . '</value>' . $mat [$i] ['mat_name'] . '</name>';
                    }
                    break;
                case md5("load_msu") :
                    $mms = get_data("select mms.mms_id, msu.msu_name from mat_msu mms, meansure msu where mms.mat_id='" . $action->eda_id . "' and mms.msu_id=msu.msu_id order by msu.msu_multiple desc");
                    for ($i = 0; $i < count($mms); $i++) {
                        echo $mms [$i] ['mms_id'] . '</value>' . $mms [$i] ['msu_name'] . '</name>';
                    }
                    break;
                case md5("load_msu_smm") :
                    $mms = get_data("select smm.smm_id, msu.msu_name from stock_mat_msu smm, mat_msu mms, meansure msu where mms.mat_id='" . $action->eda_id . "' and mms.msu_id=msu.msu_id and mms.mms_id=smm.mms_id and smm.stock_id='" . intval($return_val['stock_id']) . "' order by msu.msu_multiple desc");
                    for ($i = 0; $i < count($mms); $i++) {
                        echo $mms [$i] ['smm_id'] . '</value>' . $mms [$i] ['msu_name'] . '</name>';
                    }
                    break;
                case md5("load_msu_price") :
                    $mms = get_data("select mms.price, msu.msu_name from mat_msu mms, meansure msu where mms.mat_id='" . $action->eda_id . "' and mms.msu_id=msu.msu_id order by msu.msu_multiple desc");
                    for ($i = 0; $i < count($mms); $i++) {
                        echo $mms [$i] ['price'] . '</value>' . $mms [$i] ['msu_name'] . '</name>';
                    }
                    break;
                case md5("load_cat_mat_split") :
                    $mat = get_data("select mat_id, mat_name from materials mat where cat_id='" . $action->eda_id . "'");
                    for ($i = 0; $i < count($mat); $i++) {
                        $chk = get_data("select mms.mms_id from stock_mat_msu smm, mat_msu mms, meansure msu where mms.mat_id='" . $mat[$i]['mat_id'] . "' and mms.mms_id=smm.mms_id and smm.stock_id='" . $return_val['stock_id'] . "' and smm.quantity>0 and mms.msu_id=msu.msu_id limit 1");
                        if (count($chk) > 0) {
                            echo $mat [$i] ['mat_id'] . '</value>' . $mat [$i] ['mat_name'] . '</name>';
                        }
                    }
                    break;
                case md5("load_msu_split") :
                    $mms = get_data("select smm.smm_id, msu.msu_name from stock_mat_msu smm, mat_msu mms, meansure msu where mms.mat_id='" . $action->eda_id . "' and mms.msu_id=msu.msu_id and mms.mms_id=smm.mms_id and smm.stock_id='" . $return_val['stock_id'] . "' order by msu.msu_multiple desc");
                    for ($i = 0; $i < count($mms); $i++) {
                        echo $mms [$i] ['smm_id'] . '</value>' . $mms [$i] ['msu_name'] . '</name>';
                    }
                    break;
                case md5("load_msu_list") :
                    include ("bms/templates/load_msu_list.htm");
                    break;
                case md5("load_item_type") :
                    $item = get_data("select item_id, item_name from item_type where item_type='" . $action->eda_id . "'");
                    for ($i = 0; $i < count($item); $i++) {
                        echo $item [$i] ['item_id'] . '</value>' . $item [$i] ['item_name'] . '</name>';
                    }
                    break;
                case md5("get_msu_price") :
                    $chk = get_data("select mat.mat_price from materials mat, mat_msu mms, categories cat where mms.mms_id='" . $action->eda_id . "' and mms.mat_id=mat.mat_id and mat.cat_id=cat.cat_id and cat.cat_type='XD'");
                    if (count($chk) > 0) {
                        echo $chk [0] [0];
                    } else {
                        $pr = get_data("select price from mat_msu where mms_id='" . $action->eda_id . "'");
                        if (count($pr) > 0)
                            echo $pr [0] [0];
                        else
                            echo '0';
                    }
                    break;
                case md5("chk_serial"):
                    $chk_sell = get_data("select serial_start from out_serials os, out_invoices inv, out_invoice_details invd where invd.inv_id=inv.inv_id and os.invd_id=invd.invd_id and invd.smm_id='" . $action->eda_id . "' and (LENGTH('" . $_GET['serial_start'] . "')<=LENGTH(serial_start ) and  ( LPAD('" . $_GET['serial_start'] . "',LENGTH(serial_start ),'Z') = serial_start or LPAD('" . $_GET['serial_start'] . "',LENGTH(serial_start ),'Z') between serial_start and serial_end)) or (LENGTH('" . $_GET['serial_end'] . "')<=LENGTH(serial_end) and   LPAD('" . $_GET['serial_end'] . "',LENGTH(serial_start ),'Z') between serial_start and serial_end) limit 1");
                    if (count($chk_sell) > 0) {
                        echo "SELL|".intval(@$chk[0]['s_price']);
                    } else {
                        if (empty($_GET['serial_end'])) {
                            $chk = get_data("select serial_start,s_price from serials where smm_id='" . $action->eda_id . "' and LENGTH('" . $_GET['serial_start'] . "')<=LENGTH(serial_start ) and  (LPAD('" . $_GET['serial_start'] . "',LENGTH(serial_start ),'Z') = serial_start or LPAD('" . $_GET['serial_start'] . "',LENGTH(serial_start ),'Z') between serial_start and serial_end) limit 1");
                        } else {
                            $chk = get_data("select serial_start,s_price from serials where smm_id='" . $action->eda_id . "' and LENGTH('" . $_GET['serial_start'] . "')<=LENGTH(serial_start ) and LENGTH('" . $_GET['serial_end'] . "')<=LENGTH(serial_end) and  LPAD('" . $_GET['serial_start'] . "',LENGTH(serial_start ),'Z') between serial_start and serial_end and LPAD('" . $_GET['serial_end'] . "',LENGTH(serial_start ),'Z') between serial_start and serial_end limit 1");
                        }
                        if (count($chk) > 0) {
                            echo "TRUE|".intval(@$chk[0]['s_price']);
                        } else {
                            echo "FALSE|".intval(@$chk[0]['s_price']);
                        }
                    }
                    break;
                case md5("load_user") :
                    $user = get_data("select user_id, user_name, full_name from users where group_id='" . $action->eda_id . "'");
                    for ($i = 0; $i < count($user); $i++) {
                        echo $user [$i] ['user_id'] . '</value>' . $user [$i] ['full_name'] . " (" . $user [$i] ['user_name'] . ')</name>';
                    }
                    break;
                case md5("load_mat_return_stock"):
                    if (!isset($return_val['mat_return_type'])) {
                        $return_val['mat_return_type'] = 'SUP';
                    }
                    $stocks = array();
                    if ($return_val['mat_return_type'] == 'SUP') {
                        echo '<option value="">Nhập kho nhà cung cấp</option>';
                        echo 'stock</value>Nhập kho nhà cung cấp</name>';
                    } else if ($return_val['mat_return_type'] == 'CUS') {
                        $chk_mainstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='mainstock'");
                        $chk_empstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='empstock'");
                        if (count($chk_mainstock) > 0 && count($chk_empstock) > 0) {
                            $stocks = get_data("select stock_id, stock_name, user_id from stocks order by stock_name");
                        } else if (count($chk_mainstock) > 0) {
                            $stocks = get_data("select stock_id, stock_name, user_id from stocks where user_id is null or user_id='" . $sessions->get_session('user_id') . "'  order by stock_name");
                        } else {
                            $stocks = get_data("select stock_id, stock_name, user_id from stocks where user_id='" . $sessions->get_session('user_id') . "'  order by stock_name");
                        }
                    } else {
                        $chk_mainstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='mainstock'");
                        if (count($chk_mainstock) > 0) {
                            $stocks = get_data("select stock_id, stock_name, user_id from stocks where user_id is null order by stock_name");
                        }
                    }
                    for ($i = 0; $i < count($stocks); $i++) {
                        echo $stocks [$i] ['stock_id'] . '</value>' . $stocks [$i] ['stock_name'] . '</name>';
                    }
                    break;
                case md5("load_search_mat_return_stock"):
                    if (!isset($return_val['mat_return_type'])) {
                        $return_val['mat_return_type'] = 'SUP';
                    }
                    $stocks = array();
                    if ($return_val['mat_return_type'] == 'EMP') {
                        $stocks = get_data("select stock_id, stock_name, user_id from stocks where stock_id='" . $return_val['stock_id'] . "'  order by stock_name");
                    } else if ($return_val['mat_return_type'] == 'SUP') {
                        $chk_mainstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='mainstock'");
                        if (count($chk_mainstock) > 0) {
                            $stocks = get_data("select stock_id, stock_name, user_id from stocks where user_id is null order by stock_name");
                        }
                    } else {
                        $chk_mainstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='mainstock'");
                        $chk_empstock = get_data("select ugp.ugp_id from user_group_permission ugp, function_menu fmenu where (ugp.user_id='" . $sessions->get_session("user_id") . "' or ugp.group_id='" . $sessions->get_session("group_id") . "') and ugp.fmenu_id=fmenu.fmenu_id and fmenu_act='empstock'");
                        if (count($chk_mainstock) > 0 && count($chk_empstock) > 0) {
                            $stocks = get_data("select stock_id, stock_name, user_id from stocks order by stock_name");
                        } else if (count($chk_mainstock) > 0) {
                            $stocks = get_data("select stock_id, stock_name, user_id from stocks where user_id is null or user_id='" . $sessions->get_session('user_id') . "'  order by stock_name");
                        } else {
                            $stocks = get_data("select stock_id, stock_name, user_id from stocks where user_id='" . $sessions->get_session('user_id') . "'  order by stock_name");
                        }
                    }
                    for ($i = 0; $i < count($stocks); $i++) {
                        echo $stocks [$i] ['stock_id'] . '</value>' . $stocks [$i] ['stock_name'] . '</name>';
                    }
                    break;
                case md5("load_permission") :
                    include ("bms/templates/general/permission_detail.htm");
                    break;
                case md5("search_cus") :
                    include ("bms/templates/search_cus_result.htm");
                    break;
                case md5("search_emp") :
                    include ("bms/templates/search_emp_result.htm");
                    break;
                case md5("search_mat") :
                    include ("bms/templates/search_mat_result.htm");
                    break;
                case md5("chose_mat_instock") :
                    include ("bms/templates/chose_mat_instock.htm");
                    break;
                case md5("view_report") :
                    $action->title = "Xem báo cáo";
                    include ("bms/templates/view_report.htm");
                    break;
                case md5("excel_export") :
                    $action->title = "Xuất dữ liệu Excel";
                    include ("bms/modules/excel_export.php");
                    break;                
                case md5('search_sup') :
                    include ("bms/templates/search_sup_result.htm");
                    break;
                case md5("search_mat_stock") :
                    include ("bms/templates/search_mat_stock_result.htm");
                    break;
                case md5("search_mat_return") :
                    include ("bms/templates/search_mat_return_result.htm");
                    break;
                case md5("doc_so"):
                    echo doc_so($action->eda_module);
                    break;
                case md5("getmatfrommodel"):
                    if (@$return_val['input'] == 1) {
                        $mat = get_data("select mat.mat_name, mat.mat_id, mat.mat_model, mat.vat, mms.mms_id from materials mat, mat_msu mms   where mat.mat_model = '" . $action->eda_module . "' and mat.mat_id=mms.mat_id  limit 1");
                        if (count($mat) > 0) {
                            echo $mat[0]['mms_id'] . ":" . $mat[0]['mat_name'] . ":" . $mat[0]['mat_model'] . ":" . $mat[0]['mat_id'] . ":" . $mat[0]['vat'];
                        } else {
                            echo 'none';
                        }
                    } else {
                        $mat = get_data("select mat.mat_name, mat.vat, mat.mat_id, smm.smm_id, smm.stock_id, mms.mms_id, msu.msu_id, msu.msu_name, mat.mat_model, mms.price, mms.price_dealer, mms.price_dealer2 from materials mat, mat_msu mms, stock_mat_msu smm, meansure msu   where smm.stock_id='" . $action->eda_id . "'  and mat.mat_model = '" . $action->eda_module . "' and mat.mat_id=mms.mat_id and mms.mms_id=smm.mms_id and mms.msu_id=msu.msu_id  limit 1");
                        if (count($mat) > 0) {
                            echo $mat[0]['smm_id'] . ":" . $mat[0]['mms_id'] . ":" . $mat[0]['mat_name'] . ":" . $mat[0]['mat_model'] . ":" . $mat[0]['price'] . ":" . $mat[0]['price_dealer'] . ":" . $mat[0]['mat_id'] . ":" . $mat[0]['vat']. ":" . $mat[0]['price_dealer2'] ;
                        } else {
                            echo 'none';
                        }
                    }
                    break;
                case md5("getmatfrombarcode"):
                    if (@$return_val['input'] == 1) {
                        $mat = get_data("select mat.mat_name, mat.mat_id, mat.mat_model, mat.vat, mms.mms_id, mms.msu_id, mat.mat_model, mms.price, mms.price_dealer from materials mat, mat_msu mms  where mat.barcode = '" . $action->eda_module . "' and mat.mat_id=mms.mat_id limit 1");
                        if (count($mat) > 0) {
                            echo $mat[0]['mat_id'] . ":" . $mat[0]['msu_id'] . ":" . $mat[0]['mat_name']. ":" . $mat[0]['mat_model']. ":" . $mat[0]['vat'];
                        } else {
                            echo 'none';
                        }
                    } else {
                        $mat = get_data("select mat.mat_name, mat.vat, mat.mat_id, smm.smm_id, smm.stock_id, mms.mms_id, msu.msu_id, msu.msu_name, mat.mat_model, mms.price, mms.price_dealer, mms.price_dealer2 from materials mat, mat_msu mms, stock_mat_msu smm, meansure msu   where smm.stock_id='" . $action->eda_id . "'  and mat.barcode = '" . $action->eda_module . "' and mat.mat_id=mms.mat_id and mms.mms_id=smm.mms_id and mms.msu_id=msu.msu_id  limit 1");
                        if (count($mat) > 0) {
                            echo $mat[0]['smm_id'] . ":" . $mat[0]['mms_id'] . ":" . $mat[0]['mat_name'] . ":" . $mat[0]['mat_model'] . ":" . $mat[0]['price'] . ":" . $mat[0]['price_dealer'] . ":" . $mat[0]['mat_id'] . ":" . $mat[0]['vat']. ":" . $mat[0]['price_dealer2'] ;
                        } else {
                            echo 'none';
                        }
                    }
                    break;
                case md5("getmatfrom"):
                    if (@$return_val['input'] == 1) {
                        $mat = get_data("select mat.mat_name, mat.mat_id, mat.mat_model, mat.vat, mms.mms_id, mms.msu_id, mat.mat_model, mms.price, mms.price_dealer from materials mat, mat_msu mms  where mat.".$return_val['t']." = '" . $action->eda_module . "' and mat.mat_id=mms.mat_id limit 1");
                        if (count($mat) > 0) {
                            echo $mat[0]['mat_id'] . ":" . $mat[0]['msu_id'] . ":" . $mat[0]['mat_name']. ":" . $mat[0]['mat_model']. ":" . $mat[0]['vat'];
                        } else {
                            echo 'none';
                        }
                    } else {
                        $mat = get_data("select mat.mat_name, mat.vat, mat.mat_id, smm.smm_id, smm.stock_id, mms.mms_id, msu.msu_id, msu.msu_name, mat.mat_model, mms.price, mms.price_dealer, mms.price_dealer2 from materials mat, mat_msu mms, stock_mat_msu smm, meansure msu   where smm.stock_id='" . $action->eda_id . "'  and mat.".$return_val['t']." = '" . $action->eda_module . "' and mat.mat_id=mms.mat_id and mms.mms_id=smm.mms_id and mms.msu_id=msu.msu_id  limit 1");
                        if (count($mat) > 0) {
                            echo $mat[0]['smm_id'] . ":" . $mat[0]['mms_id'] . ":" . $mat[0]['mat_name'] . ":" . $mat[0]['mat_model'] . ":" . $mat[0]['price'] . ":" . $mat[0]['price_dealer'] . ":" . $mat[0]['mat_id'] . ":" . $mat[0]['vat']. ":" . $mat[0]['price_dealer2'] ;
                        } else {
                            echo 'none';
                        }
                    }
                    break;                    
                case md5("get_price_from_mms"):
                    if (@$return_val['input'] == 1) {
                        $mat = get_data("select mms.price_input, mms.discount_input from mat_msu mms where mms.mms_id='" . $action->eda_id . "' limit 1");
                        if (count($mat) > 0) {
                            echo $mat[0]['price_input'] . ":" . $mat[0]['discount_input'];
                        } else {
                            echo 'none';
                        }
                    } else {
                        $mat = get_data("select mms.price, mms.price_dealer from mat_msu mms where mms.mms_id='" . $action->eda_id . "' limit 1");
                        if (count($mat) > 0) {
                            echo $mat[0]['price'] . ":" . $mat[0]['price_dealer'];
                        } else {
                            echo 'none';
                        }
                    }
                    break;
                case md5("add_mat_quick"):
                    if (isset($_POST['mat_name'])) {
                        include("bms/modules/general.php");
                        $g = new general();
                        $db->query("begin");
                        $g->add_mat_sm();
                        $id = get_data("select max(mat_id) mat_id from materials");
                        $db->query("commit");
                        if (empty($err_msg)) {
                            $id = get_data("select mat_id, mat_name, mat_model from materials where mat_id='" . $id[0]['mat_id'] . "'");
                            $id2 = get_data("select min(mms_id) mms_id from mat_msu where mat_id='" . $id[0]['mat_id'] . "'");
                            echo "id:" . $id[0]['mat_id'] . ":" . $id[0]['mat_name'] . ":" . $id[0]['mat_model']. ":" . $id2[0]['mms_id'];
                        } else {
                            echo $err_msg;
                        }
                    } else {
                        include("bms/templates/add_mat_quick.htm");
                    }
                    break;
                case md5("get_cus_debt"):
                    if (!isset($return_val['created_date'])) {
                        $return_val['created_date'] = time();
                    }
                    if (empty($return_val['created_date'])) {
                        $return_val['created_date'] = time();
                    }
                    $debt_old = 0;
                    $debt_old1 = get_data("select cus.debt from customers cus where cus.cus_id='" . $action->eda_id . "'");
                    if (count($debt_old1) > 0) {
                        $debt_old+=$debt_old1[0][0];
                    }
                    $debt_old2 = get_data("select sum(IFNULL(inv.total,0)) amount  from out_invoices inv where ifnull(inv.draft,0)=0 and inv.created_date<" . $return_val['created_date'] . " and inv.cus_id='" . $action->eda_id . "'");
                    if (count($debt_old2) > 0) {
                        $debt_old+=$debt_old2[0][0];
                    }
                    $debt_old3 = get_data("select sum(IFNULL(bin.amount,0)) amount from budget_invoices bin where (bin.bin_type=0) and bin.created_date<" . $return_val['created_date'] . " and bin.cus_id='" . $action->eda_id . "'");

                    if (count($debt_old3) > 0) {
                        $debt_old-=$debt_old3[0][0];
                    }
                    $debt3 = get_data("select sum(IFNULL(total,0)) amount  from mat_return_invoices where paid_type=1 and created_date<" . $return_val['created_date'] . " group by cus_id  having cus_id='" . $action->eda_id . "'");
                    if (count($debt3) > 0) {
                        $debt_old-=$debt3[0][0];
                    }
                    echo $debt_old;
                    break;
                case md5("get_cus_debt"):
                    if (!isset($return_val['created_date'])) {
                        $return_val['created_date'] = time();
                    }
                    if (empty($return_val['created_date'])) {
                        $return_val['created_date'] = time();
                    }
                    $debt_old = 0;
                    $debt_old1 = get_data("select cus.debt from customers cus where cus.cus_id='" . $action->eda_id . "'");
                    if (count($debt_old1) > 0) {
                        $debt_old+=$debt_old1[0][0];
                    }
                    $debt_old2 = get_data("select sum(IFNULL(inv.total,0)) amount  from out_invoices inv where ifnull(inv.draft,0)=0 and inv.created_date<" . $return_val['created_date'] . " and inv.cus_id='" . $action->eda_id . "'");
                    if (count($debt_old2) > 0) {
                        $debt_old+=$debt_old2[0][0];
                    }
                    $debt_old3 = get_data("select sum(IFNULL(bin.amount,0)) amount from budget_invoices bin where (bin.bin_type=0) and bin.created_date<" . $return_val['created_date'] . " and bin.cus_id='" . $action->eda_id . "'");

                    if (count($debt_old3) > 0) {
                        $debt_old-=$debt_old3[0][0];
                    }
                    $debt3 = get_data("select sum(IFNULL(total,0)) amount  from mat_return_invoices where paid_type=1 and created_date<" . $return_val['created_date'] . " group by cus_id  having cus_id='" . $action->eda_id . "'");
                    if (count($debt3) > 0) {
                        $debt_old-=$debt3[0][0];
                    }
                    echo $debt_old;
                    break;
                case md5("excelload"):
                    if(isset($_FILES['excelfile']['tmp_name'])) {
                        $ext= pathinfo($_FILES['excelfile']['name'], PATHINFO_EXTENSION);
                        if(in_array($ext,array('xls','xlsx','ods'))) {
                            if(!file_exists("data/tmp")) {
                                mkdir("data/tmp");
                            }
                            move_uploaded_file($_FILES['excelfile']['tmp_name'], "data/tmp/".$sessions->get_session('user_name')."_excel.".$ext);
                            require_once 'bms/modules/excel_import.php';
                            $excel=new excel_import();
                            $sessions->set_session('excel_file',"data/tmp/".$sessions->get_session('user_name')."_excel.".$ext);
                            $data=@$excel->readWorkSheet("data/tmp/".$sessions->get_session('user_name')."_excel.".$ext);
                        } else {
                            $data='Vui lòng chọn file dữ liệu là excel';
                        }
                    } else {
                        $data="Vui lòng chọn file dữ liệu";
                    }
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    break;
                case md5("excelload_data"):
                    require_once 'bms/modules/excel_import.php';
                    $excel=new excel_import();
                    $data=@$excel->readValue($sessions->get_session('excel_file'),$_GET['worksheet']);
                    //$data=@$excel->loadHTML($sessions->get_session('excel_file'));
                    //echo $data;
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    break;
                case md5("excelimport_mat"):
                ini_set('max_execution_time', 300);
                ini_set('memory_limit', '256M');
                    unset($return_val['eda_type']);
                    unset($return_val['eda_code']);
                    $c=count($return_val);
                    for($i=0;$i<$c;$i++) {
                        foreach ($return_val[$i] as $key => $value) {
                            if($value=='null') {
                                $return_val[$i][$key]='';
                            }
                        }
                        $return_val[$i]['mat_name']=str_replace("'", '&apos;', $return_val[$i]['mat_name']);
                        $return_val[$i]['mat_name']=str_replace("\"", '&quot;', $return_val[$i]['mat_name']);
                        $return_val[$i]['cat_name']=str_replace("'", '&apos;', $return_val[$i]['cat_name']);
                        $return_val[$i]['cat_name']=str_replace("\"", '&quot;', $return_val[$i]['cat_name']);
                        $return_val[$i]['msu_name']=str_replace("'", '&apos;', $return_val[$i]['msu_name']);
                        $return_val[$i]['msu_name']=str_replace("\"", '&quot;', $return_val[$i]['msu_name']);
                        $mat=get_data("select mat_id from materials where mat_model='".$db->escape_string($return_val[$i]['mat_model'])."'".(!empty($return_val[$i]['barcode'])?" or barcode='".$db->escape_string($return_val[$i]['barcode'])."'":"")." or mat_name='".$db->escape_string($return_val[$i]['mat_name'])."'");
                        if(count($mat)>0) {
                            $chk=false;
                            echo "Sản phẩm ".$return_val[$i]['mat_name']." đã tồn tại trong CSDL<br>";
                        } else if(!empty($return_val[$i]['cat_name'])&&!empty($return_val[$i]['msu_name'])) {
                            $chk_cat=get_data("select cat_id from categories where cat_name='".$db->escape_string($return_val[$i]['cat_name'])."'");
                            if(count($chk_cat)>0) {
                                $catid=$chk_cat[0]['cat_id'];
                            } else {
                                $db->query("begin");
                                $db->query("insert into categories(cat_name) values('".$db->escape_string($return_val[$i]['cat_name'])."')");
                                $cat=get_data("select max(cat_id) cat_id from categories");
                                $catid=$cat[0]['cat_id'];
                                $db->query("commit");
                            }
                            $chk_msu=get_data("select msu_id from meansure where msu_name='".$db->escape_string($return_val[$i]['msu_name'])."'");
                            if(count($chk_msu)>0) {
                                $msuid=$chk_msu[0]['msu_id'];
                            } else {
                                $db->query("begin");
                                $db->query("insert into meansure(msu_name) values('".$db->escape_string($return_val[$i]['msu_name'])."')");
                                $msu=get_data("select max(msu_id) msu_id from meansure");
                                $msuid=$msu[0]['msu_id'];
                                $db->query("commit");
                            }
                            $db->query("begin");
                            $db->query("insert into materials(mat_name,mat_desc,mat_model,mat_waranty,barcode,vat,cat_id,pr,gai) values('".$db->escape_string($return_val[$i]['mat_name'])."','".$db->escape_string(@$return_val[$i]['mat_desc'])."','".$db->escape_string($return_val[$i]['mat_model'])."','".$db->escape_string(@$return_val[$i]['mat_waranty'])."','".$db->escape_string($return_val[$i]['barcode'])."','".intval($return_val[$i]['vat'])."',$catid,'".$db->escape_string($return_val[$i]['pr'])."','".$db->escape_string($return_val[$i]['gai'])."')");
                            $mat=get_data("select max(mat_id) mat_id from materials");
                            $matid=$mat[0]['mat_id'];
                            $db->query("insert into mat_msu(mat_id, msu_id,price,price_dealer,price_dealer2,price_input,discount_input) values($matid,$msuid,".floatval($return_val[$i]['price']).",".floatval(@$return_val[$i]['price_dealer']).",".floatval(@$return_val[$i]['price_dealer2']).",".floatval(@$return_val[$i]['price_input']).",".floatval(@$return_val[$i]['discount_input']).")");
                            $db->query("commit");
                        } else {
                            echo "Sản phẩm ".$return_val[$i]['mat_name']." thiếu thông tin".(!empty($return_val[$i]['cat_name'])?"":" danh mục").(!empty($return_val[$i]['msu_name'])?"":" đơn vị tính")."<br>";
                        }
                    }
                    echo "Đã nhập xong dữ liệu</br>";
                    break;












                    case md5("excelimport_sup"):
                    //print_r($return_val);die();
                    ini_set('max_execution_time', 300);
        ini_set('memory_limit', '256M');
                    $c=count($return_val);
                    for($i=0;$i<$c;$i++) {
                        if(@$return_val[$i]['sup_code']!=""){
                        $newrow['sup_name']=@$return_val[$i]['sup_name'];
                        $newrow['address']=@$return_val[$i]['address'];              
                        $newrow['tel']=@$return_val[$i]['tel'];
                        $newrow['email']=@$return_val[$i]['email'];
                        $newrow['website']=@$return_val[$i]['website'];
                        $newrow['tax_no']=@$return_val[$i]['tax_no'];
                        $newrow['description']=@$return_val[$i]['description'];
                        $newrow['reg_no']=@$return_val[$i]['reg_no'];
                        $newrow['bank_acc']=@$return_val[$i]['bank_acc'];
                        $newrow['bank_name']=@$return_val[$i]['bank_name'];
                        $newrow['debt']=floatval(@$return_val[$i]['debt']);
                        $newrow['sup_code']=@$return_val[$i]['sup_code'];
                        $supliers=get_data("select sup_code from supliers where sup_code='".$newrow['sup_code']."'");
                        if(intval(@count($supliers))<=0)
                        $db->query("insert into supliers(sup_name,address,tel,email,website,tax_no,description,reg_no,bank_acc,bank_name,debt,sup_code) values ('".$newrow['sup_name']."','".$newrow['address']."','".$newrow['tel']."','".$newrow['email']."','".$newrow['website']."','".$newrow['tax_no']."','".$newrow['description']."','".$newrow['reg_no']."','".$newrow['bank_acc']."','".$newrow['bank_name']."','".$newrow['debt']."','".$newrow['sup_code']."')");
                        }
                    }
                    echo "Đã nhập xong dữ liệu</br>";
                    break;


















                default :
                    $file_tmp = "welcome.htm";
                    break;
            }
        }
    }

}

?>
