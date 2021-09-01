<?php
	class Clients_model extends CI_Model
	{
		var $table = 'clients';
		var $column_order = array('id', 'lname','fname','mname','address','refbrgy.brgyDesc','refcitymun.citymunDesc','birthday','contact_number'); //set column field database for datatable orderable
		var $column_search = array('concat_ws(" ",TRIM(lname),TRIM(fname),TRIM(mname))','concat_ws(" ",TRIM(fname),TRIM(lname),TRIM(mname))','concat_ws(" ",TRIM(fname),TRIM(mname),TRIM(lname))','lname','fname','mname','address','contact_number'); //set column field database for datatable searchable 
		var $column_search2 = array('concat_ws(" ",TRIM(lname),TRIM(fname),TRIM(mname))','concat_ws(" ",TRIM(fname),TRIM(lname),TRIM(mname))','concat_ws(" ",TRIM(fname),TRIM(mname),TRIM(lname))','lname','fname','mname','address','birthday','contact_number'); //set column field database for datatable searchable for filtered
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
	 
	        $this->db->select("clients.fname, clients.lname, clients.mname,clients.birthday, clients.id,clients.address, clients.contact_number, clients.status, covid_status.c_status_id, covid_status.c_classification, refbrgy.brgyCode, refbrgy.brgyDesc,refcitymun.citymunCode, refcitymun.citymunDesc, cs.end_quarantine, cs.stats_id");
	        $this->db->from($this->table);  
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode','left'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode','left');
        	$this->db->join('covid_status','covid_status.c_status_id = clients.status','left');
        	$this->db->join('(select end_quarantine,client_id, stats_id 
								from client_status WHERE stats_id 
           						IN (SELECT max(stats_id) 
               					from client_status 
           						group by client_id)) cs','cs.client_id = clients.id','left');
        	$this->db->where('clients.active',$active);
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

		public function get_datatables($active,$verified){
	        $this->_get_datatables_query($active,$verified);
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $query = $this->db->get();
			// echo $this->db->last_query();
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
	 
	        $this->db->from($this->table);  
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
	        return $this->db->count_all_results();
	    }
	 
	    public function count_all($active,$verified)
	    {
	        $this->db->from($this->table);
        	$this->db->where('clients.active',$active);
        	if($verified!=2){
        		$this->db->where('clients.verified',$verified);
        	}
	        return $this->db->count_all_results();
	    } 

	    public function get_by_id($id){
			$this->db->select('a.active, a.address, a.birthday, a.brgyCode, a.citymunCode, a.contact_number, a.fname, a.id, a.image_path, a.lname, a.mname, a.oddeven_exemption, a.pow, a.provCode, a.qrcode, a.sex, a.username, a.verified,b.group_id');
			$this->db->from($this->table.' a');
        	$this->db->join('(select client_id, GROUP_CONCAT(group_id) AS group_id from oddeven_exemption where client_id = '.$id.' group by client_id) b','b.client_id = a.id','left');
			$this->db->where('id',$id);
			$query = $this->db->get();
			//echo $this->db->last_query();

			return $query->row();
		}

		public function save_status($data2){
			$this->db->insert('client_status', $data2);
			return $this->db->insert_id();
		}

		public function update($where, $data){
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
		}

		public function inactive_client($where, $data){
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
		}

		public function delete_by_id($id){
			$this->db->where('id', $id);
			$this->db->delete($this->table);
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

		public function get_clients_list(){
			$this->db->select('a.*');
			$this->db->from('clients a');
			return $this->db->get()->result_object(); 
		}

		public function get_status_list(){
			$this->db->select('a.*');
			$this->db->from('covid_status a');
			$this->db->where('a.status',1);
			return $this->db->get()->result_object(); 
		} 

		public function get_symptoms_list(){
			$this->db->select('a.*');
			$this->db->from('symptoms a');
			$this->db->where('a.status',1);
			return $this->db->get()->result_object(); 
		} 

		public function get_est_list(){
			$this->db->select('a.*');
			$this->db->from('establishments a');
			return $this->db->get()->result_object(); 
		} 

		public function get_healthRecord_table($id){
			$this->db->select('a.*, b.c_symptom_id, b.c_symptom');
			$this->db->from('client_symptoms a'); 
			$this->db->join('symptoms b', 'b.c_symptom_id = a.symptoms');
			$this->db->where('a.client_id',$id); 			
			$this->db->order_by('a.onset_date', 'DESC');
			return $this->db->get()->result_object(); 
		}
		
		public function get_closed_contact_table($id){
			$this->db->select('a.*');
			$this->db->from('closed_contact_tbl a'); 
			$this->db->where('a.closed_client_id',$id); 			
			$this->db->order_by('a.date_added', 'DESC');
			return $this->db->get()->result_object(); 
		}	

		public function add_exemption($data){
			$this->db->insert_batch('oddeven_exemption', $data);
		}
		public function delete_exemption($id){
			$this->db->where('client_id', $id);
			$this->db->delete('oddeven_exemption');
		}
		public function view_status($id){
			$this->db->select('a.*,b.id,concat(b.lname,", ",b.fname," ",b.mname) as fullname,c.c_classification as status, concat(d.lname,", ",d.fname," ",d.mname) as ufullname');
			$this->db->from('clients b'); 
			$this->db->join('client_status a','a.client_id=b.id','LEFT'); 
			$this->db->join('covid_status c','c.c_status_id=a.status_id','LEFT'); 
			$this->db->join('users d','d.userid=a.changed_by','LEFT'); 
			$this->db->where('b.id',$id); 			
			$this->db->order_by('a.stats_id', 'DESC');
			return $this->db->get()->result_object(); 
		}	
	}
?>

