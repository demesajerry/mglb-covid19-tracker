<?php
	class A1family_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function save_rel($relatives_data){
			for($x = 0; $x < count($relatives_data); $x++){
				$data[] = array( 
					'a1_userid' => $relatives_data[$x]['userid'],
					'a1_relativeid' => $relatives_data[$x]['reluserid'],
					'relative_name' => $relatives_data[$x]['member_name'], 
					'relation' => $relatives_data[$x]['member_relation'], 
					'is_living' => $relatives_data[$x]['living'],
					'date_reg' => date('Y-m-d h:i:s'),  
				);
			} 
			try{
				for($x = 0; $x< count($relatives_data); $x++){
					$this->db->insert('a1_family', $data[$x]);
				}
				return 'success';
			}
			catch(Exception $e){
				return 'failed';
			}
		}

		public function search_userid($fname,$lname,$mname,$birthday){ 
				$this->db->select('clients.*, vaccination.category, vaccination.userid');
				$this->db->from('clients'); 
				$this->db->join('vaccination','vaccination.userid = clients.id','LEFT');
				$this->db->where('clients.fname',$fname);
				$this->db->where('clients.lname',$lname);
				$this->db->where('clients.mname',$mname);
				$this->db->where('clients.birthday',$birthday); 
				$this->db->where('vaccination.category', 1);
				$result = $this->db->get()->result_object(); 
				return $result[0]->{'id'}; 
		}

		public function check_relative($userid,$reluserid){
			$this->db->select('a1_fid');
			$this->db->from('a1_family');
			$this->db->where('a1_userid',$userid);
			$this->db->where('a1_relativeid',$reluserid); 
			$result = $this->db->get()->result_object(); 
			return $result[0]->{'a1_fid'};

			//echo $this->db->last_query();
			//exit(); 
		}

		public function get_details($where){
			$this->db->select('a.*,b.*,c.*');
			$this->db->from('clients a');
			$this->db->join('vaccination b','b.userid = a.id','LEFT');
			$this->db->join('post_vaccination c','c.userid = a.id','LEFT');
			foreach($where as $key=>$val){
				$this->db->where($key, $val); 
			}
			$query = $this->db->get();
			//echo $this->db->last_query();

			$result = $query->result();
			return $result; 
		}

		public function get_details_rel($where){
			$this->db->select('a.*,b.*,c.*');
			$this->db->from('clients a');
			$this->db->join('vaccination b','b.userid = a.id','LEFT');
			$this->db->join('post_vaccination c','c.userid = a.id','LEFT');
			foreach($where as $key=>$val){
				$this->db->where($key, $val); 
			}
			$query = $this->db->get();
			//echo $this->db->last_query();

			$result = $query->result();
			return $result; 
		}

		public function get_details_id($where,$dose){
			$this->db->select('a.*,b.*,c.*');
			$this->db->from('clients a');
			$this->db->join('vaccination b','b.userid = a.id','LEFT');
			if($dose == "1"){
				$this->db->join('(select * from post_vaccination where first_dose = "01_Yes") c','c.userid = a.id','LEFT');
			}elseif ($dose == "2") {
				$this->db->join('(select * from post_vaccination where second_dose = "01_Yes") c','c.userid = a.id','LEFT');
			}else{
				$this->db->join('post_vaccination c','c.userid = a.id','LEFT');
			}
			foreach($where as $key=>$val){
				$this->db->where($key, $val); 
			}
			$query = $this->db->get();
			//echo $this->db->last_query();

			$result = $query->result();
			return $result; 
		}

		public function update_workplace($data,$where, $table){
			$this->db->where('userid', $where); 
			$this->db->update($table, $data); 
			// echo $this->db->last_query();
			// exit(); 
		} 

		public function update($data, $where, $table){
			$update = new stdClass();
			foreach($data as $key=>$val){
				if ($this->db->field_exists($key, $table)){
					$update->{$key} = $val;
				}
			}
			$this->db->set($update);
			foreach($where as $key=>$val){
				$this->db->where($key,$val);
			}
			$this->db->update($table);
			
			return true;
		}

		public function add($data,$table){
			$add = new stdClass();
			foreach($data as $key=>$val){
				if ($this->db->field_exists($key, $table)){
					$add->{$key} = $val;
				}
			}
			$this->db->insert($table, $add);
			$insert_id = $this->db->insert_id();
   			return  $insert_id;
		}

		function clientExist($data){
		$this->db->select('a.id');
		$this->db->from('clients a');
		$this->db->join('vaccination b','b.userid = a.id', 'INNER');
		foreach($data as $key=>$val){
			$this->db->where('a.'.$key, $val);
		}
		$query = $this->db->get(); 
		    if ($query->num_rows() > 0) {
		        return true;
		    } 
		    else {
		        return false;
		    }
		}

		public function get_list(){
			$this->db->select('a.*, b.lname, b.fname, b.contact_number, sum(IF(a.approve = "1", 1,0)) AS approved, sum(IF(a.approve = "0", 1,0)) AS for_approval');
			$this->db->from('a1_family a');
			$this->db->join('clients b','b.id = a.a1_userid');
			$this->db->group_by('a1_userid');
			// $this->db->where('approve','0');
			$query = $this->db->get('');
			$result = $query->result();
			return $result; 
		}


	}
?>

