<?php 
	class Admin extends CI_Controller
	{
		public function index()
		{
			if ($this->session->userdata('admin') != 1) {
				redirect('');
			}

			$data['title'] = 'Zaplecze';
			$data['admin'] = $this->session->userdata('admin');

			$this->load->view('templates/header', $data);
			$this->load->view('admin/index', $data);
			$this->load->view('templates/footer');
		}

		public function ligi()
		{
			if ($this->session->userdata('admin') != 1) {
				redirect('');
			}

			$data['title'] = 'Zaplecze - ligi';
			$data['ligi'] = $this->admin_model->get_ligi();

			// walidacja
			$this->form_validation->set_rules('name', 'Nazwa', 'required|is_unique[ligi.name]' );

			if ($this->form_validation->run() === FALSE) {
				
				$this->load->view('templates/header', $data);
				$this->load->view('admin/ligi', $data);
				$this->load->view('templates/footer');

			} else {

				// Upload Image
				$config['upload_path'] = './assets/images/flags';
	            $config['allowed_types']        = 'gif|jpg|png';
	            $config['max_size']             = '2100';
	            $config['max_width']            = '1024';
	            $config['max_height']           = '768';

	            $this->load->library('upload', $config);

				if (!$this->upload->do_upload('ligalogo')) {
					$errors = array('error' => $this->upload->display_errors());
					$liga_image = 'noimage.jpg';
					var_dump($this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$liga_image = $_FILES['ligalogo']['name'];
				}

				$this->admin_model->create_liga($liga_image);

				// Set message
				$this->session->set_flashdata('success', 'Dodano now ligę');
				redirect('admin/ligi');
			}

			
		}


		public function grupyspotkan()
		{

			if ($this->session->userdata('admin') != 1) {
				redirect('');
			}

			$data['grupy'] = $this->admin_model->get_groups();
			$data['title'] = 'Grupy spotkań';

			// walidacja
			$this->form_validation->set_rules('name', 'Nazwa', 'required|is_unique[grupy_spotkan.name]' );

			if ($this->form_validation->run() === FALSE) {
				
				$this->load->view('templates/header', $data);
				$this->load->view('admin/grupyspotkan', $data);
				$this->load->view('templates/footer');

			} else {

				

				$this->admin_model->create_grupe();

				// Set message
				$this->session->set_flashdata('success', 'Dodano nową grupę - można dodać w niej mecze.');
				redirect('admin/grupyspotkan');
			}

		}

		public function grupa($id) 
		{

			if ($this->session->userdata('admin') != 1) {
				redirect('');
			}

			$data['title'] = 'Grupa - dodaj mecze';
			$data['id'] = $id;

			$data['mecze'] = $this->mecze_model->get_mecze($id);
			// echo "<pre>";
			
			$data['ligi'] = $this->admin_model->get_ligi();
			// print_r($data['ligi']);
			
			// walidacja
			$this->form_validation->set_rules('liga', 'Liga', 'required' );
			$this->form_validation->set_rules('in_date', 'Data', 'required' );
			$this->form_validation->set_rules('display_to_hours', 'Godzina', 'required' );
			$this->form_validation->set_rules('gosc', 'Gość', 'required' );
			$this->form_validation->set_rules('gospodarz', 'Gospodarz', 'required' );

			if ($this->form_validation->run() === FALSE) {
				
				$this->load->view('templates/header', $data);
				$this->load->view('admin/grupa', $data);
				$this->load->view('templates/footer');

			} else {
				

				$this->mecze_model->create_mecz($id);

				// Set message
				$this->session->set_flashdata('success', 'Dodano mecze do grupy.');
				redirect('admin/grupa/'.$id);
			}

			
		}


		public function mecz($id) 
		{

			if ($this->session->userdata('admin') != 1) {
				redirect('');
			}

			$data['title'] = 'Mecz - edycja wyniku';
			$data['mecz'] = $this->mecze_model->get_mecz($id);
			$grupa = $data['mecz']['group_id'];

			// echo "<pre>";
			// print_r($data['mecz']);

			// walidacja
			$this->form_validation->set_rules('gosc_wynik', 'Gość', 'required' );
			$this->form_validation->set_rules('gospodarz_wynik', 'Gospodarz', 'required' );

			if ($this->form_validation->run() === FALSE) {
				
				$this->load->view('templates/header', $data);
				$this->load->view('admin/mecz', $data);
				$this->load->view('templates/footer');

			} else {

				$this->mecze_model->update_mecz($id);
				$this->mecze_model->update_grupy_spotkan($grupa);
				

				// Set message
				$this->session->set_flashdata('success', 'Zapisano wynik meczu.');
				redirect('admin/grupa/'.$data['mecz']['group_id']);
			}

			
		}


		public function usunmecz($id) 
		{

			if ($this->session->userdata('admin') != 1) {
				redirect('');
			}

			$data['title'] = 'Mecz - usuń mecz';
			
			$data['mecz'] = $this->mecze_model->get_mecz($id);
			// echo "<pre>";
			print_r($data['mecz']);
			if ($this->input->get('del')) {

				$this->mecze_model->delete_mecz($id);

				// Set message
				$this->session->set_flashdata('success', 'Mecz został usunięty.');
				redirect('admin/grupa/'.$data['mecz']['group_id']);
			}


				
			$this->load->view('templates/header', $data);
			$this->load->view('admin/usunmecz', $data);
			$this->load->view('templates/footer');

			

			
		}


	}