<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Facility_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get facility by id
     */
    function get_facility($id)
    {
        return $this->db->get_where('facilities',array('id'=>$id))->row_array();
    }

    /*
     * Get facility by id
     */
    function get_facility_by_ucode($uCode)
    {
        return $this->db->get_where('facilities',array('uCode'=>$uCode))->row_array();
    }
    
    /*
     * Get all facilities
     */
    function get_all_facilities()
    {
        return $this->db->order_by('name', 'asc')->get('facilities')->result_array();
    }
    
    /*
     * function to add new facility
     */
    function add_facility($params)
    {
        $this->db->insert('facilities',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update facility
     */
    function update_facility($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('facilities',$params);
        if($response)
        {
            return "facility updated successfully";
        }
        else
        {
            return "Error occuring while updating facility";
        }
    }
    
    /*
     * function to delete facility
     */
    function delete_facility($id)
    {
        $response = $this->db->delete('facilities',array('id'=>$id));
        if($response)
        {
            return "facility deleted successfully";
        }
        else
        {
            return "Error occuring while deleting facility";
        }
    }
}
