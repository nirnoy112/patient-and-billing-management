<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Physician_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get physician by id
     */
    function get_physician($id)
    {
        return $this->db->get_where('physicians',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all physicians
     */
    function get_all_physicians()
    {
        return $this->db->order_by('name', 'asc')->get('physicians')->result_array();
    }
    
    /*
     * function to add new physician
     */
    function add_physician($params)
    {
        $this->db->insert('physicians',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update physician
     */
    function update_physician($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('physicians',$params);
        if($response)
        {
            return "physician updated successfully";
        }
        else
        {
            return "Error occuring while updating physician";
        }
    }
    
    /*
     * function to delete physician
     */
    function delete_physician($id)
    {
        $response = $this->db->delete('physicians',array('id'=>$id));
        if($response)
        {
            return "physician deleted successfully";
        }
        else
        {
            return "Error occuring while deleting physician";
        }
    }
}
