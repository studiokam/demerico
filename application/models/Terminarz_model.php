<?php 
class terminarz_model extends CI_Model
{

	public function get_grupy()
	{
		$this->db->order_by('create_at', 'DESC');
		$query = $this->db->get('grupy_spotkan');
		return $query->result_array();
	}

	public function get_aktywne_mecze()
	{
		$this->db->where('data_meczu >', date("Y-m-d H:i:s"));
		$this->db->order_by('liga_id');
		$this->db->order_by('data_meczu');
		$this->db->join('ligi', 'ligi.id_ligi = liga_id');
		$query = $this->db->get('mecz');
		return $query->result_array();
	}

	// pobiera typy innych
	public function get_inni()
	{
		$this->db->where('data_meczu >', date("Y-m-d H:i:s"));
		$this->db->order_by('liga_id');
		$this->db->order_by('data_meczu');
		$this->db->join('ligi', 'ligi.id_ligi = liga_id');
		$query = $this->db->get('mecz');
		return $query->result_array();
	}


	// pobiera wyniki zalogowanegu usera
	public function get_wyniki_usera($data)
	{
		
		
		foreach ($data as $row) {
			$this->db->where('wynik_user_id', $this->session->userdata('user_id'));
			$this->db->where('wynik_mecz_id', $row['mecz_id']);
			$query = $this->db->get('wynik');
			$wynik1 = $query->row_array();
			$wynik2 = $row;

			// jesli jest to pobranie wyników przed jakimkolwiek obstawieniem to nie ma jeszcze wyniku z db i wstawiam recznie
			if (empty($wynik1)) {
				$wynik3 = array(
					'wynik_id' => '',
		            'wynik_user_id' => $this->session->userdata('user_id'),
		            'wynik_mecz_id' => $row['mecz_id'],
		            'wynik_gospodarz_wynik' => '',
		            'wynik_gosc_wynik' => '',
		            'wynik_group_id' => $row['group_id']
				);
			} else {
				$wynik3 = $query->row_array();
			}

			$result[] = array_merge($wynik2, $wynik3);
			
		}

		if (!$data) {
			$result = array();
			return $result;
		} else {
			
			return $result;
		}

		
	}


	// pobiera wyniki obserwowanych userow
	public function get_wyniki_obserwowanych($data, $users_id)
	{

		foreach ($users_id as $user_id) {	
			foreach ($data as $row) {
				$this->db->where('wynik_user_id', $user_id);
				$this->db->select('users.username, wynik_id, wynik_user_id, wynik_mecz_id, wynik_gospodarz_wynik, wynik_gosc_wynik, wynik_group_id');
				$this->db->where('wynik_mecz_id', $row['mecz_id']);
				$this->db->join('users', 'users.id = wynik_user_id');
				$query = $this->db->get('wynik');
				$wynik1 = $query->row_array();

				// jesli jest to pobranie wyników przed jakimkolwiek obstawieniem to nie ma jeszcze wyniku z db i wstawiam recznie
				if (empty($wynik1)) {
					$wynik3 = array(
						'wynik_id' => '',
			            'wynik_user_id' => $user_id,
			            'username' => $this->user_model->getUsername($user_id),
			            'wynik_mecz_id' => $row['mecz_id'],
			            'wynik_gospodarz_wynik' => '',
			            'wynik_gosc_wynik' => '',
			            'wynik_group_id' => $row['group_id']
					);
				} else {
					$wynik3 = $query->row_array();
				}

				$result[] = $wynik3;
				
			}
		}


		if (!$data) {
			$result = array();
			return $result;
		} else {
			
			return $result;
		}

		
	}





	public function replace_wynik($mecze)
	{
		
		foreach ($mecze as $mecz) {

			$this->db->where('wynik_mecz_id', $mecz['mecz_id']);
			$this->db->where('wynik_user_id', $this->session->userdata('user_id'));
			$this->db->delete('wynik');


			
			$data = array(
		        'wynik_user_id' => $this->session->userdata('user_id'),
		        'wynik_mecz_id' => $mecz['mecz_id'],
		        'wynik_group_id' => $mecz['group_id'],
		        'wynik_gospodarz_wynik' => $mecz['gospodarz_wynik'],
		        'wynik_gosc_wynik' => $mecz['gosc_wynik']
			);

			$this->db->insert('wynik', $data);

		}
	}


	public function mecze_z_grupy($id_grupy, $user_id)
	{
		
		$this->db->where('group_id', $id_grupy);
		$this->db->order_by('liga_id');
		$this->db->order_by('data_meczu', 'DESC');
		$this->db->join('ligi', 'ligi.id_ligi = liga_id');
		$mecze = $this->db->get('mecz');
		$mecze_arr = $mecze->result_array();
		// echo "<pre>";
		// print_r($mecze_arr);

		foreach ($mecze_arr as $row) {
			$this->db->where('wynik_user_id', $user_id);
			$this->db->where('wynik_mecz_id', $row['mecz_id']);
			$wyniki = $this->db->get('wynik');
			$wyniki_arr = $wyniki->result_array();

			$wynik2 = $row;

			// jesli jest to pobranie wyników przed jakimkolwiek obstawieniem to nie ma jeszcze wyniku z db i wstawiam recznie
			$wynik3 = array();
			if (!empty($wyniki_arr)) {
				$wynik3 = $wyniki->row_array();
			} 

			$result[] = array_merge($wynik2, $wynik3);
		}

		if (!$mecze_arr) {
			$result = array();
		} 

		return $result;
		
	}


	public function wyniki_zalogowanego($id_grupy)
	{
		
		$this->db->where('wynik_group_id', $id_grupy);
		$this->db->where('wynik_user_id', $this->session->userdata('user_id'));
		$query = $this->db->get('wynik');
		return $query->result_array();
	}

	public function podsumowanie($id_grupy)
	{
		
		$this->db->where('group_id', $id_grupy);
		$this->db->order_by('points', 'DESC');
		$this->db->limit(20);
		$this->db->join('users', 'users.id = user_id');
		$query = $this->db->get('ranking_grup');
		// return $query->result_array();

		$summaryResult = [];
 
		
		foreach ($query->result_array() as $row) {
		    
		    $rows['user_id'] 	= $row['user_id'];
		    $rows['points'] 	= $row['points'];
		    $rows['username'] 	= $row['username'];
		    $summaryResult[] 	= $rows;
		}

		return $summaryResult;

	}


	public function inni($id_grupy, $id)
	{
		
		$this->db->where('wynik_group_id', $id_grupy);
		$this->db->where('wynik_user_id !=', $id);
		$this->db->join('users', 'users.id = wynik_user_id');
		$this->db->join('mecz', 'mecz.mecz_id = wynik_mecz_id');
		$query = $this->db->get('wynik');
		// return $query->result_array();

		$summaryResult = [];
 
		
		foreach ($query->result_array() as $row) {
		    
		    $rows['wynik_user_id'] 	= $row['wynik_user_id'];
		    $rows['wynik_mecz_id'] 	= $row['wynik_mecz_id'];
		    $rows['username'] 	= $row['username'];
		    $rows['wynik_gospodarz_wynik'] 	= $row['wynik_gospodarz_wynik'];
		    $rows['wynik_gosc_wynik'] 	= $row['wynik_gosc_wynik'];
		    $rows['wynik_pkt'] 	= $row['wynik_pkt'];
		    $rows['gospodarz'] 	= $row['gospodarz'];
		    $rows['gosc'] 	= $row['gosc'];
		    $summaryResult[] 	= $rows;
		}

		return $summaryResult;

	}


	public function typy_usera($id_grupy, $user_id)
	{
		


		$this->db->select('
			users.username, 
			mecz.gospodarz,
			mecz.gosc,
			mecz.gospodarz_wynik,
			mecz.gosc_wynik,
			wynik.wynik_pkt,
			wynik.wynik_gospodarz_wynik,
			wynik.wynik_gosc_wynik
			');
		$this->db->where('group_id', $id_grupy);
		$this->db->join('users', 'users.id = '.$user_id);
		$this->db->join('wynik', 'wynik.wynik_mecz_id = mecz_id AND wynik.wynik_user_id = '.$user_id);
		$this->db->order_by('liga_id');
		$this->db->order_by('data_meczu', 'DESC');
		$query = $this->db->get('mecz');
		return $query->result_array();
	}

}