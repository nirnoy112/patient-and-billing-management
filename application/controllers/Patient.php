<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/

include_once APPPATH.'/third_party/mpdf/mpdf.php';

class Patient extends NDP_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model('Order_model');
        $this->load->model('Patient_model');
        $this->load->model('Attachment_model');
        $this->load->model('BillingCompany_Model');
        $this->load->model('Attorney_model');

        $this->loadAppData(true);
    } 

    /*
     * Listing of all patients
     */
    function index() {

        redirect('patient/enlist');

    }


    function enlist() {

        $this->data['ctrl'] = $this;

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

        /*$query_rules = $this->data['p_query_rules'];
        $this->data['filter_data'] = $query_rules;*/

        $query_rules = $this->data['p_query_rules'];
        $this->data['filter_data'] = $query_rules;

        if((int)$this->data['roleId'] == 2) {

            $tech = $this->Tech_model->get_tech_by_title($this->data['realName']);
            $query_rules['tid'] = $tech['id'];

            $this->data['all_techs'] = array();

        }

        if(isset($_POST['filter_patients'])) {

            $p_query_rules = $this->input->post('fdata');
            $this->updateUserSession('p_query_rules', $p_query_rules);
            redirect('patient/enlist');

            /*$query_rules = $p_query_rules;
        $this->data['filter_data'] = $query_rules;*/
            //var_dump($this->data['filter_data']); die();

        }
        //$query_rules = $this->input->post('fdata');
            //var_dump($query_rules);die();



        if($query_rules['dateFrom'] != null && $query_rules['dateTo'] != null) {

            $dfs = $query_rules['dateFrom'] . ' 00:00:00';
            $dts = $query_rules['dateTo'] . ' 23:59:59';

            $df = DateTime::createFromFormat('m-d-Y H:i:s', $dfs);
            $dt = DateTime::createFromFormat('m-d-Y H:i:s', $dts);

            $query_rules['dateFrom'] = strtotime($df->format('Y-m-d H:i:s'));
            $query_rules['dateTo'] = strtotime($dt->format('Y-m-d H:i:s'));

        }

        $patients = array();

        if((int)$this->data['roleId'] == 3) {
            //var_dump('OK'); die();

            $bc = $this->BillingCompany_Model->get_BC_by_RUID((int)$this->data['id']);
            //var_dump($bc); die();

            //$patients = $this->Patient_model->get_patients_by_bc((int)$bc['id']);

            $bcid = (int)$bc['id'];

            $oids = $this->Order_model->pullOrderIDs($query_rules);

            foreach ($oids as $value) {

                $osid = (int) $value['id'];

                $pa = $this->Patient_model->get_patients($osid);

                foreach ($pa as $p) {

                    if((int)$p['BCID'] == $bcid) {

                        array_push($patients, $p);

                    }

                }

            }

        } else {

            $oids = $this->Order_model->pullOrderIDs($query_rules);

            foreach ($oids as $value) {

                $osid = (int) $value['id'];

                $pa = $this->Patient_model->get_patients($osid);

                foreach ($pa as $p) {

                    array_push($patients, $p);

                }

            }

        }

        if(isset($_POST['start_assign'])) {

            $aoid = (int)$this->input->post('oid');
            $apid = (int)$this->input->post('pid');

            $patient = $this->Patient_model->get_patient($apid);

            $this->data['aoid'] = $aoid;
            $this->data['apid'] = $apid;

            $this->data['patient'] = $patient;

            $this->data['all_bcs'] = $this->BillingCompany_Model->get_all_BCs();


            $this->data['_modal'] = 'patient/assign-modal';


        }

        if(isset($_POST['assign_patient'])) {

            $aoid = (int)$this->input->post('aoid');
            $apid = (int)$this->input->post('apid');

            $patient = $this->Patient_model->get_patient($apid);

            $patient['BCID'] = (int)$this->input->post('bcId');

            $this->Patient_model->update_patient($apid, $patient);

            redirect('patient/index');

        }

        if(isset($_POST['start_payment'])) {

            $aoid = (int)$this->input->post('oid');
            $apid = (int)$this->input->post('pid');

            $patient = $this->Patient_model->get_patient($apid);

            $this->data['aoid'] = $aoid;
            $this->data['apid'] = $apid;

            $this->data['patient'] = $patient;


            $this->data['_modal'] = 'patient/pay-modal';


        }

        if(isset($_POST['post_payment'])) {

            $aoid = (int)$this->input->post('aoid');
            $apid = (int)$this->input->post('apid');

            $patient = $this->Patient_model->get_patient($apid);

            $patient['totalDue'] = (float)$patient['totalDue'] - (float)$this->input->post('payment-amount');

            $patient['amountPaid'] = (float)$patient['amountPaid'] + (float)$this->input->post('payment-amount');

            $this->Patient_model->update_patient($apid, $patient);

            redirect('patient/index');

        }

        //var_dump($patients); die();

            //Start Printing
            if(isset($_POST['start_print'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $patient = $this->Patient_model->get_patient($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;

                $this->data['patient'] = $patient;


                $this->data['_modal'] = 'process/print';


            }

            //Start Sending
            if(isset($_POST['start_send'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $patient = $this->Patient_model->get_patient($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;

                $this->data['patient'] = $patient;


                $this->data['_modal'] = 'process/send';


            }

            //Start Direct Processing
            if(isset($_POST['start_direct'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $patient = $this->Patient_model->get_patient($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;

                $this->data['patient'] = $patient;


                $this->data['_modal'] = 'process/direct';


            }//Selected Direct Processing
            if(isset($_POST['selected_direct'])) {

                $selectedOptions = $this->input->post('opt');
                //var_dump($selectedOptions); die();

                $this->sbpLog('DIRECT PROCESS # ' . (int)$this->input->post('aoid') . '/' . (int)$this->input->post('apid'));

                if( isset($selectedOptions) && $selectedOptions != null ) {

                    $filesString = '';
                    $others = null;

                    $aoid = (int)$this->input->post('aoid');
                    $apid = (int)$this->input->post('apid');

                    $patient = $this->Patient_model->get_patient($apid);

                    $finalFileName = 'Patient_#' . $patient['PID'] . '_Overview.pdf';

                    if( isset($selectedOptions['hcfa']) && $selectedOptions['hcfa'] == 'YES' ) {

                        $file = $this->pHCFA($apid);
                        $filesString .= FCPATH . 'PnS/partials/' . $file . ' ';

                    }

                    if( isset($selectedOptions['order']) && $selectedOptions['order'] == 'YES' ) {

                        $file = $this->pOrder($apid);
                        $filesString .= $file . ' ';

                    }

                    if( isset($selectedOptions['attachments']) && $selectedOptions['attachments'] == 'YES' ) {

                        /*$rData = $this->pAttachments($apid);

                        if($rData['file'] != null && $rData['file'] != '') {

                            $filesString .= FCPATH . 'PnS/partials/' . $rData['file'] . ' ';

                        }

                        if($rData['others'] != null && $rData['others'] != '') {

                            $others = $rData['others'];

                        }*/


                        $afs = $this->pAttachments($apid);

                        if($afs != null && $afs != '') {

                            $filesString .= $afs;

                        }
                        
                        

                    }

                    if( isset($selectedOptions['w9']) && $selectedOptions['w9'] == 'YES' ) {

                        $file = FCPATH . 'PnS/core/W-9.pdf';
                        $filesString .= $file . ' ';

                    }

                    $finalPDF = $this->createTheDirectPDF($apid, $filesString);

                    redirect('patient/index');
                        
                    
                }

            }

            //Selected Print
            if(isset($_POST['selected_print'])) {

                

                /*$dirPDF = FCPATH . 'PnS/partials/';
                $PdfDir = FCPATH . 'PnS/partials';*/


                $selectedOptions = $this->input->post('opt');
                //var_dump($selectedOptions); die();

                //$this->sbpLog('PRINT # ' . (int)$this->input->post('aoid') . '/' . (int)$this->input->post('apid'));

                if( isset($selectedOptions) && $selectedOptions != null ) {

                    $filesString = '';
                    $others = '';

                    $aoid = (int)$this->input->post('aoid');
                    $apid = (int)$this->input->post('apid');

                    $patient = $this->Patient_model->get_patient($apid);

                    $finalFileName = 'Patient_#' . $patient['PID'] . '_Overview.pdf';

                    if( isset($selectedOptions['hcfa']) && $selectedOptions['hcfa'] == 'YES' ) {

                        $file = $this->pHCFA($apid);
                        $filesString .= FCPATH . 'PnS/partials/' . $file . ' ';

                    }

                    if( isset($selectedOptions['order']) && $selectedOptions['order'] == 'YES' ) {

                        $file = $this->pOrder($apid);
                        $filesString .= $file . ' ';

                    }

                    if( isset($selectedOptions['attachments']) && $selectedOptions['attachments'] == 'YES' ) {

                        $afs = $this->pAttachments($apid);

                        if($afs != null && $afs != '') {

                            $filesString .= $afs;

                        }

                        /*if($rData['file'] != null && $rData['file'] != '') {

                            $filesString .= FCPATH . 'PnS/partials/' . $rData['file'] . ' ';

                        }

                        if($rData['others'] != null && $rData['others'] != '') {

                            $others = $rData['others'];

                        }*/
                        
                        

                    }

                    if( isset($selectedOptions['w9']) && $selectedOptions['w9'] == 'YES' ) {

                        $file = FCPATH . 'PnS/core/W-9.pdf';
                        $filesString .= $file . ' ';

                    }

                    //var_dump($filesString); die();

                    $finalPDF = $this->createTheFinalPDF($apid, $filesString);

                    $downloadableFile = array(
                        'filename' => $finalFileName,
                        'mimetype' => 'application/pdf'
                    );

                    $filenameWithPath = FCPATH . 'PnS/combined/' . $finalPDF;
                    

                    header('Content-disposition: attachment; filename='. $downloadableFile['filename']);
                    header('Content-type: ' . $downloadableFile['mimetype']);
                    header('Content-Length: ' . filesize($filenameWithPath));

                    ob_clean();
                    ob_start();

                    readfile($filenameWithPath);

                    ob_flush();
                    flush();

                    exit;

                }


            }

            //Selected Send
            if(isset($_POST['selected_send'])) {

                $selectedOptions = $this->input->post('opt');
                //var_dump($selectedOptions); die();

                $this->sbpLog('SENDMAIL # ' . (int)$this->input->post('aoid') . '/' . (int)$this->input->post('apid'));

                if( isset($selectedOptions) && $selectedOptions != null ) {

                    $filesString = '';
                    $others = null;

                    $aoid = (int)$this->input->post('aoid');
                    $apid = (int)$this->input->post('apid');

                    $patient = $this->Patient_model->get_patient($apid);

                    $finalFileName = 'Patient_#' . $patient['PID'] . '_Overview.pdf';

                    if( isset($selectedOptions['hcfa']) && $selectedOptions['hcfa'] == 'YES' ) {

                        $file = $this->pHCFA($apid);
                        $filesString .= FCPATH . 'PnS/partials/' . $file . ' ';

                    }

                    if( isset($selectedOptions['order']) && $selectedOptions['order'] == 'YES' ) {

                        $file = $this->pOrder($apid);
                        $filesString .= $file . ' ';

                    }

                    if( isset($selectedOptions['attachments']) && $selectedOptions['attachments'] == 'YES' ) {

                        /*$rData = $this->pAttachments($apid);

                        if($rData['file'] != null && $rData['file'] != '') {

                            $filesString .= FCPATH . 'PnS/partials/' . $rData['file'] . ' ';

                        }

                        if($rData['others'] != null && $rData['others'] != '') {

                            $others = $rData['others'];

                        }*/


                        $afs = $this->pAttachments($apid);

                        if($afs != null && $afs != '') {

                            $filesString .= $afs;

                        }
                        
                        

                    }

                    if( isset($selectedOptions['w9']) && $selectedOptions['w9'] == 'YES' ) {

                        $file = FCPATH . 'PnS/core/W-9.pdf';
                        $filesString .= $file . ' ';

                    }

                    $finalPDF = $this->createTheFinalPDF($apid, $filesString);

                    $filenameWithPath = FCPATH . 'PnS/combined/' . $finalPDF;

                    $toEmail = $selectedOptions['emailToSend'];
                    
                    $this->sendEmail($toEmail, $filenameWithPath);
                        
                    
                }

            }

        /*if($patients) {*/
            if(isset($_POST['edit_patient'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $this->load->model('Patient_model');
                $patient = $this->Patient_model->get_patient($apid);
                $procedures = $this->_getProcedures($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;
                $this->data['patient'] = $patient;
                $this->data['procedures'] = $procedures;


                $this->data['_modal'] = 'patient/edit';


            }

            if(isset($_POST['edit_submit'])) {

                $apid = (int)$this->input->post('apid');
                $aoid = (int)$this->input->post('aoid');
                $patient = $this->input->post('patient');

                $patient['OSID'] = $aoid;

                $ids = $this->input->post('ids');
                $procedures = $this->input->post('procedures');

                $order = $this->Order_model->get_order($aoid);

                $pDate = date('m-d-Y', $order['scheduledTime']);

                $count = 0;

                foreach ($ids as $id) {

                    $procedure = $procedures[$count];

                    if($id > 0) {

                        $this->load->model('Procedure_model');
                        $this->Procedure_model->update_procedure($id, $procedure);

                    } else {

                        if($procedure['cptId'] > 0 || $procedure['anatomicalPosition'] != 'NONE' || $procedure['icdId'] > 0 || $procedure['definitiveId'] > 0) {

                            /*$pIcdcode = '';

                            if($procedure['icdId'] > 0) {

                                foreach($this->data['all_icdcodes'] as $icdcode){

                                    if($icdcode['id'] ==  $procedure['icdId']) {
                                        $pIcdcode = $icdcode['code'];
                                    }

                                }

                            }*/

                            $procedure['dateFrom'] = $pDate;
                            $procedure['dateTo'] = $pDate;
                            $procedure['placeOfService'] = '24';
                            $procedure['reserved'] = '1083887186';

                            $this->load->model('Procedure_model');
                            $this->Procedure_model->add_procedure($procedure);

                        }
                    }

                    $count++;

                }

                $this->Patient_model->update_patient($apid, $patient);

                redirect($this->data['current_url'] . '?oid=' . $orderId);
                
            }

            // CODE

            if(isset($_POST['manage_patient'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $this->load->model('Patient_model');
                $patient = $this->Patient_model->get_patient($apid);
                $procedures = $this->_getProcedures($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;
                $this->data['patient'] = $patient;
                $this->data['procedures'] = $procedures;


                $this->data['_modal'] = 'patient/code';


            }

            if(isset($_POST['update_patient'])) {

                $apid = (int)$this->input->post('apid');
                $aoid = (int)$this->input->post('aoid');
                $patient = $this->input->post('patient');

                $patient['OSID'] = $aoid;
                $patient['processStatusId'] = 2;

                $ids = $this->input->post('ids');
                $procedures = $this->input->post('procedures');

                $order = $this->Order_model->get_order($aoid);

                $pDate = date('m-d-Y', $order['scheduledTime']);

                $count = 0;

                foreach ($ids as $id) {

                    $procedure = $procedures[$count];

                    if($id > 0) {

                        $this->load->model('Procedure_model');
                        $this->Procedure_model->update_procedure($id, $procedure);

                    } else {

                        if($procedure['cptId'] > 0 || $procedure['anatomicalPosition'] != 'NONE' || $procedure['icdId'] > 0 || $procedure['definitiveId'] > 0) {

                            /*$pIcdcode = '';

                            if($procedure['icdId'] > 0) {

                                foreach($this->data['all_icdcodes'] as $icdcode){

                                    if($icdcode['id'] ==  $procedure['icdId']) {
                                        $pIcdcode = $icdcode['code'];
                                    }

                                }

                            }*/

                            $procedure['dateFrom'] = $pDate;
                            $procedure['dateTo'] = $pDate;
                            $procedure['placeOfService'] = '24';
                            $procedure['reserved'] = '1083887186';

                            $this->load->model('Procedure_model');
                            $this->Procedure_model->add_procedure($procedure);

                        }
                    }

                    $count++;

                }

                $this->Patient_model->update_patient($apid, $patient);

                redirect($this->data['current_url']);

                
            }

            if(isset($_POST['manage_attachments'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $this->load->model('Attachment_model');
                $attachments = $this->Attachment_model->get_attachments($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;
                $this->data['attachments'] = $attachments;


                $this->data['_modal'] = 'attachment/attachments-modal';

            }

            if(isset($_POST['upload_attachment']) && $_FILES['fileToUpload']['name']) {

                $file = $_FILES['fileToUpload'];
                //var_dump($file);

                $filename_array = explode('.',$file['name']);
                $size = count($filename_array);
                $extension = $filename_array[$size - 1];
                $newFileName = $filename_array[$size - 2] . '_' . time() . '.' . $extension;

                //var_dump($newFileName);

                move_uploaded_file($file['tmp_name'], APPPATH . 'uploads/' . $newFileName);

                $aoid = (int)$this->input->post('aoid');
                $apid = (int)$this->input->post('apid');

                $aParams = array(

                    'patientId' => $apid,
                    'mimetype' => $file['type'],
                    'filename' => $newFileName

                );

                $this->load->model('Attachment_model');
                $this->Attachment_model->add_attachment($aParams);
                $attachments = $this->Attachment_model->get_attachments($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;
                $this->data['attachments'] = $attachments;


                $this->data['_modal'] = 'attachment/attachments-modal';
                    
                
            }

            if(isset($_POST['download_file'])) {
                $atchId = $this->input->post('atchId');
                $this->_download($atchId);
            }


            $config = array();
            $config["base_url"] = base_url() . 'patient/enlist';
            $config["per_page"] = 10;
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
            $config["total_rows"] = sizeof($patients);

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $links = $this->pagination->create_links();

            $active_patients = array();

            for($i = 0; $i < $config["per_page"]; $i++) {

                $index = $page + $i;

                if($index < $config["total_rows"]) {

                    array_push($active_patients, $patients[$index]);

                }

            }

            $this->data['ctrl'] = $this;

            $this->data['filter_data'] = ($this->input->post('fdata') == null) ? $this->data['p_query_rules'] : $this->input->post('fdata');
            $this->data['pageTitle'] = 'Patients';
            $this->data['pageHeading'] = 'ENLISTED PATIENTS';
            $this->data['patients'] = $active_patients;
            $this->data['links'] = $links;

            $this->data['submit_route'] = '';

            $this->data['_view'] = 'patient/index';
            $this->load->view('layouts/main',$this->data);

        

    }

    /*
     * Listing of scheduled patients(for particular schedule ID)
     */
    function scheduled()
    {

        $this->data['ctrl'] = $this;

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

        $orderId = (int) $this->input->get('oid');
        //var_dump($orderId); die();

        

        $patients = $this->Patient_model->get_patients($orderId);


        if(isset($_POST['start_assign'])) {

            $aoid = (int)$this->input->post('oid');
            $apid = (int)$this->input->post('pid');

            $patient = $this->Patient_model->get_patient($apid);

            $this->data['aoid'] = $aoid;
            $this->data['apid'] = $apid;

            $this->data['patient'] = $patient;

            $this->data['all_bcs'] = $this->BillingCompany_Model->get_all_BCs();


            $this->data['_modal'] = 'patient/assign-modal';


        }

        if(isset($_POST['assign_patient'])) {

            $aoid = (int)$this->input->post('aoid');
            $apid = (int)$this->input->post('apid');

            $patient = $this->Patient_model->get_patient($apid);

            $patient['BCID'] = (int)$this->input->post('bcId');

            $this->Patient_model->update_patient($apid, $patient);

            redirect('patient/scheduled?oid=' . $aoid);

        }

        if(isset($_POST['start_payment'])) {

            $aoid = (int)$this->input->post('oid');
            $apid = (int)$this->input->post('pid');

            $patient = $this->Patient_model->get_patient($apid);

            $this->data['aoid'] = $aoid;
            $this->data['apid'] = $apid;

            $this->data['patient'] = $patient;


            $this->data['_modal'] = 'patient/pay-modal';


        }

        if(isset($_POST['post_payment'])) {

            $aoid = (int)$this->input->post('aoid');
            $apid = (int)$this->input->post('apid');

            $patient = $this->Patient_model->get_patient($apid);

            $patient['totalDue'] = (float)$patient['totalDue'] - (float)$this->input->post('payment-amount');

            $patient['amountPaid'] = (float)$patient['amountPaid'] + (float)$this->input->post('payment-amount');

            $this->Patient_model->update_patient($apid, $patient);

            redirect('patient/scheduled?oid=' . $aoid);

        }

        //var_dump($patients);

            //Start Printing
            if(isset($_POST['start_print'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $patient = $this->Patient_model->get_patient($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;

                $this->data['patient'] = $patient;

                //var_dump($patient); die();


                $this->data['_modal'] = 'process/print';


            }

            //Start Sending
            if(isset($_POST['start_send'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $patient = $this->Patient_model->get_patient($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;

                $this->data['patient'] = $patient;


                $this->data['_modal'] = 'process/send';


            }

            //Start Direct Processing
            if(isset($_POST['start_direct'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $patient = $this->Patient_model->get_patient($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;

                $this->data['patient'] = $patient;


                $this->data['_modal'] = 'process/direct';


            }//Selected Direct Processing
            if(isset($_POST['selected_direct'])) {

                $selectedOptions = $this->input->post('opt');
                //var_dump($selectedOptions); die();

                $this->sbpLog('DIRECT PROCESS # ' . (int)$this->input->post('aoid') . '/' . (int)$this->input->post('apid'));

                if( isset($selectedOptions) && $selectedOptions != null ) {

                    $filesString = '';
                    $others = null;

                    $aoid = (int)$this->input->post('aoid');
                    $apid = (int)$this->input->post('apid');

                    $patient = $this->Patient_model->get_patient($apid);

                    $finalFileName = 'Patient_#' . $patient['PID'] . '_Overview.pdf';

                    if( isset($selectedOptions['hcfa']) && $selectedOptions['hcfa'] == 'YES' ) {

                        $file = $this->pHCFA($apid);
                        $filesString .= FCPATH . 'PnS/partials/' . $file . ' ';

                    }

                    if( isset($selectedOptions['order']) && $selectedOptions['order'] == 'YES' ) {

                        $file = $this->pOrder($apid);
                        $filesString .= $file . ' ';

                    }

                    if( isset($selectedOptions['attachments']) && $selectedOptions['attachments'] == 'YES' ) {

                        /*$rData = $this->pAttachments($apid);

                        if($rData['file'] != null && $rData['file'] != '') {

                            $filesString .= FCPATH . 'PnS/partials/' . $rData['file'] . ' ';

                        }

                        if($rData['others'] != null && $rData['others'] != '') {

                            $others = $rData['others'];

                        }*/


                        $afs = $this->pAttachments($apid);

                        if($afs != null && $afs != '') {

                            $filesString .= $afs;

                        }
                        
                        

                    }

                    if( isset($selectedOptions['w9']) && $selectedOptions['w9'] == 'YES' ) {

                        $file = FCPATH . 'PnS/core/W-9.pdf';
                        $filesString .= $file . ' ';

                    }

                    $finalPDF = $this->createTheDirectPDF($apid, $filesString);

                    redirect('patient/scheduled?oid=' . $aoid);
                        
                    
                }

            }

            //Selected Print
            if(isset($_POST['selected_print'])) {

                

                /*$dirPDF = FCPATH . 'PnS/partials/';
                $PdfDir = FCPATH . 'PnS/partials';*/


                $selectedOptions = $this->input->post('opt');
                //var_dump($selectedOptions); die();



                //$this->sbpLog('PRINT # ' . (int)$this->input->post('aoid') . '/' . (int)$this->input->post('apid'));

                if( isset($selectedOptions) && $selectedOptions != null ) {

                    $filesString = '';
                    $others = null;

                    $aoid = (int)$this->input->post('aoid');
                    $apid = (int)$this->input->post('apid');

                    $patient = $this->Patient_model->get_patient($apid);

                    $finalFileName = 'Patient_#' . $patient['PID'] . '_Overview.pdf';

                    if( isset($selectedOptions['hcfa']) && $selectedOptions['hcfa'] == 'YES' ) {

                        $file = $this->pHCFA($apid);
                        $filesString .= FCPATH . 'PnS/partials/' . $file . ' ';

                    }

                    if( isset($selectedOptions['order']) && $selectedOptions['order'] == 'YES' ) {

                        $file = $this->pOrder($apid);
                        $filesString .= $file . ' ';

                    }

                    if( isset($selectedOptions['attachments']) && $selectedOptions['attachments'] == 'YES' ) {

                        $afs = $this->pAttachments($apid);

                        if($afs != null && $afs != '') {

                            $filesString .= $afs;

                        }

                        /*$rData = $this->pAttachments($apid);

                        if($rData['file'] != null && $rData['file'] != '') {

                            $filesString .= FCPATH . 'PnS/partials/' . $rData['file'] . ' ';

                        }

                        if($rData['others'] != null && $rData['others'] != '') {

                            $others = $rData['others'];

                        }*/
                        
                        

                    }

                    if( isset($selectedOptions['w9']) && $selectedOptions['w9'] == 'YES' ) {

                        $file = FCPATH . 'PnS/core/W-9.pdf';
                        $filesString .= $file . ' ';

                    }

                    $finalPDF = $this->createTheFinalPDF($apid, $filesString);

                    $downloadableFile = array(
                        'filename' => $finalFileName,
                        'mimetype' => 'application/pdf'
                    );

                    $filenameWithPath = FCPATH . 'PnS/combined/' . $finalPDF;
                    

                    header('Content-disposition: attachment; filename='. $downloadableFile['filename']);
                    header('Content-type: ' . $downloadableFile['mimetype']);
                    header('Content-Length: ' . filesize($filenameWithPath));

                    ob_clean();
                    ob_start();

                    readfile($filenameWithPath);

                    ob_flush();
                    flush();

                    exit;

                }


            }

            //Selected Send
            if(isset($_POST['selected_send'])) {

                $selectedOptions = $this->input->post('opt');
                //var_dump($selectedOptions); die();

                $this->sbpLog('SENDMAIL # ' . (int)$this->input->post('aoid') . '/' . (int)$this->input->post('apid'));

                if( isset($selectedOptions) && $selectedOptions != null ) {

                    $filesString = '';
                    $others = null;

                    $aoid = (int)$this->input->post('aoid');
                    $apid = (int)$this->input->post('apid');

                    $patient = $this->Patient_model->get_patient($apid);

                    $finalFileName = 'Patient_#' . $patient['PID'] . '_Overview.pdf';

                    if( isset($selectedOptions['hcfa']) && $selectedOptions['hcfa'] == 'YES' ) {

                        $file = $this->pHCFA($apid);
                        $filesString .= FCPATH . 'PnS/partials/' . $file . ' ';

                    }

                    if( isset($selectedOptions['order']) && $selectedOptions['order'] == 'YES' ) {

                        $file = $this->pOrder($apid);
                        $filesString .= $file . ' ';

                    }

                    if( isset($selectedOptions['attachments']) && $selectedOptions['attachments'] == 'YES' ) {

                        $afs = $this->pAttachments($apid);

                        if($afs != null && $afs != '') {

                            $filesString .= $afs;

                        }

                        /*$rData = $this->pAttachments($apid);

                        if($rData['file'] != null && $rData['file'] != '') {

                            $filesString .= FCPATH . 'PnS/partials/' . $rData['file'] . ' ';

                        }

                        if($rData['others'] != null && $rData['others'] != '') {

                            $others = $rData['others'];

                        }*/
                        
                        

                    }

                    if( isset($selectedOptions['w9']) && $selectedOptions['w9'] == 'YES' ) {

                        $file = FCPATH . 'PnS/core/W-9.pdf';
                        $filesString .= $file . ' ';

                    }

                    $finalPDF = $this->createTheFinalPDF($apid, $filesString);

                    $filenameWithPath = FCPATH . 'PnS/combined/' . $finalPDF;

                    $toEmail = $selectedOptions['emailToSend'];
                    
                    $this->sendEmail($toEmail, $filenameWithPath);
                        
                    
                }

            }

        /*if($patients) {*/
            if(isset($_POST['edit_patient'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $this->load->model('Patient_model');
                $patient = $this->Patient_model->get_patient($apid);
                $procedures = $this->_getProcedures($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;
                $this->data['patient'] = $patient;
                $this->data['procedures'] = $procedures;


                $this->data['_modal'] = 'patient/edit';


            }

            if(isset($_POST['edit_submit'])) {

                $apid = (int)$this->input->post('apid');
                $aoid = (int)$this->input->post('aoid');
                $patient = $this->input->post('patient');

                $patient['OSID'] = $aoid;

                $ids = $this->input->post('ids');
                $procedures = $this->input->post('procedures');

                $order = $this->Order_model->get_order($aoid);

                $pDate = date('m-d-Y', $order['scheduledTime']);

                $count = 0;

                foreach ($ids as $id) {

                    $procedure = $procedures[$count];

                    if($id > 0) {

                        $this->load->model('Procedure_model');
                        $this->Procedure_model->update_procedure($id, $procedure);

                    } else {

                        if($procedure['cptId'] > 0 || $procedure['anatomicalPosition'] != 'NONE' || $procedure['icdId'] > 0 || $procedure['definitiveId'] > 0) {

                            /*$pIcdcode = '';

                            if($procedure['icdId'] > 0) {

                                foreach($this->data['all_icdcodes'] as $icdcode){

                                    if($icdcode['id'] ==  $procedure['icdId']) {
                                        $pIcdcode = $icdcode['code'];
                                    }

                                }

                            }*/

                            $procedure['dateFrom'] = $pDate;
                            $procedure['dateTo'] = $pDate;
                            $procedure['placeOfService'] = '24';
                            $procedure['reserved'] = '1083887186';

                            $this->load->model('Procedure_model');
                            $this->Procedure_model->add_procedure($procedure);

                        }
                    }

                    $count++;

                }

                $this->Patient_model->update_patient($apid, $patient);

                redirect($this->data['current_url'] . '?oid=' . $orderId);
                
            }

            // CODE

            if(isset($_POST['manage_patient'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $this->load->model('Patient_model');
                $patient = $this->Patient_model->get_patient($apid);
                $procedures = $this->_getProcedures($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;
                $this->data['patient'] = $patient;
                $this->data['procedures'] = $procedures;


                $this->data['_modal'] = 'patient/code';


            }

            if(isset($_POST['update_patient'])) {

                $apid = (int)$this->input->post('apid');
                $aoid = (int)$this->input->post('aoid');
                $patient = $this->input->post('patient');

                $patient['OSID'] = $aoid;
                $patient['processStatusId'] = 2;

                $ids = $this->input->post('ids');
                $procedures = $this->input->post('procedures');

                $order = $this->Order_model->get_order($aoid);

                $pDate = date('m-d-Y', $order['scheduledTime']);

                $count = 0;

                foreach ($ids as $id) {

                    $procedure = $procedures[$count];

                    if($id > 0) {

                        $this->load->model('Procedure_model');
                        $this->Procedure_model->update_procedure($id, $procedure);

                    } else {

                        if($procedure['cptId'] > 0 || $procedure['anatomicalPosition'] != 'NONE' || $procedure['icdId'] > 0 || $procedure['definitiveId'] > 0) {

                            /*$pIcdcode = '';

                            if($procedure['icdId'] > 0) {

                                foreach($this->data['all_icdcodes'] as $icdcode){

                                    if($icdcode['id'] ==  $procedure['icdId']) {
                                        $pIcdcode = $icdcode['code'];
                                    }

                                }

                            }*/

                            $procedure['dateFrom'] = $pDate;
                            $procedure['dateTo'] = $pDate;
                            $procedure['placeOfService'] = '24';
                            $procedure['reserved'] = '1083887186';

                            $this->load->model('Procedure_model');
                            $this->Procedure_model->add_procedure($procedure);

                        }
                    }

                    $count++;

                }

                $this->Patient_model->update_patient($apid, $patient);

                redirect($this->data['current_url'] . '?oid=' . $orderId);
                
            }

            if(isset($_POST['manage_attachments'])) {

                $aoid = (int)$this->input->post('oid');
                $apid = (int)$this->input->post('pid');

                $this->load->model('Attachment_model');
                $attachments = $this->Attachment_model->get_attachments($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;
                $this->data['attachments'] = $attachments;


                $this->data['_modal'] = 'attachment/attachments-modal';

            }

            if(isset($_POST['upload_attachment']) && $_FILES['fileToUpload']['name']) {

                $file = $_FILES['fileToUpload'];
                //var_dump($file);

                $filename_array = explode('.',$file['name']);
                $size = count($filename_array);
                $extension = $filename_array[$size - 1];
                $newFileName = $filename_array[$size - 2] . '_' . time() . '.' . $extension;

                //var_dump($newFileName);

                move_uploaded_file($file['tmp_name'], APPPATH . 'uploads/' . $newFileName);

                $aoid = (int)$this->input->post('aoid');
                $apid = (int)$this->input->post('apid');

                $aParams = array(

                    'patientId' => $apid,
                    'mimetype' => $file['type'],
                    'filename' => $newFileName

                );

                $this->load->model('Attachment_model');
                $this->Attachment_model->add_attachment($aParams);
                $attachments = $this->Attachment_model->get_attachments($apid);

                $this->data['aoid'] = $aoid;
                $this->data['apid'] = $apid;
                $this->data['attachments'] = $attachments;


                $this->data['_modal'] = 'attachment/attachments-modal';
                    
                
            }

            if(isset($_POST['download_file'])) {
                $atchId = $this->input->post('atchId');
                $this->_download($atchId);
            }

            $this->data['ctrl'] = $this;

            $this->data['oid'] = $orderId;
            $this->data['pageTitle'] = 'Patients';
            $this->data['pageHeading'] = 'SCHEDULED PATIENTS';
            $this->data['patients'] = $patients;

            $this->data['submit_route'] = 'patient/scheduled?oid=' . $orderId;

            $this->data['_view'] = 'patient/scheduled';
            $this->load->view('layouts/main',$this->data);

        /*} else {

            $this->data['pageTitle'] = 'Patients';
            $this->data['pageHeading'] = 'SCHEDULED PATIENTS';
            $this->data['patients'] = array();

            $this->data['_view'] = 'patient/scheduled';
            $this->load->view('layouts/main',$this->data);

        }*/

    }

    public function getBC($bcid) {

        return $this->BillingCompany_Model->get_BC($bcid);
        
    }

    public function countAttachments($pid) {

        return $this->Attachment_model->get_attachment_count($pid);
            
    }

    /*
     * Adding a new patient
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'processStatusId' => $this->input->post('processStatusId'),
				'OSID' => $this->input->post('OSID'),
				'firstName' => $this->input->post('firstName'),
				'lastName' => $this->input->post('lastName'),
				'dob' => $this->input->post('dob'),
				'PID' => $this->input->post('PID'),
				'resonBehindOrder' => $this->input->post('resonBehindOrder'),
				'history' => $this->input->post('history'),
				'notes' => $this->input->post('notes'),
            );
            
            $patient_id = $this->Patient_model->add_patient($params);
            redirect('patient/index');
        }
        else
        {
			$this->load->model('Status_model');
			$this->data['all_statuses'] = $this->Status_model->get_all_statuses();
            
            $this->data['_view'] = 'patient/add';
            $this->load->view('layouts/main',$this->data);
        }
    }

    public function sbln() {

        $response = array();

        try {

            $ln = $this->input->get('ln');

            $patients = $this->Patient_model->pickPatientByLN($ln);

            //if($patient == null) {

                $response['status'] = 200;
                $response['resultCount'] = ($patients != null) ? count($patients) : 0;
                $response['patients'] = $patients;

                $responseJSON = json_encode($response);

                echo $responseJSON;

                //var_dump($responseJSON);die();

            //}

        } catch(Exception $ex) {

            $response['status'] = 500;
            $response['message'] = $ex->getMessage();

            $responseJSON = json_encode($response);

                echo $responseJSON;

            //var_dump($responseJSON);die();

        }


        //var_dump($patient);die();

    }

    public function port() {

        $response = array();

        try {

            $pid = $this->input->get('pid');

            $patient = $this->Patient_model->pickPatient($pid);

            //if($patient == null) {

                $response['status'] = 200;
                $response['resultCount'] = ($patient != null) ? 1 : 0;
                $response['patient'] = $patient;

                $responseJSON = json_encode($response);

                echo $responseJSON;

                //var_dump($responseJSON);die();

            //}

        } catch(Exception $ex) {

            $response['status'] = 500;
            $response['message'] = $ex->getMessage();

            $responseJSON = json_encode($response);

                echo $responseJSON;

            //var_dump($responseJSON);die();

        }


        //var_dump($patient);die();

    }


    /*
     * Editing a patient
     */
    function edit($id)
    {   
        // check if the patient exists before trying to edit it
        $data['patient'] = $this->Patient_model->get_patient($id);
        
        if(isset($data['patient']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'processStatusId' => $this->input->post('processStatusId'),
					'OSID' => $this->input->post('OSID'),
					'firstName' => $this->input->post('firstName'),
					'lastName' => $this->input->post('lastName'),
					'dob' => $this->input->post('dob'),
					'PID' => $this->input->post('PID'),
					'resonBehindOrder' => $this->input->post('resonBehindOrder'),
					'history' => $this->input->post('history'),
					'notes' => $this->input->post('notes'),
                );

                $this->Patient_model->update_patient($id,$params);            
                redirect('patient/index');
            }
            else
            {
				$this->load->model('Status_model');
				$data['all_statuses'] = $this->Status_model->get_all_statuses();

                $data['_view'] = 'patient/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The patient you are trying to edit does not exist.');

    }

    /*
     * HCFA Printing
     */
    private function pHCFA($apid) {


        $patient = $this->Patient_model->get_patient($apid);

        $procedures = $this->_getProcedures($apid);

        $this->load->model('Procedure_model');
        $activeProcedures = $this->Procedure_model->get_procedures($apid);

        $osid = $patient['OSID'];

        $order = $this->Order_model->get_order($osid);
        $facilityId = $order['facilityId'];
        $rpId = $order['referringPhysicianId'];
        $sd = date('m-d-Y', $order['scheduledTime']);
        $this->load->model('Facility_model');
        $facility = $this->Facility_model->get_facility($facilityId);
        $this->load->model('Physician_model');
        $rp = $this->Physician_model->get_physician($rpId);

        $data = $patient;

        $data['facility'] = $facility;
        $data['sd'] = $sd;
        $data['physician'] = $rp['name'];

        $total_charge = 0.00;

        foreach ($procedures as $key => $value) {

            $serialNumber = $key + 1;
            
            $data['procedure' . $serialNumber] = $value;

            $total_charge += $value['charges'];

        }

        $data['total_charge'] = $total_charge;

        if(count($activeProcedures) > 6) {

            /*for($i = 0; $i < 6; $i++) {

                $serialNumber = $i + 1;
                
                $data['procedure' . $serialNumber] = $procedures[$i];

            }*/

            $info = $this->convertDataToInfo($data, 1, true);

            $pdfFile = $this->createPDFforHCFA($data['PID'], $info, 1, true);

            /*for($i = 0; $i < 6; $i++) {

                $serialNumber = $i + 1;
                
                $data['procedure' . $serialNumber] = $procedures[6 + $i];

            }*/

            $info = $this->convertDataToInfo($data, 2, false);

            $pdfFile = $pdfFile . ' ' . FCPATH . 'PnS/partials/' . $this->createPDFforHCFA($data['PID'], $info, 2, false);

            return $pdfFile;

        } else {

            /*foreach ($procedures as $key => $value) {

                $serialNumber = $key + 1;
                
                $data['procedure' . $serialNumber] = $value;

            }*/

            $info = $this->convertDataToInfo($data, 1, false);
            //var_dump($data['PID']); die();
            //var_dump($info); die();

            $pdfFile = $this->createPDFforHCFA($data['PID'], $info, 1, false);

            return $pdfFile;

        }
        
    }

    /*
     * Order Printing
     */
    private function printOrder($pid) {


        $patient = $this->Patient_model->get_patient($pid);

        $this->data['patient'] = (object)$patient;

        $content = $this->load->view('printablePDFs/order', $this->data, true);

        $pdfFile = 'Order_' . $patient['PID'] . '.pdf';

        $this->load->library('npdf');

        $mPDF = $this->npdf->pdf;

        //$mPDF->SetDisplayMode('fullpage');

        /*$stylesheet = file_get_contents(base_url() . '/assets/css/mpdfstyletables.css');
        $mPDF->WriteHTML($stylesheet, 1);*/

        $mPDF->WriteHTML($content);

        $mPDF->Output($pdfFile, 'D');
        
    }

    /*
     * Creating HCFA PDF
     */
    private function createPDFforHCFA($pid, $info, $pageCount, $hasNextPage) {

        $PDF_masterFile = FCPATH . 'PnS/core/pdfMaster.pdf';
        $dirFDF = FCPATH . 'PnS/FDFs';
        $dirPDF = FCPATH . 'PnS/partials';
        $dirSignature = FCPATH . 'PnS/Signatures';
        $dirTmp = FCPATH . 'PnS/tmp';


        $fdf_data = $this->createFDF($PDF_masterFile, $info);
        $fdf_file = 'FDF_' . $pid . '.fdf';

        
        if($fp=fopen($dirFDF.'/'.$fdf_file,'w')){
            fwrite($fp,$fdf_data,strlen($fdf_data));
        }else{
            die('Unable to create file: '.$dirFDF.'/'.$fdf_file);
        }
        fclose($fp);
        
        $pdffile = 'H_' . $pid . '.pdf';

        if($hasNextPage == true) {

            $pdffile = 'H_' . $pid . '_1.pdf';

        }

        if($pageCount == 2) {

            $pdffile = 'H_' . $pid . '_2.pdf';

        }
        $command = "pdftk $PDF_masterFile fill_form $dirFDF/$fdf_file output tmp/$pdffile flatten";
        exec ($command,$result);
        
#       echo "<br>$command</br>".var_dump($result)."<br>";
        
        if($result[0] == ''){
            

            /*$signature  = "$dirSignature/".$userinfo['fldsigjpg'];
        
            if( preg_match("/\.pdf$/",$signature) ){
                $command = "pdftk tmp/$pdffile stamp $signature output $dirPDF/$pdffile";
            }
            else{*/
                $command = "pdftk $PDF_masterFile fill_form $dirFDF/$fdf_file output $dirPDF/$pdffile flatten";

            //}
            
            exec ($command,$result);
            //unlink ("tmp/$pdffile");
           
            if($result[0] == ''){

                return $pdffile;

                //$SQL = "Update $table1 SET hcfastatus='Processed', hcfafilename='$pdffile' WHERE `fldID`='$id'";
                //$rv2 = mysql_query($SQL) or die (mysql_error());
                /*echo "Successfully Generated PDF and is ready to print. <a href='$dirPDF/$pdffile' target='_new'>Print HCFA</a>";*/
                
             }
         
            //exit(0);
         
        }
        else{
            echo "Error in generating PDF";
        }

    }

    private function createFDF($file, $info) {

        $data="%FDF-1.2\n%����\n1 0 obj\n<< \n/FDF << /Fields [ ";

        foreach($info as $field => $val){

            if(is_array($val)){

                $data.='<</T('.$field.')/V[';
                foreach($val as $opt)
                $data.='('.trim($opt).')';
                $data.=']>>';

            } else {

                $data.='<</T('.$field.')/V('.trim($val).')>>';

            }

        }

        $data.="] \n/F (".$file.") /ID [ <".md5(time()).">\n] >>".
        " \n>> \nendobj\ntrailer\n".
        "<<\n/Root 1 0 R \n\n>>\n%%EOF\n";

        return $data;

    }


    /*
     * HCFA patient
     */
    public function hcfa($pid, $oid)
    {

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

        $this->data['all_attorneys'] = $this->Attorney_model->get_all_attorneys();

        if(isset($_POST['save_hcfa'])) {

            $patient = $this->input->post('patient');
            //var_dump($patient); die();

                $patient['OSID'] = $oid;
                $patientName = $this->input->post('patientName');
                $names = explode(' ', $patientName, 3);

                $patient['lastName'] = $names[0];
                $patient['firstName'] = $names[1];
                $patient['middleName'] = $names[2];

                if($patient['financialClass'] == 'PIWC') {

                    $patient['streetNoI']                = $patient['streetNoP'];
                    $patient['cityI']                   = $patient['cityP']; 
                    $patient['stateI']                  = $patient['stateP'];    
                    $patient['zipCodeI']               = $patient['zipCodeP'];
                    $patient['telephoneI']               = $patient['telephoneP'];

                }

                //var_dump($patient); die();

                $ids = $this->input->post('ids');
                $procedures = $this->input->post('procedures');


                $order = $this->Order_model->get_order((int)$oid);

                $pDate = date('m-d-Y', $order['scheduledTime']);

                $count = 0;

                $total_charge = 00.00;

                foreach ($ids as $id) {

                    $procedure = $procedures[$count];

                    if($procedure['charges'] != '' && $procedure['charges'] != null) {

                        $total_charge = $total_charge + $procedure['charges'];

                    }

                    $total_charge;

                    if($id > 0) {

                        $this->load->model('Procedure_model');
                        $procedureParams = $this->getAbsoluteArray($procedure);
                        $this->Procedure_model->update_procedure($id, $procedureParams);

                    } else {

                        if($procedure['cptId'] > 0) {

                            /*$pIcdcode = '';

                            if($procedure['icdId'] > 0) {

                                foreach($this->data['all_icdcodes'] as $icdcode){

                                    if($icdcode['id'] ==  $procedure['icdId']) {
                                        $pIcdcode = $icdcode['code'];
                                    }

                                }

                            }*/

                            $procedure['dateFrom'] = $pDate;
                            $procedure['dateTo'] = $pDate;
                            $procedure['placeOfService'] = '24';
                            $procedure['reserved'] = '1083887186';

                            $procedureParams = $this->getAbsoluteArray($procedure);
                            $this->Procedure_model->add_procedure($procedureParams);

                        }
                    }

                    $count++;

                }

                $pParams = $this->getAbsoluteArray($patient);

                $pParams['totalCharges'] = $total_charge;

                if($patient['amountPaid'] != null && $patient['amountPaid'] != '') {

                    $pParams['totalDue'] = $total_charge - $patient['amountPaid'];

                } else {

                    $pParams['amountPaid'] = 0.00;
                    $pParams['totalDue'] = $total_charge;

                }

                $this->Patient_model->update_patient($pid, $pParams);
            
            redirect('patient/scheduled' . '?oid=' . $oid);

        }
        if(isset($_POST['cancel'])) {
            
            redirect('patient/scheduled' . '?oid=' . $oid);

        }

        $patient = $this->Patient_model->get_patient($pid);

        $procedures = $this->_getProcedures($pid);

        $this->data['patient'] = (object)$patient;
        $this->data['procedures'] = $procedures;

        $this->data['pageTitle'] = 'HCFA';
        $this->data['pageHeading'] = 'HEALTH INSURANCE CLAIM FORM'; 
        $this->data['_view'] = 'patient/hcfa';
        $this->load->view('layouts/main', $this->data);

        //var_dump($patient);

        /*// check if the patient exists before trying to run in HCFA
        if(isset($patient['id']))
        {
            $this->Patient_model->delete_patient($pid);
            redirect('patient' . '?oid=' . $oid);
        }*/
        /*else
            show_error('The patient you are trying to take through HCFA does not exist.');*/
    }

    /*
     * Deleting patient
     */
    public function remove($pid, $oid)
    {
        $patient = $this->Patient_model->get_patient($pid);

        // check if the patient exists before trying to delete it
        if(isset($patient['id']))
        {
            $this->Patient_model->delete_patient($pid);
            
            if($oid == 0) {

                redirect('patient/enlist');

            } else {

                redirect('patient/scheduled' . '?oid=' . $oid);

            }
        }
        else
            show_error('The patient you are trying to delete does not exist.');
    }

    private function _download($attachmentId) {

        $file = $this->Attachment_model->get_attachment($attachmentId);
        $filenameWithPath = APPPATH . 'uploads/' . $file['filename'];

        header('Content-disposition: attachment; filename='. $file['filename']);
        header('Content-type: ' . $file['mimetype']);
        header('Content-Length: ' . filesize($filenameWithPath));

        readfile($filenameWithPath);

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
                    'definitiveId' => 0,
                    'dateFrom' => '',
                    'dateTo' => '',
                    'placeOfService' => '',
                    'modifier' => '',
                    'diagnosisPointer' => '',
                    'typeOfService' => '',
                    'charges' => '',
                    'daysOrUnits' => '',
                    'epsdt' => '',
                    'emg' => '',
                    'cob' => '',
                    'reserved' => ''
                );
                
            }

            return $procedure;

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
                    'definitiveId' => 0,
                    'dateFrom' => '',
                    'dateTo' => '',
                    'placeOfService' => '',
                    'modifier' => '',
                    'diagnosisPointer' => '',
                    'typeOfService' => '',
                    'charges' => '',
                    'daysOrUnits' => '',
                    'epsdt' => '',
                    'emg' => '',
                    'cob' => '',
                    'reserved' => ''
                );
                
            }

            return $procedures;
        }

    }

    private function convertDataToInfo($data, $pageCount, $hasNextPage) {


        $this->load->model('Cptcode_model');
        $all_cptcodes = $this->Cptcode_model->get_all_cptcodes();

        $this->load->model('Icdcode_model');
        $all_icdcodes = $this->Icdcode_model->get_all_icdcodes();

        $this->load->model('Definitive_model');
        $all_definitives = $this->Definitive_model->get_all_definitives();


        $info = array();

        if($data['payerAID'] > 0) {

            $active_payer = $this->Attorney_model->get_attorney($data['payerAID']);

            /*$info['insurance_name'] = strtoupper($active_payer['name']);
            $info['insurance_address'] = strtoupper($active_payer['address']);
            $info['insurance_address2'] = $active_payer['email'] . '  ' . $active_payer['phone'];
            $info['insurance_city_state_zip'] = strtoupper($active_payer['city'] . ', ' . $active_payer['state'] . ' ' . $active_payer['zip']);*/

            $info['insurance_name'] = strtoupper($active_payer['name']);
            $info['insurance_address'] = strtoupper($active_payer['address']);
            $info['insurance_address2'] = strtoupper($active_payer['city'] . ', ' . $active_payer['state'] . ' ' . $active_payer['zip']);


        }
#1      
        switch ($data['hcfainstype']){
            case 'MEDICARE'     : $info['insurance_type'] = 'Medicare';      break;
            case 'MEDICAID'     : $info['insurance_type'] = 'Medicaid';        break;
            case 'TRICARE'      : $info['insurance_type'] = 'Tricare';         break;
            case 'GROUP HEALTH' : $info['insurance_type'] = 'Group';  break;
            case 'FECA'         : $info['insurance_type'] = 'Feca';          break;
            case 'OTHER'           : $info['insurance_type'] = 'Other';            break;
            case 'CHAMPVA'      : $info['insurance_type'] = 'Champva';         break;
        }
        
#1a
        $info['insurance_id'] = $data['insuredId'];         
        
#2
        $info['pt_name'] = $data['lastName']." ".$data['firstName']." ".$data['middleName'];
#3
        //list ( $info['Patient_Birthdate_YYYY'],$info['Patient_Birthdate_MM'],$info['Patient_Birthdate_DD']) = split ("-", $data['dob']);
        $dobArray = explode('-', $data['dob']);
        $info['birth_mm'] = $dobArray[0];
        $info['birth_dd'] = $dobArray[1];
        $info['birth_yy'] = $dobArray[2];
        switch ($data['patientSex']){
            case 'Male'  : $info['sex'] = 'M'; break;
            case 'Female': $info['sex'] = 'F'; break;
        }

#4
        $info['ins_name'] = $data['insuredName'];

#5
        $info['pt_street']                = $data['streetNoP'];    
        $info['pt_city']                   = $data['cityP']; 
        $info['pt_state']                  = $data['stateP'];    
        $info['pt_zip']               = $data['zipCodeP'];


        
        if($data['telephoneP'] != null || $data['telephoneP'] != '') {

            //preg_match('/(\d\d\d).(\d\d\d.\d\d\d\d)$/', $data['telephoneP'], $matches);



            /*$info['pt_AreaCode'] = $matches[1];
            $info['pt_phone']           = $matches[2];*/

            $info['pt_AreaCode'] = substr($data['telephoneP'], 0, 3);
            $info['pt_phone']           = substr($data['telephoneP'], 3);

        }
        
#6
        switch ($data['insuredRelationId']){
            case 1     : $info['rel_to_ins'] = 'S';      break;
            case 2     : $info['rel_to_ins'] = 'M';        break;
            case 3      : $info['rel_to_ins'] = 'C';         break;
            case 4 : $info['rel_to_ins'] = 'O';  break;
        }

#7
        if($data['financialClass'] == 'PIWC') {

            $info['ins_street']                = $info['pt_street'];    
            $info['ins_city']                   = $info['pt_city'];
            $info['ins_state']                  = $info['pt_state'];    
            $info['ins_zip']               = $info['pt_zip'];



            $info['ins_phone area'] = $info['pt_AreaCode'];
            $info['ins_phone']           = $info['pt_phone'];

        } else {

            $info['ins_street']                = $data['streetNoI'];    
            $info['ins_city']                   = $data['cityI']; 
            $info['ins_state']                  = $data['stateI'];    
            $info['ins_zip']               = $data['zipCodeI'];

            if($data['telephoneI'] != null || $data['telephoneI'] != '') {

                preg_match('/(\d\d\d).(\d\d\d.\d\d\d\d)$/', $data['telephoneI'], $matches);



                $info['ins_phone area'] = substr($data['telephoneI'], 0, 3);
                $info['ins_phone']           = substr($data['telephoneI'], 3);

            }

        }

#8 BLANK
        $info['NUCC USE'] = $data['reserved'];
#9 BLANK

        $info['other_ins_name'] = $data['nameOI'];
        $info['other_ins_policy'] = $data['policyOrGroupNoOI'];
        $info['other_ins_plan_name'] = $data['OIinsurancePlanName'];
        //$info['other_ins_name'] = $data['nameOI'];
        //$info['other_ins_name'] = $data['nameOI'];

#10
        $info['employment']      =   $data['isEmployment'];
        $info['pt_auto_accident']   =   $data['isAutoAccident'];
        $info['accident_place']  =   $data['stateOfAutoAccident'];
        $info['other_accident']  =   $data['isOtherAccident'];

#11
        $info['ins_policy'] = $data['fecaOrIPGNo'];

        $dobArray = explode('-', $data['insuredDOB']);
        
        $info['ins_dob_mm'] = $dobArray[0];
        $info['ins_dob_dd'] = $dobArray[1];
        $info['ins_dob_yy'] = $dobArray[2];

        switch ($data['insuredSex']){
            case 'Male'  : $info['ins_sex'] = 'MALE'; break;
            case 'Female': $info['ins_sex'] = 'FEMALE'; break;
        }

        $info['ins_plan_name']              = $data['insurancePlanName'];


        $info['ins_benefit_plan'] = $data['haveAnotherPlan'];

#12
        $info['pt_signature']       = "Signature on File";
        $info['pt_date']  = $data['signatureDate'];
#13
        $info['ins_signature'] = "Signature on File";


#14
        if($data['dateOfCurrentIllness'] != null || $data['dateOfCurrentIllness'] != '') {

            preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['dateOfCurrentIllness'],$match);
            $info['cur_ill_yy'] = $match[3];
            $info['cur_ill_dd'] = $match[2];
            $info['cur_ill_mm'] = $match[1];
            
        }
#15
        if($data['similarIllnessFirstDate'] != null || $data['similarIllnessFirstDate'] != '') {

            preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['similarIllnessFirstDate'],$match);
            $info['sim_ill_yy'] = $match[3];
            $info['sim_ill_dd'] = $match[2];
            $info['sim_ill_mm'] = $match[1];
            
        }

#16
        if($data['inabilitySratingDate'] != null || $data['inabilitySratingDate'] != '') {

            preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['inabilitySratingDate'],$match);
            $info['work_yy_from'] = $match[3];
            $info['work_dd_from'] = $match[2];
            $info['work_mm_from'] = $match[1];
            
        }

        if($data['inabilityEndingDate'] != null || $data['inabilityEndingDate'] != '') {

            preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['inabilityEndingDate'],$match);
            $info['work_yy_end'] = $match[3];
            $info['work_dd_end'] = $match[2];
            $info['work_mm_end'] = $match[1];
            
        }

#17
        //$info['ref_physician']                        =  $data['physician'];
        $info['ref_physician']                        = strtoupper($data['nameOfRPorOS']);
        #$info['Number_of_Referring_Provider']                      

        $info['physician number 17a']    = $data['seventeenA'];
        //$info['physician number 17a1']    = $data['seventeenB'];

        $info['id_physician'] = $data['seventeenB'];

#18

        if($data['hospitalizationSratingDate'] != null || $data['hospitalizationSratingDate'] != '') {

            preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['hospitalizationSratingDate'],$match);
            $info['hosp_yy_from'] = $match[3];
            $info['hosp_dd_from'] = $match[2];
            $info['hosp_mm_from'] = $match[1];
            
        }

        if($data['hospitalizationEndingDate'] != null || $data['hospitalizationEndingDate'] != '') {

            preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['hospitalizationEndingDate'],$match);
            $info['hosp_yy_end'] = $match[3];
            $info['hosp_dd_end'] = $match[2];
            $info['hosp_mm_end'] = $match[1];
            
        }

#19
#20
        $info['lab']  = $data['outsideLab'];
        $info['charge']  = sprintf("%.2f", $data['outsideLabCharges']);
#21
#       list ( $info['Diagnosis_Code_1a_21'], $info['Diagnosis_Code_1b_21'], $info['Diagnosis_Code_1c_21'] ) = split ("-", $data['hcfadiag1']);
#       list ( $info['Diagnosis_Code_2a_21'], $info['Diagnosis_Code_2b_21'], $info['Diagnosis_Code_2c_21'] ) = split ("-", $data['hcfadiag2']);
#       list ( $info['Diagnosis_Code_3a_21'], $info['Diagnosis_Code_3b_21'], $info['Diagnosis_Code_3c_21'] ) = split ("-", $data['hcfadiag3']);
#       list ( $info['Diagnosis_Code_4a_21'], $info['Diagnosis_Code_4b_21'], $info['Diagnosis_Code_4c_21'] ) = split ("-", $data['hcfadiag4']);
    
            

            $info['diagnosis1'] = $data['natureOfIllnessA'];
            $info['diagnosis2'] = $data['natureOfIllnessB'];
            $info['diagnosis3'] = $data['natureOfIllnessC'];
            $info['diagnosis4'] = $data['natureOfIllnessD'];
            $info['diagnosis5'] = $data['natureOfIllnessE'];
            $info['diagnosis6'] = $data['natureOfIllnessF'];
            $info['diagnosis7'] = $data['natureOfIllnessG'];
            $info['diagnosis8'] = $data['natureOfIllnessH'];
            $info['diagnosis9'] = $data['natureOfIllnessI'];
            $info['diagnosis10'] = $data['natureOfIllnessJ'];
            $info['diagnosis11'] = $data['natureOfIllnessK'];
            $info['diagnosis12'] = $data['natureOfIllnessL'];
            

        

        /*if($data['natureOfIllnessA'] != null || $data['natureOfIllnessA'] != '') {

            preg_match('/([\w\d]+).([\w\d]*)$/', $data['natureOfIllnessA'], $matches);
            $info['Diagnosis_Code_1a_21'] = $matches[1];
            $info['Diagnosis_Code_1b_21'] = '.'; 
            $info['Diagnosis_Code_1c_21'] = $matches[2];
            
        }

        if($data['natureOfIllnessB'] != null || $data['natureOfIllnessB'] != '') {

            preg_match('/([\w\d]+).([\w\d]*)$/', $data['natureOfIllnessB'], $matches);
            $info['Diagnosis_Code_2a_21'] = $matches[1];
            $info['Diagnosis_Code_2b_21'] = '.'; 
            $info['Diagnosis_Code_2c_21'] = $matches[2];
            
        }

        if($data['natureOfIllnessC'] != null || $data['natureOfIllnessC'] != '') {

            preg_match('/([\w\d]+).([\w\d]*)$/', $data['natureOfIllnessC'], $matches);
            $info['Diagnosis_Code_3a_21'] = $matches[1];
            $info['Diagnosis_Code_3b_21'] = '.'; 
            $info['Diagnosis_Code_3c_21'] = $matches[2];
            
        }

        if($data['natureOfIllnessD'] != null || $data['natureOfIllnessD'] != '') {

            preg_match('/([\w\d]+).([\w\d]*)$/', $data['natureOfIllnessD'], $matches);
            $info['Diagnosis_Code_4a_21'] = $matches[1];
            $info['Diagnosis_Code_4b_21'] = '.'; 
            $info['Diagnosis_Code_4c_21'] = $matches[2];
            
        }*/

#        $info['Diagnosis_Code_1a_21']  = $data['hcfadiag1'];
#        $info['Diagnosis_Code_2a_21']  = $data['hcfadiag2'];
#        $info['Diagnosis_Code_3a_21']  = $data['hcfadiag3'];
#        $info['Diagnosis_Code_4a_21']  = $data['hcfadiag4'];
    
#22
        $info['medicaid_resub'] = $data['medResubmissionCode'];
        $info['original_ref'] = $data['originalRefNo'];
#23
        $info['prior_auth']  = $data['prioprAuthNo'];

#24
    $total  = 0.00;

    for($i = 1; $i<7; $i++){

        $index = $i + 6 * ($pageCount -1);
        
        if($data['procedure'.$index]['id'] > 0){
            
            /*if($data['procedure'.$i]['dateFrom'] != null || $data['procedure'.$i]['dateFrom'] != '') {

            preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['procedure'.$i]['dateFrom'],$match);
            $info['sv'.$i.'_yy_from'] = $match[3];
            $info['sv'.$i.'_dd_from'] = $match[2];
            $info['sv'.$i.'_mm_from'] = $match[1];
            
        }

        if($data['procedure'.$i]['dateTo'] != null || $data['procedure'.$i]['dateTo'] != '') {

            preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['procedure'.$i]['dateTo'],$match);
            $info['sv'.$i.'_yy_end'] = $match[3];
            $info['sv'.$i.'_dd_end'] = $match[2];
            $info['sv'.$i.'_mm_end'] = $match[1];


            
        }*/

            if($data['sd'] != null || $data['sd'] != '') {

                preg_match("/(\d\d)-(\d\d)-\d\d(\d\d)/",$data['sd'],$match);

                $order_yy = $match[3];
                $order_dd = $match[2];
                $order_mm = $match[1];

                $info['sv'.$i.'_yy_from'] = $order_yy;
                $info['sv'.$i.'_dd_from'] = $order_dd;
                $info['sv'.$i.'_mm_from'] = $order_mm;

                $info['sv'.$i.'_yy_end'] = $order_yy;
                $info['sv'.$i.'_dd_end'] = $order_dd;
                $info['sv'.$i.'_mm_end'] = $order_mm;
                
            }

            /*$info['sv'.$i.'_yy_from'] = $info['cur_ill_yy'];
            $info['sv'.$i.'_dd_from'] = $info['cur_ill_dd'];
            $info['sv'.$i.'_mm_from'] = $info['cur_ill_mm'];

            $info['sv'.$i.'_yy_end'] = $info['cur_ill_yy'];
            $info['sv'.$i.'_dd_end'] = $info['cur_ill_dd'];
            $info['sv'.$i.'_mm_end'] = $info['cur_ill_mm'];*/
            
            //$info['place'.$i]    = $data['procedure'.$i]['placeOfService'];
            $info['place'.$i]    = '24';
            //$info['emg'.$i]                 = $data['procedure'.$i]['emg'];
            

# 'fld".$data['fldZone'].'Amount'
            //$sql = "SELECT * FROM tblproceduremanagment WHERE fldDescription='".$data['fldProcedure'.$i]."';";
            //$res = mysql_query($sql) or die (mysql_error());
            //$cbtc = mysql_fetch_assoc($res);

            $pCptcode = '';

                foreach($all_cptcodes as $cptcode) {

                    if($cptcode['id'] == $data['procedure'.$index]['cptId']) {
                        $pCptcode = $cptcode['code'];
                    }

                }

                $pIcdcode = '';

                foreach($all_icdcodes as $icdcode){

                    if($icdcode['id'] ==  $data['procedure'.$index]['icdId']) {
                        $pIcdcode = $icdcode['code'];
                    }

                }

                //$info['diagnosis' . $i] = $pIcdcode;

                $pDefinitive = '';

                foreach($all_definitives as $definitive) {

                    if($definitive['id'] == $data['procedure'.$index]['definitiveId']) {
                        $pDefinitive = $definitive['value'];
                    }

                }        

            
            //$info['Procedure_CPT_HCPCS_'.$i] = $pCptcode;
            
    #        $info['Supplemental_information_'.$i] = $data['fldProcedure'.$i];
            //$info['Procedure_Modifer_'.$i.'a']  = $data['procedure'.$i]['modifier'];
    # Procedure_Modifer_1b
    # Procedure_Modifer_1c
    # Procedure_Modifer_1d
            $info['cpt'.$i]   = $pCptcode;
            $info['mod'.$i]   = $data['procedure'.$index]['modifier'];
            $info['diag'.$i]   = $data['procedure'.$index]['diagnosisPointer'];
            $info['day'.$i]   = $data['procedure'.$index]['daysOrUnits'];
            $info['ch'.$i]   = sprintf("$%.2f", $data['procedure'.$index]['charges']);
            $info['local'.$i]   = '1083887186';
            $info['epsdt'.$i]   = $data['procedure'.$index]['epsdt'];

            $total += $data['totalCharges'];
            
# if fldRate = Flat then just use fldRateValue as amount in 24.f
# if fldRate = anything else then you must get zone number and value from tblproceduremangement 
# and multiply that value by fldRateValue from tblfacility

            //$amount = sprintf("%.2f", $data['procedure'.$i]['charges']);

            
            /*ltrim ($data['fldPatientID']);
            if( $data['fldRate'] == 'Flat' && !preg_match("/^[AaTt]/",$data['fldPatientID'] ) ){
                $amount = sprintf("%.2f",$data['fldRateValue']);
            }
            else if ($data['fldRate'] == 'Flat' && preg_match("/^[AaTt]/",$data['fldPatientID'] )){
                    $amount = sprintf("%.2f",(float)$cbtc['fldz'.$data['fldZone'].'amount']);
            
            }
            else{
                $amount = sprintf("%.2f",((float)$cbtc['fldz'.$data['fldZone'].'amount']*(float)$data['fldRateValue']));
            #   echo "$amount<br>";
            }*/
            //list($dollars,$cents) = split("\.","$amount");
#            echo "$amount,$dollars,$cents <br>";
            //$amountArray = explode('.', $amount);
            //$dollars = $amountArray[0];
            //$cents = $amountArray[1];
            
            //$info['Dollar_Charges_'.$i] = $dollars;
            //$info['Cents_Charges_'.$i]  = $cents;
            
            //$total += $amount;
    #EPSDT_Family_Plan_1
    #Rendering_Providers_NPI_Number_1
    
            
        }
    }

#25
        $info['tax_id'] = $data['federalTaxID'];
        $info['ssn']           = ($data['isSSN'] == 'YES') ? 'SSN' : 'EIN';
#26
        $info['pt_account'] = $data['patientAccNo'];
#27
        $info['assignment'] = $data['doesAcceptAssignment'];

#28
        if($hasNextPage == false) {

            $info['t_charge'] = sprintf("%.2f", $data['total_charge']);

            $info['amt_paid'] = sprintf("%.2f", $data['amountPaid']);
#30
            $info['t_due'] = $data['total_charge'] - $data['amountPaid'];

        } else {

            $info['t_charge'] = 'See Page 2';

            $info['amt_paid'] = 'See Page 2';
#30
            $info['t_due'] = 'See Page 2';

        }
        //$total = sprintf("%.2f",$total);
        //$sql = "UPDATE $table1 SET total_charge='$total' WHERE `fldID`='$id'";
        //$rv2 = mysql_query($sql) or die (mysql_error());

        //list($info['Total_Charge_Dollars'],$info['Total_Charge_Cents']) = split("\.","$total");
        /*$totalArray = explode('.', $total);

        $info['Total_Charge_Dollars'] = $totalArray[0];
        $info['Total_Charge_Cents'] = $totalArray[1];*/
#        $info['Total_Charge_Dollars'] = $info['Dollar_Charges_1']+$info['Dollar_Charges_2']+$info['Dollar_Charges_3']+$info['Dollar_Charges_4']+$info['Dollar_Charges_5']+$info['Dollar_Charges_6'];
#        $info['Total_Charge_Cents']   = $info['Cent_Charges_1']+$info['Cent_Charges_2']+$info['Cent_Charges_3']+$info['Cent_Charges_4']+$info['Cent_Charges_5']+$info['Cent_Charges_6'];

#29
        if(isset($data['PhyOrSpplrSignature'])){

            $info['physician_signature'] = $data['PhyOrSpplrSignature'];
       
        }
        

#31

        if(isset($data['PhyOrSpplrSignature'])){

            $info['physician_signature'] = $data['PhyOrSpplrSignature'];
       
        }

        if(isset($data['PhyOrSpplrSigDate'])){

            //$info['physician_signature'] = "Signature on File";
            $info['physician_date'] = $data['PhyOrSpplrSigDate'];
       
        }
        /*else{
        
            $info['physician_signature'] = "Signature on File";
        }*/
#32
        $info['fac_name']           = strtoupper($data['facility']['name']);
        $info['fac_street']           = strtoupper($data['facility']['address']);
        $info['fac_location']           = strtoupper($data['facility']['city'] . ', ' . $data['facility']['state'] . ' ' . $data['facility']['zip']);
        /*$info['fac_name']           = $data['facility']['name'];
        $info['fac_street']           = $data['facility']['address'];
        $info['fac_location']           = $data['facility']['city'] . ', ' . $data['facility']['state'] . ' ' . $data['facility']['zip'];*/
        $info['pin1']           = $data['facility']['uCode'];
        //$info['Service_Facility_Location_Address']        = '';//$data['fldAddressLine1'];   
        //$info['Service_Facility_Location_City_State_Zip'] = '';//$data['fldAddressCity']." ".$data['fldAddressState']." ".$data['fldAddressZip'];    

#33
        $info['doc_name']           = 'SADDLEBACK PORTABLE X-RAY';
        $info['doc_street']           = 'P.O. BOX 4427';
        $info['doc_location']           = 'SANTA ANA, CA 92701';
        $info['pin']           = '1083887186';
        /*$info['Billing_Provider_Phone_Number_Area_Code'] = "850"; 
        $info['Billing_Provider_Phone_Number']           = "562-1656";

        $info['Billing_Provider_Name']           = 'Tech Care X-Ray';
        $info['Billing_Provider_Address']        = '106 West 5th Ave';
        $info['Billing_Provider_City_State_Zip'] = 'Tallahassee,FL 32303';
        $info['NPI_Number_a'] = '1639432040';*/

        //var_dump($total);var_dump($info);die();

        return $info;

    }

    private function pW9($apid) {

        $file = array(
            'filename' => 'W-9.pdf',
            'mimetype' => 'application/pdf'
        );

        $filenameWithPath = FCPATH . 'PnS/core/' . $file['filename'];
        

        header('Content-disposition: attachment; filename='. $file['filename']);
        header('Content-type: ' . $file['mimetype']);
        header('Content-Length: ' . filesize($filenameWithPath));

        readfile($filenameWithPath);

    }

    private function pOrder($apid) {

        $this->load->model('Patient_model');
        $this->load->model('Order_model');
        $this->load->model('Facility_model');
        $this->load->model('Tech_model');
        $this->load->model('Physician_model');
        $this->load->model('Cptcode_model');
        $this->load->model('Procedure_model');

        $dirPDF = FCPATH . 'PnS/partials/';

        $patient = $this->Patient_model->get_patient($apid);

        $osid = $patient['OSID'];

        $order = $this->Order_model->get_order($osid);

        $facilityId = $order['facilityId'];
        $referringPhysicianId = $order['referringPhysicianId'];
        $techId = $order['techId'];
        $scheduledTime = $order['scheduledTime'];

        $facility = $this->Facility_model->get_facility($facilityId);
        $tech = $this->Tech_model->get_tech($techId);
        $physician = $this->Physician_model->get_physician($referringPhysicianId);

        $this->data['scheduledTime'] = date(' m-d-Y, H:i ', $scheduledTime);
        $this->data['patient'] = (object)$patient;
        $this->data['facility'] = (object)$facility;
        $this->data['tech'] = (object)$tech;
        $this->data['referringPhysician'] = (object)$physician;

        $procedures = $this->_getProcedures($apid);

        $cpt1 = array(
            'id' => 0,
            'code' => 0,
            'description' => ' '
        );

        $cpt2 = array(
            'id' => 0,
            'code' => 0,
            'description' => ' '
        );

        if($procedures[0]['id'] > 0) {

            $cpt1 = $this->Cptcode_model->get_cptcode($procedures[0]['cptId']);

        }

        if($procedures[1]['id'] > 0) {

            $cpt2 = $this->Cptcode_model->get_cptcode($procedures[1]['cptId']);

        }

        $this->data['cpt1'] = (object)$cpt1;
        $this->data['cpt2'] = (object)$cpt2;

        $content = $this->load->view('printablePDFs/order', $this->data, true);

        $pdfFile = $dirPDF . 'O_' . $patient['PID'] . '.pdf';

        $this->load->library('npdf');

        $mPDF = $this->npdf->pdf;

        /*$stylesheet = file_get_contents(base_url() . '/assets/css/mpdfstyletables.css');
        $mPDF->WriteHTML($stylesheet, 1);*/

        $mPDF->WriteHTML($content);

        $mPDF->Output($pdfFile, 'F');

        return $pdfFile;

    }

    private function pAttachments($apid) {

        $dirPDF = FCPATH . 'PnS/partials';

        $uploadsDir = APPPATH . 'uploads';

        $fileLocationDirPath = APPPATH . 'uploads/';

        //$this->load->model('Attachment_model');

        $patient = $this->Patient_model->get_patient($apid);

        $attachments = $this->Attachment_model->get_attachments($apid);

        $pdfFile = 'Attachments_' . $patient['PID'] . '.pdf';

        $files = array();
        $others = array();


        if(count($attachments) > 0) {

            foreach ($attachments as $attachment) {

                if($attachment['mimetype'] == 'application/pdf') {

                    $fsArray = explode(' ', $attachment['filename']);
                    $size = count($fsArray);

                    if($size > 1) {

                        array_push($files, $fileLocationDirPath . '"' . $attachment['filename'] . '"');

                    } else {

                       array_push($files, $fileLocationDirPath . $attachment['filename']); 

                    }

                    //array_push($files, $fileLocationDirPath . $attachment['filename']);
                    

                }

            }

        }  

        $fileString = '';

        if(count($files) > 0) {

            foreach ($files as $file) {
                $fileString .= $file . ' ';
            }
        }

        return $fileString;


    }

    /*private function pAttachments($apid) {

        $dirPDF = FCPATH . 'PnS/partials';

        $imagesFile = FCPATH . 'PnS/partials/images.pdf';

        $uploadsDir = APPPATH . 'uploads';

        $fileLocationDirPath = APPPATH . 'uploads/';

        //$this->load->model('Attachment_model');

        $patient = $this->Patient_model->get_patient($apid);

        $attachments = $this->Attachment_model->get_attachments($apid);

        $pdfFile = 'Attachments_' . $patient['PID'] . '.pdf';

        $files = array();
        $others = array();


        foreach ($attachments as $attachment) {

            if($attachment['mimetype'] == 'application/pdf') {

                array_push($files, $fileLocationDirPath . $attachment['filename']);

            } else {

                array_push($others, $fileLocationDirPath . $attachment['filename']);            

            }

            
        }

        if($files) {

            $fileString = '';

            foreach ($files as $file) {

                $fileString .= $file . ' ';
                
            }


            $command = "pdftk ".$fileString."cat output $dirPDF/attachments.pdf flatten";
            exec ($command,$result);

            if($result[0] == '') {

                $data = array();

                $data['file'] = 'attachments.pdf';

                if($others) {

                    $data['others'] = $others;

                } else {

                    $data['others'] = null;

                }

                return $data;

                if($others) {

                    $fileString = '';

                    foreach ($others as $other) {

                        $fileString .= $other . ' ';
                        
                    }

                    $command = "pdftk $dirPDF/attachments.pdf attach_files ".$fileString."output $dirPDF/$pdfFile";
                    exec ($command,$result);

                    if($result[0] == '') {

                        exit(0);

                    } else {

                        die('Error in creating PDF..!');

                    }

                }

                exit(0);

            } else {

                die('Error in creating PDF..!');

            }

        }


    }*/

    private function createFinalPDF($apid, $filesString, $others) {

        $PdfDir = FCPATH . 'PnS/combined';

        $patient = $this->Patient_model->get_patient($apid);

        $pdfFileName = 'ScheduledPatient_' . $patient['PID'] . '.pdf';

        $mainPDF = FCPATH . 'PnS/partials/' . $pdfFileName;

        if($filesString != '' || $filesString != null) {

            $command = "pdftk ".$filesString."cat output $PdfDir/ScheduledPatient.pdf flatten";

            exec ($command,$result);

            if($result[0] == '') {

                if($others != '' && $others != null) {

                    $fileString = '';

                    foreach ($others as $other) {

                        $fileString .= $other . ' ';
                        
                    }

                    $command = "pdftk $PdfDir/ScheduledPatient.pdf attach_files ".$fileString."output $PdfDir/$pdfFileName";
                    exec ($command,$result);

                    if($result[0] == '') {

                        return $pdfFileName;

                        exit(0);

                    } else {

                        die('Error in creating PDF..!');

                    }

                }

                return 'ScheduledPatient.pdf';

                exit(0);

            } else {

                die('Error in creating the printable PDF..!');

            }

        }


    }

    private function createTheFinalPDF($apid, $filesString) {

        $PdfDir = FCPATH . 'PnS/combined';

        $tempDir = FCPATH . 'PnS/temp';

        $patient = $this->Patient_model->get_patient($apid);

        $pdfFileName = 'SP_' . $patient['PID'] . '.pdf';

        $mainPDF = FCPATH . 'PnS/combined/' . $pdfFileName;

        if($filesString != '' || $filesString != null) {

            $command = "pdftk ".$filesString."cat output $PdfDir/$pdfFileName flatten";

            exec ($command,$result);

            if($result[0] == '') {

                //$command = "pdftk $tempDir/CombinedPO.pdf output $pdfDir/SP.pdf";

                //exec ($command,$result);

                //unlink ("$PdfDir/$pdfFileName");
           
                //if($result[0] == '') {


                    return $pdfFileName;
                    
                //} else {
                //    return '';
                //}

                

            } else {

                return '';

                //die('Error in creating the printable PDF..!');

            }

        } else {

            return '';

        }


    }

    private function createTheDirectPDF($apid, $filesString) {

        $PdfDir = FCPATH . 'DirectProcessStorage';

        $tempDir = FCPATH . 'PnS/temp';

        $patient = $this->Patient_model->get_patient($apid);

        $pdfFileName = 'Patient_#' . $patient['PID'] . '_Overview_t.' . time() . '.pdf';

        $mainPDF = FCPATH . 'PnS/combined/' . $pdfFileName;

        if($filesString != '' || $filesString != null) {

            $command = "pdftk ".$filesString."cat output $PdfDir/$pdfFileName flatten";

            exec ($command,$result);

            if($result[0] == '') {

                //$command = "pdftk $tempDir/CombinedPO.pdf output $pdfDir/SP.pdf";

                //exec ($command,$result);

                //unlink ("$PdfDir/$pdfFileName");
           
                //if($result[0] == '') {


                    return $pdfFileName;
                    
                //} else {
                //    return '';
                //}

                

            } else {

                return '';

                //die('Error in creating the printable PDF..!');

            }

        } else {

            return '';

        }


    }

    
}
