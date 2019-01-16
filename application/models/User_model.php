<?php 
	class user_model extends CI_Model
	{
		
		public function __construct()
		{
			if ($this->input->cookie('hash') && !$this->session->userdata('logged_in')) {
				$hash = $this->input->cookie('hash');
				$this->db->where('hash', $hash);
				$query = $this->db->get('users_session');
				$hashCheck = $query->row_array();
				print_r($hashCheck);

				if (count($hashCheck)) {

					// pobranie danych usera jesli jest taki hash
					$this->db->where('id', $hashCheck['user_id']);
					$query = $this->db->get('users');
					$result = $query->row_array();
					// sprawdzenie czy jest administratorem
					$admin = $result['admin'];

					// Create ssession
					$user_data = array(
						'user_id' => $result['id'],
						'username' => $result['username'],
						'admin' => $result['admin'],
						'logged_in' => true
					);
					$this->session->set_userdata($user_data);
					redirect('');
				}
			}
		}

		public function register($enc_password)
		{
			$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'password' => $enc_password,
				'watch_users_id' => 'a:0:{}'
			);

			return $this->db->insert('users', $data);
		}

		public function login($username, $password)
		{
			$this->db->where('username', $username);
			$this->db->where('password', $password);

			$result = $this->db->get('users');

			if ($result->num_rows() == 1) {
				return $result->row(0)->id;
			} else {
				return false;
			}
		}

		public function userUpdate($password, $email)
		{
			$data = array(
				'password' => $password,
				'email' => $email
			);
			$this->db->where('id', $this->session->userdata('user_id'));
			$this->db->update('users', $data);
		}

		public function admin($user_id)
		{
			$this->db->where('id', $user_id);

			$result = $this->db->get('users');
			
			if ($result->num_rows() == 1) {
				return $result->row(0)->admin;
			} else {
				return false;
			}

		}

		public function allUsers()
		{
			
			$result = $this->db->get('users');
			return $result->result_array();

		}

		public function uniqueEmail($email)
		{
			$this->db->where('email', $email);
			$query = $this->db->get('users');
			$result = count($query->result_array());
			return $result;

		}

		public function obserwowaniID($user_id)
		{
			$this->db->where('id', $user_id);
			$result = $this->db->get('users');
			return unserialize($result->row_array()['watch_users_id']);
		}


		public function obserwowaniUsername($user_id)
		{

			$id_users = $this->obserwowaniID($user_id);

			foreach ($id_users as $row) {
				$this->db->where('id', $row);
				$result = $this->db->get('users');

				$username[] = $result->row_array()['username'];
			}
			return $username;

		}

		public function watchUsersDefault($user_id)
		{

			$this->db->where('id', $user_id);
			$result = $this->db->get('users');
			return $result->row_array()['watch_users_default'];

		}

		public function getUsername($user_id)
		{
			$this->db->where('id', $user_id);
			$result = $this->db->get('users');
			return $result->row_array()['username'];
		}

		public function getUserEmail($user_id)
		{
			$this->db->where('id', $user_id);
			$result = $this->db->get('users');
			return $result->row_array()['email'];
		}

		public function get_pokazuj_innych($user_id)
		{
			$this->db->where('id', $user_id);
			$result = $this->db->get('users');
			return $result->row_array()['watch_users_default'];
		}

		public function setOffObserwowani($user_id)
		{
			$data = array('watch_users_default' => 0);
			$this->db->where('id', $user_id);
			$result = $this->db->update('users', $data);
			return $result;
		}


	}