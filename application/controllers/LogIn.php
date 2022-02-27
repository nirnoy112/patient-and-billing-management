<?php

	/*****
	*
	* @File: 'Login.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 19 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

	class LogIn extends NDP_Controller {

		public function __construct() {

			parent::__construct();

			$this->load->model('User_model');

			$this->loadAppData(false);

		}

		public function index() {

			if($this->data['is_authorized'] == false) {

				$data['pageTitle'] = 'Login';
				$data['pageHeading'] = 'SCHEDULE MANAGEMENT SYSTEM';
				$data['errorMessage'] = $this->session->flashdata('errorMessage');

				$data['_view'] = 'login/index';

				$this->load->view('layouts/main',$data);

			} else {

				redirect('order');

			}

		}

		public function authenticate() {

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$data['user'] = $this->User_model->authenticate_user($username, $password);

			if(isset($data['user']['id'])) {

				$this->updateUserSession('is_authorized', true);
				$this->updateUserSession('id', $data['user']['id']);
				$this->updateUserSession('username', $data['user']['username']);
				$this->updateUserSession('realName', $data['user']['realName']);
				$this->updateUserSession('roleId', $data['user']['roleId']);
				
				$rules = array(
	                'sortBy' => 'scheduledTime',
	                'sortingOrder' => 'asc',
	                'fid' => 0,
	                'rpid' => 0,
	                'tid' => 0,
	                'dateFrom' => '01-01-2000',
	                'dateTo' => '01-01-2020'

	            );

	            $this->updateUserSession('query_rules', $rules);

	            $oRules = array(
	                'sortBy' => 'scheduledTime',
	                'sortingOrder' => 'asc',
	                'fid' => 0,
	                'rpid' => 0,
	                'tid' => 0,
	                'dateFrom' => '01-01-2000',
	                'dateTo' => '01-01-2020'

	            );

	            $this->updateUserSession('o_query_rules', $oRules);

	            $pRules = array(
	                'sortBy' => 'scheduledTime',
	                'sortingOrder' => 'asc',
	                'fid' => 0,
	                'rpid' => 0,
	                'tid' => 0,
	                'dateFrom' => date('m-d-Y'),
	                'dateTo' => date('m-d-Y')

	            );
	            $this->updateUserSession('p_query_rules', $pRules);

				$this->sbpLog('LOGGED IN');

				if((int)$data['user']['roleId'] == 3) {

					redirect('patient');

				} else {

					redirect('order');

				}
				

			} else {

				$this->session->set_flashdata('errorMessage', 'Wrong Credentials.!!! To Get Help, Please Call 1-315-575-6970');
				redirect('login');

			}

			
		}

	}

?>
