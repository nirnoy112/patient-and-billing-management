<?php

    /*****
    *
    * @File: 'User.php'.
    * @Author: Nirnoy.
    * @CreatedOn: 14 AUGUST, 2017.
    * @LastUpdatedOn: 15 AUGUST, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');
 
class User extends NDP_Controller {
    function __construct()
    {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->model('Role_model');

        $this->loadAppData(true);
        
    } 

    /*
     * Listing of Users
     */
    function index()
    {
        $this->data['all_roles'] = $this->Role_model->get_all_roles();
        $this->data['users'] = $this->User_model->get_all_users();
        $this->data['pageTitle'] = 'Users';
        $this->data['pageHeading'] = 'MANAGE ENLISTED USERS'; 
        $this->data['_view'] = 'user/index';
        $this->load->view('layouts/main',$this->data);
    }

    /*
     * Adding a new User
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   

            $Uparams = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'realName' => $this->input->post('realName'),
                'roleId' => $this->input->post('roleId'),
                'suspended' => 0
            );

            $ruid = $this->User_model->add_user($Uparams);

            redirect('user/index');
        }
        else
        {
            $this->data['all_roles'] = $this->Role_model->get_all_roles();
            $this->data['pageTitle'] = 'Users';
            $this->data['pageHeading'] = 'ENLIST NEW USER';          
            $this->data['_view'] = 'user/add';
            $this->load->view('layouts/main',$this->data);
        }
    }  

    /*
     * Editing a User
     */
    function edit($id)
    {   
        // check if the User exists before trying to edit it
        $this->data['user'] = $this->User_model->get_user($id);
        
        if(isset($this->data['user']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            { 
                $uid = $this->data['user']['id'];

                $Uparams = array(
                    'username' => $this->input->post('username'),
                    'realName' => $this->input->post('realName'),
                    'roleId' => $this->input->post('roleId'),
                    'suspended' => (int)$this->input->post('suspended')
                );

                if($this->input->post('password') != null && $this->input->post('password')!= '') {

                    $Uparams['password'] = $this->input->post('password');
                }

                $this->User_model->update_user($uid, $Uparams);           
                redirect('user/index');

            }
            else
            {
                $this->data['all_roles'] = $this->Role_model->get_all_roles();
                $this->data['pageTitle'] = 'Users';
                $this->data['pageHeading'] = 'EDIT ENLISTED USER'; 
                $this->data['_view'] = 'user/edit';
                $this->load->view('layouts/main',$this->data);
            }
        }
        else
            show_error('The User you are trying to edit does not exist.');
    } 

    /*
     * Deleting User
     */
    function remove($id)
    {
        $user = $this->User_model->get_user($id);

        // check if the User exists before trying to delete it
        if(isset($user['id']))
        {
            $uid = $user['id'];
            $this->User_model->delete_user($uid);
            redirect('user/index');
        }
        else
            show_error('The User you are trying to delete does not exist.');
    }

    
}
