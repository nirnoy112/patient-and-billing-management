<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Status_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get status by id
     */
    function get_status($id)
    {
        return $this->db->get_where('statuses',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all statuses
     */
    function get_all_statuses()
    {
        return $this->db->get('statuses')->result_array();
    }
    
    /*
     * function to add new status
     */
    function add_status($params)
    {
        $this->db->insert('statuses',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update status
     */
    function update_status($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('statuses',$params);
        if($response)
        {
            return "status updated successfully";
        }
        else
        {
            return "Error occuring while updating status";
        }
    }
    
    /*
     * function to delete status
     */
    function delete_status($id)
    {
        $response = $this->db->delete('statuses',array('id'=>$id));
        if($response)
        {
            return "status deleted successfully";
        }
        else
        {
            return "Error occuring while deleting status";
        }
    }
}
