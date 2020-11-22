<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Staff_group extends AdminController
{
    /* List all staff_group members */
    public function index()
    {
        if (!has_permission('staff_group', '', 'view')) {
            access_denied('staff_group');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('staff_group');
        }
        $data['staff_members'] = $this->staff_group_model->get('', ['active' => 1]);
        $data['title']         = _l('staff_members');
        $this->load->view('admin/staff_group/manage', $data);
    }
    public function ajax()
    {
        if (!has_permission('staff_group', '', 'view')) {
            access_denied('staff_group');
        }
        $pt=$this->input->post();
        $rt=$this->db->where('staff_groupid',intval(@$pt['id']))->get(db_prefix().'staff_group')->row_array();
        echo json_encode($rt,true);die();
    }
    public function staff_group_manager($id = '')
    {
        
        if (!has_permission('staff_group', '', 'view')) {
            access_denied('staff_group');
        }
        if ($this->input->post()) {
            $id=$this->input->post('id');
            if ($id == '') {
                if (!has_permission('staff_group', '', 'create')) {
                    access_denied('staff_group');
                }

                $id = $this->staff_group_model->add($this->input->post());
                //print_r($id);die("??");
                if ($id) {

                    set_alert('success', _l('added_successfully', _l('staff_group')));
                    redirect(admin_url('staff_group/staff_group_manager/' . $id));
                }
            } else {
                if (!has_permission('staff_group', '', 'edit')) {
                    access_denied('staff_group');
                }
                $success = $this->staff_group_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('staff_group')));
                    die('{"success":"success"}');
                }
                die("{}");
                //redirect(admin_url('staff_group/staff_group_manager/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('staff_group_lowercase'));
        } else {
            $data['staff_group']       = $staff_group;
            $title              = _l('edit', _l('staff_group_lowercase')) . ' ' . $staff_group->name;
        }
        $data['title'] = $title;
        $this->load->view('admin/staff_group/staff_group', $data);
    }

    /* Delete staff_group from database */
    public function delete($id)
    {
        if (!has_permission('staff_group', '', 'delete')) {
            access_denied('staff_group');
        }
        if (!$id) {
            redirect(admin_url('staff_group'));
        }
        $response = $this->staff_group_model->delete($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('staff_group_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('staff_group')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('staff_group_lowercase')));
        }
        redirect(admin_url('staff_group'));
    }

    
}
