<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
	}

	public function scanner()
	{
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'admin/scanner';
		//$this->data['est_list'] = $this->Admin_model->list('establishments');
		$this->load->view('template/admin', $this->data);
	}

	public function text_blast()
	{
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'admin/text_blast';
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		//$this->data['est_list'] = $this->Admin_model->list('establishments');
		$this->load->view('template/admin', $this->data);
	}

	public function category()
	{
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/category';
		$this->data['category_list'] = $this->Admin_model->category_list();
		$this->load->view('template/admin', $this->data);
	}	

	public function a1_relatives()
	{
		$this->isAllowed();
		$this->load->model('A1family_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'a1family/list';
		$this->data['a1_list'] = $this->A1family_model->get_list();
		$this->data['links'] = $this->linkGenerator();
		$this->load->view('template/admin', $this->data);
	}	

	public function add()
	{
		$this->load->model('Admin_model', '', TRUE);
		$table = $this->input->post('table');
		$id_name = $this->input->post('id_name');
		$data = array();
		$data[$table] = $this->input->post('dbval');
		$data["status"] = $this->input->post('status');
		$id = $this->input->post('id');
		if($id == ""){
			$check = $this->Admin_model->checker($data[$table],$table);
			if($check == 0){
				$this->Admin_model->add($data,$table);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data[$table].' has been added to '.$table.' list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data[$table].' as '.$table.'. Duplicate entry detected</div>');
			}			
			
		}
		else{
			$this->Admin_model->edit($data,$id,$table,$id_name);
		}
		redirect(site_url("Admin/".$table));
	}

		public function add_si()
	{
		$this->load->model('Admin_model', '', TRUE);
		$table = 'sched_interval';
		$id_name = 'si_id';
		$data = array();
		$data['description'] = $this->input->post('description');
		$data["start_time"] = $this->input->post('start_time');
		$data["hour_interval"] = $this->input->post('hour_interval');
		$data["max_per_hour"] = $this->input->post('max_per_hour');
		$data["end_time"] = $this->input->post('end_time');
		$data["max_client"] = $this->input->post('max_client');
		$data["over_time"] = $this->input->post('over_time');

		$id = $this->input->post('si_id');
		if($id == ""){
				$this->Admin_model->add($data,$table);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data[$table].' has been added to '.$table.' list.</div>');			
		}
		else{
			$this->Admin_model->edit($data,$id,$table,$id_name);
		}
		redirect(site_url("Admin/".$table));
	}

	public function add_link()
	{
		$this->load->model('Admin_model', '', TRUE);
		$table = $this->input->post('table');
		$id_name = $this->input->post('id_name');
		$data = array();
		$data[$table] = $this->input->post('dbval');
		$data["status"] = $this->input->post('status');
		$data["icon"] = $this->input->post('icon');
		$data["label"] = $this->input->post('label');
		$data["multiple"] = $this->input->post('multiple');
		$data["parent_id"] = $this->input->post('parent_id');
		$id = $this->input->post('id');
		if($id == ""){
			$check = $this->Admin_model->checker($data[$table],$table);
			if($check == 0){
				$this->Admin_model->add($data,$table);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data[$table].' has been added to '.$table.' list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data[$table].' as '.$table.'. Duplicate entry detected</div>');
			}			
			
		}
		else{
			$this->Admin_model->edit($data,$id,$table,$id_name);
		}

		redirect(site_url("Admin/".$table));
	}

	public function add_priority_group()
	{
		$this->load->model('Admin_model', '', TRUE);
		$table = $this->input->post('table');
		$id_name = $this->input->post('id_name');
		$data = array();
		$data[$table] = $this->input->post('dbval');
		$data["status"] = $this->input->post('status');
		$data["description"] = $this->input->post('description');
		$id = $this->input->post('id');
		if($id == ""){
			$check = $this->Admin_model->checker($data['description'],$table);
			if($check == 0){
				$this->Admin_model->add($data,$table);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data['description'].' has been added to '.$table.' list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data['description'].' as '.$table.'. Duplicate entry detected</div>');
			}			
			
		}
		else{
			$this->Admin_model->edit($data,$id,$table,$id_name);
		}

		redirect(site_url("Admin/".$table));
	}

	public function delete()
	{
		$this->load->model('Admin_model', '', TRUE);
		$table = $this->input->post('table');
		$id_name = $this->input->post('id_name');
		$id = $this->input->post('id');
		$val = $this->input->post('dbval');
		$this->Admin_model->delete($id,$id_name,$table);
		$this->session->set_flashdata('message', "<div class='alert alert-warning'>".$table. " " . $val . '  has been deleted</div>');
		redirect(site_url("Admin/".$table));
	}

	public function active_scanners(){
		$this->load->model('Admin_model', '', TRUE);
		$data = $this->Admin_model->active_scanners();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function check_alerts(){
		$this->load->model('Admin_model', '', TRUE);
		$data = $this->Admin_model->check_alerts();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function est_list(){
		$this->isAllowed();
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'establishment/list.php';
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->load->view('template/admin', $this->data);
	}

	public function ajax_list(){
    	$this->load->model('Establishment_model');
        $list = $this->Establishment_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->name;
            $row[] = $val->address.' '.$val->brgyDesc.' '.$val->citymunDesc;
            $row[] = $val->contact_person;
            $row[] = $val->contact_number; 

            //actions
	    	if(!empty(array_intersect(array(1,2), $this->session->userdata('logged_in')->access))){
            $row[] = '<a class="edit_stats" href="javascript:void(0)" title="Edit" est_id='.$val->id.' id="edit"><i class="fa fa-edit fa-lg"></i></a>
					<a class="add_exemption" href="javascript:void(0)" title="Add Exemption" group_id='.$val->group_id.' est_name='.$val->name.' id="add_exemption"><i class="fa fa-share-square fa-lg"></i></a>
					<a class="add_member" href="javascript:void(0)" title="Add group Member" est_id='.$val->id.' est_name='.$val->name.' id="add_member"><i class="fa fa-plus"></i></a>
					<a class="delete" href="javascript:void(0)" title="Add group Member" est_id='.$val->id.' est_name='.$val->name.' id="delete"><i class="fa fa-trash"></i></a>
            		 '
                ;
            }else{
            $row[] = '<a class="edit_stats" href="javascript:void(0)" title="Edit" est_id='.$val->id.' id="edit"><i class="fa fa-edit fa-lg"></i></a>
					<a class="add_exemption" href="javascript:void(0)" title="Add Exemption" group_id='.$val->group_id.' est_name='.$val->name.' id="add_exemption"><i class="fa fa-share-square fa-lg"></i></a>
					<a class="add_member" href="javascript:void(0)" title="Add group Member" est_id='.$val->id.' est_name='.$val->name.' id="add_member"><i class="fa fa-plus"></i></a>
            		 '
                ;
            }

 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Establishment_model->count_all(),
                        "recordsFiltered" => $this->Establishment_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
	{
		$this->load->model('Establishment_model');
		$data = $this->Establishment_model->get_by_id($id);
		echo json_encode($data);
	} 

    public function tagger_ajax_edit($id)
	{
		$this->load->model('General_model');
		$data = $this->General_model->get_one_row('tagger_account','tagger_id',$id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$id = $this->input->post('id');
		$uplb = $this->input->post('uplb')!=1?0:1;
		$data = array(
			'name' => $this->input->post('name'),
			'address' => $this->input->post('address'),
			'provCode' => $this->input->post('provCode'),
			'citymunCode' => $this->input->post('citymunCode'),
			'brgyCode' => $this->input->post('brgyCode'),
			'username' => $this->input->post('username'),
			'contact_number' => $this->input->post('contact_number'),
			'contact_person' => $this->input->post('contact_person'),  
			'oddeven_exemption' => $this->input->post('oddeven_exemption'),  
			'uplb' => $this->input->post('uplb'),  
		);
		if($this->input->post('password')!=''){
			$data += array('password' => sha1($this->input->post('password')));
		}
 		$this->load->model('Establishment_model');
		$this->Establishment_model->update($id, $data);

		echo json_encode($data);
	} 

	public function ajax_delete($id){

 		$this->load->model('Admin_model');
	    $this->Admin_model->delete($id,'id','establishments');
	    echo json_encode('deleted');
  	}

	public function add_client_exemption(){
		$client_id = $this->input->post('client_id');
		$group_id = $this->input->post('group_id');
		$data = new stdClass();
		$data->client_id = $client_id;
		$data->group_id = $group_id;

 		$this->load->model('Admin_model');
		$this->Admin_model->add($data, 'oddeven_exemption');

		//$data = $this->Admin_model->exempted_list($est_id);
		echo json_encode($group_id);
	}

	public function add_access(){
		$link_id = $this->input->post('link_id');
		$at_id = $this->input->post('at_id');
		$data = new stdClass();
		$data->link_id = $link_id;
		$data->at_id = $at_id;

 		$this->load->model('Admin_model');
		$this->Admin_model->add($data, 'access');

		//$data = $this->Admin_model->exempted_list($est_id);
		echo json_encode($data->at_id);
	}

	public function add_member(){
		$group_id = $this->input->post('group_id');
		$est_id = $this->input->post('est_id');
 		$this->load->model('Admin_model');
		if(!empty($est_id)){
			foreach($est_id as $val){
				$data = array(
				           'group_id' => $group_id,
				       	);
			$this->Admin_model->edit($data,$val,'establishments','id');
			}
		}

		//$data = $this->Admin_model->exempted_list($est_id);
		echo json_encode('added');
	}

	public function multiple_client_exemption(){
		$group_id = $this->input->post('group_id');
		$client_id = $this->input->post('client_id');
 		$this->load->model('Clients_model');
		if(!empty($group_id)){
			foreach($group_id as $val){
				$data_exemption[] = array(
				           'client_id' => $client_id,
				           'group_id' => $val,
				       	);
			}
			$this->Clients_model->add_exemption($data_exemption);
		}

		//$data = $this->Admin_model->exempted_list($est_id);
		echo json_encode('added');
	}

	public function delete_client_exemption(){
		$exemption_id = $this->input->post('exemption_id');

 		$this->load->model('Admin_model');
		$this->Admin_model->delete($exemption_id, 'exemption_id','oddeven_exemption');

		//$data = $this->Admin_model->exempted_list($est_id);
		echo json_encode('deleted');
	}

	public function delete_link(){
		$a_id = $this->input->post('a_id');

 		$this->load->model('Admin_model');
		$this->Admin_model->delete($a_id, 'a_id','access');

		//$data = $this->Admin_model->exempted_list($est_id);
		echo json_encode('deleted');
	}

	public function get_exempted(){
		$group_id = $this->input->post('group_id');

 		$this->load->model('Admin_model');

		$data = $this->Admin_model->exempted_list($group_id);
		echo json_encode($data);
	}

	public function get_members(){
		$est_id = $this->input->post('est_id');

 		$this->load->model('Admin_model');

		$data = $this->Admin_model->search_list('establishments',$est_id,'group_id');
		echo json_encode($data);
	}

	public function get_access(){
		$at_id = $this->input->post('at_id');

 		$this->load->model('Admin_model');

		$data = $this->Admin_model->access_list($at_id);
		echo json_encode($data);
	}

	public function access_type(){
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/access_type';
		$this->data['list'] = $this->Admin_model->list('access_type');
		$this->data['links'] = $this->linkGenerator();
		$this->load->view('template/admin', $this->data);
	}

	public function Vaccinator(){
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/vaccinator';
		$this->data['list'] = $this->Admin_model->list('vaccinator');
		$this->data['links'] = $this->linkGenerator();
		$this->load->view('template/admin', $this->data);
	}
	public function sched_interval(){
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/sched_interval';
		$this->data['list'] = $this->Admin_model->list('sched_interval');
		$this->data['links'] = $this->linkGenerator();
		$this->load->view('template/admin', $this->data);
	}

	public function link(){
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/link';
		$this->data['list'] = $this->Admin_model->list('link');
		$this->data['links'] = $this->linkGenerator();
		$this->load->view('template/admin', $this->data);
	}

	public function priority_group(){
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/priority_group';
		$this->data['list'] = $this->Admin_model->list('priority_group');
		$this->data['links'] = $this->linkGenerator();
		$this->load->view('template/admin', $this->data);
	}

    public function get_links()
	{
		$search = $this->input->POST('search');
		$at_id = $this->input->POST('at_id');
		$this->load->model('Admin_model');
		$data = $this->Admin_model->links_list($search,$at_id);
		echo json_encode($data);
	} 
    public function forbidden()
	{
		$this->load->view('errors/index.html');
	} 

    public function qr_generator()
	{
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/qr_generator';
		//$this->data['list'] = $this->Admin_model->list('access_type');
		$this->data['links'] = $this->linkGenerator();
		$this->load->view('template/admin', $this->data);
	} 

    public function print_qr()
	{
		//$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/print_qr';
		//$this->data['list'] = $this->Admin_model->list('access_type');
		$this->data['links'] = $this->linkGenerator();
		$this->load->view('template/print_head', $this->data);
	} 

	public function tagger_list(){
		$this->isAllowed();
		$this->load->model('General_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'tagger/list.php';
		// $selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->load->view('template/admin', $this->data);
	}
	
	public function adverse_event()
	{
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in'); 
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'admin/adverse_event';
		$this->data['adverse_list'] = $this->Admin_model->get_adverse_list();
		$this->load->view('template/admin', $this->data);
	}

	public function add_tagger()
	{
		$this->load->model('Admin_model', '', TRUE);
		$this->load->model('General_model', '', TRUE);
		$tagger_id = $this->input->post('id');
		$password = $this->input->post('password');
			$data = array();
			$data["fname"] = $this->input->post('fname');
			$data["lname"] = $this->input->post('lname');
			$data["mname"] = $this->input->post('mname');
			$data["contact_number"] = $this->input->post('contact_number');
			$data["brgyCode"] = $this->input->post('brgyCode');
			$data["mname"] = $this->input->post('mname');
			$data["username"] = $this->input->post('username');
			if($password!=''){
			$data["password"] = password_hash($password, PASSWORD_BCRYPT);
			}
			$data["access"] = $this->input->post('access');

			$brgyDesc = $this->General_model->get_one_row('refbrgy','brgyCode',$data["brgyCode"])->brgyDesc;
		if($tagger_id==''){
			$id = $this->Admin_model->add($data,'tagger_account');
		}else{
			$this->Admin_model->edit($data,$tagger_id,'tagger_account','tagger_id');
			$id = $tagger_id;
		}

		$jsondata = new stdClass();
		$jsondata->fullname = $data["lname"].', '.$data["fname"].' '.$data["mname"];
		$jsondata->brgy = $brgyDesc;
		$jsondata->username = $data["username"];
		$jsondata->password = $password;
		echo json_encode($jsondata);

	}

	public function ajax_taggerList(){
    	$this->load->model('Tagger_model');
        $list = $this->Tagger_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $val->tagger_id;
            $row[] = $val->fname;
            $row[] = $val->lname;
            $row[] = $val->mname;
            $row[] = $val->brgyDesc; 
            $row[] = $val->contact_number; 

            //actions
            $row[] = '<a class="edit" href="javascript:void(0)" title="Edit" tagger_id='.$val->tagger_id.' id="edit"><i class="fa fa-edit fa-lg"></i></a>
					<a class="disable" href="javascript:void(0)" title="Disable Tagger Account" tagger_id="'.$val->tagger_id.'" full_name="'.$val->lname.', '.$val->fname.'" id="disable"><i class="fa fa-ban"></i></a>
            		 '
                ;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Tagger_model->count_all(),
                        "recordsFiltered" => $this->Tagger_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_taggerEdit($id)
	{
		$this->load->model('Establishment_model');
		$data = $this->Establishment_model->get_by_id($id);
		echo json_encode($data);
	} 

	public function ajax_taggerUpdate()
	{
		$id = $this->input->post('id');
		$uplb = $this->input->post('uplb')!=1?0:1;
		$data = array(
			'name' => $this->input->post('name'),
			'address' => $this->input->post('address'),
			'provCode' => $this->input->post('provCode'),
			'citymunCode' => $this->input->post('citymunCode'),
			'brgyCode' => $this->input->post('brgyCode'),
			'username' => $this->input->post('username'),
			'contact_number' => $this->input->post('contact_number'),
			'contact_person' => $this->input->post('contact_person'),  
			'oddeven_exemption' => $this->input->post('oddeven_exemption'),  
			'uplb' => $this->input->post('uplb'),  
		);
		if($this->input->post('password')!=''){
			$data += array('password' => sha1($this->input->post('password')));
		}
 		$this->load->model('Establishment_model');
		$this->Establishment_model->update($id, $data);

		echo json_encode($data);
	} 

	public function ajax_taggerDelete($id){

 		$this->load->model('Admin_model');
	    $this->Admin_model->delete($id,'id','establishments');
	    echo json_encode('deleted');
  	}

	public function get_sms(){
 		$this->load->model('Admin_model');
	    $offset = $this->Admin_model->get_offset();
	    // var_dump($offset[0]);
 		$this->load->model('Admin_model');
	    $list = $this->Admin_model->get_sms($offset[0]->offset);
		$offset = $offset[0]->offset+100;
		$data = new stdClass();
		$data->offset = $offset;
	    $this->Admin_model->update_offset($data);

	    echo json_encode($list);
  	}

  	public function save_device(){
 		$this->load->model('General_model');
  		$where2 = new stdClass();
  		$where = new stdClass();
  		$where->device_id = $this->input->post('device_id');

  		$data = new stdClass();
  		$data->is_active = '1';

  		$data2 = new stdClass();
  		$data2->is_active = '0';

  		$this->General_model->update($data2,$where2,'device');

  		$this->General_model->update($data,$where,'device');

	    echo json_encode(1);
  	}
  	 
	public function add_adverse_event()
	{
		$this->load->model('Admin_model', '', TRUE);  
		$data = array();
		$data["description"] = $this->input->post('description');
		$data["status"] = $this->input->post('status'); 

		$id = $this->Admin_model->add_adverse_event($data); 
		redirect(site_url("Admin/adverse_event"));
	}

	public function edit_adverse_event()
	{
		$this->load->model('Admin_model', '', TRUE); 
		$data = array();
		$data["description"] = $this->input->post('description');
		$data["status"] = $this->input->post('status'); 

		$id = $this->input->post('av_id'); 

		$this->Admin_model->edit_adverse_event($data,$id);

		redirect(site_url("Admin/adverse_event"));
	}

	public function vac_site()
	{
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in'); 
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'admin/vac_site';
		$this->data['vac_site_list'] = $this->Admin_model->get_vac_site_list();
		$this->load->view('template/admin', $this->data);
	}	

	public function add_vac_site()
	{
		$this->load->model('Admin_model', '', TRUE);  
		$data = array();
		$data["vac_site"] = $this->input->post('vac_site');
		$data["status"] = $this->input->post('status'); 

		$id = $this->Admin_model->add_vac_site($data); 
		redirect(site_url("Admin/vac_site"));
	}

	public function edit_vac_site()
	{
		$this->load->model('Admin_model', '', TRUE); 
		$data = array();
		$data["vac_site"] = $this->input->post('vac_site');
		$data["status"] = $this->input->post('status'); 

		$id = $this->input->post('vac_site_id'); 

		$this->Admin_model->edit_vac_site($data,$id);

		redirect(site_url("Admin/vac_site"));
	}
	
	public function vaccines()
	{
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in'); 
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'admin/vaccines';
		$this->data['vaccine_list'] = $this->Admin_model->get_vaccine_list();
		$this->load->view('template/admin', $this->data);
	}

	public function add_vaccine()
	{
		$this->load->model('Admin_model', '', TRUE);  
		$data = array();
		$data["brand"] = $this->input->post('brand');
		$data["manufacturer"] = $this->input->post('manufacturer');
		$data["status"] = $this->input->post('status'); 

		$id = $this->Admin_model->add_vaccine($data); 
		redirect(site_url("Admin/vaccines"));
	}

	public function edit_vaccine()
	{
		$this->load->model('Admin_model', '', TRUE); 
		$data = array();
		$data["brand"] = $this->input->post('brand');
		$data["manufacturer"] = $this->input->post('manufacturer');
		$data["status"] = $this->input->post('status'); 

		$id = $this->input->post('vaccine_id'); 

		$this->Admin_model->edit_vaccine($data,$id);

		redirect(site_url("Admin/vaccines"));
	}

	public function ind()
	{
		$this->isAllowed();
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in'); 
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'admin/indigent';
		$this->data['indigent_list'] = $this->Admin_model->get_indigent_list();
		$this->load->view('template/admin', $this->data);
	}


	public function add_indigent()
	{
		$this->load->model('Admin_model', '', TRUE);  
		$data = array();
		$data["indigent_grp"] = $this->input->post('indigent'); 
		$data["status"] = $this->input->post('status'); 

		$id = $this->Admin_model->add_indigent($data); 
		redirect(site_url("Admin/indigent"));
	}

	public function edit_indigent()
	{
		$this->load->model('Admin_model', '', TRUE); 
		$data = array(); 
		$data["indigent_grp"] = $this->input->post('indigent'); 
		$data["status"] = $this->input->post('status'); 

		$id = $this->input->post('ind_id'); 

		$this->Admin_model->edit_indigent($data,$id);

		redirect(site_url("Admin/indigent"));
	}
}