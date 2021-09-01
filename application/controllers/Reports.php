<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this->tracks();
	}

	public function tracks()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/tracks';
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('Establishment_model', '', TRUE);
		//$this->data['client_list'] = $this->Clients_model->get_clients_list();
		//$this->data['est_list'] = $this->Establishment_model->get_est_list();
		$this->load->view('template/admin', $this->data);
	}


	public function post_vaccination()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/post_vaccination';
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model', '', TRUE);
		$selected_mun = '43411';//LB as initial selected
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$where = new stdClass();
		$where->status = 0;
        $this->data['category'] = $this->General_model->filter_list('','priority_group','priority_group');
		$this->data['vac_site'] = $this->General_model->list('vac_site');
		$this->data['vaccines'] = $this->General_model->list('vaccines');
		//$this->data['client_list'] = $this->Clients_model->get_clients_list();
		//$this->data['est_list'] = $this->Establishment_model->get_est_list();
		$this->load->view('template/admin', $this->data);
	}

	public function vas_line()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/vas_line';
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model', '', TRUE);
		$selected_mun = '43411';//LB as initial selected
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$where = new stdClass();
		$where->status = 0;
        $this->data['category'] = $this->General_model->filter_list('','priority_group','priority_group');
		$this->data['vac_site'] = $this->General_model->list('vac_site');
		$this->data['vaccines'] = $this->General_model->list('vaccines');
		//$this->data['client_list'] = $this->Clients_model->get_clients_list();
		//$this->data['est_list'] = $this->Establishment_model->get_est_list();
		$this->load->view('template/admin', $this->data);
	}


	public function vaccination()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/vaccination';
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('General_model', '', TRUE);
		$selected_mun = '43411';//LB as initial selected
		$this->data['brgy_list'] = $this->General_model->get_brgy($selected_mun);
		$where = new stdClass();
		$where->status = 0;
        $this->data['category'] = $this->General_model->filter_list('','priority_group','priority_group');
		//$this->data['client_list'] = $this->Clients_model->get_clients_list();
		//$this->data['est_list'] = $this->Establishment_model->get_est_list();
		$this->load->view('template/admin', $this->data);
	}

	public function mho()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/mho';
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('Establishment_model', '', TRUE);
		//$this->data['client_list'] = $this->Clients_model->get_clients_list();
		//$this->data['est_list'] = $this->Establishment_model->get_est_list();
		$this->load->view('template/admin', $this->data);
	}

	public function health_dec()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/health_dec';
		$this->load->model('Clients_model', '', TRUE);
		$this->load->model('Establishment_model', '', TRUE);
		$this->data['symptoms_list'] = $this->Clients_model->get_symptoms_list();
		$this->load->view('template/admin', $this->data);
	}

	public function close_contact()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/close_contact';
		$this->load->view('template/admin', $this->data);
	}

	public function age_bracket()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/age_bracket';
		$this->load->view('template/admin', $this->data);
	}

	public function est_logs()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/est_logs';
		$this->load->view('template/admin', $this->data);
	}

	public function get_tracks(){
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$alert = $this->input->post('alert');
		$search->date_from =  '';
		$search->date_to = '';
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			$search->alert =  $alert;
			$data->date['date1'] =  $date[0];
			$data->date['date2'] = $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		}

		$search->client_id = $this->input->post('client_id');
		$search->est_id = $this->input->post('est_id');
		$data->date['date'] = $this->input->post('date');
		$data->tracks = $this->Reports_model->get_tracks($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_post_vac(){
		ini_set('memory_limit', '-1');
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date_start = $this->input->post('date_start');
		$date_end = $this->input->post('date_end'); 
		$min_age = $this->input->post('min_age');
		$max_age = $this->input->post('max_age');
		$category = $this->input->post('category');
		$brgyCode = $this->input->post('brgyCode');
		$with_comorbidity = $this->input->post('with_comorbidity'); 
		$deferred = $this->input->post('deferred');
		$vac_site1 = $this->input->post('vac_site1'); 
		$vac_site2 = $this->input->post('vac_site2'); 
		$vaccinator = $this->input->post('vaccinator');
		$vac_manufacturer = $this->input->post('vac_manufacturer');
		$dose = $this->input->post('dose');
		$acct_status = $this->input->post('acct_status');
		 
		$search->date_start =  $date_start;
		$search->date_end =  $date_end;
		$search->min_age =  $min_age;
		$search->max_age =  $max_age;
		$search->category =  $category;
		$search->brgyCode =  $brgyCode;
		$search->with_comorbidity =  $with_comorbidity;
		$search->deferred =  $deferred; 
		$search->vac_site1 =  $vac_site1;
		$search->vac_site2 =  $vac_site2; 
		$search->vaccinator =  $vaccinator; 
		$search->vac_manufacturer =  $vac_manufacturer; 
		$search->dose =  $dose; 
		$search->acct_status =  $acct_status;
		 
		$data->date_start =  $date_start;
		$data->date_end =  $date_end;

		$data->tracks = $this->Reports_model->get_post_vac($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	
	public function get_vac(){
		ini_set('memory_limit', '-1');
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		$min_age = $this->input->post('min_age');
		$max_age = $this->input->post('max_age');
		$category = $this->input->post('category');
		$brgyCode = $this->input->post('brgyCode');
		$with_comorbidity = $this->input->post('with_comorbidity');
		$next_vac_date = $this->input->post('next_vac_date');

		$search->date_reg =  $date.' '.$time;
		$search->min_age =  $min_age;
		$search->max_age =  $max_age;
		$search->category =  $category;
		$search->brgyCode =  $brgyCode;
		$search->with_comorbidity =  $with_comorbidity;
		$search->next_vac_date =  $next_vac_date;
		$data->date_reg =  $date.' '.$time;

		$data->tracks = $this->Reports_model->get_vac($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_mho(){
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$search->date_from =  '';
		$search->date_to = '';
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			$data->date['date1'] =  $date[0];
			$data->date['date2'] = $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		}

		$search->est_id = 485;
		$data->date['date'] = $this->input->post('date');
		$data->tracks = $this->Reports_model->get_mho($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_health_dec(){
		$this->load->model('Reports_model');
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$ddate = $this->input->post('date_declared');
		$search->date_from =  '';
		$search->date_to = '';
		$search->ddate_from =  '';
		$search->ddate_to = '';
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			//$data->date['date1'] =  $date[0];
			//$data->date['date2'] = $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		}
		if($ddate!=''){
			$ddate = explode(" - ",$ddate);
			$search->ddate_from =  $ddate[0];
			$search->ddate_to = $ddate[1];
			$data->date['dfrom'] =  date("M d, Y", strtotime($ddate[0]));
			$data->date['dto'] = date("M d, Y", strtotime($ddate[1]));
		}

		$search->client_id = $this->input->post('client_id');
		$search->symptoms_id = $this->input->post('symptoms_id');
		$data->date['date'] = $this->input->post('date');
		$data->tracks = $this->Reports_model->get_health_dec($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_close_contact(){
		$this->load->model('Reports_model');
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$ddate = $this->input->post('date_declared');
		$search->date_from =  '';
		$search->date_to = '';
		$search->ddate_from =  '';
		$search->ddate_to = '';
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			//$data->date['date1'] =  $date[0];
			//$data->date['date2'] = $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		}
		if($ddate!=''){
			$ddate = explode(" - ",$ddate);
			$search->ddate_from =  $ddate[0];
			$search->ddate_to = $ddate[1];
			$data->date['dfrom'] =  date("M d, Y", strtotime($ddate[0]));
			$data->date['dto'] = date("M d, Y", strtotime($ddate[1]));
		}

		$search->client_id = $this->input->post('client_id');
		$data->date['date'] = $this->input->post('date');
		$data->tracks = $this->Reports_model->get_close_contact($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_age_bracket(){
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$search->date_from =  '';
		$search->date_to = '';
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		}

		$search->est_id = $this->input->post('est_id');
		$data->date['date'] = $this->input->post('date');
		$data->tracks = $this->Reports_model->get_age_bracket($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_est_logs(){
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$search->date_from =  '';
		$search->date_to = '';
		if($date!='' || $this->input->post('est_id') !=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
			$search->est_id = $this->input->post('est_id');
			$search->alert = $this->input->post('alert');
			$data->date['date'] = $this->input->post('date');
			$data->tracks = $this->Reports_model->get_est_logs($search);
			$data->error_log = '';
		}else{
			$data->error_log = 'Establishment and date log is required!';
		}

		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function print_tracks()
	{
		$this->data['content'] = 'reports/print/client_count';
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$search = new stdClass();
		$date = explode(" - ",$this->input->post('date'));

		$search->group_by = $this->input->post('group_by');
		$search->date_from =  $date[0];
		$search->date_to =  $date[1];
		$search->poc =  (!empty($this->input->post('poc')))?$this->input->post('poc'):'';
		$this->data['from'] = $date[0];
		$this->data['to'] = $date[1];
		$this->data['poc'] = $search->poc;
		$this->data['station'] = $this->general_model->get_one_row('health_station','station_id',$search->poc);
		$this->data['client_count'] = $this->reports_model->client_count($search);
		$this->data['client_count'] = $this->reports_model->client_count($search);
		$this->load->view('template/print_head', $this->data);
	}

	public function vac_category()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/vac_category';
		$this->data['vaccines'] = $this->General_model->list('vaccines');
		$this->load->view('template/admin', $this->data);
	}

	public function vac_per_brgy()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/vac_per_brgy';
		$this->load->view('template/admin', $this->data);
	}
	
	public function vac_site()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/vac_site';
		$this->data['vac_site'] = $this->General_model->list('vac_site');
		$this->load->view('template/admin', $this->data);
	}

	public function vaccine()
	{
		$this->isAllowed();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['links'] = $this->linkGenerator();
		$this->data['content'] = 'report/vaccine';
		$this->load->view('template/admin', $this->data);
	}

	public function get_vac_category(){
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$search->date_from =  '';
		$search->date_to = '';
		$search->dose = $this->input->post('dose');
		$search->vac_manufacturer = $this->input->post('vac_manufacturer');
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		}

		$data->date['date'] = $this->input->post('date');
		$data->tracks = $this->Reports_model->get_vac_category($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_vac_per_brgy(){
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$search->date_from =  '';
		$search->date_to = '';
		$search->dose = $this->input->post('dose');
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		}

		$data->date['date'] = $this->input->post('date');
		$data->tracks = $this->Reports_model->get_vac_per_brgy($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}
	
	public function get_vac_site(){
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date');
		$dose = $this->input->post('dose');
		$vac_site_id = $this->input->post('vac_site_id');
		$search->date_from =  '';
		$search->date_to = '';
		$search->dose =  $dose; 
		$search->vac_site =  $vac_site_id;
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		} 
		$data->date['date'] = $this->input->post('date'); 
		$data->tracks = $this->Reports_model->get_vac_site($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_vaccine(){
		$this->load->model('Reports_model', '', TRUE);
		$search = new stdClass();
		$data = new stdClass();
		$date = $this->input->post('date'); 
		$dose = $this->input->post('dose');
		$search->dose =  $dose;
		$search->date_from =  '';
		$search->date_to = ''; 
		if($date!=''){
			$date = explode(" - ",$this->input->post('date'));
			$search->date_from =  $date[0];
			$search->date_to =  $date[1];
			$data->date['from'] =  date("M d, Y", strtotime($date[0]));
			$data->date['to'] = date("M d, Y", strtotime($date[1]));
		} 
		$data->date['date'] = $this->input->post('date'); 
		$data->tracks = $this->Reports_model->get_vaccine($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}
}
