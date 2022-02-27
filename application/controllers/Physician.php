<?php

    /*****
    *
    * @File: 'Physician.php'.
    * @Author: Nirnoy.
    * @CreatedOn: 14 May, 2017.
    * @LastUpdatedOn: 14 May, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');
 
class Physician extends NDP_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Physician_model');

        $this->loadAppData(true);

    } 

    /*
     * Listing of physicians
     */
    function index()
    {
        $this->data['physicians'] = $this->Physician_model->get_all_physicians();
        $this->data['pageTitle'] = 'Physicians';
        $this->data['pageHeading'] = 'MANAGE ENLISTED PHYSICIANS';
        $this->data['_view'] = 'physician/index';
        $this->load->view('layouts/main',$this->data);
    }

    /*
     * Adding a new physician
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'name' => $this->input->post('name'),
            );
            
            $physician_id = $this->Physician_model->add_physician($params);
            redirect('physician/index');
        }
        else
        {
            $this->data['pageTitle'] = 'Physicians';
            $this->data['pageHeading'] = 'ENLIST NEW PHYSICIAN';            
            $this->data['_view'] = 'physician/add';
            $this->load->view('layouts/main',$this->data);
        }
    }  

    /*
     * Editing a physician
     */
    function edit($id)
    {   
        // check if the physician exists before trying to edit it
        $this->data['physician'] = $this->Physician_model->get_physician($id);
        
        if(isset($this->data['physician']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'name' => $this->input->post('name'),
                );

                $this->Physician_model->update_physician($id,$params);            
                redirect('physician/index');
            }
            else
            {
                $this->data['pageTitle'] = 'Physicians';
                $this->data['pageHeading'] = 'EDIT ENLISTED PHYSICIANS';
                $this->data['_view'] = 'physician/edit';
                $this->load->view('layouts/main',$this->data);
            }
        }
        else
            show_error('The physician you are trying to edit does not exist.');
    } 

    /*
     * Deleting physician
     */
    function remove($id)
    {
        $physician = $this->Physician_model->get_physician($id);

        // check if the physician exists before trying to delete it
        if(isset($physician['id']))
        {
            $this->Physician_model->delete_physician($id);
            redirect('physician/index');
        }
        else
            show_error('The physician you are trying to delete does not exist.');
    }
    
}
