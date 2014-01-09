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
		$this->load->model('rosmodel');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		
		$this->db = $this->load->database('default',TRUE);
//		$this->cms_db = $this->load->database('cms',TRUE);
		
	}

	public function index()
	{
		
		//$data['title'] = "Kurukshetra 2014 | The Battle of Brains";
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

		//$data['galleries'] = $this->mainmodel->getgalleries();
		$data['updates'] = 0;
		//$data['static_page'] = $this->mainmodel->getstaticpagetabsbystaticpageid($data['system_type']);
		//$data['static_page_image'] = $this->mainmodel->getstaticpageimagebystaticpageid($data['system_type']);

        //$data['colleges'] = $this->mainmodel->getlistofcollege();
        //$data['degrees'] = $this->mainmodel->getlistofdegree();
        //$data['courses'] = $this->mainmodel->getlistofcourse();

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
			$data['title']="ROS";
			$data['welcome']="Welcome to ROS";
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/basic/ros_meta');
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/ros_navigation',$data);
			$this->load->view('_template/basic/roswelcome',$data);
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
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
	public function ros($url=null)
	{

			if($this->bitauth->logged_in())
			{


			$ret=$this->session->all_userdata();
			$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
			if($logged_details->fullname != null && $logged_details->gender != null && $logged_details->semester != null && $logged_details->degree != null && $logged_details->course != null && $logged_details->institution != null && $logged_details->contactno != null)
			{
				if($logged_details->name!=NULL && $logged_details->coll) $logged_details->kid;
				$level=$this->rosmodel->getLevel($logged_details->kid);
				echo "Inside";
				
				$this->loadLevel($level);

			}
			else
				{
					$data['profile']=0;
					redirect('ros.kurkushetra.org.in',$data);				
				}

	}
	else
	{
		redirect('www.kurkushetra.org.in/ros');
	}
}

	public function submit()
	{
		
		if($this->bitauth->logged_in())
		{
			
			
			$data['logged_in']=1;
			$ret=$this->session->all_userdata();
			$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
			$data['log'] =$logged_details;
			$answer=$this->rosmodel->getanswer($this->input->post('level'));
			
			if(strcmp(strtolower($this->input->post('answer')),$answer)==0)
				{
							
        			$this->rosmodel->promote($this->input->post('level'), $logged_details->kid);
					$this->ros('some');
           		}
			
			else
			{

			$me=rand(5, 15);
			$data['img']='meme'.$me.'.jpg';;
			$data['title']="ROS";
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/basic/ros_meta');
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/ros_navigation',$data);
			$this->load->view('_template/basic/roswelcome',$data);
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
			}
		}
		else
		{
			redirect(base_url());
		}

}
		
	
	public function ros_level($url=null)
	{
		
		if($this->bitauth->logged_in())
		{
		$ret=$this->session->all_userdata();
		$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
		$data['log']=$logged_details;

		
				
				$level=$this->rosmodel->getLevel($logged_details->kid);
				$data['level']=$level;
				switch($level)
				{
				case 1:$data['level']=1;
						$data['img']=array('luigisbrother.jpg');
						$data['pageclue']="The boot shaped country will help you find your way";
						break;
				case 2:$data['level']=2;
						$data['img']=array('insidethe.jpg');
						$data['pageclue']="Who is the dean?";
						break;
				case 3:$data['level']=3;
						$data['img']=array('samenames.jpg');
						$data['pageclue']="The first name is the last name and vice versa";
						break;
				case 4:$data['level']=4;
						$data['img']=array('irespanol.jpg');
						$data['pageclue']="Mod: You know sometimes it is difficult to make every thing required into clues :p";
						break;
				case 5:$data['level']=5; 
						$data['img']=array('part1.jpg', 'part2.jpg');
						$data['pageclue']="Another name";
						break;
				case 6:$data['level']=6;
						$data['img']=array('character.jpg');
						$data['pageclue']="";
						break;
				case 7:$data['level']=7;
						$data['img']=array('rebus.jpg');
						$data['pageclue']="Something Similar";
						break;
				case 8:$data['level']=8;
						$data['img']=array('founder.jpg');
						$data['pageclue']="9617 , 9618 , 9619 , 9620 , 9621 , 9622";
						break;
				case 9:$data['level']=9;
						$data['img']=array('afdsfdaf.jpg','sdfsadfasf.jpg','dfsdfsdf.jpg');
						$data['pageclue']="";
						break;		
				case 10:$data['level']=10;	
						$data['img']=array('asfdsfsafdas.gif','asdfasfsdfsaf.jpg');
						$data['pageclue']="";
						break;
				case 11:if(strcmp($url,'whatami.php')==0)
						{
						$data['level']=11;
						$data['img']=array('sdfadsafssqw.jpg');
						$data['pageclue']="";
						}
						elseif((strcmp($url,'auroraborealis.php')==0)||strcmp($url, 'auroraborealis')==0)
						{
						$data['level']=11;
						$data['img']=array('sadfspodfk');
						$data['pageclue']="";
						}
						break;
				case 12:$data['level']=12;
						$data['img']=array('sadfsldf.jpg','mnbxcv.jpg','asdfsdf.jpg','jasdfk.jpg');
						$data['pageclue']="";
						break;
				case 13:$data['level']=13;
						$data['img']=array('sketch.jpg');
						$data['pageclue']="The ark of art";
						break;
				case 14:$data['level']=14;
						$data['img']=array('zxcmvncxnmv.jpg','dyghdhd.png');
						$data['pageclue']="A picture is worth thousand words";
						break;
				case 15:$data['level']=15;
						
						$data['pageclue']="The Sphinx says: Now let me tell you a story. Of all the mystical Japanese clans of the ancient age, none was more feared than Badhum clan. From this clan was born a the most powerful necromancer of all, named Yon . A conjurer of spirits , he was able to summon an army of a million white spirits to fight by his side , fending of all any enemy that dare attack his clan. But one day suddenly his magic went terribly wrong and his white spirits go rogue and start attacking their own master , killing him and wiping out his entire clan. Thus the story being said, find out what went wrong and you may pass." ;
						break;
				case 16:$data['level']=16;
						$data['img']=array('anim.gif');
						$data['pageclue']="Oracles of doomsday 2012";
						break;
				case 17:if(strcmp('level17.php',$url)==0)
						{
						$data['level']=17;
						$data['img']=array('qweadfx.jpg','oerkjfkmxc.jpg');
						$data['pageclue']="what is it??";
						}
						elseif (strcmp('ocarina.php', $url)==0) {
								$data['level']=17;
						$data['img']=array('dfkjsalf.jpg','nbxcmvbs.jpg');
						$data['pageclue']="";
						}
						break;
				case 18:$data['level']=18;
						$data['img']=array('gsdgsdfgsd.jpg');
						$data['pageclue']="";
						break;
				case 19:$data['level']=19;
						$data['img']=array('dsfgerwqwe.jpg');
						$data['pageclue']="273.6";
						break;
				case 20:$data['level']=20;
						$data['img']=array('000080.jpg','ffff00.jpg');
						$data['pageclue']="Treasure";
						break;
				case 21:$data['level']=21;
						$data['img']=array('odfjokwel.jpg');
						$data['pageclue']="Who does he travel with?";
						break; 
				case 22:if(strcmp($url,'level22.php')==0)
						{
						$data['level']=22;
						$data['img']=array('safasfeww.jpg');
						$data['pageclue']="Extremely Specific";
						}
						elseif(strcmp($url,'namcobandai.php')==0)
						{
							$data['level']=22;
						$data['img']=array('adfasdfwe.jpg');
						$data['pageclue']="";
						}
						break; 
				case 23:$data['level']=23;
						$data['img']=array('sowepas.jpg');
						$data['pageclue']="RIP";
						break;
				case 24:$data['level']=24;
						$data['img']=array('sdpweiuoqm.jpg');
						$data['pageclue']="";
						break;
				case 25:$data['level']=25;
						$data['img']=array('fp.jpg','flare.jpg','m.jpg');
						$data['pageclue']="uti hfaa plpgufzkmau gop hksyanlpml oqlhsfzkm";
						break;
				case 26:$data['level']=26;
						$data['img']=array('car.jpg');
						$data['pageclue']="Man's deliberate malice answers seedy interest...What does he believe in though?";
						break;
				case 27:$data['level']=27;
						$data['img']=array('somepeople.jpg');
						$data['pageclue']="What happened in amity 9 years back? 13 years later, What was An dre fussing about";
						break;
				case 28:$data['level']=28;
						$data['img']=array('xmnbcdsf.jpg');
						$data['pageclue']="GR BRX PHDQ VOHHS RYHU? RN... EXW L JHW WR EH RQ WRS.";
						break;
				case 29:$data['level']=29;
						$data['img']=array('adfawoefsd.jpg','vfsdfwe.jpg','!.jpg');
						$data['pageclue']="Side Effects";
						break;		
				case 30:$data['level']=30;
						$data['img']=array('connect.jpg');
						$data['pageclue']="";
						break;		
				case 31:if(strcmp($url,'son.php')==0)
						{
						$data['level']=31;
						$data['img']=array('mother.jpg','father.jpg');
						$data['pageclue']="";
						}
						elseif (strcmp($url, 'sphinx.php')==0) {
						$data['img']=array('callmemaybe.jpg','new.jpg');
						$data['pageclue']="";
						}
						break;	
				case 32:if(strcmp($url, 'kerge.php')==0)
						{$data['level']=32;
						$data['img']=array('1.gif','1a.jpg','1b.jpg','1c.png');
						$data['pageclue']="";}
						elseif(strcmp($url, 'mountolympus.php')==0)
						{
							$data['img']=array('slayer.jpg','move.jpg');
						$data['pageclue']="";	
						}
						break;
				case 33:$data['level']=33;
						$data['img']=array('asdfqpeqwe.jpg','asdfasdf.jpg');
						$data['pageclue']="Sixteen";
						break;
				case 34:$data['level']=34;
						
						$data['pageclue']="wsvapsfieshllqtbgrq";
						break;
				case 35:$data['level']=35;
						$data['img']=array('adxczv.jpg','dqowelzds.jpg','hitler.jpg');
						$data['pageclue']="My Master";
						break;
				case 36:$data['level']=36;
						$data['img']=array('sport.jpg','cartoon.jpg','animechar.jpg');
						$data['pageclue']="";
						break;
				case 37:if(strcmp($url, 'level37.php')==0)
						{
							$data['img']=array('nagato.jpg');
						$data['pageclue']="The First I";
						}
						elseif (strcmp($url,'hagoromootsutsuki.php')==0) 
						{
						$data['level']=37;
						$data['img']=array('6HVSN5.jpg');
						$data['pageclue']="You already know the key";
						}
						break;
			case 38:if(strcmp('name.php',$url)==0)
					{
						$data['img']=array('whoami.jpg');
						$data['pageclue']="";
					}
					elseif (strcmp('tonystark.php',$url)==0) {
						$data['img']=array('sadpqeww.jpg');
						$data['pageclue']="Take the odd one out first";
					}
					break;
			case 39:$data['level']=39;
						$data['img']=array('hehelia.gif','birdie.jpg','made.jpg');
						$data['pageclue']="";
						break;
			case 40:if(strcmp($url,'improvise.php')==0)
					{
						$data['level']=40;
						$data['img']=array('singin.jpg');
						$data['pageclue']="To my other favorite W.W";
					}
					elseif (strcmp('aclockworkorange.php',$url)==0) {
						$data['img']=array('noclueshere.jpg');
						$data['pageclue']="Power Rangers";
						
					}
					elseif (strcmp($url, 'leavesofgrass.php')==0) {
						$data['level']=40;
						$data['img']=array('whose.jpg');
						$data['pageclue']="Please sir, I want some more";
					}
						break;
				case 41:$data['level']=41;
						$data['img']=array('guy1.jpg','guy2.jpg','guy3.jpg','guy4.jpg');
						$data['pageclue']="";
						break;						
				case 42:$data['level']=42;
						$data['img']=array('barcode.png');
						$data['pageclue']="";
						break;
				case 43:$data['level']=43;
						$data['img']=array('success.jpg');
						$data['succesnote']="Congrats ".$logged_details->kid." tuned for the Main run";
						break;
				}
				
				$data['logged_in']=1;		
			
			
			$data['title']="ROS";
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/basic/ros_meta');
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/ros_navigation',$data);
			$this->load->view('questions',$data);
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
			
			
			
		}
		else
		{
			redirect(base_url());
		}

	}
	public function loadLevel($level)
	{
		if($this->bitauth->logged_in())
		{
		$ret=$this->session->all_userdata();
		$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
		echo $logged_details->fullname;
		$level=$this->rosmodel->getLevel($logged_details->kid,$logged_details->fullname);
		//$level=$this->rosmodel->getLevel($logged_details->kid);
		switch($level)
			{
				case 1:$data['level']=1;
						$data['urlclue']='henchmen.php';
						break;
				case 2:$data['level']=2;
						$data['urlclue']='copresidents.php';
						break;
				case 3:$data['urlclue']='level3.php';
						break;
				case 4:$data['urlclue']='movie.php';
						break;
				case 5:$data['urlclue']='rebus.php';
						break;
				case 6:$data['urlclue']='level6.php';
						break;
				case 7:$data['urlclue']='myth.php';
						break;
				case 8:$data['urlclue']='UMTASHEA.php';
						break;
				case 9:$data['urlclue']='number.php';
						break;
				case 10:$data['urlclue']='7891.php';
						break;
				case 11:$data['urlclue']='level11.php';
						break;
				case 12:$data['urlclue']='12.php';
						break;	
				case 13:$data['urlclue']='animals.php';
						break;
				case 14:$data['urlclue']='level14.php';
						break;
				case 15:$data['urlclue']='smokingkills.php';
						break;
				case 16:$data['urlclue']='flight.php';
						break;
				case 17:$data['urlclue']='level17.php';
						break;
				case 17:$data['urlclue']='ocarina.php';
						break;
				case 18:$data['urlclue']='type.php';
						break;
				case 19:$data['urlclue']='level19.php';
						break;
				case 20:$data['urlclue']='level20.php';
						break;
				case 21:$data['urlclue']='level21.php';
						break;
				case 22:$data['urlclue']='level22.php';
						break;
				case 23:$data['urlclue']='thefourthone.php';
						break;
				case 24:$data['urlclue']='level24.php';
						break;
				case 25:$data['urlclue']='level25.php';
						break;	
				case 26:$data['urlclue']='bonsoir.php';
						break;
				case 27:$data['urlclue']='thinkthink.php';
						break;
				case 28:$data['urlclue']='level28.php';
						break;
				case 29:$data['urlclue']='level29.php';
						break;
				case 30:$data['urlclue']='ajoyant.php';
						break;
				case 31:$data['urlclue']='son.php';
						break;		
				case 32:$data['urlclue']='kerge.php';
						break;
				
				case 33:$data['urlclue']='level33.php';
						break;	
				case 34:$data['urlclue']='qkzmt.php';
						break;		
				case 35:$data['urlclue']='level35.php';
						break;
				case 36:$data['urlclue']='director.php';
						break;
				case 37:$data['urlclue']='level37.php';
						break;
				
				case 38:$data['urlclue']='name.php';
						break;
				case 39:$data['urlclue']='level39.php';
						break;
				case 40:$data['urlclue']='improvise.php';
						break;
				case 41:$data['urlclue']='level41.php';
						break;
				case 42:$data['urlclue']='thisistheend.php';
						break;
				case 43:$data['urlclue']='lastlevel.php';
						break;

			}
		
			$url=base_url().'ros_level/'.$data['urlclue'];
			redirect($url);
		}
		else
			redirect(base_url());

	}
	public function instruction()
	{
			$data['logged_in']=0;
			$data['title']="ROS|INSTRUCTION";
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/basic/ros_meta');
			$this->load->view('_template/head/styles');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/title',$data);
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-end');
			$this->load->view('_template/head/body-start');
			$this->load->view('_template/basic/ros_navigation',$data);
			$this->load->view('_template/basic/ros_rules');
			$this->load->view('_template/head/body-end');
			$this->load->view('_template/head/html-end');
			
			
	}
	public function comments()
	{
			if($this->bitauth->logged_in())
			{
			$data['logged_in']=1;
			$ret=$this->session->all_userdata();
			$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
			$data['log']=$logged_details;
			$data['title']="ROS";
			$level=$this->rosmodel->getLevel($logged_details->kid);	
			$data['level']=$level;
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/basic/ros_meta');
			$this->load->view('_template/head/styles');
			$this->load->view('_template/basic/ros_navigation',$data);
			$this->load->view('_template/basic/ros_comments.php',$data);
			}
			else
				{
					redirect(base_url());
				}
	}
	public function leaderboard()
	{
		
		
		$result=$this->db->query('SELECT kid,level,name,college from ros_main ORDER BY level DESC,timestamp ASC LIMIT 0,15');

		if($this->bitauth->logged_in())
		{
			$data['logged_in']=1;
			$ret=$this->session->all_userdata();
			$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
			$data['log']=$logged_details;
			$data['count']= $this->db->count_all('ros_main');
			$rank=1;
			$user_id=$this->db->query('SELECT * from ros_main ORDER BY level DESC,timestamp ASC');
			//echo $count;
			foreach($user_id->result() as $detail)
				{
					//echo strcmp($logged_details->kid,$detail->kid);
					if(strcmp($logged_details->kid,$detail->kid)!=0)
						{
							$rank=$rank+1;
						}
				else
					break;
				}
			$data['rank']=$rank;
			$data['id']=$result->result();
			$this->load->view('_template/head/doctype');
			$this->load->view('_template/head/html-start');
			$this->load->view('_template/head/scripts');
			$this->load->view('_template/head/head-start');
			$this->load->view('_template/head/meta-tags');
			$data['title']="ROS";
			$this->load->view('_template/head/styles');
			$this->load->view('_template/basic/ros_navigation',$data);
			$this->load->view('_template/basic/leader',$data);
		}
		else
			redirect(base_url());
	}

}	
