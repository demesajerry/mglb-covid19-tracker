<?php
	class Classifications_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function add_classifications($data){		
			$this->db->insert('covid_status', $data); 
			$insert_id = $this->db->insert_id();
		   return  $insert_id;		
		}

		public function get_classification_list(){
			$this->db->select('a.*');
			$this->db->from('covid_status a');
			return $this->db->get()->result_object(); 
		} 
		public function edit_classifications($data,$c_status_id){
			$this->db->where('c_status_id', $c_status_id); 
			$this->db->update('covid_status', $data); 
			//echo $this->db->last_query();exit();
		} 

		public function get_covidStatus_list(){
			$this->db->select('a.*');
			$this->db->from('covid_status a');
			return $this->db->get()->result_object(); 
		}
	}
?>

