<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends MY_Controller {

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
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$where = new stdClass();
		$where->vac_date = $this->input->post('reminder_date');
		$where->dose = $this->input->post('dose');
		$where->category_group = $this->input->post('category_group');
		$data = $this->General_model->get_msg_details_reminder($where,$start,$end);

		echo json_encode($data);
	}

	public function frontliner_reminder()
	{
		//android as gsm modem
		$this->load->model('General_model');
		$apikey = $this->input->post('apikey');
		$ip_add = $_SERVER['REMOTE_ADDR'];
		if($apikey=='smsatlosbanos'){
	  		$contact_number = '0'.substr($this->input->post('contact_number'), -10);
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
			$this->send_text($message,$contact_number);
		}
	}

	public function a1_relative()
	{
		//android as gsm modem
		$this->load->model('General_model');
		$apikey = $this->input->post('apikey');
		$ip_add = $_SERVER['REMOTE_ADDR'];
		if($apikey=='smsatlosbanos'){
	  		$contact_number = '0'.substr($this->input->post('contact_number'), -10);
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
	  		$message .= "\nA1 relatives are required to bring proof of relation to A1 and proof of Los Baños residency.";
	  		$message .= "\nBring your own pen. Wear Mask and faceshield properly.";
		    // echo json_encode($message);

			$this->send_text($message,$contact_number);
		}
	}


	public function send_reminder()
	{
		//android as gsm modem
		$apikey = $this->input->post('apikey');
		$ip_add = $_SERVER['REMOTE_ADDR'];

		if($apikey=='smsatlosbanos'){
	  		$contact_number = '0'.substr($this->input->post('contact_number'), -10);
	  		$name = $this->input->post('name');
	  		$vac_date = $this->input->post('vac_date');
	  		$vac_site = $this->input->post('vac_site');
	  		$time_schedule = $this->input->post('time_schedule');
	  		$device_id = $this->input->post('device_id');
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
	  		$message .= "\nWear facemask and faceshield properly. Bring Ballpen.";
	  		$message .= "\nSalamat po.";
			$this->send_text($message,$contact_number,$device_id);
		}
	}

	public function received_message($apikey = false, $device_id = false)
	{
		// $this->isLogin();
		//android as gsm modem
		$this->load->model('General_model');
		//echo $apikey;
		$ip_add = $_SERVER['REMOTE_ADDR'];
		if($apikey=='smsatlosbanos' && $ip_add == '58.71.16.226'){
			//get ast 10 digit and add zero at the start
			$contact_number = '0'.substr($this->input->get('phoneNumber'), -10);

			$message = $this->input->get('message');

			$sms = new stdClass();
			$sms->device = 'SAMSUNG';
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
						if($check[0]->pregnancy_status != '01_Pregnant' && $check[0]->priority_group == 'A1'){
							$message .= "\nA1 category bring PROOF as FRONTLINER";
						}
						if($check[0]->pregnancy_status != '01_Pregnant' && $check[0]->priority_group == 'A1.1' || $check[0]->priority_group == 'A1.2' ){
							$message .= "\nA1 relative bring PROOF of relation to A1 and LB Residency.";
						}
						if($check[0]->pregnancy_status != '01_Pregnant' && $check[0]->category == '15'){
							$message .= "\nBring PROOF as outbound OFW and LB Residency.";
						}
						if($check[0]->priority_group == 'A2' && ($check[0]->age >= '60' || $check[0]->age == NULL)){
							$message .= "\nA2 category bring PROOF as SENIOR and LB Residency.";
						}
						if($check[0]->with_comorbidity == '01_Yes' &&  ($check[0]->age <="59" || $check[0]->age == NULL) && $check[0]->pregnancy_status != '01_Pregnant' && $check[0]->priority_group != 'A1' && $check[0]->priority_group != 'A2'){
							$message .= "\nA3 category bring PROOF of COMORBIDITY and LB Residency.";
						}
						if($check[0]->priority_group == 'A3' && $check[0]->with_comorbidity == '02_None' && $check[0]->pregnancy_status != '01_Pregnant' && ($check[0]->age <="59" || $check[0]->age == NULL)){
							$message .= "\nA3 category bring PROOF of COMORBIDITY and LB Residency.";
						}
						if(($check[0]->priority_group == 'EA3' || $check[0]->pregnancy_status == '01_Pregnant') && ($check[0]->age <="59" || $check[0]->age == NULL)){
							$message .= "\nEA3 Bring proof of PREGNANCY and LB Residency.";
						}
						if($check[0]->priority_group == 'A4' && $check[0]->category != '15' && $check[0]->with_comorbidity != '01_Yes' && $check[0]->pregnancy_status != '01_Pregnant'){
							$message .= "\nA4 category bring PROOF of LB Residency.";
						}
						if($check[0]->priority_group == 'A5' && $check[0]->with_comorbidity != '01_Yes' && $check[0]->pregnancy_status != '01_Pregnant'){
							$message .= "\nA5 category bring PROOF of LB Residency.";
						}
						if($check[0]->priority_group == 'OTHERS' && $check[0]->with_comorbidity != '01_Yes' && $check[0]->pregnancy_status != '01_Pregnant'){
							$message .= "\nROP category bring PROOF LB Residency.";
						}
					}else{
							$message .= "\nBring your own pen. Wear mask and faceshield properly.";
					}

				//check if reply is no
				}elseif($reply=='RESCHED'){
					$message = 'You will be rescheduled again at a later date. Thank You.';

					$where->reply = 'YES';
					$check_reply = $this->General_model->filter_list($where,'sent_messages',false);
					if(count($check_reply)>0){
						$data->time_schedule = '';
					}
					unset($where->reply);
					$this->General_model->update($data,$where,'sent_messages');
				//end if reply == no
				}elseif($reply=='NO'){
					$message = 'Kayo po ay hindi na muling makakatanggap ng mensahe mula sa LB RESBAKUNA. Maraming Salamat po.';
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
			}
			//send confirmation or error text
			$this->send_text($message,$contact_number,$device_id);
		}
	}	

	public function manual_sms()
	{
		$this->isLogin();
		//android as gsm modem
		$this->load->model('General_model');

		//get ast 10 digit and add zero at the start
		$contact_number = '0'.substr($this->input->post('phoneNumber'), -10);
		$device_id = $this->input->post('device_id');

		$message = $this->input->post('message');

		$sms = new stdClass();
		$sms->device = 'SAMSUNG';
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
					if($with_reply>$check[0]->max_client ){
						//set time schedule to start_time
						$time_schedule = $check[0]->overtime;
						//exit loop when found the time schedule
					}

					//convert time 24hours format to 12 hours format
					$data->time_schedule = ltrim(date("h A", strtotime($time_schedule.':00')),"0");

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
					$message .= "\nThis is NON-TRANSFERABLE";
			//check if reply is no
			}elseif($reply=='RESCHED'){
				$message = 'You have DECLINED Your Schedule. You may be scheduled again on a later date. Thank You.';

				$where->reply = 'YES';
				$check_reply = $this->General_model->filter_list($where,'sent_messages',false);
				if(count($check_reply)>0){
					$data->time_schedule = '';
				}
				unset($where->reply);
				$this->General_model->update($data,$where,'sent_messages');
			//end if reply == no
			}elseif($reply=='NO'){
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
		$this->send_text($message,$contact_number,$device_id);
	}	

  	public function alert_text(){
		// $this->isLogin();
  		$username = 'pido';
  		$password = 'pido2322';
  		$contact_number = '09163638499';
  		$name = $this->input->post('name');
  		$est = $this->session->userdata('est_logged_in')->name;
  		$time = date('Y-m-d H:i:s');
  		$message = 'MGLB Covid19 Tracker Alert';
  		$message .= "\n Establishment: ".$est;
  		$message .= "\n Client: ".$name;
  		$message .= "\n Time: ".$time;
  		 /* API URL */
        $url = 'http://58.71.16.227/SendSMS';
                 
        $data_sms = ['message'=>$message, 'phone'=>$contact_number, 'username'=>$username, 'password'=>$password];
		$get_data = $this->callAPI('POST', $url, $data_sms, '1');	
  	}

  	public function send_cancellation(){
		$this->isLogin();
  		$username = 'pido';
  		$password = 'sms@losbanos';
		$contact_number = '0'.substr($this->input->post('contact_number'), -10);
		$vac_date = $this->input->post('vac_date');
  		// $name = $this->input->post('name');
  		$time = date('Y-m-d H:i:s');
  		$message = 'LB RESBAKUNA ANNOUNCEMENT';
  		$message .= "\nDue to the typhoon, ";
  		$message .= "Vaccination scheduled for ".date('F d, Y',strtotime($vac_date)). " is cancelled.";
  		$message .= "\n\nWe will send notification for new schedule.";
  		 /* API URL */
        $url = 'http://58.71.16.227/SendSMS';
                 
        $data_sms = ['message'=>$message, 'phone'=>$contact_number, 'username'=>$username, 'password'=>$password];
		$get_data = $this->callAPI('POST', $url, $data_sms, '1');	
  	}

  	public function vac_msg(){
		$this->isLogin();
 		$this->load->model('Admin_model');
 		$this->load->model('General_model');

        // $url = 'https://lbsms.mglb-covid19-tracker.com/Sms/send_text';       
        $url = $this->input->post('link');
        $device_id = $this->input->post('device_id');

  		$userid = $this->input->post('userid');
  		$username = 'pido';
  		$password = 'sms@losbanos';
  		$contact_number = '0'.substr($this->input->post('contact_number'), -10);
  		$number_prefix = substr($contact_number, 1,3);
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
  			$site_text = 'LB Evacuation Center';
  		}elseif($vac_site==4){
  			$site_text = 'St. Jude';
  		}elseif($vac_site==5){
  			$site_text = 'LBDH';
  		}elseif($vac_site==6){
  			$site_text = 'HealthServ';
  		}elseif($vac_site==7){
  			$site_text = 'UPLB UHS';
  		}elseif($vac_site==8){
  			$site_text = 'IRRI';
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
  		$message .= "\nYES".$data->code;
  		$message .= "\nRESCHED".$data->code;
  		$message .= "\nNO".$data->code;
  		// if($dose=='1'){
  		// 	$message .= "\nDISREGARD IF GIVEN DOSE 1";
  		// }
  		// if($dose=='2'){
  		// 	$message .= "\nDISREGARD IF GIVEN DOSE 2";
  		// }
		$message .= "\nNON-TRANSFERABLE";
		if($vac_manufacturer == 'Janssen'){
			$message .="\nIto po ay para sa mga SENIOR CITTIZEN(A2) at ADULT WITH COMORBIDITY(A3) lamang. Para sa A3 category kayo po ay kailangan mag dala ng patunay ng inyong comorbidity.";
		}
        $data_sms = ['message'=>$message, 'phone'=>$contact_number, 'username'=>$username, 'password'=>$password];
        //get prefixes
        $mobile_prefix=$this->General_model->fetch_prefixes();
        //if not contact nnumber prefix is not in prefix listand total lenght of number is not 11 do not send sms
    	if(in_array($number_prefix,$mobile_prefix) && strlen($contact_number) == 11){
			$get_data = $this->callAPI('POST', $url, $data_sms, $device_id);
		}else{
			$get_data = false;
			$failed_sms = new stdClass();
			$failed_sms->userid = $userid;
			$failed_sms->number = $contact_number;
			$failed_sms->date_texted = date('Y-m-d');
			$failed_sms->vac_date = $vac_date;
			$this->Admin_model->add($failed_sms,'failed_sms');
		}
		//if text is successfull
		if($get_data!=false){
        	$data->si_id = $this->input->post('si_id');
			//check if there is no record yet
			if(count($texted_previous)==0){
				//add to database if no record
				$this->Admin_model->add($data,'sent_messages');
				//if there is already record
			}elseif($texted_previous>0){
				//edit the data
				if($texted_previous[0]->vac_date < $vac_date){
					$data->reply = '';
					$data->time_schedule = '';
				}
				$this->Admin_model->edit($data,$texted_previous[0]->msg_id,'sent_messages','msg_id');
			}
		    return $get_data;
		}else{
			$jsondata = new stdClass();
			$jsondata->status = false;
		    echo json_encode($jsondata);
		}		
  	}

  	public function bulk_vac_msg(){
		$this->isLogin();
 		$this->load->model('Admin_model');
 		$this->load->model('General_model');

        // $url = 'https://lbsms.mglb-covid19-tracker.com/Sms/send_text';       
        $url = 'http://sms.mglb-covid19-tracker.com/SendSMS';

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
	  		$username = "pido";
	  		$password = "sms@losbanos";
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
	    	
	        $data_sms = ['message'=>$message, 'phone'=>$contact_number, 'username'=>$username, 'password'=>$password];
			$get_data = $this->callAPI2('GET', $url, $data_sms, $device_id);
			// if text is successfull
			if($get_data!=false){
				//check if there is no record yet
				if(count($texted_previous)==0){
					//add to database if no record
					$this->Admin_model->add($data,'sent_messages');
					//if there is already record
				}elseif($texted_previous>0){
					//edit the data
					$this->Admin_model->edit($data,$texted_previous[0]->msg_id,'sent_messages','msg_id');
				}
				$jsondata[] = json_decode($get_data);
			}
		}	
		echo json_encode($jsondata);
  	}


  	public function send_text($message,$number,$device_id){
		// $this->isLogin();
 		$this->load->model('Admin_model');
  		$username = 'pido';
  		$password = 'sms@losbanos';
  		$contact_number = $number;
  		$message = $message;
  		 /* API URL */
        // $url = 'https://lbsms.mglb-covid19-tracker.com/Sms/send_text';
 		$this->load->model('General_model');
 		//get device link
		$url = $this->General_model->get_one_row('device','device_id',$device_id)->link;

        $data_sms = ['message'=>$message, 'phone'=>$contact_number, 'username'=>$username, 'password'=>$password];
		$this->callAPI('POST', $url, $data_sms,$device_id);
  	}

  	public function ayuda_text(){
		// $this->isLogin();
 		$this->load->model('Admin_model');
  		$username = 'pido';
  		$password = 'sms@losbanos';
  		$contact_number = '09163638499';//$this->input->post('contact_number');
  		$message = "Huling panawagan sa mga nais mapabilang sa Financial Assistance.\n
		 1. Mga HINDI mga nakatanggap sa mga naunang prioridad tulad ng SAP beneficiaries, Waitlisted, 4ps, PWD, Senior Citizen at Solo Parents\n
		2. Mga HINDI mga nakapagpa validate o interview sa kanya kanyang mga barangay para sa Financial Assistance. \n
		Maaari po kayong magdala ng photocopy ng inyong Valid IDs ng Family Head at mga miyembro ng pamilya at Birthcertificate  para sa menor de edad na kasapi ng pamilya.\n
		Magsadya Municipal Activity Area sa Mayo 13, 2021 sa ganap na 8 ng Umaga hanggang 3 ng hapon lamang.";
  		 /* API URL */
        // $url = 'https://lbsms.mglb-covid19-tracker.com/Sms/send_text';       
        $url = 'http://sms.mglb-covid19-tracker.com/SendSMS';       

        $data_sms = ['message'=>$message, 'phone'=>$contact_number, 'username'=>$username, 'password'=>$password];
		$get_data = $this->callAPI('POST', $url, $data_sms);

		if($get_data!=false){
		    return $get_data;
		}else{
		    return false;
		}		
  	}

  	public function callAPI($method, $url, $data, $device_id){
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
	   // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	   // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	   // EXECUTE:
	   $result = curl_exec($curl);
	   curl_close($curl);
	   if(!$result){
	   		return false;
		}else{
	 		$this->load->model('General_model');

			$sms = new stdClass();
			$sms->device = $device_id;
			$sms->number = $data['phone'];
			$sms->message = $data['message'];			
			$sms->action = '2';//1 = send
			$sms->date = date('Y-m-d');//1 = send
			$sms->time = date('H:i:s');//1 = send
			$this->General_model->add($sms,'sms');

	   		return $result;
		}
	}

  	public function callAPI2($method, $url, $data, $device_id){
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
	   curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	   // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	   // EXECUTE:
	   $result = curl_exec($curl);
	   curl_close($curl);
	   if(!$result){
	   		return false;
		}else{
	 		$this->load->model('General_model');

			$sms = new stdClass();
			$sms->device = $device_id;
			$sms->number = $data['phone'];
			$sms->message = $data['message'];			
			$sms->action = '2';//1 = send
			$sms->date = date('Y-m-d');//1 = send
			$sms->time = date('H:i:s');//1 = send
			//insert to db message sent
			$this->General_model->add($sms,'sms');

	   		return $result;
		}
	}

	public function smshub_received($api_key = null){
 		$this->load->model('Admin_model');
 		if($api_key == 'smsatlosbanos'){
	 		$data = new stdClass();
	 		$data->deviceId = '22';
	 		$data->number = '09163638499';
	 		$data->message = 'test';
	 		$data->action = 'received';
	 		foreach($_GET as $key => $val){
	 			$data->message .= $key." : ".$val;
	 		}
	 		foreach($_POST as $key => $val){
	 			$data->message .= $key." : ".$val;
	 		}
			$this->Admin_model->add($data,'sms');
		}
	}
}
