<?php

    /*****
    *
    * @File: 'Tech.php'.
    * @Author: Nirnoy.
    * @CreatedOn: 14 May, 2017.
    * @LastUpdatedOn: 14 May, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');
 
class Tech extends NDP_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tech_model');

        $this->loadAppData(true);

    } 

    /*
     * Listing of techs
     */
    function index()
    {
        $this->data['techs'] = $this->Tech_model->get_all_techs();
        $this->data['pageTitle'] = 'Techs';
        $this->data['pageHeading'] = 'MANAGE ENLISTED TECHNICIANS';
        $this->data['_view'] = 'tech/index';
        $this->load->view('layouts/main',$this->data);
    }

    /*
     * Adding a new tech
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'title' => $this->input->post('title'),
            );
            
            $tech_id = $this->Tech_model->add_tech($params);
            redirect('tech/index');
        }
        else
        {   
            $this->data['pageTitle'] = 'Techs';
            $this->data['pageHeading'] = 'ENLIST NEW TECH';         
            $this->data['_view'] = 'tech/add';
            $this->load->view('layouts/main',$this->data);
        }
    }  

    /*
     * Editing a tech
     */
    function edit($id)
    {   
        // check if the tech exists before trying to edit it
        $this->data['tech'] = $this->Tech_model->get_tech($id);
        
        if(isset($this->data['tech']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'title' => $this->input->post('title'),
                );

                $this->Tech_model->update_tech($id,$params);            
                redirect('tech/index');
            }
            else
            {
                $this->data['pageTitle'] = 'Techs';
                $this->data['pageHeading'] = 'EDIT ENLISTED TECH'; 
                $this->data['_view'] = 'tech/edit';
                $this->load->view('layouts/main',$this->data);
            }
        }
        else
            show_error('The tech you are trying to edit does not exist.');
    } 

    /*
     * Deleting tech
     */
    function remove($id)
    {
        $tech = $this->Tech_model->get_tech($id);

        // check if the tech exists before trying to delete it
        if(isset($tech['id']))
        {
            $this->Tech_model->delete_tech($id);
            redirect('tech/index');
        }
        else
            show_error('The tech you are trying to delete does not exist.');
    }
    
}
