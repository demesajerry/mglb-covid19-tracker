<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vac_card extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

    public function index()
    {
        $this->isLogin();
        $this->isAllowed();
        $this->load->model('Vac_card_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('logged_in');
        $this->data['links'] = $this->linkGenerator();
        $this->data['content'] = 'vac_card/index';
        $selected_prov = '434';//LAGUNA as initial selected
        $selected_mun = '43411';//LB as initial selected
        $this->data['prov_list'] = $this->General_model->get_province();
        $this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
        $this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
        $this->load->view('template/admin', $this->data);
    }

    public function print()
    {
        $this->isLogin();
        // $this->isAllowed();
        $this->load->model('Vac_card_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('logged_in');
        $this->data['links'] = $this->linkGenerator();
        $this->data['content'] = 'vac_card/print';
        $this->load->model('Vac_card_model');
        $userid = $this->input->post('userid');
        $this->data['details'] = $this->Vac_card_model->get_details($userid);
        $check = $this->Vac_card_model->list($this->data['details']->id_no);
        if(count($check)==0){
            $vac_card = new stdClass();
            $vac_card->vac_id = $this->data['details']->id_no;
            $vac_card->hash = bin2hex(random_bytes(5));
            $this->General_model->add($vac_card,'vac_card');
            $this->data['hash'] = $vac_card->hash;
        }else{
            $where = new stdClass();
            $where->id = $check[0]->id;
            $table = 'vac_card';
            //update print count
            $this->Vac_card_model->update($where,$table);
            $this->data['hash'] = $check[0]->hash;
        }
        
        $this->load->view('template/print_head', $this->data);
    }

    public function print_vc()
    {
        $this->isLogin();
        // $this->isAllowed();
        $this->load->model('Vac_card_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('logged_in');
        $this->data['links'] = $this->linkGenerator();
        $this->data['content'] = 'vac_card/print_vc';
        $this->load->model('Vac_card_model');
        $userid = $this->input->post('userid');
        $this->data['details'] = $this->Vac_card_model->get_details($userid);
        $check = $this->Vac_card_model->list($this->data['details']->id_no);
        if(count($check)==0){
            $vac_card = new stdClass();
            $vac_card->vac_id = $this->data['details']->id_no;
            $vac_card->hash = bin2hex(random_bytes(5));
            $this->General_model->add($vac_card,'vac_card');
            $this->data['hash'] = $vac_card->hash;
        }else{
            $where = new stdClass();
            $where->id = $check[0]->id;
            $table = 'vac_card';
            //update print count
            $this->Vac_card_model->update($where,$table);
            $this->data['hash'] = $check[0]->hash;
        }
        
        $this->load->view('template/print_head', $this->data);
    }
	public function get_list(){

		$verified = 2;
		$active = 1;
        $is_disable = 0;
        $dose = $this->input->post('dose');
    	$this->load->model('Vac_card_model');
        $rows = $this->Vac_card_model->get_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($rows->list as $clients) {
			$actions='';
            $no++;
            $row = array();
            $row[] = $clients->lname;
            $row[] = $clients->fname;
            $row[] = $clients->mname;
            $row[] = $clients->brgyDesc;
            $row[] = $clients->age;
            $row[] = $clients->contact_number; 
            $actions.='<button class="btn btn-primary btn-xs print" 
					fullname="'.$clients->lname.', '.$clients->fname.'" 
                    userid="'.$clients->userid.'"
					><i class="fa fa-print"></i></button>  ';
			$row[] = $actions;
	        $data[] = $row;
		}

        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Vac_card_model->count_all(),
                    "recordsFiltered" => $this->Vac_card_model->count_filtered(),
                    "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
}