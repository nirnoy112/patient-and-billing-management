<?php

    /*****
    *
    * @File: 'BillingCompany.php'.
    * @Author: Nirnoy.
    * @CreatedOn: 20 JUNE, 2017.
    * @LastUpdatedOn: 20 JUNE, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');
 
class Billing_Company extends NDP_Controller {
    function __construct()
    {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->model('BillingCompany_Model');

        $this->loadAppData(true);
        
    } 

    /*
     * Listing of bcs
     */
    function index()
    {
        $this->data['bcs'] = $this->BillingCompany_Model->get_all_BCs();
        $this->data['pageTitle'] = 'Billing Companies';
        $this->data['pageHeading'] = 'MANAGE ENLISTED BILLING COMPANIES'; 
        $this->data['_view'] = 'billing_companies/index';
        $this->load->view('layouts/main',$this->data);
    }

    /*
     * Adding a new Billing Company
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   

            $Uparams = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'realName' => $this->input->post('realName'),
                'roleId' => 3,
                'suspended' => 0
            );

            $ruid = $this->User_model->add_user($Uparams);

            $params = array(
				'companyName' => $this->input->post('companyName'),
				'address' => $this->input->post('address'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'realName' => $this->input->post('realName'),
				'RUID' => $ruid
            );
            
            $bc_id = $this->BillingCompany_Model->add_BC($params);
            redirect('billing_company/index');
        }
        else
        {
            $this->data['pageTitle'] = 'Billing Companies';
            $this->data['pageHeading'] = 'ENLIST NEW BILLING COMPANY';          
            $this->data['_view'] = 'billing_companies/add';
            $this->load->view('layouts/main',$this->data);
        }
    }  

    /*
     * Editing a BillingCompany
     */
    function edit($id)
    {   
        // check if the BillingCompany exists before trying to edit it
        $this->data['bc'] = $this->BillingCompany_Model->get_BC($id);
        
        if(isset($this->data['bc']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            { 
                $ruid = $this->data['bc']['RUID']; 
                $Uparams = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password'),
                    'realName' => $this->input->post('realName'),
                    'roleId' => 3
                );

                $this->User_model->update_user($ruid, $Uparams);

                $params = array(
                    'companyName' => $this->input->post('companyName'),
                    'address' => $this->input->post('address'),
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password'),
                    'realName' => $this->input->post('realName'),
                    'RUID' => $ruid
                );

                $this->BillingCompany_Model->update_BC($id,$params);            
                redirect('billing_company/index');
            }
            else
            {
                $this->data['pageTitle'] = 'Billing Companies';
                $this->data['pageHeading'] = 'EDIT ENLISTED BILLING COMPANY'; 
                $this->data['_view'] = 'billing_companies/edit';
                $this->load->view('layouts/main',$this->data);
            }
        }
        else
            show_error('The Billing Company you are trying to edit does not exist.');
    } 

    /*
     * Deleting Billing Company
     */
    function remove($id)
    {
        $bc = $this->BillingCompany_Model->get_BC($id);

        // check if the Billing Company exists before trying to delete it
        if(isset($bc['id']))
        {
            $ruid = $bc['RUID'];
            $this->User_model->delete_user($ruid);
            $this->BillingCompany_Model->delete_BC($id);
            redirect('billing_company/index');
        }
        else
            show_error('The Billing Company you are trying to delete does not exist.');
    }
    
}
