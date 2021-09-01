<?php
	class Sms_records_model extends CI_Model
	{
		var $table = 'sms';
		var $column_order = array('sms_id', 'device','number','message','action'); //set column field database for datatable orderable
		var $column_search = array('sms_id', 'device','number','message','action'); //set column field database for datatable searchable 
		var $order = array('sms_id' => 'asc'); // default order 
 


		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function get_datatables(){
	        $this->db->select("*");
	        $this->db->from($this->table);  

	        if($this->input->post('provCode')){
	            $this->db->where('clients.provCode', $this->input->post('provCode'));
	        } 
	        if($this->input->post('citymunCode')){
	            $this->db->where('clients.citymunCode', $this->input->post('citymunCode'));
	        } 
	        if($this->input->post('brgyCode')){
	            $this->db->where('clients.brgyCode', $this->input->post('brgyCode'));
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
	         
            $this->db->order_by('sms_id','ASC');

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

	    public function count_all()
	    {
	        $this->db->from($this->table);
	        return $this->db->count_all_results();
	    } 
	}
?>

