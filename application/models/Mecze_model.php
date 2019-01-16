<?php 
/**
 * 
 */
class mecze_model extends CI_Model
{
	
	public function get_mecze($id)
	{
		$this->db->select('*');
		$this->db->from('mecz');
		$this->db->where('group_id', $id);
		$this->db->order_by('liga_id');
		$this->db->order_by('data_meczu');
		$this->db->join('ligi', 'ligi.id_ligi = liga_id');
		$query = $this->db->get();

		return $query->result_array();

	}

	public function get_mecz($id)
	{
		$this->db->where('mecz_id', $id);
		$this->db->join('ligi', 'ligi.id_ligi = liga_id');
		$query = $this->db->get('mecz');

		return $query->row_array();

	}

	public function create_mecz($id)
	{
		$data = array(
			'group_id' => $id,
			'liga_id' => $this->input->post('liga'),
			'gospodarz' => $this->input->post('gospodarz'),
			'gosc' => $this->input->post('gosc'),
			'data_meczu' => $this->input->post('in_date') . ' ' . $this->input->post('display_to_hours')
		);

		return $this->db->insert('mecz', $data);
	}

	public function update_mecz($id)
	{
		

		// transakcje
		$this->db->trans_start();

		// update meczu
		$data = array(
			'gospodarz_wynik' => $this->input->post('gospodarz_wynik'),
			'gosc_wynik' => $this->input->post('gosc_wynik')
		);
		$this->db->where('mecz_id', $id);
		$this->db->update('mecz', $data);

		$this->db->where('wynik_mecz_id', $id);
		$typy_dla_tego_update = $this->db->get('wynik');
		$typy_dla_tego_update_arr = $typy_dla_tego_update->result_array();

		if (count($typy_dla_tego_update_arr) > 0) {
			foreach ($typy_dla_tego_update_arr as $row) {
				$data_pkt = array(
					'wynik_pkt' => $this->oblicz_punkty($row['wynik_gospodarz_wynik'], $row['wynik_gosc_wynik'], $data),
				);
				$this->db->where('wynik_mecz_id', $id);
				$this->db->where('wynik_user_id', $row['wynik_user_id']);
				$this->db->update('wynik', $data_pkt);
			}
		}		

		// sumowanie punktów userów dla danej grupy (wynika z meczu)
		// ustalenie id grupy dla meczu
		$this->db->where('mecz_id', $id);
		$query_id_grupy = $this->db->get('mecz');
		$query_id_grupy_arr = $query_id_grupy->row_array();
		$id_grupy = $query_id_grupy_arr['group_id'];
		
		$this->db->where('wynik_group_id', $id_grupy);
		$query = $this->db->get('wynik');
		$wszystkie_wyniki = $query->result_array();


		$summaryResult = [];
 
		
		foreach ($wszystkie_wyniki as $row) {
		    if (!isset($summaryResult[$row['wynik_user_id']])) {
				$summaryResult[$row['wynik_user_id']] = 0;
				}
		    $summaryResult[$row['wynik_user_id']] += $row['wynik_pkt'];
		}
		
		foreach ($summaryResult as $userID => $result){
		    // echo $userID.'<br>';
		    // echo $result.'<br>';

		    $this->db->where('group_id', $id_grupy);
			$this->db->where('user_id', $userID);
			$this->db->delete('ranking_grup');


			
			$data_in = array(
		        'group_id' => $id_grupy,
		        'user_id' => $userID,
		        'points' => $result
			);

			$this->db->insert('ranking_grup', $data_in);
		}




		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
		    // generate an error... or use the log_message() function to log your error
		    return false;
		} else {
			return true;
		}

		
	}

	public function oblicz_punkty($wynik_gospodarz_wynik, $wynik_gosc_wynik, $data)
	{
		if ($data['gospodarz_wynik'] > $data['gosc_wynik']) {
			$zwyciezca = '1';
		} elseif ($data['gospodarz_wynik'] < $data['gosc_wynik']) {
			$zwyciezca = '2';
		} elseif ($data['gospodarz_wynik'] == $data['gosc_wynik']) {
			$zwyciezca = '0';
		}

		if ($wynik_gospodarz_wynik == $data['gospodarz_wynik'] && $wynik_gosc_wynik == $data['gosc_wynik']) {
			$pkt = '5';
		} else {

			if ($wynik_gospodarz_wynik > $wynik_gosc_wynik) {
				$typ = '1';
			} elseif ($wynik_gospodarz_wynik < $wynik_gosc_wynik) {
				$typ = '2';
			} elseif ($wynik_gospodarz_wynik == $wynik_gosc_wynik) {
				$typ = '0';
			}

			if ($zwyciezca == $typ) {
				$pkt = '3';
			} else {
				$pkt = '0';
			} 

		}

		if ($wynik_gospodarz_wynik == null || $wynik_gosc_wynik == null) {
			$pkt = '0';
		}


		return $pkt;

	}

	public function delete_mecz($id)
	{
		
		$this->db->where('mecz_id', $id);
		return $this->db->delete('mecz');
	}

	public function update_grupy_spotkan($group_id)
	{
		
		$this->db->where('group_id', $group_id);
		$query = $this->db->get('mecz');
		$result = $query->result_array();

		// sprawdzenie czy wszędzie sa wpisane wyniki (dla każdego meczu w tej grupie - jesli tak to flaga na true i update grupy), jest to potrzebne np. do ustawienia grupy jako zakonczona dla ostatniej kolejki
		foreach ($result as $row) {
			if ($row['gosc_wynik'] != "" && $row['gospodarz_wynik'] != "") {
				$flag[] = 1;
			} else {
				$flag[] = 0;
			}
		}

		if (!in_array('0', $flag)) {
			$data = array('end_status' => '1');
			$this->db->where('id', $group_id);
			$this->db->update('grupy_spotkan', $data);
		} else {
			$data = array('end_status' => '0');
			$this->db->where('id', $group_id);
			$this->db->update('grupy_spotkan', $data);
		}

		return $flag;
	}

	
}