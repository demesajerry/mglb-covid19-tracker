<?php
	class Resbakuna_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function get_details($id, $hash){
	        $this->db->select('CONCAT(clients.lname,", ", clients.fname," ", LEFT(clients.mname,1),".") as fullname, 
	        	DATE_FORMAT(birthday,"%b&nbsp;%d, %Y") as bday, 
	        	IF(sex=1,"MALE","FEMALE") as sex, 
	        	UPPER(CONCAT(refbrgy.brgyDesc," ", refcitymun.citymunDesc,"<br>",refprovince.provDesc)) as address, 
	        	CONCAT("LBLAG-",LPAD(vaccination.vac_id, 8, "0")) as dict_id_no, 
	        	vaccination.vac_id as id_no,
	        	DATE_FORMAT(first.vac_date,"%m/%d/%y") as f_vac_date, 
	        	first_vac.manufacturer as f_vaccine, 
	        	first.lot_number as f_lot_number, 
	        	first_vaccinator.vcard_display as f_vaccinator,  
	        	DATE_FORMAT(second.vac_date,"%m/%d/%y") as s_vac_date, 
	        	second_vac.manufacturer as s_vaccine, 
	        	second.lot_number as s_lot_number, 
	        	second_vaccinator.vcard_display as s_vaccinator,  
	        	');  
	        $this->db->from('vac_card');  
	        $this->db->join('vaccination','vaccination.vac_id = vac_card.vac_id');  
	        $this->db->join('clients','clients.id=vaccination.userid');  
	        $this->db->join('(select * from post_vaccination where first_dose = "01_Yes") first','first.userid = clients.id');  
	        $this->db->join('(select * from post_vaccination where second_dose = "01_Yes") second','second.userid = clients.id');  
	        $this->db->join('refprovince','refprovince.provCode = clients.provCode');  
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode');  
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode');  
	        $this->db->join('vaccines as first_vac','first_vac.vaccine_id = first.vac_manufacturer');  
	        $this->db->join('vaccines as second_vac','second_vac.vaccine_id = second.vac_manufacturer');  
	        $this->db->join('vaccinator as first_vaccinator','first_vaccinator.v_id = first.vaccinator_name','LEFT');  
	        $this->db->join('vaccinator as second_vaccinator','second_vaccinator.v_id = second.vaccinator_name','LEFT');  

			$this->db->where('vac_card.vac_id',$id);
			$this->db->where('vac_card.hash',$hash);
	        $result= $this->db->get()->result_object();
	        if($result!=false){
	        return $result[0];
	        }else{
	        	return false;
	        }
		}
	}
?>

