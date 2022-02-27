<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Icdcode_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get icdcode by id
     */
    function get_icdcode($id)
    {
        return $this->db->get_where('icdcodes',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all icdcodes
     */
    function get_all_icdcodes()
    {
        return $this->db->order_by('code', 'asc')->get('icdcodes')->result_array();
    }
    
    /*
     * function to add new icdcode
     */
    function add_icdcode($params)
    {
        $this->db->insert('icdcodes',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update icdcode
     */
    function update_icdcode($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('icdcodes',$params);
        if($response)
        {
            return "icdcode updated successfully";
        }
        else
        {
            return "Error occuring while updating icdcode";
        }
    }
    
    /*
     * function to delete icdcode
     */
    function delete_icdcode($id)
    {
        $response = $this->db->delete('icdcodes',array('id'=>$id));
        if($response)
        {
            return "icdcode deleted successfully";
        }
        else
        {
            return "Error occuring while deleting icdcode";
        }
    }
}
