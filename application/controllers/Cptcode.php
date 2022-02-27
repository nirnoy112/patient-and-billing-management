<?php

    /*****
    *
    * @File: 'controllers/Cptcode.php'.
    * @Author: Nirnoy.
    * @CreatedOn: 16 May, 2017.
    * @LastUpdatedOn: 16 May, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');
 
class Cptcode extends NDP_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cptcode_model');

        $this->loadAppData(true);

    } 

    /*
     * Listing of cptcodes
     */
    function index()
    {
        $this->data['cptcodes'] = $this->Cptcode_model->get_all_cptcodes();

        $this->data['pageTitle'] = 'CPT Codes';
        $this->data['pageHeading'] = 'MANAGE ENLISTED CPT CODES'; 

        $this->data['_view'] = 'cptcode/index';
        $this->load->view('layouts/main',$this->data);
    }

    /*
     * Adding a new cptcode
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'code' => $this->input->post('code'),
				'description' => $this->input->post('description'),
            );
            
            $cptcode_id = $this->Cptcode_model->add_cptcode($params);
            redirect('cptcode/index');
        }
        else
        {
            $this->data['pageTitle'] = 'CPT Codes';
            $this->data['pageHeading'] = 'ENLIST NEW CPT CODE';              
            $this->data['_view'] = 'cptcode/add';
            $this->load->view('layouts/main',$this->data);
        }
    }  

    /*
     * Editing a cptcode
     */
    function edit($id)
    {   
        // check if the cptcode exists before trying to edit it
        $this->data['cptcode'] = $this->Cptcode_model->get_cptcode($id);
        
        if(isset($this->data['cptcode']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'code' => $this->input->post('code'),
					'description' => $this->input->post('description'),
                );

                $this->Cptcode_model->update_cptcode($id,$params);            
                redirect('cptcode/index');
            }
            else
            {
                $this->data['pageTitle'] = 'CPT Codes';
                $this->data['pageHeading'] = 'EDIT ENLISTED CPT CODE'; 
                $this->data['_view'] = 'cptcode/edit';
                $this->load->view('layouts/main',$this->data);
            }
        }
        else
            show_error('The cptcode you are trying to edit does not exist.');
    } 

    /*
     * Deleting cptcode
     */
    function remove($id)
    {
        $cptcode = $this->Cptcode_model->get_cptcode($id);

        // check if the cptcode exists before trying to delete it
        if(isset($cptcode['id']))
        {
            $this->Cptcode_model->delete_cptcode($id);
            redirect('cptcode/index');
        }
        else
            show_error('The cptcode you are trying to delete does not exist.');
    }
    
}
