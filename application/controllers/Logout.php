<?php

	/*****
	*
	* @File: 'Logout.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 19 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Logout extends NDP_Controller {

		public function __construct() {

			parent::__construct();
			$this->loadAppData(true);

		}

		public function index() {



			$this->sbpLog('LOGGED OUT');

			$this->session->sess_destroy();

			redirect('login');

		}

	}

?>