<?php
	class User_information_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function backend_authentication_details($username){
			$this->db->select('a.*, b.link as home_page');
			$this->db->from('users a');
			$this->db->where('username', $username);
			$this->db->join('link b', 'b.link_id = a.home_page','LEFT');
			$this->db->group_by('a.userid');
	        //$query = $this->db->get();
			//echo $this->db->last_query();
			//$this->db->where('password', $password);
			$this->db->limit(1);

			$query = $this->db->get();
			
			//$this->db->query("UPDATE `backend_user_info` set last_login_date = UNIX_TIMESTAMP(NOW()) where username ='" .$username. "' and password='".sha1($password)."'");
			
			if($query->num_rows() == 1)
			{
				$result = $query->result();
				return $result[0];
			}
			else
			{
				return false;
			}
		}		

		public function est_login($username, $password){
			$this->db->select('a.*,b.brgyDesc,c.citymunDesc');
			$this->db->from('establishments a');
			$this->db->join('refbrgy b','b.brgyCode = a.brgyCode');
			$this->db->join('refcitymun c','c.citymunCode = a.citymunCode');
			$this->db->where('username', $username);
			$this->db->where('password', $password);
			$this->db->limit(1);

			$query = $this->db->get();
			
			//$this->db->query("UPDATE `backend_user_info` set last_login_date = UNIX_TIMESTAMP(NOW()) where username ='" .$username. "' and password='".sha1($password)."'");
			
			if($query->num_rows() == 1)
			{
				$result = $query->result();
				return $result[0];
			}
			else
			{
				return false;
			}
		}		

		public function user_login($username){
			$this->db->select('a.*,b.brgyDesc,c.citymunDesc,d.provDesc, CONCAT(a.fname, " ", a.lname) AS fullname, a.password');
			$this->db->from('clients a');
			$this->db->join('refbrgy b','b.brgyCode = a.brgyCode','left');
			$this->db->join('refcitymun c','c.citymunCode = a.citymunCode','left');
			$this->db->join('refprovince d','d.provCode = a.provCode','left');
			$this->db->where('username', $username);
			//$this->db->where('password', $password);

			$query = $this->db->get();
			
			//$this->db->query("UPDATE `backend_user_info` set last_login_date = UNIX_TIMESTAMP(NOW()) where username ='" .$username. "' and password='".sha1($password)."'");
			
			if($query->num_rows() >= 1)
			{
				$result = $query->result();
				return $query->row_array();
			}
			else
			{
				return false;
			}		
		}		

		public function tagger_login($username){
			$this->db->select('a.*, b.brgyDesc');
			$this->db->from('tagger_account a');
			$this->db->join('refbrgy b','b.brgyCode = a.brgyCode','left');
			$this->db->where('username', $username);
			//$this->db->where('password', $password);

			$query = $this->db->get();
			
			//$this->db->query("UPDATE `backend_user_info` set last_login_date = UNIX_TIMESTAMP(NOW()) where username ='" .$username. "' and password='".sha1($password)."'");
			
			if($query->num_rows() >= 1)
			{
				$result = $query->result();
				return $result[0];
			}
			else
			{
				return false;
			}		
		}		
		
		public function get_links($at_id){
			$this->db->select('b.label, b.link');
			$this->db->from('access a');
			$this->db->join('link b','b.link_id = a.link_id');
			foreach($at_id as $val){
				$this->db->or_where('a.at_id',$val);
			}
			$query = $this->db->get();
			//echo $this->db->last_query();
			
			$result = $query->result();
			return $result;
		}		
	}
?>

