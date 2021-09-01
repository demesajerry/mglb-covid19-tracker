<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classifications extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
	}

	public function index()
	{
		$this->list();
	}

	public function list()
	{
		$this->isAllowed();
		$this->load->model('Classifications_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'classifications/list';
		$this->data['covidStatus_list'] = $this->Classifications_model->get_covidStatus_list();
		$this->load->view('template/admin', $this->data);
	}

	public function add_classifications()
	{
		$this->load->model('Classifications_model', '', TRUE);
		 
		$data = array();
		$data["c_classification"] = $this->input->post('c_classification'); 
		$data["template"] = $this->input->post('template'); 
		$data["status"] = $this->input->post('status'); 
		$c_status_id = $this->Classifications_model->add_classifications($data); 
		redirect(site_url("Classifications/list"));
	}

	public function edit_classifications()
	{
		$this->load->model('Classifications_model', '', TRUE);
 
		$data = array();
		$data["c_classification"] = $this->input->post('c_classification');  
		$data["template"] = $this->input->post('template'); 
		$data["status"] = $this->input->post('status'); 
		$c_status_id = $this->input->post('c_status_id'); 

		$this->Classifications_model->edit_classifications($data,$c_status_id);

		redirect(site_url("Classifications/list"));
	}

}
