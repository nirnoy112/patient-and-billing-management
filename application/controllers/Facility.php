<?php

    /*****
    *
    * @File: 'Facility.php'.
    * @Author: Nirnoy.
    * @CreatedOn: 14 May, 2017.
    * @LastUpdatedOn: 14 May, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');
 
class Facility extends NDP_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Facility_model');

        $this->loadAppData(true);
        
    } 

    /*
     * Listing of facilities
     */
    function index()
    {
        $this->data['facilities'] = $this->Facility_model->get_all_facilities();
        $this->data['pageTitle'] = 'Facilities';
        $this->data['pageHeading'] = 'MANAGE ENLISTED FACILITIES'; 
        $this->data['_view'] = 'facility/index';
        $this->load->view('layouts/main',$this->data);
    }

    /*
     * Adding a new facility
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'name' => $this->input->post('name'),
				'uCode' => $this->input->post('uCode'),
				'address' => $this->input->post('address'),
				'address2' => $this->input->post('address2'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'zip' => $this->input->post('zip'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax')
            );
            
            $facility_id = $this->Facility_model->add_facility($params);
            redirect('facility/index');
        }
        else
        {
            $this->data['pageTitle'] = 'Facilities';
            $this->data['pageHeading'] = 'ENLIST NEW FACILITY';          
            $this->data['_view'] = 'facility/add';
            $this->load->view('layouts/main',$this->data);
        }
    }  

    /*
     * Editing a facility
     */
    function edit($id)
    {   
        // check if the facility exists before trying to edit it
        $this->data['facility'] = $this->Facility_model->get_facility($id);
        
        if(isset($this->data['facility']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'name' => $this->input->post('name'),
					'uCode' => $this->input->post('uCode'),
					'address' => $this->input->post('address'),
					'address2' => $this->input->post('address2'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zip' => $this->input->post('zip'),
                    'phone' => $this->input->post('phone'),
                    'fax' => $this->input->post('fax')
                );

                $this->Facility_model->update_facility($id,$params);            
                redirect('facility/index');
            }
            else
            {
                $this->data['pageTitle'] = 'Facilities';
                $this->data['pageHeading'] = 'EDIT ENLISTED FACILITY'; 
                $this->data['_view'] = 'facility/edit';
                $this->load->view('layouts/main',$this->data);
            }
        }
        else
            show_error('The facility you are trying to edit does not exist.');
    } 

    /*
     * Deleting facility
     */
    function remove($id)
    {
        $facility = $this->Facility_model->get_facility($id);

        // check if the facility exists before trying to delete it
        if(isset($facility['id']))
        {
            $this->Facility_model->delete_facility($id);
            redirect('facility/index');
        }
        else
            show_error('The facility you are trying to delete does not exist.');
    }
    
}
