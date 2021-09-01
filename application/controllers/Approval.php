<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
		$this->load->model('Approval_model');
	}

	public function index()
	{
		$this->list();
	}

	public function list()
	{
		$this->load->model('Approval_model', '', TRUE);
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'approval/list';
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['citymun_list'] = $this->Approval_model->get_citymun_list();
		$this->data['status_list'] = $this->Approval_model->get_status_list();
		$this->load->view('template/admin', $this->data);
	}

	public function ajax_list(){
    	$this->load->model('Approval_model');
        $list = $this->Approval_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $clients) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $clients->lname.', '.$clients->fname.' '.$clients->mname;
            $row[] = $clients->address.' '.$clients->brgyDesc.' '.$clients->citymunDesc;
            $row[] = $clients->birthday;
            $row[] = $clients->contact_number; 
            $row[] = $clients->c_classification; 
            //actions
            $row[] = '<a class="approve_registration" href="javascript:void(0)" title="Approve" onclick="approve_registration('."'".$clients->id."'".')"><i class="fa fa-check fa-lg"></i></a>'
                ;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Approval_model->count_all(),
                        "recordsFiltered" => $this->Approval_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
	{
		$data = $this->Approval_model->get_by_id($id);
		echo json_encode($data);
	} 

	public function ajax_update()
	{
		$id = $this->input->post('id');
		 
		$data = array(
			'active' => 1,
		);

 		$this->load->model('Approval_model');
		$this->Approval_model->update(array('id' => $id), $data);

		echo json_encode($data);
	} 
}
