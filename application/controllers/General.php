<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends MY_Controller {

	public function __construct() {
		parent::__construct();
		//$this->isLogin();
	}

	public function add()
	{
		$this->load->model('Admin_model', '', TRUE);
		$table = $this->input->post('table');
		$data = new stdClass();
		$data->{$table} = $this->input->post('new_item');
		$jsondata = new stdClass();
		$check = $this->Admin_model->checker($data->{$table},$table);
		if($check == 0){
			$jsondata->id = $this->admin_model->add($data,$table);
		}
		else{
			$jsondata->id = '0';
		}
		$jsondata->new_item = $this->input->post('new_item');
		$jsondata->table = $this->input->post('table');

		header('Content-Type: application/json');
		echo json_encode( $jsondata );
	}

	public function municipality_list()
	{
		$this->load->model('General_model', '', TRUE);
		$provCode = $this->input->POST('provCode');
		$municipality_list = $this->General_model->get_municipality($provCode);
		echo json_encode($municipality_list);
	}
	public function brgy_list()
	{
		$this->load->model('General_model', '', TRUE);
		$citymunCode = $this->input->POST('citymunCode');
		$brgy_list = $this->General_model->get_brgy($citymunCode);
		echo json_encode($brgy_list);
	}

    public function get_clients()
	{
		$search = $this->input->POST('search');
		$group_id = $this->input->POST('group_id');
		$this->load->model('General_model');
		$data = $this->General_model->client_list($search,$group_id);
		echo json_encode($data);
	} 

    public function get_est()
	{
		$search = $this->input->POST('search');
		$this->load->model('General_model');
		$data = $this->General_model->est_list($search);
		echo json_encode($data);
	}

    public function get_not_member()
	{
		$search = $this->input->POST('search');
		$est_id = $this->input->POST('est_id');
		$this->load->model('General_model');
		$data = $this->General_model->not_member($search,$est_id);
		echo json_encode($data);
	}

	public function captcha_generator(){
		$random_alpha = md5(rand());
		$captcha_code = substr($random_alpha, 0, 6);
		$this->session->set_userdata('captcha', $captcha_code);
		$target_layer = imagecreatetruecolor(70,30);
		$captcha_background = imagecolorallocate($target_layer, 255, 160, 119);
		imagefill($target_layer,0,0,$captcha_background);
		$captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0);
		imagestring($target_layer, 5, 5, 5, $captcha_code, $captcha_text_color);
		header("Content-type: image/jpeg");
		imagejpeg($target_layer);
	} 

	public function import(){
		$this->isLogin();
		$this->load->model('General_model', '', TRUE);
		$this->load->model('Vaccination_model', '', TRUE);
		$this->load->model('Admin_model', '', TRUE);
		$this->load->model('Contact_tracing_model', '', TRUE);
		$list = $this->General_model->list('vaccination2');
		$exist = 0;
		$new = 0;
						$exist_vaccination = 0;
				$new_vaccination = 0;

		foreach($list as $val){
			$provCode = explode('_',$val->provCode);
			$citymunCode = explode('_',$val->citymunCode);
			$brgyCode = explode('_',$val->brgyCode);
			$val->provCode = $provCode[1];
			$val->citymunCode = $citymunCode[1];
			$val->brgyCode = $brgyCode[1];
			$val->active = 1;
			$data = new stdClass();
			$data->fname = $val->fname;
			$data->lname = $val->lname;
			$data->mname = $val->mname;
			$data->birthday = date("Y-m-d", strtotime($val->birthday));
			$val->birthday = date("Y-m-d", strtotime($val->birthday));
			$check = $this->Admin_model->checker_dynamic('clients',$data);
			if($check){
				$exist++;
				$details = $this->Vaccination_model->get_details($data);
				$where = new stdClass();
				$where->id = $details[0]->id;
				$id= $details[0]->id;
				$this->Vaccination_model->update($val,$where,'clients');
				$val->userid = $details[0]->id;
			}else{
				$new++;
				$id = $this->Vaccination_model->add($val,'clients');
				$where = new stdClass();
				$where->id = $id;
				//$details = $this->Vaccination_model->get_details($where);
				$val->userid = $id;
				$update = new stdClass();
				$update->qrcode = $val->brgyCode . '-' . str_pad($id, 6, '0', STR_PAD_LEFT);
				//update client qrcode
				$this->Contact_tracing_model->update_client_qrcode($id,$update);
			}
			$where2 = new stdClass();
			$where2->userid = $id;
			$check2 = $this->Admin_model->checker_dynamic('vaccination',$where2);
				unset($val->vac_id);

			if($check2){
				$exist_vaccination++;
				$val->date_reg = date("Y-m-d H:i:s", strtotime($val->date_reg));
				$this->Vaccination_model->update($val,$where2,'vaccination');
			}else{
				$new_vaccination++;
				$val->date_reg = date("Y-m-d H:i:s", strtotime($val->date_reg));
			 	$this->Vaccination_model->add($val,'vaccination');
			}
		}
		 	echo $exist.'<br>';
		 	echo $new.'<br>';
		 	echo $exist_vaccination.'<br>';
		 	echo $new_vaccination.'<br>';
	}

	public function update_clients(){
		$this->isLogin();
		$this->load->model('General_model', '', TRUE);
		$this->load->model('Vaccination_model', '', TRUE);
		$this->load->model('Admin_model', '', TRUE);
		$this->load->model('Contact_tracing_model', '', TRUE);
		$list = $this->General_model->list('vaccination2');
		$exist = 0;
		$new = 0;
						$exist_vaccination = 0;
				$new_vaccination = 0;
				$update = new stdClass();
		foreach($list as $val){
			$provCode = explode('_',$val->provCode);
			$citymunCode = explode('_',$val->citymunCode);
			$brgyCode = explode('_',$val->brgyCode);
			$val->provCode = $provCode[1];
			$val->citymunCode = $citymunCode[1];
			$val->brgyCode = $brgyCode[1];
			$val->active = 1;
			$data = new stdClass();
			$data->fname = $val->fname;
			$data->lname = $val->lname;
			$data->mname = $val->mname;
			$data->birthday = date("Y-m-d", strtotime($val->birthday));
			$val->birthday = date("Y-m-d", strtotime($val->birthday));
			$check = $this->Admin_model->checker_dynamic('clients',$data);
			if($check){
				$exist++;
				$details = $this->Vaccination_model->get_details($data);
				$where = new stdClass();
				$where->id = $details[0]->id;
				$id= $details[0]->id;
				$val->userid = $details[0]->id;
				$update->contact_number = $val->contact_number;
				$this->Vaccination_model->update($update,$where,'clients');
			}
		 }
	 	echo $exist.'<br>';
	 	echo $new.'<br>';
	}

	public function update_specificrow(){
		$this->isLogin();
		$this->load->model('General_model', '', TRUE);
		$this->load->model('Vaccination_model', '', TRUE);
		$this->load->model('Admin_model', '', TRUE);
		$this->load->model('Contact_tracing_model', '', TRUE);
		$list = $this->General_model->list('vaccination2');
		$exist = 0;
		$new = 0;
		$exist_vaccination = 0;
		$new_vaccination = 0;
		$update = new stdClass();
		//$not_found = new stdClass();
		foreach($list as $val){
			$data = new stdClass();
			$data->fname = $val->fname;
			$data->lname = $val->lname;
			$data->mname = $val->mname;
			$data->birthday = date("Y-m-d", strtotime($val->birthday));
			$val->birthday = date("Y-m-d", strtotime($val->birthday));
			$check = $this->Admin_model->checker_dynamic('clients',$data);
			if($check){
				$exist++;
				$details = $this->Vaccination_model->get_details($data);
				$where = new stdClass();
				$where->id = $details[0]->id;
				$id= $details[0]->id;
				$val->userid = $details[0]->id;

				$update->birthday = $val->birthday_corrected;

				$this->Vaccination_model->update($update,$where,'clients');
				$found[]=array('fname'=>$val->fname, 'lname'=>$val->lname, 'mname'=>$val->mname, 'birthday' => $val->birthday);

			}else{
				$new++;
				$not_found[]=array('fname'=>$val->fname, 'lname'=>$val->lname, 'mname'=>$val->mname, 'birthday' => $val->birthday);
			}
		 }
	 	echo $exist.'<br>';
	 	echo $new.'<br>';
		echo '<pre>' . var_export($not_found, true) . '</pre>';
	}

	public function update_citymun(){
		$this->isLogin();
		$this->load->model('General_model', '', TRUE);
		$list = $this->General_model->list('prov');
		foreach($list as $val){
			$data = new stdClass();
			$data->codeprov = $val->province;

			$where = new stdClass();
			$where->psgcCode = $val->code;

			$this->General_model->update($data,$where,'refprovince');
		 }
	}
}
