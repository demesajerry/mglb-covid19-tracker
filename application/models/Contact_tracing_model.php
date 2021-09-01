<?php
	class Contact_tracing_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function client_info($id){
			$this->db->select('a.brgyCode, a.address,a.birthday,a.contact_number, a.fname,a.lname, a.mname, a.username, a.sex, a.qrcode, b.citymunDesc,c.brgyDesc, d.provDesc');
			$this->db->from('clients a');
			$this->db->join('refcitymun b','b.citymunCode = a.citymunCode','LEFT');
			$this->db->join('refbrgy c','c.brgyCode = a.brgyCode','LEFT');
			$this->db->join('refprovince d','d.provCode = a.provCode','LEFT');
			$this->db->where('a.id', $id); 
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();
			return $result[0];
		}

		public function client_info_resbakuna($id){
			$this->db->select('a.brgyCode, a.address,a.birthday,a.contact_number, a.fname,a.lname, a.mname, a.username, a.sex, a.qrcode, b.citymunDesc,c.brgyDesc, d.provDesc, DATE_FORMAT(v.date_reg, "%b&nbsp;%d, %Y %H:%i:%s") as date_reg ');
			$this->db->from('clients a');
			$this->db->join('refcitymun b','b.citymunCode = a.citymunCode','LEFT');
			$this->db->join('refbrgy c','c.brgyCode = a.brgyCode','LEFT');
			$this->db->join('refprovince d','d.provCode = a.provCode','LEFT');
			$this->db->join('vaccination v','v.userid = a.id','LEFT');
			$this->db->where('a.id', $id); 
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();
			return $result[0];
		}

		public function est_info($id){
			$this->db->select('a.*,b.citymunDesc,c.brgyDesc');
			$this->db->from('establishments a');
			$this->db->join('refcitymun b','b.citymunCode = a.citymunCode');
			$this->db->join('refbrgy c','c.brgyCode = a.brgyCode');
			$this->db->where('a.id', $id); 
			$query = $this->db->get('');
			$result = $query->result();
			return $result[0];
		}

		public function add($data,$table){
			$this->db->insert($table, $data); 
			return $this->db->insert_id();
		}

		public function update_client_qrcode($id,$qrcode){
			$this->db->where('id', $id); 
			$this->db->update('clients', $qrcode); 
			//echo $this->db->last_query();
		}

		public function update_est_group($id,$group_id){
			$this->db->where('id', $id); 
			$this->db->update('establishments', $group_id); 
			//echo $this->db->last_query();
		}

		public function check_duplicate_client($data){
			$this->db->select('*');
			$this->db->from('clients');
			$this->db->where('fname', $data->fname); 
			$this->db->where('lname', $data->lname); 
			$this->db->where('mname', $data->mname); 
			$this->db->where('birthday', $data->birthday); 
			$query = $this->db->get();
	        //if no records found
	        if($query->num_rows()>0){
	        	return true;
	        }else{
	        	return false;
	        }
		}

		public function check_duplicate_est($data){
			$this->db->select('*');
			$this->db->from('establishments');
			$this->db->where('name', $data->name); 
			$query = $this->db->get();
	        //if no records found
	        if($query->num_rows()>0){
	        	return true;
	        }else{
	        	return false;
	        }
		}

		public function check_duplicate_qrcode($data){
			$this->db->select('*');
			$this->db->from('clients');
			$this->db->where('qrcode', $data->qrcode); 
			$query = $this->db->get('');
	        if($query->num_rows()>0){
	        	return true;
	        }else{
	        	return false;
	        }
		}
		public function check_duplicate_username($data,$table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where('username', $data->username); 
			$query = $this->db->get('');
	        if($query->num_rows()>0){
	        	return true;
	        }else{
	        	return false;
	        }
		}
	}
?>

