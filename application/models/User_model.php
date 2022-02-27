<?php

    /*****
    *
    * @Author: Nasid Kamal.
    * @CreatedOn: 19 JUNE, 2017.
    * @LastUpdatedOn: 15 AUGUST, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get user by id
     */
    function get_user($id)
    {
        return $this->db->get_where('users',array('id'=>$id))->row_array();
    }

    /*
     * Authenticate user
     */
    function authenticate_user($username, $password)
    {
        return $this->db->get_where('users',array('username'=>$username, 'password'=>$password))->row_array();
    }

    
    /*
     * Get all users
     */
    function get_all_users()
    {
        return $this->db->get('users')->result_array();
    }
    
    /*
     * function to add new user
     */
    function add_user($params)
    {
        $this->db->insert('users',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update user
     */
    function update_user($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('users',$params);
        if($response)
        {
            return "user updated successfully";
        }
        else
        {
            return "Error occuring while updating user";
        }
    }
    
    /*
     * function to delete user
     */
    function delete_user($id)
    {
        $response = $this->db->delete('users',array('id'=>$id));
        if($response)
        {
            return "user deleted successfully";
        }
        else
        {
            return "Error occuring while deleting user";
        }
    }
    
    /*
     * function to suspend user
     */
    function suspend_user($id)
    {

        $params = array(

            'suspended' => 1

        );

        $this->db->where('id',$id);

        $response = $this->db->update('users',$params);
        if($response)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

}
