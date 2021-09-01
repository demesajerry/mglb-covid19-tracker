<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Establishment extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin_est();
		//$this->output->enable_profiler(TRUE);
		//$this->load->model('patients_model', '', TRUE);
	}

	public function index(){
		$this->scan();
	}

	public function scan(){
		if($this->session->userdata('est_logged_in')->userid == 670){
			redirect(site_url("Est_reports/"));
		}else{
		$this->data['userdata'] = $this->session->userdata('est_logged_in');
		$this->data['content'] = 'establishment/scan.php';

		$this->load->view('template/establishment', $this->data);
		}
	}

	public function add_entry(){
		$this->load->model('Establishment_model');
		$this->load->model('General_model');
		date_default_timezone_set('Asia/Manila');
		$group_id = $this->input->post('group_id');
		$est_id = $this->input->post('est_id');
		$client_qrcode = $this->input->post('qrcode');
 		$userinfo = $this->General_model->check_qr_exist($client_qrcode,$group_id);
		$jsondata = new stdClass();
		$jsondata->device_id = $this->General_model->get_one_row('device','is_active','1')->device_id;

		$data = new stdClass();

		$jsondata->oddeven_exemption = $this->Establishment_model->get_by_id($est_id)->oddeven_exemption;
		$data->est_id = $est_id;
		$data->datetime =  date("Y-m-d H:i:s");
 		if(count($userinfo)>0){
			$data->sov =  $userinfo[0]->status;
			$data->client_id = $userinfo[0]->id;
 			$jsondata->userinfo = $userinfo[0];
			$jsondata->error_log = 0;
 			$track_id = $this->Establishment_model->add($data,'tracks');
 			$jsondata->track_id = $track_id;
 		}else{
			$jsondata->error_log = 1;
 		}
 		
		header('Content-Type: application/json');
		echo json_encode( $jsondata );
 	}

 	public function alert_sms(){
		$this->load->model('Establishment_model');
		$data_alerts = new stdClass();
		$data_alerts->track_id = $this->input->post('track_id');
		$data_alerts->alert_status = $this->input->post('status');
		$data_alerts->checked = 0;
		$data_alerts->date = date('Y-m-d');
			$this->Establishment_model->add($data_alerts,'alerts');
			//send text message
			// $contact_number = "09972971912";
			// $contact_number = "09163638499";
			$contact_number = "09652735043";
			$username = "pido";
			$password = "sms@losbanos";
			$message = "ALERT TYPE ".$this->input->post('status');
			$message .= "\n".$this->session->userdata('est_logged_in')->name;
			$message .= "\n".$this->input->post('name');
			$message .= "\n".$this->input->post('contact_number');
			$message .= "\n".$this->input->post('brgyDesc');
			$message .= "\n".date('F d, Y H:i:s');
           
        $data_sms = ['message'=>$message, 'phone'=>$contact_number, 'username'=>$username, 'password'=>$password];
        $url = 'http://58.71.16.227/SendSMS';
        //decode returned json data
		// $jsondata->test = json_decode($this->callAPI('GET', $url, $data_sms));	
        $this->callAPI('POST', $url, $data_sms);

		// $url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';

		//send data
		// $data_sms = new stdClass();
		// $data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
		// $data_sms->message_id = '0';
  // 		$data_sms->number = '63'.substr($contact_number, -10);

  // 		$data_sms->message = $message;

		// $get_data = json_decode($this->callAPI('POST', $url, $data_sms));
  	}

  	public function callAPI($method, $url, $data){
	   $curl = curl_init();
	   switch ($method){
	      case "POST":
	         curl_setopt($curl, CURLOPT_POST, 1);
	         if ($data)
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	         break;
	      case "PUT":
	         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	         if ($data)
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
	         break;
	      default:
	         if ($data)
	            $url = sprintf("%s?%s", $url, http_build_query($data));
	   }
	   // OPTIONS:
	   curl_setopt($curl, CURLOPT_URL, $url);
	   // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	   // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	   // EXECUTE:
	   $result = curl_exec($curl);
	   curl_close($curl);
	   
 		$this->load->model('General_model');

		$sms = new stdClass();
		$sms->device = 'SAMSUNG';
		$sms->number = $data['phone'];
		$sms->message = $data['message'];			
		$sms->action = '2';//1 = send
		$sms->date = date('Y-m-d');//1 = send
		$sms->time = date('H:i:s');//1 = send
		//insert to db message sent
		$this->General_model->add($sms,'sms');

	   // return $result;
	}

	public function alert_sms_dost()
	{
		$this->load->model('Establishment_model');
		$data_alerts = new stdClass();
		$data_alerts->track_id = $this->input->post('track_id');
		$data_alerts->alert_status = $this->input->post('status');
		$data_alerts->checked = 0;
		$data_alerts->date = date('Y-m-d');
			$this->Establishment_model->add($data_alerts,'alerts');
			//send text message
			//$contact_number = "09561621929";
			// $contact_number = "639972971912";
			// $contact_number = "639163638499";
			$contact_number = "09163638499";
			$username = "pido";
			$password = "sms@losbanos";
			$message = "ALERT TYPE ".$this->input->post('status');
			$message .= "\n".$this->session->userdata('est_logged_in')->name;
			$message .= "\n".$this->input->post('name');
			$message .= "\n".$this->input->post('contact_number');
			$message .= "\n".$this->input->post('brgyDesc');
			$message .= "\n".date('F d, Y H:i:s');
           
        $url = 'http://sms.mglb-covid19-tracker.com/SendSMS';
        //decode returned json data
		// $jsondata->test = json_decode($this->callAPI('GET', $url, $data_sms));	
			$url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';

			//send data
			$data_sms = new stdClass();
			$data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
			$data_sms->message_id = '0';
	  		$data_sms->number = '63'.substr($contact_number, -10);

	  		$data_sms->message = $message;

			$get_data = $this->callAPI_DOST('POST', $url, $data_sms);
		}

  	public function callAPI_DOST($method, $url, $data){
	   $curl = curl_init();
	   switch ($method){
	      case "POST":
	         curl_setopt($curl, CURLOPT_POST, 1);
	         if ($data)
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	         break;
	      case "PUT":
	         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	         if ($data)
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
	         break;
	      default:
	         if ($data)
	            $url = sprintf("%s?%s", $url, http_build_query($data));
	   }
	   // OPTIONS:
	   curl_setopt($curl, CURLOPT_URL, $url);
	   // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	   // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	   // EXECUTE:
	   $result = curl_exec($curl);
	   curl_close($curl);

 		$this->load->model('General_model');

		$sms = new stdClass();
		$sms->device = 'DOST';
		$sms->number = '0'.substr($data->number, -10);
		$sms->message = $data->message;			
		$sms->action = '2';//1 = send
		$sms->date = date('Y-m-d');//1 = send
		$sms->time = date('H:i:s');//1 = send
		//insert to db message sent
		$this->General_model->add($sms,'sms');

	   return $result;
	}

    public function forbidden()
	{
		$this->load->view('errors/index.html');
	} 
 }
