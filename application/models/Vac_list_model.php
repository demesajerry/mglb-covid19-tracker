<?php
	class Vac_list_model extends CI_Model
	{
		var $table = 'clients';
		var $column_order = array('id', 'lname','fname','mname','address','birthday','contact_number'); //set column field database for datatable orderable
		var $column_search = array('qrcode','concat_ws(" ",TRIM(lname),TRIM(fname),TRIM(mname))','concat_ws(" ",TRIM(lname),TRIM(fname),TRIM(mname))','concat_ws(" ",TRIM(lname),TRIM(fname),TRIM(mname))','lname','fname','mname','address','birthday','clients.contact_number'); //set column field database for datatable searchable 
		var $column_search2 = array('concat_ws(" ",lname,fname,mname)','concat_ws(" ",fname,lname,mname)','concat_ws(" ",fname,mname,lname)','lname','fname','mname','address','birthday','clients.contact_number'); //set column field database for datatable searchable for filtered
		var $order = array('id' => 'asc'); // default order 

		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function vaccination_main_config($active,$verified,$is_disable){
	 		if($this->input->post('dose') == 1 ){
	 			$vac_date_field = 'vaccination.first_vac_date';
	 			$text_status_field = 'sms1.msg_id';
	 		}else{
	 			$vac_date_field = 'vaccination.next_vac_date';
	 			$text_status_field = 'sms2.msg_id';
	 		}

        	$this->db->where('clients.active',$active);
        	$this->db->where('vaccination.is_disable',$is_disable);

	        if($this->input->post('provCode')){
	            $this->db->where('clients.provCode', $this->input->post('provCode'));
	        } 
	        if($this->input->post('citymunCode')){
	            $this->db->where('clients.citymunCode', $this->input->post('citymunCode'));
	        } 
	        if($this->input->post('brgyCode')){
	            $this->db->where('clients.brgyCode', $this->input->post('brgyCode'));
	        } 
	        if($this->input->post('age_bracket')!=''){
	        	if($this->input->post('age_bracket') == "0"){
	        		$this->db->group_start();
		            	$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', "18");
		            	$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', "59");
	        		$this->db->group_end();
	        	}else{
		            	$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', "60");
	        	}
	        }
	        if($this->input->post('with_comorbidity')!=''){
	            $this->db->where('vaccination.with_comorbidity', $this->input->post('with_comorbidity'));
	        }
	        if($this->input->post('sched_status')!=''){
	        	if($this->input->post('sched_status') == "0"){
		            $this->db->where($vac_date_field,'0000-00-00');
	        	}
	        	if($this->input->post('sched_status') == "1"){
			            $this->db->where($vac_date_field.' !=','0000-00-00');
	        	}
	        }
	        if($this->input->post('vac_date')!=''){
	        	$vac_date = explode(' - ',$this->input->post('vac_date'));
	        	$vac_date_from = date("Y-m-d", strtotime($vac_date[0]));
	        	$vac_date_to = date("Y-m-d", strtotime($vac_date[1]));
	            $this->db->where($vac_date_field.' >=',$vac_date_from);
	            $this->db->where($vac_date_field.' <=',$vac_date_to);
	        }
	        if($this->input->post('text_status')!=''){
	        	if($this->input->post('text_status')=="0"){
	            	$this->db->where($text_status_field,NULL);
	            }else{
	            	$this->db->where($text_status_field.' !=',NULL);
	            }
	        }

	        if($this->input->post('dose') == "1"){
	            $this->db->where('vaccination.is_vaccinated','0');
	            $this->db->where('vaccination.is_vaccinated_second','0');
	        	$this->db->where('vaccination.a1_vaccinated_status','0');

		        if($this->input->post('vac_site_id')!=""){
		            $this->db->where('vaccination.first_vac_site',$this->input->post('vac_site_id'));
		        }

	        	if($this->input->post('time_schedule') != ""){
	            	$this->db->where('sms1.time_schedule',$this->input->post('time_schedule'));
	            }

	        	if($this->input->post('vaccine_used') != ""){
	            	$this->db->where('vaccination.possible_vaccine',$this->input->post('vaccine_used'));
	            }

		        if($this->input->post('sched_rep')!=""){
		        	if($this->input->post('sched_rep') == "0"){
	        		$this->db->group_start();
	            		$this->db->where('sms1.reply','');
	            		$this->db->or_where('sms1.reply',null);
	        		$this->db->group_end();
	        		}else{
            		$this->db->where('sms1.reply',$this->input->post('sched_rep'));
            		}
		        }
	        }
	        if($this->input->post('dose') == "2"){
	            $this->db->where('vaccination.is_vaccinated','1');
	            // $this->db->where('post_vaccination.vac_date !=','0000-00-00');
	            $this->db->where('vaccination.is_vaccinated_second','0');

	            if($this->input->post('first_vac_site_id')!=""){
		            $this->db->where('vaccination.first_vac_site',$this->input->post('first_vac_site_id'));
	            }

		        if($this->input->post('vac_site_id')!=""){
		            $this->db->where('vaccination.second_vac_site',$this->input->post('vac_site_id'));
		        }

	        	if($this->input->post('time_schedule') != ""){
	            	$this->db->where('sms2.time_schedule',$this->input->post('time_schedule'));
	            }

	        	if($this->input->post('vaccine_used') != ""){
	            	$this->db->where('post_vaccination.vac_manufacturer',$this->input->post('vaccine_used'));
	            }

		        if($this->input->post('sched_rep')!=""){
		        	if($this->input->post('sched_rep') == "0"){
	        		$this->db->group_start();
	            		$this->db->where('sms2.reply','');
	            		$this->db->or_where('sms2.reply',null);
	        		$this->db->group_end();
	        		}else{
            		$this->db->where('sms2.reply',$this->input->post('sched_rep'));
            		}
		        }
	        }

	        if($this->input->post('fvd')!=""){
	        	$fvd = date("Y-m-d", strtotime($this->input->post('fvd')));
	            $this->db->where('post_vaccination.vac_date',$fvd);
	        }
	        //vaccination list in tagger account
	        if($this->input->post('status_filter')!=''){
	            $this->db->where('vaccination.is_validated', $this->input->post('status_filter'));
	        }

			if($this->input->post('category_group')!=''){
			$this->db->group_start();
				foreach($this->input->post('category_group') as $key => $val){
				if($val == 'A1'){
					$this->db->where('pg.priority_group', 'A1');
					$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
				}
				if($val == 'A1.1'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.1');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
					$this->db->group_end();
				}
				if($val == 'A1.2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.2');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
					$this->db->group_end();
				}
				if($val == 'A1.8'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.8');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
					$this->db->group_end();
				}
				if($val == 'A2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '60');
							$this->db->where('pg.priority_group !=', 'A1');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group =', 'A2');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'A3'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group !=', 'A2');
							$this->db->where('pg.priority_group !=', 'OTHERS');
							$this->db->where('vaccination.with_comorbidity', '01_Yes');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('pg.priority_group', 'A3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('pg.priority_group', 'A3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group !=', 'A2');
							$this->db->where('pg.priority_group !=', 'OTHERS');
							$this->db->where('vaccination.with_comorbidity', '01_Yes');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'EA3'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('pg.priority_group', 'EA3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('pg.priority_group', 'EA3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.pregnancy_status', '01_Pregnant');
							$this->db->where('clients.sex', '0');
						$this->db->group_end();
					$this->db->group_end();
				}				
				if($val == 'A4'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A4');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A4');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'A5'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A5');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A5');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'B1'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B1');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B1');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'B2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B2');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B2');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'B3'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B3');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'B4'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B4');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) = ', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B4');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'OTHERS'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
					$this->db->group_start();
						// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
						// $this->db->where('vaccination.with_comorbidity', '02_None');
						$this->db->where('pg.priority_group', 'OTHERS');
					$this->db->group_end();
					$this->db->or_group_start();
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) = ', NULL);
						// $this->db->where('vaccination.with_comorbidity', '02_None');
						$this->db->where('pg.priority_group', 'OTHERS');
					$this->db->group_end();
					$this->db->group_end();
				}
			}
			$this->db->group_end();
			}
			if($this->input->post('arrived')!=''){
				$this->db->where_in('vaccination.arrival', $this->input->post('arrived'));
			}
	        //vaccination category
	        if($this->input->post('category')!=''){
	            $this->db->where('vaccination.category', $this->input->post('category'));
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
 		}
		//main list
		public function get_datatables_admin($active,$verified,$is_disable){
	        $this->db->select("vaccination.userid, TRIM(clients.fname) as fname, clients.qrcode, TRIM(clients.lname) as lname, TRIM(clients.mname) as mname,clients.birthday, clients.id,clients.address, TRIM(clients.contact_number) as contact_number, clients.status, refbrgy.brgyCode, refbrgy.brgyDesc,refcitymun.citymunCode, refcitymun.citymunDesc, vaccination.date_reg, TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) AS age, if(vaccination.with_comorbidity = '01_Yes','YES','NO') as comor, vaccination.first_vac_date, unix_timestamp(vaccination.date_reg) as date_reg_timestamp, sms1.reply as reply1, sms2.reply as reply2, vaccination.next_vac_date, sms1.msg_id as first_text_status, sms2.msg_id as second_text_status, vaccination.possible_vaccine, vaccination.first_vac_site, vaccination.second_vac_site, vaccines.manufacturer as vac2,vaccines.vaccine_id as vac2_id,post_vaccination.vac_date, sms1.status as send_status1, sms2.status as send_status2  , sms1.time_schedule as time_schedule1, sms2.time_schedule as time_schedule2, vaccination.arrival, pg.priority_group, pg.description, sms1.si_id as si_id1, sms2.si_id as si_id2, vaccination.date_update");
	        $this->db->from($this->table);  
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode','left'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode','left');
	        $this->db->join('vaccination','vaccination.userid = clients.id','INNER');
	        $this->db->join('(select * from post_vaccination) post_vaccination','post_vaccination.userid = clients.id','LEFT');
	        $this->db->join('sent_messages sms1','sms1.vac_date = vaccination.first_vac_date AND sms1.userid = vaccination.userid','LEFT');
	        $this->db->join('sent_messages sms2','sms2.vac_date = vaccination.next_vac_date AND sms2.userid = vaccination.userid','LEFT');
			$this->db->join('priority_group pg', 'pg.pg_id = vaccination.category', 'LEFT');
	        $this->db->join('vaccines vaccines','vaccines.vaccine_id = post_vaccination.vac_manufacturer','LEFT');

	        //call main query
	        $this->vaccination_main_config($active,$verified,$is_disable);
	        if($this->input->post('dose') == "2"){
	            $this->db->where('post_vaccination.vac_date !=','0000-00-00');
	        }

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

		public function get_datatables_tagger($active,$verified,$is_disable){
	        $this->db->select("vaccination.userid, clients.fname, clients.qrcode, clients.lname, clients.mname,clients.birthday, clients.id,clients.address, clients.contact_number, clients.status, refbrgy.brgyCode, refbrgy.brgyDesc,refcitymun.citymunCode, refcitymun.citymunDesc, vaccination.date_reg, TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) AS age, if(vaccination.with_comorbidity = '01_Yes','YES','NO') as comor, vaccination.first_vac_date, unix_timestamp(vaccination.date_reg) as date_reg_timestamp, pg.priority_group, pg.description");
	        $this->db->from($this->table);  
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode','left'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode','left');
	        $this->db->join('vaccination','vaccination.userid = clients.id','INNER');
			$this->db->join('priority_group pg', 'pg.pg_id = vaccination.category', 'LEFT');

	        //call main query
	        $this->vaccination_main_config($active,$verified,$is_disable);

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

		//for filtered count
	    public function count_filtered($active,$verified,$is_disable){
	 		if($this->input->post('dose') == 1 ){
	 			$vac_date_field = 'vaccination.first_vac_date';
	 			$text_status_field = 'sms1.msg_id';
	 		}else{
	 			$vac_date_field = 'vaccination.next_vac_date';
	 			$text_status_field = 'sms2.msg_id';
	 		}
	        $this->db->select('COUNT(DISTINCT (vaccination.userid)) as num_filetered');
	        $this->db->from($this->table);  
	        $this->db->join('vaccination','vaccination.userid = clients.id','INNER');
	        $this->db->join('post_vaccination','post_vaccination.userid = clients.id','LEFT');
	        $this->db->join('sent_messages sms1','sms1.vac_date = vaccination.first_vac_date AND sms1.userid = vaccination.userid','LEFT');
	        $this->db->join('sent_messages sms2','sms2.vac_date = vaccination.next_vac_date AND sms2.userid = vaccination.userid','LEFT');
			$this->db->join('priority_group pg', 'pg.pg_id = vaccination.category', 'LEFT');

	        //call main query
	        $this->vaccination_main_config($active,$verified,$is_disable);

	        $query = $this->db->get();
			// echo $this->db->last_query();
	        return $query->row()->num_filetered;
	    }

	    public function count_all($active,$verified)
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
	        if($this->input->post('status_filter')!=''){
	            $this->db->where('vaccination.is_validated', $this->input->post('status_filter'));
	        }
	        if($this->input->post('is_vaccinated')!=''){
	            $this->db->where('vaccination.is_vaccinated', $this->input->post('is_vaccinated'));
	        }
	 
	        $this->db->select("TRIM(clients.fname) as fname, clients.qrcode, TRIM(clients.lname) as lname, TRIM(clients.mname) as mname,clients.birthday, clients.id,clients.address, TRIM(clients.contact_number) as contact_number, clients.status, refbrgy.brgyCode, refbrgy.brgyDesc,refcitymun.citymunCode, refcitymun.citymunDesc, vaccination.date_reg");
	        $this->db->from($this->table);  
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode','left'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode','left');
	        $this->db->join('vaccination','vaccination.userid = clients.id','INNER');
        	$this->db->where('clients.active',$active);
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

	    public function get_scheduled_list($schedule,$dose,$status,$vac_site, $vaccine_used){
	    	if($dose == "1"){
		        $this->db->select("vaccination.userid, clients.fname, clients.lname, clients.mname, clients.contact_number, vaccination.first_vac_date as vac_date, vaccination.possible_vaccine as vaccine, vaccination.first_vac_site as vac_site, sms1.msg_id, sms1.time_schedule");
	    	}else{
		        $this->db->select("vaccination.userid, clients.fname, clients.lname, clients.mname, clients.contact_number, vaccination.next_vac_date as vac_date, vaccination.second_vac_site as vac_site, vaccines.manufacturer as vaccine, sms2.msg_id,sms2.reply, sms2.time_schedule ");
	    	}
	        $this->db->from($this->table);  
	        $this->db->join('vaccination','vaccination.userid = clients.id','INNER');
	        $this->db->join('(select * from post_vaccination where vac_manufacturer != "") as post_vaccination','post_vaccination.userid = clients.id','LEFT');
	        $this->db->join('sent_messages sms1','sms1.vac_date = vaccination.first_vac_date AND sms1.userid = vaccination.userid','LEFT');
	        $this->db->join('sent_messages sms2','sms2.vac_date = vaccination.next_vac_date AND sms2.userid = vaccination.userid','LEFT');
	        $this->db->join('vaccines vaccines','vaccines.vaccine_id = post_vaccination.vac_manufacturer','LEFT');
        	$this->db->where('clients.active','1');
        	$this->db->where('vaccination.is_disable','0');

	        if($dose == "1"){
	        	$this->db->where('vaccination.first_vac_date',$schedule);
	        	$this->db->group_start();
	            	$this->db->where('sms1.reply','');
	            	$this->db->or_where('sms1.reply',null);
	        	$this->db->group_end();
	        	$this->db->where('vaccination.first_vac_site !=','');
	        	$this->db->where('vaccination.possible_vaccine !=','');
	        	if($status=='1'){
	        		$this->db->where('sms1.msg_id !=',null);
	        	}
	        	if($status=='2'){
	        		$this->db->where('sms1.msg_id',null);
	        	}
	        	if($vac_site!=''){
	        		$this->db->where('vaccination.first_vac_site',$vac_site);
	        	}
	        	if($vaccine_used!=''){
	        		$this->db->where('vaccination.possible_vaccine',$vaccine_used);
	        	}
            }else{
	        	$this->db->where('vaccination.next_vac_date',$schedule);
	            $this->db->where('vaccination.is_vaccinated','1');
	            $this->db->where('post_vaccination.vac_date !=','0000-00-00');
	            $this->db->where('vaccination.is_vaccinated_second','0');
	        	$this->db->group_start();
	            	$this->db->where('sms2.reply','');
	            	$this->db->or_where('sms2.reply',null);
	        	$this->db->group_end();
	        	$this->db->where('vaccination.second_vac_site !=','');
	        	if($status=='1'){
	        	$this->db->group_start();
	            	$this->db->where('sms2.msg_id !=','');
	            	$this->db->or_where('sms2.msg_id !=',null);
	        	$this->db->group_end();
	        	}
	        	if($status=='2'){
	        	$this->db->group_start();
	            	$this->db->where('sms2.msg_id','');
	            	$this->db->or_where('sms2.msg_id',null);
	        	$this->db->group_end();
	        	}
	        	if($vac_site!=''){
	        		$this->db->where('vaccination.second_vac_site',$vac_site);
	        	}
	        	if($vaccine_used!=''){
	        		$this->db->where('post_vaccination.vac_manufacturer',$vaccine_used);
	        	}
            }
            // $this->db->group_by('vaccination.userid');
            $result=$this->db->get()->result_object();
			 // echo $this->db->last_query();
	       return $result;
	    }

	    public function bulk_sched($active,$verified){
	 		if($this->input->post('dose') == 1 ){
	 			$vac_date_field = 'vaccination.first_vac_date';
	 			$text_status_field = 'sms1.msg_id';
	 		}else{
	 			$vac_date_field = 'vaccination.next_vac_date';
	 			$text_status_field = 'sms2.msg_id';
	 		}
	        $this->db->select("vaccination.userid, clients.fname, clients.qrcode, clients.lname, clients.mname,clients.birthday, clients.id,clients.address, clients.contact_number, clients.status, refbrgy.brgyCode, refbrgy.brgyDesc,refcitymun.citymunCode, refcitymun.citymunDesc, vaccination.date_reg, TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) AS age, if(vaccination.with_comorbidity = '01_Yes','YES','NO') as comor, vaccination.first_vac_date, unix_timestamp(vaccination.date_reg) as date_reg_timestamp, sms1.reply as reply1, sms2.reply as reply2, vaccination.next_vac_date, sms1.msg_id as first_text_status, sms2.msg_id as second_text_status, vaccination.possible_vaccine, vaccination.first_vac_site, vaccination.second_vac_site, post_vaccination.vac_manufacturer as vac2,post_vaccination.vac_date, sms1.time_schedule as time1, sms2.time_schedule as time2  ");
	        $this->db->from($this->table);  
	        $this->db->join('refbrgy','refbrgy.brgyCode = clients.brgyCode','left'); 
	        $this->db->join('refcitymun','refcitymun.citymunCode = clients.citymunCode','left');
	        $this->db->join('vaccination','vaccination.userid = clients.id','INNER');
	        $this->db->join('post_vaccination','post_vaccination.userid = clients.id','LEFT');
	        $this->db->join('sent_messages sms1','sms1.vac_date = vaccination.first_vac_date AND sms1.userid = vaccination.userid','LEFT');
	        $this->db->join('sent_messages sms2','sms2.vac_date = vaccination.next_vac_date AND sms2.userid = vaccination.userid','LEFT');
			$this->db->join('priority_group pg', 'pg.pg_id = vaccination.category', 'LEFT');
        	$this->db->where('clients.active',$active);
        	$this->db->where_in('clients.status',['1','4']);
        	$this->db->where('vaccination.is_disable','0');
        	
	        if($this->input->post('provCode')){
	            $this->db->where('clients.provCode', $this->input->post('provCode'));
	        } 
	        if($this->input->post('citymunCode')){
	            $this->db->where('clients.citymunCode', $this->input->post('citymunCode'));
	        } 
	        if($this->input->post('brgyCode')){
	            $this->db->where('clients.brgyCode', $this->input->post('brgyCode'));
	        } 
	        if($this->input->post('age_bracket')!=''){
	        	if($this->input->post('age_bracket') == "0"){
	        		$this->db->group_start();
		            	$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', "18");
		            	$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', "59");
	        		$this->db->group_end();
	        	}else{
		            	$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', "60");
	        	}
	        }
	        if($this->input->post('with_comorbidity')!=''){
	            $this->db->where('vaccination.with_comorbidity', $this->input->post('with_comorbidity'));
	        }
	        if($this->input->post('sched_status')!=''){
	        	if($this->input->post('sched_status') == "0"){
		            $this->db->where($vac_date_field,'0000-00-00');
	        	}
	        	if($this->input->post('sched_status') == "1"){
			            $this->db->where($vac_date_field.' !=','0000-00-00');
	        	}
	        }
	        if($this->input->post('vac_date')!=''){
	        	$vac_date = explode(' - ',$this->input->post('vac_date'));
	        	$vac_date_from = date("Y-m-d", strtotime($vac_date[0]));
	        	$vac_date_to = date("Y-m-d", strtotime($vac_date[1]));
	            $this->db->where($vac_date_field.' >=',$vac_date_from);
	            $this->db->where($vac_date_field.' <=',$vac_date_to);
	        }
	        if($this->input->post('text_status')!=''){
	        	if($this->input->post('text_status')=="0"){
	            	$this->db->where($text_status_field,NULL);
	            }else{
	            	$this->db->where($text_status_field.' !=',NULL);
	            }
	        }

	        if($this->input->post('dose') == "1"){
	            $this->db->where('vaccination.is_vaccinated','0');
	            $this->db->where('vaccination.is_vaccinated_second','0');
            	$this->db->where('vaccination.a1_vaccinated_status','0');

		        if($this->input->post('vac_site_id')!=""){
		            $this->db->where('vaccination.first_vac_site',$this->input->post('vac_site_id'));
		        }

	        	if($this->input->post('vaccine_used') != ""){
	            	$this->db->where('vaccination.possible_vaccine',$this->input->post('vaccine_used'));
	            }

	        	if($this->input->post('time_schedule') != ""){
	            	$this->db->where('sms1.time_schedule',$this->input->post('time_schedule'));
	            }

		        if($this->input->post('sched_rep')!=""){
		        	if($this->input->post('sched_rep') == "0"){
	        		$this->db->group_start();
	            		$this->db->where('sms1.reply','');
	            		$this->db->or_where('sms1.reply',null);
	        		$this->db->group_end();
	        		}else{
            		$this->db->where('sms1.reply',$this->input->post('sched_rep'));
            		}
		        }
	        }
	        if($this->input->post('dose') == "2"){
	            $this->db->where('vaccination.is_vaccinated','1');
	            $this->db->where('post_vaccination.vac_date !=','0000-00-00');
	            $this->db->where('vaccination.is_vaccinated_second','0');

		        if($this->input->post('first_vac_site_id')!=""){
		            $this->db->where('vaccination.first_vac_site',$this->input->post('first_vac_site_id'));
		        }

		        if($this->input->post('vac_site_id')!=""){
		            $this->db->where('vaccination.second_vac_site',$this->input->post('vac_site_id'));
		        }

	        	if($this->input->post('vaccine_used') != ""){
	            	$this->db->where('post_vaccination.vac_manufacturer',$this->input->post('vaccine_used'));
	            }


	        	if($this->input->post('time_schedule') != ""){
	            	$this->db->where('sms1.time_schedule',$this->input->post('time_schedule'));
	            }

		        if($this->input->post('sched_rep')!=""){
		        	if($this->input->post('sched_rep') == "0"){
	        		$this->db->group_start();
	            		$this->db->where('sms2.reply','');
	            		$this->db->or_where('sms2.reply',null);
	        		$this->db->group_end();
	        		}else{
            		$this->db->where('sms2.reply',$this->input->post('sched_rep'));
            		}
		        }
	        }

			if($this->input->post('category_group')!=''){
			$this->db->group_start();
				foreach($this->input->post('category_group') as $key => $val){
				if($val == 'A1'){
					$this->db->where('pg.priority_group', 'A1');
					$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
				}
				if($val == 'A1.1'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.1');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
					$this->db->group_end();
				}
				if($val == 'A1.2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.2');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
					$this->db->group_end();
				}
				if($val == 'A1.8'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.8');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
					$this->db->group_end();
				}
				if($val == 'A2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '60');
							$this->db->where('pg.priority_group !=', 'A1');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group =', 'A2');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'A3'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group !=', 'A2');
							$this->db->where('pg.priority_group !=', 'OTHERS');
							$this->db->where('vaccination.with_comorbidity', '01_Yes');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('pg.priority_group', 'A3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('pg.priority_group', 'A3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group !=', 'A2');
							$this->db->where('pg.priority_group !=', 'OTHERS');
							$this->db->where('vaccination.with_comorbidity', '01_Yes');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'EA3'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('pg.priority_group', 'EA3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('pg.priority_group', 'EA3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.pregnancy_status', '01_Pregnant');
							$this->db->where('clients.sex', '0');
						$this->db->group_end();
					$this->db->group_end();
				}							
				if($val == 'A4'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A4');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A4');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'A5'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A5');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A5');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'B1'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B1');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B1');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'B2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B2');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B2');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'B3'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) =', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B3');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'B4'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B4');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) = ', NULL);
							$this->db->where('vaccination.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B4');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($val == 'OTHERS'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
					$this->db->group_start();
						// $this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <', '60');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) >=', '18');
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) <=', '59');
						// $this->db->where('vaccination.with_comorbidity', '02_None');
						$this->db->where('pg.priority_group', 'OTHERS');
					$this->db->group_end();
					$this->db->or_group_start();
						$this->db->where('TIMESTAMPDIFF(YEAR, clients.birthday, CURDATE()) = ', NULL);
						// $this->db->where('vaccination.with_comorbidity', '02_None');
						$this->db->where('pg.priority_group', 'OTHERS');
					$this->db->group_end();
					$this->db->group_end();
				}
			}
			$this->db->group_end();
			}

	        if($this->input->post('fvd')!=""){
	        	$fvd = date("Y-m-d", strtotime($this->input->post('fvd')));
	            $this->db->where('post_vaccination.vac_date',$fvd);
	        }
	        //vaccination list in tagger account
	        if($this->input->post('status_filter')!=''){
	            $this->db->where('vaccination.is_validated', $this->input->post('status_filter'));
	        }
	        //category
	        if($this->input->post('category')!=''){
	            $this->db->where('vaccination.category', $this->input->post('category'));
	        }

            $this->db->group_by('vaccination.userid');
            
	        if($this->input->post('quantity')!=''){
		        $this->db->limit($this->input->post('quantity'));
	        }
	        if($this->input->post('dose')==1){
            $this->db->order_by('date_reg_timestamp', 'ASC');
	        }
            $result=$this->db->get()->result_object();
			 // echo $this->db->last_query();
	       return $result;
	    }
	}
?>

