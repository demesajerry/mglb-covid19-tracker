<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Duplicate_clients extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
		$this->load->model('Clients_model');
	}
	public function index(){
		$this->isAllowed();
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'clients/duplicate';
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['citymun_list'] = $this->Clients_model->get_citymun_list();
		$this->load->view('template/admin', $this->data);
	}

	public function duplicate_list(){
		//$this->output->enable_profiler(TRUE);

		//do not search for verified
		$verified = 2;
		$active = 1;
    	$this->load->model('Duplicate_clients_model');
        $list = $this->Duplicate_clients_model->get_datatables($active,$verified);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $clients) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $clients->lname.', '.$clients->fname.' '.$clients->mname;
            $row[] = $clients->address.', '.$clients->brgyDesc.' '.$clients->citymunDesc;
            $row[] = $clients->birthday;
            $row[] = $clients->contact_number; 
            $row[] = $clients->num; 

    		$actions='<a class="view_dup" href="javascript:void(0)" title="View Duplicate" onclick="view_dup('."'".$clients->fname."'".','."'".$clients->lname."'".')"><i class="fa fa-eye fa-lg"></i></a> |';
	    	if(!empty(array_intersect(array(1), $this->session->userdata('logged_in')->access))){
			$actions.=' <a class="delete_client" href="javascript:void(0)" title="Delete" onclick="delete_client('."'".$clients->id."'".')"><i class="fa fa-trash fa-lg"></i></a>|';
	    	}
            //actions
            $row[] = $actions;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Duplicate_clients_model->count_all($active,$verified),
                        "recordsFiltered" => $this->Duplicate_clients_model->count_filtered($active,$verified),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    public function search(){
    	$where = new stdClass();
    	foreach($_POST as $key=>$val){
    		$where->{$key} = $val;
    	}

    	$this->load->model('Duplicate_clients_model');
    	$json = new stdClass();
		$json->data = $this->Duplicate_clients_model->search($where);

        echo json_encode($json);

    }

    public function search_vac(){
    	$where = new stdClass();
    	foreach($_POST as $key=>$val){
    		$where->{$key} = $val;
    	}

    	$this->load->model('Duplicate_clients_model');
    	$json = new stdClass();
		$json->data = $this->Duplicate_clients_model->search($where);
		$json->data_post = $this->Duplicate_clients_model->search_postvac($where);

        echo json_encode($json);

    }

    public function update(){
    	$data = new stdClass();
    	$data->userid = $this->input->post('userid');

    	$where = new stdClass();
    	$where->userid = $this->input->post('userid_orig');

    	$this->load->model('General_model');
    	$this->load->model('Duplicate_clients_model');

		//update vaccination
		$this->General_model->update($data,$where,'vaccination');
		//update post_vaccination
		$this->General_model->update($data,$where,'post_vaccination');

		$json = $this->Duplicate_clients_model->search($data);

        echo json_encode($json);
    }

    public function disable_vaccination(){
        $data = new stdClass();
        $data->is_disable = 1;

        $where = new stdClass();
        $where->vac_id = $this->input->post('vac_id');

        $this->load->model('General_model');
        $this->load->model('Duplicate_clients_model');

        $jsondata = $this->Duplicate_clients_model->search($where);

        $this->General_model->update($data,$where,'vaccination');

        echo json_encode($jsondata[0]);
    }
    public function enable_vaccination(){
        $data = new stdClass();
        $data->is_disable = "0";

        $where = new stdClass();
        $where->vac_id = $this->input->post('vac_id');

        $this->load->model('General_model');
        $this->load->model('Duplicate_clients_model');
        $jsondata = $this->Duplicate_clients_model->search($where);

        $this->General_model->update($data,$where,'vaccination');

        echo json_encode($jsondata[0]);
    }
}
