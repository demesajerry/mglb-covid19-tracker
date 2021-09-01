<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagger extends MY_Controller {

	public function __construct() {
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		//$this->load->model('patients_model', '', TRUE);
	}

	public function index(){
		if(!isset($this->session->userdata['tagger_logged_in']))
		{
			$this->data['page_title'] = 'Login';
			$this->data['validation_message'] = '';
			$this->load->view('tagger/login', $this->data);
		} else {
			redirect(site_url("Tagger/vaccination"));
		}
	}

	public function vaccination(){
		$this->isLogin_tagger();
		$this->load->model('General_model');
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['userdata'] = $this->session->userdata('tagger_logged_in');
		$this->data['content'] = 'tagger/vaccination.php';
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$where = new stdClass();
		$where->status = 0;
		$this->data['priority_group'] = $this->General_model->filter_list($where,'priority_group',false);
		$this->load->view('template/tagger', $this->data);
	}

	public function scan(){
		$this->isLogin_tagger();
		$this->data['userdata'] = $this->session->userdata('tagger_logged_in');
		$this->data['content'] = 'tagger/scan.php';

		$this->load->view('template/tagger', $this->data);
	}

	public function add_entry(){
		$this->isLogin_tagger();
		$this->load->model('Tagger_model');
		$this->load->model('General_model');
		date_default_timezone_set('Asia/Manila');
		$tagger_id = $this->input->post('tagger_id');
		$client_qrcode = $this->input->post('qrcode');
		$brgyCode = $this->input->post('brgyCode');
 		$userinfo = $this->General_model->tagger_qr_exist($client_qrcode);
		$jsondata = new stdClass();
		$data = new stdClass();

 		if(count($userinfo)>0){
			$jsondata->userinfo = $userinfo[0];
			if($brgyCode ==$userinfo[0]->brgyCode){
	 			if($userinfo[0]->apor == 0){
					$data->client_id = $userinfo[0]->id;
					$data->tagger_id = $tagger_id;
					$data->tag_date =  date("Y-m-d H:i:s");
					$data->brgyCode = $brgyCode;
					$data->action_done = 'CLIENT TAGGED';
		 			//no error
					$jsondata->error_log = 0;
		 			$this->General_model->add($data,'tag_history');
		 			$update = new stdClass();
		 			$update->apor = 1;
		 			$where = new stdClass();
		 			$where->id = $userinfo[0]->id;
		 			$this->General_model->update($update,$where, 'clients');
		 		}else{
		 			//already tagged as apor
					$jsondata->error_log = 3;
		 		}
		 	}else{
		 			//NOT IN BRGY OF TAGGER
					$jsondata->error_log = 2;
		 	}
 		}else{
 			//QRCODE NOT RECOGNIZE
			$jsondata->error_log = 1;
 		}
	
		header('Content-Type: application/json');
		echo json_encode( $jsondata );
 	}
 	
    public function forbidden()
	{
		$this->load->view('errors/index.html');
	} 

	public function login()
	{
		$message = "Not Valid";
		
		if(trim($this->input->post('username')) != "" && trim($this->input->post('password')) != "")
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');		
			$long = $this->input->post('long');
			$lat = $this->input->post('lat');	

			$this->load->model('User_information_model', '', TRUE);
				$user_information = $this->User_information_model->tagger_login($username);
				if($user_information != false) 
				{
					if(password_verify($password, $user_information->password)){
						$sessiondata = new stdClass();
						$sessiondata->tagger_id = $user_information->tagger_id;
						$sessiondata->brgyDesc = $user_information->brgyDesc;
						$sessiondata->brgyCode = $user_information->brgyCode;
						$sessiondata->fullname = $user_information->lname.', '.$user_information->fname;										
						$sessiondata->access = $user_information->access;										
						$this->session->set_userdata('tagger_logged_in', $sessiondata);
						$message = "Completed";
					}else{
						$message = "Please enter correct username or password";
					}
				}
				else
				{
					$message = "Please enter correct username or password";
				}					
		} 
		else 
		{
			$message = "Please enter correct values";					
		}	
		output_to_json($this, $message);	
	}	

	public function logout()
	{
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('tagger_logged_in', $sess_array);
		$data['message_display'] = '<strong>Info:</strong> Successfully Logout';
		redirect('Tagger');
	}

 }
