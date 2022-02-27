<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 19 May, 2017.
    * @LastUpdatedOn: 19 May, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

class Attorney extends NDP_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Attorney_model');

        $this->loadAppData(true);
    } 

    /*
     * Listing of attorneys
     */
    function index()
    {
        $this->data['attorneys'] = $this->Attorney_model->get_all_attorneys();
        $this->data['pageTitle'] = 'Attorneys';
        $this->data['pageHeading'] = 'MANAGE ENLISTED ATTORNEYS'; 
        $this->data['_view'] = 'attorney/index';
        $this->load->view('layouts/main',$this->data);
    }

    /*
     * Adding a new attorney
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'name' => $this->input->post('name'),
				'primaryContact' => $this->input->post('primaryContact'),
				'email' => $this->input->post('email'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'zip' => $this->input->post('zip'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
            );
            
            $attorney_id = $this->Attorney_model->add_attorney($params);
            redirect('attorney/index');
        }
        else
        {
            $this->data['pageTitle'] = 'Attorneys';
            $this->data['pageHeading'] = 'ENLIST NEW ATTORNEY'; 
            $this->data['_view'] = 'attorney/add';
            $this->load->view('layouts/main',$this->data);
        }
    }  

    /*
     * Editing a attorney
     */
    function edit($id)
    {   
        // check if the attorney exists before trying to edit it
        $this->data['attorney'] = $this->Attorney_model->get_attorney($id);
        
        if(isset($this->data['attorney']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'name' => $this->input->post('name'),
					'primaryContact' => $this->input->post('primaryContact'),
					'email' => $this->input->post('email'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zip' => $this->input->post('zip'),
					'phone' => $this->input->post('phone'),
					'fax' => $this->input->post('fax'),
                );

                $this->Attorney_model->update_attorney($id,$params);            
                redirect('attorney/index');
            }
            else
            {
                $this->data['pageTitle'] = 'Attorneys';
                $this->data['pageHeading'] = 'EDIT ENLISTED ATTORNEY'; 
                $this->data['_view'] = 'attorney/edit';
                $this->load->view('layouts/main',$this->data);
            }
        }
        else
            show_error('The attorney you are trying to edit does not exist.');
    } 

    /*
     * Deleting attorney
     */
    function remove($id)
    {
        $attorney = $this->Attorney_model->get_attorney($id);

        // check if the attorney exists before trying to delete it
        if(isset($attorney['id']))
        {
            $this->Attorney_model->delete_attorney($id);
            redirect('attorney/index');
        }
        else
            show_error('The attorney you are trying to delete does not exist.');
    }
    
}
