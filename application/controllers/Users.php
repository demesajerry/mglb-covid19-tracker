<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
	}

	public function index()
	{
		$this->isAllowed();	
		$this->load->model('Users_model', '', TRUE);
		$this->load->model('Admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'users/list';
		$this->data['users_list'] = $this->Users_model->get_users_list();
		$this->data['at_list'] = $this->Admin_model->list('access_type');
		$this->data['link_list'] = $this->Admin_model->list('link');
		$this->load->view('template/admin', $this->data);
	}

	public function add_users()
	{
		$this->load->model('Users_model', '', TRUE);
		$imagedata = $_POST["image"];

		$image_array_1 = explode(";", $imagedata);

		$image_array_2 = explode(",", $image_array_1[1]);

		$imagedata = base64_decode($image_array_2[1]);

		$data = array();
		$data["fname"] = $this->input->post('fname');
		$data["lname"] = $this->input->post('lname');
		$data["mname"] = $this->input->post('mname');
		$data["username"] = $this->input->post('username');
		$data["home_page"] = $this->input->post('home_page');
		$data["password"] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
		$access = $this->input->post('access');
		foreach($access as $key=>$acc){
			if($key=='0'){
			$data["access"] = $acc;
			}
			else{
			$data["access"] .= ','.$acc;
			}
		}

		$id = $this->Users_model->add_users($data);

		//add file name
		$imageName = 'user'.$id.'.jpg';
		//upload image
		file_put_contents("assets/images/user_photo/".$imageName, $imagedata);

		redirect(site_url("Users/"));
	}

	public function edit_users()
	{
		$this->load->model('Users_model', '', TRUE);
		$imagedata = $_POST["image"];


		$data = array();
		$data["fname"] = $this->input->post('fname');
		$data["lname"] = $this->input->post('lname');
		$data["mname"] = $this->input->post('mname');
		$data["username"] = $this->input->post('username');
		$data["home_page"] = $this->input->post('home_page');
		if($this->input->post('password')!=''){
			$data["password"] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
		}
		$access = $this->input->post('access');
		foreach($access as $key=>$acc){
			if($key=='0'){
			$data["access"] = $acc;
			}
			else{
			$data["access"] .= ','.$acc;
			}
		}

		$id = $this->input->post('userid');

		//add file name
		$imageName = 'user'.$id.'.jpg';
		//upload image
		if(!empty($imagedata)){
		$image_array_1 = explode(";", $imagedata);
		$image_array_2 = explode(",", $image_array_1[1]);
		$imagedata = base64_decode($image_array_2[1]);
			file_put_contents("assets/images/user_photo/".$imageName, $imagedata);
		}

		$this->Users_model->edit_users($data,$id);

		redirect(site_url("Users/"));
	}

}
