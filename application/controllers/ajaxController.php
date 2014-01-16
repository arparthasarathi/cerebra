<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxController extends CI_Controller {

	
	function check_ans()
	{
		if($this->input->is_ajax_request())
		{
			$q=$this->input->post('q');
			$a=$this->input->post('a');
			   
			$this->load->model('rosmodel');
			list($x,$y,$z,$level)=$this->rosmodel->check_ans($q,$a);
			$a=array('result' => $x,'points' => $y,'attempts' => $z,'level'=>$level);
			echo json_encode($a);
		}
	}
}