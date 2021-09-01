<?php
	class Reports_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function get_tracks($data){
			$this->db->select('b.fname, b.lname, b.mname, b.contact_number, b.address, d.brgyDesc, e.citymunDesc, c.name as est_visited, a.datetime,a.sov as sov_id, b.status as status_id, f.c_classification as status, ff.c_classification as sov ');
			$this->db->from('tracks a');
			$this->db->join('clients b', 'b.id = a.client_id');
			$this->db->join('establishments c', 'c.id = a.est_id');
			$this->db->join('refbrgy d', 'd.brgyCode = b.brgyCode');
			$this->db->join('refcitymun e', 'e.citymunCode = b.citymunCode');
			$this->db->join('covid_status f', 'f.c_status_id = b.status','left');
			$this->db->join('covid_status ff', 'ff.c_status_id = a.sov','left');
			if($data->client_id){
				$this->db->where("a.client_id", $data->client_id);
			} 
			if($data->est_id){
				$this->db->where("a.est_id", $data->est_id);
			}
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.datetime >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.datetime <=', $date_to);
			}
			if($data->alert == 1){
				$this->db->where_in('a.sov',["2","3","5","6"]);
			}
			if($data->alert == 0){
				$this->db->where_in('a.sov',["1","4"]);
			}

			//$query = $this->db->get('');
			//echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}

		public function get_post_vac($data){
			$this->db->select('a.*,b.*,g.*,c.provDesc, CONCAT(c.psgcCode,c.provDesc) as pcode, d.citymunDesc, CONCAT(d.psgcCode,citymunDesc) as ccode, e.brgyDesc, DATE_FORMAT(a.birthday, "%m/%d/%Y") as birthday, f.provDesc as employer_prov_desc, TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) AS age, TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) AS vac_age, pg.priority_group, pg.description, pg.pg_id, b.is_disable, b.first_vac_site as fvs, b.second_vac_site as svs, v.vaccinator as vaccinator_name, ae.description as adverse_event_condition, vs1.bakuna_center_id as first_vac_site, vs2.bakuna_center_id as second_vac_site, vs1.vac_site as vs1, vs2.vac_site as vs2, c.codeprov, d.codecitymun, vac.manufacturer as vac_manufacturer');
			$this->db->from('clients a');
			$this->db->join('vaccination b', 'b.userid = a.id', 'INNER');
			$this->db->join('post_vaccination g', 'g.userid = a.id', 'INNER');
			$this->db->join('refprovince c', 'c.provCode = a.provCode', 'INNER');
			$this->db->join('refcitymun d', 'd.citymunCode = a.citymunCode', 'INNER');
			$this->db->join('refbrgy e', 'e.brgyCode = a.brgyCode', 'INNER');
			$this->db->join('refprovince f', 'f.provCode = b.employer_prov', 'LEFT');
			$this->db->join('priority_group pg', 'pg.pg_id = b.category', 'LEFT');
			$this->db->join('vaccinator v', 'v.v_id = g.vaccinator_name', 'LEFT');
			$this->db->join('adverse_event ae', 'ae.av_id = g.adverse_event', 'LEFT');
			$this->db->join('vac_site vs1', 'vs1.vac_site_id = b.first_vac_site', 'LEFT');
			$this->db->join('vac_site vs2', 'vs2.vac_site_id = b.second_vac_site', 'LEFT');
			$this->db->join('vaccines vac', 'vac.vaccine_id = g.vac_manufacturer', 'LEFT');

			if($data->vac_site1!=''){ 
				$data->vac_site1 = ($data->vac_site1=='EMPTY')?"":$data->vac_site1;
				$this->db->where('b.first_vac_site', $data->vac_site1);
			}

			if($data->vac_site2!=''){ 
				$data->vac_site2 = ($data->vac_site2=='EMPTY')?"":$data->vac_site2;
				$this->db->where('b.second_vac_site', $data->vac_site2);
			}

			if($data->date_start!=''){
				$this->db->where('g.vac_date >=', $data->date_start);
			}
			if($data->date_end!=''){
				$this->db->where('g.vac_date <=', $data->date_end);
			}
			if($data->min_age!=''){
				$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) >=', $data->min_age);
			}
			if($data->max_age!=''){
				$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <=', $data->max_age);
			}

			if($data->deferred !=''){ 
				if($data->deferred =='1'){
					$this->db->where('g.deferral !=', '');
					$this->db->where('g.deferral !=', 'NO'); 
				}
				 
				elseif($data->deferred =='0'){
					$array = array('','NO');
					$this->db->where_in('g.deferral', $array); 
				} 
			}

			if($data->category!=''){
			$this->db->group_start();
				foreach($data->category as $key => $val){
				if($val == 'A1'){
					$this->db->where('pg.priority_group', 'A1');
				}
				if($val == 'A1.1'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.1');
					$this->db->group_end();
				}
				if($val == 'A1.2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.2');
					$this->db->group_end();
				}
				if($val == 'A1.8'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.8');
					$this->db->group_end();
				}

				if($val == 'A2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) >=', '60');
								$this->db->where('pg.priority_group !=', 'A1');
								$this->db->where('pg.priority_group !=', 'A1.1');
								$this->db->where('pg.priority_group !=', 'A1.2');
								$this->db->where('pg.priority_group !=', 'A1.8');
						$this->db->group_end();
						$this->db->or_group_start();
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <=', '59');
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group !=', 'A2');
							$this->db->where('pg.priority_group !=', 'A1.1');
							$this->db->where('pg.priority_group !=', 'A1.2');
							$this->db->where('pg.priority_group !=', 'A1.8');
							$this->db->where('b.with_comorbidity', '01_Yes');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <=', '59');
							$this->db->where('pg.priority_group', 'A3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) =', NULL);
							$this->db->where('pg.priority_group', 'A3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) =', NULL);
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group !=', 'A2');
							$this->db->where('pg.priority_group !=', 'A1.1');
							$this->db->where('pg.priority_group !=', 'A1.2');
							$this->db->where('pg.priority_group !=', 'A1.8');
							$this->db->where('b.with_comorbidity', '01_Yes');
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
					$this->db->group_end();
				}				
				if($val == 'A4'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A4');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A5');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B1');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B2');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B4');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) = ', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
						$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) <', '60');
						$this->db->where('b.with_comorbidity', '02_None');
						$this->db->where('pg.priority_group', 'OTHERS');
					$this->db->group_end();
					$this->db->or_group_start();
						$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, b.first_vac_date) = ', NULL);
						$this->db->where('b.with_comorbidity', '02_None');
						$this->db->where('pg.priority_group', 'OTHERS');
					$this->db->group_end();
					$this->db->group_end();
				}
			}
			$this->db->group_end();
			}
			if($data->brgyCode!=''){
				$this->db->where_in('a.brgyCode', $data->brgyCode);
			}
			if($data->with_comorbidity!=''){
				$this->db->where('b.with_comorbidity', $data->with_comorbidity);
			} 

			if($data->vaccinator!=''){
				$this->db->where('g.vaccinator_name', $data->vaccinator);
			}
			if($data->vac_manufacturer!=''){
				$this->db->where('g.vac_manufacturer', $data->vac_manufacturer);
			}
			if($data->dose!=''){
				if($data->dose=='1'){
					$this->db->where('g.first_dose', '01_Yes');
				}
				if($data->dose=='2'){
					$this->db->where('g.second_dose', '01_Yes');
				}
			}else{
				$this->db->group_start();
				$this->db->where('g.first_dose !=', '');
				$this->db->or_where('g.first_dose !=', '');
				$this->db->group_end();
			}
			
			if($data->acct_status!=''){
				if($data->acct_status=='1'){
					$this->db->where('b.is_disable', 1);
				}
				if($data->acct_status=='0'){
					$this->db->where('b.is_disable', 0);
				}
			}
 			$this->db->where('a.active', '1');

			$this->db->group_by('g.userid, g.vac_date, g.first_dose, g.second_dose');
			// $query = $this->db->get('');
			// echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}



		public function get_vac($data){
			$this->db->select('DATE(b.date_reg) as date,  
			sum(IF(a.brgyCode = 43411001, 1,0)) AS anos,
			sum(IF(a.brgyCode = 43411002, 1,0)) AS bagong_silang,
			sum(IF(a.brgyCode = 43411003, 1,0)) AS bambang,
			sum(IF(a.brgyCode = 43411004, 1,0)) AS batong_malake,
			sum(IF(a.brgyCode = 43411005, 1,0)) AS baybayin,
			sum(IF(a.brgyCode = 43411006, 1,0)) AS bayog,
			sum(IF(a.brgyCode = 43411007, 1,0)) AS lalakay,
			sum(IF(a.brgyCode = 43411008, 1,0)) AS maahas, 
			sum(IF(a.brgyCode = 43411010, 1,0)) AS mayondon,
			sum(IF(a.brgyCode = 43411011, 1,0)) AS tuntungin_putho, 
			sum(IF(a.brgyCode = 43411012, 1,0)) AS san_antonio,
			sum(IF(a.brgyCode = 43411013, 1,0)) AS tadlac,
			sum(IF(a.brgyCode = 43411014, 1,0)) AS timugan,
			sum(IF(a.brgyCode = 43411015, 1,0)) AS malinta,
			count(b.userid) as total, a.*,b.*,c.provDesc, d.citymunDesc, e.brgyDesc, DATE_FORMAT(a.birthday, "%m/%d/%Y") as birthday, TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) AS age, unix_timestamp(date_reg) as date_reg_timestamp, pg.priority_group, pg.description, pg.pg_id'); 

			$this->db->from('clients a');
			$this->db->join('vaccination b', 'b.userid = a.id', 'INNER');
			$this->db->join('refprovince c', 'c.provCode = a.provCode', 'LEFT');
			$this->db->join('refcitymun d', 'd.citymunCode = a.citymunCode', 'INNER');
			$this->db->join('refbrgy e', 'e.brgyCode = a.brgyCode', 'INNER');
			// $this->db->join('refprovince f', 'f.provCode = b.employer_prov', 'LEFT');
			$this->db->join('priority_group pg', 'pg.pg_id = b.category', 'LEFT');
			$this->db->where('b.is_disable', '0');
			$this->db->where('a.active', '1');

			if($data->date_reg!=' '){ 
				$this->db->where('b.date_reg >', $data->date_reg);
			}
			if($data->min_age!=''){
				$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) >=', $data->min_age);
			}
			if($data->max_age!=''){
				$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <=', $data->max_age);
			}
			if($data->category!=''){
			$this->db->group_start();
				foreach($data->category as $key => $val){
				if($val == 'A1'){
					$this->db->where('pg.priority_group', 'A1');
				}
				if($val == 'A1.1'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.1');
					$this->db->group_end();
				}
				if($val == 'A1.2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.2');
					$this->db->group_end();
				}
				if($val == 'A1.8'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->where('pg.priority_group', 'A1.8');
					$this->db->group_end();
				}
				if($val == 'A2'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) >=', '60');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <=', '59');
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group !=', 'A2');
							$this->db->where('b.with_comorbidity', '01_Yes');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) >=', '18');
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <=', '59');
							$this->db->where('pg.priority_group', 'A3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) =', NULL);
							$this->db->where('pg.priority_group', 'A3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) =', NULL);
							$this->db->where('pg.priority_group !=', 'A1');
							$this->db->where('pg.priority_group !=', 'A2');
							$this->db->where('b.with_comorbidity', '01_Yes');
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
					$this->db->group_end();
				}				
				if($val == 'A4'){
					if($key!=0){
					$this->db->or_group_start();
					}else{
					$this->db->group_start();
					}
						$this->db->group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A4');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'A5');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B1');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B2');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B3');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) =', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <', '60');
							$this->db->where('b.with_comorbidity', '02_None');
							$this->db->where('pg.priority_group', 'B4');
						$this->db->group_end();
						$this->db->or_group_start();
							$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) = ', NULL);
							$this->db->where('b.with_comorbidity', '02_None');
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
						$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) <', '60');
						$this->db->where('b.with_comorbidity', '02_None');
						$this->db->where('pg.priority_group', 'OTHERS');
					$this->db->group_end();
					$this->db->or_group_start();
						$this->db->where('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) = ', NULL);
						$this->db->where('b.with_comorbidity', '02_None');
						$this->db->where('pg.priority_group', 'OTHERS');
					$this->db->group_end();
					$this->db->group_end();
				}
			}
			$this->db->group_end();
			}			if($data->brgyCode!=''){
				$this->db->where_in('a.brgyCode', $data->brgyCode);
			}
			if($data->with_comorbidity!=''){
				$this->db->where('b.with_comorbidity', $data->with_comorbidity);
			}
			$this->db->WHERE('b.userid !=','14261');
			$this->db->WHERE('a.active','1');
			$this->db->WHERE('b.is_disable','0');
			$this->db->order_by('b.date_reg', 'ASC');
			$this->db->group_by('b.userid');
			// $query = $this->db->get('');
			// echo $this->db->last_query();  
			return $this->db->get()->result_object(); 
		}

		public function get_mho($data){
			$this->db->select('b.fname, b.lname, b.mname, b.contact_number, b.address, d.brgyDesc, e.citymunDesc, c.name as est_visited, a.datetime,a.sov as sov_id, b.status as status_id, f.c_classification as status, ff.c_classification as sov, TIMESTAMPDIFF(YEAR, b.birthday, CURDATE()) AS age, b.sex ');
			$this->db->from('tracks a');
			$this->db->join('clients b', 'b.id = a.client_id');
			$this->db->join('establishments c', 'c.id = a.est_id');
			$this->db->join('refbrgy d', 'd.brgyCode = b.brgyCode');
			$this->db->join('refcitymun e', 'e.citymunCode = b.citymunCode');
			$this->db->join('covid_status f', 'f.c_status_id = b.status','left');
			$this->db->join('covid_status ff', 'ff.c_status_id = a.sov','left');
			$this->db->where("a.est_id", $data->est_id);
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.datetime >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.datetime <=', $date_to);
			}
			$this->db->order_by("a.id",'DESC');
			//$query = $this->db->get('');
			//echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}

		public function get_health_dec($data){
			$this->db->select('DATE_FORMAT(a.date_changed, "%M&nbsp;%d,%Y&nbsp;%H:%i:%s") as date_changed, DATE_FORMAT(a.onset_date, "%M&nbsp;%d,%Y") as onset_date, DATE_FORMAT(a.date_recovered, "%M&nbsp;%d,%Y") as date_recovered, concat(b.lname,", ",b.fname," ", b.mname) as fullname, b.contact_number, b.address,c.c_symptom as symptom, d.brgyDesc, e.citymunDesc');
			$this->db->from('client_symptoms a');
			$this->db->join('clients b', 'b.id = a.client_id');
			$this->db->join('symptoms c', 'c.c_symptom_id = a.symptoms');
			$this->db->join('refbrgy d', 'd.brgyCode = b.brgyCode');
			$this->db->join('refcitymun e', 'e.citymunCode = b.citymunCode');
			if($data->client_id){
				$this->db->where("a.client_id", $data->client_id);
			} 
			if($data->date_from != ""){
				$this->db->WHERE('a.onset_date >=',$data->date_from);
			}
			if($data->date_to != ""){
				$this->db->where('a.onset_date <=', $data->date_to);
			}
			if($data->ddate_from != ""){
				$ddate_from = date('Y-m-d H:i:s', strtotime($data->ddate_from." 00:00:00")); 
				$this->db->WHERE('a.date_changed >=',$ddate_from);
			}
			if($data->ddate_to != ""){
				$ddate_to = date('Y-m-d H:i:s', strtotime($data->ddate_to." 23:59:59")); 
				$this->db->where('a.date_changed <=', $ddate_to);
			}
			//$query = $this->db->get('');
			//echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}

		public function get_close_contact($data){
			$this->db->select('DATE_FORMAT(a.date_added, "%M&nbsp;%d,%Y&nbsp;%H:%i:%s") as date_added, DATE_FORMAT(a.closed_contact_date, "%M&nbsp;%d,%Y") as closed_contact_date, concat(b.lname,", ",b.fname," ", b.mname) as fullname, b.contact_number, b.address, d.brgyDesc, e.citymunDesc');
			$this->db->from('closed_contact_tbl a');
			$this->db->join('clients b', 'b.id = a.closed_client_id');
			$this->db->join('refbrgy d', 'd.brgyCode = b.brgyCode');
			$this->db->join('refcitymun e', 'e.citymunCode = b.citymunCode');
			if($data->client_id){
				$this->db->where("a.client_id", $data->client_id);
			} 
			if($data->date_from != ""){
				$this->db->WHERE('a.closed_contact_date >=',$data->date_from);
			}
			if($data->date_to != ""){
				$this->db->where('a.closed_contact_date <=', $data->date_to);
			}
			if($data->ddate_from != ""){
				$ddate_from = date('Y-m-d H:i:s', strtotime($data->ddate_from." 00:00:00")); 
				$this->db->WHERE('a.date_added >=',$ddate_from);
			}
			if($data->ddate_to != ""){
				$ddate_to = date('Y-m-d H:i:s', strtotime($data->ddate_to." 23:59:59")); 
				$this->db->where('a.date_added <=', $ddate_to);
			}
			//$query = $this->db->get('');
			//echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}

		public function get_age_bracket($data){
			$this->db->select('DATE(a.datetime) as date,
							sum(IF(TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) <= 20, 1,0)) AS ageb20,
							sum(IF(TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) >= 21 AND TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) <=29, 1,0)) AS age2129,
							sum(IF(TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) >= 30 AND TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) <=39, 1,0)) AS age3039,
							sum(IF(TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) >= 40 AND TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) <=49, 1,0)) AS age4049,
							sum(IF(TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) >= 50 AND TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) <=59, 1,0)) AS age5059,
							sum(IF(TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) >= 60 AND TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) <=65, 1,0)) AS age6065,
							sum(IF(TIMESTAMPDIFF(YEAR, b.birthday ,a.datetime) >= 66, 1,0)) AS ageg66,
							sum(if(a.sov != 1, 1,0)) as alert_logs, 
							count(a.id) as total');
			$this->db->from('tracks a');
			$this->db->join('clients b', 'b.id = a.client_id');
			$this->db->join('establishments c', 'c.id = a.est_id');
			if($data->est_id){
				$this->db->where("a.est_id", $data->est_id);
			}
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.datetime >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.datetime <=', $date_to);
			}
			$this->db->WHERE('b.id !=','14261');
			$this->db->group_by('DATE(a.datetime)');
			$this->db->order_by('DATE(a.datetime)','ASC');
			//$query = $this->db->get('');
			//echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}

		public function get_est_logs($data){
			$this->db->select('c.name as scanner_name, DATE(a.datetime) as date_log,
				sum(if(a.sov = 1 OR a.sov = 4, 1,0)) as normal_logs, 
				sum(if(a.sov != 1, 1,0)) as alert_logs, 
				c.name, a.datetime ');
			$this->db->from('tracks a');
			$this->db->join('establishments c', 'c.id = a.est_id');

			if($data->est_id){
				$this->db->where("a.est_id", $data->est_id);
			}
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.datetime >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.datetime <=', $date_to);
			}
			if($data->alert == 1){
				$this->db->where_in('a.sov',["2","3","5","6"]);
			}
			if($data->alert == 0){
				$this->db->where_in('a.sov',["1","4"]);
			}
			$this->db->WHERE('c.id !=','14261');
			$this->db->group_by('DATE(a.datetime), a.est_id');
			$this->db->order_by('normal_logs','DESC');
			//$query = $this->db->get('');
			//echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}

		public function get_vac_category($data){ 
			$this->db->select('DATE(c.vac_date) as date,  
			sum(IF(
					(d.priority_group = "A1" OR d.priority_group = "A1.1" OR d.priority_group = "A1.2" )
					, 1,0)
					) AS A1,
			sum(IF(
					(d.priority_group = "A1.8")
					, 1,0)
					) AS A18,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) >= 60 
					AND d.priority_group != "A1" AND d.priority_group != "A1.1" AND d.priority_group != "A1.2" AND d.priority_group != "A1.8")
					OR
					(d.priority_group = "A2")
					, 
					1,0)
					) AS A2,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) >= 18 
						AND 
						TIMESTAMPDIFF(YEAR, b.birthday ,a.first_vac_date) <=59 
						AND 
						a.with_comorbidity  = "01_Yes" 
						AND 
						d.priority_group != "A1"
						AND 
						d.priority_group != "A2"
						AND 
						d.priority_group != "A1.1"
						AND 
						d.priority_group != "A1.2"
						AND 
						d.priority_group != "A1.8"
					) 
					OR 
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) >= 18 
						AND 
						TIMESTAMPDIFF(YEAR, b.birthday ,a.first_vac_date) <=59 
						AND 
						d.priority_group = "A3"
					) 
					OR 
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL 
						AND 
						d.priority_group = "A3"
					) 
					OR 
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL 
						AND 
						d.priority_group != "A1"
						AND 
						d.priority_group != "A2"
						AND 
						a.with_comorbidity  = "01_Yes" 
						AND 
						d.priority_group != "A1.1"
						AND 
						d.priority_group != "A1.2"
						AND 
						d.priority_group != "A1.8"
					) 
					OR
					(d.priority_group = "EA3")
					, 1,0)
					) AS A3,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) < 60
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "A4"
					)
					OR
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "A4"
					)
					, 1,0)
					) AS A4,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) < 60
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "A5"
					)
					OR
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "A5"
					)
					, 1,0)
					) AS A5,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) < 60
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "B1"
					)
					OR
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "B1"
					)
					, 1,0)
					) AS B1,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) < 60
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "B2"
					)
					OR
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "B2"
					)
					, 1,0)
					) AS B2,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) < 60
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "B3"
					)
					OR
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "B3"
					)
					, 1,0)
					) AS B3,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) < 60
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "B4"
					)
					OR
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "B4"
					)
					, 1,0)
					) AS B4,
			sum(IF(
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) < 60
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "OTHERS"
					)
					OR
					(TIMESTAMPDIFF(YEAR, b.birthday , a.first_vac_date) IS NULL
						AND
						a.with_comorbidity  = "02_None" 
						AND 
						d.priority_group = "OTHERS"
					)
					, 1,0)
					) AS others,
			count(c.userid) as total');

			$this->db->from('vaccination a');
			$this->db->join('clients b', 'b.id = a.userid'); 
			$this->db->join('post_vaccination c', 'c.userid = a.userid', 'INNER'); 
			$this->db->join('priority_group d', 'd.pg_id = a.category','LEFT'); 

			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('c.vac_date >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('c.vac_date <=', $date_to);
			}
			if($data->vac_manufacturer != ""){
				$this->db->where('c.vac_manufacturer', $data->vac_manufacturer);
			}
			if($data->dose!=''){
				if($data->dose=='1'){
					$this->db->where('c.first_dose', '01_Yes');
				}
				if($data->dose=='2'){
					$this->db->where('c.second_dose', '01_Yes');
				}
			}
			$this->db->WHERE('b.id !=','14261');
			$this->db->WHERE('a.is_disable =','0');
			$this->db->WHERE('b.active','1');
			$this->db->group_start();
				$this->db->WHERE('c.first_dose !=','');
				$this->db->OR_WHERE('c.second_dose !=','');
			$this->db->group_end();
			$this->db->group_by('DATE(c.vac_date)');
			$this->db->order_by('DATE(c.vac_date)','ASC');
			//$query = $this->db->get('');
			//echo $this->db->last_query();

			return $this->db->get()->result_object();
		}

		public function get_vac_per_brgy($data){ 
			$this->db->select('DATE(c.vac_date) as date,  
			sum(IF(b.brgyCode = 43411001, 1,0)) AS anos,
			sum(IF(b.brgyCode = 43411002, 1,0)) AS bagong_silang,
			sum(IF(b.brgyCode = 43411003, 1,0)) AS bambang,
			sum(IF(b.brgyCode = 43411004, 1,0)) AS batong_malake,
			sum(IF(b.brgyCode = 43411005, 1,0)) AS baybayin,
			sum(IF(b.brgyCode = 43411006, 1,0)) AS bayog,
			sum(IF(b.brgyCode = 43411007, 1,0)) AS lalakay,
			sum(IF(b.brgyCode = 43411008, 1,0)) AS maahas, 
			sum(IF(b.brgyCode = 43411010, 1,0)) AS mayondon,
			sum(IF(b.brgyCode = 43411011, 1,0)) AS tuntungin_putho, 
			sum(IF(b.brgyCode = 43411012, 1,0)) AS san_antonio,
			sum(IF(b.brgyCode = 43411013, 1,0)) AS tadlac,
			sum(IF(b.brgyCode = 43411014, 1,0)) AS timugan,
			sum(IF(b.brgyCode = 43411015, 1,0)) AS malinta,
			count(c.userid) as total');

			$this->db->from('vaccination a');
			$this->db->join('clients b', 'b.id = a.userid'); 
			if($data->dose == '1'){
				$this->db->join('(select * from post_vaccination where first_dose = "01_Yes") c', 'c.userid = a.userid', 'INNER'); 
			}elseif($data->dose == '2'){
			$this->db->join('(select * from post_vaccination where second_dose = "01_Yes") c', 'c.userid = a.userid', 'INNER'); 
			}elseif($data->dose == '0'){
			$this->db->join('post_vaccination c', 'c.userid = a.userid', 'INNER'); 
			}
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.vac_date >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.vac_date <=', $date_to);
			}

			$this->db->WHERE('b.id !=','14261');
			$this->db->WHERE('a.is_disable =','0');
			$this->db->group_start();
				$this->db->WHERE('c.first_dose !=','');
				$this->db->OR_WHERE('c.second_dose !=','');
			$this->db->group_end();
			$this->db->group_by('DATE(c.vac_date)');
			$this->db->order_by('DATE(c.vac_date)','ASC'); 

			return $this->db->get()->result_object();
		}
		
		public function get_vac_site($data){ 
			$this->db->select('DATE(a.vac_date) as date,  
			sum(IF(c.first_vac_site = "1" OR c.second_vac_site = "1", 1,0)) AS VacSite1,
			sum(IF(c.first_vac_site = "2" OR c.second_vac_site = "2", 1,0)) AS VacSite2,
			sum(IF(c.first_vac_site = "3" OR c.second_vac_site = "3", 1,0)) AS VacSite3,
			sum(IF(c.first_vac_site = "4" OR c.second_vac_site = "4", 1,0)) AS VacSite4,
			sum(IF(c.first_vac_site = "5" OR c.second_vac_site = "5", 1,0)) AS VacSite5,
			sum(IF(c.first_vac_site = "6" OR c.second_vac_site = "6", 1,0)) AS VacSite6,
			sum(IF(c.first_vac_site = "7" OR c.second_vac_site = "7", 1,0)) AS VacSite7,
			count(c.userid) as total');

			$this->db->from('post_vaccination a');
			$this->db->join('clients b', 'b.id = a.userid'); 
			$this->db->join('vaccination c', 'c.userid = a.userid'); 
			 
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.vac_date >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.vac_date <=', $date_to);
			}
			if($data->dose!=''){
				if($data->dose=='1'){
					$this->db->where('a.first_dose', '01_Yes');
					$this->db->where('c.first_vac_site', $data->vac_site);
				}
				if($data->dose=='2'){
					$this->db->where('a.second_dose', '01_Yes');
					$this->db->where('c.second_vac_site', $data->vac_site);
				}
			}else{
				$this->db->group_start();
					$this->db->where('c.first_vac_site', $data->vac_site);
					$this->db->or_where('c.second_vac_site', $data->vac_site);
				$this->db->group_end();
			}

			$this->db->WHERE('b.id !=','14261');
			$this->db->WHERE('c.is_disable =','0');
			$this->db->group_start();
				$this->db->WHERE('a.first_dose !=','');
				$this->db->OR_WHERE('a.second_dose !=','');
			$this->db->group_end();
			$this->db->group_by('DATE(a.vac_date)');
			$this->db->order_by('DATE(a.vac_date)','ASC');
			//$query = $this->db->get('');
			//echo $this->db->last_query();

			return $this->db->get()->result_object();
		}


		public function get_vaccine($data){ 
			$this->db->select('DATE(a.vac_date) as date,  
			sum(IF(a.vac_manufacturer = "1", 1,0)) AS Vac1,
			sum(IF(a.vac_manufacturer = "2", 1,0)) AS Vac2,
			sum(IF(a.vac_manufacturer = "5", 1,0)) AS Vac3,
			sum(IF(a.vac_manufacturer = "3", 1,0)) AS Vac4, 
			count(a.userid) as total');

			$this->db->from('post_vaccination a');
			$this->db->join('clients b', 'b.id = a.userid'); 
			$this->db->join('vaccination c', 'c.userid = a.userid'); 
			 
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.vac_date >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.vac_date <=', $date_to);
			}
			if($data->dose!=''){
				if($data->dose=='1'){
					$this->db->where('a.first_dose', '01_Yes');
				}
				if($data->dose=='2'){
					$this->db->where('a.second_dose', '01_Yes');
				}
			} 

			$this->db->WHERE('b.id !=','14261');
			$this->db->WHERE('c.is_disable =','0');
			$this->db->group_by('DATE(a.vac_date)');
			$this->db->order_by('DATE(a.vac_date)','ASC'); 

			return $this->db->get()->result_object();
		}
	}
?>

