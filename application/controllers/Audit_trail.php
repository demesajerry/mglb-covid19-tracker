<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_trail extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
		$this->load->model('Audit_trail_model');
	}

	public function index()
	{
		$this->isAllowed();
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'admin/audit_trail';
		$this->load->view('template/admin', $this->data);
	}

	public function list(){
        $table_name = $this->input->post('table_name');
        $this->load->model('Audit_trail_model');
        $data_list = $this->Audit_trail_model->get_datatables($table_name);
        $data = array();
        $no = $_POST['start'];
        foreach ($data_list->list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->fname.', '.$val->lname;
            $row[] = $val->client_id;
            $row[] = $val->datetime;
            $row[] = $val->action_done;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Audit_trail_model->count_all($table_name),
                        "recordsFiltered" => $data_list->count,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
}
