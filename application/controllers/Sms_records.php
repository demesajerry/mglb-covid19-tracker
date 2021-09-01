<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_records extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
		$this->load->model('Sms_records_model');
	}

	public function index()
	{
		$this->isAllowed();
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'admin/sms_records';
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
        $this->data['device'] = $this->General_model->list('device');
        $this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['citymun_list'] = $this->Clients_model->get_citymun_list();
		$this->data['clients_list'] = $this->Clients_model->get_clients_list();
		$this->data['status_list'] = $this->Clients_model->get_status_list();
		$this->load->view('template/admin', $this->data);
	}

	public function list(){
        $data_list = $this->Sms_records_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_list->list as $val) {
        	$action = ($val->action=='1')?'<p class="text-info">Received</p>':'<p class="text-success">Sent</p>';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->device;
            $row[] = $val->number;
            $row[] = $val->message;
            $row[] = $action;
            $row[] = date('F d, Y', strtotime($val->date));
            $row[] = $val->time;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Sms_records_model->count_all(),
                        "recordsFiltered" => $data_list->count,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function client_reply()
    {
        $this->load->model('General_model');
        $where = new stdClass();
        $where->number = '0'.substr($this->input->post('contact_number'), -10);
        // $where->dose = $this->input->post('dose');
        $data = $this->General_model->filter_list($where,'sms','');

        echo json_encode($data);
    }
}
