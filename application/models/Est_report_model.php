<?php
	class Est_report_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function get_datatables(){

    		$this->db->select('a.id, b.fname, b.lname, c.name as est_visited, a.datetime, ff.c_classification as sov, c.uplb ');
			$this->db->from('tracks a');
			$this->db->join('establishments c', 'c.id = a.est_id','inner');
			$this->db->join('clients b', 'b.id = a.client_id');
			$this->db->join('covid_status ff', 'ff.c_status_id = a.sov','left');
			$this->db->where("c.uplb", '1');
			if($_POST['client_id']!=''){
				$this->db->where("a.client_id", $_POST['client_id']);
			} 
			if($_POST['est_id']!=''){
				$this->db->where("a.est_id", $_POST['est_id']);
			}
			if($_POST['dov']!=''){
				$date = explode(' To ',$_POST['dov']);
				$date_from = date('Y-m-d H:i:s', strtotime($date[0]." 00:00:00"));
				$date_to = date('Y-m-d H:i:s', strtotime($date[1]." 23:59:59"));
				$this->db->WHERE('a.datetime >=',$date_from);
				$this->db->WHERE('a.datetime <=',$date_to);
			}
            if($_POST['search']['value']) // if datatable send POST for search
            {
	        	$search = explode(' ', $_POST['search']['value']);
	        	$this->db->group_start();
	        	foreach($search as $val){
					$this->db->like('concat(b.fname," ",b.lname)',$_POST['search']['value']);
				}
	        	$this->db->group_end();
            }
			$this->db->order_by('a.id','DESC');
	        $this->db->limit($_POST['length'],$_POST['start']);
	        $query = $this->db->get();
			//echo $this->db->last_query();
	        return $query->result();
	    }
	 
	    public function count_filtered()
	    {
			$this->db->select('count(*) as total');
			$this->db->from('tracks a');
			$this->db->join('establishments c', 'c.id = a.est_id','inner');
			$this->db->join('clients b', 'b.id = a.client_id');
			$this->db->where("c.uplb", '1');
			if($_POST['client_id']!=''){
				$this->db->where("a.client_id", $_POST['client_id']);
			} 

			if($_POST['est_id']!=''){
				$this->db->where("a.est_id", $_POST['est_id']);
			}

			if($_POST['dov']!=''){
				$date = explode(' To ',$_POST['dov']);
				$date_from = date('Y-m-d H:i:s', strtotime($date[0]." 00:00:00"));
				$date_to = date('Y-m-d H:i:s', strtotime($date[1]." 23:59:59"));
				$this->db->WHERE('a.datetime >=',$date_from);
				$this->db->WHERE('a.datetime <=',$date_to);
			}
            if($_POST['search']['value']) // if datatable send POST for search
            {
	        	$search = explode(' ', $_POST['search']['value']);
	        	$this->db->group_start();
	        	foreach($search as $val){
					$this->db->like('concat(b.fname," ",b.lname)',$_POST['search']['value']);
				}
	        	$this->db->group_end();
            }
	        $query = $this->db->get();
	        return $query->result()[0]->total;

		}

	    public function count_all()
	    {
			$this->db->select('count(*) as total');
			$this->db->from('tracks a');
			$this->db->join('establishments c', 'c.id = a.est_id','inner');
			$this->db->where("c.uplb", '1');
	        $query = $this->db->get();
	        return $query->result()[0]->total;
	    } 

		public function est_uplb($search,$est_id){
			$this->db->select('*');
			$this->db->from('establishments');
			$this->db->where('group_id !=',$est_id);
			$this->db->where('uplb','1');
			if($search!=''){
				$this->db->like('name',$search);
			}
			$this->db->limit('20');
			$query = $this->db->get('');
			$result = $query->result();
			//echo $this->db->last_query();

			return $result; 
		}
	}
?>

