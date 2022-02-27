<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Tech_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get tech by id
     */
    function get_tech($id)
    {
        return $this->db->get_where('techs',array('id'=>$id))->row_array();
    }

    /*
     * Get tech by title
     */
    function get_tech_by_title($title)
    {
        return $this->db->get_where('techs',array('title'=>$title))->row_array();
    }
    
    /*
     * Get all techs
     */
    function get_all_techs()
    {
        return $this->db->order_by('title', 'asc')->get('techs')->result_array();
    }
    
    /*
     * function to add new tech
     */
    function add_tech($params)
    {
        $this->db->insert('techs',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update tech
     */
    function update_tech($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('techs',$params);
        if($response)
        {
            return "tech updated successfully";
        }
        else
        {
            return "Error occuring while updating tech";
        }
    }
    
    /*
     * function to delete tech
     */
    function delete_tech($id)
    {
        $response = $this->db->delete('techs',array('id'=>$id));
        if($response)
        {
            return "tech deleted successfully";
        }
        else
        {
            return "Error occuring while deleting tech";
        }
    }
}
