<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Role_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get role by id
     */
    function get_role($id)
    {
        return $this->db->get_where('roles',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all roles
     */
    function get_all_roles()
    {
        return $this->db->get('roles')->result_array();
    }
    
    /*
     * function to add new role
     */
    function add_role($params)
    {
        $this->db->insert('roles',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update role
     */
    function update_role($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('roles',$params);
        if($response)
        {
            return "role updated successfully";
        }
        else
        {
            return "Error occuring while updating role";
        }
    }
    
    /*
     * function to delete role
     */
    function delete_role($id)
    {
        $response = $this->db->delete('roles',array('id'=>$id));
        if($response)
        {
            return "role deleted successfully";
        }
        else
        {
            return "Error occuring while deleting role";
        }
    }
}
