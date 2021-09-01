<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Health_declaration extends MY_Controller {

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
		// $this->dashboard();
		$this->load->model('General_model');
		$this->load->model('Clients_model');
		$this->data['userdata'] = $this->session->userdata('user');
		$id = $this->session->userdata('user')['id'];
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['status_list'] = $this->Clients_model->get_status_list();
		$this->data['symptoms_list'] = $this->Clients_model->get_symptoms_list();
		$this->data['healthRecord_table'] = $this->Clients_model->get_healthRecord_table($id);
		$this->data['closed_contact_table'] = $this->Clients_model->get_closed_contact_table($id);
		$this->data['content'] = 'health_declaration/index.php';
		$this->load->view('template/public', $this->data);
	}
 
	public function add()
	{
		$data = new stdClass();
		
		$data->client_id = $this->input->post('client_id');
		$data->symptoms = $this->input->post('symptoms');
		$data->onset_date = $this->input->post('onset_date');
		$data->date_recovered = $this->input->post('date_recovered');
		 
		$data->date_changed = date('Y-m-d H:i:s');  

		$this->load->model('Health_declaration_model'); 		
		$this->Health_declaration_model->add($data);
		redirect(site_url("Health_declaration/index"));	
	}

	public function add_closed_contact()
	{
		$data = new stdClass();
		
		$data->closed_client_id = $this->input->post('closed_client_id');
		$data->closed_contact_date = $this->input->post('closed_contact_date');
		$data->date_added = date('Y-m-d H:i:s');   

		$this->load->model('Health_declaration_model'); 		
		$this->Health_declaration_model->add_closed_contact($data);
		redirect(site_url("Health_declaration/index"));	
	}


	public function edit()
	{
		$data = new stdClass();

		$data->client_id = $this->input->post('client_id');
		$data->symptoms = $this->input->post('symptoms');
		$data->onset_date = $this->input->post('onset_date');
		$data->date_recovered = $this->input->post('date_recovered');
		//$data->date_changed = date('Y-m-d H:i:s'); 

		$symptom_id = $this->input->post('symptom_id');
		$this->load->model('Health_declaration_model');		
		$this->Health_declaration_model->edit($data,$symptom_id);
		redirect(site_url("Health_declaration/index"));	
	}

	public function edit_closed_contact()
	{
		$data = new stdClass();

		$data->closed_client_id = $this->input->post('closed_client_id');
		$data->closed_contact_date = $this->input->post('closed_contact_date');
		$data->date_added = date('Y-m-d H:i:s');

		$closed_contact_id = $this->input->post('closed_contact_id');
		$this->load->model('Health_declaration_model');		
		$this->Health_declaration_model->edit_closed_contact($data,$closed_contact_id);
		redirect(site_url("Health_declaration/index"));	
	}
 
}
