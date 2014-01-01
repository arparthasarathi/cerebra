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
		
}
