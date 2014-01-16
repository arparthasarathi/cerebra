<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class auth extends CI_Controller
{

	/**
	 * auth::__construct()
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('bitauth');

		$this->load->helper('form');
		$this->load->helper('url');

		$this->load->library('form_validation');
		$this->db = $this->load->database('default',TRUE);
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}

	/**
	 * auth::convert()
	 *
	 */
	public function convert()
	{
		$this->load->dbforge();
		$this->dbforge->modify_column($this->bitauth->_table['groups'], array(
			'roles' => array(
				'name' => 'roles',
				'type' => 'text'
			)
		));

		$query = $this->db->select('group_id, roles')->get($this->bitauth->_table['groups']);
		if($query && $query->num_rows())
		{
			foreach($query->result() as $row)
			{
				$this->db->where('group_id', $row->group_id)->set('roles', $this->bitauth->convert($row->roles))->update($this->bitauth->_table['groups']);
			}
		}

		echo 'Update complete.';
	}

	/**
	 * auth::login()
	 *
	 */
	public function login()
	{
		$data = array();

		if($this->input->post())
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('remember_me','Remember Me','');

			if($this->form_validation->run() == TRUE)
			{
				// Login
				if($this->bitauth->login($this->input->post('username'), $this->input->post('password'), $this->input->post('remember_me')))
				{
					// Redirect
					if($redir = $this->session->userdata('redir'))
					{
						$this->session->unset_userdata('redir');
					}

					redirect($redir ? $redir : 'auth');
				}
				else
				{
					$data['error'] = $this->bitauth->get_error();
				}
			}
			else
			{
				$data['error'] = validation_errors();
			}
		}

		$this->load->view('auth/login', $data);
	}

	/**
	 * auth::index()
	 *
	 */
	public function index()
	{
		if( ! $this->bitauth->logged_in())
		{
			$this->session->set_userdata('redir', current_url());
			redirect('auth/login');
		}

		$this->load->view('auth/users', array('bitauth' => $this->bitauth, 'users' => $this->bitauth->get_users()));
	}

	/**
	* auth::register()
	*
	*/
	public function register()
	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|bitauth_unique_username');
			$this->form_validation->set_rules('fullname', 'Fullname', '');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|bitauth_valid_password');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|matches[password]');

			if($this->form_validation->run() == TRUE)
			{
				unset($_POST['submit'], $_POST['password_conf']);
				$this->bitauth->add_user($this->input->post());
				redirect('auth/login');
			}

		}

		$this->load->view('auth/add_user', array('title' => 'Register'));
	}

	/**
	* auth::add_user()
	*
	*/
	public function add_user()
	{
		if( ! $this->bitauth->logged_in())
		{
			$this->session->set_userdata('redir', current_url());
			redirect('auth/login');
		}

		if ( ! $this->bitauth->has_role('admin'))
		{
			$this->load->view('auth/no_access');
			return;
		}

		if($this->input->post())
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|bitauth_unique_username');
			$this->form_validation->set_rules('fullname', 'Fullname', '');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|bitauth_valid_password');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|matches[password]');

			if($this->form_validation->run() == TRUE)
			{
				unset($_POST['submit'], $_POST['password_conf']);
				$this->bitauth->add_user($this->input->post());
				redirect('auth');
			}

		}

		$this->load->view('auth/add_user', array('title' => 'Add User', 'bitauth' => $this->bitauth));
	}


	/**
	* auth::edit_user()
	*
	*/
	public function edit_user($user_id)
	{
		if( ! $this->bitauth->logged_in())
		{
			$this->session->set_userdata('redir', current_url());
			redirect('auth/login');
		}

		if ( ! $this->bitauth->has_role('admin'))
		{
			$this->load->view('auth/no_access');
			return;
		}

		if($this->input->post())
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|bitauth_unique_username['.$user_id.']');
			$this->form_validation->set_rules('fullname', 'Fullname', '');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('active', 'Active', '');
			$this->form_validation->set_rules('enabled', 'Enabled', '');
			$this->form_validation->set_rules('password_never_expires', 'Password Never Expires', '');
			$this->form_validation->set_rules('groups[]', 'Groups', '');

			if($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', 'Password', 'bitauth_valid_password');
				$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|matches[password]');
			}

			if($this->form_validation->run() == TRUE)
			{
				unset($_POST['submit'], $_POST['password_conf']);
				$this->bitauth->update_user($user_id, $this->input->post());
				redirect('auth');
			}

		}

		$groups = array();
		foreach($this->bitauth->get_groups() as $_group)
		{
			$groups[$_group->group_id] = $_group->name;
		}


		$this->load->view('auth/edit_user', array('bitauth' => $this->bitauth, 'groups' => $groups, 'user' => $this->bitauth->get_user_by_id($user_id)));
	}

	/**
	 * auth::groups()
	 *
	 */
	public function groups()
	{
		if( ! $this->bitauth->logged_in())
		{
			$this->session->set_userdata('redir', current_url());
			redirect('auth/login');
		}

		$this->load->view('auth/groups', array('bitauth' => $this->bitauth, 'groups' => $this->bitauth->get_groups()));
	}

	/**
	 * auth::add_group()
	 *
	 */
	public function add_group()
	{
		if( ! $this->bitauth->logged_in())
		{
			$this->session->set_userdata('redir', current_url());
			redirect('auth/login');
		}

		if ( ! $this->bitauth->has_role('admin'))
		{
			$this->load->view('auth/no_access');
			return;
		}

		if($this->input->post())
		{
			$this->form_validation->set_rules('name', 'Group Name', 'trim|required|bitauth_unique_group');
			$this->form_validation->set_rules('description', 'Description', '');
			$this->form_validation->set_rules('members[]', 'Members', '');
			$this->form_validation->set_rules('roles[]', 'Roles', '');

			if($this->form_validation->run() == TRUE)
			{
				unset($_POST['submit']);
				$this->bitauth->add_group($this->input->post());
				redirect('auth/groups');
			}

		}

		$users = array();
		foreach($this->bitauth->get_users() as $_user)
		{
			$users[$_user->user_id] = $_user->fullname;
		}

		$this->load->view('auth/add_group', array('bitauth' => $this->bitauth, 'roles' => $this->bitauth->get_roles(), 'users' => $users));
	}

	/**
	 * auth:edit_group()
	 *
	 */
	public function edit_group($group_id)
	{
		if( ! $this->bitauth->logged_in())
		{
			$this->session->set_userdata('redir', current_url());
			redirect('auth/login');
		}

		if ( ! $this->bitauth->has_role('admin'))
		{
			$this->load->view('auth/no_access');
			return;
		}

		if($this->input->post())
		{
			$this->form_validation->set_rules('name', 'Group Name', 'trim|required|bitauth_unique_group['.$group_id.']');
			$this->form_validation->set_rules('description', 'Description', '');
			$this->form_validation->set_rules('members[]', 'Members', '');
			$this->form_validation->set_rules('roles[]', 'Roles', '');

			if($this->form_validation->run() == TRUE)
			{
				unset($_POST['submit']);
				$this->bitauth->update_group($group_id, $this->input->post());
				redirect('auth/groups');
			}

		}

		$users = array();
		foreach($this->bitauth->get_users() as $_user)
		{
			$users[$_user->user_id] = $_user->fullname;
		}

		$group = $this->bitauth->get_group_by_id($group_id);

		$role_list = array();
		$roles = $this->bitauth->get_roles();
		foreach($roles as $_slug => $_desc)
		{
			if($this->bitauth->has_role($_slug, $group->roles))
			{
				$role_list[] = $_slug;
			}
		}

		$this->load->view('auth/edit_group', array('bitauth' => $this->bitauth, 'roles' => $roles, 'group' => $group, 'group_roles' => $role_list, 'users' => $users));
	}

	/**
	 * auth::activate()
	 *
	 */
	 public function activate($activation_code)
	 {
	 	if($this->bitauth->activate($activation_code))
	 	{
	 		$this->load->view('auth/activation_successful');
	 		return;
	 	}

	 	$this->load->view('auth/activation_failed');
	 }

	/**
	 * auth::logout()
	 *
	 */
	public function logout()
	{
		$this->bitauth->logout();
		redirect('auth');
	}


	public function k_register()
	{
		$response = "";
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[bitauth_userdata.email]|is_unique[bitauth_users.username]');
			$this->form_validation->set_message('is_unique',"Already registered");
			$this->form_validation->set_message('required',"Fields required cannot be left blank");
			$this->form_validation->set_rules('password','Password','trim|required|min_length[6]');
			$this->form_validation->set_rules('spassword','Confirmation Password','trim|required|matches[password]|min_length[6]');
		
			if($this->form_validation->run() == TRUE)
			{
				$trackemail = explode('@', set_value('email'));
				$userdata = array(
                	'email'=> set_value('email'),
                	'username'=> set_value('email'),
                	'profilename' => $trackemail[0],
                	'password'=> set_value('password'),
                	'kid' => 'k'.substr(sha1(set_value('email')),5,6)
                );

                $response = array('status' => 1,'response' =>$this->bitauth->add_user($userdata));
				
			}
			else
			{
				$response = array('status' => 0,'response' => validation_errors());
			}
		}

		echo json_encode($response);
	}

	public function k_login()
	{
		$data = array();
		$response = "";

		if($this->input->post())
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('remember_me','Remember Me','');

			if($this->form_validation->run() == TRUE)
			{
				if($content = $this->bitauth->login($this->input->post('username'), $this->input->post('password'), $this->input->post('remember_me')))
				{
					$ret=$this->session->all_userdata();
       	 			$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        			$data['log']=$logged_details;
					$response = array('status' => 1, 'response' => $logged_details);
						//$this->session->unset_userdata('redir');
				}
				else
				{
				$response = array('status' => 2, 'response' =>  $this->bitauth->get_error());
				}
			}
			else
			{
				$response = array('status' => 0, 'response' => validation_errors());
				$data['error'] = validation_errors();
		//		$this->load->view('login');
			}
		}
		
		json_encode($response);

		//echo $response;
		
	}

	public function k_logout()
	{
		$data = array();
		$response = "";

		if($this->input->post())
		{
			if($this->input->post('logout_prototype'))
			{
				$this->bitauth->logout();
				$response = array('status' => 1, 'response' => "Logout Successful");
			}
		}
		echo json_encode($response);
		
	}

	public function k_fb()
	{
		$data = array();
		$response = "";

		if($this->input->post())
		{
			$trackemail = explode('@', $this->input->post('email'));

			$userdata = array(
                'email'=> $this->input->post('email'),
                'username'=> $this->input->post('email'),
                'profilename' => $trackemail[0],
                'password'=> "facebook",
                'kid' => 'k'.substr(sha1($this->input->post('email')),5,6)
            );

            $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[bitauth_userdata.email]|is_unique[bitauth_users.username]');

            if($this->form_validation->run() == TRUE)
			{
				$this->bitauth->add_user($userdata);
				if($content = $this->bitauth->login($this->input->post('username'), $userdata['password'], $this->input->post('remember_me')))
				{
					$ret=$this->session->all_userdata();
       	 			$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        			$data['log']=$logged_details;
					$response = array('status' => 1,'response' => $logged_details);
				}
				else
				{
					$response = array('status' => 2, 'response' =>  $this->bitauth->get_error());
				}
			}
			else
			{
				if($content = $this->bitauth->login($this->input->post('username'), $userdata['password'], $this->input->post('remember_me')))
				{
					$ret=$this->session->all_userdata();
       	 			$logged_details=$this->bitauth->get_user_by_id($ret['ba_user_id']);
        			$data['log']=$logged_details;
					$response = array('status' => 1,'response' => $logged_details);
				}
				else
				{
					$response = array('status' => 2, 'response' =>  $this->bitauth->get_error());
				}
			}
			
		}
		echo json_encode($response);
	}

	public function k_forgot_password()
	{
		if($this->input->get())
		{
			$userdata = array(
				'username' => $this->input->get('email') 
			);

		}

		print_r($userdata['username']);

		//echo $this->bitauth->get_user_by_username($userdata['username']);
	}

	
}