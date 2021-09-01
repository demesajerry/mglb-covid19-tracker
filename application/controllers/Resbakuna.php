<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resbakuna extends MY_Controller {

	public function __construct() {
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		//$this->load->model('patients_model', '', TRUE);
	}
	public function validate($id_no = false, $hash = false){
		$this->load->model('Resbakuna_model');
		$this->data['content'] = 'resbakuna/index.php';
		$table = 'vaccination';
		$id_name = 'vac_id';
		$id = $id_no;
		$details = $this->Resbakuna_model->get_details($id,$hash);
		$this->data['details'] = $details;
		$this->load->view('template/public', $this->data);
	}
 }
