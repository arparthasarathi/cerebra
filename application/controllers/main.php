<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	private $cms_db;

	public function __construct()
	{
		parent::__construct();

		$this->load->library('bitauth');

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('gravatar');
		$this->load->helper('kimage');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->load->model('mainmodel');
		$this->load->model('rosmodel');
		$this->db = $this->load->database('default',TRUE);
		$this->cms_db = $this->load->database('cms',TRUE);
	}

	public function index()
	{
		
		$data['title'] = "Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['sidebar'] = 2;
		$data['log']=0;

		$data['nav0'] = 1;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 0;

		$data['system_type'] = "home";

		$data['galleries'] = $this->mainmodel->getgalleries();
		$data['updates'] = $this->mainmodel->getupdates();
		$data['static_page'] = $this->mainmodel->getstaticpagetabsbystaticpageid($data['system_type']);
		$data['static_page_image'] = $this->mainmodel->getstaticpageimagebystaticpageid($data['system_type']);

        $data['colleges'] = $this->mainmodel->getlistofcollege();
        $data['degrees'] = $this->mainmodel->getlistofdegree();
        $data['courses'] = $this->mainmodel->getlistofcourse();

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;
		}

		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);			
			$this->load->view('_template/basic/section-start');
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('content/content-home-page',$data);
			$this->load->view('_template/basic/section-end');
		} else { 
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/head/title',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('content/content-home-page',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function events($eventurl="default")
	{

		$data['title'] = "Events | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;
		$data['profile_complete'] = 0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;

        	if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        	{
        		$data['profile_complete'] = 1;
        	}
		}


		
		$data['system_type'] = 'events';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 1;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 0;

		$data['subcategories'] = $this->mainmodel->getcontentsubcategories($data['system_type']);

		if($data['subcategories'])
		{
			foreach ($data['subcategories'] as $subcategory) {
				$data['content_'.$subcategory['content_subcategory']] = $this->mainmodel->getcontentitembysubcategories($subcategory['content_subcategory'],$data['system_type']);

				foreach ($data['content_'.$subcategory['content_subcategory']] as $content) {
					$data['track_data_'.$content['content_url']] = $this->mainmodel->getcontenttabbycontentitemid($content['content_item_id']);
					$data['subscription_'.$content['content_url']] = 0;
					if($this->bitauth->logged_in())
					{
						$data['subscription_'.$content['content_url']] = $this->mainmodel->checkattachmentsubscription($content['content_item_id'],$logged_details->kid);
					}	
				}
			}
		}

		$data['content_data_primary'] = "";
		$data['content_data_content'] = "";
		$sync = "";

		if($eventurl=="default")
		{
			$data['static_page_primary'] = $this->mainmodel->getstaticpagetabsbystaticpageid($data['system_type']);
			$data['static_page_image'] = $this->mainmodel->getstaticpageimagebystaticpageid($data['system_type']);

			$sync = $data['static_page_primary'];
			$sync1 = $data['static_page_image'];
			$construct_array[0]['content_item_title'] = $sync[0]['static_page_title'];
			$construct_array[0]['content_item_content'] = $sync[0]['static_page_content'];
			$data['content_data_primary'][0] = array(
					'content_title' => $construct_array[0]['content_item_title'],
					'content_type' => "",
					'content_item_sponsor_url' => "",
					'content_item_id' => 0

			);

			$data['content_data_image'][0] = array (
					'content_item_image_url' => $sync1[0]['static_page_image_url']
				);

			$data['content_data_sponsor'] = 0;

			$data['content_data_content'][0] = array(
				'content_item_tab_content' =>  $sync[0]['static_page_content'],
				'content_item_tab_id' => $sync[0]['static_page_id'],
				'content_item_tab_title' => $sync[0]['static_page_title'],
			);

			$data['tabbed'] = 0;
		}
		else
		{
			$data['content_data_primary'] = $this->mainmodel->getcontentitemtabsbycontentitemid($eventurl);
			$data['content_data_image'] = $this->mainmodel->getcontentitemimagebycontentitemid($eventurl);
			$data['content_data_sponsor'] = $this->mainmodel->getcontentitemsponsorbycontentitemid($eventurl);
			$data['content_data_content'] = $this->mainmodel->getcontentitemtabdatabycontentitemid($eventurl);

			if(trim($data['content_data_primary'][0]['content_type']) == "tabbed")
				$data['tabbed'] = 1;
			else
				$data['tabbed'] = 0;
		}
		$data['sidebar'] = 1;
		
		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');			
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function workshops($workshopurl="default")
	{
		$data['title'] = "Workshops | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;
		$data['profile_complete'] = 0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;

        	if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        	{
        		$data['profile_complete'] = 1;
        	}
		}

		$data['system_type'] = 'workshops';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 1;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 0;

		$data['subcategories'] = $this->mainmodel->getcontentsubcategories($data['system_type']);

		if($data['subcategories'])
		{
			foreach ($data['subcategories'] as $subcategory) {
				$data['content_'.$subcategory['content_subcategory']] = $this->mainmodel->getcontentitembysubcategories($subcategory['content_subcategory'],$data['system_type']);

				foreach ($data['content_'.$subcategory['content_subcategory']] as $content) {
					$data['track_data_'.$content['content_url']] = $this->mainmodel->getcontenttabbycontentitemid($content['content_item_id']);
					$data['subscription_'.$content['content_url']] = 0;
					if($this->bitauth->logged_in())
					{
						if((trim(strtolower($content['content_url'])) == "facebot") || (trim(strtolower($content['content_url'])) == "bluebot") || (trim(strtolower($content['content_url'])) == "c2000"))
						{
							$data['subscription_'.$content['content_url']] = $this->mainmodel->checkteamworkshopattachmentsubscription($content['content_item_id'],$logged_details->kid);
						}
						else
						{
							$data['subscription_'.$content['content_url']] = $this->mainmodel->checkworkshopattachmentsubscription($content['content_item_id'],$logged_details->kid);
						}
					}
				}
			}
		}


		if($workshopurl=="default")
		{
			$data['static_page_primary'] = $this->mainmodel->getstaticpagetabsbystaticpageid($data['system_type']);
			$data['static_page_image'] = $this->mainmodel->getstaticpageimagebystaticpageid($data['system_type']);

			$sync = $data['static_page_primary'];
			$sync1 = $data['static_page_image'];

			$construct_array[0]['content_item_title'] = $sync[0]['static_page_title'];
			$construct_array[0]['content_item_content'] = $sync[0]['static_page_content'];
			$data['content_data_primary'][0] = array(
					'content_title' => $construct_array[0]['content_item_title'],
					'content_type' => "",
					'content_item_sponsor_url' => "",
					'content_item_id' => 0

			);

			$data['content_data_image'][0] = array (
					'content_item_image_url' => $sync1[0]['static_page_image_url']
				);

			$data['content_data_sponsor'] = 0;

			$data['content_data_content'][0] = array(
				'content_item_tab_content' =>  $construct_array[0]['content_item_content'],
				'content_item_tab_id' => $sync[0]['static_page_id'],
				'content_item_tab_title' => $sync[0]['static_page_title'],
			);

			$data['tabbed'] = 0;
		}
		else
		{
			$data['content_data_primary'] = $this->mainmodel->getcontentitemtabsbycontentitemid($workshopurl);
			$data['content_data_image'] = $this->mainmodel->getcontentitemimagebycontentitemid($workshopurl);
			$data['content_data_sponsor'] = $this->mainmodel->getcontentitemsponsorbycontentitemid($workshopurl);
			$data['content_data_content'] = $this->mainmodel->getcontentitemtabdatabycontentitemid($workshopurl);

			if(trim($data['content_data_primary'][0]['content_type']) == "tabbed")
				$data['tabbed'] = 1;
			else
				$data['tabbed'] = 0;
		}
		$data['sidebar'] = 1;
		
		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');			
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function lectures($lecturesurl="default")
	{
		$data['title'] = "Lectures | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;
		$data['profile_complete'] = 0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;

        	if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        	{
        		$data['profile_complete'] = 1;
        	}

		}

		$data['system_type'] = 'lectures';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 1;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 0;

		$data['subcategories'] = $this->mainmodel->getcontentsubcategories($data['system_type']);

		if($data['subcategories'])
		{
			foreach ($data['subcategories'] as $subcategory) {
				$data['content_'.$subcategory['content_subcategory']] = $this->mainmodel->getcontentitembysubcategories($subcategory['content_subcategory'],$data['system_type']);

				foreach ($data['content_'.$subcategory['content_subcategory']] as $content) {
					$data['track_data_'.$content['content_url']] = $this->mainmodel->getcontenttabbycontentitemid($content['content_item_id']);
					$data['subscription_'.$content['content_url']] = 0;
					if($this->bitauth->logged_in())
					{
						$data['subscription_'.$content['content_url']] = $this->mainmodel->checkattachmentsubscription($content['content_item_id'],$logged_details->kid);
					}
				}
			}
		}


		if($lecturesurl=="default")
		{
			$data['static_page_primary'] = $this->mainmodel->getstaticpagetabsbystaticpageid($data['system_type']);
			$data['static_page_image'] = $this->mainmodel->getstaticpageimagebystaticpageid($data['system_type']);

			$sync = $data['static_page_primary'];
			$sync1 = $data['static_page_image'];

			$construct_array[0]['content_item_title'] = $sync[0]['static_page_title'];
			$construct_array[0]['content_item_content'] = $sync[0]['static_page_content'];
			$data['content_data_primary'][0] = array(
					'content_title' => $construct_array[0]['content_item_title'],
					'content_type' => "",
					'content_item_sponsor_url' => "",
					'content_item_id' => 0

			);

			$data['content_data_image'][0] = array (
					'content_item_image_url' => $sync1[0]['static_page_image_url']
				);

			$data['content_data_sponsor'] = 0;

			$data['content_data_content'][0] = array(
				'content_item_tab_content' =>  $construct_array[0]['content_item_content'],
				'content_item_tab_id' => $sync[0]['static_page_id'],
				'content_item_tab_title' => $sync[0]['static_page_title'],
			);

			$data['tabbed'] = 0;
		}
		else
		{
			$data['content_data_primary'] = $this->mainmodel->getcontentitemtabsbycontentitemid($lecturesurl);
			$data['content_data_image'] = $this->mainmodel->getcontentitemimagebycontentitemid($lecturesurl);
			$data['content_data_sponsor'] = $this->mainmodel->getcontentitemsponsorbycontentitemid($lecturesurl);
			$data['content_data_content'] = $this->mainmodel->getcontentitemtabdatabycontentitemid($lecturesurl);

			if(trim($data['content_data_primary'][0]['content_type']) == "tabbed")
				$data['tabbed'] = 1;
			else
				$data['tabbed'] = 0;
		}
		$data['sidebar'] = 1;
		
		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');			
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function sponsors($sponsorsurl="2014")
	{
		$data['title'] = "Sponsors | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;
		$data['profile_complete'] = 0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;

        	if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        	{
        		$data['profile_complete'] = 1;
        	}
		}

		$data['system_type'] = 'sponsors';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 1;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 0;

		$data['avenues'] = array(
				'cosponsor' => "Co-Sponsor",
				'event' => "Events Sponsor",
				'barkamp' => "Barkamp Sponsor",
				'guestlectures' => "Guest Lectures",
				'telephone' => "Telephone",
				'accomdation' => "Accomdation",
				'title' => "Title",
				'hospitality' => "Hospitality",
				'travel' => "Travel",
				'marketing' => "Marketing",
				'onlinemarketing' => "Online Marketing",
				'awareness' => "Awareness",
				'eshopping' => "E-shopping",
				'multiplex' => "Multiplex",
				'youth' => "Youth",
				'innovation' => "Innovation",
				'studentoppurtunity' => "Student Oppurtunity",
				'photography' => "Photography",
				'videocoverage' => "Video Coverage",
				'technology' => "Technology",
				'outreach' => "Outreach",
				'promotional' => "Promotional",
				'food' => "Food",
				'transportation' => "Transportation",
				'courier' => "Courier",
				'logistics' => "Logistics",
				'printing' => "Printing",
				'tshirt' => "T-shirt",
				'guestfood' => "Guest Food"
			);

		$data['sponsors'] = $this->mainmodel->sponsorsyear();
		$sponsor['sponsor_year'] = $sponsorsurl;
		$data['sponsor_year'] =  $sponsorsurl;



        $data['getcategories_'.$sponsor['sponsor_year']] = $this->mainmodel->sponsorcategory($sponsor['sponsor_year']);
       	if($data['getcategories_'.$sponsor['sponsor_year']])
       	{
       		foreach ($data['getcategories_'.$sponsor['sponsor_year']] as $category) {
       			$data['track_sponsor_'.$category['sponsor_category']] = $this->mainmodel->getsponsorbysponsorcategory($category['sponsor_category'],$sponsor['sponsor_year']);
       		}
       	}




    	if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);	
			$this->load->view('_template/basic/section-start');		
			$this->load->view('content/content-sponsor-page-holder',$data);
			$this->load->view('content/content-sponsor-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-sponsor-page-holder',$data);
			$this->load->view('content/content-sponsor-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function xceed($xceedurl="default")
	{
		$data['title'] = "XCEED | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;
		$data['profile_complete'] = 0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;

        	if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        	{
        		$data['profile_complete'] = 1;
        	}
		}

		$data['system_type'] = 'xceed';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 1;
		

		// $data['accordionmenu'] = $this->mainmodel->getdistinctxceedurl();

		// if($data['accordionmenu'])
		// {
		// 	foreach ($data['accordionmenu'] as $a) {
		// 		$data['sidebar_'.$a['xceed_url']] = $this->mainmodel->getxceedbyxceedurl($a['xceed_url']);
		// 	}
		// }

		// $data['xceed_data_image'] = 0;
		// $data['xceed_data_content'] = $this->mainmodel->getxceedbyxceedurl($xceedurl);

		$data['subcategories'] = $this->mainmodel->getcontentsubcategories($data['system_type']);

		if($data['subcategories'])
		{
			foreach ($data['subcategories'] as $subcategory) {
				$data['content_'.$subcategory['content_subcategory']] = $this->mainmodel->getcontentitembysubcategories($subcategory['content_subcategory'],$data['system_type']);

				foreach ($data['content_'.$subcategory['content_subcategory']] as $content) {
					$data['track_data_'.$content['content_url']] = $this->mainmodel->getcontenttabbycontentitemid($content['content_item_id']);
					$data['subscription_'.$content['content_url']] = 0;
					if($this->bitauth->logged_in())
					{
						$data['subscription_'.$content['content_url']] = $this->mainmodel->checkattachmentsubscription($content['content_item_id'],$logged_details->kid);
					}
				}
			}
		}


		if($xceedurl=="default")
		{
			$data['static_page_primary'] = $this->mainmodel->getstaticpagetabsbystaticpageid($data['system_type']);
			$data['static_page_image'] = $this->mainmodel->getstaticpageimagebystaticpageid($data['system_type']);

			$sync = $data['static_page_primary'];
			$sync1 = $data['static_page_image'];

			$construct_array[0]['content_item_title'] = $sync[0]['static_page_title'];
			$construct_array[0]['content_item_content'] = $sync[0]['static_page_content'];
			$data['content_data_primary'][0] = array(
					'content_title' => $construct_array[0]['content_item_title'],
					'content_type' => "",
					'content_item_sponsor_url' => "",
					'content_item_id' => 0

			);

			$data['content_data_image'][0] = array (
					'content_item_image_url' => $sync1[0]['static_page_image_url']
				);

			$data['content_data_sponsor'] = 0;

			$data['content_data_content'][0] = array(
				'content_item_tab_content' =>  $construct_array[0]['content_item_content'],
				'content_item_tab_id' => $sync[0]['static_page_id'],
				'content_item_tab_title' => $sync[0]['static_page_title'],
			);

			$data['tabbed'] = 0;
		}
		else
		{
			$data['content_data_primary'] = $this->mainmodel->getcontentitemtabsbycontentitemid($xceedurl);
			$data['content_data_image'] = $this->mainmodel->getcontentitemimagebycontentitemid($xceedurl);
			$data['content_data_sponsor'] = $this->mainmodel->getcontentitemsponsorbycontentitemid($xceedurl);
			$data['content_data_content'] = $this->mainmodel->getcontentitemtabdatabycontentitemid($xceedurl);

			if(trim($data['content_data_primary'][0]['content_type']) == "tabbed")
				$data['tabbed'] = 1;
			else
				$data['tabbed'] = 0;
		}
		$data['sidebar'] = 1;

		

		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);			
			$this->load->view('_template/basic/section-start');
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function hospitality($hospitalityurl="hospitality")
	{
		$data['title'] = "Hospitality | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;
		}

		$data['system_type'] = 'hospitality';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 1;
		

		$data['accordionmenu'] = $this->mainmodel->getdistincthospitalityurl();

		if($data['accordionmenu'])
		{
			foreach ($data['accordionmenu'] as $a) {
				$data['sidebar_'.$a['hospitality_url']] = $this->mainmodel->gethospitalitybyhospitalityurl($a['hospitality_url']);
			}
		}

		$data['hospitality_data_image'] = 0;
		$data['hospitality_data_content'] = $this->mainmodel->gethospitalitybyhospitalityurl($hospitalityurl);

		

		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);			
			$this->load->view('_template/basic/section-start');
			$this->load->view('content/content-hospitality-page-holder',$data);
			$this->load->view('content/content-hospitality-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-hospitality-page-holder',$data);
			$this->load->view('content/content-hospitality-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function karnival($karnivalurl="karnival")
	{
		$data['title'] = "Hospitality | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;
		}

		$data['system_type'] = 'karnival';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 1;
		

		$data['accordionmenu'] = $this->mainmodel->getdistinctkarnivalurl();

		if($data['accordionmenu'])
		{
			foreach ($data['accordionmenu'] as $a) {
				$data['sidebar_'.$a['karnival_url']] = $this->mainmodel->getkarnivalbykarnivalurl($a['karnival_url']);
			}
		}

		$data['karnival_data_image'] = 0;
		$data['karnival_data_content'] = $this->mainmodel->getkarnivalbykarnivalurl($karnivalurl);

		

		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);			
			$this->load->view('_template/basic/section-start');
			$this->load->view('content/content-karnival-page-holder',$data);
			$this->load->view('content/content-karnival-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-karnival-page-holder',$data);
			$this->load->view('content/content-karnival-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function about($abouturl="k2014")
	{
		$data['title'] = "About Us | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;
		}

		$data['system_type'] = 'about';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 1;
		$data['nav6'] = 0;
		$data['nav7'] = 0;
		

		$data['accordionmenu'] = $this->mainmodel->getdistinctabouturl();

		if($data['accordionmenu'])
		{
			foreach ($data['accordionmenu'] as $a) {
				$data['sidebar_'.$a['about_url']] = $this->mainmodel->getaboutbyabouturl($a['about_url']);
			}
		}

		$data['about_data_image'] = 0;
		$data['about_data_content'] = $this->mainmodel->getaboutbyabouturl($abouturl);

		

		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);			
			$this->load->view('_template/basic/section-start');
			$this->load->view('content/content-about-page-holder',$data);
			$this->load->view('content/content-about-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-about-page-holder',$data);
			$this->load->view('content/content-about-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function contact($contacturl="default")
	{
		$data['title'] = "Contact Us | Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;
		}

		$data['system_type'] = 'contact';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 1;
		$data['nav7'] = 0;



		$data['accordionmenu'] = $this->mainmodel->getlimitedcontacts();

		$data['team'] = array(
			'qms' => "Queries & Info",
			'events' => "Events",
			'workshops' => "Workshops",
			'lectures' => "Guest Lectures",
			'xceed' => "XCEED",
			'ir' => "Industry Relations",
			'hospitality' => "Hospitality",
			'media' => "Media",
			'tech' => "Virtual Participation",
			'web' => "Web",
			'karnival' => "Karnival",
			'marketing' => "Student Relations"
		);

		$data['mail'] = array(
			'qms' => "helpdesk@kurukshetra.org.in",
			'events' => "events@kurukshetra.org.in",
			'workshops' => "workshop@kurukshetra.org.in",
			'lectures' => "guestlectures@kurukshetra.org.in",
			'xceed' => "xceed@kurukshetra.org.in",
			'ir' => "industryrelations@kurukshetra.org.in",
			'hospitality' => "hospidesk@kurukshetra.org.in",
			'media' => "media@kurukshetra.org.in",
			'tech' => "techteam@kurukshetra.org.in",
			'web' => "kweb@kurukshetra.org.in",
			'karnival' => "karnival@kurukshetra.org.in",
			'marketing' => "pr@kurukshetra.org.in"
		);





		foreach($data['team'] as $a => $v)
		{
			$data['team_'.$a] = $this->mainmodel->getbyoneeachteam($a);
		}

		if($data['accordionmenu'])
		{
			foreach ($data['accordionmenu'] as $a) {
				$data['sidebar_'.$a['team']] = $this->mainmodel->getcontactbycontacturl($a['team']);
			}
		}

		if($contacturl=="default")
		{
			$data['mailing'] = 1;
			$data['limited_contacts'] = $this->mainmodel->getlimitedcontactscontent();
			$data['contact_data_content'] = 0;
		}
		else
		{
			$data['mailing'] = 0;
			$data['contact_data_content'] = $this->mainmodel->getcontactbycontacturl($contacturl);
		}

		

		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);		
			$this->load->view('_template/basic/section-start');	
			$this->load->view('content/content-contact-page-holder',$data);
			$this->load->view('content/content-contact-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-contact-page-holder',$data);
			$this->load->view('content/content-contact-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function general($generalurl="default")
	{
		$data['title'] = "Kurukshetra 2014 | The Battle of Brains";
		$data['logged_in'] = 0;
		$data['log']=0;
		$data['profile_complete'] = 0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;

        	if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        	{
        		$data['profile_complete'] = 1;
        	}
        	if($generalurl == "hospitality")
			{
				$data['hospicontent'] = $this->mainmodel->checkhospiexists($logged_details->kid);
			}
		}

		$data['system_type'] = 'special';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 0;
		

		// $data['accordionmenu'] = $this->mainmodel->getdistinctxceedurl();

		// if($data['accordionmenu'])
		// {
		// 	foreach ($data['accordionmenu'] as $a) {
		// 		$data['sidebar_'.$a['xceed_url']] = $this->mainmodel->getxceedbyxceedurl($a['xceed_url']);
		// 	}
		// }

		// $data['xceed_data_image'] = 0;
		// $data['xceed_data_content'] = $this->mainmodel->getxceedbyxceedurl($xceedurl);

		$data['subcategories'] = $this->mainmodel->getspecialcontentsubcategories($data['system_type']);

		if($data['subcategories'])
		{
			foreach ($data['subcategories'] as $subcategory) {
				$data['content_'.$subcategory['content_subcategory']] = $this->mainmodel->getspecialcontentitembysubcategories($subcategory['content_subcategory'],$data['system_type']);

				foreach ($data['content_'.$subcategory['content_subcategory']] as $content) {
					$data['track_data_'.$content['content_url']] = $this->mainmodel->getcontenttabbycontentitemid($content['content_item_id']);
					$data['subscription_'.$content['content_url']] = 0;
					if($this->bitauth->logged_in())
					{
						$data['subscription_'.$content['content_url']] = 0;//$this->mainmodel->checkattachmentsubscription($content['content_item_id'],$logged_details->kid);
					}
				}
			}
		}


		if($generalurl=="default")
		{
			$data['static_page_primary'] = $this->mainmodel->getstaticpagetabsbystaticpageid($data['system_type']);
			$data['static_page_image'] = $this->mainmodel->getstaticpageimagebystaticpageid($data['system_type']);

			$sync = $data['static_page_primary'];
			$sync1 = $data['static_page_image'];

			$construct_array[0]['content_item_title'] = $sync[0]['static_page_title'];
			$construct_array[0]['content_item_content'] = $sync[0]['static_page_content'];
			$data['content_data_primary'][0] = array(
					'content_title' => $construct_array[0]['content_item_title'],
					'content_type' => "",
					'content_item_sponsor_url' => "",
					'content_item_id' => 0

			);

			$data['content_data_image'][0] = array (
					'content_item_image_url' => $sync1[0]['static_page_image_url']
				);

			$data['content_data_sponsor'] = 0;

			$data['content_data_content'][0] = array(
				'content_item_tab_content' =>  $construct_array[0]['content_item_content'],
				'content_item_tab_id' => $sync[0]['static_page_id'],
				'content_item_tab_title' => $sync[0]['static_page_title'],
			);

			$data['tabbed'] = 0;
		}
		else
		{
			$data['content_data_primary'] = $this->mainmodel->getcontentitemtabsbycontentitemid($generalurl);
			$data['content_data_image'] = $this->mainmodel->getcontentitemimagebycontentitemid($generalurl);
			$data['content_data_sponsor'] = $this->mainmodel->getcontentitemsponsorbycontentitemid($generalurl);
			$data['content_data_content'] = $this->mainmodel->getcontentitemtabdatabycontentitemid($generalurl);

			if(trim($data['content_data_primary'][0]['content_type']) == "tabbed")
				$data['tabbed'] = 1;
			else
				$data['tabbed'] = 0;
		}

		$data['sidebar'] = 3;
		if($generalurl == "hospitality")
		{
			$data['sidebar'] = 4;
		}

		

		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);			
			$this->load->view('_template/basic/section-start');
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-page-holder',$data);
			$this->load->view('content/content-sidebar-navigation',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}
	}

	public function profile($username=null)
	{
		$data['title'] = "Profile | Kurukshetra 2014 | The Battle of Brains";
		$data['profile_complete'] = 0;

		$data['system_type'] = 'special';
		$data['updates'] = $this->mainmodel->getupdates();
		$data['nav0'] = 0;
		$data['nav1'] = 0;
		$data['nav2'] = 0;
		$data['nav3'] = 0;
		$data['nav4'] = 0;
		$data['nav5'] = 0;
		$data['nav6'] = 0;
		$data['nav7'] = 0;


        $data['colleges'] = $this->mainmodel->getlistofcollege();
        $data['degrees'] = $this->mainmodel->getlistofdegree();
        $data['courses'] = $this->mainmodel->getlistofcourse();

        $data['logged_in'] = 0;
        $data['saclaim'] = 0;

		if($this->bitauth->logged_in())
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
        	$ret=$this->session->all_userdata();
        	$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        	$data['log']=$logged_details;
        	// echo '<pre>';
        	// print_r($data['log']);
        	// echo '</pre>';
        	////////////////////////////////////////END OF SESSION DETAILS
        	$data['logged_in'] = 1;

        	$username = $logged_details->kid;
        	$profilename = $logged_details->profilename;
        	if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        	{
        		$data['profile_complete'] = 1;
        	}

        	$data['saclaim'] = $this->mainmodel->checkclaimsastatus($logged_details->kid);
		}
		else
		{
			show_404();
		}

		if($username)
		{

		}
		else
		{
			show_404();
		}

		$data['sidebar'] = 2;
		
		if (isset($_SERVER["HTTP_X_PJAX"])) {
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');			
			$this->load->view('content/content-profile-page',$data);
			$this->load->view('_template/basic/section-end');
		} else {
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/container-start');
			$this->load->view('_template/basic/header');
			$this->load->view('_template/basic/pjax-start');
			$this->load->view('_template/basic/navigation',$data);
			$this->load->view('_template/basic/section-start');
			//$this->load->view('_template/basic/main',$data);
			$this->load->view('content/content-profile-page',$data);
			$this->load->view('_template/basic/section-end');
			$this->load->view('_template/basic/container-end');
			$this->load->view('_template/basic/pjax-end');
			$this->load->view('_template/basic/footer');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
		}

	}

	public function k_attachment()
	{
		$response = "";

		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('error' => "<p>Not Logged In</p>" ));
		}
		else
		{
			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
	        $ret=$this->session->all_userdata();
	        $logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
	        $data['log']=$logged_details;
	        // echo '<pre>';
	        // print_r($data['log']);
	        // echo '</pre>';
	        ////////////////////////////////////////END OF SESSION DETAILS
	        $data['logged_in'] = 1;

	        $username = $logged_details->kid;
	        $profilename = $logged_details->profilename;

			if($this->input->post())
			{
				if($logged_details->fullname != null || $logged_details->gender != null || $logged_details->semester != null || $logged_details->degree != null || $logged_details->course != null || $logged_details->institution != null || $logged_details->contactno != null)
				{
					$data['checkifexists'] = $this->mainmodel->checkattachmentexistsforuserid();

					if($data['checkifexists'])
					{
						$response = array('status' => 1, 'response' => array('error' => "<p>You have already registered for this event</p>" ));
					}
					else
					{
						$data['pushattachment'] = $this->mainmodel->pushattachmentsubscription();
						$response = array('status' => 2, 'response' => array('success' => "<p>Thank you for registering</p>" ));				
					}
				}
				else
				{
					$response = array('status' => 3, 'response' => array('error' => "<p>Profile not complete</p>" ) );
				}
			}

    	}

		echo json_encode($response);
	}

	public function k_workshop_attachment()
	{
		$response = "";

		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('error' => "<p>Not Logged In</p>" ));
		}
		else
		{

			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
	        $ret=$this->session->all_userdata();
	        $logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
	        $data['log']=$logged_details;
	        // echo '<pre>';
	        // print_r($data['log']);
	        // echo '</pre>';
	        ////////////////////////////////////////END OF SESSION DETAILS
	        $data['logged_in'] = 1;

	        $username = $logged_details->kid;
	        $profilename = $logged_details->profilename;

			if($this->input->post())
			{
				if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        		{
					$data['checkifexists'] = $this->mainmodel->checkworkshopattachmentexistsforuserid();


					if($data['checkifexists'])
					{
						$response = array('status' => 1, 'response' => array('error' => "<p>You have already registered for this event</p>" ));
					}
					else
					{
						$data['pushattachment'] = $this->mainmodel->pushworkshopattachmentsubscription();
						$response = array('status' => 2, 'response' => array('success' => "<p>Your response has been recorded. Please wait for approval from the workshop team.</p>" ));				
					}
				}
				else
				{
					$response = array('status' => 3, 'response' => array('error' => "<p>Profile not complete</p>" ) );
				}

			}
		}

		echo json_encode($response);
	}

	public function k_team_workshop_attachment()
	{
		$response = "";

		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('error' => "<p>Not Logged In</p>" ));
		}
		else
		{

			// $this->session->set_userdata('redir', current_url());
			// redirect('auth/login');
			///////////////////////////////////////////////SESSION DETAILS
	        $ret=$this->session->all_userdata();
	        $logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
	        $data['log']=$logged_details;
	        // echo '<pre>';
	        // print_r($data['log']);
	        // echo '</pre>';
	        ////////////////////////////////////////END OF SESSION DETAILS
	        $data['logged_in'] = 1;

	        $username = $logged_details->kid;
	        $profilename = $logged_details->profilename;

			if($this->input->post())
			{
				
				if(trim(strtolower($this->input->post('workshopurl'))) == "facebot" || trim(strtolower($this->input->post('workshopurl'))) == "bluebot")
				{
					if($this->input->post('kid2') == "" || $this->input->post('kid3') == "")
					{
						$response = array('status' => 4, 'response' => array('error' => "<p>Minimum Participation of 3 in a team for 3D Printing</p>" ));
					}
				}
				else if(trim(strtolower($this->input->post('workshopurl'))) == "c2000")
				{
					if($this->input->post('kid2') == "")
					{
						$response = array('status' => 5, 'response' => array('error' => "<p>Minimum Participation of 2 in a team for C2000</p>" ));
					}
				}
				
				if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
        		{
					$data['checkifexists'] = $this->mainmodel->checkteamworkshopattachmentexistsforuserid();

					if($data['checkifexists'])
					{
						$response = array('status' => 1, 'response' => array('error' => "<p>You have already registered for this event</p>" ));
					}
					else
					{
						$data['pushattachment'] = $this->mainmodel->pushteamworkshopattachmentsubscription();
						$response = array('status' => 2, 'response' => array('success' => "<p>Your response has been recorded. Please wait for approval from the workshop team.</p>" ));				
					}
				}
				else
				{
					$response = array('status' => 3, 'response' => array('error' => "<p>Profile not complete</p>" ) );
				}

			}
		}

		echo json_encode($response);
	}

	public function k_college_list()
	{

		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('error' => "<p>Not Logged In</p>" ));
		}

		if($this->input->get())
		{
			$data['list'] = $this->mainmodel->getlistofcollege();
		}

		
		echo json_encode($data['list']);
	}


	public function k_course_list()
	{
		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('error' => "<p>Not Logged In</p>" ));
		}

		$data['list'] = $this->mainmodel->getlistofcourse();
		echo json_encode($data['list']);
	}

	public function k_degree_list()
	{
		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('error' => "<p>Not Logged In</p>" ));
		}

		$data['list'] = $this->mainmodel->getlistofdegree();
		echo json_encode($data['list']);
	}

	public function k_profile_update()
	{
		$response = "";

		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('message' => "<p>Not Logged In</p>"));
		}

		if($this->input->post())
		{
			if($this->mainmodel->updateprofile())
			{
				$response = array('status' => 1, 'response' => array('message' => "<p>Profile has been updated successfully</p>"));
			}
			else
			{
				$response = array('status' => 2, 'response' => array('message' => "<p>Profile has not updated</p>"));
			}
		}

		echo json_encode($response);
	}

	public function k_sa_register()
	{
		$response = "";

		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('message' => "<p>Not Logged In</p>"));
		}

		if($this->input->post())
		{
			if($this->mainmodel->claimsa())
			{
				$response = array('status' => 1, 'response' => array('message' => "<p>Successfully Registered for SA</p>"));
			}
			else
			{
				$response = array('status' => 2, 'response' => array('message' => "<p>Failed to register for SA</p>"));
			}
		}

		echo json_encode($response);
	}

	public function k_get_ambassador()
	{
		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('message' => "<p>Not Logged In</p>"));
		}

		if($this->input->post())
		{
			$data['stuamb'] = $this->mainmodel->getstudentambassadorbycollegename();
			$this->load->view('content/content-student-ambassador',$data);
		}
	}

	public function k_hospitality_register()
	{
		if(!$this->bitauth->logged_in())
		{
			$response = array('status' => 0, 'response' => array('message' => "<p>Not Logged In</p>"));
		}

		if($this->input->post())
		{
			if($this->mainmodel->claimhospi())
			{
				if($this->mainmodel->sendhospimail())
					$response = array('status' => 1, 'response' => array('message' => "<p>Successfully Registered for Hospitality</p>"));
			}
			else
			{
				$response = array('status' => 2, 'response' => array('message' => "<p>Failed to register for Hospitality</p>"));
			}
		}

		echo json_encode($response);
	}
	public function ros_register()
	{
		if($this->bitauth->logged_in())
				{
					
					$ret=$this->session->all_userdata();
					
					$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
					
					if($this->rosmodel->addrosuser($logged_details->kid))
						echo "Registered";
					else
						echo "already";
				}
		else	
			{	
				echo "return to k site and register";
			}
	}
	public function ros($url)
	{
		
		if($this->bitauth->logged_in())
		{
			$ret=$this->session->all_userdata();
			$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
			if($this->rosmodel->checkregistration($logged_details->kid))
					{

						$level=$this->rosmodel->getLevel($logged_details->kid); //getting level from db
						$urllevel=$this->rosmodel->getLevelByUrl($url);
						if(strcmp($urllevel,$level)==0)
						{
							echo "hi";
							$img= $this->rosmodel->getimagesequence($level);
							foreach($img as $seq)
							echo $seq.'<br>';

						}
						else
						{
								echo "No cheating";
						}
					}
			else
					$this->ros_register();
		}
		else
		{
			echo "register";
		}
		
		
		
		
	}
}
