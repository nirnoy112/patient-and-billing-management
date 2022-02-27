<?php

    /*****
    *
    * @File: 'Order.php'.
    * @Author: Nirnoy.
    * @CreatedOn: 15 April, 2017.
    * @LastUpdatedOn: 19 April, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');
 
    class Order extends NDP_Controller {

        function __construct() {

            parent::__construct();

            $this->load->model('Order_model');
            $this->load->model('Patient_model');

            $this->loadAppData(true);

        }

        public function index() {

            redirect('order/enlist');

        }

        /*
         * Listing of orders
         */
        public function enlist() {

            $this->load->model('Facility_model');
            $this->data['all_facilities'] = $this->Facility_model->get_all_facilities();

            $this->load->model('Tech_model');
            $this->data['all_techs'] = $this->Tech_model->get_all_techs();

            $this->load->model('Status_model');
            $this->data['all_statuses'] = $this->Status_model->get_all_statuses();

            $this->load->model('Physician_model');
            $this->data['all_physicians'] = $this->Physician_model->get_all_physicians();

            $this->load->model('Cptcode_model');
            $this->data['all_cptcodes'] = $this->Cptcode_model->get_all_cptcodes();

            $this->load->model('Icdcode_model');
            $this->data['all_icdcodes'] = $this->Icdcode_model->get_all_icdcodes();

            $this->load->model('Definitive_model');
            $this->data['all_definitives'] = $this->Definitive_model->get_all_definitives();

            $query_rules = $this->data['query_rules'];

            $this->data['filter_data'] = $query_rules;

            if($query_rules['dateFrom'] != null && $query_rules['dateTo'] != null) {

                $dfs = $query_rules['dateFrom'] . ' 00:00:00';
                $dts = $query_rules['dateTo'] . ' 23:59:59';

                $df = DateTime::createFromFormat('m-d-Y H:i:s', $dfs);
                $dt = DateTime::createFromFormat('m-d-Y H:i:s', $dts);

                $query_rules['dateFrom'] = strtotime($df->format('Y-m-d H:i:s'));
                $query_rules['dateTo'] = strtotime($dt->format('Y-m-d H:i:s'));

            }

            if((int)$this->data['roleId'] == 2) {

                $tech = $this->Tech_model->get_tech_by_title($this->data['realName']);
                $query_rules['tid'] = $tech['id'];

                $this->data['all_techs'] = array();

            }

            if(isset($_POST['manage_patient'])) {

                $aoid = (int)$this->input->post('oid');

                $patient = array(
                    'id' => 0,
                    'firstName' => '',
                    'lastName' => '',
                    'dob' => '',
                    'PID' => '',
                    'financialClass' => 'NONE',
                    'OSID' => $aoid,
                    'processStatusId' => 1
                );

                $procedures = $this->_getProcedures(0);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = 0;
                $this->data['patient'] = $patient;
                $this->data['procedures'] = $procedures;

                $this->data['_modal'] = 'patient/patient-modal';


            }

            if(isset($_POST['add_patient'])) {

                $aoid = (int)$this->input->post('aoid');
                $patient = $this->input->post('patient');

                $pFields = $this->Patient_model->getFields();

                $pa = array();
                foreach ($pFields as $pField) {
                    $pa[$pField] = '';
                }
                
                foreach ($patient as $key => $value) {
                    $pa[$key] = $value;
                }

                $pParams = $pa;


                $order = $this->Order_model->get_order($aoid);

                $facilityId = $order['facilityId'];

                $this->load->model('Facility_model');

                $facility = $this->Facility_model->get_facility($facilityId);
                
                //$pParams['id'] = 0;

                $ids = $this->input->post('ids');
                $procedures = $this->input->post('procedures');

                $pParams['OSID'] = $aoid;
                $pParams['processStatusId'] = 1;

                $current_time = date("Y-m-d H:i:s");

                $pParams['timeOfLastUpdate'] = $current_time;

                $facililyName = strtoupper($facility['name']);

                $facililyAddress = strtoupper($facility['address']);

                $facililyLocation = strtoupper($facility['city'] . ', ' . $facility['state'] . ' ' . $facility['zip']);

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


                unset($pParams['id']);
                $absolute_patient =  $this->getAbsoluteArray($pParams);

                /*var_dump($pParams);
                var_dump($absolute_patient);
                die();*/

                $insertedPatientId = $this->Patient_model->add_patient($absolute_patient);

                /*var_dump($insertedPatientId);
                die();*/

                $count = 0;

                foreach ($ids as $id) {

                    $procedure = $procedures[$count];

                    if($procedure['cptId'] > 0 || $procedure['anatomicalPosition'] != 'NONE' || $procedure['icdId'] > 0 || $procedure['definitiveId'] > 0) {

                        /*$pIcdcode = '';

                        if($procedure['icdId'] > 0) {

                            foreach($this->data['all_icdcodes'] as $icdcode){

                                if($icdcode['id'] ==  $procedure['icdId']) {
                                    $pIcdcode = $icdcode['code'];
                                }

                            }

                        }*/

                        $procedure['patientId'] = $insertedPatientId;

                        $procedure['dateFrom'] = date('m-d-Y', $order['scheduledTime']);
                        $procedure['dateTo'] = date('m-d-Y', $order['scheduledTime']);
                        $procedure['placeOfService'] = '24';
                        $procedure['reserved'] = '1083887186';

                        $this->load->model('Procedure_model');
                        $this->Procedure_model->add_procedure($procedure);

                    }

                    $count++;

                }

            }

            if(isset($_POST['update_patient'])) {

                $apid = (int)$this->input->post('apid');
                $patient = $this->input->post('patient');

                $this->Patient_model->update_patient($apid, $patient);
                
            }

            $config = array();
            $config["base_url"] = base_url() . '/order/enlist';
            $config["per_page"] = 15;
            $config["uri_segment"] = 3;

            $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
            $config['full_tag_close'] = '</ul>';
            $config['prev_link'] = '&lt;';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = '&gt;';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="current"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
             
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
             
            $config['first_link'] = '&lt;&lt;';
            $config['last_link'] = '&gt;&gt;';

            $config["total_rows"] = $this->Order_model->pullCount($query_rules);

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $links = $this->pagination->create_links();
            //var_dump($query_rules); var_dump($config["total_rows"]);var_dump($links); die();

            $this->data['ctrl'] = $this;
            $this->data['pageTitle'] = 'Orders';
            $this->data['pageHeading'] = 'SCHEDULED ORDERS';
            $this->data['links'] = $links;
            $this->data['orders'] = $this->Order_model->pullOrders($query_rules, $config["per_page"], $page);
            $this->data['_view'] = 'order/index';
            $this->load->view('layouts/main', $this->data);

        }

        public function filter() {

            $this->load->model('Facility_model');
            $this->data['all_facilities'] = $this->Facility_model->get_all_facilities();

            $this->load->model('Tech_model');
            $this->data['all_techs'] = $this->Tech_model->get_all_techs();

            $this->load->model('Status_model');
            $this->data['all_statuses'] = $this->Status_model->get_all_statuses();

            $this->load->model('Physician_model');
            $this->data['all_physicians'] = $this->Physician_model->get_all_physicians();

            $this->load->model('Cptcode_model');
            $this->data['all_cptcodes'] = $this->Cptcode_model->get_all_cptcodes();

            $this->load->model('Icdcode_model');
            $this->data['all_icdcodes'] = $this->Icdcode_model->get_all_icdcodes();

            $this->load->model('Definitive_model');
            $this->data['all_definitives'] = $this->Definitive_model->get_all_definitives();

            //$query_rules = $this->input->post('fdata');
            //var_dump($query_rules);die();

            $query_rules = $this->data['o_query_rules'];
            $this->data['filter_data'] = $query_rules;

            if(isset($_POST['run_filter'])) {

                $o_query_rules = $this->input->post('fdata');
                //$o_query_rules['sortingOrder'] = 'asc';
                $this->updateUserSession('o_query_rules', $o_query_rules);
                redirect('order/filter');


            }

            //$this->data['filter_data'] = $query_rules;

            if($query_rules['dateFrom'] && $query_rules['dateTo']) {

                $dfs = $query_rules['dateFrom'] . ' 00:00:00';
                $dts = $query_rules['dateTo'] . ' 23:59:59';

                $df = DateTime::createFromFormat('m-d-Y H:i:s', $dfs);
                $dt = DateTime::createFromFormat('m-d-Y H:i:s', $dts);

                $query_rules['dateFrom'] = strtotime($df->format('Y-m-d H:i:s'));
                $query_rules['dateTo'] = strtotime($dt->format('Y-m-d H:i:s'));

            }

            if((int)$this->data['roleId'] == 2) {

                $tech = $this->Tech_model->get_tech_by_title($this->data['realName']);
                $query_rules['tid'] = $tech['id'];

                $this->data['all_techs'] = array();

            }

            /*if(isset($_POST['manage_patient'])) {

                $aoid = (int)$this->input->post('oid');

                $patient = array(
                    'id' => 0,
                    'firstName' => '',
                    'lastName' => '',
                    'dob' => '',
                    'PID' => '',
                    'OSID' => $aoid,
                    'processStatusId' => 1
                );

                $procedures = $this->_getProcedures(0);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = 0;
                $this->data['patient'] = $patient;
                $this->data['procedures'] = $procedures;


                $this->data['_modal'] = 'patient/patient-modal';


            }

            if(isset($_POST['add_patient'])) {

                $aoid = (int)$this->input->post('aoid');
                $patient = $this->input->post('patient');
                $patient['OSID'] = $aoid;
                $patient['processStatusId'] = 1;

                $insertedPatientId = $this->Patient_model->add_patient($patient);

                $count = 0;

                foreach ($ids as $id) {

                    $procedure = $procedures[$count];

                    if($procedure['cptId'] > 0 || $procedure['anatomicalPosition'] != 'NONE' || $procedure['icdId'] > 0 || $procedure['definitiveId'] > 0) {

                        $procedure['patientId'] = $insertedPatientId;

                        $this->load->model('Procedure_model');
                        $this->Procedure_model->add_procedure($procedure);

                    }

                    $count++;

                }

            }*/

            if(isset($_POST['manage_patient'])) {

                $aoid = (int)$this->input->post('oid');

                $patient = array(
                    'id' => 0,
                    'firstName' => '',
                    'lastName' => '',
                    'dob' => '',
                    'PID' => '',
                    'financialClass' => 'NONE',
                    'OSID' => $aoid,
                    'processStatusId' => 1
                );

                $procedures = $this->_getProcedures(0);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = 0;
                $this->data['patient'] = $patient;
                $this->data['procedures'] = $procedures;

                $this->data['_modal'] = 'patient/patient-modal';


            }

            if(isset($_POST['add_patient'])) {

                $aoid = (int)$this->input->post('aoid');
                $patient = $this->input->post('patient');

                $pFields = $this->Patient_model->getFields();

                $pa = array();
                foreach ($pFields as $pField) {
                    $pa[$pField] = '';
                }
                
                foreach ($patient as $key => $value) {
                    $pa[$key] = $value;
                }

                $pParams = $pa;


                $order = $this->Order_model->get_order($aoid);

                $facilityId = $order['facilityId'];

                $this->load->model('Facility_model');

                $facility = $this->Facility_model->get_facility($facilityId);
                
                //$pParams['id'] = 0;

                $ids = $this->input->post('ids');
                $procedures = $this->input->post('procedures');

                $pParams['OSID'] = $aoid;
                $pParams['processStatusId'] = 1;

                $current_time = date("Y-m-d H:i:s");

                $facililyName = strtoupper($facility['name']);

                $facililyAddress = strtoupper($facility['address']);

                $facililyLocation = strtoupper($facility['city'] . ', ' . $facility['state'] . ' ' . $facility['zip']);

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

                $pParams['timeOfLastUpdate'] = $current_time;


                unset($pParams['id']);
                $absolute_patient =  $this->getAbsoluteArray($pParams);

                /*var_dump($pParams);
                var_dump($absolute_patient);
                die();*/

                $insertedPatientId = $this->Patient_model->add_patient($absolute_patient);

                /*var_dump($insertedPatientId);
                die();*/

                $order = $this->Order_model->get_order($aoid);

                $count = 0;

                foreach ($ids as $id) {

                    $procedure = $procedures[$count];

                    if($procedure['cptId'] > 0 || $procedure['anatomicalPosition'] != 'NONE' || $procedure['icdId'] > 0 || $procedure['definitiveId'] > 0) {

                        $pIcdcode = '';

                        if($procedure['icdId'] > 0) {

                            foreach($this->data['all_icdcodes'] as $icdcode){

                                if($icdcode['id'] ==  $procedure['icdId']) {
                                    $pIcdcode = $icdcode['code'];
                                }

                            }

                        }

                        $procedure['patientId'] = $insertedPatientId;

                        $procedure['dateFrom'] = date('m-d-Y', $order['scheduledTime']);
                        $procedure['dateTo'] = date('m-d-Y', $order['scheduledTime']);
                        $procedure['placeOfService'] = '24';
                        $procedure['reserved'] = $pIcdcode;

                        $this->load->model('Procedure_model');
                        $this->Procedure_model->add_procedure($procedure);

                    }

                    $count++;

                }

            }

            $config = array();
            $config["base_url"] = base_url() . 'order/filter';
            $config["per_page"] = 15;
            $config["uri_segment"] = 3;

            $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
            $config['full_tag_close'] = '</ul>';
            $config['prev_link'] = '&lt;';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = '&gt;';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="current"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
             
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
             
            $config['first_link'] = '&lt;&lt;';
            $config['last_link'] = '&gt;&gt;';
            $this->load->model('Order_model');
            //$this->load->model('Patient_model');
            $config["total_rows"] = $this->Order_model->pullCount($query_rules);

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $links = $this->pagination->create_links();
            
            $this->data['ctrl'] = $this;
            $this->data['pageTitle'] = 'Filter Result';
            $this->data['pageHeading'] = 'FOUND ORDERS';
            $this->data['links'] = $links;
            $this->data['orders'] = $this->Order_model->pullOrders($query_rules, $config["per_page"], $page);
            $this->data['_view'] = 'order/index';
            $this->load->view('layouts/main', $this->data);

        }

        /*
         * Adding a new order
         */
        function add() {

            $this->data['pageTitle'] = 'Add Schedule';
            $this->data['pageHeading'] = 'CREATE SCHEDULE';

            if(isset($_POST) && count($_POST) > 0) {

                $sts = $this->input->post('schedule-date') . ' ' . $this->input->post('time');
                //var_dump($sts); die();
                $st = DateTime::createFromFormat('m-d-Y H:i', $sts);

                $params = array(

                    'scheduledTime' =>  strtotime($st->format('Y-m-d H:i')),
                    'facilityId' => $this->input->post('facilityId'),
                    'referringPhysicianId' => $this->input->post('referringPhysicianId'),
                    'techId' => $this->input->post('techId')

                );
                
                $order_id = $this->Order_model->add_order($params);
                redirect('order/index');

            } else {

                $this->load->model('Facility_model');
                $this->data['all_facilities'] = $this->Facility_model->get_all_facilities();

                $this->load->model('Tech_model');
                $this->data['all_techs'] = $this->Tech_model->get_all_techs();

                $this->load->model('Status_model');
                $this->data['all_statuses'] = $this->Status_model->get_all_statuses();

                $this->load->model('Physician_model');
                $this->data['all_physicians'] = $this->Physician_model->get_all_physicians();

                $this->load->model('Cptcode_model');
                $this->data['all_cptcodes'] = $this->Cptcode_model->get_all_cptcodes();

                $this->load->model('Icdcode_model');
                $this->data['all_icdcodes'] = $this->Icdcode_model->get_all_icdcodes();

                $this->load->model('Definitive_model');
                $this->data['all_definitives'] = $this->Definitive_model->get_all_definitives();
                
                $this->data['_view'] = 'order/add';
                $this->load->view('layouts/main',$this->data);
            }

        }  

        /*
         * Editing a order
         */
        private function code($id) {

            $this->data['pageTitle'] = 'Order Coding';
            $this->data['pageHeading'] = 'ORDER CODING';

            // check if the order exists before trying to edit it
            $this->data['order'] = $this->Order_model->get_order($id);
            
            if(isset($this->data['order']['id'])) {

                if(isset($_POST) && count($_POST) > 0) {

                    if((int)$this->input->post('apid') == 0) {

                        $aoid = (int)$this->input->post('aoid');
                        $patient = $this->input->post('patient');

                        $insertedPID = $this->Patient_model->add_patient($patient);

                        /*$oParams = array(
                            'patientId' => $insertedPID
                        );

                        $this->Order_model->update_order($aoid, $oParams);*/
                        $params = array(
                            'facilityId' => $this->input->post('facilityId'),
                            'processStatusId' => 2,
                            'referringPhysicianId' => $this->input->post('referringPhysicianId'),
                            'cptId' => $this->input->post('cptId'),
                            'icdId' => $this->input->post('icdId'),
                            'definitiveId' => $this->input->post('definitiveId'),
                            'scheduledTime' => $this->input->post('scheduledTime'),
                            'tech' => $this->input->post('tech'),
                            'patientId' => $insertedPID
                        );

                        $this->Order_model->update_order($id,$params);            
                        redirect('order/index');

                    } else {

                        $apid = (int)$this->input->post('apid');
                        $patient = $this->input->post('patient');

                        $this->Patient_model->update_patient($apid, $patient);

                        $params = array(
                            'facilityId' => $this->input->post('facilityId'),
                            'processStatusId' => 2,
                            'referringPhysicianId' => $this->input->post('referringPhysicianId'),
                            'cptId' => $this->input->post('cptId'),
                            'icdId' => $this->input->post('icdId'),
                            'definitiveId' => $this->input->post('definitiveId'),
                            'scheduledTime' => $this->input->post('scheduledTime'),
                            'tech' => $this->input->post('tech'),
                            'patientId' => $apid
                        );

                        $this->Order_model->update_order($id,$params);            
                        redirect('order/index');
                        
                    }

                    /*$params = array(
                        'facilityId' => $this->input->post('facilityId'),
                        'processStatusId' => 2,
                        'referringPhysicianId' => $this->input->post('referringPhysicianId'),
                        'cptId' => $this->input->post('cptId'),
                        'icdId' => $this->input->post('icdId'),
                        'definitiveId' => $this->input->post('definitiveId'),
                        'scheduledTime' => $this->input->post('scheduledTime'),
                        'tech' => $this->input->post('tech'),
                        'patientId' => $this->input->post('patientId')
                    );

                    $this->Order_model->update_order($id,$params);            
                    redirect('order/index');*/

                } else {

                    $this->load->model('Facility_model');
                    $this->data['all_facilities'] = $this->Facility_model->get_all_facilities();

                    $this->load->model('Status_model');
                    $this->data['all_statuses'] = $this->Status_model->get_all_statuses();

                    $this->load->model('Physician_model');
                    $this->data['all_physicians'] = $this->Physician_model->get_all_physicians();

                    $this->load->model('Cptcode_model');
                    $this->data['all_cptcodes'] = $this->Cptcode_model->get_all_cptcodes();

                    $this->load->model('Icdcode_model');
                    $this->data['all_icdcodes'] = $this->Icdcode_model->get_all_icdcodes();

                    $this->load->model('Definitive_model');
                    $this->data['all_definitives'] = $this->Definitive_model->get_all_definitives();

                    if($this->data['order']['patientId'] > 0) {

                        $patient = $this->Patient_model->get_patient($this->data['order']['patientId']);
                        
                    } else {

                        $patient = array(
                            'id' => 0,
                            'firstName' => '',
                            'lastName' => '',
                            'dob' => '',
                            'pId' => '',
                            'resonBehindOrder' => '',
                            'history' => '',
                            'notes' => '',
                            'exams' => ''
                        );

                    }

                    $this->data['aoid'] = $this->data['order']['id'];
                    $this->data['apid'] = $this->data['order']['patientId'];
                    $this->data['patient'] = $patient;

                    $this->data['_view'] = 'order/code';
                    $this->load->view('layouts/main',$this->data);

                }

            } else {

                show_error('The order you are trying to edit does not exist.');

            }

        }

        private function _getProcedures($patientId) {

            if($patientId == 0) {

                $procedure = array();

                for($counter = 0; $counter < 12; $counter++) {

                    $procedures[$counter] = array(
                        'id' => 0,
                        'patientId' => $patientId,
                        'cptId' => 0,
                        'anatomicalPosition' => 'NONE',
                        'icdId' => 0,
                        'definitiveId' => 0
                    );
                    
                }

                return $procedures;

            } else {

                $this->load->model('Procedure_model');
                $procedures = $this->Procedure_model->get_procedures($patientId);

                for($counter = count($procedures); $counter < 12; $counter++) {

                    $procedures[$counter] = array(
                        'id' => 0,
                        'patientId' => $patientId,
                        'cptId' => 0,
                        'anatomicalPosition' => 'NONE',
                        'icdId' => 0,
                        'definitiveId' => 0
                    );
                    
                }

                return $procedures;
            }

        }

        public function countPatients($osid) {

            return $this->Patient_model->get_patient_count($osid);
            
        }

        /*
         * Deleting order
         */
        public function remove($id) {

            $this->data['pageTitle'] = 'Remove Order';
            $this->data['pageHeading'] = 'REMOVE ORDER';

            $order = $this->Order_model->get_order($id);

            // check if the order exists before trying to delete it
            if(isset($order['id'])) {

                $this->Order_model->delete_order($id);
                redirect('order/index');

            } else {

                show_error('The order you are trying to delete does not exist.');

            }

        }

        /*private getOptimized($oscId, $optId, $oprId) {


            if($key = 'pr') {

                $opr['dateFrom'] = date(' m-d-Y', $opt['scheduledTime']);
                $opr['dateTo'] = '24';
                $opr['placeOfService'] = '24';
                $opr['charges'] = 0.00;
                $opr['reserved'] = '';

            } else if($key = 'prarr') {

                foreach ($opr as $pr) {

                    $pr['dateFrom'] = '24';
                    $pr['dateTo'] = '24';
                    $pr['placeOfService'] = '24';
                    $pr['charges'] = 0.00;
                    $pr['reserved'] = '';

                }

            } else {

                $opr[''] = '24';
                $opr[] = '24';
                $opr[] = '24';

            }

            

        }*/

    }

?>