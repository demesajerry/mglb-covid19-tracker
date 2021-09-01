<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class A1registration extends MY_Controller {

	public function __construct() {
		parent::__construct();   
		$this->load->helper('url', 'form');
		//$this->output->enable_profiler(TRUE);
		//$this->load->model('patients_model', '', TRUE);
	}
	public function index(){
		$this->load->model('General_model');
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['content'] = 'a1family/index';
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$where = new stdClass();
		$where->status = 0; 
		$this->data['priority_group'] = $this->General_model->filter_list($where,'priority_group',false);
		$wherea1 = new stdClass();
		$wherea1->a1 = 1; 
		$this->data['priority_group_a1'] = $this->General_model->filter_list($wherea1,'priority_group',false);
		$this->data['a1_workplace'] = $this->General_model->filter_list($where,'a1_workplace',false); 
		$this->load->view('template/public', $this->data);
	}

	public function verifier(){
		$this->data['content'] = 'a1family/verifier.php';
		$this->load->view('template/public', $this->data);
	}

	public function get_details(){
		$this->load->model('A1family_model');
		$where = new stdClass();
		$where->qrcode = $this->input->post('qrcode');
		$details = $this->A1family_model->get_details($where);
		$data = new stdClass();
		if($details){
			$data->details = $details;
			$data->error = 0;
		}else{
			$data->error = 1;
		}

		echo json_encode( $data );
	}

	public function get_details_id(){
		$this->load->model('A1family_model');
		$dose = $this->input->post('dose');
		$where = new stdClass();
		$where->id = $this->input->post('userid');
		$details = $this->A1family_model->get_details_id($where,$dose);
		$data = new stdClass();
		if($details){
			$data->details = $details;
			$data->error = 0;
		}else{
			$data->error = 1;
		}

		echo json_encode( $data );
	}

	public function confirm_details(){
		$this->load->model('A1family_model');
		$qrcode = $this->input->post('qrcode');
		$birthday = $this->input->post('birthday');
		if($birthday!==''){
			$birthday = date("Y-m-d", strtotime($birthday));
			$where = new stdClass();
			$where->birthday = $birthday;
			$where->qrcode = $qrcode;
			$details = $this->A1family_model->get_details($where);
			$data = new stdClass();
			if($details){
				$data->details = $details;
				$data->error = 0;
			}else{
				$data->error = 1;
			}
		}else{
				$data->error = 2;
		}

		echo json_encode( $data );
	}

	public function confirm_details_rel(){
		$this->load->model('A1family_model');
		$qrcode = $this->input->post('qrcode'); 
		$where = new stdClass(); 
			$where->qrcode = $qrcode;
			$details = $this->A1family_model->get_details_rel($where);
			$data = new stdClass();
			if($details){
				$data->details = $details;
				$data->error = 0;
			}else{
				$data->error = 1;
			} 
		echo json_encode( $data );
	}  

	public function update_workplace(){ 
		$this->load->library('image_lib');
		$this->load->model('A1family_model');
		$date= date('dmy'); 
		$data = new stdClass();
		$where = $this->input->post('userid');
		$table = 'vaccination';

		$userfile = $_FILES['userfile'];
		$imagedata = $_POST["image"];  
		  
		$upload_dir = "assets/images/a1_photo/";

		if (!file_exists($upload_dir)) {
    		mkdir($upload_dir, 0777, true);  //create directory if not exist
		} 
		//browse valid id 
		if(!empty($userfile)){ 
			$upload_path="assets/images/a1_photo/"; 
			$config = array(
		        'upload_path' => $upload_path,
		        'allowed_types' => "gif|jpg|png|jpeg",
		        'overwrite' => TRUE,
		        'max_size' => "10485760",  
		        'file_name' => 'a1user'.$where.'.jpg'
	        );
	        $this->load->library('upload', $config);
		        if($this->upload->do_upload('userfile')){ 
		            $imageDetailArray = $this->upload->data();
		            $image =  $imageDetailArray['file_name']; 
		            $data->a1_imagepath = $image;
		        }
		    
	    }	 
 		//capture valid id
		if(!empty($imagedata)){
			$image_array_1 = explode(";", $imagedata);
			$image_array_2 = explode(",", $image_array_1[1]);
			$imagedata = base64_decode($image_array_2[1]);
			$imageName = 'a1user'.$where.'.jpg';
			file_put_contents($upload_dir.$imageName, $imagedata);
			$data->a1_imagepath = $imageName;
		}  
		
		$data->a1_workplace = $this->input->post('a1_workplace');
		$data->employer_name = $this->input->post('employer_name');
		$data->employer_no = $this->input->post('employer_no');
		$data->employer_add = $this->input->post('employer_add');
		$data->employer_prov = $this->input->post('employer_prov');
		$data->a1_vaccinated_status = $this->input->post('vaccinated_status');
		   
		 
		$insert = $this->A1family_model->update_workplace($data, $where, $table);
		header('Content-Type: application/json');
		echo json_encode( $data );
		 
	} 

	public function addA1Fam(){ 
		$this->load->model('A1family_model'); 
		$relatives_data = $this->input->post('data_table');  
		$status  = $this->A1family_model->save_rel($relatives_data);
		 $this->output->set_content_type('application/json');
		 echo json_encode(array('status' => $status));
	} 
	public function search_userid()
	{
		$this->load->model('A1family_model'); 		
		$fname = $this->input->POST('fname');
		$lname = $this->input->POST('lname');
		$mname = $this->input->POST('mname');
		$convert_bdate = strtotime($this->input->POST('birthday'));
		$birthday = $this->input->POST('birthyear').'-'.date('m-d', $convert_bdate); 
		$id = $this->A1family_model->search_userid($fname,$lname,$mname,$birthday);
		echo json_encode($id);
	}

	public function check_relative()
	{
		$this->load->model('A1family_model');
		$userid = $this->input->POST('userid');		
		$reluserid = $this->input->POST('reluserid');   
		$relative = $this->A1family_model->check_relative($userid,$reluserid);
		echo json_encode($relative);
	}

	public function update(){
		$this->load->model('A1family_model');
		$this->load->model('Admin_model');
		$this->load->model('Contact_tracing_model');
		
		$bday = $this->input->post('birthday').' '. $this->input->post('birthyear');
		$bday = date("Y-m-d", strtotime($bday));
		//define data
		$data = new stdClass();		
		//set update_by if tagger is logged in
		if($this->session->userdata('tagger_logged_in')){
			$data->update_by = $this->session->userdata('tagger_logged_in')->tagger_id;
		}

		$id = $this->input->post('userid');
		$qrcode = $this->input->post('qrcode');
		//setup data
		foreach($_POST as $key=>$val){
			$data->{$key} = $val;
		}
		//unset qrcode
		unset($data->qrcode);

		$data->birthday = $bday;
		//set conditional data id and qrcode
		$where = new stdClass();
		$where->id = $this->input->post('userid');
		$where->qrcode = $this->input->post('qrcode');
		//check if client exist where id and qrcode is true
		$user_exist = $this->Admin_model->checker_dynamic('clients',$where);
		//if user exist(found) update clients detail and check if it has a1family records
		if($user_exist){
			//update client
			$this->A1family_model->update($data,$where,'clients');
			//start a1family table condtions
			//set where conditons userid = userid to be used in a1family and post_a1family table 
			$where_userid = new stdClass();
			$where_userid->userid = $this->input->post('userid');

			//checkk if user has a1family details
			$with_vac_record = $this->Admin_model->checker_dynamic('a1family',$where_userid);
			//if client has a1family details update
			if($with_vac_record){
				//if next_vac_date is set convert date
				if(isset($data->next_vac_date) AND $data->next_vac_date){
					$data->next_vac_date = date("Y-m-d", strtotime($data->next_vac_date));
				}
				$data->date_update = date('Y-m-d H:i:s');
				$this->A1family_model->update($data,$where_userid,'a1family');
			}else{//if client has no a1family record add new record
				if($this->session->userdata('tagger_logged_in')){
					$data->encoded_by = $this->session->userdata('tagger_logged_in')->tagger_id;
				}
				$data->date_reg = date('Y-m-d H:i:s');
				$this->A1family_model->add($data,'a1family');
			}
			//end a1family table conditions
			//start post_a1family table conditions
			//if post_vac has value do post a1family conditions
			if($this->input->post('post_vac')){
				//if vac_date is set convert date
				if($data->vac_date){
					$data->vac_date = date("Y-m-d", strtotime($data->vac_date));
				}
				//if symptoms is set iterate to get all values
				if(isset($data->symptoms)){
					foreach($data->symptoms as $key=>$val2){
						if($key == 0){
							$symptoms = $val2;
						}else{
							$symptoms .= ', '.$val2;
						}
					}
					$data->symptoms = $symptoms;
				}
				//if dose no. has value do dose conditions
				if($data->dose_no!=''){
					//if dose no = 1 set first dose to 01_yes and add first_dose condition value to 01_yes
					if($data->dose_no == 1){
						$data->first_dose = '01_Yes';
						$data->second_dose = '02_No';
						$where_userid->first_dose = '01_Yes';
					}
					//if dose no = 2 set second dose to 01_yes and add second_dose condition value to 01_yes
					if($data->dose_no == 2){
						$data->second_dose = '01_Yes';
						$data->first_dose = '02_No';
						$where_userid->second_dose = '01_Yes';
					}
				}
				//check if user has post a1family details
				$post_vac_exist = $this->Admin_model->checker_dynamic('post_a1family',$where_userid);
				//if post vac details exist. update record
				if($post_vac_exist){
					$data->date_update = date('Y-m-d H:i:s');
					$this->A1family_model->update($data,$where_userid,'post_a1family');
				}else{//if post vac details does not exist. add new post vac record
					$data->date_added = date('Y-m-d H:i:s');
					$this->A1family_model->add($data,'post_a1family');
				}//end post vac exist checker
			}//end of post_vac conditions
		}//end if user id and qrcode exist
		else{//if userid and qrcode did not match to any client record
			//set where conditions base on fname, mname, lname and birthday
			$where_names = new stdClass();
			$where_names->fname = $this->input->post('fname');
			$where_names->lname = $this->input->post('lname');
			$where_names->mname = $this->input->post('mname');
			$where_names->birthday = $bday;
			//check if client has matching record with fname, mname, lname and birthday
			$user_exist_names = $this->Admin_model->checker_dynamic('clients',$where_names);
			//if client has matching record with fname, mname, lname and birthday
			if($user_exist_names){
				//get all client details with matching record of fname, mname, lname and birthday
				$details = $this->A1family_model->get_details($where_names);
				//set userid value, get from retrieved client id
				$id = $details[0]->id;
				$data->userid = $id;
				//update clients details with matching record base on id
				$where = new stdClass();
				$where->id = $id;
				$this->A1family_model->update($data,$where,'clients');
				//set where userid = id of client
				$where_userid = new stdClass();
				$where_userid->userid = $id;
				//check if client has a1family details
				$with_vac_record = $this->Admin_model->checker_dynamic('a1family',$where_userid);
				//if client has a1family details. update record
				if($with_vac_record){
					$data->date_update = date('Y-m-d H:i:s');
					$this->A1family_model->update($data,$where_userid,'a1family');
				}else{//if client has no a1family record add new record
					if($this->session->userdata('tagger_logged_in')){
						$data->encoded_by = $this->session->userdata('tagger_logged_in')->tagger_id;
					}
					$data->date_reg = date('Y-m-d H:i:s');
					$this->A1family_model->add($data,'a1family');
				}
			}//end if client has matching record from fname, mname, lname and birthday
			else{// if client has no matching record from fname, lname, mname and birthday
				//set active to 1
				$data->active = 1;
				$data->status = 1;
				//set registration date to current date and time for clients table
				$data->date_registered = date('Y-m-d H:i:s');
				//add new record of client details to clients table and retrieve the generated ID
				$id = $this->A1family_model->add($data,'clients');
				//set userid to the generated ID
				$data->userid = $id;
				//set registration date to current date and time for a1family table
				$data->date_reg = date('Y-m-d H:i:s');
				//generate qrcode of the client
				$update = new stdClass();
				$update->qrcode = $data->brgyCode . '-' . str_pad($id, 6, '0', STR_PAD_LEFT);
				//update client qrcode
				$this->Contact_tracing_model->update_client_qrcode($id,$update);
				if($this->session->userdata('tagger_logged_in')){
					$data->encoded_by = $this->session->userdata('tagger_logged_in')->tagger_id;
				}
				//add client a1family details
				$this->A1family_model->add($data,'a1family');
			}//end if client has no matching record from fname, lname, mname and birthday
		}// end if userid and qrcode did not match to any client record
		$jsondata = new stdClass();
		//retrieve client info
		$jsondata->client_info = $this->Contact_tracing_model->client_info($id);
		echo json_encode( $jsondata );
	}

	public function clientExist() {
		$this->load->model('A1family_model');
		$data = new stdClass();
	  	$data->fname = $this->input->post('fname'); 
	  	$data->lname = $this->input->post('lname');
		$data->mname = $this->input->post('mname'); 
		$bday = $this->input->post('birthday').' '.$this->input->post('birthyear');
		$data->birthday = date('Y-m-d', strtotime($bday));

		$result=$this->A1family_model->clientExist($data);

		echo json_encode( $result );
	}

	public function search_clientqr(){
		$this->load->model('A1family_model');
		$data = new stdClass();
		$data->qrcode = $this->input->post('qrcode'); 
		$result=$this->A1family_model->clientExist($data);		
		echo json_encode( $result );
	} 

	public function get_relatives(){
		$this->load->model('General_model');
		$where = new stdClass();
		$where->a1_userid = $this->input->post('userid'); 
		$where->approve = '0'; 
		$result=$this->General_model->filter_list($where,'a1_family','');		
		echo json_encode( $result );
	} 

	public function approve(){
		$this->load->model('General_model');
		$this->load->model('A1family_model');
		$where = new stdClass();
		$where->a1_userid = $this->input->post('userid'); 
		$where->approve = '0'; 
		$data = new stdClass();
		$data->approve='1';

		$result=$this->General_model->filter_list($where,'a1_family','');
		$this->General_model->update($data,$where,'a1_family');
		foreach($result as $val){
			$data2 = new stdClass();
			$data2->category=$val->relation;
			$where2 = new stdClass();
			$where2->userid = $val->a1_relativeid;
			$this->General_model->update($data2,$where2,'vaccination');
		}
		$where3 = new stdClass();
		$where->approve = '0'; 
		$result3=$this->A1family_model->get_list();
		echo json_encode( $result3 );
	} 

	public function disapprove(){
		$this->load->model('General_model');
		$this->load->model('A1family_model');
		$where = new stdClass();
		$where->a1_userid = $this->input->post('userid'); 
		$where->approve = '0'; 
		$data = new stdClass();
		$data->approve='2';

		$result=$this->General_model->filter_list($where,'a1_family','');
		$this->General_model->update($data,$where,'a1_family');

		$where3 = new stdClass();
		$where->approve = '0'; 
		$result3=$this->A1family_model->get_list();
		echo json_encode( $result3 );
	} 
}
