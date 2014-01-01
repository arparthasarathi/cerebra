<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mainmodel extends CI_Model {

    private $default_db;
    private $cms_db;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('string');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        
        $this->db = $this->load->database('default',TRUE);
        $this->cms_db = $this->load->database('cms',TRUE);
    }

    public function getcontentsubcategories($category)
    {
        $this->cms_db->distinct();
        $this->cms_db->select('content_subcategory');
        $this->cms_db->from('content_item');
        $this->cms_db->where('content_category',$category);
        $this->cms_db->where('content_subcategory !=',"special");
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getcontentitembysubcategories($content_name,$content_category)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('content_item');
        $this->cms_db->where('content_subcategory',$content_name);
        $this->cms_db->where('content_category',$content_category);
        $this->cms_db->where('content_category !=',"special");
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;

    }

    public function getspecialcontentsubcategories($category)
    {
        $this->cms_db->distinct();
        $this->cms_db->select('content_subcategory');
        $this->cms_db->from('content_item');
        $this->cms_db->where('content_category',$category);
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getspecialcontentitembysubcategories($content_name,$content_category)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('content_item');
        $this->cms_db->where('content_subcategory',$content_name);
        $this->cms_db->where('content_category',$content_category);
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;

    }

    public function getcontenttabbycontentitemid($content_item_id)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('content_item_tab');
        $this->cms_db->where('content_item_id',$content_item_id);
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getstaticpagetabsbystaticpageid($url)
    {
        $content = array(
                'static_page_url' => $url
            );

        $this->cms_db->select('*');
        $this->cms_db->from('static_pages');
       // $this->cms_db->join('static_page_image','static_page_image.static_page_id=static_pages.static_page_id');
        $this->cms_db->where('static_pages.static_page_url',$content['static_page_url']);

        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getstaticpageimagebystaticpageid($url)
    {
        $content = array(
                'static_page_url' => $url
            );

        $this->cms_db->select('*');
        $this->cms_db->from('static_pages');
        $this->cms_db->join('static_page_image','static_page_image.static_page_id=static_pages.static_page_id');
        $this->cms_db->where('static_pages.static_page_url',$content['static_page_url']);

        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getcontentitemtabsbycontentitemid($url)
    {
        $content = array(
                'content_url' => $url
            );

        $this->cms_db->select('*');
        $this->cms_db->from('content_item');
        //$this->cms_db->join('content_item_image','content_item_image.content_item_id=content_item.content_item_id');
        //$this->cms_db->join('content_item_sponsor','content_item_sponsor.content_item_id=content_item.content_item_id');
        $this->cms_db->where('content_item.content_url',$content['content_url']);

        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getcontentitemimagebycontentitemid($url)
    {
        $content = array(
                'content_url' => $url
            );

        $this->cms_db->select('*');
        $this->cms_db->from('content_item');
        $this->cms_db->join('content_item_image','content_item_image.content_item_id=content_item.content_item_id');
        //$this->cms_db->join('content_item_sponsor','content_item_sponsor.content_item_id=content_item.content_item_id');
        $this->cms_db->where('content_item.content_url',$content['content_url']);

        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getcontentitemsponsorbycontentitemid($url)
    {
        $content = array(
                'content_url' => $url
            );

        $this->cms_db->select('*');
        $this->cms_db->from('content_item');
        //$this->cms_db->join('content_item_image','content_item_image.content_item_id=content_item.content_item_id');
        $this->cms_db->join('content_item_sponsor','content_item_sponsor.content_item_id=content_item.content_item_id');
        $this->cms_db->where('content_item.content_url',$content['content_url']);

        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }



    public function getcontentitemtabdatabycontentitemid($url)
    {
         $content = array(
                'content_url' => $url
            );

        $this->cms_db->select('content_item_tab.*');
        $this->cms_db->from('content_item');
        $this->cms_db->join('content_item_tab','content_item_tab.content_item_id=content_item.content_item_id');
        $this->cms_db->where('content_item.content_url',$content['content_url']);

        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;   
    }

    public function sponsorsyear()
    {
        $this->cms_db->distinct();
        $this->cms_db->select('sponsor_year');
        $this->cms_db->from('sponsor_item');
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function sponsorcategory($sponsor_year)
    {
        $this->cms_db->distinct();
        $this->cms_db->select('sponsor_category');
        $this->cms_db->from('sponsor_item');
        $this->cms_db->where('sponsor_year',$sponsor_year);
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getsponsorbysponsorcategory($sponsor_category,$sponsor_year)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('sponsor_item');
        $this->cms_db->join('sponsor_item_image','sponsor_item_image.sponsor_item_id = sponsor_item.sponsor_id');
        $this->cms_db->where('sponsor_category',$sponsor_category);
        $this->cms_db->where('sponsor_year',$sponsor_year);

        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getgalleries()
    {
        $this->cms_db->select('*');
        $this->cms_db->from('gallery_image');
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getupdates()
    {
        $this->cms_db->select('*');
        $this->cms_db->from('updates');
        $query = $this->cms_db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;
    }

    public function getdistinctabouturl()
    {
        $this->cms_db->distinct();
        $this->cms_db->select('*');
        $this->cms_db->from('about_item');

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function getaboutbyabouturl($abouturl)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('about_item');
        $this->cms_db->where('about_url',$abouturl);

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function getdistinctxceedurl()
    {
        $this->cms_db->distinct();
        $this->cms_db->select('*');
        $this->cms_db->from('xceed');

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function getxceedbyxceedurl($xceedurl)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('xceed');
        $this->cms_db->where('xceed_url',$xceedurl);

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function getdistincthospitalityurl()
    {
        $this->cms_db->distinct();
        $this->cms_db->select('*');
        $this->cms_db->from('hospitality');

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function gethospitalitybyhospitalityurl($hospitalityurl)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('hospitality');
        $this->cms_db->where('hospitality_url',$hospitalityurl);

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function getdistinctkarnivalurl()
    {
        $this->cms_db->distinct();
        $this->cms_db->select('*');
        $this->cms_db->from('karnival');

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function getkarnivalbykarnivalurl($karnivalurl)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('karnival');
        $this->cms_db->where('karnival_url',$karnivalurl);

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function getdistinctcontacturl()
    {
        $this->cms_db->distinct();
        $this->cms_db->select('team');
        $this->cms_db->from('cms_userdata');
        $this->cms_db->where('team !=',"admin");
        $this->cms_db->where('team !=', "");

        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;
    }

    public function getcontactbycontacturl($contacturl)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('cms_userdata');
        $this->cms_db->where('team',$contacturl);
        $this->cms_db->where('team !=',"admin");
        $this->cms_db->where('team !=', "");
        
        $query = $this->cms_db->get();
        if($query->num_rows())
            return $query->result_array();
        else
            return 0;

    }

    public function getlimitedcontacts()
    {
        $this->cms_db->distinct();
        $this->cms_db->select('team');
        $this->cms_db->from('cms_userdata');
        $this->cms_db->where('team',"events");
        $this->cms_db->or_where('team',"workshops");
        $this->cms_db->or_where('team',"qms");
        $this->cms_db->or_where('team',"lectures");
        $this->cms_db->or_where('team',"xceed");
        $this->cms_db->or_where('team',"ir");
        $this->cms_db->or_where('team',"hospitality");
        $this->cms_db->or_where('team',"media");
        $this->cms_db->or_where('team',"events");
        $this->cms_db->or_where('team',"tech");        
        $this->cms_db->or_where('team',"web");        
        $this->cms_db->or_where('team',"karnival");       
        $this->cms_db->or_where('team',"marketing");

        $query = $this->cms_db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }

    public function getlimitedcontactscontent()
    {
        $this->cms_db->select('*');
        $this->cms_db->from('cms_userdata');
        $this->cms_db->where('team',"events");
        $this->cms_db->or_where('team',"workshops");
        $this->cms_db->or_where('team',"lectures");
        $this->cms_db->or_where('team',"xceed");
        $this->cms_db->or_where('team',"ir");
        $this->cms_db->or_where('team',"hospitality");
        $this->cms_db->or_where('team',"media");
        $this->cms_db->or_where('team',"events");
        $this->cms_db->or_where('team',"tech");        
        $this->cms_db->or_where('team',"web");        
        $this->cms_db->or_where('team',"karnival");       
        $this->cms_db->or_where('team',"marketing");

        $query = $this->cms_db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }

    public function getbyoneeachteam($teamname)
    {
        $this->cms_db->select('*');
        $this->cms_db->from('cms_userdata');
        $this->cms_db->where('team', $teamname);
        $this->cms_db->limit(1);
        $query = $this->cms_db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }

    public function checkattachmentsubscription($content_item_id,$kid)
    {
        $content  = array(
            'registration_attachment_id' => $content_item_id,
            'registration_user_id' => $kid
        );

        $this->db->from('user_registration');
        $this->db->where('registration_attachment_id',$content['registration_attachment_id']);
        $this->db->where('registration_user_id',$content['registration_user_id']);
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;

    }

    public function checkworkshopattachmentsubscription($attachmentid,$kid)
    {
        $content  = array(
            'attachmentid' => $attachmentid,
            'kid' => $kid
        );

        //print_r($content);

        $this->db->select('*');
        $this->db->from('workshop_registration');
        $this->db->where('attachmentid',$content['attachmentid']);
        $this->db->where('kid',$content['kid']);
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;

    }

    public function checkteamworkshopattachmentsubscription($attachmentid,$kid)
    {
        $content  = array(
            'attachmentid' => $attachmentid,
            'kid' => $kid
        );

        $this->db->select('*');
        $this->db->from('team_formation');
        $this->db->join('team_registration','team_registration.team_id = team_formation.teamid');
        $this->db->where('team_formation.kid',$content['kid']);
        $this->db->where('team_registration.attachment_id',$content['attachmentid']);
        $check = $this->db->get();

        if($check->num_rows() > 0)
        {
            $sync = $check->result_array();
            

            $this->db->select('*');
            $this->db->from('workshop_registration');
            $this->db->where('attachmentid',$content['attachmentid']);
            $this->db->where('kid',$sync[0]['team_id']);

            $query = $this->db->get();

            if($query->num_rows() > 0)
                return $query->result_array();
            else
                return 0;

        }
        else
            return 0;
    }


    public function checkattachmentexistsforuserid()
    {
        $content  = array(
            'registration_attachment_id' => $this->input->post('content-item-id'),
            'registration_user_id' => $this->input->post('logged-in-status') 
        );

        $this->db->from('user_registration');
        $this->db->where('registration_attachment_id',$content['registration_attachment_id']);
        $this->db->where('registration_user_id',$content['registration_user_id']);
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;

    }

    public function pushattachmentsubscription()
    {
        $content  = array(
            'registration_id' => 'REGISTRATION-'.random_string('alnum',4),
            'registration_attachment_id' => $this->input->post('content-item-id'),
            'registration_user_id' => $this->input->post('logged-in-status') 
        );

        $query = $this->db->insert('user_registration',$content);

        if($query)
            return 1;
        else
            return 0;

    }

    public function checkworkshopattachmentexistsforuserid()
    {
        $content  = array(
            'attachmentid' => $this->input->post('attachment-id'),
            'kid' => $this->input->post('logged-in-status') 
        );

        $this->db->select('*');
        $this->db->from('workshop_registration');
        $this->db->where('attachmentid',$content['attachmentid']);
        $this->db->where('kid',$content['kid']);
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result_array();
        else
            return 0;

    }

    public function checkteamworkshopattachmentexistsforuserid()
    {
        $content  = array(
            'attachmentid' => $this->input->post('attachment-id'),
            'kid' => $this->input->post('logged-in-status') 
        );

        $this->db->select('*');
        $this->db->from('team_formation');
        $this->db->join('team_registration','team_registration.team_id = team_formation.teamid');
        $this->db->where('team_formation.kid',$content['kid']);
        $this->db->where('team_registration.attachment_id',$content['attachmentid']);
        $check = $this->db->get();

        if($check->num_rows() > 0)
        {
            $sync = $check->result_array();

            $this->db->select('*');
            $this->db->from('workshop_registration');
            $this->db->where('attachmentid',$content['attachmentid']);
            $this->db->where('kid',$sync[0]['team_id']);

            $query = $this->db->get();

            if($query->num_rows() > 0)
                return $query->result_array();
            else
                return 0;

        }
        else
            return 0;
    }


    public function pushworkshopattachmentsubscription()
    {
        $content  = array(
            'workshopregid' => 'WORKSHOP-REGISTRATION-'.random_string('alnum',4),
            'attachmentid' => $this->input->post('attachment-id'),
            'kid' => $this->input->post('logged-in-status'),
            'response1' => $this->input->post('response1'),
            'response2' => $this->input->post('response2'),
            'response3' => $this->input->post('response3'),
            'response4' => $this->input->post('response4'),
            'response5' => $this->input->post('response5'),
            'responsestatus' => 0
        );

        $query = $this->db->insert('workshop_registration',$content);

        if($query)
            return 1;
        else
            return 0;

    }

    public function pushteamworkshopattachmentsubscription()
    {
        $teamid = 'WORKSHOP-TEAM-REGISTRATION-'.random_string('alnum',4);

        $content1 = array(
            'team_id' => $teamid,
            'attachment_id' => $this->input->post('attachment-id')
        );

        if($this->input->post('kid1'))
        {
            $content2 = array(
                'tfid' => 'TEAM-FORMATION-'.random_string('alnum',4), 
                'teamid' => $teamid,
                'kid' => $this->input->post('kid1')
            );
            $query2 = $this->db->insert('team_formation',$content2);
        }

        if($this->input->post('kid2'))
        {
            $content3 = array(
                'tfid' => 'TEAM-FORMATION-'.random_string('alnum',4), 
                'teamid' => $teamid,
                'kid' => $this->input->post('kid2')
            );
            $query3 = $this->db->insert('team_formation',$content3);
        }

        if($this->input->post('kid3'))
        {
            $content4 = array(
                'tfid' => 'TEAM-FORMATION-'.random_string('alnum',4), 
                'teamid' => $teamid,
                'kid' => $this->input->post('kid3')
            );
            $query4 = $this->db->insert('team_formation',$content4);
        }

        if($this->input->post('kid4'))
        {
            $content5 = array(
                'tfid' => 'TEAM-FORMATION-'.random_string('alnum',4), 
                'teamid' => $teamid,
                'kid' => $this->input->post('kid4')
            );
            $query5 = $this->db->insert('team_formation',$content5);
        }

       

        $content6  = array(
            'workshopregid' => 'WORKSHOP-REGISTRATION-'.random_string('alnum',4),
            'attachmentid' => $this->input->post('attachment-id'),
            'kid' => $teamid,
            'response1' => $this->input->post('response1'),
            'response2' => $this->input->post('response2'),
            'response3' => $this->input->post('response3'),
            'response4' => $this->input->post('response4'),
            'response5' => $this->input->post('response5'),
            'responsestatus' => 0
        );

        $query1 = $this->db->insert('team_registration',$content1);
        $query6 = $this->db->insert('workshop_registration',$content6);

        if($query1 && $query2 && $query3 && $query4 || $query5 && $query6)
            return 1;
        else
            return 0;

    }


    public function getlistofcollege()
    {
        $this->db->select('*');
        $this->db->from('college_list');

        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }

    public function getlistofcourse()
    {
        $this->db->select('*');
        $this->db->from('course_list');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }

    public function getlistofdegree()
    {
        $this->db->select('*');
        $this->db->from('degree_list');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }

    public function updateprofile()
    {
        $content = array(
            'kid' => $this->input->post('kid'),
            'fullname' => $this->input->post('fullname'),
            'institution' => $this->input->post('institution'),
            'degree' => $this->input->post('degree'),
            'course' => $this->input->post('course'),
            'contactno' => $this->input->post('contactnumber'),
            'type' => $this->input->post('type'),
            'semester' => $this->input->post('semester'), 
            'gender' => $this->input->post('gender')
        );

        $this->db->where('kid',$content['kid']);
        $query = $this->db->update('bitauth_userdata',$content);

        if($query)
            return 1;
        else
            return 0;
    }

    public function claimsa()
    {
        $content = array(
            'stuambid' => "STUDENT-AMBASSADOR-".random_string('alnum',4),
            'kid' => $this->input->post('logged-in-status'), 
            'response1' => $this->input->post('saresponse1'),
            'response2' => $this->input->post('saresponse2'),
            'response3' => $this->input->post('saresponse3'),
            'response4' => $this->input->post('saresponse4'),
            'status' => "pending",
            'cmsstatus' => 1
        );


        $query = $this->db->insert('stuambreg',$content);

        if($query)
            return 1;
        else
            return 0;
    }

    public function checkclaimsastatus($kid)
    {
        $this->db->select('*');
        $this->db->from('stuambreg');
        $this->db->where('kid',$kid);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }

    public function getstudentambassadorbycollegename()
    {
        $content = array(
            'institution' => $this->input->post('institution'),
            'ambassadorflag' => 1
        );

        $this->db->select('*');
        $this->db->from('bitauth_userdata');
        $this->db->where('institution',$content['institution']);
        $this->db->where('ambassadorflag',$content['ambassadorflag']);

        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;

    }

    public function claimhospi()
    {
        $content = array(
            'kid' => $this->input->post('kid'),
            'hospitalityid' => 'HOSPITALITY-'.random_string('alnum',4),
            'arrivaldate' => $this->input->post('arrivaldate'),
            'arrivalmean' => $this->input->post('arrivalmedian'),
            'arrivaltime' => $this->input->post('arrivaltime'),
            'departuredate' => $this->input->post('departuredate'), 
            'departuremean' => $this->input->post('departuremedian'),
            'departuretime' => $this->input->post('departuretime'),
            'city' => $this->input->post('city'),
            'responsestatus' => 1
        );

        $query = $this->db->insert('hospitality',$content);
        if($query)
            return 1;
        else 
            return 0;

    }

    public function checkhospiexists($kid)
    {
        $this->db->select('*');
        $this->db->from('hospitality');
        $this->db->where('kid',$kid);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return 0;
    }

    public function sendhospimail()
    {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'noreply@kurukshetra.org.in', // change it to yours
            'smtp_pass' => 'scott_tiger', // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        $this->db->select('*');
        $this->db->from('bitauth_userdata');
        $this->db->where('kid',$this->input->post('kid'));
        $query = $this->db->get();

        if($query)
        {
            $result = $query->result_array();
            $message = '';
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('noreply@kurukshetra.org.in','Kurukshetra 2014' );
            $this->email->to($result[0]['email']);
            $this->email->subject('Kurukshetra 2014 - Hospitality Registration');
            $this->email->message($this->load->view('emails/hospi', $result, true ));
            if($this->email->send())
            {
                //echo $this->email->print_debugger();die;
                return 1;
            }
            else
                return 0;
        }

        
    }
}

?>