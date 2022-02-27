<?php

    /*****
    *
    * @File: 'Report.php'.
    * @Author: Nirnoy.
    * @CreatedOn: 16 AUGUST, 2017.
    * @LastUpdatedOn: 17 AUGUST, 2017.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');
 
class Report extends NDP_Controller {
    function __construct()
    {
        parent::__construct();

        $this->load->model('Facility_model');
        $this->load->model('Order_model');
        $this->load->model('Patient_model');

        $this->loadAppData(true);
        
    } 

    /*
     * Creating Facility Report
     */
    function facility()
    {

        $dirPDF = FCPATH . 'PnS/combined';

        if(isset($_POST['create_f_report'])) {

            //$fuCode = (int)$this->input->post('uCode');

            //$facility = $this->Facility_model->get_facility_by_ucode($fuCode);

            $facilityOpts = $this->input->post('facilityOpts');

            //var_dump($facilityOpts);die();

            

            $data = array();


            foreach ($facilityOpts as $facOpt) {

                $query_rules = array(
                    'sortBy' => 'scheduledTime',
                    'sortingOrder' => 'asc',
                    'rpid' => 0,
                    'fid' => $facOpt,
                    'tid' => 0,
                    'dateFrom' => $this->input->post('dateFrom'),
                    'dateTo' => $this->input->post('dateTo')

                );

                if($query_rules['dateFrom'] != null && $query_rules['dateTo'] != null) {

                    $dfs = $query_rules['dateFrom'] . ' 00:00:00';
                    $dts = $query_rules['dateTo'] . ' 23:59:59';

                    $df = DateTime::createFromFormat('m-d-Y H:i:s', $dfs);
                    $dt = DateTime::createFromFormat('m-d-Y H:i:s', $dts);

                    $query_rules['dateFrom'] = strtotime($df->format('Y-m-d H:i:s'));
                    $query_rules['dateTo'] = strtotime($dt->format('Y-m-d H:i:s'));

                }

                $facData = array();


                //echo $facOpt . '<br>';

                //$query_rules['fid'] = (int)$facOpt;


                $facData['facility'] = $this->Facility_model->get_facility($query_rules['fid']);

                $oids = $this->Order_model->pullOrderIDs($query_rules);

                

                $ordersData = array();
                
                foreach ($oids as $oid) {

                    $orderData = array();
                    
                    $osid = (int)$oid['id'];

                    $order = $this->Order_model->get_order($osid);

                    $orderData['sheduledTime'] = $order['scheduledTime'];
                    //var_dump($order);

                    $pa = $this->Patient_model->get_patients($osid);

                    $orderData['patients'] = $pa;
                    //var_dump($pa);
                    array_push($ordersData, $orderData);

                }

                $facData['orders'] = $ordersData;

                //array_push($facData, $orderData);

                
                //if($facData != null) {
                    array_push($data, $facData);
                //}

                

            }

            /*foreach ($data as $value) {
                var_dump($value['facility']);
                var_dump($value['orders']);
            }
            die();*/
            $this->data['reports'] = $data;

            //var_dump($data); die();

            //array_push($data, $facData);

            //var_dump($data); die();


            /*$patients = $this->Patient_model->get_facility_patients($fuCode);

            $data = array(
                'facility' => $facility,
                'patients' => $patients
            );*/

            $this->data['ctrl'] = $this;

            $content = $this->load->view('printablePDFs/facility_report', $this->data, true);

            $pdfFile = $dirPDF . 'FR_' . mt_rand() . '.pdf';

            $this->load->library('npdf');

            $mPDF = $this->npdf->pdf;

            $mPDF->WriteHTML($content);

            $mPDF->Output($pdfFile, 'F');

            $reportFileName = 'BillingReport_' . date('m-d-Y') . '.pdf';


            $downloadableFile = array(
                'filename' => $reportFileName,
                'mimetype' => 'application/pdf'
            );

            //$filenameWithPath = FCPATH . 'PnS/combined/' . $finalPDF;
            

            header('Content-disposition: attachment; filename='. $downloadableFile['filename']);
            header('Content-type: ' . $downloadableFile['mimetype']);
            header('Content-Length: ' . filesize($pdfFile));

            ob_clean();
            ob_start();

            readfile($pdfFile);

            ob_flush();
            flush();

            exit;



        }

        $this->data['all_facilities'] = $this->Facility_model->get_all_facilities();
        $this->data['pageTitle'] = 'Facility Report';
        $this->data['pageHeading'] = 'CREATE FACILITY REPORT'; 
        $this->data['_view'] = 'report/facility';
        $this->load->view('layouts/main',$this->data);

    }

    public function displayProcedures($pid) {

        $this->load->model('Procedure_model');
        $procedures = $this->Procedure_model->get_procedures($pid);

        $this->load->model('Cptcode_model');
        $all_cptcodes = $this->Cptcode_model->get_all_cptcodes();

        $this->load->model('Icdcode_model');
        $all_icdcodes = $this->Icdcode_model->get_all_icdcodes();

        $this->load->model('Definitive_model');
        $all_definitives = $this->Definitive_model->get_all_definitives();


        $proceduresData = '';

        foreach ($procedures as $procedure) {

            $pCptcode = '';

            foreach($all_cptcodes as $cptcode) {

                if($cptcode['id'] == $procedure['cptId']) {
                    $pCptcode = $cptcode['code'];
                }

            }

            $pIcdcode = '';

            foreach($all_icdcodes as $icdcode){

                if($icdcode['id'] ==  $procedure['icdId']) {
                    $pIcdcode = $icdcode['code'];
                }

            }

            //$info['diagnosis' . $i] = $pIcdcode;

            $pDefinitive = '';

            foreach($all_definitives as $definitive) {

                if($definitive['id'] == $procedure['definitiveId']) {
                    $pDefinitive = $definitive['value'];
                }

            }
            
            $proceduresData .= $pCptcode . ' | ' . $pIcdcode . ' | ' . $pDefinitive . '<br><hr>';

        }

        return $proceduresData;


    }

    
}
