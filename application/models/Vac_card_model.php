<?php
	class Vac_card_model extends CI_Model
	{
		var $table = 'clients';
		var $column_order = array('id', 'lname','fname','mname','address','birthday','contact_number'); //set column field database for datatable orderable
		var $column_search = array('qrcode','concat_ws(" ",TRIM(lname),TRIM(fname),TRIM(mname))','lname','fname','mname','address','birthday','clients.contact_number'); //set column field database for datatable searchable 
		var $order = array('id' => 'asc'); // default order 

		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function vaccination_main_config(){
	        $this->db->join('vaccination','vaccination.userid = clients.id'); 
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode','left'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode','left');
	        $this->db->where('clients.status','1');
	        $this->db->where('clients.active','1');
	        $this->db->where('vaccination.is_disable','0');
	        $this->db->where('vaccination.is_vaccinated_second','1');
	        $this->db->where('vaccination.is_vaccinated','1');
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
		}

		public function get_list(){
	        $this->db->select('unix_timestamp(vaccination.date_reg) as date_reg_timestamp, 
	        	vaccination.userid, 
	        	clients.fname, 
	        	clients.qrcode, 
	        	clients.lname, 
	        	clients.mname,
	        	clients.birthday, 
	        	clients.id,clients.address, 
	        	clients.contact_number, 
	        	clients.status, 
	        	refbrgy.brgyCode, 
	        	refbrgy.brgyDesc,
	        	refcitymun.citymunCode, 
	        	refcitymun.citymunDesc, 
	        	vaccination.date_reg, 
	        	TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) AS age,
	        	vaccination.is_vaccinated,
	        	vaccination.is_vaccinated_second');
	        $this->db->from('clients');  
	        $this->vaccination_main_config();
            // $this->db->group_by('clients.id');
            $this->db->order_by('date_reg_timestamp', 'ASC');
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        //$query = $this->db->get();

	        $result = new stdClass();
	        $result->list = $this->db->get()->result_object();
			// echo $this->db->last_query();
	        return $result;
	    }

	    public function count_filtered(){
	        $this->db->select('COUNT(DISTINCT (vaccination.userid)) as num_filetered');
	        $this->db->from($this->table);  
	        //call main query
	        $this->vaccination_main_config();

	        $query = $this->db->get();
			// echo $this->db->last_query();
	        return $query->row()->num_filetered;
	    }

	    public function count_all()
	    {
	        $this->db->select('COUNT(*) as num_all');  
	        $this->db->from('clients');  
	        $this->db->join('vaccination','vaccination.userid = clients.id','INNER');
	        $this->db->where('clients.active','1');
	        $this->db->where('vaccination.is_disable','0');
	        $this->db->where('vaccination.a1_vaccinated_status','0');
			// $this->db->where('clients.id !=','14261');
			// $this->db->group_by('vaccination.userid');
			$query = $this->db->get('');
	        return $query->row()->num_all;
	    } 

	    public function get_details($userid){
	        $this->db->select('CONCAT(clients.lname,", ", clients.fname," ", LEFT(clients.mname,1),".") as fullname, 
	        	UPPER(clients.lname) as lname,
	        	UPPER(clients.fname) as fname,
	        	UPPER(LEFT(clients.mname,1)) as mname,
	        	clients.contact_number,
	        	vaccination.suffix,
	        	IF(sex=1,"MALE","FEMALE") as sex, 
	        	DATE_FORMAT(birthday,"%b&nbsp;%d, %Y") as bday, 
	        	vaccination.philhealth_id, 
	        	UPPER(CONCAT(refbrgy.brgyDesc," ", refcitymun.citymunDesc," ",refprovince.provDesc)) as address, 
	        	CONCAT("LBLAG-",LPAD(vaccination.vac_id, 8, "0")) as dict_id_no, 
	        	vaccination.vac_id as id_no,
	        	DATE_FORMAT(first.vac_date,"%m/%d/%y") as f_vac_date, 
	        	UPPER(first_vac.manufacturer) as f_vaccine, 
	        	first.lot_number as f_lot_number, 
	        	first.batch_number as f_batch_number, 
	        	first_vaccinator.vcard_display as f_vaccinator,  
	        	first_vaccinator.signature as f_sig,  
	        	DATE_FORMAT(second.vac_date,"%m/%d/%y") as s_vac_date, 
	        	UPPER(second_vac.manufacturer) as s_vaccine, 
	        	second.lot_number as s_lot_number, 
	        	second.batch_number as s_batch_number, 
	        	second_vaccinator.vcard_display as s_vaccinator,  
	        	second_vaccinator.signature as s_sig,  
	        	priority_group.priority_group
	        	');  
	        $this->db->from('clients');  
	        $this->db->join('vaccination','vaccination.userid = clients.id');  
	        $this->db->join('priority_group','priority_group.pg_id = vaccination.category');  
	        $this->db->join('(select * from post_vaccination where first_dose = "01_Yes") first','first.userid = clients.id');  
	        $this->db->join('(select * from post_vaccination where second_dose = "01_Yes") second','second.userid = clients.id');  
	        $this->db->join('refprovince','refprovince.provCode = clients.provCode');  
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode');  
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode');  
	        $this->db->join('vaccines as first_vac','first_vac.vaccine_id = first.vac_manufacturer');  
	        $this->db->join('vaccines as second_vac','second_vac.vaccine_id = second.vac_manufacturer');  
	        $this->db->join('vaccinator as first_vaccinator','first_vaccinator.v_id = first.vaccinator_name','LEFT');  
	        $this->db->join('vaccinator as second_vaccinator','second_vaccinator.v_id = second.vaccinator_name','LEFT');  
	        $this->db->where('clients.id',$userid); 
	        $result= $this->db->get()->result_object();
			// echo $this->db->last_query();
	        return $result[0];
	    }

		public function list($id){
			$this->db->select('*');
			$this->db->from('vac_card');
			$this->db->where('vac_id',$id);
	        return $this->db->get()->result_object();
		}

		public function update($where,$table){
			foreach($where as $key=>$val){
				$this->db->where($key,$val); 
			}
			$this->db->set('print_count', 'print_count+1', FALSE);
			$this->db->update($table); 
			// echo $this->db->last_query();
		}
	}
?>

