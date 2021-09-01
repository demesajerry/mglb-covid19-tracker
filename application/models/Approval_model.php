<?php
	class Approval_model extends CI_Model
	{
		var $table = 'clients';
		var $column_order = array('id', 'lname','fname','mname','address','refbrgy.brgyDesc','refcitymun.citymunDesc','birthday','contact_number','covid_status.c_classification'); //set column field database for datatable orderable
		var $column_search = array('lname','fname','mname','address','refbrgy.brgyDesc','refcitymun.citymunDesc','birthday','contact_number','covid_status.c_classification'); //set column field database for datatable searchable 
		var $order = array('id' => 'asc'); // default order 
 


		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function _get_datatables_query(){
	        //add custom filter here
	        if($this->input->post('provCode')){
	            $this->db->where('clients.provCode', $this->input->post('provCode'));
	        } 
	        if($this->input->post('citymunCode')){
	            $this->db->like('clients.citymunCode', $this->input->post('citymunCode'));
	        } 
	        if($this->input->post('brgyCode')){
	            $this->db->like('clients.brgyCode', $this->input->post('brgyCode'));
	        } 
	        if($this->input->post('status_filter')){
	            $this->db->like('clients.status', $this->input->post('status_filter'));
	        }
	 
	        $this->db->from($this->table);  
	        $this->db->select("clients.*, covid_status.c_status_id,covid_status.c_classification, refbrgy.brgyCode, refbrgy.brgyDesc,refcitymun.citymunCode, refcitymun.citymunDesc");
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode');
        	$this->db->join('covid_status','covid_status.c_status_id = clients.status','left');
        	$this->db->where('clients.active',0);

	        $i = 0;
	     
	        foreach ($this->column_search as $item) // loop column 
	        {
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
	         
	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->order))
	        {
	            $order = $this->order;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
	    }

		public function get_datatables(){
	        $this->_get_datatables_query();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $query = $this->db->get();
	        return $query->result();
	    }

	    public function count_filtered(){
	        $this->_get_datatables_query();
	        $query = $this->db->get();
	        return $query->num_rows();
	    }
	 
	    public function count_all()
	    {
	        $this->db->from($this->table);
	        return $this->db->count_all_results();
	    } 

	    public function get_by_id($id){
			$this->db->from($this->table);
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $query->row();
		}
  
		public function update($where, $data){
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
		}

		public function get_brgy_list(){
			$this->db->select('brgyDesc,brgyCode,citymunCode');
			$this->db->from('refbrgy');
			$this->db->where('citymunCode', '043411'); 
			return $this->db->get()->result_object(); 
		}

		public function get_citymun_list(){
			$this->db->select('citymunDesc,citymunCode');
			$this->db->from('refcitymun'); 
			return $this->db->get()->result_object(); 
		}

		public function get_status_list(){
			$this->db->select('a.*');
			$this->db->from('covid_status a');
			$this->db->where('a.status',1);
			return $this->db->get()->result_object(); 
		} 
	}
?>

