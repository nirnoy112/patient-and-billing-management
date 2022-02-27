<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Definitive_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get definitive by id
     */
    function get_definitive($id)
    {
        return $this->db->get_where('definitives',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all definitives
     */
    function get_all_definitives()
    {
        return $this->db->order_by('value', 'asc')->get('definitives')->result_array();
    }
    
    /*
     * function to add new definitive
     */
    function add_definitive($params)
    {
        $this->db->insert('definitives',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update definitive
     */
    function update_definitive($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('definitives',$params);
        if($response)
        {
            return "definitive updated successfully";
        }
        else
        {
            return "Error occuring while updating definitive";
        }
    }
    
    /*
     * function to delete definitive
     */
    function delete_definitive($id)
    {
        $response = $this->db->delete('definitives',array('id'=>$id));
        if($response)
        {
            return "definitive deleted successfully";
        }
        else
        {
            return "Error occuring while deleting definitive";
        }
    }
}
