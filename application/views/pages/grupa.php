<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-12">
			<h4>Przegld grupy wyników</h4>
			
			<?php if ($this->session->userdata('logged_in')): ?>
			<form action="" method="get">		
				<label class="switch">
		          	<input type="checkbox" class="success" name="inni" class="custom-control-input" value="<?php echo ($watch_users_default > 0 ? 0 : 1) ?>" <?php if($watch_users_default > 0) echo "checked ='checked'";?> id="customControlAutosizing" onchange="window.location.href='<?php echo base_url(); ?>grupa/<?php echo $id; ?>?inni=' + this.value;">
		          	<span class="slider round"></span>
		        </label>
		        <label class ="cdustom-control-label" for="cuvstomControlAutosizing">Pokaż jak obstawiają inni <?php if($watch_users_default > 0) echo '- <a href="' . base_url() . 'konto">ustawienia</a>';?></label>
			</form>
			<?php endif ?>
			
			<div class="d-none d-md-block">
				<table class="table">
				<!-- <table class="table d-none d-md-block"> -->
				  <thead>
				    <tr>
				      <th scope="col">Liga</th>
				      <th scope="col">Data</th>
				      <th class="text-center" scope="col">Spotkanie</th>
				      
				      <?php if ($zalogowany): ?>
				      	<th class="text-center" scope="col">Twój typ</th>
				      	<th class="text-center" scope="col">Pkt.</th>
				      <?php endif ?>
				      <th class="text-right" scope="col">Wynik meczu</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $lacznie = '0'; ?>
					<?php foreach ($mecze_z_grupy as $mecz): ?>
					<tr>
				      	<th><img src="<?php echo base_url().'assets/images/flags/'.$mecz['img']; ?>" width="20px"></th>
				      	<td><?php echo $mecz['data_meczu']; ?></td>
				      	<td class="text-center"><?php echo $mecz['gospodarz'] .' - '. $mecz['gosc']; ?></td>

				      	<?php if ($zalogowany): ?>
				      	<td class="text-center">
				      		<?php if (isset($mecz['wynik_gospodarz_wynik'])): ?>
				      			<?php echo $mecz['wynik_gospodarz_wynik'] .' - '. $mecz['wynik_gosc_wynik']; ?>
				      		<?php else: ?>
				      			- : -
				      		<?php endif ?>
				      		
				      	</td>
				      	<td class="text-center">
				      		<?php if (isset($mecz['wynik_pkt'])): ?>
				      			<?php echo $mecz['wynik_pkt']; ?>
				      			<?php $lacznie = $lacznie + $mecz['wynik_pkt'];?>
				      		<?php else: ?>
				      			-
				      		<?php endif ?>
				      		
				      	</td>
					    <?php endif ?>

				      	<td class="text-right font-weight-bold">
				      	<?php if ($mecz['gospodarz_wynik'] == ''): ?>
							- : -
				      	<?php else: ?>
							<?php echo $mecz['gospodarz_wynik'] .' : '. $mecz['gosc_wynik']; ?>
				      	<?php endif ?>

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
								    	<td></td>
								    	<td></td>
								    </tr>
						    	<?php endif ?>
						    <?php endforeach ?>
						    
						<?php endif ?>
				    
				<?php endforeach ?>
				 <?php if ($zalogowany): ?>
					      	
					      
				<tr class="inni-typy-suma">
				    	<td></td>
				    	<td></td>
				    	<td></td>
						<td class="text-center">Twoje punkty łcznie:</td>
				    	<td class="text-center"><?php echo $lacznie; ?></td>
				    	<td></td>
				    </tr> 
				    <?php endif ?>
					</tbody>
				</table>
			</div>

			<!-- mobile table -->

			<table class="table d-md-none">
			  
			  <tbody>
			  	<tr>
			      	<td class="pl-0 pr-0">
					  	<div class="float-left"><strong>Mecz (jego wynik)</strong></div>
						<div class="float-right"><strong>Twój typ i punkty</strong></div>
						<div class="clearfix"></div>
					  	<?php $lacznie = '0'; ?>
						<?php foreach ($mecze_z_grupy as $mecz): ?>
					</td>
				</tr>
					
				<tr>
			      	<td class="pl-0 pr-0">
			      		<div class="float-left">
			      			<img src="<?php echo base_url().'assets/images/flags/'.$mecz['img']; ?>" width="20px">
			      		</div>
			      		<div class="float-left ml-10">
			      			<?php echo $mecz['gospodarz'] .' - '. $mecz['gosc']; ?>
			      			<?php if ($mecz['gospodarz_wynik'] == ''): ?>
								<strong>- : -</strong>
					      	<?php else: ?>
								<strong class="ml-10"><?php echo $mecz['gospodarz_wynik'] .' : '. $mecz['gosc_wynik']; ?></strong>
					      	<?php endif ?><br>

					      	<div class="data-sm"><?php echo substr($mecz['data_meczu'], 0, -3); ?></div>


			      		</div>
			      		<div class="float-right text-right">
			      			
			      			<?php if ($zalogowany): ?>
				      			
					      		<?php if (isset($mecz['wynik_gospodarz_wynik'])): ?>
					      			<?php echo $mecz['wynik_gospodarz_wynik'] .' : '. $mecz['wynik_gosc_wynik']; ?>
					      		<?php else: ?>
					      			- : -
					      		<?php endif ?><br>

					      		<?php if (isset($mecz['wynik_pkt'])): ?>
					      			<div class="data-sm"><?php echo $mecz['wynik_pkt']; ?> pkt</div>
					      			<?php $lacznie = $lacznie + $mecz['wynik_pkt'];?>
					      		<?php else: ?>
					      			-
					      		<?php endif ?>
				      	
						    <?php endif ?>
			      		</div>
			      		<div class="clearfix"></div>
			      	

			      	</td>
			      	
			    </tr>

			    <?php if ($pokazuj_innych > 0): ?>
		    
					    <?php foreach ($aktywne_mecze_wyniki_obserwowanych as $row): ?>
					    	<?php if ($row['wynik_mecz_id'] == $mecz['mecz_id']): ?>
					    		<tr class="inni-typy-mobi">
							    	<td class="text-left">
							    		<small class="ml-20"><?php echo ucfirst($row['username']). ' '. ($row['wynik_gospodarz_wynik'] !== null ? $row['wynik_gospodarz_wynik'] : '- ') . ':' . ($row['wynik_gosc_wynik'] !== null ? $row['wynik_gosc_wynik'] : ' -') ?></small>
							    	</td>
							    </tr>
					    	<?php endif ?>
					    <?php endforeach ?>
					    <tr class="inni-typy-mobi-last">
					    	<td></td>
					    </tr>
					    
					<?php endif ?>
			    
			<?php endforeach ?>
			 <?php if ($zalogowany): ?>
				      	
				      
			<tr class="inni-typy-suma">
			    	
					<td class="text-right">Twoje punkty łcznie: <?php echo $lacznie; ?></td>
			    	
			    </tr> 
			    <?php endif ?>
				</tbody>
			</table>
			
		</div>
	</div>
	<hr><br><br>
	<div class="row">
		<div class="col-md-4 mb-50">
			<h5>Podsumowanie:</h5>
			<table class="table table-sm">
			 <thead>
			    <tr>
			      <th class="text-center" scope="col">#</th>
			      <th scope="col">Kto</th>
			      <th class="text-center" scope="col">Pkt.</th>
			      <th class="text-right" scope="col">zobacz</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i = 1; ?>
			  	<?php foreach ($podsumowanie as $rank): ?>
			  		<tr>
				      <th class="text-center"><?php echo $i; $i++;?></th>
				      <td><?php echo $rank['username']; ?></td>
				      <td class="text-center"><?php echo $rank['points']; ?></td>
				      <td class="text-right"><a class="badge badge-info" href="<?php echo base_url(); ?>typy/<?php echo $id.'/'.$rank['user_id']; ?>">typy</a></td>
				    </tr>
			  	<?php endforeach ?>
			  	
			    
			   
			  </tbody>
			</table>
		</div>

		<?php if ($typy_usera !== ''): ?>
			
		<div class="col-md-7 offset-md-1">
			<h5>Typy najlepszego - <?php echo $typy_usera[0]['username']; ?></h5>
			<table class="table table-sm">
			 <thead>
			    <tr>
			      <th scope="col">Mecz</th>
			      <th class="text-center" scope="col">wynik</th>
			      <th class="text-right" scope="col">Pkt.</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $lacznie_usera = 0 ?>
			  	<?php foreach ($typy_usera as $typy): ?>
			  		
			    <tr>
			      <td><?php echo $typy['gospodarz'] .' - '. $typy['gosc']; ?></td>
			      <td class="text-center"><?php echo $typy['gospodarz_wynik'] .' : '. $typy['gosc_wynik']; ?></td>
			      <td class="text-right"><?php echo $typy['wynik_pkt']; ?></td>
			    </tr>
			    <?php $lacznie_usera = $lacznie_usera + $typy['wynik_pkt']; ?>
			    <?php endforeach ?>
			   	<tr>
			      <td></td>
			      <td class="text-center"></td>
			      <td class="text-right"><?php echo $lacznie_usera; ?></td>
			    </tr>
			  </tbody>
			</table>
		</div>
		<?php endif ?>

	</div>
</div>