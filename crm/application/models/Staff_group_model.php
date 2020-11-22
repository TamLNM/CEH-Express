<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Staff_group_model extends App_Model
{
    /**
     * Add new employee role
     * @param mixed $data
     */
    public function add($data)
    {
        //print_r($data);die();
        $data['datecreated'] = date("Y-m-d H:i:s");
        unset($data['id']);
        $this->db->insert(db_prefix() . 'staff_group', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            log_activity('New Staff group Added [ID: ' . $insert_id . '.' . $data['staff_group_name'] . ']');
            return $insert_id;
        }

        return false;
    }

    /**
     * Update employee role
     * @param  array $data role data
     * @param  mixed $id   role id
     * @return boolean
     */
    public function update($data, $id)
    {
        $affectedRows = 0;
        
        $data['datecreated'] = date("Y-m-d H:i:s");
        unset($data['id']);
        $this->db->where('staff_groupid', $id);
        //print_r($data);die();
        $this->db->update(db_prefix() . 'staff_group', $data);

        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }

        if ($affectedRows > 0) {
            log_activity('Staff group Updated [ID: ' . $id . ', Name: ' . $data['staff_group_name'] . ']');
            return true;
        }

        return false;
    }

    /**
     * Get employee role by id
     * @param  mixed $id Optional role id
     * @return mixed     array if not id passed else object
     */
    public function get($id = '')
    {
        if (is_numeric($id)) {

            $role = $this->app_object_cache->get('role-' . $id);

            if ($role) {
                return $role;
            }

            $this->db->where('staff_groupid', $id);

            $role              = $this->db->get(db_prefix() . 'staff_group')->row();
            $role->permissions = !empty($role->permissions) ? unserialize($role->permissions) : [];

            $this->app_object_cache->add('role-' . $id, $role);

            return $role;
        }

        return $this->db->get(db_prefix() . 'staff_group')->result_array();
    }

    /**
     * Delete employee role
     * @param  mixed $id role id
     * @return mixed
     */
    public function delete($id)
    {

        $affectedRows = 0;
        $this->db->where('staff_groupid', $id);
        $this->db->delete(db_prefix() . 'staff_group');

        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }

        if ($affectedRows > 0) {
            log_activity('Staff group Deleted [ID: ' . $id);

            return true;
        }

        return false;
    }


}
