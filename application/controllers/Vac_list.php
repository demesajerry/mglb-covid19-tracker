<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vac_list extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Clients_model');
        //$this->output->enable_profiler(TRUE);
	}

    public function index()
    {
        $this->isLogin_tagger();
        $this->isAllowed_Tagger();
        $this->load->model('Vac_list_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('tagger_logged_in');
        $this->data['content'] = 'vaccination/list';
        $selected_prov = '434';//LAGUNA as initial selected
        $selected_mun = '43411';//LB as initial selected
        $this->data['prov_list'] = $this->General_model->get_province();
        $this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
        $this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
        $this->load->view('template/tagger', $this->data);
    }

    public function disabled_list()
    {
        $this->isLogin_tagger();
        $this->isAllowed_Tagger();
        $this->load->model('Vac_list_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('tagger_logged_in');
        $this->data['content'] = 'vaccination/disabled_list';
        $selected_prov = '434';//LAGUNA as initial selected
        $selected_mun = '43411';//LB as initial selected
        $this->data['prov_list'] = $this->General_model->get_province();
        $this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
        $this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
        $this->load->view('template/tagger', $this->data);
    }

    public function first_vac_scheduler()
    {
        $this->isLogin();
        $this->isAllowed();
        $this->load->model('Vac_list_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('logged_in');
        $this->data['links'] = $this->linkGenerator();
        $this->data['content'] = 'admin/vaccination';
        $this->data['device'] = $this->General_model->list('device');
        $selected_prov = '434';//LAGUNA as initial selected
        $selected_mun = '43411';//LB as initial selected
        $this->data['prov_list'] = $this->General_model->get_province();
        $this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
        $this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
        $this->data['category_group'] = $this->General_model->filter_list('','priority_group','priority_group');
        $this->data['category'] = $this->General_model->filter_list('','priority_group','');
        $this->data['vac_site_list'] = $this->General_model->list('vac_site');
        $this->data['sched_interval'] = $this->General_model->list('sched_interval');
        $this->data['vaccines'] = $this->General_model->list('vaccines');
        $this->data['dose'] = "1";
        $this->data['dose_text'] = "First Dose";
        $this->data['title_page'] = "First Dose Scheduler";
        $this->data['fifth_col'] = "Registration Date";
        if(!empty(array_intersect(array(11, 1), $this->session->userdata('logged_in')->access))){
            $this->data['scheduler_access'] = "1";
        }else{
            $this->data['scheduler_access'] = "0";
        }
        $this->load->view('template/admin', $this->data);
    }

    public function second_vac_scheduler()
    {
        $this->isLogin();
        $this->isAllowed();
        $this->load->model('Vac_list_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('logged_in');
        $this->data['links'] = $this->linkGenerator();
        $this->data['content'] = 'admin/vaccination';
        $this->data['device'] = $this->General_model->list('device');
        $selected_prov = '434';//LAGUNA as initial selected
        $selected_mun = '43411';//LB as initial selected
        $this->data['prov_list'] = $this->General_model->get_province();
        $this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
        $this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
        $this->data['category_group'] = $this->General_model->filter_list('','priority_group','priority_group');
        $this->data['category'] = $this->General_model->filter_list('','priority_group','');
        $this->data['vac_site_list'] = $this->General_model->list('vac_site');
        $this->data['sched_interval'] = $this->General_model->list('sched_interval');
        $this->data['vaccines'] = $this->General_model->list('vaccines');
        $this->data['dose'] = "2";
        $this->data['dose_text'] = "Second Dose";
        $this->data['title_page'] = "Second Dose Scheduler";
        $this->data['fifth_col'] = "First Dose Date";
        if(!empty(array_intersect(array(11, 1), $this->session->userdata('logged_in')->access))){
            $this->data['scheduler_access'] = "1";
        }else{
            $this->data['scheduler_access'] = "0";
        }
        $this->load->view('template/admin', $this->data);
    }


    public function client_today_first()
    {
        $this->isLogin();
        $this->isAllowed();
        $this->load->model('Vac_list_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('logged_in');
        $this->data['links'] = $this->linkGenerator();
        $this->data['content'] = 'vaccination/client_today';
        $this->data['device'] = $this->General_model->list('device');
        $selected_prov = '434';//LAGUNA as initial selected
        $selected_mun = '43411';//LB as initial selected
        $this->data['prov_list'] = $this->General_model->get_province();
        $this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
        $this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
        $where = new stdClass();
        $where->status = 0;
        $this->data['category'] = $this->General_model->filter_list($where,'priority_group','priority_group');
        $this->data['dose'] = "1";
        $this->data['dose_text'] = "First Dose";
        $this->data['title_page'] = "Cliet Today: First Dose";
        $this->data['fifth_col'] = "Registration Date";
        $this->load->view('template/admin', $this->data);
    }

    public function client_today_second()
    {
        $this->isLogin();
        $this->isAllowed();
        $this->load->model('Vac_list_model', '', TRUE);
        $this->load->model('General_model');
        $this->data['userdata'] = $this->session->userdata('logged_in');
        $this->data['links'] = $this->linkGenerator();
        $this->data['content'] = 'vaccination/client_today';
        $this->data['device'] = $this->General_model->list('device');
        $selected_prov = '434';//LAGUNA as initial selected
        $selected_mun = '43411';//LB as initial selected
        $this->data['prov_list'] = $this->General_model->get_province();
        $this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
        $this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
        $where = new stdClass();
        $where->status = 0;
        $this->data['category'] = $this->General_model->filter_list($where,'priority_group','priority_group');
        $this->data['dose'] = "2";
        $this->data['dose_text'] = "Second Dose";
        $this->data['title_page'] = "Cliet Today: Second Dose";
        $this->data['fifth_col'] = "Registration Date";
        $this->load->view('template/admin', $this->data);
    }

	public function view_details($userid= null, $action = null, $dose =null)
	{
		$this->isLogin_tagger();
		$this->isAllowed_Tagger();
		$this->load->model('General_model');
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['userdata'] = $this->session->userdata('tagger_logged_in');
		$this->data['content'] = 'vaccination/view_details.php';
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
        $this->data['adverse_event'] = $this->General_model->list('adverse_event');
        $this->data['vaccinator'] = $this->General_model->list('vaccinator');
        $this->data['vac_site'] = $this->General_model->list('vac_site');
        $this->data['vaccines'] = $this->General_model->list('vaccines');
        $where = new stdClass();
        // $where->status = 0;
        // $where->status = 1;
        $this->data['priority_group'] = $this->General_model->filter_list($where,'priority_group',false);
		$this->data['userid'] = $userid;
        $this->data['action'] = $action;
        $this->data['dose'] = $dose;

		$this->load->view('template/tagger', $this->data);
	}

    public function ajax_list(){
        $this->isLogin_tagger();
        $this->isAllowed_Tagger();
        //$this->output->enable_profiler(TRUE);

        //do not search for verified
        $verified = 2;
        $active = 1;
        $is_disable = 0;
        $dose = $this->input->post('dose');
        $this->load->model('Vac_list_model');
        $rows = $this->Vac_list_model->get_datatables_tagger($active,$verified,$is_disable);
        $data = array();
        $no = $_POST['start'];
        foreach ($rows->list as $clients) {
            $no++;
            $row = array();
            // $row[] = $clients->userid;
            $row[] = trim($clients->lname).', '.trim($clients->fname).' '.trim($clients->mname);
            $row[] = $clients->address.', '.$clients->brgyDesc.' '.$clients->citymunDesc;
            $row[] = $clients->priority_group;
            $row[] = $clients->age;
            $row[] = $clients->comor;
            $row[] = $clients->birthday;
            $row[] = $clients->contact_number; 
            $row[] = $clients->date_reg; 

            $actions='<a href="#" client_id="'.$clients->id.'" class="btn btn-success btn-circle btn-xs validate"><i class="fa fa-eye" title="Validate details"></i></a>  ';
            if(in_array($this->session->userdata('tagger_logged_in')->access,array(1))){
            $actions.='<a href="#" client_id="'.$clients->id.'" dose="1" class="btn btn-info btn-circle btn-xs dose_detail" title="First Dose"><strong>1</strong></a>  ';

            if($this->input->post('dose')!='1'){
                $actions.='<a href="#" client_id="'.$clients->id.'" dose="2" class="btn btn-warning btn-circle btn-xs dose_detail"  title="Second Dose"><strong>2</strong></a>  ';
            }
            $actions.=' <a href="javascript:void(0)" title="View Resbakuna doses" 
                        client_id="'.$clients->id.'")" 
                        name="'.$clients->lname.', '.$clients->fname.'" 
                        class="btn btn-primary btn-circle btn-xs view_dose"><i class="fa fa-syringe fa-lg"></i></a>';
            }
            $actions.='<a href="#" 
                        client_id="'.$clients->id.'" 
                        name="'.$clients->lname.', '.$clients->fname.'" 
                        class="btn btn-danger btn-circle btn-xs disable">
                        <i class="fa fa-ban" title="Disable Client"></i>
                    </a>  ';
            //actions
            $row[] = $actions;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Vac_list_model->count_all($active,$verified),
                        "recordsFiltered" => '20',//$this->Vac_list_model->count_filtered($active,$verified),
                        "data" => $data,
                );
        
            //output to json format
        echo json_encode($output);
    }

    public function ajax_list_disabled(){
        $this->isLogin_tagger();
        $this->isAllowed_Tagger();
        //$this->output->enable_profiler(TRUE);

        //do not search for verified
        $verified = 2;
        $active = 1;
        $is_disable = 1;
        $dose = $this->input->post('dose');
        $this->load->model('Vac_list_model');
        $rows = $this->Vac_list_model->get_datatables_tagger($active,$verified,$is_disable);
        $data = array();
        $no = $_POST['start'];
        foreach ($rows->list as $clients) {
            $no++;
            $row = array();
            $row[] = trim($clients->lname).', '.trim($clients->fname).' '.trim($clients->mname);
            $row[] = $clients->address.', '.$clients->brgyDesc.' '.$clients->citymunDesc;
            $row[] = $clients->priority_group;
            $row[] = $clients->age;
            $row[] = $clients->comor;
            $row[] = $clients->birthday;
            $row[] = $clients->contact_number; 
            $row[] = $clients->date_reg; 

            $actions='<a href="#" client_id="'.$clients->id.'" name="'.$clients->lname.', '.$clients->fname.'" class="btn btn-info btn-circle btn-xs enable"><i class="fa fa-check" title="Disable Client"></i></a>  ';
            //actions
            $row[] = $actions;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Vac_list_model->count_all($active,$verified),
                        "recordsFiltered" => '20',//$this->Vac_list_model->count_filtered($active,$verified),
                        "data" => $data,
                );
        
            //output to json format
        echo json_encode($output);
    }
	public function view_status()
	{
		$id = $this->input->post('id');

 		$this->load->model('Clients_model');
		$data = $this->Clients_model->view_status($id);

		echo json_encode($data);
	} 

	public function ajax_delete($id){
	    $this->Clients_model->delete_by_id($id);

 		$this->load->model('Admin_model');
 		$audit_data = new stdClass();
 		$audit_data->user_id = $this->session->userdata('logged_in')->userid;
 		$audit_data->client_id = $id;
 		$audit_data->datetime = date('Y-m-d H:i:s');
 		$audit_data->action_done = 'Client Deleted';
		$this->Admin_model->add($audit_data,'audit_trail');

	    echo json_encode($id);
  	}

	public function ajax_admin_list(){

		$verified = 2;
		$active = 1;
        $is_disable = 0;
        $dose = $this->input->post('dose');
    	$this->load->model('Vac_list_model');
        $rows = $this->Vac_list_model->get_datatables_admin($active,$verified,$is_disable);
        $data = array();
        $no = $_POST['start'];
        foreach ($rows->list as $clients) {
            $actions='';
        	$first_vac_date = ($clients->first_vac_date!='0000-00-00')?date('F d, Y', strtotime($clients->first_vac_date)):'';
        	$next_vac_date = ($clients->next_vac_date!='0000-00-00')?date('F d, Y', strtotime($clients->next_vac_date)):'';
        	$first_text_status = '';
        	$second_text_status = '';
            if($clients->first_text_status!=null && $dose == '1'){
                $first_text_status = '<i class="fa fa-check"></i>';
            }
            if($clients->second_text_status!=null && $dose == '2'){
                $second_text_status = '<i class="fa fa-check"></i>';
            }
            // if($clients->send_status1=='0'){
            //     $first_text_status = '<p class="text-secondary"><i class="fa fa-circle-o-notch"><i>Pending..</i></p>';
            // }
            // if($clients->send_status1=='1'){
            //     $first_text_status = '<p class="text-success"><b><i class="fa fa-check"></i> Sent</b></p>';
            // }
            // if($clients->send_status1=='2'){
            //     $first_text_status = '<p class="text-danger"><b><i class="fa fa-times"></i>Failed</b></p>';
            // }
            // if($clients->send_status2=='0'){
            //      $second_text_status = '<p class="text-secondary"><i class="fa fa-circle-o-notch"><i>Pending..</p>';
            // }
            // if($clients->send_status2=='1'){
            //      $second_text_status = '<p class="text-success"><b><i class="fa fa-check"></i>Sent!</b></p>';
            // }
            // if($clients->send_status2=='2'){
            //      $second_text_status = '<p class="text-danger"><b><i class="fa fa-times"></i>Failed</b></p>';
            // }
            $no++;
                if($dose == '1'){
                $row = array();
                $row[] = $clients->userid;
                $row[] = $clients->lname.', '.$clients->fname.' '.$clients->mname;
                $row[] = $clients->priority_group.'('.$clients->description.')';
                $row[] = $clients->age;
                $row[] = $clients->brgyDesc;
                $row[] = $clients->comor;
                $row[] = $clients->contact_number; 
                if($clients->date_update=='0000-00-00 00:00:00'){
                    $row[] = $clients->date_reg; 
                }else{
                $row[] = $clients->date_reg."<hr class='slim'>".$clients->date_update; 
                }
                $row[] = $first_vac_date; 
                $row[] = $clients->time_schedule1; 
                $row[] = $first_text_status; 
                $row[] = $clients->reply1; 
                if(!empty(array_intersect(array(11, 1), $this->session->userdata('logged_in')->access))){
                    $actions='<button class="btn btn-primary btn-xs add_schedule" 
        					name="'.$clients->lname.', '.$clients->fname.'" 
        					contact_number="'.$clients->contact_number.'"
                            userid="'.$clients->userid.'"
        					><i class="fa fa-calendar-alt"></i></button>  ';
                }
                if(!empty(array_intersect(array(11, 1,16), $this->session->userdata('logged_in')->access))){
                $actions.='<button class="btn btn-info btn-xs  vac_msg" 
                            name="'.$clients->lname.', '.$clients->fname.'" 
                            contact_number="'.$clients->contact_number.'"
                            vac_date="'.$clients->first_vac_date.'"
                            userid="'.$clients->userid.'"
                            vac_manufacturer="'.$clients->possible_vaccine.'"
                            vac_site="'.$clients->first_vac_site.'"
                            dose="'.$dose.'"
                            ><i class="fa fa-mobile"></i></button> ';
                }
                $actions.='<button class="btn btn-danger btn-xs update1" 
                            userid="'.$clients->userid.'" 
                            contact_number="'.$clients->contact_number.'"
                            name="'.$clients->lname.', '.$clients->fname.'" 
                            reply="'.$clients->reply1.'" 
                            vac_date="'.$clients->first_vac_date.'" 
                            vac_site="'.$clients->first_vac_site.'" 
                            si_id="'.$clients->si_id1.'" 
                            dose="1"
                            title="Update Client"
                            ><i class="fa fa-edit"></i></button> ';
                $actions.='<button class="btn btn-success btn-xs sms_history" 
                            contact_number="'.$clients->contact_number.'"
                            dose="1"
                            title="SMS history"
                            ><i class="fa fa-list"></i></button> ';
                $row[] = $actions;
                $row[] = $clients->first_text_status;
                $row[] = $clients->userid;
                $row[] = $clients->arrival;
            }else{
                $first_dose_date = ($clients->vac_date!='0000-00-00')?date('F d, Y', strtotime($clients->vac_date)):'';
                $row = array();
                $row[] = $clients->userid;
                $row[] = $clients->lname.', '.$clients->fname.' '.$clients->mname;
                $row[] = $clients->priority_group.'('.$clients->description.')';
                $row[] = $clients->age;
                $row[] = $clients->brgyDesc;
                $row[] = $clients->comor;
                $row[] = $clients->contact_number; 
                $row[] =  $first_dose_date;
                $row[] = $next_vac_date; 
                $row[] = $clients->time_schedule2; 
                $row[] = $second_text_status; 
                $row[] = $clients->reply2; 
                if(!empty(array_intersect(array(11, 1), $this->session->userdata('logged_in')->access))){
                    $actions='<button class="btn btn-primary btn-xs add_schedule" 
                            name="'.$clients->lname.', '.$clients->fname.'" 
                            contact_number="'.$clients->contact_number.'"
                            userid="'.$clients->userid.'"
                            vac_manufacturer="'.$clients->vac2.'"
                            ><i class="fa fa-calendar-alt"></i></button>  ';
                }
                if(!empty(array_intersect(array(11, 1), $this->session->userdata('logged_in')->access))){
                $actions.='<button class="btn btn-warning btn-xs  vac_msg" 
                            name="'.$clients->lname.', '.$clients->fname.'" 
                            contact_number="'.$clients->contact_number.'"
                            vac_date="'.$clients->next_vac_date.'"
                            userid="'.$clients->userid.'"
                            vac_site="'.$clients->second_vac_site.'"
                            vac_manufacturer="'.$clients->vac2.'"
                            dose="2"
                            ><i class="fa fa-mobile"></i></button> ';
                }   
                $actions.='<button class="btn btn-danger btn-xs update" 
                            userid="'.$clients->userid.'" 
                            contact_number="'.$clients->contact_number.'"
                            next_vac_date="'.$clients->next_vac_date.'"
                            vac_date="'.$clients->vac_date.'"
                            vac_manufacturer="'.$clients->vac2_id.'"
                            name="'.$clients->lname.', '.$clients->fname.'" 
                            reply="'.$clients->reply2.'" 
                            dose="2"
                            vac_date="'.$clients->next_vac_date.'" 
                            vac_site="'.$clients->second_vac_site.'" 
                            si_id="'.$clients->si_id1.'" 
                            title="Update Client"
                            ><i class="fa fa-edit"></i></button> ';
                $actions.='<button class="btn btn-success btn-xs sms_history" 
                            contact_number="'.$clients->contact_number.'"
                            dose="2"
                            title="SMS history"
                            ><i class="fa fa-list"></i></button> ';
                $row[] = $actions;
                $row[] = $clients->second_text_status;
                $row[] = $clients->userid;
                $row[] = $clients->arrival;
                $row[] = $clients->vac2;
            }
            $row[] = $clients->userid;
            //actions
            $data[] = $row;
        }
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Vac_list_model->count_all($active,$verified),
                    "recordsFiltered" => $this->Vac_list_model->count_filtered($active,$verified,$is_disable),
                    "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function check_sched(){
        $this->load->model('General_model');
        $dose = $this->input->post('dose');
        $vac_site = $this->input->post('vac_site');
        $data = new stdCLass();
        $where = new stdClass();
        if($dose == 1){
            $where->first_vac_date = date('Y-m-d', strtotime($this->input->post('date_sched')));
            $data->total = $this->General_model->count_dynamic($where,'vaccination');
            $where->first_vac_site = $vac_site;
            $data->total_site = $this->General_model->count_dynamic($where,'vaccination');
        }else{
            $where->next_vac_date = date('Y-m-d', strtotime($this->input->post('date_sched')));
            $data->total = $this->General_model->count_dynamic($where,'vaccination');
            $where->second_vac_site = $vac_site;
            $data->total_site = $this->General_model->count_dynamic($where,'vaccination');
        }
        echo json_encode($data);
    }

    public function update_sched(){
        $this->load->model('General_model');
        $dose = $this->input->post('dose');
        $data = new stdClass();
        if($dose == 1){
            $data->first_vac_date = date('Y-m-d', strtotime($this->input->post('date_sched')));
            $data->first_vac_site = $this->input->post('vac_site');
            $data->possible_vaccine = $this->input->post('vac_manufacturer');
        }else{
            $data->next_vac_date = date('Y-m-d', strtotime($this->input->post('date_sched')));
            $data->second_vac_site = $this->input->post('vac_site');
        }

        $where =  new stdClass();
        $where->userid = $this->input->post('userid');

        $this->General_model->update($data,$where,'vaccination');

        echo json_encode($data);
    }

    public function update_arrival(){
        $this->load->model('General_model');
        $userid = $this->input->post('userid');
        $dose = $this->input->post('dose');
        $data = new stdClass();

        $data->arrival = $this->input->post('dose');

        $where =  new stdClass();
        $where->userid = $this->input->post('userid');

        $this->General_model->update($data,$where,'vaccination');

        echo json_encode(1);
    }

    public function get_scheduled_list(){
        $this->load->model('Vac_list_model');
        $schedule = date("Y-m-d", strtotime($this->input->post('schedule')));
        $status = $this->input->post('status');
        $vac_site = $this->input->post('vac_site');
        $dose = $this->input->post('dose');
        $new = $this->input->post('new');
        $vaccine_used = $this->input->post('vaccine_used');

        $data = $this->Vac_list_model->get_scheduled_list($schedule, $dose,$status, $vac_site, $vaccine_used);
        echo json_encode($data);
    }

    public function bulk_sched(){
        $this->load->model('Vac_list_model');
        $this->load->model('General_model');
        $dose = $this->input->post('dose');
        $vac_site = $this->input->post('vac_site');        
        $data = new stdCLass();
        $where = new stdClass();
        if($dose == 1){
            $where->is_disable = '0';
            $where->first_vac_date = date('Y-m-d', strtotime($this->input->post('date_sched')));
            $where->is_vaccinated = '0';
            $data->total = $this->General_model->count_dynamic($where,'vaccination');
            $where->first_vac_site = $vac_site;
            $data->total_site = $this->General_model->count_dynamic($where,'vaccination');
        }else{
            $where->is_disable = '0';
            $where->next_vac_date = date('Y-m-d', strtotime($this->input->post('date_sched')));
            $where->is_vaccinated_second = '0';
            $data->total = $this->General_model->count_dynamic($where,'vaccination');
            $where->second_vac_site = $vac_site;
            $data->total_site = $this->General_model->count_dynamic($where,'vaccination');
        }
        $verified = 2;
        $active = 1;

        $rows =  $this->Vac_list_model->bulk_sched($active,$verified);
        $data->list = $rows;

        echo json_encode($data);
    }


    public function update_bulk_sched(){
        $this->load->model('General_model');
        $userid = $this->input->post('userid');
        $dose = $this->input->post('dose');
        $data = new stdClass();
        foreach($userid as $val){
            if($dose == 1){
                $data->first_vac_date = date('Y-m-d', strtotime($this->input->post('date_sched')));
                $data->first_vac_site = $this->input->post('vac_site');
                $data->possible_vaccine = $this->input->post('vac_manufacturer');
            }else{
                $data->next_vac_date = date('Y-m-d', strtotime($this->input->post('date_sched')));
                $data->second_vac_site = $this->input->post('vac_site');
            }

            $where =  new stdClass();
            $where->userid = $val;
            
            $this->General_model->update($data,$where,'vaccination');
        }

        echo json_encode('1');
    }

    public function reminder_list(){
        $this->load->model('General_model');
        $where = new stdClass();
        $vac_date = explode(' - ',$this->input->post('reminder_date'));
        $where->vac_date = date("Y-m-d", strtotime($vac_date[0]));
        $where->reply = 'YES';
        $data = $this->General_model->get_msg_details($where);
        echo json_encode($data);
    }

    public function update_client(){
        $this->load->model('Vaccination_model');
        $this->load->model('General_model');
        $where = new stdClass();
        $where->id = $this->input->post('userid');

        $data = new stdClass();
        $data->contact_number = $this->input->post('contact_number');
        $this->Vaccination_model->update($data, $where, 'clients');

        $where2 = new stdClass();
        $where2->userid = $this->input->post('userid');

        $data->vac_manufacturer = $this->input->post('vac_manufacturer');
        $data->vac_date = date("Y-m-d", strtotime($this->input->post('first_dose_date')));
        $this->Vaccination_model->update($data, $where2, 'post_vaccination');

        $data->next_vac_date = date("Y-m-d", strtotime($this->input->post('next_vac_date')));
        $this->Vaccination_model->update($data, $where2, 'vaccination');

        $reply = $this->input->post('reply');

        if($reply == 'YES'){
            $where_reply= new stdClass();
            $where_reply->vac_date = $this->input->post('next_vac_date');
            $where_reply->reply = 'YES';
            $where_reply->dose = $this->input->post('dose');
            $where_reply->vac_site = $this->input->post('vac_site');
            $count_yes = $this->General_model->filter_list($where_reply,'sent_messages',false);

            //do not comment
            $with_reply = count($count_yes);

            $check = $this->General_model->get_one_row('sched_interval','si_id',$this->input->post('si_id'));
            //set max number of client for this hour
            $max_interval = $check->max_per_hour;
            //set min number of client for this hour
            $min_interval = 0;
            //set time schedule
            $start_time = $check->start_time;
            //for for if statement start time to end time
            for($i=$check->start_time; $i<=$check->end_time; $i++){
                //if start time equal to 12 add 1 (12 is break time)
                if($start_time == '12'){
                    $start_time++;
                }
                //if count of with reply is less than max interval and greater than min interval
                if($with_reply<$max_interval && $with_reply>=$min_interval){
                    //set time schedule to start_time
                    $time_schedule = $start_time;
                    //exit loop when found the time schedule
                    break;
                }
                //increase start_time / time schedule + hour interval
                $start_time = $start_time+$check->hour_interval;
                //increase min interval + interval
                $min_interval =$min_interval+$check->max_per_hour;
                //increase current max interval + interval
                $max_interval=$max_interval+$check->max_per_hour;
                //$counter++;
            }
            //if yes is greater than max_per_hour * hour
            if($with_reply>=$check->max_client ){
                //set time schedule to start_time
                $time_schedule = $check->over_time;
                //exit loop when found the time schedule
            }

            $data_reply = new stdClass();
            $data_reply->reply = 'YES';
            //convert time 24hours format to 12 hours format
            $data_reply->time_schedule = ltrim(date("h A", strtotime($time_schedule.':00')),"0");

            $where3 = new stdClass();
            $where3->userid = $this->input->post('userid');
            $where3->dose = $this->input->post('dose');
            $where3->contact_number = '0'.substr($this->input->post('contact_number'), -10);
            $this->General_model->update($data_reply,$where3,'sent_messages');

            // $userid =$this->input->post('userid');
            // $dose = $this->input->post('dose');
            // $result = $this->General_model->get_user_details($userid, $dose);


            // $message = 'RESBAKUNA CONFIRMED SCHEDULE:';
            // $message .= "\n".$result[0]->lname.', '.$result[0]->fname;
            // $message .= "\n".date('F d, Y', strtotime($result[0]->vac_date)).' At '. $data->time_schedule;

            // if($this->input->post('vac_site')==1){
            //     $site_text = 'Batong Malake Covered Court';
            // }elseif($this->input->post('vac_site')==2){
            //     $site_text = 'UPLB Copeland';
            // }elseif($this->input->post('vac_site')==3){
            //     $site_text = 'LB Evacuation Center';
            // }

            // $message .= "\n".$site_text;
            // if($result[0]->with_comorbidity == '01_Yes' && $result[0]->age >= '18' && $result[0]->age <="59" && $check[0]->priority_group != 'A1'){
            //     $message .= "\nA3 category bring PROOF of COMORBIDITY";
            // }
            // // if($result[0]->priority_group == 'A1'){
            // //     $message .= "\nA1 category bring PROOF as FRONTLINER";
            // // }
            // //     $message .= "\nThis is NON-TRANSFERABLE";

            //  $this->load->library('../controllers/Sms');
            //  $this->send_text($message,$contact_number,'6');

        }else{
            $data_reply = new stdClass();
            $data_reply->reply = $this->input->post('reply');

            $where3 = new stdClass();
            $where3->userid = $this->input->post('userid');
            $where3->dose = $this->input->post('dose');
            $where3->contact_number = '0'.substr($this->input->post('contact_number'), -10);
            $this->General_model->update($data_reply,$where3,'sent_messages');
        }

        $this->load->model('Admin_model');
        $audit_data = new stdClass();
        $audit_data->user_id = $this->session->userdata('logged_in')->userid;
        $audit_data->client_id = $this->input->post('userid');
        $audit_data->datetime = date('Y-m-d H:i:s');
        $audit_data->action_done = 'Update client reply: '.$this->input->post('reply');
        $audit_data->action_done .= '<br>Number: '.$this->input->post('contact_number');
        $audit_data->action_done .= '<br>vaccine: '.$this->input->post('vac_manufacturer');;
        $audit_data->action_done .= '<br>First Dose: '.$this->input->post('first_dose_date');
        $this->Admin_model->add($audit_data,'audit_trail');

        echo json_encode($where3);
    }

    public function update1_client(){
        $this->load->model('Vaccination_model');
        $this->load->model('General_model');
        $reply = $this->input->post('reply');

        $where = new stdClass();
        $where->id = $this->input->post('userid');

        $data = new stdClass();
        $data->contact_number = $this->input->post('contact_number');
        $this->Vaccination_model->update($data, $where, 'clients');

        $where2 = new stdClass();
        $where2->userid = $this->input->post('userid');
        $data2 = new stdClass();
        $data2->is_disable = $this->input->post('is_disable');
        $data2->a1_vaccinated_status = $this->input->post('a1_vaccinated_status');
        $this->Vaccination_model->update($data2, $where2, 'vaccination');

        if($reply == 'YES'){
            $where_reply= new stdClass();
            $where_reply->vac_date = $this->input->post('vac_date');
            $where_reply->reply = 'YES';
            $where_reply->dose = $this->input->post('dose');
            $where_reply->vac_site = $this->input->post('vac_site');
            $count_yes = $this->General_model->filter_list($where_reply,'sent_messages',false);

            //do not comment
            $with_reply = count($count_yes);

            $check = $this->General_model->get_one_row('sched_interval','si_id',$this->input->post('si_id'));
            //set max number of client for this hour
            $max_interval = $check->max_per_hour;
            //set min number of client for this hour
            $min_interval = 0;
            //set time schedule
            $start_time = $check->start_time;
            //for for if statement start time to end time
            for($i=$check->start_time; $i<=$check->end_time; $i++){
                //if start time equal to 12 add 1 (12 is break time)
                if($start_time == '12'){
                    $start_time++;
                }
                //if count of with reply is less than max interval and greater than min interval
                if($with_reply<$max_interval && $with_reply>=$min_interval){
                    //set time schedule to start_time
                    $time_schedule = $start_time;
                    //exit loop when found the time schedule
                    break;
                }
                //increase start_time / time schedule + hour interval
                $start_time = $start_time+$check->hour_interval;
                //increase min interval + interval
                $min_interval =$min_interval+$check->max_per_hour;
                //increase current max interval + interval
                $max_interval=$max_interval+$check->max_per_hour;
                //$counter++;
            }
            //if yes is greater than max_per_hour * hour
            if($with_reply>=$check->max_client ){
                //set time schedule to start_time
                $time_schedule = $check->over_time;
                //exit loop when found the time schedule
            }

            $data_reply = new stdClass();
            $data_reply->reply = 'YES';
            //convert time 24hours format to 12 hours format
            $data_reply->time_schedule = ltrim(date("h A", strtotime($time_schedule.':00')),"0");

            $where3 = new stdClass();
            $where3->userid = $this->input->post('userid');
            $where3->dose = $this->input->post('dose');
            $where3->contact_number = '0'.substr($this->input->post('contact_number'), -10);
            $this->General_model->update($data_reply,$where3,'sent_messages');
        }else{
            $data_reply = new stdClass();
            $data_reply->reply = $this->input->post('reply');

            $where3 = new stdClass();
            $where3->userid = $this->input->post('userid');
            $where3->dose = $this->input->post('dose');
            $where3->contact_number = '0'.substr($this->input->post('contact_number'), -10);
            $this->General_model->update($data_reply,$where3,'sent_messages');
        }

        $this->load->model('Admin_model');
        $audit_data = new stdClass();
        $audit_data->user_id = $this->session->userdata('logged_in')->userid;
        $audit_data->client_id = $this->input->post('userid');
        $audit_data->datetime = date('Y-m-d H:i:s');
        $audit_data->action_done = 'Update client reply: '.$this->input->post('reply');
        $audit_data->action_done .= '<br>Number: '.$this->input->post('contact_number');
        $audit_data->action_done .= '<br>disable: '.$this->input->post('is_disable');
        $audit_data->action_done .= '<br>already Vaccinated: '.$this->input->post('a1_vaccinated_status');
        $this->Admin_model->add($audit_data,'audit_trail');

        echo json_encode(1);
    }


    public function disable(){
        $this->load->model('General_model');
        $client_id = $this->input->post('client_id');
        $data = new stdClass();
        $data->is_disable = '1';

        $where =  new stdClass();
        $where->userid = $this->input->post('client_id');

        $this->General_model->update($data,$where,'vaccination');

        echo json_encode($data);
    }

    public function enable(){
        $this->load->model('General_model');
        $client_id = $this->input->post('client_id');
        $data = new stdClass();
        $data->is_disable = '0';

        $where =  new stdClass();
        $where->userid = $this->input->post('client_id');

        $this->General_model->update($data,$where,'vaccination');

        echo json_encode($data);
    }

    public function list_client_today(){

        $verified = 2;
        $active = 1;
        $is_disable = 0;
        $dose = $this->input->post('dose');
        $this->load->model('Vac_list_model');
        $rows = $this->Vac_list_model->get_datatables_admin($active,$verified,$is_disable);
        $data = array();
        $no = $_POST['start'];
        foreach ($rows->list as $clients) {
            $first_vac_date = ($clients->first_vac_date!='0000-00-00')?date('F d, Y', strtotime($clients->first_vac_date)):'';
            $next_vac_date = ($clients->next_vac_date!='0000-00-00')?date('F d, Y', strtotime($clients->next_vac_date)):'';
            $first_text_status = '';
            $second_text_status = '';
            if($clients->first_text_status!=null && $dose == '1'){
                $first_text_status = '<i class="fa fa-check"></i>';
            }
            if($clients->second_text_status!=null && $dose == '2'){
                $second_text_status = '<i class="fa fa-check"></i>';
            }
            $no++;
                if($dose == '1'){
                $row = array();
                $row[] = $clients->lname.', '.$clients->fname.' '.$clients->mname;
                $row[] = $clients->brgyDesc;
                $row[] = $clients->age;
                $row[] = $clients->comor;
                $row[] = $clients->contact_number; 
                $row[] = $clients->date_reg; 
                $row[] = $first_vac_date; 
                $row[] = $clients->time_schedule1; 
                $row[] = $first_text_status; 
                $row[] = $clients->reply1; 
                $actions='<button class="btn btn-info btn-xs arrived" 
                            userid="'.$clients->userid.'" 
                            client_name="'.$clients->lname.', '.$clients->fname.' '.$clients->mname.'" 
                            dose="1"
                            title="Tag client as arrived"
                            ><i class="fa fa-check"></i></button> ';
                $row[] = $actions;
                $row[] = $clients->first_text_status;
                $row[] = $clients->userid;
                $row[] = $clients->arrival;
            }else{
                $first_dose_date = ($clients->vac_date!='0000-00-00')?date('F d, Y', strtotime($clients->vac_date)):'';
                $row = array();
                $row[] = $clients->lname.', '.$clients->fname.' '.$clients->mname;
                $row[] = $clients->brgyDesc;
                $row[] = $clients->age;
                $row[] = $clients->comor;
                $row[] = $clients->contact_number; 
                $row[] =  $first_dose_date;
                $row[] = $next_vac_date; 
                $row[] = $clients->time_schedule2; 
                $row[] = $second_text_status; 
                $row[] = $clients->reply2; 

                $actions='<button class="btn btn-info btn-xs arrived" 
                            userid="'.$clients->userid.'" 
                            client_name="'.$clients->lname.', '.$clients->fname.' '.$clients->mname.'" 
                            dose="2"
                            title="Tag client as arrived"
                            ><i class="fa fa-check"></i></button> ';
                $row[] = $actions;
                $row[] = $clients->second_text_status;
                $row[] = $clients->userid;
                $row[] = $clients->arrival;
                $row[] = $clients->vac2;
            }
            $row[] = $clients->userid;
            //actions
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Vac_list_model->count_all($active,$verified),
                        "recordsFiltered" => $rows->count,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function get_doses(){
        $this->load->model('General_model');
        $userid = $this->input->post('userid');

        $where = new stdClass();
        $where->userid = $userid;

        $data = $this->General_model->get_doses($where,'post_vaccination',false);

        echo json_encode($data);
    }

    public function delete_dose(){
        $this->load->model('General_model');
        $userid = $this->input->post('userid');
        $dose = $this->input->post('dose');
        $post_vac_id = $this->input->post('post_vac_id');
        //delete post vac detail
        $this->General_model->delete($post_vac_id,'post_vac_id','post_vaccination');

        $where = new stdClass();
        $where->userid = $userid;
        $data = new stdClass();
        if($dose == 1){
            $data->first_vac_date = '0000-00-00';
            $data->is_vaccinated = 0;
            $data->possible_vaccine = '';
        }
        if($dose == 2){
            $data->next_vac_date = '0000-00-00';
            $data->is_vaccinated_second = 0;
        }
        $this->General_model->update($data,$where,'vaccination');

        echo json_encode($dose);
    }

    public function merge_dose(){
        $this->load->model('General_model');
        $merge_userid = $this->input->post('merge_userid');
        $current_userid = $this->input->post('current_userid');
        $dose = $this->input->post('dose');
        $post_vac_id = $this->input->post('post_vac_id');
        $vac_date = $this->input->post('vac_date');

        $data = new stdClass();
        if($dose == 1){
            $data->first_vac_date = '0000-00-00';
            $data->is_vaccinated = 0;
        }
        if($dose == 2){
            $data->next_vac_date = '0000-00-00';
            $data->is_vaccinated_second = 0;
        }

        $where = new stdClass();
        $where->userid = $current_userid;

        $this->General_model->update($data,$where,'vaccination');

        $data2 = new stdClass();
        if($dose == 1){
            $data2->first_vac_date = $vac_date;
            $data2->is_vaccinated = 1;
        }
        if($dose == 2){
            $data2->next_vac_date = $vac_date;
            $data2->is_vaccinated_second = 1;
        }

        $where2 = new stdClass();
        $where2->userid = $merge_userid;

        $this->General_model->update($data2,$where2,'vaccination');

        $data3 = new stdClass();
        $data3->userid = $merge_userid;

        $where3 = new stdClass();
        $where3->post_vac_id = $post_vac_id;

        $this->General_model->update($data3,$where3,'post_vaccination');

        echo json_encode($dose);
    }

}
