<?php

	/*****
	*
	* @File: 'controllers/D.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 22 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

	class D extends NDP_Controller {

		public function __construct() {

			parent::__construct();

			$this->load->model('Patient_model');
			$this->load->model('Order_model');
			$this->load->model('Facility_model');
			$this->load->model('Tech_model');
			$this->load->model('Physician_model');
			$this->load->model('Cptcode_model');
			$this->load->model('Procedure_model');

			$this->loadAppData(true);

		}

		public function restoreStaticData($apid) {

			$patient = $this->Patient_model->get_patient($apid);

	        $osid = $patient['OSID'];

	        $order = $this->Order_model->get_order($osid);

	        $pDate = date('m-d-Y', $order['scheduledTime']);

	        $procedures = $this->Procedure_model->get_procedures($apid);

	        $total_charge = 00.00;

			foreach ($procedures as $procedure) {


				$id = $procedure['id'];
				
				if($procedure['charges'] != '' && $procedure['charges'] != null) {

                        $total_charge = $total_charge + $procedure['charges'];

                    }

				$procedure['dateFrom'] = $pDate;
                $procedure['dateTo'] = $pDate;
                $procedure['placeOfService'] = '24';
                $procedure['reserved'] = '1083887186';

                $procedureParams = $this->getAbsoluteArray($procedure);
                $this->Procedure_model->update_procedure($id, $procedure);
			}

	        $facilityId = $order['facilityId'];
	        $referringPhysicianId = $order['referringPhysicianId'];
	        $techId = $order['techId'];
	        $scheduledTime = $order['scheduledTime'];

	        $facility = $this->Facility_model->get_facility($facilityId);
	        $tech = $this->Tech_model->get_tech($techId);
	        $physician = $this->Physician_model->get_physician($referringPhysicianId);

	        $facililyName = strtoupper($facility['name']);

	        $facililyAddress = strtoupper($facility['address']);

	        $facililyLocation = strtoupper($facility['city'] . ', ' . $facility['state'] . ' ' . $facility['zip']);

	        $pParams = $patient;

	        $pParams['SFLInfo'] = <<<EOT
{$facililyName}
{$facililyAddress}
{$facililyLocation}
EOT;


		    $pParams['SFLInfoA'] = $facility['uCode'];

		    $pParams['BillingProviderInfoA'] = '1083887186';

		    $pParams['BillingProviderInfo'] = <<<EOT
SADDLEBACK PORTABLE X-RAY
P.O. BOX 4427
SANTA ANA, CA 92701
EOT;


			$patientParams = $this->getAbsoluteArray($pParams);
			$this->Patient_model->update_patient($apid, $patientParams);


        
    	}

    	public function restoreAll() {


    		$ps = $this->Patient_model->get_all_patients();

    		foreach ($ps as $p) {
    			

    			$this->restoreStaticData($p['id']);

    		}

    		echo 'Restored Static Data For ' . count($ps) . ' Existing Patients...!';


    	}

		public function index() {

			//echo 'D';
			var_dump($this->data);

		}

	}

?>