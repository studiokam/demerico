<?php 

class Users extends CI_Controller
{
	
	public function register()
	{
		$data['title'] = 'Rejestracja';

		// walidacja formularza rejestracji
		// nick
		$this->form_validation->set_rules('username', 'Nick', 
			'required|min_length[2]|max_length[30]|is_unique[users.username]',
	        array(
	                'required'      => 'Podaj %s.',
	                'is_unique'     => 'Taki %s już jest.',
	                'min_length'    => '%s - min. 2 znaki.',
	                'max_length'    => '%s - max. 30 znaków.'
	        )
		);
		// email 
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]', array('required' => 'Podaj %s.', 'is_unique' => 'Taki %s już jest. Podaj inny.'));
		// hasła
		$this->form_validation->set_rules('password', 'Hasło', 'required', array('required' => '%s jest wymagane.'));
		$this->form_validation->set_rules('password2', 'Ponowne hasło', 'required|matches[password]', array('required' => '%s jest wymagane.', 'matches' => 'Hasła nie sa jednakowe'));

		if ($this->form_validation->run() === FALSE) 
		{
			$this->load->view('templates/header', $data);
			$this->load->view('users/register', $data);
			$this->load->view('templates/footer');
		} 
		else
		{
			// hashowanie hasła (bez soli)
			$enc_password = md5($this->input->post('password'));

			// dodanie usera do db
			$this->user_model->register($enc_password);

			// wiadomość o udanej rejestracji
			$this->session->set_flashdata('success', 'Rejestracja przebiegła pomyślnie, możesz się zalogować');

			redirect('users/login');
		}

	}

	public function login()
	{
		$data['title'] = 'Logowanie';
		
		// walidacja
		$this->form_validation->set_rules('username', 'Nick', 'required', array('required' => '%s jest wymagany.'));
		$this->form_validation->set_rules('password', 'Hasło', 'required', array('required' => '%s jest wymagane.'));
		if ($this->form_validation->run() === FALSE) 
		{
			$this->load->view('templates/header', $data);
			$this->load->view('users/login', $data);
			$this->load->view('templates/footer');
		} else {
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			$user_id = $this->user_model->login($username, $password);

			if ($user_id) {

				// sprawdzenie czy jest administratorem
				$admin = $this->user_model->admin($user_id);

				// Create ssession
				$user_data = array(
					'user_id' => $user_id,
					'username' => $username,
					'admin' => $admin,
					'logged_in' => true
				);
				$this->session->set_userdata($user_data);

				$rand = random_string('sha1');
				$cookie = array(
                    'name'   => 'hash',
                    'value'  => $rand,                            
                    'expire' => '51622400',                                                                                   
                    // 'secure' => TRUE
                );
                $this->input->set_cookie($cookie);


                $data = array(
                	'user_id' => $user_id,
                	'hash' => $rand
                );
                $this->db->insert('users_session', $data);

				// Set message
				$this->session->set_flashdata('success', 'Poprawnie zalogowano.');
				redirect('terminarz');

			} else {
				
				// Set message
				$this->session->set_flashdata('error', 'Nie można zalogować na takie dane.');

				$this->load->view('templates/header', $data);
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function logout()
	{
		
		$array_items = array('user_id', 'username', 'logged_in', 'admin', 'inni');
		$this->session->unset_userdata($array_items);
		$hash = $this->input->cookie('hash');
		$this->db->where('hash', $hash);
		$this->db->delete('users_session');
		delete_cookie('hash');

		redirect('');
	}

	
}