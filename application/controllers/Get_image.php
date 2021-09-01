<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_image extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($img = null)
	{
		$this->isLogin_client();
		$img = $this->session->userdata('user')['image_path'];
		$file_extension = explode('.',$img);

		switch($file_extension[1]){
			case "gif": $ctype = 'image/gif'; break; 
			case "png": $ctype = 'image/png'; break; 
			case "jpeg": 
			case "jpg": $ctype = 'image/jpeg'; break; 
			case "svg": $ctype = 'image/svg+xml'; break; 
		}

		header('Content-Type: '. $ctype);

		readfile($img);
	}

	public function check($img = null)
	{
		$this->isLogin_client();
		$img = base_url().'assets/images/check.gif';
		$file_extension = explode('.',$img);

		switch($file_extension[1]){
			case "gif": $ctype = 'image/gif'; break; 
			case "png": $ctype = 'image/png'; break; 
			case "jpeg": 
			case "jpg": $ctype = 'image/jpeg'; break; 
			case "svg": $ctype = 'image/svg+xml'; break; 
		}

		header('Content-Type: '. $ctype);

		readfile($img);
	}

	public function a1reg($filename)
	{
		$img = base_url().'assets/images/Instructions/ScanQR.jpg';
		$ctype = 'image/jpeg';

		header('Content-Type: '. $ctype);

		readfile($img);
	}
}
