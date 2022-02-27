<?php

	/*****
	*
	* @File: 'Main.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 19 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Main extends NDP_Controller {

		public function __construct() {

			parent::__construct();

			$this->loadAppData(false);

		}

		public function index() {

			redirect('login');

		}

	}

?>