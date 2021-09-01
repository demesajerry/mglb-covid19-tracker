<?php
	class Vaccination_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
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
			//echo $this->db->last_query();
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

		function client_verify($qrcode){
		$this->db->select('a.lname, a.fname, b.date_reg, is_vaccinated, is_vaccinated_second, c.reply, c.date as date_texted, c.vac_date, d.priority_group, d.description, rs.date as latest');
		$this->db->from('clients a');
		$this->db->join('vaccination b','b.userid = a.id', 'LEFT');
		$this->db->join('sent_messages c','c.userid = a.id', 'LEFT');
		$this->db->join('priority_group d','d.pg_id = b.category', 'LEFT');
		$this->db->join('resbakuna_status rs', 'rs.category = d.priority_group');
		$this->db->where('a.qrcode', $qrcode);
		$query = $this->db->get(); 
		    if ($query->num_rows() > 0) {
		        return $query->result()[0];
		    } 
		    else {
		        return false;
		    }
		}


	}
?>

