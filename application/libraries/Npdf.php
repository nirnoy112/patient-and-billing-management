<?php

	/*****
	*
	* @File: 'Npdf.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 23 MAY, 2017.
	* @LastUpdatedOn: 23 MAY, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

	include_once APPPATH.'/third_party/mpdf/mpdf.php';

	class Npdf {

	    public $param;
	    public $pdf;

	    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3') {

	        $this->param = $param;
	        $this->pdf = new mPDF($this->param);

	    }

	}


?>