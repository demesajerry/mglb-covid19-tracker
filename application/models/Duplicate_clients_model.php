<?php
	class Duplicate_clients_model extends CI_Model
	{
		var $table = 'clients';
		var $column_order = array('id', 'lname','fname','mname','address','refbrgy.brgyDesc','refcitymun.citymunDesc','birthday','contact_number'); //set column field database for datatable orderable
		var $column_search = array('concat_ws(" ",lname,fname,mname)','concat_ws(" ",fname,lname,mname)','concat_ws(" ",fname,mname,lname)','lname','fname','mname','address','refbrgy.brgyDesc','refcitymun.citymunDesc','birthday','contact_number'); //set column field database for datatable searchable 
		var $column_search2 = array('concat_ws(" ",lname,fname,mname)','concat_ws(" ",fname,lname,mname)','concat_ws(" ",fname,mname,lname)','lname','fname','mname','address','birthday','contact_number'); //set column field database for datatable searchable for filtered
		var $order = array('id' => 'asc'); // default order 



		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function _get_datatables_query($active,$verified){
	        //add custom filter here
	        if($this->input->post('provCode')){
	            $this->db->where('clients.provCode', $this->input->post('provCode'));
	        } 
	        if($this->input->post('citymunCode')){
	            $this->db->where('clients.citymunCode', $this->input->post('citymunCode'));
	        } 
	        if($this->input->post('brgyCode')){
	            $this->db->where('clients.brgyCode', $this->input->post('brgyCode'));
	        } 
	        if($this->input->post('status_filter')){
	            $this->db->where('clients.status', $this->input->post('status_filter'));
	        }
	 
	        $this->db->select("count(*) as num, clients.fname, clients.lname, clients.mname,clients.birthday, clients.id,clients.address, clients.contact_number, clients.status, refbrgy.brgyCode, refbrgy.brgyDesc,refcitymun.citymunCode, refcitymun.citymunDesc, concat(clients.fname,clients.lname) as checker");
	        $this->db->from($this->table);  
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode','left'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode','left');
	        $this->db->join('vaccination a','a.userid = clients.id','inner');

	    	if($verified!=2){
	    		$this->db->where('clients.verified',$verified);
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
	         
            $this->db->order_by('num','DESC');
	    	$this->db->group_by('checker');
	    	$this->db->having('num > 1');
	    }

		public function get_datatables($active,$verified){
	        $this->_get_datatables_query($active,$verified);
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $query = $this->db->get();
			//echo $this->db->last_query();
	        return $query->result();
	    }

	    public function count_filtered($active,$verified){
	        //add custom filter here
	        if($this->input->post('provCode')){
	            $this->db->where('clients.provCode', $this->input->post('provCode'));
	        } 
	        if($this->input->post('citymunCode')){
	            $this->db->where('clients.citymunCode', $this->input->post('citymunCode'));
	        } 
	        if($this->input->post('brgyCode')){
	            $this->db->where('clients.brgyCode', $this->input->post('brgyCode'));
	        } 
	        if($this->input->post('status_filter')){
	            $this->db->where('clients.status', $this->input->post('status_filter'));
	        }

 	        $this->db->select("count(*) as num, concat(clients.fname,clients.lname) as checker");
	        $this->db->from($this->table);  
	        $this->db->join('vaccination a','a.userid = clients.id','inner');
	        // $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode','left'); 
	        // $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode','left');
	    	// $this->db->join('covid_status','covid_status.c_status_id = clients.status','left');
	    	$this->db->where('clients.active',$active);
	    	if($verified!=2){
	    		$this->db->where('clients.verified',$verified);
	    	}
	        $i = 0;
	     
	        foreach ($this->column_search2 as $item) // loop column 
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
	 
	                if(count($this->column_search2) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }
	    	$this->db->group_by('checker');
	    	$this->db->having('num > 1');
	        return $this->db->count_all_results();
	    }
	 
	    public function count_all($active,$verified)
	    {
 	        $this->db->select("count(*) as num, concat(clients.fname,clients.lname) as checker");
	        $this->db->from($this->table);
	        $this->db->join('vaccination a','a.userid = clients.id','inner');
	    	$this->db->where('clients.active',$active);
	    	if($verified!=2){
	    		$this->db->where('clients.verified',$verified);
	    	}
	    	$this->db->group_by('checker');
	    	$this->db->having('num > 1');
	        return $this->db->count_all_results();
	    } 

	    public function search($where){
			$this->db->select('clients.*, vaccination.*');
			$this->db->from('clients');
			$this->db->join('vaccination','vaccination.userid = clients.id','LEFT');
			// $this->db->where('clients.active','1');
			// $this->db->where('vaccination.active','1');
			foreach($where as $key=>$val){
				$this->db->where($key,$val);
			}
			$query = $this->db->get('');
			//echo $this->db->last_query();
			if($query->num_rows() > 0){
		        return $query->result();
			}else{
				return false;
			}
	    }
	    public function search_postvac($where){
			$this->db->select('clients.*, post_vaccination.*');
			$this->db->from('clients');
			$this->db->join('post_vaccination','post_vaccination.userid = clients.id','LEFT');
			$this->db->where('clients.active','1');
			foreach($where as $key=>$val){
				$this->db->where($key,$val);
			}
			$query = $this->db->get('');
			//echo $this->db->last_query();
			if($query->num_rows() > 0){
		        return $query->result();
			}else{
				return false;
			}
	    }
	}
?>
