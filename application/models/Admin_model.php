<?php 
	class admin_model extends CI_Model
	{
		public function create_liga($liga_image)
		{
			
			$data = array(
				'name' => $this->input->post('name'),
				'img' => $liga_image
			);

			return $this->db->insert('ligi', $data);
		}

		public function get_ligi()
		{
			$query = $this->db->get('ligi');
			return $query->result_array();
		}

		public function create_grupe()
		{
			$data = array(
				'name' => $this->input->post('name')
			);
			return $this->db->insert('grupy_spotkan', $data);
		}

		public function get_groups()
		{
			$this->db->order_by('create_at', 'DESC');
			$query = $this->db->get('grupy_spotkan');
			return $query->result_array();
		}


	}