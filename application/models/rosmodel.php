<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Rosmodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		{
			$this->load->database();
			$this->load->helper('url');


		}
	}
	public function addrosuser($kid)
	{
		echo $kid;
		$data = array('kid' => $kid);
		$query = $this->db->query("SELECT kid FROM ros_user where kid='$kid'");
		
		if($query->result())
			return 0;
		else {
			$this->db->insert('ros_user',$data);
			unset($data);
			$data = array('' => $kid,'level'=>1);
			$this->db->insert('ros_user_stat',$data);
			return 1;			
		}
		
			
	}
		
	
	public function checkregistration($kid)
	{
		$query=$this->db->query("SELECT kid FROM ros_user_stat where kid='$kid'");
		if($query->result())
			return 1;
	}
	public function getLevel($kid)
	{
		
		$query = $this->db->query("SELECT level FROM ros_user_stat WHERE kid='$kid'");
		foreach ($query->result() as $row)
		  	  		return  $row->level;
		 
		   	
    }
    public function getLevelByUrl($kid)
	{
		
		$url=array('0','connect.php','alter_ego.php');
		if(in_array($kid, $url))
			return array_search($kid, $url);

	}
		
	public function getimagesequence($level)
	{
		$marks = array( 
		"level1" => array("img1" => '1.jpg',"img2" => '2.jpg',"img3" => '3.jpg'),
		"level2" => array("img1" => '101.jpg',"img2" => '102.jpg',"img3" => '103.jpg'),
         "zara" => array("physics" => 31,"maths" => 22,"chemistry" => 39)
                );
		return $marks["level".$level];
	}
	public function ros_answer_judge()
	{
		
	}
}
