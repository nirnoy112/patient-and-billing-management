<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class BillingCompany_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get BC by id
     */
    function get_BC($id)
    {
        return $this->db->get_where('billing_companies',array('id'=>$id))->row_array();
    }

    /*
     * Get BC by RUID
     */
    function get_BC_by_RUID($ruid)
    {
        return $this->db->get_where('billing_companies',array('RUID'=>$ruid))->row_array();
    }

    /*
     * Get all BCs
     */
    function get_all_BCs()
    {
        return $this->db->get('billing_companies')->result_array();
    }
    
    /*
     * function to add new BC
     */
    function add_BC($params)
    {
        $this->db->insert('billing_companies',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update BC
     */
    function update_BC($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('billing_companies',$params);
        if($response)
        {
            return "BC updated successfully";
        }
        else
        {
            return "Error occuring while updating BC";
        }
    }
    
    /*
     * function to delete BC
     */
    function delete_BC($id)
    {
        $response = $this->db->delete('billing_companies',array('id'=>$id));
        if($response)
        {
            return "BC deleted successfully";
        }
        else
        {
            return "Error occuring while deleting BC";
        }
    }
}
