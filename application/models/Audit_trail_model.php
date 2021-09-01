<?php
	class Audit_trail_model extends CI_Model
	{
		var $column_order = array('fname', 'lname','client_id','datetime','action_done'); //set column field database for datatable orderable
		var $column_search = array('fname', 'lname','client_id','datetime','action_done'); //set column field database for datatable searchable 
 


		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function get_datatables($table_name){
        	$this->db->select("a.fname, a.lname, b.user_id, b.client_id, b.datetime, b.action_done");
	        $this->db->from($table_name.' b'); 
	        if($table_name == 'audit_trail'){
	        	$this->db->join('users a','a.userid = b.user_id');  
	    	}else{
	        	$this->db->join('tagger_account a','a.tagger_id = b.user_id');  
	    	}

	        $i = 0;
	        foreach ($this->column_search as $item) // loop column 
	        {
	        	$search = explode(' ', $_POST['search']['value']);
	            if($_POST['search']['value']) // if datatable send POST for search
	            {
	                 
	                if($i===0) // first loop
	                {
	                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    	$this->db->like($item, $_POST['search']['value']);
	                }
	                else
	                {
                    	$this->db->or_like($item, $_POST['search']['value']);
	                }
	 
	                if(count($this->column_search) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }
	         

	        $filtered_count = $this->db->count_all_results('', false);

	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        //$query = $this->db->get();

	        $result = new stdClass();
	        $result->count = $filtered_count;
	        $result->list = $this->db->get()->result_object();
			// echo $this->db->last_query();
	        return $result;
	    }

	    public function count_all($table_name)
	    {
	        $this->db->from($table_name);
	        return $this->db->count_all_results();
	    } 
	}
?>

