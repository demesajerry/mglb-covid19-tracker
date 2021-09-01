<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
		$this->load->model('Clients_model');
	}

	public function index()
	{
		$this->isAllowed();
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'clients/list';
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['citymun_list'] = $this->Clients_model->get_citymun_list();
		$this->data['clients_list'] = $this->Clients_model->get_clients_list();
		$this->data['status_list'] = $this->Clients_model->get_status_list();
		$this->data['est_list'] = $this->Clients_model->get_est_list();
		$this->load->view('template/admin', $this->data);
	}

	public function verify()
	{
		$this->isAllowed();
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'clients/for_verification';
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['citymun_list'] = $this->Clients_model->get_citymun_list();
		$this->data['clients_list'] = $this->Clients_model->get_clients_list();
		$this->data['status_list'] = $this->Clients_model->get_status_list();
		$this->load->view('template/admin', $this->data);
	}

	public function disabled()
	{
		$this->isAllowed();
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'clients/disabled';
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['citymun_list'] = $this->Clients_model->get_citymun_list();
		$this->data['clients_list'] = $this->Clients_model->get_clients_list();
		$this->data['status_list'] = $this->Clients_model->get_status_list();
		$this->load->view('template/admin', $this->data);
	}

	public function ajax_list(){
		//$this->output->enable_profiler(TRUE);

		//do not search for verified
		$verified = 2;
		$active = 1;
    	$this->load->model('Clients_model');
        $list = $this->Clients_model->get_datatables($active,$verified);
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
	    	if(!empty(array_intersect(array(1,3), $this->session->userdata('logged_in')->access))){
	            if($clients->status == 5 ){
	                $row[] = 
	                    '<a class="update_stats" href="javascript:void(0)" title="View" onclick="update_stats('."'".$clients->id."'".')"><div class="btn btn-danger"> '.$clients->c_classification.'</div>
	                    </a>';
	            }
	            elseif($clients->status == 4 ){
	                $row[] = 
	                    '<a class="update_stats" href="javascript:void(0)" title="View" onclick="update_stats('."'".$clients->id."'".')"><div class="btn btn-success"> '.$clients->c_classification.'</div>
	                    </a>';
	            }
	            elseif($clients->status == 3 ){
	                $row[] = 
	                    '<a class="update_stats" href="javascript:void(0)" title="View" onclick="update_stats('."'".$clients->id."'".')"><div class="btn btn-warning"> '.$clients->c_classification.'</div>
	                    </a>';
	            }
	            elseif($clients->status == 2 ){
	                $row[] = 
	                    '<a class="update_stats" href="javascript:void(0)" title="View" onclick="update_stats('."'".$clients->id."'".')"><div class="btn btn-warning"> '.$clients->c_classification.'</div>
	                    </a>';
	            }
	            else {
	                 $row[] = 
	                    '<a class="update_stats" href="javascript:void(0)" title="View" onclick="update_stats('."'".$clients->id."'".')"><div class="btn btn-default"> '.$clients->c_classification.'</div>
	                    </a>';
	            }
	        }else{
                 $row[] = '******';
	        }

    		$actions='<a class="edit_stats" href="javascript:void(0)" title="Edit" onclick="edit_stats('."'".$clients->id."'".')"><i class="fa fa-edit fa-lg"></i></a> |';
	    	if(!empty(array_intersect(array(1,2,6), $this->session->userdata('logged_in')->access))){
			$actions.=' <a class="reset_password" href="javascript:void(0)" title="Reset Password" id="reset_password" client_id="'.$clients->id.'")"><i class="fa fa-key fa-lg"></i></a> |';
	    	}
	    	if(!empty(array_intersect(array(1), $this->session->userdata('logged_in')->access))){
			$actions.=' <a class="delete_client" href="javascript:void(0)" title="Delete" onclick="delete_client('."'".$clients->id."'".')"><i class="fa fa-trash fa-lg"></i></a>|';
	    	}
	    	if(!empty(array_intersect(array(1,3), $this->session->userdata('logged_in')->access))){
			$actions.=' <a id="view_status" href="javascript:void(0)" title="View Status History" client_id="'.$clients->id.'")"><i class="fa fa-address-book fa-lg"></i></a>';
	    	}
            //actions
            $row[] = $actions;
 			$row[]=$clients->end_quarantine;
 			$row[]=$clients->stats_id;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Clients_model->count_all($active,$verified),
                        "recordsFiltered" => $this->Clients_model->count_filtered($active,$verified),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

	public function verify_list(){
		//list all unverified clients
		$verified = 0;
		$active = 1;
    	$this->load->model('Clients_model');
        $list = $this->Clients_model->get_datatables($active,$verified);
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
            $row[] = '<a class="edit_stats" href="javascript:void(0)" title="Edit" onclick="edit_stats('."'".$clients->id."'".')"><i class="fa fa-edit fa-lg"></i></a>'
                ;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Clients_model->count_all($active,$verified),
                        "recordsFiltered" => $this->Clients_model->count_filtered($active,$verified),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

	public function disabled_list(){
		//list all unverified clients
		$verified = 2;
		$active = 0;
    	$this->load->model('Clients_model');
        $list = $this->Clients_model->get_datatables($active,$verified);
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
            $row[] = '<a class="edit_stats" href="javascript:void(0)" title="Edit" onclick="edit_stats('."'".$clients->id."'".')"><i class="fa fa-edit fa-lg"></i></a>'
                ;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Clients_model->count_all($active,$verified),
                        "recordsFiltered" => $this->Clients_model->count_filtered($active,$verified),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
	{
		$data = $this->Clients_model->get_by_id($id);
		echo json_encode($data);
	} 

	public function ajax_update()
	{
		$id = $this->input->post('id');
		$exemption = $this->input->post('exemption');

		$data = array(
			'lname' => $this->input->post('lname'),
			'fname' => $this->input->post('fname'),
			'mname' => $this->input->post('mname'),
			'username' => $this->input->post('username'),
			'address' => $this->input->post('address'),
			'provCode' => $this->input->post('update_provCode'),
			'citymunCode' => $this->input->post('update_citymunCode'),
			'brgyCode' => $this->input->post('update_brgyCode'),
			'birthday' => $this->input->post('birthday'),
			'contact_number' => $this->input->post('contact_number'),
			'sex' => $this->input->post('sex'),  
			'pow' => $this->input->post('pow'), 
			'qrcode' => $this->input->post('qrcode'), 
			'oddeven_exemption' => $this->input->post('oddeven_exemption'), 
			//'image_path' => $imageName,
		);
		$active = $this->input->post('active');
		$verify = $this->input->post('verify');
		if(isset($active)){
			$data += ['active' => $this->input->post('active')];
		}
		if(isset($verify)){
			$data += ['verified' => $this->input->post('verify')];
		}

 		$this->load->model('Clients_model');
		$this->Clients_model->update(array('id' => $this->input->post('id')), $data);
		$this->Clients_model->delete_exemption($id);
		
		// if(!empty($exemption)){
		// 	foreach($exemption as $val){
		// 		$data_exemption[] = array(
		// 		           'client_id' => $id,
		// 		           'est_id' => $val,
		// 		       	);
		// 	}
		// 	$this->Clients_model->add_exemption($data_exemption);
		// }
		if(!isset($active) && !isset($verify)){
	 		$this->load->model('Admin_model');
	 		$audit_data = new stdClass();
	 		$audit_data->user_id = $this->session->userdata('logged_in')->userid;
	 		$audit_data->client_id = $id;
	 		$audit_data->datetime = date('Y-m-d H:i:s');
	 		$audit_data->action_done = 'details updated';
			$this->Admin_model->add($audit_data,'audit_trail');
	 	}

		echo json_encode($data);
	} 

	public function ajax_inactive($id)
	{
		$this->load->model('Clients_model');
		$data = array(
			'active' => 2, 
		);
		$this->Clients_model->inactive_client(array('id' => $id), $data);

 		$this->load->model('Admin_model');
 		$audit_data = new stdClass();
 		$audit_data->user_id = $this->session->userdata('logged_in')->userid;
 		$audit_data->client_id = $id;
 		$audit_data->datetime = date('Y-m-d H:i:s');
 		$audit_data->action_done = 'Client Inactivated';
		$this->Admin_model->add($audit_data,'audit_trail');

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

	public function ajax_update_status()
	{
	    $id = $this->input->post('id');
		$status = $this->input->post('status');
		$validate_password = $this->input->post('validate_password');
		$password = $this->input->post('password');
		$date = $this->input->post('date');
		$encoder = $this->input->post('encoder');
		$end_quarantine = $this->input->post('end_quarantine');
		$former_status = $this->input->post('former_status');

		if((password_verify($validate_password, $password)) || $status == '1'){
			$this->load->model('Clients_model');
			$data = array(
				'status' => $status, 
			);
			$this->Clients_model->update(array('id' => $id), $data);

			$data2 = array(
				'client_id' => $id,
				'status_id' => $status,
				'date_changed' => $date,
				'changed_by' => $encoder, 
				'end_quarantine' => $end_quarantine, 
				'former_status' => $former_status, 
			);  
			$this->Clients_model->save_status($data2);
		}else{
			$data = array(
				'status' => false, 
			);
		}

		echo json_encode($data);
	}  
	public function search_covidStats(){
		$this->load->model('Clients_model');	
		$covidStats = $this->input->POST('view_covid_status');
		$status_display = $this->Clients_model->search_covidStats($covidStats);
		echo json_encode($status_display);
	}
	public function reset_password()
	{
		$id = $this->input->post('id');
		$data = array(
			'password' => sha1('covid19'),
		);

 		$this->load->model('Clients_model');
		$this->Clients_model->update(array('id' => $this->input->post('id')), $data);

 		$this->load->model('Admin_model');
 		$audit_data = new stdClass();
 		$audit_data->user_id = $this->session->userdata('logged_in')->userid;
 		$audit_data->client_id = $id;
 		$audit_data->datetime = date('Y-m-d H:i:s');
 		$audit_data->action_done = 'Password Reset';
		$this->Admin_model->add($audit_data,'audit_trail');

		echo json_encode($data);
	} 
	public function view_status()
	{
		$id = $this->input->post('id');

 		$this->load->model('Clients_model');
		$data = $this->Clients_model->view_status($id);

		echo json_encode($data);
	} 
	public function update_eoq()
	{
		$update = new stdClass();
		$stats_id = $this->input->post('stats_id');
		$update->end_quarantine = $this->input->post('eoq_update');
		$id = $this->input->post('id');

 		$this->load->model('Admin_model');
		$this->Admin_model->edit($update,$stats_id,'client_status','stats_id');
		$data = new stdClass();
		$data->message = 'Update Success';

 		$audit_data = new stdClass();
 		$audit_data->user_id = $this->session->userdata('logged_in')->userid;
 		$audit_data->client_id = $id;
 		$audit_data->datetime = date('Y-m-d H:i:s');
 		$audit_data->action_done = 'Update End of Quarantine, stats_id = '.$stats_id;
		$this->Admin_model->add($audit_data,'audit_trail');

		echo json_encode($data);
	} 
}
