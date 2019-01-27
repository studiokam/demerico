<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function view($page = 'home')
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}

		$data['title'] = ucfirst($page.' - typer');

		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
	}

	public function terminarz()
	{
		$data['title'] 							=	 'Terminarz';
		$data['grupy'] 							=	 $this->terminarz_model->get_grupy();
		$data['aktywne_mecze'] 					=	 $this->terminarz_model->get_aktywne_mecze();
		$data['pokazuj_innych'] 				=	 $this->user_model->get_pokazuj_innych($this->session->userdata('user_id'));
		$data['aktywne_mecze_wyniki_usera'] 	=	 $this->terminarz_model->get_wyniki_usera($data['aktywne_mecze']);
		$data['obserwowani_ilsc'] 				=	 count($this->user_model->obserwowaniID($this->session->userdata('user_id')));
		$data['watch_users_default'] 			=	 $this->user_model->watchUsersDefault($this->session->userdata('user_id'));

		if ($data['pokazuj_innych'] > 0) {
			$users_id = $this->user_model->obserwowaniID($this->session->userdata('user_id'));
			$data['aktywne_mecze_wyniki_obserwowanych'] = $this->terminarz_model->get_wyniki_obserwowanych($data['aktywne_mecze'], $users_id);
		}
// echo "<pre>";
		// print_r($data['aktywne_mecze_wyniki_obserwowanych']);


		// ustawienie pokazywania innych
		if (isset($_GET['inni'])) {
			
			// jesli nie ma oznaczonych osób to nie pozwala włczyć domyslnego pokazywania wyników innych osób
			if ($data['obserwowani_ilsc'] < 1) {
				// wiadomość o braku wybranych userow do obserwowania
				$this->session->set_flashdata('danger', 'Nie można włczyć wyświetlania wyników innych osób - wybierz przynajmniej jedną i wtedy włcz pokazywanie');
				Redirect('konto');
			}

			// update obserwowanych
			$data = array(
		        'watch_users_default' => $_GET['inni'],
			);

			$this->db->where('id', $this->session->userdata('user_id'));
			$this->db->update('users', $data);
			Redirect('terminarz');
		}

		// walidacja
		if (!empty($_POST)) {
			$this->terminarz_model->replace_wynik($_POST);
			
			// Set message
			$this->session->set_flashdata('success', 'Zapisano wyniki');
			redirect('terminarz');
		}
			
		$this->load->view('templates/header', $data);
		$this->load->view('pages/terminarz', $data);
		$this->load->view('templates/footer');
		
	}

	public function moje()
	{
		$data['title'] 							=	 'Moje typy';
		$data['grupy'] 							=	 $this->terminarz_model->get_grupy();

		$this->load->view('templates/header', $data);
		$this->load->view('pages/moje', $data);
		$this->load->view('templates/footer');
		
	}


	public function grupa($id_grupy)
	{
		$data['title'] 					= 	'Grupa';
		$data['id'] 					= 	$id_grupy;
		$data['zalogowany'] 			= 	$this->session->userdata('logged_in');
		$data['mecze_z_grupy'] 			= 	$this->terminarz_model->mecze_z_grupy($id_grupy, $this->session->userdata('user_id'));
		$data['podsumowanie'] 			= 	$this->terminarz_model->podsumowanie($id_grupy);
		$data['watch_users_default'] 	= 	$this->user_model->watchUsersDefault($this->session->userdata('user_id'));
		$data['inni_wyniki'] 			= 	$this->terminarz_model->inni($id_grupy, $this->session->userdata('logged_in'));
		$data['obserwowani_ilsc'] 		= 	count($this->user_model->obserwowaniID($this->session->userdata('user_id')));
		$data['pokazuj_innych'] 		= 	$this->user_model->get_pokazuj_innych($this->session->userdata('user_id'));

		if ($data['pokazuj_innych'] > 0) {
			$users_id = $this->user_model->obserwowaniID($this->session->userdata('user_id'));
			$data['aktywne_mecze_wyniki_obserwowanych'] = $this->terminarz_model->get_wyniki_obserwowanych($data['mecze_z_grupy'], $users_id);
		}
		

		// ustawienie pokazywania innych
		if (isset($_GET['inni'])) {
			
			// jesli nie ma oznaczonych osób to nie pozwala włczyć domyslnego pokazywania wyników innych osób
			if ($data['obserwowani_ilsc'] < 1) {
				// wiadomość o braku wybranych userow do obserwowania
				$this->session->set_flashdata('danger', 'Nie można włczyć wyświetlania wyników innych osób - wybierz przynajmniej jedną i wtedy włącz pokazywanie');
				Redirect('konto');
			}

			// update obserwowanych
			$data = array(
		        'watch_users_default' => $_GET['inni'],
			);

			$this->db->where('id', $this->session->userdata('user_id'));
			$this->db->update('users', $data);
			Redirect('grupa/'.$id_grupy);
		}

		if (empty($data['podsumowanie'])) {
			$data['typy_usera'] = '';
		} else {
			$data['typy_usera'] 	= 	$this->terminarz_model->typy_usera($id_grupy,$data['podsumowanie'][0]['user_id']);
		}
// echo "<pre>";
		// print_r($data['typy_usera']);
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/grupa', $data);
		$this->load->view('templates/footer');
		
	}

	public function konto()
	{
		if (!$this->session->userdata('logged_in')) {
			Redirect('/');
		}

		$data['pokazuj_innych'] = $this->user_model->get_pokazuj_innych($this->session->userdata('user_id'));
		$data['obserwowani_ilsc'] = count($this->user_model->obserwowaniID($this->session->userdata('user_id')));
		$data['email'] = $this->user_model->getUserEmail($this->session->userdata('user_id'));
		

		if ($data['obserwowani_ilsc'] > 0) {
			$data['obserwowani'] = $this->user_model->obserwowaniUsername($this->session->userdata('user_id'));
		}

		$data['title'] = 'Konto';

		if (isset($_GET['default'])) {
			
			// jesli nie ma oznaczonych osób to nie pozwala włczyć domyslnego pokazywania wyników innych osób
			if ($data['obserwowani_ilsc'] < 1) {
				// wiadomość o braku wybranych userow do obserwowania
				$this->session->set_flashdata('danger', 'Nie można włczyć wyświetlania wyników innych osób - wybierz przynajmniej jedną i wtedy włcz pokazywanie');
				Redirect('konto');
			}

			// update obserwowanych
			$data = array(
		        'watch_users_default' => $_GET['default'],
			);

			$this->db->where('id', $this->session->userdata('user_id'));
			$this->db->update('users', $data);
			Redirect('konto');
		}

		// email
		$this->form_validation->set_rules('email', 'Email', 'callback_email_self_check');
		// hasła
		$this->form_validation->set_rules('password', 'Hasło', 'required', array('required' => '%s jest wymagane.'));
		$this->form_validation->set_rules('password2', 'Ponowne hasło', 'required|matches[password]', array('required' => '%s jest wymagane.', 'matches' => 'Hasła nie sa jednakowe'));

		if ($this->form_validation->run() === FALSE) 
		{
			$this->load->view('templates/header', $data);
			$this->load->view('pages/konto', $data);
			$this->load->view('templates/footer');
		} 
		else
		{
			// hashowanie hasła (bez soli)
			$enc_password = md5($this->input->post('password'));

			// update usera
			$this->user_model->userUpdate($enc_password, $this->input->post('email'));

			// wiadomość o udanej rejestracji
			$this->session->set_flashdata('success', 'Zapisano poprawnie');

			redirect('konto');
		}
	}


	// sprawdzenie czy jest juz w db taki email ale pomija email usera (do update danych)
	public function email_self_check($str)
    {
        $obecny_email = $this->user_model->getUserEmail($this->session->userdata('user_id'));
  
        if ($str == $obecny_email)
        {
                return TRUE;
        }
        else
        {
	         	$unique = $this->user_model->uniqueEmail($str);
	            if (!$unique) {
	            	
	            	return TRUE;

	            } 
	            else 
	            {
	            	$this->form_validation->set_message('email_self_check', 'Jest już taki email, podaj inny');
	            	return FALSE;
	            }
        }
    }


	public function users_list()
	{
		
		if (!$this->session->userdata('logged_in')) {
			Redirect('/');
		}

		$data['title'] = 'Users';
		$data['users'] = $this->user_model->allUsers();
		$data['obserwowani'] = $this->user_model->obserwowaniID($this->session->userdata('user_id'));
		$data['pokazuj_innych'] = $this->user_model->get_pokazuj_innych($this->session->userdata('user_id'));

		$oberwowani_arr = $data['obserwowani'];

		if (count($oberwowani_arr) < 1 && $data['pokazuj_innych'] > 0) {
			$this->user_model->setOffObserwowani($this->session->userdata('user_id'));
			Redirect('users_list');
		}

		// print_r($oberwowani_arr);
		if (isset($_GET['id'])) {

			if (in_array($_GET['id'], $oberwowani_arr)) {
				$oberwowani_arr = array_diff($oberwowani_arr, array((int)$_GET['id']));
			} else {
				$oberwowani_arr[] = (int)$_GET['id'];
			}
			
			// update obserwowanych
			$data = array(
		        'watch_users_id' => serialize($oberwowani_arr),
			);

			$this->db->where('id', $this->session->userdata('user_id'));
			$this->db->update('users', $data);
			Redirect('users_list');
		}

		$this->load->view('templates/header', $data);
		$this->load->view('pages/users_list', $data);
		$this->load->view('templates/footer');
	}


	public function typy($id_grupy, $user_id)
	{
		$data['title'] 			= 	'Typy';
		$data['id_grupy'] 		=	$this->uri->segment(2);
		$data['user_id'] 		= 	$this->uri->segment(3);
		$data['username'] 		= 	$this->user_model->getUsername($this->uri->segment(3));
		$data['mecze_z_grupy'] 	= 	$this->terminarz_model->mecze_z_grupy($id_grupy, $this->uri->segment(3));

		$this->load->view('templates/header', $data);
		$this->load->view('pages/typy', $data);
		$this->load->view('templates/footer');
	}


	public function ranking()
	{
		$grupy = $this->ranking_model->idWszystkichGrup();

		foreach ($grupy as $row) {
			$this->mecze_model->update_grupy_spotkan($row);
		}

		// echo "<pre>";


		$data['title'] 				= 	'Ranking';
		$data['all_points']     	= 	$this->ranking_model->allPoints();
		$data['last_group'] 		= 	$this->ranking_model->lastGroup();
		$data['group_name'] 		= 	$this->ranking_model->groupName($data['last_group']);
		$data['ligi'] 				= 	$this->ranking_model->ligi();
		$data['ligi_dane'] 			= 	$this->ranking_model->ligiDane();
		$data['wybrani_points'] 	= 	$this->ranking_model->wybrani_points();
		$data['logged_in'] 			= 	$this->session->userdata('logged_in');
		$data['typowali_wszyscy'] 	= 	$this->ranking_model->typowaliWszyscy();
		// print_r($data['typowali_wszyscy']);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/ranking', $data);
		$this->load->view('templates/footer');
	}


	public function ranking_lig($id)
	{
		$id_ligi = $id;

		$data['title'] 			= 	'Ranking';
		$data['id_ligi'] 		= 	$id_ligi;
		$data['ligi'] 			= 	$this->ranking_model->ligi($id_ligi);
		$data['ligi_dane'] 		= 	$this->ranking_model->ligiDane($id_ligi);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/ranking_lig', $data);
		$this->load->view('templates/footer');
	}


}
