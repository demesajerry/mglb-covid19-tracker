<?php
	class Admin_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function list($table){
			$this->db->select('*');
			$this->db->from($table);
			//$this->db->order_by($table,'ASC');
			return $this->db->get()->result_object(); 
		}

		public function search_list($table,$where,$where_clause){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($where_clause,$where);
			//$this->db->order_by($table,'ASC');
			return $this->db->get()->result_object(); 
		}

		public function active_scanners(){
			$this->db->select('a.scanner_name, a.time_log, IFNULL(b.scan_count, 0) as scan_count, a.location');
			$this->db->from('active_scanners a');
			$this->db->join('(select est_id, count(*) as scan_count from tracks where date(datetime) = "'.date('Y-m-d').'" group by est_id) b','b.est_id = a.est_id','left');
			$this->db->where('a.date_log',date('Y-m-d'));
			//$query = $this->db->get('');
			//echo $this->db->last_query();
			return $this->db->get()->result_object(); 
		}

		public function check_alerts(){
			$this->db->select('a.alert_id, concat(c.lname,",",c.fname," ",c.mname) as fullname, a.checked, b.datetime, e.name as establishment');
			$this->db->from('alerts a');
			$this->db->join('tracks b','b.id = a.track_id','INNER');
			$this->db->join('clients c','c.id = b.client_id');
			$this->db->join('covid_status d','d.c_status_id = a.alert_status');
			$this->db->join('establishments e','e.id = b.est_id');
			$this->db->where('a.date',date("Y-m-d"));
			$this->db->order_by('b.datetime','DESC');
			//$query = $this->db->get('');
			//echo $this->db->last_query();
			return $this->db->get()->result_object(); 
		}

		public function checker($where,$table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($table,$where);
			$query = $this->db->get('');
			//echo $this->db->last_query();
			$num = $query->num_rows();
			return $num;
		}

		public function checker_dynamic($table,$where){
			$this->db->select('*');
			$this->db->from($table);
			foreach($where as $key=>$val){
				$this->db->where($key,$val);
			}
			$query = $this->db->get('');
			//echo $this->db->last_query();
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function check_estlog($est_id){
			$this->db->select('*');
			$this->db->from('active_scanners');
			$this->db->where('est_id',$est_id);
			$this->db->where('date_log',date('Y-m-d'));
			$query = $this->db->get('');
			//echo $this->db->last_query();
			$num = $query->num_rows();
			return $num;
		}

		public function category_list(){
			$this->db->select('*');
			$this->db->from('category');
			return $this->db->get()->result_object(); 
		}

		public function add($data,$table){
			$this->db->insert($table, $data);
			$insert_id = $this->db->insert_id();
   			return  $insert_id;
		}

		public function edit($data,$id,$table,$id_name){
			$this->db->where($id_name, $id); 
			$this->db->update($table, $data); 
			//echo $this->db->last_query();
		}

		public function delete($id,$table_id,$table){
			$this->db->where($table_id,$id);
			$this->db->delete($table); 
		}

		public function exempted_list($group_id){
			$this->db->select('concat(c.lname,", ", c.fname, " ", c.mname) as fullname, exemption_id');
			$this->db->from('oddeven_exemption a');
			$this->db->join('establishments b','b.group_id = a.group_id');
			$this->db->join('clients c','c.id = a.client_id');
			$this->db->where('a.group_id',$group_id);
			$this->db->group_by('b.group_id, a.client_id');
			$this->db->order_by('a.exemption_id','DESC');
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();

			return $result; 
		}

		public function access_list($at_id){
			$this->db->select('a.*, b.link ');
			$this->db->from('access a');
			$this->db->join('link b','b.link_id = a.link_id');
			$this->db->where('a.at_id',$at_id);
			$this->db->order_by('a.a_id','DESC');
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();

			return $result; 
		}

		public function links_list($search,$at_id){
			$this->db->select('a.*');
			$this->db->from('link a');
			if($at_id!=''){
			$this->db->join('(select at_id, link_id from access where at_id = '.$at_id.') b','b.link_id = a.link_id', 'left');
			$this->db->where('b.at_id IS NULL');
			}
			if($search!=''){
				$this->db->like('link',$search);
			}
			$this->db->limit('20');
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();

			return $result; 
		}

		public function get_sms($offset){
			$this->db->select('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) AS age, contact_number, fname, lname');
			$this->db->from('clients');
			$this->db->where('TIMESTAMPDIFF(YEAR, birthday, CURDATE()) >=', "25");
			$this->db->where('TIMESTAMPDIFF(YEAR, birthday, CURDATE()) <', "60");
			$this->db->limit('1',$offset);
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();

			return $result; 
		}

		public function get_offset(){
			$this->db->select('*');
			$this->db->from('offset');
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();
			return $result; 
		}

		public function update_offset($data){
			$this->db->update('offset', $data); 
			//echo $this->db->last_query();
		}
		
		public function add_adverse_event($data){		
			$this->db->insert('adverse_event', $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}
 
		public function edit_adverse_event($data,$id){
			$this->db->where('av_id', $id); 
			$this->db->update('adverse_event', $data);  
		}

		public function get_adverse_list(){
			$this->db->select('a.*');
			$this->db->from('adverse_event a');
			return $this->db->get()->result_object(); 
		}

		public function get_vac_site_list(){
			$this->db->select('a.*');
			$this->db->from('vac_site a');
			return $this->db->get()->result_object(); 
		}

		public function add_vac_site($data){		
			$this->db->insert('vac_site', $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}
 
		public function edit_vac_site($data,$vac_site_id){
			$this->db->where('vac_site_id', $vac_site_id); 
			$this->db->update('vac_site', $data);  
		}

		public function add_vaccine($data){		
			$this->db->insert('vaccines', $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}
 
		public function edit_vaccine($data,$id){
			$this->db->where('vaccine_id', $id); 
			$this->db->update('vaccines', $data);  
		}

		public function get_vaccine_list(){
			$this->db->select('a.*');
			$this->db->from('vaccines a');
			return $this->db->get()->result_object(); 
		}

		public function add_indigent($data){		
			$this->db->insert('indigent', $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}
 
		public function edit_indigent($data,$id){
			$this->db->where('ind_id', $id); 
			$this->db->update('indigent', $data);  
		}

		public function get_indigent_list(){ 
			$this->db->from('indigent');
			return $this->db->get()->result_object(); 
		}
	}
?>

