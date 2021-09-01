<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Est_reports extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin_est();
		$this->load->model('Clients_model');
        // $this->output->enable_profiler(TRUE);

	}

 	public function index(){
		$this->isAllowed_est();
		$this->data['userdata'] = $this->session->userdata('est_logged_in');
		$this->data['content'] = 'establishment/reports.php';

		$this->load->view('template/establishment', $this->data);
 	}

	public function ajax_list(){
    	$this->load->model('Est_report_model');
        $no = $_POST['start'];
        $list = $this->Est_report_model->get_datatables();

        $data = array();
        foreach ($list as $clients) {
        	$datetime = explode(' ',$clients->datetime);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $clients->fname;
            $row[] = $clients->lname;
            $row[] = $clients->est_visited;
            $row[] = $datetime[0];
            $row[] = $datetime[1]; 
 			$row[] = $clients->sov;
            $data[] = $row;
        }
        $count= $this->Est_report_model->count_filtered();
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" =>  $count,
                        "recordsFiltered" => $count,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function uplb_est()
	{
		$search = $this->input->POST('search');
		$est_id = $this->input->POST('est_id');
		$this->load->model('Est_report_model');
		$data = $this->Est_report_model->est_uplb($search,$est_id);
		echo json_encode($data);
	}
}
