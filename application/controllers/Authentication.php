<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');		
	}
	
	public function index()
	{
		$this->login_page();
	}
	
	public function login_page()
	{
		if(!isset($this->session->userdata['logged_in']))
		{
			$this->data['page_title'] = 'Login';
			$this->data['validation_message'] = '';
			$this->load->view('authentication/login', $this->data);
		} else {
			$home_page = $this->session->userdata('logged_in')->home_page;
			redirect(site_url($home_page));
		}
	}

	public function login()
	{
		$message = "Not Validation";
		
		if(trim($this->input->post('username')) != "" && trim($this->input->post('password')) != "")
		{
			$data = new stdClass();
			$username = $this->input->post('username');
			$password = $this->input->post('password');	
			$captcha = $this->input->post('captcha');	
			$long = $this->input->post('long');
			$lat = $this->input->post('lat');	
			$this->load->model('User_information_model', '', TRUE);
			if($captcha==$this->session->userdata('captcha')){
				$user_information = $this->User_information_model->backend_authentication_details($username);
				
				if($user_information != false) 
				{
					if(password_verify($password, $user_information->password)){
						$sessiondata = new stdClass();
						$sessiondata->userid = $user_information->userid;
						$sessiondata->username = $user_information->username;
						$sessiondata->password = $user_information->password;
						$sessiondata->fullname = $user_information->fname." ".$user_information->lname;
						$sessiondata->access = explode(",", $user_information->access);
						$sessiondata->home_page = $user_information->home_page;
						$links = $this->User_information_model->get_links($sessiondata->access);
						//$array[]->link to $Link[] (multidimension to single)
						$sessiondata->links_label = array_column($links, 'label');
						$sessiondata->links = array_column($links, 'link');
						$this->session->set_userdata('logged_in', $sessiondata);
						if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
						    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
						} else {
						    $ip = $_SERVER['REMOTE_ADDR'];
						}

						$add_log = new stdClass();
						$add_log->username = $sessiondata->username;
						$add_log->fullname = $sessiondata->fullname;
						$add_log->location = $lat.", ".$long;
						$add_log->datetime = date('Y-m-d H:i:s');
						$add_log->ip = $ip;
						$this->load->model('Admin_model', '', TRUE);
						$this->Admin_model->add($add_log,'admin_logs');
						$data->message = "Completed";
						$data->home_page = $sessiondata->home_page;
					}else{
						$message = "Incorrect Password.";
					}
				}
				else
				{
					$data->message = "Please enter correct username.";
				}	
			}else{
					$data->message = "Incorrect Captcha!";
			}				
		} 
		else 
		{
			$data->message = "Please enter correct values";					
		}	
		output_to_json($this, $data);	
	}	

	public function est()
	{
		if(!isset($this->session->userdata['est_logged_in']))
		{
			$this->data['page_title'] = 'Login';
			$this->data['validation_message'] = '';
			$this->load->view('authentication/est_login', $this->data);
		} else {
			redirect(site_url("Establishment/scan"));
		}
	}

	public function est_login()
	{
		$message = "Not Valid";
		
		if(trim($this->input->post('username')) != "" && trim($this->input->post('password')) != "")
		{
			$username = $this->input->post('username');
			$password = sha1($this->input->post('password'));		
			$long = $this->input->post('long');
			$lat = $this->input->post('lat');	

			$this->load->model('User_information_model', '', TRUE);
				$user_information = $this->User_information_model->est_login($username, $password);
				
				if($user_information != false) 
				{

					$sessiondata = new stdClass();
					$sessiondata->userid = $user_information->id;
					$sessiondata->oddeven_exemption = $user_information->oddeven_exemption;
					$sessiondata->group_id = $user_information->group_id;
					$sessiondata->username = $user_information->username;
					$sessiondata->password = $user_information->password;
					$sessiondata->name = $user_information->name;
					$sessiondata->report = $user_information->report;
					$sessiondata->address = $user_information->address.' '.$user_information->brgyDesc.' '.$user_information->citymunDesc;
									
					$this->session->set_userdata('est_logged_in', $sessiondata);
					$message = "Completed";
					$this->load->model('Admin_model', '', TRUE);
					$data = new stdClass();
					$data->est_id = $user_information->id;
					$data->scanner_name = $user_information->name;
					$data->session_id = session_id();
					$data->date_log = date('Y-m-d');
					$data->time_log = date('H:i:s');
					$data->location = $lat.", ".$long;
					$check = $this->Admin_model->check_estlog($data->est_id);
					if($check==0){
						$this->Admin_model->add($data, 'active_scanners');
					}
				}
				else
				{
					$message = "Please enter correct username and password";
				}					
		} 
		else 
		{
			$message = "Please enter correct values";					
		}	
		output_to_json($this, $message);	
	}	

	public function user_login()
	{
		$message = "Not Validation";		
		if(trim($this->input->post('username')) != "" && trim($this->input->post('password')) != "")
		{
		//load session library
		$this->load->library('session');
		$this->load->model('User_information_model');

		$username = $_POST['username'];
		$password = sha1($_POST['password']);

		$data = $this->User_information_model->user_login($username);
			if($data){
				if($data['password'] == $password){
					$this->session->set_userdata('user', $data);
					$message = "Completed";
				}else{
					$message = "Incorrect Password";
				}
			}else{
				$message = "Incorrect Username";
			} 
		}
		else 
		{
			$message = "Please enter correct values";					
		}	
		output_to_json($this, $message);	
	}	

	public function logout()
	{
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = '<strong>Info:</strong> Successfully Logout';
		redirect('Authentication');
	}

	public function est_logout()
	{
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('est_logged_in', $sess_array);
		$data['message_display'] = '<strong>Info:</strong> Successfully Logout';
		redirect('Authentication/est');
	}

	public function client_logout()
	{
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('user', $sess_array);
		$data['message_display'] = '<strong>Info:</strong> Successfully Logout';
		redirect('Contact_tracing/registration');
	}
	
}
