<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Cptcode_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get cptcode by id
     */
    function get_cptcode($id)
    {
        return $this->db->get_where('cptcodes',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all cptcodes
     */
    function get_all_cptcodes()
    {
        return $this->db->order_by('code', 'asc')->get('cptcodes')->result_array();
    }
    
    /*
     * function to add new cptcode
     */
    function add_cptcode($params)
    {
        $this->db->insert('cptcodes',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update cptcode
     */
    function update_cptcode($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('cptcodes',$params);
        if($response)
        {
            return "cptcode updated successfully";
        }
        else
        {
            return "Error occuring while updating cptcode";
        }
    }
    
    /*
     * function to delete cptcode
     */
    function delete_cptcode($id)
    {
        $response = $this->db->delete('cptcodes',array('id'=>$id));
        if($response)
        {
            return "cptcode deleted successfully";
        }
        else
        {
            return "Error occuring while deleting cptcode";
        }
    }
}
