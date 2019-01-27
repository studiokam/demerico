<?php 
class ranking_model extends CI_Model{

	private $_id_grupy,
			$_all_points,
			$_ligi_dane;

	public function allPoints()
	{
		
		$this->db->select(' 
			ranking_grup.user_id, 
			ranking_grup.points,
			users.username'
		);

		$this->db->join('users', 'users.id = user_id');
		$query = $this->db->get('ranking_grup');
		$result = $query->result_array();

		if (!empty($result)) {

			// sumowanie punktów dla wszytkich wyników z db
			foreach ($result as $row) {

			    if (!isset($summaryResult[$row['user_id']])) {
					$summaryResult[$row['user_id']] = 0;
				}

			    $summaryResult[$row['user_id']] += $row['points'];
			}

			// dodanie do sum wyników username 
			foreach ($summaryResult as $key => $value) {
				
				$nick = $this->user_model->getUsername($key);
				$all_points[] = array(
					'user_id' => $key, 
					'sum_points' => $value, 
					'username' => $nick
				);
			}

			// przesortowanie aby było od największej liczby punktów
			foreach ($all_points as $key => $row) 
				{ 
					$vc_array_name[$key] = $row['sum_points']; 
				} 
			array_multisort($vc_array_name, SORT_DESC, $all_points);

			$this->_all_points = $all_points;
			return $all_points;
		}
		return array();

	}

	public function wybrani_points()
	{
		
		if ($this->session->userdata('logged_in')) {
			
			$wybrani = $this->user_model->obserwowaniID($this->session->userdata('user_id'));
			$all_pts = $this->allPoints();

			foreach ($all_pts as $key => $value) {
				foreach ($wybrani as $row) {
					if (in_array($row, $value)) {
						$result[] = $value;
					}
				}
			}

			if (!isset($result)) {
				$result = array();
			}

			return $result;

		} else {
			return array();
		}

	}

	public function lastGroup()
	{

		// zwraca najpozniej utworzona grupę
		$this->db->select('id');
		$this->db->order_by('create_at', 'DESC');
		$this->db->where('end_status = 1');
		$query = $this->db->get('grupy_spotkan');
		$result = $query->row_array();
		$id_grupy = $result['id'];
		$this->_id_grupy = $id_grupy;

		// pobranie wyników dla tej danej grupy(ostatniej)
		$this->db->where('wynik_group_id', $id_grupy);
		$query = $this->db->get('wynik');
		$result = $query->result_array();

		// sumowanie punktów dla wszytkich wyników z db
		foreach ($result as $row) {

		    if (!isset($summaryResult[$row['wynik_user_id']])) {
				$summaryResult[$row['wynik_user_id']] = 0;
			}

		    $summaryResult[$row['wynik_user_id']] += $row['wynik_pkt'];
		}

		

		if (!empty($summaryResult)) {

			// dodanie do sum wyników username 
			foreach ($summaryResult as $key => $value) {
				
				$nick = $this->user_model->getUsername($key);
				$all_points[] = array(
					'user_id' => $key, 
					'sum_points' => $value, 
					'username' => $nick
				);
			}

			// przesortowanie aby było od największej liczby punktów
			foreach ($all_points as $key => $row) 
				{ 
					$vc_array_name[$key] = $row['sum_points']; 
				} 
			array_multisort($vc_array_name, SORT_DESC, $all_points);

			return $all_points;
		}

		return array();

	}

	public function idWszystkichGrup()
	{
		$this->db->select('id');
		$query = $this->db->get('grupy_spotkan');
		$result = $query->result_array();

		$all_id = array_column($result, 'id');
		return $all_id;

	}

	public function groupName($id)
	{
		$this->db->where('id', $this->_id_grupy);
		$query = $this->db->get('grupy_spotkan');
		$result = $query->row_array();
		$name = $result['name'];

		return $name;

	}

	public function ligi($id = '')
	{
		if ($id) {
			$this->db->where('id_ligi', $id);
		}
		$query = $this->db->get('ligi');
		$result = $query->result_array();
		$this->_ligi_dane = $result;
		
		// pobranie wszystkich meczów dla danej ligi
		foreach ($result as $row) {
			
			$this->db->select('liga_id, mecz_id');
			$this->db->where('liga_id', $row['id_ligi']);
			if ($id) {
				$this->db->where('liga_id', $id);
			} else {
				$this->db->where('liga_id', $row['id_ligi']);
			}

			$query_mecz = $this->db->get('mecz');
			$result_mecz[] = $query_mecz->result_array();

			
		}
		// echo "<pre>";

		foreach ($result_mecz as $row) {
			foreach ($row as $rows) {
				$array[$rows['liga_id']][] = $rows['mecz_id'];
			}
		}

		if (!empty($array)) {
			
		
			foreach ($array as $key => $value) {

				foreach ($value as $row) {

					// pobranie wyników dla każdego meczu
					$this->db->select('wynik_user_id, wynik_pkt');
					$this->db->where('wynik_mecz_id', $row);
					$query_wynik = $this->db->get('wynik');
					$result_wynik[$key][$row] = $query_wynik->result_array();

					
				}
			}

			foreach ($result_wynik as $key => $value) {
				$liga_id[] = $key;
			}

			$i=0;
			foreach ($result_wynik as $key => $value) {
				
				if ($key == $liga_id[$i]) {
					
					foreach ($value as $key_in_val => $value_in_val) {
						
						foreach ($value_in_val as $name => $name_value) {
							if (!isset($wyniki[$name_value['wynik_user_id']])) {
								$wyniki[$name_value['wynik_user_id']] = 0;
							}

						    $wyniki[$name_value['wynik_user_id']] += $name_value['wynik_pkt'];
						}

					}

					// sortowanie od największej ilośći pkt
					arsort($wyniki);

					// do ogolnej tablicy
					$final[$key] = $wyniki;
					$i++;
					unset($wyniki);
					$wyniki = [];

				}
			}

			foreach ($final as $key => $value) {
				foreach ($value as $val_key => $val_value) {
					$final2[$key][] = [
						'username' => $this->user_model->getUsername($val_key),
						'pts' => $val_value
					]; 
				}
			}
			// print_r($final2);

			return $final2;
		} else {
			return array();
		}

	}

	public function ligiDane()
	{
		return $this->_ligi_dane;
	}


	// ranking / wyniki dla opcji gdzie wszyscy typowali te same spotkania (min 10)
	public function typowaliWszyscy()
	{
		// pobranie typowanego meczu dla kazdego usera
		$query = $this->db->get('wynik');
		$result = $query->result_array();
		$ile = 10;
		

		if (!empty($result)) {
			
			// do tablicy mecze dla danego usera
			foreach ($result as $key => $value) {
				if ($value['wynik_pkt'] != null) {
					if (!isset($wyniki[$value['wynik_user_id']])) {
						$wyniki[$value['wynik_user_id']] = [];
					}
					if ($value['wynik_gospodarz_wynik'] != null && $value['wynik_gosc_wynik'] != null) {
						$wyniki[$value['wynik_user_id']][] .= $value['wynik_mecz_id'];
					}
				}

					

			    
			}

			if (count($wyniki) > 1) {
				// sprawdzanie czy dany user ma powyżej $ile meczów typowanych
				foreach ($wyniki as $key => $value) {
					if (count($value) > $ile) {
						$zakwalifikowany[$key] = $value; 
					}
				}

				if (isset($zakwalifikowany)) {
					
					// zapisanie id userów zakwalifikowanych
					foreach ($zakwalifikowany as $key => $value) {
						$zakwalifikowany_id[] = $key; 
					}

					// wybranie meczów które typował każdy zakwalifikowany (min $ile)
					$intersected_array = call_user_func_array('array_intersect',$zakwalifikowany);

					if (!empty($intersected_array)) {

						// pobranie dla każdego usera punktów do meczu z tych zakwalifikowanych
						foreach ($zakwalifikowany_id as $row) {
							foreach ($intersected_array as $match) {
								
								$this->db->select('wynik_user_id, wynik_pkt');
								$this->db->where('wynik_user_id', $row);
								$this->db->where('wynik_mecz_id', $match);
								$query = $this->db->get('wynik');
								$result = $query->row_array();
								$user_i_pkt_arr[] = $result;
							}
						}

						// echo "<pre>";
						// print_r($zakwalifikowany_id);
						// print_r($wyniki);

						// zliczanie punktów dla userow
						foreach ($user_i_pkt_arr as $key => $value) {

							if (!isset($user_i_pkt[$value['wynik_user_id']])) {
								$user_i_pkt[$value['wynik_user_id']] = 0;
							}

						    $user_i_pkt[$value['wynik_user_id']] += $value['wynik_pkt'];
						}


						// z
						foreach ($user_i_pkt as $key => $value) {
							$final[] = [
								'username' => $this->user_model->getUsername($key),
								'pts' => $value
							]; 
						}

						// sortowanie od najwiekszej 
						foreach ($final as $key => $row) 
							{ 
								$vc_array_name[$key] = $row['pts']; 
							} 
						array_multisort($vc_array_name, SORT_DESC, $final);


						return $final;

					} else {
						return array();
					}

				} else {
					return array();
				}

					
			}
				

		}

		return array();

			
	}


}