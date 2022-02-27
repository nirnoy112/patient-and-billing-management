<?php

	/*****
	*
	* @File: 'core/NDP_Controller.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 19 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

	class NDP_Controller extends CI_Controller {

		public function __construct() {

			parent::__construct();

		}

		public function initialize() {

			$user_session_data = array(

				'is_authorized' => false,
				'id' => 0,
				'username' => 'anonym',
				'realName' => 'Anonymous User',
				'user_role' => null,
				'current_url' => null,
				'previous_url' => null,
				'query_rules' => null

			);

			$this->session->set_userdata('user_session', $user_session_data);

		}

		public function loadAppData($is_authorization_required) {

			if($this->session->userdata('user_session') == null) {

				$this->initialize();

			}
			
			$data = $this->session->userdata('user_session');

			$last_url = $data['current_url'];

			$data['current_url'] = current_url();
			$data['previous_url'] = $last_url;

			$this->session->set_userdata('user_session', $data);

			$this->data = $this->session->userdata('user_session');

			if($is_authorization_required == true && $this->data['is_authorized'] == false) {
				
				redirect('login');

			}

		}

		public function updateUserSession($key, $value) {

			$data = $this->session->userdata('user_session');

			$data[$key] = $value;

			$this->session->set_userdata('user_session', $data);

			$this->data = $this->session->userdata('user_session');

		}

		public function sbpLog($action_performed) {

			$documentText = '';

			$current_time = date("m-d-Y H:i:s");

			$fileName = 'sbpLog_' . date('m-d-Y') . '.txt';

			$fnm = FCPATH . 'assets/fonts/SBPlog.txt';

			$ct = $this->formatwhitespaces($current_time, 30);

			$username = $this->formatwhitespaces($this->data['username'], 20);

			$realName = $this->formatwhitespaces($this->data['realName'], 25);

			$action = $this->formatwhitespaces($action_performed, 20);

			$documentText .= <<<EOT
 {$ct}{$username}{$realName}{$action}
-------------------------------------------------------------------------------------------------
EOT;
			$documentText .= "\n";

			$f = fopen(APPPATH . 'logs/sys/' . $fileName, 'a');
        	fwrite($f, $documentText);
        	fclose($f);

			/*$currentContents = file_get_contents(APPPATH . 'logs/sys/' . $fileName);

			$currentContents .= $documentText;

			if ( write_file( APPPATH . 'logs/sys/' . $fileName, $currentContents ) ) {

				return true;

			} else {

				return false;

			}*/

			//file_put_contents( APPPATH . 'logs/sys/' . $fileName, $currentContents );

			//$crntContents = file_get_contents($fnm);

			//$crntContents .= $documentText;

			//file_put_contents( $fnm, $crntContents );

		}

		public function getAbsoluteArray($array) {

			$absolute_array = array();

			foreach ($array as $key => $value) {
				if($value != '') {
					$absolute_array[$key] = $value;
				}
			}

			if(empty($absolute_array)) {
				return null;
			} else {
				return $absolute_array;
			}
			
		}

		public function sendEmail($toEmail, $attachedFile) {

			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => '465',
				'smtp_user' => '',
				'smtp_pass' => '',
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => true
			);

			$this->load->library('email', $config);
			$this->email->from('noreply@sbp.com', 'SPB Admin');
			$this->email->to($toEmail);
			$this->email->subject('SPB INFO: Need Immediate Attention');
			$this->email->message('On the behalf of SBP, this email aim at getting you informed formally about the fact that the attached PDF requires your immediate notice, review and feedback.');
			$this->email->attach($attachedFile);
			$this->email->set_newline("\r\n");
			
			if($this->email->send()) {
				echo 'An Email Has Been Sent Successfully...!';
			} else {
				show_error($this->email->print_debugger());
			}

		}


		public function formatwhitespaces($text, $length) {
			
			return str_pad ($text, $length," ");

		}


	}

?>
