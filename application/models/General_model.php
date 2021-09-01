<?php
	class General_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function get_one_row($table,$id_name,$id){
			$this->db->select('*');
			$this->db->from($table);
			if($id!=''){
			$this->db->where($id_name,$id);
			}
			$query = $this->db->get('');
			$result = $query->result();
			if(count($result)!=0){
				return $result[0]; 
			}
			else{
				return false;
			}		
		}
		public function list($table){
			$this->db->select('*');
			$this->db->from($table);
			$query = $this->db->get('');
			$result = $query->result();
			return $result; 
		}
		public function list_array($table){
			$this->db->select('*');
			$this->db->from($table);
			$query = $this->db->get('');
			$result = $query->result_array();
			return $result; 
		}
		public function filter_list($where,$table,$group_by){
			$this->db->select('*');
			$this->db->from($table);
			if($where!=''){
				foreach($where as $key=>$val){
					$this->db->where($key,$val);
				}
			}
			if($group_by!=false){
				$this->db->group_by($group_by);
			}
			$query = $this->db->get('');
			$result = $query->result();
			// echo $this->db->last_query();
			return $result; 
		}
		public function filter_list_date($where){
			$this->db->select('a.*, b.with_comorbidity,b.pregnancy_status, TIMESTAMPDIFF(YEAR, c.birthday, CURDATE()) AS age, d.priority_group, b.category, si.start_time, si.hour_interval, si.max_per_hour, si.end_time, si.max_client, si.over_time');
			$this->db->from('sent_messages a');
			$this->db->join('vaccination b','b.userid = a.userid');
			$this->db->join('clients c','c.id = a.userid');
			$this->db->join('priority_group d','d.pg_id = b.category');
			$this->db->join('sched_interval si','si.si_id = a.si_id');
			foreach($where as $key=>$val){
				$this->db->where("a.".$key,$val);
			}
			$this->db->where('a.vac_date >',date('Y-m-d'));
			$query = $this->db->get('');
			$result = $query->result();
			return $result; 
		}

		public function get_msg_details($where){
			$this->db->select('a.*, b.fname, b.lname');
			$this->db->from('sent_messages a');
			$this->db->join('clients b','b.id = a.userid');
			foreach($where as $key=>$val){
				$this->db->where($key,$val);
			}
			$query = $this->db->get('');
			$result = $query->result();
			return $result; 
		}

		public function get_msg_details_reminder($where,$start,$end){
			$this->db->select('a.*, b.fname, b.lname');
			$this->db->from('sent_messages a');
			$this->db->join('clients b','b.id = a.userid');
			$this->db->join('vaccination v','v.userid = a.userid');
			$this->db->join('priority_group pg','pg.pg_id = v.category');

        	$vac_date = explode(' - ',$where->vac_date);
        	$vac_date_from = date("Y-m-d", strtotime($vac_date[0]));
        	$vac_date_to = date("Y-m-d", strtotime($vac_date[1]));
            $this->db->where('vac_date >=',$vac_date_from);
            $this->db->where('vac_date <=',$vac_date_to);

			$this->db->where('reply','YES');
			$this->db->where('dose',$where->dose);
			if($where->category_group!=''){
				$this->db->where_in('priority_group',$where->category_group);
			}

			$this->db->group_by('userid');
			$this->db->limit($end,$start);

			$query = $this->db->get('');
			$result = $query->result();
			// echo $this->db->last_query();

			return $result; 
		}


		public function get_province(){
			$this->db->select('provDesc,provCode');
			$this->db->from('refprovince');
			return $this->db->get()->result_object(); 
		}
		public function get_municipality($provCode){
			$this->db->select('citymunDesc,citymunCode,provCode');
			$this->db->from('refcitymun');
			$this->db->where('provCode', $provCode); 
			return $this->db->get()->result_object(); 
		}
		public function get_brgy($citymunCode){
			$this->db->select('brgyDesc,brgyCode,citymunCode');
			$this->db->from('refbrgy');
			$this->db->where('citymunCode', $citymunCode); 
			return $this->db->get()->result_object(); 
		}
		public function get_hmo(){
			$this->db->select('*');
			$this->db->from('hmo');
			return $this->db->get()->result_object(); 
		}
		public function check_qr_exist($qrcode,$group_id){
			$this->db->select('a.id, a.fname, a.lname , a.oddeven_exemption, a.contact_number, b.brgyDesc,c.citymunDesc, TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) AS age, a.sex,a.status, b.brgyCode, b.citymunCode, d.template, a.active, group_id, a.apor');
			$this->db->from('clients a');
			$this->db->join('refbrgy b','b.brgyCode = a.brgyCode');
			$this->db->join('refcitymun c','c.citymunCode = a.citymunCode');
			$this->db->join('covid_status d','d.c_status_id = a.status');
        	$this->db->join('(select client_id, group_id from oddeven_exemption where group_id = '.$group_id.') e','e.client_id = a.id','left');
			$this->db->where('qrcode', $qrcode); 
			$query = $this->db->get();
			//echo $this->db->last_query();

			$result = $query->result();
			return $result; 
		}

		public function tagger_qr_exist($qrcode){
			$this->db->select('a.id, a.fname, a.lname , a.oddeven_exemption, b.brgyDesc,c.citymunDesc, TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) AS age, a.sex,a.status, b.brgyCode, b.citymunCode, d.template, a.active, a.apor');
			$this->db->from('clients a');
			$this->db->join('refbrgy b','b.brgyCode = a.brgyCode');
			$this->db->join('refcitymun c','c.citymunCode = a.citymunCode');
			$this->db->join('covid_status d','d.c_status_id = a.status');
			$this->db->where('qrcode', $qrcode); 
			$query = $this->db->get();
			//echo $this->db->last_query();

			$result = $query->result();
			return $result; 
		}

		public function client_list($search,$group_id){
			$this->db->select('concat(a.lname,", ",a.fname," ",a.mname) as fullname, a.id');
			$this->db->from('clients a');
			if($group_id!=''){
			$this->db->join('(select client_id from oddeven_exemption where group_id = '.$group_id.') b','b.client_id = a.id', 'left');
			$this->db->where('b.client_id IS NULL');
			}
			if($search!=''){
				$this->db->group_start();
					$this->db->like('concat_ws(" ",a.lname,a.fname,a.mname)',$search);
					$this->db->or_like('concat_ws(" ",a.fname,a.lname,a.mname)',$search);
					$this->db->or_like('concat(a.lname,", ",a.fname," ",a.mname)',$search);
				$this->db->group_end();
			}
			$this->db->limit('20');
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();

			return $result; 
		}

		public function est_list($search){
			$this->db->select('*');
			$this->db->from('establishments');
			if($search!=''){
				$this->db->like('name',$search);
			}
			$this->db->group_by('group_id');
			$this->db->limit('20');
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();

			return $result; 
		}

		public function not_member($search,$est_id){
			$this->db->select('*');
			$this->db->from('establishments');
			$this->db->where('group_id !=',$est_id);
			if($search!=''){
				$this->db->like('name',$search);
			}
			$this->db->limit('20');
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();

			return $result; 
		}

		public function link_tree(){
			$this->db->select('*');
			$this->db->from('link');
			$this->db->where('status',0);
			$this->db->order_by('link_id','ASC');
			return $this->db->get()->result_object(); 
		}

		public function update($data,$where,$table){
			foreach($where as $key=>$val){
				$this->db->where($key,$val); 
			}
			$this->db->update($table, $data); 
			return $this->db->last_query();
		}

		public function add($data,$table){
			$this->db->insert($table, $data);
			$insert_id = $this->db->insert_id();
   			return  $insert_id;
		}

		public function checker_dynamic($where,$table){
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

		public function list_dynamic($where,$table){
			$this->db->select('*');
			$this->db->from($table);
			foreach($where as $key=>$val){
				$this->db->where($key,$val);
			}
			$query = $this->db->get('');
			//echo $this->db->last_query();
			if($query->num_rows() > 0){
				$result = $query->result();
				return $result; 
			}else{
				return false;
			}
		}

		public function count_dynamic($where,$table){
			$this->db->select('*');
			$this->db->from($table);
			foreach($where as $key=>$val){
				$this->db->where($key,$val);
			}
			$query = $this->db->get('');
			//echo $this->db->last_query();
			if($query->num_rows() > 0){
				return $query->num_rows();
			}else{
				return false;
			}
		}

		public function get_user_details($userid,$dose){
			$this->db->select('a.*, b.with_comorbidity, c.vac_date, TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) AS age');
			$this->db->from('clients a');
			$this->db->join('vaccination b','b.userid = a.id');
			$this->db->join('sent_messages c','c.userid = a.id');
			$this->db->where('a.id',$userid);
			$this->db->where('c.dose',$dose);
			$query = $this->db->get('');
			$result = $query->result();
			return $result; 
		}

		public function delete($id,$table_id,$table){
			$this->db->where($table_id,$id);
			$this->db->delete($table); 
		}

		public function get_doses($where,$table,$group_by){
			$this->db->select('post_vaccination.vac_date ,post_vaccination.post_vac_id ,post_vaccination.userid, post_vaccination.first_dose, post_vaccination.second_dose,  post_vaccination.vac_date,  post_vaccination.date_added, vaccines.manufacturer ');
			$this->db->from($table);
			if($where!=''){
				foreach($where as $key=>$val){
					$this->db->where($key,$val);
				}
			}
			if($group_by!=false){
				$this->db->group_by($group_by);
			}
			$this->db->join('vaccines','vaccines.vaccine_id = post_vaccination.vac_manufacturer');
			$query = $this->db->get('');
			$result = $query->result();
			// echo $this->db->last_query();
			return $result; 
		}

		public function fetch_prefixes(){
			$this->db->select('*');
			$this->db->from('mobile_prefix');
			$query = $this->db->get('');
			$result = $query->result();

	        $prefix = array();
	        foreach($result as $val){
	        	$prefix[] = $val->prefix;
	        }

			return $prefix; 
		}
	}
?>

