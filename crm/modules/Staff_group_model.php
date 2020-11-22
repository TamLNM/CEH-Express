<?php
defined('BASEPATH') OR exit('');
class Staff_group_model extends CI_Model {
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item('YARD_ID');
    }
    
    public function load_data(){
      $this->ceh->select('tbl_staff_group.*');
      $data = $this->ceh->get('tbl_staff_group')->result_array();
      return $data;
  }

    public function ajax_save($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $loxz = array();//add
        $TESTKEY='staff_group_id';
        $KEYMAP=$this->config->item('KEYMAP');

        foreach ($datas as $key => $item) {
            if(isset($item['staff_group_name'])){
                $item['staff_group_name'] = UNICODE.$item['staff_group_name'];
            };

            $item['updated_by'] = $this->session->userdata("UserID");
            $item['updated_at'] = date('Y-m-d H:i:s');         
        
            $id=$item[$TESTKEY];
            if(isset($item[$TESTKEY])){
                unset($item[$TESTKEY]);
            };
 
            $checkHD = $this->ceh->where("staff_group_name",$item['staff_group_name'])->limit(1)->get('tbl_staff_group')->row_array();
            if ($this->input->post('action') == "edit"){
                $checkItem = $this->ceh->where($TESTKEY, $id)
                                    ->limit(1)
                                    ->get('tbl_staff_group')
                                    ->row_array();

                if (is_array($checkItem) && count($checkItem) > 0){
                    if (is_array($checkHD) && count($checkHD) > 0){
                        if($checkHD[$TESTKEY] != $checkItem[$TESTKEY]){
                            $loxz[]=('{"deny":"Tên ['.$item['staff_group_name'].'] đã tồn tại !"}');
                            goto over_loop;
                        }
                    }
                    $this->ceh->where($TESTKEY, $checkItem[$TESTKEY])->update('tbl_staff_group', $item);
                    $loxz[]=('{"success":"Đối tượng ['.$checkItem[$TESTKEY].'] đã được thay đổi !","type":"edit","data":'.json_encode($item).'}');//add
                    $this->funcs->save_log($this->ceh,$this->session->userdata("UserID"),'tbl_staff_group','update','Sửa Hướng',$checkItem,$item);
                }
            }
            else {
                if (is_array($checkHD) && count($checkHD) > 0){
                    $loxz[]=('{"deny":"Mã ['.$item['staff_group_name'].'] đã tồn tại !"}');
                    goto over_loop;
                }

                $item['created_by'] = $this->session->userdata("UserID");
                $item['created_at'] = date('Y-m-d H:i:s');
                $this->ceh->insert('tbl_staff_group', $item);
                $this->funcs->save_log($this->ceh,$this->session->userdata("UserID"),'tbl_staff_group','add','Thêm Hướng',null,$item);
                $new=$this->ceh->query("SELECT * FROM tbl_staff_group WHERE $TESTKEY = (SELECT MAX($TESTKEY) FROM tbl_staff_group)")->row_array();
                $loxz[]=('{"success":"Thêm thành công đối tượng ['.@$new['staff_group_name'].']","type":"add","data":'.@json_encode(@$new).'}');//add
            };
            over_loop:
        };
        
        $this->ceh->trans_complete();
        
        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
                if(count($loxz))
                    echo ("[".join(",",$loxz)."]");die();
                    return TRUE;
        }
    }

    public function ajax_delete($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        $TESTKEY='staff_group_id';
        $KEYMAP=$this->config->item('KEYMAP');
        
        foreach ($datas as $item) {
            $old = $this->ceh->where($TESTKEY, $item)->get('tbl_staff_group')->row_array();
            if(is_array($old) && count($old)>0 ){
                if(is_array(@$KEYMAP[$TESTKEY]))
                    foreach ($KEYMAP[$TESTKEY] as $KINDEX => $KTABLE) {
                        $KROW=$this->ceh->select($TESTKEY)->where($TESTKEY, $old[$TESTKEY])->limit(1)->get($KTABLE)->row_array();                
                        if(is_array($KROW) && count($KROW)>0){
                            die('{"deny":"Đối tượng ['.$old['staff_group_name'].'] đã được sử dụng, không thể xóa !"}');
                        }
                    }
                $this->ceh->where($TESTKEY, $item)->delete('tbl_staff_group');
                array_push($result['success'], 'Xóa thành công ['.$old['staff_group_name'].'] : '.$item);
                $this->funcs->save_log($this->ceh,$this->session->userdata("UserID"),'tbl_staff_group','delete','Xóa Hướng',$old,null);
            }
            else{
                die('{"deny":"Mã số '.$item.' không tồn tại !"}');
            }
       
        };
        $this->ceh->trans_complete();
        
        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        };
    }
}