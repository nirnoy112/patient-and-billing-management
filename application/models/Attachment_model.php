<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Attachment_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get attachment by id
     */
    function get_attachment($id)
    {
        return $this->db->get_where('attachments',array('id'=>$id))->row_array();
    }

    /*
     * Get attachment count by pid
     */
    function get_attachment_count($pid)
    {
        $this->db->where('patientId', $pid);

        $count = $this->db->count_all_results('attachments');

        return $count;

    }

    /*
     * Get attachments by Patient Id
     */
    function get_attachments($pid)
    {
        return $this->db->get_where('attachments',array('patientId'=>$pid))->result_array();
    }
    
    /*
     * Get all attachments
     */
    function get_all_attachments()
    {
        return $this->db->get('attachments')->result_array();
    }
    
    /*
     * function to add new attachment
     */
    function add_attachment($params)
    {
        $this->db->insert('attachments',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update attachment
     */
    function update_attachment($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('attachments',$params);
        if($response)
        {
            return "attachment updated successfully";
        }
        else
        {
            return "Error occuring while updating attachment";
        }
    }
    
    /*
     * function to delete attachment
     */
    function delete_attachment($id)
    {
        $response = $this->db->delete('attachments',array('id'=>$id));
        if($response)
        {
            return "attachment deleted successfully";
        }
        else
        {
            return "Error occuring while deleting attachment";
        }
    }
}