<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DostApi extends MY_Controller {

	public function __construct() {
		parent::__construct();
		//$this->isLogin();
		//$this->output->enable_profiler(TRUE);
		 // Load Pagination library
    	$this->load->library('pagination');
    	$this->load->helper('captcha');
	}

	public function reminder_data()
	{
		$this->load->model('General_model');
		$where = new stdClass();
		$where->vac_date = $this->input->post('reminder_date');
		$where->reply = 'YES';
		$where->dose = $this->input->post('dose');
		$where->category_group = $this->input->post('category_group');
		$data = $this->General_model->get_msg_details_reminder($where);

		echo json_encode($data);
	}

	public function send_reminder()
	{
		$this->load->model('General_model');
		//android as gsm modem
		$ip_add = $_SERVER['REMOTE_ADDR'];
		$api_key = $this->input->post('api_key');
		if($api_key=='smsatlosbanos'){
	  		$contact_number = $this->input->post('contact_number');
	  		$name = $this->input->post('name');
	  		$vac_date = $this->input->post('vac_date');
	  		$vac_site = $this->input->post('vac_site');
	  		$time_schedule = $this->input->post('time_schedule');
	  		$dose = $this->input->post('dose');

	  		if($vac_site==1){
	  			$site_text = 'Batong Malake Covered Court';
	  		}elseif($vac_site==2){
	  			$site_text = 'UPLB Copeland';
	  		}elseif($vac_site==3){
	  			$site_text = 'LB Evacuation Center';
	  		}

			$message = 'LB RESBAKUNA REMINDER';
			$message .= "\n".$name;
			$message .= "\n".date('F d, Y', strtotime($vac_date)).' At '. $time_schedule;
	  		$message .= "\n".$site_text;
	  		$message .= "\nFaceshield and Mask at all times\nBring Your Own Pen";
	  		$message .= "\n DO NOT REPLY.";

			$data_sms = new stdClass();
			$data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
			$data_sms->message_id = '0';
	  		$data_sms->number = '63'.substr($contact_number, -10);

	  		$data_sms->message = $message;
			$url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';
			echo $get_data = json_encode($this->callAPI('POST', $url, $data_sms));
		}
	}	

	public function frontliner_reminder()
	{
		$this->load->model('General_model');
		//android as gsm modem
		$ip_add = $_SERVER['REMOTE_ADDR'];
		$api_key = $this->input->post('api_key');
		if($api_key=='smsatlosbanos'){
	  		$contact_number = $this->input->post('contact_number');
	  		$name = $this->input->post('name');
	  		$vac_date = $this->input->post('vac_date');
	  		$vac_site = $this->input->post('vac_site');
	  		$time_schedule = $this->input->post('time_schedule');
	  		$dose = $this->input->post('dose');

	  		if($vac_site==1){
	  			$site_text = 'Batong Malake Covered Court';
	  		}elseif($vac_site==2){
	  			$site_text = 'UPLB Copeland';
	  		}elseif($vac_site==3){
	  			$site_text = 'LB Evacuation Center';
	  		}

			$message = 'LB RESBAKUNA REMINDER';
			$message .= "\n".$name;
			$message .= "\n".date('F d, Y', strtotime($vac_date)).' At '. $time_schedule;
	  		$message .= "\n".$site_text;
	  		$message .= "\nA1 required to bring any of the ff as proof:";
	  		$message .= "\nPRC, COE as medical frontliner, Certificate of Training.";
	  		$message .= "\n DO NOT REPLY.";

			$data_sms = new stdClass();
			$data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
			$data_sms->message_id = '0';
	  		$data_sms->number = '63'.substr($contact_number, -10);

	  		$data_sms->message = $message;
			$url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';
			echo $get_data = json_encode($this->callAPI('POST', $url, $data_sms));
		}
	}	

	public function send_new()
	{
		$this->load->model('General_model');

		$this->isLogin();
 		$this->load->model('Admin_model');
 		$this->load->model('General_model');

  		$userid = $this->input->post('userid');
  		$contact_number = '0'.substr($this->input->post('contact_number'), -10);
  		$name = $this->input->post('name');
  		$vac_date = $this->input->post('vac_date');
  		$vac_manufacturer = $this->input->post('vac_manufacturer');
  		$vac_site = $this->input->post('vac_site');
  		$dose = $this->input->post('dose');

  		if($vac_site==1){
  			$site_text = 'BM Covered Court';
  		}elseif($vac_site==2){
  			$site_text = 'UPLB Copeland';
  		}elseif($vac_site==3){
  			$site_text = 'Evacuation Center';
  		}elseif($vac_site==4){
  			$site_text = 'St. Jude';
  		}elseif($vac_site==5){
  			$site_text = 'LBDH';
  		}elseif($vac_site==6){
  			$site_text = 'HealthServ';
  		}elseif($vac_site==7){
  			$site_text = 'UPLB UHS';
  		}
		$message = 'LB RESBAKUNA';
  		$message .= "\n".strtoupper($name);
  		$message .= "\n".date('F d',strtotime($vac_date));
  		$message .= "\n".$site_text;
  		//if vacmanufacturer is not empty ussually in second dose
  		if($vac_manufacturer!=''){
  			$message .= "\n".$vac_manufacturer;
  		}
  		if($dose=='1'){
  			$message .= ' Dose 1';
  		}
  		if($dose=='2'){
  			$message .= ' Dose 2';
  		}
        /* Array Parameter Data */
        $data = new stdClass();
        $data->userid = $userid;
        //compare to dose number
        $data->dose = $dose;
        //check if user is already texted without comparing to date
		$texted_previous = $this->General_model->filter_list($data,'sent_messages',false);
        //check if user is already texted today
		$checker = $this->General_model->filter_list($data,'sent_messages',false);
		//if there is a record get the code
		if(count($checker)>0){
			$data->code = $this->General_model->filter_list($data,'sent_messages',false)[0]->code;
		}else{
			//ensure that the code generated is unique for today
        	$wherecode = new stdClass();
        	// $wherecode->date = $data->date;
			do {
			  $code = rand(100,999);
			  $wherecode->code = $code;
			  $wherecode->contact_number = $contact_number;
			} while ($this->General_model->checker_dynamic($wherecode,'sent_messages'));

        	$data->code = $code;
        	//add date if new entry
	        $data->date = date('Y-m-d');
    	}

        $data->contact_number = $contact_number;
        $data->vac_date = $vac_date;
        $data->vac_manufacturer = $vac_manufacturer;
        $data->vac_site = $vac_site;

  		$message .= "\nValid Reply";
  		$message .= "\nTo CONFIRM: YES".$data->code;
  		$message .= "\nTo DECLINE: NO".$data->code;
  		$message .= "\nTo STOP: STOP".$data->code;
  		// if($dose=='1'){
  		// 	$message .= "\nDISREGARD IF GIVEN DOSE 1";
  		// }
  		// if($dose=='2'){
  		// 	$message .= "\nDISREGARD IF GIVEN DOSE 2";
  		// }
		$message .= "\nNON-TRANSFERABLE";


		//check if there is no record yet
		if(count($texted_previous)==0){
			//add to database if no record
			$msg_id = $this->Admin_model->add($data,'sent_messages');
			//if there is already record
		}elseif($texted_previous>0){
			$msg_id = $texted_previous[0]->msg_id;
			//edit the data
			$this->Admin_model->edit($data,$msg_id,'sent_messages','msg_id');
		}
        // $url = 'https://lbsms.mglb-covid19-tracker.com/Sms/send_text';       
		$url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';

		$data_sms = new stdClass();
		$data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
		$data_sms->message_id = $msg_id;
  		$data_sms->number = '63'.substr($contact_number, -10);

  		$data_sms->message = $message;

		$get_data = json_decode($this->callAPI('POST', $url, $data_sms));
		echo $get_data;					
	}	

	public function send_new_bulk()
	{
		$this->load->model('General_model');

		$this->isLogin();
 		$this->load->model('Admin_model');
 		$this->load->model('General_model');
        $this->load->model('Vac_list_model');

        $schedule = date("Y-m-d", strtotime($this->input->post('schedule')));
        $status = $this->input->post('status');
        $vac_site = $this->input->post('vac_site');
        $dose = $this->input->post('dose');
        $new = $this->input->post('new');
        $data = $this->Vac_list_model->get_scheduled_list($schedule, $dose,$status, $vac_site);
        $jsondata = array();
        foreach($data as $val){
	  		$userid = $val->userid;
	  		$contact_number = '0'.substr($val->contact_number, -10);
	  		$name = $val->lname.', '.$val->fname;
	  		$vac_date = $val->vac_date;
	  		$vac_manufacturer = $val->vaccine;
	  		$vac_site = $val->vac_site;
	  		$dose = $this->input->post('dose');

	  		if($vac_site==1){
	  			$site_text = 'Batong Malake Covered Court';
	  		}elseif($vac_site==2){
	  			$site_text = 'UPLB Copeland';
	  		}elseif($vac_site==3){
	  			$site_text = 'LB Evacuation Center';
	  		}
	  		$message = 'MGLB RESBAKUNA Schedule: ';
	  		$message .= "\n".strtoupper($name);
	  		$message .= "\n".date('F d, Y',strtotime($vac_date));
	  		$message .= "\n".$site_text;
	  		//if vacmanufacturer is not empty ussually in second dose
	  		if($vac_manufacturer!=''){
	  			$message .= "\n".$vac_manufacturer;
	  		}

	        /* Array Parameter Data */
	        $data = new stdClass();
	        $data->userid = $userid;
	        //compare to dose number
	        $data->dose = $dose;
	        //check if user is already texted without comparing to date
			$texted_previous = $this->General_model->filter_list($data,'sent_messages',false);
	        //check if user is already texted today
			$checker = $this->General_model->filter_list($data,'sent_messages',false);
			//if there is a record get the code
			if(count($checker)>0){
				$data->code = $this->General_model->filter_list($data,'sent_messages',false)[0]->code;
			}else{
				//ensure that the code generated is unique for today
	        	$wherecode = new stdClass();
	        	// $wherecode->date = $data->date;
				do {
				  $code = rand(100,999);
				  $wherecode->code = $code;
				  $wherecode->contact_number = $contact_number;
				} while ($this->General_model->checker_dynamic($wherecode,'sent_messages'));

	        	$data->code = $code;
	        	//add date if new entry
		        $data->date = date('Y-m-d');
	    	}

	        $data->contact_number = $contact_number;
	        $data->vac_date = $vac_date;
	        $data->vac_manufacturer = $vac_manufacturer;
	        $data->vac_site = $vac_site;

	  		$message .= "\nTo CONFIRM reply YES".$data->code;
	  		$message .= "\nTo DECLINE reply NO".$data->code;
	    	
			//check if there is no record yet
			if(count($texted_previous)==0){
				//add to database if no record
				$msg_id = $this->Admin_model->add($data,'sent_messages');
				//if there is already record
			}elseif($texted_previous>0){
				$msg_id = $texted_previous[0]->msg_id;
				//edit the data
				$this->Admin_model->edit($data,$msg_id,'sent_messages','msg_id');
			}
	        // $url = 'https://lbsms.mglb-covid19-tracker.com/Sms/send_text';       
			$url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';

			$data_sms = new stdClass();
			$data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
			$data_sms->message_id = $msg_id;
	  		$data_sms->number = '63'.substr($contact_number, -10);

	  		$data_sms->message = $message;

			$jsondata[] = json_decode($this->callAPI('POST', $url, $data_sms));
		}
		echo json_encode($jsondata);
	}	

	public function send_reply()
	{
		$this->load->model('General_model');
		$ip_add = $_SERVER['REMOTE_ADDR'];
		$api_key = $this->input->post('api_key');
		$contact_number = $this->input->post('number');
		if(password_verify('lgulb'.date('Y-m-d'), $api_key) && $ip_add == '58.71.16.226'){
			//get ast 10 digit and add zero at the start
			$contact_number = '0'.substr($contact_number, -10);
			$message = $this->input->post('message');

			$sms = new stdClass();
			$sms->device = 'DOST';
			$sms->number = $contact_number;
			$sms->message = $message;			
			$sms->action = '1';//1 = received
			$sms->date = date('Y-m-d');//1 = send
			$sms->time = date('H:i:s');//1 = send
			$this->General_model->add($sms,'sms');


			//explode message
			$received_message = strtoupper(preg_replace('/\s+/', '', $message));
			$reply = substr($received_message,0,-3);
			$code = substr($received_message,-3);

			$data = new stdClass();
			$data->reply =$reply;

			$where = new stdClass();
			$where->contact_number = $contact_number;
			$where->code = $code;//code
			//check if there is a record
			$check = $this->General_model->filter_list_date($where);
			if(count($check)>0){
				//check if message is yes or no
				if($reply=='YES'){
					$where->reply = 'YES';
					$check_yes = $this->General_model->filter_list($where,'sent_messages',false);

					$where_sms = new stdClass();
					$where_sms->msg_id = $check[0]->msg_id;
					$result = $this->General_model->get_msg_details($where_sms);

					if(count($check_yes)>0){
						$data->time_schedule = $result[0]->time_schedule;
					}else{
						$where_reply = new stdClass();
						$where_reply->vac_date = $check[0]->vac_date;
						$where_reply->reply = 'YES';
						$where_reply->dose = $check[0]->dose;
						$where_reply->vac_site = $check[0]->vac_site;
						$count_yes = $this->General_model->filter_list($where_reply,'sent_messages',false);
						//do not comment
						$with_reply = count($count_yes);

						//set max number of client for this hour
						$max_interval = $check[0]->max_per_hour;
						//set min number of client for this hour
						$min_interval = 0;
						//set time schedule
						$start_time = $check[0]->start_time;
						//for for if statement start time to end time
						for($i=$check[0]->start_time; $i<=$check[0]->end_time; $i++){
							//if start time equal to 12 add 1 (12 is break time)
							if($start_time == '12'){
								$start_time++;
							}
							//if count of with reply is less than max interval and greater than min interval
							if($with_reply<$max_interval && $with_reply>=$min_interval){
								//set time schedule to start_time
								$time_schedule = $start_time;
								//exit loop when found the time schedule
								break;
							}
							//increase start_time / time schedule + hour interval
							$start_time = $start_time+$check[0]->hour_interval;
							//increase min interval + interval
							$min_interval =$min_interval+$check[0]->max_per_hour;
							//increase current max interval + interval
							$max_interval=$max_interval+$check[0]->max_per_hour;
							$counter++;
						}
						//if yes is greater than max_per_hour * hour
						if($with_reply>=$check[0]->max_client ){
							//set time schedule to start_time
							$time_schedule = $check[0]->over_time;
							//exit loop when found the time schedule
						}

						//convert time 24hours format to 12 hours format
						$data->time_schedule = ltrim(date("h A", strtotime($time_schedule.':00')),"0");
						// if($check[0]->vac_manufacturer != 'Gamaleya'){
						// 	if($with_reply<50){
						// 		$data->time_schedule = '8 AM';
						// 	}
						// 	if($with_reply<100 && $with_reply>=50){
						// 		$data->time_schedule = '9 AM';
						// 	}
						// 	if($with_reply<150 && $with_reply>=100){
						// 		$data->time_schedule = '10 AM';
						// 	}
						// 	if($with_reply<200 && $with_reply>=150){
						// 		$data->time_schedule = '11 AM';
						// 	}
						// 	if($with_reply<250 && $with_reply>=200){
						// 		$data->time_schedule = '1 PM';
						// 	}
						// 	if($with_reply<300 && $with_reply>=250){
						// 		$data->time_schedule = '2 PM';
						// 	}
						// 	if($with_reply<350 && $with_reply>=300){
						// 		$data->time_schedule = '3 PM';
						// 	}
						// 	if($with_reply<400 && $with_reply>=350){
						// 		$data->time_schedule = '4 PM';
						// 	}
						// }else{
						// 	if($check[0]->vac_date == '2021-06-09'){
						// 		if($with_reply<50){
						// 			$data->time_schedule = '8 AM';
						// 		}
						// 		if($with_reply<100 && $with_reply>=50){
						// 			$data->time_schedule = '1 PM';
						// 		}
						// 	}else{
						// 		if($with_reply<50){
						// 			$data->time_schedule = '8 AM';
						// 		}
						// 		if($with_reply<100 && $with_reply>=50){
						// 			$data->time_schedule = '10 AM';
						// 		}
						// 	}
						// }
						unset($where->reply);
						$this->General_model->update($data,$where,'sent_messages');
					}
					$message = 'RESBAKUNA CONFIRMED SCHEDULE:';
					$message .= "\n".$result[0]->lname.', '.$result[0]->fname;
					$message .= "\n".date('F d, Y', strtotime($result[0]->vac_date)).' At '. $data->time_schedule;

			  		if($check[0]->vac_site==1){
			  			$site_text = 'Batong Malake Covered Court';
			  		}elseif($check[0]->vac_site==2){
			  			$site_text = 'UPLB Copeland';
			  		}elseif($check[0]->vac_site==3){
			  			$site_text = 'LB Evacuation Center Paciano Park';
			  		}

					$message .= "\n".$site_text;
					if($check[0]->dose == '1'){
						if($check[0]->priority_group == 'A1'){
							$message .= "\nA1 category bring PROOF as FRONTLINER";
						}
						if($check[0]->priority_group == 'A1.1' || $check[0]->priority_group == 'A1.2' ){
							$message .= "\nA1 relative bring PROOF of relation to A1 and LB Residency.";
						}
						if($check[0]->category == '15'){
							$message .= "\nBring PROOF as outbound OFW and LB Residency.";
						}
						if($check[0]->priority_group == 'A2' && ($check[0]->age < '60' || $check[0]->age == NULL)){
							$message .= "\nA2 category bring PROOF as SENIOR and LB Residency.";
						}
						if($check[0]->with_comorbidity == '01_Yes' &&  ($check[0]->age <="59" || $check[0]->age == NULL) && $check[0]->priority_group != 'A1' && $check[0]->priority_group != 'A2'){
							$message .= "\nA3 category bring PROOF of COMORBIDITY and LB Residency.";
						}
						if($check[0]->priority_group == 'A3' && $check[0]->with_comorbidity == '02_None' && ($check[0]->age <="59" || $check[0]->age == NULL)){
							$message .= "\nA3 category bring PROOF of COMORBIDITY and LB Residency.";
						}
						if($check[0]->priority_group == 'A4' && $check[0]->category != '15'){
							$message .= "\nA4 category bring PROOF of LB Residency.";
						}
						if($check[0]->priority_group == 'A5'){
							$message .= "\nA5 category bring PROOF of LB Residency.";
						}
						if($check[0]->priority_group == 'OTHERS'){
							$message .= "\nROP category bring PROOF LB Residency.";
						}
					}else{
							$message .= "\nBring your own pen. Wear mask and faceshield properly.";
					}				//check if reply is no
				}elseif($reply=='NO'){
					$message = 'You have DECLINED Your Schedule. You may be scheduled again on a later date. Thank You.';

					$where->reply = 'YES';
					$check_reply = $this->General_model->filter_list($where,'sent_messages',false);
					if(count($check_reply)>0){
						$data->time_schedule = '';
					}
					unset($where->reply);
					$this->General_model->update($data,$where,'sent_messages');
				//end if reply == no
				}elseif($reply=='STOP'){
					$message = 'Kayo po ay hindi na muling makakatanggap ng mensahe mula sa LB RESBAKUNA. Isuot ng maayos ang facemask at faceshield sa lahat ng oras. Maraming Salamat po.';
					$where->reply = 'YES';
					$check_reply = $this->General_model->filter_list($where,'sent_messages',false);
					if(count($check_reply)>0){
						$data->time_schedule = '';
					}
					unset($where->reply);
					$this->General_model->update($data,$where,'sent_messages');					
				}else{
					$message = 'Invalid Response! Please Try again with valid response.';
				}
			}else{
				$message = 'Invalid Response! Please Try again with valid response.';
			}		//send confirmation or error text
	        // $url = 'https://lbsms.mglb-covid19-tracker.com/Sms/send_text';       
			$url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';

			//send data
			$data_sms = new stdClass();
			$data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
			$data_sms->message_id = '0';
	  		$data_sms->number = '63'.substr($contact_number, -10);

	  		$data_sms->message = $message;

			$this->callAPI('POST', $url, $data_sms);
		}
	}

	public function send_reply_manual()
	{
		$this->load->model('General_model');
		$ip_add = $_SERVER['REMOTE_ADDR'];
		// $api_key = $this->input->post('api_key');
		$contact_number = $this->input->get('number');
		if($ip_add == '58.71.16.226'){
			//get ast 10 digit and add zero at the start
			$contact_number = '0'.substr($contact_number, -10);
			//explode message
			$received_message = strtoupper(preg_replace('/\s+/', '', $this->input->get('message')));
			$reply = substr($received_message,0,-3);
			$code = substr($received_message,-3);

			$data = new stdClass();
			$data->reply =$reply;

			$where = new stdClass();
			$where->contact_number = $contact_number;
			$where->code = $code;//code
			//check if there is a record
			$check = $this->General_model->filter_list_date($where);
			if(count($check)>0){
				//check if message is yes or no
				if($reply=='YES'){
					$where->reply = 'YES';
					$check_yes = $this->General_model->filter_list($where,'sent_messages',false);

					$where_sms = new stdClass();
					$where_sms->msg_id = $check[0]->msg_id;
					$result = $this->General_model->get_msg_details($where_sms);

					if(count($check_yes)>0){
						$data->time_schedule = $result[0]->time_schedule;
					}else{
						$where_reply = new stdClass();
						$where_reply->vac_date = $check[0]->vac_date;
						$where_reply->reply = 'YES';
						$where_reply->dose = $check[0]->dose;
						$where_reply->vac_site = $check[0]->vac_site;
						$count_yes = $this->General_model->filter_list($where_reply,'sent_messages',false);

						$with_reply = count($count_yes);
						if($check[0]->vac_manufacturer != 'Gamaleya'){
							if($with_reply<50){
								$data->time_schedule = '8 AM';
							}
							if($with_reply<100 && $with_reply>=50){
								$data->time_schedule = '9 AM';
							}
							if($with_reply<150 && $with_reply>=100){
								$data->time_schedule = '10 AM';
							}
							if($with_reply<200 && $with_reply>=150){
								$data->time_schedule = '11 AM';
							}
							if($with_reply<250 && $with_reply>=200){
								$data->time_schedule = '1 PM';
							}
							if($with_reply<300 && $with_reply>=250){
								$data->time_schedule = '2 PM';
							}
							if($with_reply<350 && $with_reply>=300){
								$data->time_schedule = '3 PM';
							}
							if($with_reply<400 && $with_reply>=350){
								$data->time_schedule = '4 PM';
							}
						}else{
							if($check[0]->vac_date == '2021-06-09'){
								if($with_reply<50){
									$data->time_schedule = '8 AM';
								}
								if($with_reply<100 && $with_reply>=50){
									$data->time_schedule = '1 PM';
								}
							}else{
								if($with_reply<50){
									$data->time_schedule = '8 AM';
								}
								if($with_reply<100 && $with_reply>=50){
									$data->time_schedule = '10 AM';
								}
							}
						}
						unset($where->reply);
						$this->General_model->update($data,$where,'sent_messages');
					}
					$message = 'RESBAKUNA CONFIRMED SCHEDULE:';
					$message .= "\n".$result[0]->lname.', '.$result[0]->fname;
					$message .= "\n".date('F d, Y', strtotime($result[0]->vac_date)).' At '. $data->time_schedule;

			  		if($check[0]->vac_site==1){
			  			$site_text = 'Batong Malake Covered Court';
			  		}elseif($check[0]->vac_site==2){
			  			$site_text = 'UPLB Copeland';
			  		}elseif($check[0]->vac_site==3){
			  			$site_text = 'LB Evacuation Center';
			  		}

					$message .= "\n".$site_text;
					if($check[0]->with_comorbidity == '01_Yes' && $check[0]->age >= '18' && $check[0]->age <="59" && $check[0]->priority_group != 'A1'){
						$message .= "\nA3 category bring PROOF of COMORBIDITY";
					}
					if($check[0]->priority_group == 'A1'){
						$message .= "\nA1 category bring PROOF as FRONTLINER";
					}
				//check if reply is no
				}elseif($reply=='NO'){
					$message = 'You have DECLINED Your Schedule. You may be scheduled again on a later date. Thank You.';

					$where->reply = 'YES';
					$check_reply = $this->General_model->filter_list($where,'sent_messages',false);
					if(count($check_reply)>0){
						$data->time_schedule = '';
					}
					unset($where->reply);
					$this->General_model->update($data,$where,'sent_messages');
				//end if reply == stop
				}elseif($reply=='STOP'){
					$message = 'Kayo po ay hindi na muling makakatanggap ng mensahe mula sa LB RESBAKUNA. Isuot ng maayos ang facemask at faceshield sa lahat ng oras. Maraming Salamat po.';
					$where->reply = 'YES';
					$check_reply = $this->General_model->filter_list($where,'sent_messages',false);
					if(count($check_reply)>0){
						$data->time_schedule = '';
					}
					unset($where->reply);
					$this->General_model->update($data,$where,'sent_messages');					
				}else{
					$message = 'Invalid Response! Please Try again with valid response.';
				}
			}else{
				$message = 'Invalid Response! Please Try again with valid response.';
			}		//send confirmation or error text
	        // $url = 'https://lbsms.mglb-covid19-tracker.com/Sms/send_text';       
			$url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';

			//send data
			$data_sms = new stdClass();
			$data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
			$data_sms->message_id = '0';
	  		$data_sms->number = '63'.substr($contact_number, -10);

	  		$data_sms->message = $message;

			$this->callAPI('POST', $url, $data_sms);
		}
	}

	public function update_status()
	{
		$this->load->model('General_model');
		$ip_add = $_SERVER['REMOTE_ADDR'];
		$api_key = $this->input->post('api_key');
		$msg_id = $this->input->post('msg_id');
		$status = $this->input->post('status');
		if(password_verify('lgulb'.date('Y-m-d'), $api_key) && $ip_add == '58.71.16.226'){
			if($msg_id!='0'){
				$where = new stdClass();
				$where->msg_id = $msg_id;
				$data = new stdClass();
				$data->status = $status;
				$this->General_model->update($data,$where,'sent_messages');
			}
		}
	}	

	public function send_custom_sms()
	{
		$this->load->model('General_model');
		//android as gsm modem
		$ip_add = $_SERVER['REMOTE_ADDR'];
		$api_key = $this->input->post('api_key');
		if($api_key=='smsatlosbanos'){
	  		$contact_number = $this->input->post('contact_number');

			$message = 'LB RESBAKUNA ADVISORY';
			$message .= "\nYour 2nd Dose of Gamaleya/Sputnik V will be rescheduled as advised by DOH. Pls wait for the notice of new schedule.";

			$data_sms = new stdClass();
			$data_sms->api_key = password_hash('lgulb'.date('Y-m-d'), PASSWORD_BCRYPT);
			$data_sms->message_id = '0';
	  		$data_sms->number = '63'.substr($contact_number, -10);

	  		$data_sms->message = $message;
			$url = 'https://lbsms.mglb-covid19-tracker.com/api/sms';
			echo $get_data = json_encode($this->callAPI('POST', $url, $data_sms));
		}
	}	

  	public function callAPI($method, $url, $data){
	   $curl = curl_init();
	   switch ($method){
	      case "POST":
	         curl_setopt($curl, CURLOPT_POST, 1);
	         if ($data)
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	         break;
	      case "PUT":
	         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	         if ($data)
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
	         break;
	      default:
	         if ($data)
	            $url = sprintf("%s?%s", $url, http_build_query($data));
	   }
	   // OPTIONS:
	   curl_setopt($curl, CURLOPT_URL, $url);
	   // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	   // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	   // EXECUTE:
	   $result = curl_exec($curl);
	   curl_close($curl);

 		$this->load->model('General_model');

		$sms = new stdClass();
		$sms->device = 'DOST';
		$sms->number = '0'.substr($data->number, -10);
		$sms->message = $data->message;			
		$sms->action = '2';//1 = send
		$sms->date = date('Y-m-d');//1 = send
		$sms->time = date('H:i:s');//1 = send
		//insert to db message sent
		$this->General_model->add($sms,'sms');

	   return $result;
	}
}
