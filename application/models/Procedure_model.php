<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Procedure_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get procedure by id
     */
    function get_procedure($id)
    {
        return $this->db->get_where('procedures',array('id'=>$id))->row_array();
    }

    /*
     * Get procedure by patient's id
     */
    function get_procedures($pid)
    {
        return $this->db->get_where('procedures',array('patientId'=>$pid))->result_array();
    }
    
    /*
     * Get all procedures
     */
    function get_all_procedures()
    {
        return $this->db->get('procedures')->result_array();
    }
    
    /*
     * function to add new procedure
     */
    function add_procedure($params)
    {
        $this->db->insert('procedures',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update procedure
     */
    function update_procedure($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('procedures',$params);
        if($response)
        {
            return "procedure updated successfully";
        }
        else
        {
            return "Error occuring while updating procedure";
        }
    }
    
    /*
     * function to delete procedure
     */
    function delete_procedure($id)
    {
        $response = $this->db->delete('procedures',array('id'=>$id));
        if($response)
        {
            return "procedure deleted successfully";
        }
        else
        {
            return "Error occuring while deleting procedure";
        }
    }
}
