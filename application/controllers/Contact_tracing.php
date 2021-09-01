<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_tracing extends MY_Controller {

	public function __construct() {
		parent::__construct();
		//$this->isLogin();
		//$this->output->enable_profiler(TRUE);
		 // Load Pagination library
    	$this->load->library('pagination');
    	$this->load->helper('captcha');
	}

	public function index()
	{
		$this->registration();
	}

	public function registration()
	{
		$this->load->model('General_model');
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['content'] = 'contact_tracing/client_registration/registration';
		$this->load->view('template/public', $this->data);	
	}

	public function est_registration()
	{
		$this->load->model('General_model');
		$selected_prov = '434';//LAGUNA as initial selected
		$selected_mun = '43411';//LB as initial selected
		$this->data['prov_list'] = $this->General_model->get_province();
		$this->data['municipality_list'] = $this->General_model->get_municipality($selected_prov);
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$this->data['content'] = 'contact_tracing/establishment_registration/registration';
		$this->load->view('template/public', $this->data);	
	}

	public function add_client(){
		$this->load->library('image_lib');
		$this->load->model('Contact_tracing_model');
		$date= date('dmy');
		$qrcode = $this->input->post('qrcode');
		$password = $this->input->post('password');
		$password = $password!=''?$password:'covid19';
		$jsondata = new stdClass();
		$data = new stdClass();
		$data->fname = $this->input->post('fname');
		$data->lname = $this->input->post('lname');
		$data->mname = $this->input->post('mname');
		$data->address = $this->input->post('address');
		$data->citymunCode = $this->input->post('citymunCode');
		$data->brgyCode = $this->input->post('brgyCode');
		$data->provCode = $this->input->post('provCode');
		$data->birthday = date("Y-m-d", strtotime($this->input->post('birthday')));
		$data->contact_number = $this->input->post('contact_number');
		$data->pow = $this->input->post('pow');
		$data->sex = $this->input->post('sex');
		$data->username = $this->input->post('username');
		$data->password = sha1($password);
		$data->status = 1;
		$data->active = 1;
		$upload_dir = "assets/images/id_uploads/".$date."/";
		$data->qrcode = $qrcode;
		$data->date_registered = date('Y-m-d H:i:s');
		$jsondata->error_log = array();


		if (!file_exists($upload_dir)) {
    		mkdir($upload_dir, 0777, true);  //create directory if not exist
		}

		$config['upload_path']=$upload_dir;
        $config['allowed_types']='gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 5000;
		$this->load->library('upload',$config);
		//check if client is not unique
		$duplicate_client = $this->Contact_tracing_model->check_duplicate_client($data);
		$duplicate_username = $this->Contact_tracing_model->check_duplicate_username($data,'clients');
		$duplicate_qrcode = false;

		if($duplicate_client == true){
			$jsondata->error_log[] = 1;
		}
		if($duplicate_username == true){
			$jsondata->error_log[] = 3;
		}
		if($qrcode!=''){
			$duplicate_qrcode = $this->Contact_tracing_model->check_duplicate_qrcode($data);
			if($duplicate_qrcode == true){
				$jsondata->error_log[] = 2;
			}
		}
		if($duplicate_username == false AND $duplicate_qrcode == false AND $duplicate_client == false){
			//if no duplicate found upload file first then add client to db
			if (!$this->upload->do_upload('upload_file')) {
				$jsondata->error_image = $this->upload->display_errors();
			   $jsondata->error_log[] = 4;
			}else{
	            $image_data =   $this->upload->data();

	            $configer =  array(
	              'image_library'   => 'gd2',
	              'source_image'    =>  $image_data['full_path'],
	              'maintain_ratio' => TRUE,
	              'quality' => '80%', //tell CI to reduce the image quality and affect the image size
	              //'width' => 1280,//new size of image
	              //'height' => 720,//new size of image
	            );
	            $this->image_lib->clear();
	            $this->image_lib->initialize($configer);
	            $this->image_lib->resize();
		        $file_name = $this->upload->data('file_name');
				$data->image_path = $upload_dir.$file_name;
				$generated_id = $this->Contact_tracing_model->add($data,'clients');
				$jsondata->error_message = '';
				if($qrcode==''){
					$update = new stdClass();
					$update->qrcode = $data->brgyCode . '-' . str_pad($generated_id, 6, '0', STR_PAD_LEFT);
					//update client qrcode
					$this->Contact_tracing_model->update_client_qrcode($generated_id,$update);
				}
				$jsondata->client_info = $this->Contact_tracing_model->client_info($generated_id);
	      }
		}
		header('Content-Type: application/json');
		echo json_encode( $jsondata );
	}
	public function add_est(){
		$this->load->model('Contact_tracing_model');
		$password = $this->input->post('password');
		$jsondata = new stdClass();
		$data = new stdClass();
		$data->name = $this->input->post('name');
		$data->uplb = $this->input->post('uplb')!=1?0:1;
		$data->address = $this->input->post('address');
		$data->provCode = $this->input->post('provCode');
		$data->citymunCode = $this->input->post('citymunCode');
		$data->brgyCode = $this->input->post('brgyCode');
		$data->contact_number = $this->input->post('contact_number');
		$data->contact_person = $this->input->post('contact_person');
		$data->oddeven_exemption = 1;
		$data->username = $this->input->post('username');
		$data->password = sha1($password);
		$data->status = 0;
		$jsondata->error_log = array();

		//check if client is not unique
		$duplicate_est = $this->Contact_tracing_model->check_duplicate_est($data);
		$duplicate_username = $this->Contact_tracing_model->check_duplicate_username($data,'establishments');

		if($duplicate_est == true){
			$jsondata->error_log[] = 1;
		}
		if($duplicate_username == true){
			$jsondata->error_log[] = 3;
		}
		if($duplicate_username == false AND $duplicate_est == false){
			//if no duplicate found add client
			$generated_id = $this->Contact_tracing_model->add($data,'establishments');
			$update = new stdClass();
			$update->group_id = $generated_id;
			//update client qrcode
			$this->Contact_tracing_model->update_est_group($generated_id,$update);
			$jsondata->client_info = $this->Contact_tracing_model->est_info($generated_id);
		}
		$len = strlen($password);

    	$jsondata->password =  substr($password, 0, 1).str_repeat('*', $len - 2).substr($password, $len - 1, 1);
    	$jsondata->qr_p =  $password;

		header('Content-Type: application/json');
		echo json_encode( $jsondata );
	}
}
