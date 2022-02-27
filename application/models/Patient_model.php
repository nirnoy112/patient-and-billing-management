<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Patient_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get DB column name list
     */
    function getFields() {

        return $this->db->list_fields('patients');
        
    }

    /*
     * Get patient by PID
     */
    function pickPatient($pid)
    {

        return $this->db->get_where('patients',array('PID'=>$pid))->row_array();

    }

    /*
     * Get patients by LN
     */
    function pickPatientByLN($ln)
    {

        return $this->db->get_where('patients',array('lastName'=>$ln))->result_array();

    }
    
    /*
     * Get patient by id
     */
    function get_patient($id)
    {
        return $this->db->get_where('patients',array('id'=>$id))->row_array();
    }

    /*
     * Get patient by oid
     */
    function get_patients($oid)
    {
        return $this->db->order_by('firstName', 'asc')->get_where('patients',array('OSID'=>$oid))->result_array();
    }

    /*
     * Get patient by oid
     */
    function get_facility_patients($uCode)
    {
        return $this->db->order_by('firstName', 'asc')->get_where('patients',array('SFLInfoA'=>$uCode))->result_array();
    }

    /*
     * Get patient by bcid
     */
    function get_patients_by_bc($bcid)
    {
        return $this->db->order_by('firstName', 'asc')->get_where('patients',array('BCID'=>$bcid))->result_array();
    }

    /*
     * Get patient count by oid
     */
    function get_patient_count($osid)
    {
        $this->db->where('OSID', $osid);

        $count = $this->db->count_all_results('patients');

        return $count;

    }
    
    /*
     * Get all patients
     */
    function get_all_patients()
    {
        return $this->db->get('patients')->result_array();
    }
    
    /*
     * function to add new patient
     */
    function add_patient($pParams)
    {
        $this->db->insert('patients', $pParams);
        return $this->db->insert_id();
    }
    
    /*
     * function to update patient
     */
    function update_patient($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('patients',$params);
        if($response)
        {
            return "patient updated successfully";
        }
        else
        {
            return "Error occuring while updating patient";
        }
    }
    
    /*
     * function to delete patient
     */
    function delete_patient($id)
    {
        $response = $this->db->delete('patients',array('id'=>$id));
        if($response)
        {
            return "patient deleted successfully";
        }
        else
        {
            return "Error occuring while deleting patient";
        }
    }
}
