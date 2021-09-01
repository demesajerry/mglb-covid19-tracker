<?php
	class Establishment_model extends CI_Model
	{
		var $column_order = array('id', 'name','address','contact_person','contact_number'); //set column field database for datatable orderable
		var $column_search = array('name','contact_person','contact_number'); //set column field database for datatable searchable 
		var $order = array('id' => 'asc'); // default order 

		public function __construct()
		{
			parent::__construct();
		}
		public function add($data,$table){
			$this->db->insert($table, $data); 
			return $this->db->insert_id();
		}
		public function get_est_list(){
			$this->db->select('*');
			$this->db->from('establishments');
			return $this->db->get()->result_object(); 
		}

		public function _get_datatables_query(){	 
	        $this->db->select("a.*, refbrgy.brgyCode, refbrgy.brgyDesc,refcitymun.citymunCode, refcitymun.citymunDesc");
	        $this->db->from('establishments a');  
	        $this->db->join('refbrgy','refbrgy.brgyCode = a.brgyCode'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = a.citymunCode');
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
	        $this->db->from('establishments');
	        return $this->db->count_all_results();
	    } 

	    public function get_by_id($id){
			$this->db->from('establishments');
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $query->row();
		}

		public function update($where, $data){
			$this->db->where('id',$where);
			$this->db->update('establishments', $data);
			return $this->db->affected_rows();
		}
	}
?>

