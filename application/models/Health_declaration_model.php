<?php
	class Health_declaration_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function client_info($id){
			$this->db->select('a.brgyCode, a.address,a.birthday,a.contact_number, a.fname,a.lname, a.mname, a.username, a.sex, a.qrcode, b.citymunDesc,c.brgyDesc, d.provDesc');
			$this->db->from('clients a');
			$this->db->join('refcitymun b','b.citymunCode = a.citymunCode');
			$this->db->join('refbrgy c','c.brgyCode = a.brgyCode');
			$this->db->join('refprovince d','d.provCode = a.provCode');
			$this->db->where('a.id', $id); 
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();
			return $result[0];
		} 
		
		public function add($data){
			$this->db->insert('client_symptoms', $data); 
		}
		public function add_closed_contact($data){
			$this->db->insert('closed_contact_tbl', $data); 
		}
		public function edit($data,$symptom_id){
			$this->db->where('symptom_id', $symptom_id); 
			$this->db->update('client_symptoms', $data);  
		}  
		public function edit_closed_contact($data,$closed_contact_id){
			$this->db->where('closed_contact_id', $closed_contact_id); 
			$this->db->update('closed_contact_tbl', $data);  
		}
	}
?>

