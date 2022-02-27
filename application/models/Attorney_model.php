<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 19 May, 2017.
    * @LastUpdatedOn: 19 May, 2017.
    *
    *****/


class Attorney_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get attorney by id
     */
    function get_attorney($id)
    {
        return $this->db->get_where('attorneys',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all attorneys
     */
    function get_all_attorneys()
    {
        return $this->db->get('attorneys')->result_array();
    }
    
    /*
     * function to add new attorney
     */
    function add_attorney($params)
    {
        $this->db->insert('attorneys',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update attorney
     */
    function update_attorney($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('attorneys',$params);
        if($response)
        {
            return "attorney updated successfully";
        }
        else
        {
            return "Error occuring while updating attorney";
        }
    }
    
    /*
     * function to delete attorney
     */
    function delete_attorney($id)
    {
        $response = $this->db->delete('attorneys',array('id'=>$id));
        if($response)
        {
            return "attorney deleted successfully";
        }
        else
        {
            return "Error occuring while deleting attorney";
        }
    }
}
