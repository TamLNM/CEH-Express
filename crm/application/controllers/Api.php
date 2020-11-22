<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('departments_model');
        $this->load->model('projects_model');
        $this->load->model('currencies_model');
        $this->load->model('authentication_model');
        $this->load->helper('date');
    }
    public function index()
    {
        die("123");
    }
    public function create_task(){
        //Array ( [is_public] => on [billable] => on [name] => TEST [hourly_rate] => 100000 [milestone] => [startdate] => 2020-05-22 [duedate] => [priority] => 3 [repeat_every] => 1 [repeat_every_custom] => 1 [repeat_type_custom] => day [rel_type] => invoice [rel_id] => [tags] => haha,hehe [description] => mô tả )
        $post=$this->input->post();
        $post['is_public']='on';//on công khai hay không
        $post['billable']='on';//on có hóa đơn không
        $post['name']='TEST2';//tên task
        $post['hourly_rate']=100000;//tỷ lệ mỗi giờ
        $post['milestone']='';// mốc
        $post['startdate']='2020-05-22';// ngày bắt đầu công việc y-m-d
        $post['duedate']='';//Ngày hạn mức công việc y-m-d
        $post['priority']=3;//mức ưu tiên 1 thấp, 2 bình thường 3 cao 4 gấp
        $post['repeat_every']=0;//lặp lại mỗi giây mặc định 0
        $post['repeat_every_custom']=1;//lặp lại mỗi giây mặc định 0
        $post['repeat_type_custom']='day';//day,week,month,year
        $post['rel_type']='project';//loại công việc được phát sinh từ dự án hoặc đề nghị invoice, project, proposal
        $post['rel_id']=3;//1 id dự theo rel_type
        $post['tags']='kkk,kekeke';//tag
        $post['description']='mô tả';//ghi chú
        $ins=array();
        $ins['is_public']=@$post['is_public'];//on công khai hay không
        $ins['billable']=@$post['billable'];//on có hóa đơn không
        $ins['name']=@$post['name'];//tên task
        $ins['hourly_rate']=@$post['hourly_rate'];//tỷ lệ mỗi giờ
        $ins['milestone']=@$post['milestone'];// mốc
        $ins['startdate']=@$post['startdate'];// ngày bắt đầu công việc y-m-d
        $ins['duedate']=@$post['duedate'];//Ngày hạn mức công việc y-m-d
        $ins['priority']=@$post['priority'];//mức ưu tiên 1 thấp, 2 bình thường 3 cao 4 gấp
        $ins['repeat_every']=@$post['repeat_every'];//lặp lại mỗi giây mặc định 0
        $ins['repeat_every_custom']=@$post['repeat_every_custom'];//lặp lại mỗi giây mặc định 0
        $ins['repeat_type_custom']=@$post['repeat_type_custom'];//day,week,month,year
        $ins['rel_type']=@$post['rel_type'];//loại công việc được phát sinh từ dự án hoặc đề nghị project, proposal
        $ins['rel_id']=@$post['rel_id'];//1 id dự theo rel_type
        $ins['description']=@$post['description'];//ghi chú
                $id      = $this->tasks_model->add($ins);
                $_id     = false;
                $success = false;
                $message = '';
                if ($id) {
                    $success       = true;
                    $_id           = $id;
                    $message       = _l('added_successfully', _l('task'));
                    $uploadedFiles = handle_task_attachments_array($id);
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'task', [$file]);
                        }
                    }
                }
                echo json_encode([
                    'success' => $success,
                    'id'      => $_id,
                    'message' => $message,
                ]);
                return $success;
                die();



        // $ins['dateadded']=@$post['dateadded'];// ngày thêm Y-m-d h:i:s
        // $ins['datefinished']=@$post['datefinished'];// ngày kết thúc công việc y-m-d h:i:s
        // $ins['addedfrom']=@$post['addedfrom'];// người thêm mặc định 1 (admin)
        // $ins['is_added_from_contact']=@$post['is_added_from_contact'];// mặc định 0
        // $ins['status']=@$post['status'];//tình trạng 5,4
        // $ins['recurring_type']=@$post['recurring_type'];//Loại định kỳ, mặc định null
        // $ins['recurring']=@$post['recurring'];//0
        // $ins['is_recurring_from']=@$post['is_recurring_from'];//null
        // $ins['cycles']=@$post['cycles'];//chu kỳ//0
        // $ins['total_cycles']=@$post['total_cycles'];//tổng chu kỳ //0
        // $ins['custom_recurring']=@$post['custom_recurring'];//chu kỳ tùy chỉnh
        // $ins['last_recurring_date']=@$post['last_recurring_date'];
        // $ins['billed']=@$post['billed'];// hóa đơn đã xuất
        // $ins['invoice_id']=@$post['invoice_id'];// id hóa đơn
        // $ins['kanban_order']=@$post['kanban_order'];
        // $ins['milestone_order']=@$post['milestone_order'];//mốc đặt hàng
        // $ins['visible_to_client']=@$post['visible_to_client'];// hiện với khách
        // $ins['deadline_notified']=@$post['deadline_notified'];//cảnh báo deadline
    }


    public function create_checklist_item(){
        $ins=array();
        $ins['taskid']=@$post['taskid'];//
        $ins['description']=@$post['description'];//

        $ins['taskid']=3;//
        $ins['description']='TEST DE '.time();//

        $id      = $this->tasks_model->add_checklist_item($ins);
        $_id     = false;
                $success = false;
                $message = '';
                if ($id) {
                    $success       = true;
                    $_id           = $id;
                    $message       = _l('added_successfully', _l('checklist'));
                    $uploadedFiles = handle_task_attachments_array($id);
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'checklist', [$file]);
                        }
                    }
                }
                echo json_encode([
                    'success' => $success,
                    'id'      => $_id,
                    'message' => $message,
                ]);
                return $success;
                die();
    }

    public function create_project(){
        //Array ( [name] => Du an 333 [clientid] => 1 [progress_from_tasks] => on [progress] => 28 [billing_type] => 2 [status] => 2 [project_cost] => [project_rate_per_hour] => 1000000 [estimated_hours] => 100 [project_members] => Array ( [0] => 3 [1] => 2 [2] => 1 ) [start_date] => 2020-05-22 [deadline] => 2020-05-31 [tags] => dự án xxx [description] => ghi chu [send_created_email] => on [settings] => Array ( [available_features] => Array ( [0] => project_overview [1] => project_tasks [2] => project_timesheets [3] => project_milestones [4] => project_files [5] => project_discussions [6] => project_gantt [7] => project_tickets [8] => project_invoices [9] => project_estimates [10] => project_expenses [11] => project_credit_notes [12] => project_subscriptions [13] => project_notes [14] => project_activity ) [view_tasks] => on [create_tasks] => on [edit_tasks] => on [comment_on_tasks] => on [view_task_comments] => on [view_task_attachments] => on [view_task_checklist_items] => on [upload_on_tasks] => on [view_task_total_logged_time] => on [view_finance_overview] => on [upload_files] => on [open_discussions] => on [view_milestones] => on [view_gantt] => on [view_timesheets] => on [view_activity_log] => on [view_team_members] => on ) )
        $post=$this->input->post();
        $ins=array();
        $ins['name']=@$post['name'];//
        $ins['clientid']=@$post['clientid'];//
        $ins['progress_from_tasks']=@$post['progress_from_tasks'];//
        $ins['progress']=@$post['progress'];//
        $ins['billing_type']=@$post['billing_type'];//
        $ins['status']=@$post['status'];//
        $ins['project_cost']=@$post['project_cost'];//
        $ins['project_rate_per_hour']=@$post['project_rate_per_hour'];//
        $ins['estimated_hours']=@$post['estimated_hours'];//
        $ins['project_members']=@$post['project_members'];//
        $ins['start_date']=@$post['start_date'];//
        $ins['deadline']=@$post['deadline'];//
        $ins['tags']=@$post['tags'];//
        $ins['description']=@$post['description'];//
        $ins['send_created_email']=@$post['send_created_email'];//
        $ins['settings']=array();//
        $ins['settings']['available_features']=array();//
        $ins['settings']['available_features'][]='project_overview';
        $ins['settings']['available_features'][]='project_tasks';
        $ins['settings']['available_features'][]='project_timesheets';
        $ins['settings']['available_features'][]='project_milestones';
        $ins['settings']['available_features'][]='project_files';
        $ins['settings']['available_features'][]='project_discussions';
        $ins['settings']['available_features'][]='project_gantt';
        $ins['settings']['available_features'][]='project_tickets';
        $ins['settings']['available_features'][]='project_invoices';
        $ins['settings']['available_features'][]='project_activity';
        $ins['settings']['view_tasks']=@$post['view_tasks'];//
        $ins['settings']['create_tasks']=@$post['create_tasks'];//
        $ins['settings']['edit_tasks']=@$post['edit_tasks'];//
        $ins['settings']['comment_on_tasks']=@$post['comment_on_tasks'];//
        $ins['settings']['view_task_comments']=@$post['view_task_comments'];//
        $ins['settings']['view_task_attachments']=@$post['view_task_attachments'];//
        $ins['settings']['view_task_checklist_items']=@$post['view_task_checklist_items'];//
        $ins['settings']['upload_on_tasks']=@$post['upload_on_tasks'];//
        $ins['settings']['view_task_total_logged_time']=@$post['view_task_total_logged_time'];//
        $ins['settings']['view_finance_overview']=@$post['view_finance_overview'];//
        $ins['settings']['upload_files']=@$post['upload_files'];//
        $ins['settings']['open_discussions']=@$post['open_discussions'];//
        $ins['settings']['view_milestones']=@$post['view_milestones'];//
        $ins['settings']['view_gantt']=@$post['view_gantt'];//
        $ins['settings']['view_timesheets']=@$post['view_timesheets'];//
        $ins['settings']['view_activity_log']=@$post['view_activity_log'];//
        $ins['settings']['view_team_members']=@$post['view_team_members'];//







//Array ( [name] => Du an 333 [clientid] => 1 [progress_from_tasks] => on [progress] => 28 [billing_type] => 2 [status] => 2 [project_cost] => [project_rate_per_hour] => 1000000 [estimated_hours] => 100 [project_members] => Array ( [0] => 3 [1] => 2 [2] => 1 ) [start_date] => 2020-05-22 [deadline] => 2020-05-31 [tags] => dự án xxx [description] => ghi chu [send_created_email] => on [settings] => Array ( [available_features] => Array ( [0] => project_overview [1] => project_tasks [2] => project_timesheets [3] => project_milestones [4] => project_files [5] => project_discussions [6] => project_gantt [7] => project_tickets [8] => project_invoices [9] => project_estimates [10] => project_expenses [11] => project_credit_notes [12] => project_subscriptions [13] => project_notes [14] => project_activity ) [view_tasks] => on [create_tasks] => on [edit_tasks] => on [comment_on_tasks] => on [view_task_comments] => on [view_task_attachments] => on [view_task_checklist_items] => on [upload_on_tasks] => on [view_task_total_logged_time] => on [view_finance_overview] => on [upload_files] => on [open_discussions] => on [view_milestones] => on [view_gantt] => on [view_timesheets] => on [view_activity_log] => on [view_team_members] => on ) )
        $ins['name']='Namex';//
        $ins['clientid']=1;//
        $ins['progress_from_tasks']='on';//
        $ins['progress']='28';//
        $ins['billing_type']='2';//
        $ins['status']='2';//
        $ins['project_cost']='';//
        $ins['project_rate_per_hour']='1000000';//
        $ins['estimated_hours']='100';//
        $ins['project_members']=array(3,2,1);//
        $ins['start_date']='2020-05-22';//
        $ins['deadline']='2020-05-29';//
        $ins['tags']='a,b,c';//
        $ins['description']='gc';//
        $ins['send_created_email']='on';//
        $ins['settings']=array();//
        $ins['settings']['available_features']=array();//
        $ins['settings']['available_features'][]='project_overview';
        $ins['settings']['available_features'][]='project_tasks';
        $ins['settings']['available_features'][]='project_timesheets';
        $ins['settings']['available_features'][]='project_milestones';
        $ins['settings']['available_features'][]='project_files';
        $ins['settings']['available_features'][]='project_discussions';
        $ins['settings']['available_features'][]='project_gantt';
        $ins['settings']['available_features'][]='project_tickets';
        $ins['settings']['available_features'][]='project_invoices';
        $ins['settings']['available_features'][]='project_activity';
        $ins['settings']['view_tasks']='on';//
        $ins['settings']['create_tasks']='on';//
        $ins['settings']['edit_tasks']='on';//
        $ins['settings']['comment_on_tasks']='on';//
        $ins['settings']['view_task_comments']='on';//
        $ins['settings']['view_task_attachments']='on';//
        $ins['settings']['view_task_checklist_items']='on';//
        $ins['settings']['upload_on_tasks']='on';//
        $ins['settings']['view_task_total_logged_time']='on';//
        $ins['settings']['view_finance_overview']='on';//
        $ins['settings']['upload_files']='on';//
        $ins['settings']['open_discussions']='on';//
        $ins['settings']['view_milestones']='on';//
        $ins['settings']['view_gantt']='on';//
        $ins['settings']['view_timesheets']='on';//
        $ins['settings']['view_activity_log']='on';//
        $ins['settings']['view_team_members']='on';//

        unset($ins['view_tasks']);
        unset($ins['create_tasks']);
        unset($ins['edit_tasks']);
        unset($ins['comment_on_tasks']);
        unset($ins['view_task_comments']);
        unset($ins['view_task_attachments']);
        unset($ins['view_task_checklist_items']);
        unset($ins['upload_on_tasks']);
        unset($ins['view_task_total_logged_time']);
        unset($ins['view_finance_overview']);
        unset($ins['upload_files']);
        unset($ins['open_discussions']);
        unset($ins['view_milestones']);
        unset($ins['view_gantt']);
        unset($ins['view_timesheets']);
        unset($ins['view_activity_log']);
        unset($ins['view_team_members']);





        $success = $this->projects_model->add($ins);
        print_r($ins);print_r($success);die();
        return $success;
    }

    public function project_change_status(){
        //[project_id] => 1 [status_id] => 2 [mark_all_tasks_as_completed] => 0 [cancel_recurring_tasks] => false [notify_project_members_status_change] => 0 
        $post=$this->input->post();
        $ins=array();
        $ins['status_id']=@$post['status_id'];//
        $ins['mark_all_tasks_as_completed']=@$post['mark_all_tasks_as_completed'];//
        $ins['cancel_recurring_tasks']=@$post['cancel_recurring_tasks'];//
        $ins['notify_project_members_status_change']=@$post['notify_project_members_status_change'];//
        $ins['send_project_marked_as_finished_email_to_contacts']=@$post['send_project_marked_as_finished_email_to_contacts'];//
        //$this->project_model->mark_as($ins);
        $message = _l('project_marked_as_failed', $status['name']);
        $success = $this->projects_model->mark_as($ins);

        if ($success) {
            $message = _l('project_marked_as_success', $status['name']);
        }
        echo json_encode([
                    'success' => $success,
                    'message' => $message
                ]);
        return $success;
        
    }


    public function add_departments(){
        //Array ( [name] => DOAN VAN HIEU [hidefromclient] => on [email] => support@cehsoft.com [imap_username] => imap [host] => hót [password] => pá [encryption] => [delete_after_import] => on )
        $ins=array();
        $ins['name']=@$post['name'];//
        $ins['hidefromclient']=@$post['hidefromclient'];//
        $ins['email']=@$post['email'];//
        $ins['imap_username']=@$post['imap_username'];//
        $ins['host']=@$post['host'];//
        $ins['password']=@$post['password'];//
        $ins['encryption']=@$post['encryption'];//
        $ins['delete_after_import']=@$post['delete_after_import'];//
        $success = $this->departments_model->add($ins);
        echo json_encode([
                    'success' => $success
                ]);
        return $success;
    }







}
