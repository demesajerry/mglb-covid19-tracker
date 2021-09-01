<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_profile extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin_client();
		//$this->output->enable_profiler(TRUE);
		 // Load Pagination library
    	$this->load->library('pagination');
    	$this->load->helper('captcha');
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		$this->load->model('General_model');
		$this->load->model('Clients_model');
		$id = $this->session->userdata('user')['id'];
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['status_list'] = $this->Clients_model->get_status_list();
		$this->data['symptoms_list'] = $this->Clients_model->get_symptoms_list();
		$this->data['healthRecord_table'] = $this->Clients_model->get_healthRecord_table($id);
		$this->data['content'] = 'client_profile/index.php';
		$this->data['userdata'] = $this->session->userdata('user');
		$this->load->view('template/public', $this->data);	
	}

	public function get_image(){
		$img = $this->session->userdata('user')['image_path'];
		$file_extension = explode('.',$img);

		switch($file_extension[1]){
			case "gif": $ctype = 'image/gif'; break; 
			case "png": $ctype = 'image/png'; break; 
			case "jpeg": 
			case "jpg": $ctype = 'image/jpeg'; break; 
			case "svg": $ctype = 'image/svg+xml'; break; 
		}

		header('Content-Type: '. $ctype);

		readfile($img);
	}

	public function est_registration()
	{
		$this->load->model('General_model');
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['content'] = 'contact_tracing3/establishment_registration/registration';
		$this->load->view('template/public', $this->data);	
	}

	public function update_client(){ 
		$this->load->model('Client_profile_model'); 
		
		$data = new stdClass();
		$client_id = $this->input->post('client_id');
		$data->fname = $this->input->post('fname');
		$data->lname = $this->input->post('lname');
		$data->mname = $this->input->post('mname');
		$data->address = $this->input->post('address');
		$data->citymunCode = $this->input->post('citymunCode');
		$data->brgyCode = $this->input->post('brgyCode');
		$data->provCode = $this->input->post('provCode');
		$data->birthday = date("Y-m-d", strtotime($this->input->post('birthday')));
		$data->contact_number = $this->input->post('contact_number');
		$data->pow = $this->input->post('pow');
		$data->sex = $this->input->post('sex');  
		
		$this->Client_profile_model->update($data, $client_id);	 
		
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function update_healthRecord(){ 
		$this->load->model('Client_profile_model'); 
		
		$data = new stdClass(); 

		$data->client_id = $this->input->post('client_id');   
		 
		$c_symptoms=implode(', ',$this->input->post('symptoms'));  
        $data->symptoms = $c_symptoms; 

        $data->closed_contact =(empty($this->input->post('closed_contact')))? '0' : $this->input->post('closed_contact');
         
		$data->date_changed = date('Y-m-d H:i:s');

		$this->Client_profile_model->add_healthRecord($data);	 
		
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function change_password(){ 
		$this->load->model('Client_profile_model'); 
		$this->load->model('User_information_model'); 
		
		$data = new stdClass();
		$client_id = $this->input->post('client_id');
		$data->username = $this->input->post('username');
		$data->password = sha1($this->input->post('new_password'));  

		$this->Client_profile_model->change_password($data, $client_id);
		$data = $this->User_information_model->user_login($data->username, $data->password);
		$this->session->set_userdata('user', $data); 
		//header('Content-Type: application/json');
		//echo json_encode($data);
	}

	public function add_est(){
		$this->load->model('Client_profile_model');
		$password = $this->input->post('password');
		$jsondata = new stdClass();
		$data = new stdClass();
		$data->name = $this->input->post('name');
		$data->address = $this->input->post('address');
		$data->citymunCode = $this->input->post('citymunCode');
		$data->brgyCode = $this->input->post('brgyCode');
		$data->contact_number = $this->input->post('contact_number');
		$data->contact_person = $this->input->post('contact_person');
		$data->username = $this->input->post('username');
		$data->password = sha1($password);
		$data->status = 0;
		$jsondata->error_log = array();

		//check if client is not unique
		$duplicate_est = $this->Client_profile_model->check_duplicate_est($data);
		$duplicate_username = $this->Client_profile_model->check_duplicate_username($data,'establishments');

		if($duplicate_est == true){
			$jsondata->error_log[] = 1;
		}
		if($duplicate_username == true){
			$jsondata->error_log[] = 3;
		}
		if($duplicate_username == false AND $duplicate_est == false){
			//if no duplicate found add client
			$generated_id = $this->Client_profile_model->add($data,'establishments');
			$jsondata->client_info = $this->Client_profile_model->est_info($generated_id);
		}
		$len = strlen($password);

    	$jsondata->password =  substr($password, 0, 1).str_repeat('*', $len - 2).substr($password, $len - 1, 1);

		header('Content-Type: application/json');
		echo json_encode( $jsondata );
	}
}
