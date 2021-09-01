<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vaccination extends MY_Controller {

	public function __construct() {
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		//$this->load->model('patients_model', '', TRUE);
	}
	public function index(){
		$this->load->model('General_model');
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['content'] = 'vaccination/index.php';
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$where = new stdClass();
		$where->status = 0;
		$this->data['priority_group'] = $this->General_model->filter_list($where,'priority_group',false);

		$this->load->view('template/public', $this->data);
	}

	public function verifier(){
		$this->data['content'] = 'vaccination/verifier.php';
		$this->load->view('template/public', $this->data);
	}

	public function get_details(){
		$this->load->model('Vaccination_model');
		$where = new stdClass();
		$where->qrcode = $this->input->post('qrcode');
		$details = $this->Vaccination_model->get_details($where);
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
		$this->load->model('Vaccination_model');
		$dose = $this->input->post('dose');
		$where = new stdClass();
		$where->id = $this->input->post('userid');
		$details = $this->Vaccination_model->get_details_id($where,$dose);
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
		$this->load->model('Vaccination_model');
		$qrcode = $this->input->post('qrcode');
		$birthday = $this->input->post('birthday');
		if($birthday!==''){
			$birthday = date("Y-m-d", strtotime($birthday));
			$where = new stdClass();
			$where->birthday = $birthday;
			$where->qrcode = $qrcode;
			$details = $this->Vaccination_model->get_details($where);
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

	public function update(){
		$this->load->model('Vaccination_model');
		$this->load->model('Admin_model');
		$this->load->model('General_model');
		$this->load->model('Contact_tracing_model');

		$jsondata = new stdClass();

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
		$audit_trail_msg = '';
		//setup data
		foreach($_POST as $key=>$val){
			$data->{$key} = $val;
			$audit_trail_msg .= $key.':'.$val."<br>"; 
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
		//if user exist(found) update clients detail and check if it has vaccination records
		if($user_exist){
			//check if fname, lname, mname exist
			$where_name = new stdClass();
			$where_name->fname = $this->input->post('fname');
			$where_name->lname = $this->input->post('lname');
			$where_name->mname = $this->input->post('mname');
			$check_name = $this->General_model->list_dynamic($where_name,'clients');
			if($check_name){
				//set client found to 0
				$client_found = 0;
				//iterate in returned list of names
				foreach($check_name as $val){
					//check if userid is found in the check_name array
					if($val->id == $this->input->post('userid')){
						//if found set client_found to 1
						$client_found = 1;
						//exit loop
						break;
					}
				}
				//if client_found == 1 continue update (client name already existed with same userid)
				if($client_found == 1){
					$this->Vaccination_model->update($data,$where,'clients');
					$jsondata->message = '1';
					if($this->session->userdata('tagger_logged_in')){

				 		$audit_data = new stdClass();
				 		$audit_data->user_id = $this->session->userdata('tagger_logged_in')->tagger_id;
				 		$audit_data->client_id = $this->input->post('userid');
				 		$audit_data->datetime = date('Y-m-d H:i:s');
				 		$audit_data->action_done = "Update by Tagger details: <br>".$audit_trail_msg;
						$this->Admin_model->add($audit_data,'audit_trail_vaccination');
					}
				}else{
					$jsondata->message = 'Duplicate Name!';
					$alert = '1';
				}
			}else{
				//update client
				$this->Vaccination_model->update($data,$where,'clients');
				$jsondata->message = '1';
				if($this->session->userdata('tagger_logged_in')){
			 		$audit_data = new stdClass();
			 		$audit_data->user_id = $this->session->userdata('tagger_logged_in')->tagger_id;
			 		$audit_data->client_id = $this->input->post('userid');
			 		$audit_data->datetime = date('Y-m-d H:i:s');
			 		$audit_data->action_done = "Update by Tagger details: <br>".$audit_trail_msg;
					$this->Admin_model->add($audit_data,'audit_trail_vaccination');
				}
			}
			//start vaccination table condtions
			//set where conditons userid = userid to be used in vaccination and post_vaccination table 
			$where_userid = new stdClass();
			$where_userid->userid = $this->input->post('userid');

			//check if user has vaccination details
			$with_vac_record = $this->Admin_model->checker_dynamic('vaccination',$where_userid);
			//if client has vaccination details update
			if($with_vac_record){
				//if next_vac_date is set convert date
				if(isset($data->next_vac_date) AND $data->next_vac_date){
					$data->next_vac_date = date("Y-m-d", strtotime($data->next_vac_date));
				}
				$data->date_update = date('Y-m-d H:i:s');
				if(!isset($alert)){
					$this->Vaccination_model->update($data,$where_userid,'vaccination');
				}
			}else{//if client has no vaccination record add new record
				if($this->session->userdata('tagger_logged_in')){
					$data->encoded_by = $this->session->userdata('tagger_logged_in')->tagger_id;
				}
				$data->date_reg = date('Y-m-d H:i:s');
				if(!isset($alert)){
					$this->Vaccination_model->add($data,'vaccination');
				}
			}
			//end vaccination table conditions
			//start post_vaccination table conditions
			//if post_vac has value do post vaccination conditions
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
						$vaccination_data = new stdCLass();
						//update first_vac_date in vaccination to inputted vaccination date
						$vaccination_data->first_vac_date = $data->vac_date;
						//update vaccination table, first_vac_date field
						$this->Vaccination_model->update($vaccination_data,$where_userid,'vaccination');
						
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
				//check if user has post vaccination details
				$post_vac_exist = $this->Admin_model->checker_dynamic('post_vaccination',$where_userid);
				//if post vac details exist. update record
				if($post_vac_exist){
					$data->date_update = date('Y-m-d H:i:s');
					$this->Vaccination_model->update($data,$where_userid,'post_vaccination');
				}else{//if post vac details does not exist. add new post vac record
					$data->date_added = date('Y-m-d H:i:s');
					$this->Vaccination_model->add($data,'post_vaccination');
				}//end post vac exist checker
			}//end of post_vac conditions
		}//end if user id and qrcode exist
		else{//if userid and qrcode did not match to any client record
			//set where conditions base on fname, mname, lname and birthday
			//set message to success
			$jsondata->message = '1';
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
				$details = $this->Vaccination_model->get_details($where_names);
				//set userid value, get from retrieved client id
				$id = $details[0]->id;
				$data->userid = $id;
				//update clients details with matching record base on id
				$where = new stdClass();
				$where->id = $id;
				$this->Vaccination_model->update($data,$where,'clients');
				//set where userid = id of client
				$where_userid = new stdClass();
				$where_userid->userid = $id;
				//check if client has vaccination details
				$with_vac_record = $this->Admin_model->checker_dynamic('vaccination',$where_userid);
				//if client has vaccination details. update record
				if($with_vac_record){
					$data->date_update = date('Y-m-d H:i:s');
					$this->Vaccination_model->update($data,$where_userid,'vaccination');
				}else{//if client has no vaccination record add new record
					if($this->session->userdata('tagger_logged_in')){
						$data->encoded_by = $this->session->userdata('tagger_logged_in')->tagger_id;
					}
					$data->date_reg = date('Y-m-d H:i:s');
					$this->Vaccination_model->add($data,'vaccination');
				}
			}//end if client has matching record from fname, mname, lname and birthday
			else{// if client has no matching record from fname, lname, mname and birthday
				//set active to 1
				$data->active = 1;
				$data->status = 1;
				//set registration date to current date and time for clients table
				$data->date_registered = date('Y-m-d H:i:s');
				//add new record of client details to clients table and retrieve the generated ID
				$id = $this->Vaccination_model->add($data,'clients');
				//set userid to the generated ID
				$data->userid = $id;
				//set registration date to current date and time for vaccination table
				$data->date_reg = date('Y-m-d H:i:s');
				//generate qrcode of the client
				$update = new stdClass();
				$update->qrcode = $data->brgyCode . '-' . str_pad($id, 6, '0', STR_PAD_LEFT);
				//update client qrcode
				$this->Contact_tracing_model->update_client_qrcode($id,$update);
				if($this->session->userdata('tagger_logged_in')){
					$data->encoded_by = $this->session->userdata('tagger_logged_in')->tagger_id;
				}
				//add client vaccination details
				$this->Vaccination_model->add($data,'vaccination');
			}//end if client has no matching record from fname, lname, mname and birthday
		}// end if userid and qrcode did not match to any client record
		//retrieve client info
		$jsondata->client_info = $this->Contact_tracing_model->client_info_resbakuna($id);
		echo json_encode( $jsondata );
	}

	public function clientExist() {
		$this->load->model('Vaccination_model');
		$data = new stdClass();
	  	$data->fname = $this->input->post('fname'); 
	  	$data->lname = $this->input->post('lname');
		$data->mname = $this->input->post('mname'); 
		$bday = $this->input->post('birthday').' '.$this->input->post('birthyear');
		$data->birthday = date('Y-m-d', strtotime($bday));

		$result=$this->Vaccination_model->clientExist($data);

		echo json_encode( $result );
	}

	public function search_clientqr(){
		$this->load->model('Vaccination_model');
		$data = new stdClass();
		$data->qrcode = $this->input->post('qrcode'); 
		$result=$this->Vaccination_model->clientExist($data);		
		echo json_encode( $result );
	} 

	public function client_verify(){
		$this->load->model('Vaccination_model');
		$qrcode = $this->input->post('qrcode'); 
		$result=$this->Vaccination_model->client_verify($qrcode);		
		echo json_encode( $result );
	} 
 }
