<div class="container">
	<br><br>
	<div class="row">
		<div class="d-none d-md-block col-md-9 ">
			<h4>Mecze do typowania</h4>
			
			    
			<?php if ($this->session->userdata('logged_in')): ?>
			<form action="" method="get">		
				<label class="switch">
		          	<input type="checkbox" class="success" name="inni" class="custom-control-input" value="<?php echo ($watch_users_default > 0 ? 0 : 1) ?>" <?php if($watch_users_default > 0) echo "checked ='checked'";?> id="customControlAutosizing" onchange="window.location.href='<?php echo base_url(); ?>terminarz?inni=' + this.value;">
		          	<span class="slider round"></span>
		        </label>
		        <label class ="cdustom-control-label" for="cuvstomControlAutosizing">Pokaż jak obstawiają inni <?php if($watch_users_default > 0) echo '- <a href="konto">ustawienia</a>';?></label>
			</form>
			<?php endif ?>

			<?php if (!$aktywne_mecze_wyniki_usera): ?>
			  	<hr>
			  	<p>Obecnie nie ma niczego do obstawienia</p>
			  	<hr>
			<?php else: ?>
				
				<?php echo validation_errors(); ?>
				<?php echo form_open('terminarz'); ?>
				<table class="table">
				  <thead>
				    <tr>
				      <th scope="col">Liga</th>
				      <th scope="col">Data</th>
				      <th class="text-center" scope="col">Spotkanie</th>
				      <th class="text-right" scope="col">Twój typ</th>
				    </tr>
				  </thead>
				  <tbody>
				  	
				<?php foreach ($aktywne_mecze_wyniki_usera as $mecz): ?>
					<tr>
				      <th><img src="<?php echo base_url().'assets/images/flags/'.$mecz['img']; ?>" width="20px"></th>
				      <td><?php echo $mecz['data_meczu']; ?></td>
				      <td class="text-center"><?php echo $mecz['gospodarz'] .' - '. $mecz['gosc']; ?></td>
				      <td class="text-right">

					    <div class="bet-max float-right">
					      	<div class="form-row">
								<div class="col">
									<input type="number" class="form-control text-center font-weight-bold" name="<?php echo $mecz['mecz_id']; ?>form_data[gospodarz_wynik]" value="<?php echo $mecz['wynik_gospodarz_wynik']; ?>">
								</div>
								<div class="mt-9">:</div>
								<div class="col">
									<input type="number" class="form-control text-center font-weight-bold" name="<?php echo $mecz['mecz_id']; ?>form_data[gosc_wynik]" value="<?php echo $mecz['wynik_gosc_wynik']; ?>">
								</div>
							</div>
						</div>
						<input type="hidden" name="<?php echo $mecz['mecz_id']; ?>form_data[mecz_id]" value="<?php echo $mecz['mecz_id']; ?>">
						<input type="hidden" name="<?php echo $mecz['mecz_id']; ?>form_data[group_id]" value="<?php echo $mecz['group_id']; ?>">

				      </td>
				    </tr> 
				    <?php if ($pokazuj_innych > 0): ?>
		    
					    <?php foreach ($aktywne_mecze_wyniki_obserwowanych as $row): ?>
					    	<?php if ($row['wynik_mecz_id'] == $mecz['mecz_id']): ?>
					    		<tr class="inni-typy">
							    	<td></td>
							    	<td></td>
							    	<td class="text-center"><?php echo ucfirst($row['username']). ' '. ($row['wynik_gospodarz_wynik'] !== null ? $row['wynik_gospodarz_wynik'] : '- ') . ':' . ($row['wynik_gosc_wynik'] !== null ? $row['wynik_gosc_wynik'] : ' -') ?></td>
							    	<td></td>
							    </tr>
					    	<?php endif ?>
					    <?php endforeach ?>
					    
					<?php endif ?>
				    
				    
				<?php endforeach ?>
					</tbody>
				</table>
				<hr>
				

				<?php if (!$this->session->userdata('logged_in')): ?>
					<a href="<?php echo base_url(); ?>users/login" class="btn btn-success float-right">Zaloguj się aby obstawiać</a>
				<?php else: ?>
					<button type="submit" class="btn btn-success float-right">Zapisz</button>
				<?php endif ?>

			<?php endif ?>
			
			</form>
		</div>
		

		<!-- mobile table --> 
		<div class="d-block d-md-none col-md-9 ">
			<h4>Mecze do typowania</h4>
			<?php if ($this->session->userdata('logged_in')): ?>
			<form action="" method="get">		
				<label class="switch">
		          	<input type="checkbox" class="success" name="inni" class="custom-control-input" value="<?php echo ($watch_users_default > 0 ? 0 : 1) ?>" <?php if($watch_users_default > 0) echo "checked ='checked'";?> id="customControlAutosizing" onchange="window.location.href='<?php echo base_url(); ?>terminarz?inni=' + this.value;">
		          	<span class="slider round"></span>
		        </label>
		        <label class ="cdustom-control-label" for="cuvstomControlAutosizing">Pokaż jak obstawiają inni <?php if($watch_users_default > 0) echo '- <a href="konto">ustawienia</a>';?></label>
			</form>
			<?php endif ?>
			
			<?php echo validation_errors(); ?>
			<?php echo form_open('terminarz'); ?>
			<table class="table">
			  
			  <tbody>
			<?php foreach ($aktywne_mecze_wyniki_usera as $mecz): ?>
				<tr>
			      <td class="pl-0 pr-0">
			      	<div class="float-left">
		      			<img src="<?php echo base_url().'assets/images/flags/'.$mecz['img']; ?>" width="20px">
		      		</div>
		      		<div class="float-left ml-10">
		      			<div class="data-mecz"><?php echo $mecz['gospodarz'] .' - '. $mecz['gosc']; ?></div>

				      	<div class="data-sm"><?php echo substr($mecz['data_meczu'], 0, -3); ?></div>


		      		</div>
					<div class="float-right text-right">
						<div class="bet-max">
					      	<div class="form-row">
								<div class="col">
									<input type="number" class="form-control text-center font-weight-bold" name="<?php echo $mecz['mecz_id']; ?>form_data[gospodarz_wynik]" value="<?php echo $mecz['wynik_gospodarz_wynik']; ?>">
								</div>
								<div class="kropki">:</div>
								<div class="col">
									<input type="number" class="form-control text-center font-weight-bold" name="<?php echo $mecz['mecz_id']; ?>form_data[gosc_wynik]" value="<?php echo $mecz['wynik_gosc_wynik']; ?>">
								</div>
							</div>
						</div>
					</div>

			      	
			    

				    
					<input type="hidden" name="<?php echo $mecz['mecz_id']; ?>form_data[mecz_id]" value="<?php echo $mecz['mecz_id']; ?>">
					<input type="hidden" name="<?php echo $mecz['mecz_id']; ?>form_data[group_id]" value="<?php echo $mecz['group_id']; ?>">

			      </td>
			    </tr>
			    <?php if ($pokazuj_innych > 0): ?>
		    
				    <?php foreach ($aktywne_mecze_wyniki_obserwowanych as $row): ?>
				    	<?php if ($row['wynik_mecz_id'] == $mecz['mecz_id']): ?>
				    		<tr class="inni-typy-mobi">
						    	
						    	<td class="text-left">
						    		<small class="ml-20"><?php echo ucfirst($row['username']). ' '?><?php echo ($row['wynik_gospodarz_wynik'] != null ? $row['wynik_gospodarz_wynik'] : ' - ') . ':' . ($row['wynik_gosc_wynik'] != null ? $row['wynik_gosc_wynik'] : ' -') ?></small>
						    	</td>
						    	
						    </tr>
				    	<?php endif ?>
				    <?php endforeach ?>
				    <tr class="inni-typy-mobi-last">
				    	<td></td>
				    </tr>
				    
				<?php endif ?>
			    
			<?php endforeach ?>
				</tbody>
			</table>
			<hr>
			<?php if (!$this->session->userdata('logged_in')): ?>
				<a href="<?php echo base_url(); ?>users/login" class="btn btn-success float-right mb-50">Zaloguj się aby obstawiać</a>
			<?php else: ?>
				<button type="submit" class="btn btn-success mb-50 float-right">Zapisz</button>
			<?php endif ?>
			
			</form>
		</div>

		<div class="col-md-3">
			<h4>Wszystkie grupy spotkań</h4>
			<?php foreach ($grupy as $grupa): ?>
				<a href="<?php echo base_url(); ?>grupa/<?php echo $grupa['id']; ?>" class="terminarz-grupy">
						<div class="mb-0 nag"><?php echo $grupa['name']; ?></div>

						
					</a>
					<p class="nag-data"><?php echo date('d-m-Y', time($grupa['create_at'])); ?></p>
			<?php endforeach ?>
		</div>
	</div>
</div>
