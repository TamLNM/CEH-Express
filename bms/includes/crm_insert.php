<?php

function split_name($name) {

    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
    return array($first_name, $last_name);
}
function convert_tourl($str) {
      $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
      $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
      $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
      $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
      $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
      $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
      $str = preg_replace("/(đ)/", "d", $str);
      $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
      $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
      $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
      $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
      $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
      $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
      $str = preg_replace("/(Đ)/", "D", $str);
      $str = str_replace(" ", "-", str_replace("&*#39;","",$str));
      return $str;
  }
function crm_add_project($ord_trf_code,$sender_email,$receiver_email,$tongtien,$details=""){
	global $sessions;
    global $db;
	$tongtien=floatval(@$tongtien);
	$ord_trf_code=(@$ord_trf_code);
	$sender_email=trim(@$sender_email);
    $receiver_email=trim(@$receiver_email);
	$sender=get_data("select * from customer where email='".$sender_email."'");
    $receiver=get_data("select * from customer where email='".$receiver_email."'");
    //print_r($receiver);die();
	if(is_array($sender) && count($sender)>0 && is_array($receiver) && count($receiver)>0){
		$clientid1=@crm_add_customer($sender[0]);
        $clientid2=@crm_add_customer($receiver[0]);
        $clientid=intval($clientid1).",".intval($clientid2);
        if($details=="")
            $details="Đơn hàng số [" . $ord_trf_code . "]";
		$db->query("insert into tblprojects(
                name      ,
                description    ,
                status  ,
                clientid   ,
                billing_type,
                start_date          ,
                deadline     ,
                project_created          ,
                date_finished        ,
                progress        ,
                progress_from_tasks            ,
                project_cost     ,
                project_rate_per_hour      ,
                estimated_hours    ,
                addedfrom)            
                values(
                'Đơn [" . $ord_trf_code . "]',
                '" . $details . "',
                '2',
                '".$clientid."',
                '1',
                '" .date('Y-m-d') . "',
                NULL,
                '" .date('Y-m-d') . "',
                NULL,
                '0',
                '1',
                '" . $tongtien . "',
                '0',
                '0',
                '1'
            )");

        $project_id=$db->insert_id();
        

        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','available_features','".'a:15:{s:16:"project_overview";i:1;s:13:"project_tasks";i:1;s:18:"project_timesheets";i:1;s:18:"project_milestones";i:1;s:13:"project_files";i:1;s:19:"project_discussions";i:1;s:13:"project_gantt";i:1;s:15:"project_tickets";i:1;s:16:"project_invoices";i:1;s:17:"project_estimates";i:1;s:16:"project_expenses";i:1;s:20:"project_credit_notes";i:1;s:21:"project_subscriptions";i:1;s:13:"project_notes";i:1;s:16:"project_activity";i:1;}'."')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_tasks','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','create_tasks','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','edit_tasks','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','comment_on_tasks','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_task_comments','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_task_attachments','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_task_checklist_items','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','upload_on_tasks','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_task_total_logged_time','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_finance_overview','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','upload_files','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','open_discussions','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_milestones','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_gantt','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_timesheets','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_activity_log','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','view_team_members','1')");
        $db->query("insert into tblproject_settings(project_id,name,value) values ('".$project_id."','hide_tasks_on_main_tasks_table','1')");
        $dept_id=crm_add_dept('Sales');
        crm_add_inv($ord_trf_code);
        crm_add_pj_notifi($project_id,$dept_id,'not_staff_added_as_project_member',array("Đơn [" . $ord_trf_code . "]"));
        return $project_id;

	}
    else
    {
        //die("Khong ton tai ".$sender_email."========".$receiver_email);
    }
	return false;
}

function crm_add_customer($cusdata){
	global $sessions;
    global $db;
		$tblclients=get_data('select * from tblclients where company like "'.$cusdata['cus_name'].'"');
		if(is_array($tblclients) && count($tblclients)>0){
			$clientid=$tblclients[0]['userid'];
            return $clientid;
		}
		else{

$tblcustomers_groups=get_data('select * from tblcustomers_groups where name like "'.$cusdata['cus_type_name'].'"');
		if(is_array($tblcustomers_groups) && count($tblcustomers_groups)>0){
			$groupid=$tblcustomers_groups[0]['id'];
		}
		else{
			$db->query("insert into tblcustomers_groups(name) values('".$cusdata['cus_type_name']."')");
			$groupid=$db->insert_id();
		}


			$tblcountries=get_data('select * from tblcountries where iso2 like "'.$cusdata['nation_code'].'"');
			$db->query("insert into tblclients(
                company       ,
                vat    ,
                phonenumber  ,
                country    ,
                city,
                zip          ,
                state     ,
                address          ,
                website        ,
                datecreated        ,
                active            ,
                billing_street     ,
                billing_city      ,
                billing_state    ,
                billing_zip    ,
                billing_country    ,
                shipping_street    ,
                shipping_city    ,
                shipping_state    ,
                shipping_zip    ,
                shipping_country    ,
                longitude    ,
                latitude    ,
                default_language    ,
                default_currency    ,
                show_primary_contact    ,
                stripe_id    ,
                registration_confirmed    ,
                addedfrom)            
                values(
                '".@$cusdata['cus_name']."',
                '".@$cusdata['vat']."',
                '".@$cusdata['tel']."',
                '".(@$tblcountries[0]['country_id']?@$tblcountries[0]['country_id']:'243')."',
                '".@$cusdata['city']."',
                '".@$cusdata['zip']."',
                '".@$cusdata['state']."',
                '".@$cusdata['address']."',
                '".@$cusdata['website']."',
                '".date('Y-m-d H:i:s')."',
                '".(@$cusdata['active']?@$cusdata['active']:'1')."',
                '".(@$cusdata['billing_street']?@$cusdata['billing_street']:'')."',
                '".(@$cusdata['billing_city']?@$cusdata['billing_city']:'')."',
                '".(@$cusdata['billing_state']?@$cusdata['billing_state']:'')."',
                '".(@$cusdata['billing_zip']?@$cusdata['billing_zip']:'')."',
                '".(@$cusdata['billing_country']?@$cusdata['billing_country']:'')."',
                '".(@$cusdata['shipping_street']?@$cusdata['shipping_street']:'')."',
                '".(@$cusdata['shipping_city']?@$cusdata['shipping_city']:'')."',
                '".(@$cusdata['shipping_state']?@$cusdata['shipping_state']:'')."',
                '".(@$cusdata['shipping_zip']?@$cusdata['shipping_zip']:'')."',
                '".(@$cusdata['shipping_country']?@$cusdata['shipping_country']:'')."',
                '".(@$cusdata['longitude']?@$cusdata['longitude']:'')."',
                '".(@$cusdata['latitude']?@$cusdata['latitude']:'')."',
                '".(@$tblcountries[0]['short_name']?@$tblcountries[0]['short_name']:'vietnamese')."',
                '".(@$cusdata['default_currency']?@$cusdata['default_currency']:'1')."',
                '".(@$cusdata['show_primary_contact']?@$cusdata['show_primary_contact']:'')."',
                '".(@$cusdata['stripe_id']?@$cusdata['stripe_id']:'')."',
                '".(@$cusdata['registration_confirmed']?@$cusdata['registration_confirmed']:'1')."',
                '1'
            )");
        $customer_id=$db->insert_id();
        $db->query("insert into tblcustomer_groups(groupid,customer_id) values('".$groupid."','".$customer_id."')");
        $fullname=split_name($cusdata['cus_name']);
        $db->query("insert into tblcontacts(
                userid       ,
                is_primary    ,
                firstname  ,
                lastname    ,
                email,
                phonenumber          ,
                title     ,
                datecreated        ,
                password        ,
                email_verified_at)            
                values(
                '".@$customer_id."',
                '1',
                '".@$fullname[0]."',
                '".@$fullname[1]."',
                '".@$cusdata['email']."',
                '".@$cusdata['tel']."',
                '".trim(@$fullname[0].''.@$fullname[1])."',
                '".date('Y-m-d H:i:s')."',                
                '".@$cusdata['tel']."',
                '".date('Y-m-d H:i:s')."'
            )");
        $contact_id=$db->insert_id();
        $db->query("insert into tblcontact_permissions(permission_id,userid) values ('1','".$contact_id."')");
        $db->query("insert into tblcontact_permissions(permission_id,userid) values ('2','".$contact_id."')");
        $db->query("insert into tblcontact_permissions(permission_id,userid) values ('3','".$contact_id."')");
        $db->query("insert into tblcontact_permissions(permission_id,userid) values ('4','".$contact_id."')");
        $db->query("insert into tblcontact_permissions(permission_id,userid) values ('5','".$contact_id."')");
        $db->query("insert into tblcontact_permissions(permission_id,userid) values ('6','".$contact_id."')");





        return $customer_id;
		}
		return false;
}


function crm_add_contract($contract_code){
    global $sessions;
    global $db;
    $exp_contract=get_data('select * from contract where contract_code = "'.$contract_code.'"');
        if(is_array($exp_contract) && count($exp_contract)>0){
            $exp_contract=$exp_contract[0];
            $exp_id=$exp_contract['contract_id'];
        }
        else
        {
            return false;
        }

        $tblcontracts=get_data('select * from tblcontracts where exp_id = "'.$exp_id.'"');
        if(is_array($tblcontracts) && count($tblcontracts)>0){
            $tblcontracts=$tblcontracts[0];
            $contract_id=$tblcontracts['id'];
        }
        else{
            $content='            
            <div style="text-align:center;padding-bottom:20px;">
            <h1>'.$exp_contract['contract_name'].'</h1>
            <style>
#ff_table table,#ff_table th,#ff_table  td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
            </div>
            <table id=ff_table border=1 colspan=0 rowspan=0 style="border: 1px solid black;border-collapse: collapse;" >
            <tbody>
                <tr>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Sản phẩm</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Loại tiền</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Đã bao gồm VAT</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>VAT</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Kho gửi</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Kho nhận</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Hàng không</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Hàng không (HĐ)</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Đường biển</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Đường biển (HĐ)</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Đường bộ</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Đường bộ (HĐ)</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Phụ phí</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse;"><b>Phụ phí (HĐ)</b></td>
                </tr>
            ';
            $contract_details=get_data('select * from contract_details where contract_code = "'.$exp_contract['contract_code'].'"');
            if(is_array($contract_details) && count($contract_details)>0){
                foreach ($contract_details as $key => $value) {
                    $content.='<tr>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['stock_type_name'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['currency_name'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.(intval($value['include_vat'])==1?'Đã':'Không').'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.floatval(@$value['VAT']).'%</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['warehouse_name_dep'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['warehouse_name_des'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['air_freight_rates'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['air_freight_rates_contract'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['sea_freight_rates'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['sea_freight_rates_contract'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['road_freight_rates'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['road_freight_rates_contract'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['expense'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;">'.$value['expense_contract'].'</td>
                    </tr>';
                }
            }
            $content.='</tbody></table>';
            $customer=get_data("select * from customer where cus_name like '".$exp_contract['cus_name']."'");
            if(is_array($customer) && count($customer)>0){
                $tblclients=get_data('select * from tblclients where company like "'.$customer[0]['cus_name'].'"');
                if(is_array($tblclients) && count($tblclients)>0){
                    $clientid=$tblclients[0]['userid'];
                }
                else{
                    $clientid=crm_add_customer($customer[0]);
                }
            }
            $db->query("insert into tblcontracts(
                hash,
                content       ,
                description    ,
                subject  ,
                client     ,
                datestart,
                dateend          ,
                contract_type      ,
                addedfrom          ,
                dateadded        ,
                isexpirynotified        ,
                contract_value            ,
                trash     ,
                not_visible_to_client      ,
                exp_id)            
                values
                (
                '".md5($content.time())."'       ,
                '".$content."'       ,
                '".$exp_contract['contract_name']."'    ,
                '".$exp_contract['contract_name']."'  ,
                '".$clientid."'     ,
                '".$exp_contract['start_time']."',
                '".$exp_contract['finish_time']."',
                '0'      ,
                '1'          ,
                '".$exp_contract['start_time']."'        ,
                '0'        ,
                '0'            ,
                '0'     ,
                '0'      ,
                '".$exp_contract['contract_id']."'
                )
                ");
        $contract_id=$db->insert_id();
        return $contract_id;
        }
        return false;
}

function crm_update_ord_status($status='',$ord_code='',$ord_id=''){
    global $sessions;
    global $db;
    if(intval($ord_id)>0){
        $ord_id=intval($ord_id);
        $ord=get_data("select * from ord_tariff where ord_trf_id = '".$ord_id."'");
        if(is_array($ord) && count($ord)>0){
            $ord_code = $ord[0]['ord_trf_code'];
        }
        else
        {
            return false;
        }
    }
    $tblprojects=get_data("select * from tblprojects where name like '%[".$ord_code."]%'");
    $pj_id=$tblprojects[0]['id'];
    switch($status){
        case "NK":
            $dept_id=crm_add_dept('Warehouse');
            $taskdata=array();
            $taskdata['name']="Chuyển kho nội bộ [".$ord_code."]";
            $taskdata['description']="Chuyển kho nội bộ [".$ord_code."]";
            crm_success_pj_task($pj_id);
            $task_id=crm_add_pj_task($pj_id,$dept_id,$taskdata);
        break;
        case "CK":
            $dept_id=crm_add_dept('Warehouse');
            $taskdata=array();
            $taskdata['name']="Nhập kho nhận [".$ord_code."]";
            $taskdata['description']="Nhập kho nhận [".$ord_code."]";
            crm_success_pj_task($pj_id);
            $task_id=crm_add_pj_task($pj_id,$dept_id,$taskdata);
        break;
        case "NKN":
            $dept_id=crm_add_dept('Delivery');
            $taskdata=array();
            $taskdata['name']="Giao hàng [".$ord_code."]";
            $taskdata['description']="Giao hàng [".$ord_code."]";
            crm_success_pj_task($pj_id);
            $task_id=crm_add_pj_task($pj_id,$dept_id,$taskdata);
        break;
        case "GH":
            $dept_id=crm_add_dept('Delivery');
            $taskdata=array();
            $taskdata['name']="Xác nhận hoàn tất [".$ord_code."]";
            $taskdata['description']="Xác nhận hoàn tất [".$ord_code."]";
            crm_success_pj_task($pj_id);
            $task_id=crm_add_pj_task($pj_id,$dept_id,$taskdata);
        break;
        case "HT":
            
            crm_success_pj_task($pj_id);
        break;
    }
    return $dept_id;    
}




function crm_add_dept($dept_name){
	global $sessions;
global $db;
$departments = get_data("select * from tbldepartments where name='" . $dept_name . "'");
    if (count($departments) <= 0) {
                        $db->query("insert into tbldepartments(name) values ('" . $dept_name . "')");
                        $dept_id=$db->insert_id();
                    }
                    else{
                        $dept_id=$departments[0]['departmentid'];
    }
      return $dept_id;    
}



function crm_success_pj_task($project_id,$task_id=0){
global $db;
    if($task_id==0){
        $db->query("update tbltasks set status=5, datefinished='".date('Y-m-d H:i:s')."' where rel_type='project' and rel_id=".$project_id);
    }
    else{

    }
    return false;
}
function crm_add_pj_task($project_id,$departmentid,$cusdata){
global $db;
$departments = get_data("select * from tbldepartments where departmentid='" . $departmentid . "'");
$project = get_data("select * from tblprojects where id='" . $project_id . "'");
if (count($project) <= 0) {
    return false;
}
//print_r($cusdata);die();
    if (count($departments) > 0) {
            $db->query("insert into tbltasks(
                name       ,
                description    ,
                priority  ,
                dateadded    ,
                startdate,
                duedate          ,
                datefinished     ,
                addedfrom          ,
                is_added_from_contact        ,
                status        ,
                recurring_type            ,
                repeat_every     ,
                recurring      ,
                is_recurring_from    ,
                cycles    ,
                total_cycles    ,
                custom_recurring    ,
                last_recurring_date    ,
                rel_id     ,
                rel_type     ,
                is_public    ,
                billable    ,
                billed    ,
                invoice_id    ,
                hourly_rate    ,
                milestone     ,
                kanban_order     ,
                milestone_order    ,
                visible_to_client    ,
                deadline_notified    ,
                departmentid)            
                values(
                '".(@$cusdata['name']?@$cusdata['name']:'')."',
                '".(@$cusdata['description']?@$cusdata['description']:'')."',
                '".(@$cusdata['priority']?@$cusdata['priority']:'2')."',
                '".(@$cusdata['dateadded']?@$cusdata['dateadded']:'')."',
                '".(@$cusdata['startdate']?@$cusdata['startdate']:date('Y-m-d H:i:s'))."',
                ".(@$cusdata['duedate']?"'".@$cusdata['duedate']."'":'NULL').",
                ".(@$cusdata['datefinished']?"'".@$cusdata['datefinished']."'":'NULL').",
                '".(@$cusdata['addedfrom']?@$cusdata['addedfrom']:'1')."',
                '".(@$cusdata['is_added_from_contact']?@$cusdata['is_added_from_contact']:'0')."',
                '".(@$cusdata['status']?@$cusdata['status']:'4')."',
                ".(@$cusdata['recurring_type']?@$cusdata['recurring_type']:'NULL').",
                '".(@$cusdata['repeat_every']?@$cusdata['repeat_every']:'0')."',
                '".(@$cusdata['recurring']?@$cusdata['recurring']:'0')."',
                ".(@$cusdata['is_recurring_from']?@$cusdata['is_recurring_from']:'NULL').",
                '".(@$cusdata['cycles']?@$cusdata['cycles']:'0')."',
                '".(@$cusdata['total_cycles']?@$cusdata['total_cycles']:'0')."',
                '".(@$cusdata['custom_recurring']?@$cusdata['custom_recurring']:'0')."',
                ".(@$cusdata['last_recurring_date']?@$cusdata['last_recurring_date']:'NULL').",
                '".(@$cusdata['rel_id']?@$cusdata['rel_id']:$project_id)."',
                '".(@$cusdata['rel_type']?@$cusdata['rel_type']:'project')."',
                '".(@$cusdata['is_public']?@$cusdata['is_public']:'1')."',
                '".(@$cusdata['billable']?@$cusdata['billable']:'1')."',
                '".(@$cusdata['billed']?@$cusdata['billed']:'0')."',
                '".(@$cusdata['invoice_id']?@$cusdata['invoice_id']:'0')."',
                '".(@$cusdata['hourly_rate']?@$cusdata['hourly_rate']:'0')."',
                '".(@$cusdata['milestone']?@$cusdata['milestone']:'0')."',
                '".(@$cusdata['kanban_order']?@$cusdata['kanban_order']:'0')."',
                '".(@$cusdata['milestone_order']?@$cusdata['milestone_order']:'0')."',
                '".(@$cusdata['visible_to_client']?@$cusdata['visible_to_client']:'1')."',
                '".(@$cusdata['deadline_notified']?@$cusdata['deadline_notified']:'0')."',
                '".intval(@$departmentid)."'
            )");
        $task_id=$db->insert_id();
        crm_add_task_notifi($task_id,intval(@$departmentid),'not_task_assigned_to_you',array($cusdata['name']));
        return $task_id;
                    }
                    else{
                       return false;
    }
      return $dept_id;    
}
function crm_add_checklist($task_id,$name){
global $db;
$tbltasks = get_data("select * from tbltasks where id='" . $task_id . "'");

if (count($tbltasks) <= 0) {
    return false;
}
//print_r($cusdata);die();
    if (count($tbltasks) > 0) {
            $db->query("insert into tbltask_checklist_items(
                taskid        ,
                description    ,
                finished  ,
                dateadded )            
                values(
                '".(@$task_id?@$task_id:'')."',                
                '".(@$name?@$name:'')."',                
                '0',      
                '".date('Y-m-d H:i:s')."'
            )");
        $task_id=$db->insert_id();
        return $task_id;
                    }
                    else{
                       return false;
    }
     return false;  
}
function crm_add_task_notifi($task_id,$departmentid,$description,$notidata=array()){
global $db;
$tbltasks = get_data("select * from tbltasks where id='" . $task_id . "'");
if (count($tbltasks) <= 0) {
    return false;
}
$departments = get_data("select * from tbldepartments where departmentid='" . $departmentid . "'");
if (count($departments) <= 0) {
    return false;
}
$link="#taskid=".$task_id;
$additional_data=serialize($notidata);
$db->query("insert into tblnotifications(
                date        ,
                description    ,
                fromuserid  ,
                fromclientid  ,
                from_fullname  ,
                touserid  ,
                fromcompany  ,
                link  ,
                additional_data  ,
                departmentid )            
                values(
                '".date('Y-m-d H:i:s')."',
                '".(@$description?@$description:'not_task_assigned_to_you')."',                
                '1',                
                '0',      
                'CEH SOFT',      
                '0',      
                '0',      
                '".$link."',      
                '".$additional_data."',      
                '".intval($departmentid)."'
            )");
        $noti_id=$db->insert_id();
        return $noti_id;
                     
}

function crm_add_pj_notifi($project_id,$departmentid,$description='not_staff_added_as_project_member',$notidata=array()){
global $db;
$project = get_data("select * from tblprojects where id='" . $project_id . "'");
if (count($project) <= 0) {
    return false;
}
$departments = get_data("select * from tbldepartments where departmentid='" . $departmentid . "'");
if (count($departments) <= 0) {
    return false;
}
$link="projects/view/".$project_id;
$additional_data=serialize($notidata);
$db->query("insert into tblnotifications(
                date        ,
                description    ,
                fromuserid  ,
                fromclientid  ,
                from_fullname  ,
                touserid  ,
                fromcompany  ,
                link  ,
                additional_data  ,
                departmentid )            
                values(
                '".date('Y-m-d H:i:s')."',
                '".(@$description?@$description:'not_staff_added_as_project_member')."',                
                '1',                
                '0',      
                'CEH SOFT',      
                '0',      
                '0',      
                '".$link."',      
                '".$additional_data."',      
                '".intval($departmentid)."'
            )");
        $noti_id=$db->insert_id();
        return $noti_id;
                     
}

function crm_add_user($user_id){
	global $sessions;
global $db;
	$staff_id=0;
	$user_id=intval(@$user_id);
	$users=get_data('select * from users where user_id='.$user_id);
	$dept = get_data("select * from dept where dept_id='" . $users[0]["dept_id"] . "'");
    $dept_id=crm_add_dept($dept[0]["dept_name"]);
	if(is_array($users) && count($users)>0){
                    $staff = get_data("select * from tblstaff where email='" . $users[0]["email"] . "'");
                    if (count($staff) <= 0) {
                        $fullname=split_name($users[0]['full_name']);
                        $db->query("insert into tblstaff(
                            firstname, 
                            lastname, 
                            facebook, 
                            linkedin, 
                            phonenumber, 
                            skype, 
                            email, 
                            password, 
                            datecreated, 
                            profile_image, 
                            active, 
                            default_language, 
                            direction, 
                            media_path_slug, 
                            is_not_staff, 
                            hourly_rate) 
                    values('" . $fullname[0] . "', 
                    '" . $fullname[1] . "', 
                    'facebook', 
                    'linkedin', 
                    'phonenumber',
                    'skype',
                    '" . $users[0]['email'] . "',
                    '" . ($users[0]['password']) . "',
                    '".date('Y-m-d H:i:s')."',
                    '',
                    1,
                    'vietnamese',
                    '',
                    '" . convert_tourl($users[0]['full_name'])."-".time().'-'.uniqid() . "',
                    0,
                    0)");
                        $staff_id=$db->insert_id();
                        $db->query("insert into tblstaff_departments(staffid,departmentid) values ('" . $staff_id . "','" . $dept_id . "')");
                    }
	}

	return $staff_id;
}


function crm_add_inv($ord_code){
    global $sessions;
    global $db;
    $ord_tariff=get_data('select * from ord_tariff where ord_trf_code = "'.$ord_code.'"');
        if(is_array($ord_tariff) && count($ord_tariff)>0){
            $ord_tariff=$ord_tariff[0];
        }
        else
        {
            return false;
        }

        $tblprojects=get_data("select * from tblprojects where name like '%[".$ord_code."]%'");
        if(is_array($tblprojects) && count($tblprojects)>0){
            $tblprojects=$tblprojects[0];
            $project_id=$tblprojects['id'];
       
       $total=$tblprojects['project_cost'];
       $subtotal=$total;
       $total_tax=0;
            
$ord_tariff_details=get_data('select * from ord_tariff_details where ord_trf_code = "'.$ord_tariff['ord_trf_code'].'"');
if(is_array($ord_tariff_details) && count($ord_tariff_details)>0){
                foreach ($ord_tariff_details as $key => $value) {
                    $value['vat_rates']=floatval(@($value['vat_rates']*100/$value['rates']));
                    if(intval(@$value['include_vat'])==0){
                        $total_tax+=($value['vat_rates']/100)*$value['total_money'];
                    }
                    else
                    {
                        $total_tax+=$value['total_money']/($value['vat_rates']+100)*$value['vat_rates'];
                    }
                    
                }
}
    $subtotal=$total-$total_tax;
            $clientid=$tblprojects['clientid'];
            $db->query("insert into tblinvoices(
                hash      ,
                clientid ,
                number       ,
                prefix    ,
                number_format  ,
                datecreated     ,
                date,
                duedate          ,
                currency       ,
                subtotal          ,
                total_tax        ,
                total        ,
                adjustment            ,
                addedfrom     ,                
                status      ,
                allowed_payment_modes      ,
                project_id 
                )            
                values
                (
                '".md5($project_id.time())."'       ,
                '".$clientid."'       ,
                '".($project_id)."'       ,
                'PAYM-'       ,
                '1'    ,
                '".$tblprojects['start_date']."'  ,
                '".$tblprojects['start_date']."'     ,
                '".$tblprojects['start_date']."',
                '1',
                '".$subtotal."'      ,
                '".$total_tax."'          ,
                '".$total."'        ,
                '0'        ,
                '1'            ,
                '2'     ,
                '".'a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:6:"paypal";}'."'      ,
                '".$project_id."'
                )
                ");
        $invoice_id=$db->insert_id();
        $db->query("insert into tblinvoicepaymentrecords(
                invoiceid      ,
                amount ,
                paymentmode       ,
                date  ,
                daterecorded     ,
                note    ,
                transactionid
                )            
                values
                (
                '".$invoice_id."'       ,
                '".$total."'       ,
                '1'       ,
                '".$tblprojects['start_date']."'  ,
                '".$tblprojects['start_date']."'     ,
                '',
                '".$ord_tariff['ord_trf_code']."'
                )
                ");
            if(is_array($ord_tariff_details) && count($ord_tariff_details)>0){
                foreach ($ord_tariff_details as $key => $value) {
                    $value['vat_rates']=floatval(@($value['vat_rates']*100/$value['rates']));
                    $db->query("insert into tblitemable(
                    rel_id ,
                    rel_type        ,
                    description    ,
                    long_description  ,
                    qty     ,
                    rate ,
                    unit          ,
                    item_order
                    )            
                    values
                    (
                    '".$invoice_id."'       ,
                    'invoice'    ,
                    '".$value['stock_type_name']."',
                    '".$value['numeric']." ".$value['unit_name']." Giá ".$value['total_money']." ',
                    '".$value['numeric']."',
                    '".$value['total_money']."'      ,
                    ''      ,
                    '1'
                    )
                    ");
                    $itemid=$db->insert_id();
                    $db->query("insert into tblitem_tax(
                    itemid  ,
                    rel_id        ,
                    rel_type    ,
                    taxrate  ,
                    taxname
                    )            
                    values
                    (
                    '".$itemid."'       ,
                    '".$invoice_id."'       ,
                    'invoice'    ,
                    '".floatval(@$value['vat_rates'])."',
                    'GTGT'
                    )
                    ");
                }
            }
        return $invoice_id;
        }
        return false;
}
