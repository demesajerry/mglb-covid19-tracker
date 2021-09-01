<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $data = array();
	protected $login_user_data = array();
	public function __construct()
	{
		parent::__construct();

		// $this->data['bread_crumbs'] = array();
	}
	
	public function admin_loader()
	{
		// $this->data["login_admin_data"] = $this->session->userdata('login_admin_data');
	}
	
	protected function redirect_to_default_page() 
	{				
 		//redirect(site_url("admin/home"));
	}
	
	protected function isLogin()
	{
		if(!$this->session->userdata('logged_in'))
		{
			redirect(site_url("Authentication/logout"));
		}
	}

	protected function isLogin_est()
	{
		if(!$this->session->userdata('est_logged_in'))
		{
			redirect(site_url("Authentication/est_logout"));
		}
	}

	protected function isLogin_tagger()
	{
		if(!$this->session->userdata('tagger_logged_in'))
		{
			redirect(site_url("Tagger/logout"));
		}
	}

	protected function isLogin_client()
	{
		if(!$this->session->userdata('user'))
		{
			redirect(site_url("Contact_tracing"));
		}
	}

	protected function linkGenerator()
	{
		$links_label = $this->session->userdata('logged_in')->links_label;
		$this->load->model('General_model', '', TRUE);
		$data = new stdClass();
		$tree_data = $this->General_model->link_tree();

		function buildTree($data, $parentId){
		    $branch = array();

		    foreach ($data as $element) 
		    {
		        if ($element->parent_id == $parentId) 
		        {
		            $children = buildTree($data, $element->link_id);
		            if ($children) 
		            {
		                $element->children = $children;
		            }
		            $branch[] = $element;
		        }

		    }

		    return $branch;
		}

		$link_generated = buildTree($tree_data,0);

		function printTree($array,$links_label) {
			 $output='';
		    foreach ($array as $a) {
		    	if(!empty(array_intersect(array($a->label), $links_label))){
			    	//if parent and multiple is false add direct link
			    	if($a->multiple == 0){
				        $output .= "<li>";
				        $output .= "<a href='".base_url().$a->link."'>";
				        $output .= "<i class='".$a->icon."'></i> ";
				        $output .= "<span>".$a->label."</span></a>";
				        $output .= "</li>";
			        //if multiple is true  start tree view
			    	}else{
				        $output .= "<li class='treeview'>";
				        $output .= "<a href='#'>";
				        $output .= "<i class='".$a->icon."'></i> ";
				        $output .= "<span>".$a->label."</span>";
				        $output .= "<span class='pull-right-container'>";
				        $output .= "<i class='fa fa-angle-left pull-right'></i>";
				        $output .= "</span>";
				        $output .= "</a>";
				        $output .= "<ul class='treeview-menu'>";
			    	}
				        if (isset($a->children)) {
				            $output .= printTree($a->children,$links_label);
				        }
			        //if multiple is true  end tree view
			        if($a->multiple == 1){
				        $output .= "</ul>";
			        }
			    }
				        $output .= "</li>";
		    }
		    return $output;
		}
		return printTree($link_generated,$links_label);
	}

	protected function isAllowed()
	{
		$allowed_links = $this->session->userdata('logged_in')->links;
		$link_loc = [];
		if($this->router->fetch_method() == 'index'){
			$link_loc[] = $this->router->fetch_class().'/'.$this->router->fetch_method();
			$link_loc[] = $this->router->fetch_class().'/';
			$link_loc[] = $this->router->fetch_class();
		}else{
			$link_loc[] = $this->router->fetch_class().'/'.$this->router->fetch_method();
		}
		// echo '<pre>' . var_export($allowed_links, true) . '</pre>';
		// echo '<pre>' . var_export($link_loc, true) . '</pre>';
    	if(empty(array_intersect($link_loc, $allowed_links)))
		{
			redirect(site_url("Admin/forbidden"));
		}
	}

	protected function isAllowed_est()
	{
		$userid = $this->session->userdata('est_logged_in')->userid;
    	if(!in_array($userid,array(469)))
		{
			redirect(site_url("Establishment/forbidden"));
		}
	}
	protected function isAllowed_Tagger()
	{
		$userid = $this->session->userdata('tagger_logged_in')->access;
    	if(!in_array($userid,array(1,2)))
		{
			redirect(site_url("Tagger/forbidden"));
		}
	}

}
