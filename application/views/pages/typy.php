<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-12">
			<h4>Typy (<?php echo $username; ?>)</h4>

			<div class="d-none d-md-block">
				<table class="table">
				  <thead>
				    <tr>
				      	<th scope="col">Liga</th>
				      	<th scope="col">Data</th>
				      	<th class="text-center" scope="col">Spotkanie</th>
				      	<th class="text-center" scope="col">Typ</th>
				      	<th class="text-center" scope="col">Pkt.</th>
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

				      
					      	<td class="text-center">
					      		<?php if (isset($mecz['wynik_gospodarz_wynik'])): ?>
					      			<?php echo $mecz['wynik_gospodarz_wynik'] .' - '. $mecz['wynik_gosc_wynik']; ?>
					      		<?php else: ?>
					      			-
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

				      <td class="text-right font-weight-bold">
				      	<?php if ($mecz['gospodarz_wynik'] == ''): ?>
							- : -
				      	<?php else: ?>
							<?php echo $mecz['gospodarz_wynik'] .' : '. $mecz['gosc_wynik']; ?>
				      	<?php endif ?>
				      	
				      		
				      	</td>

				      	
				    </tr>
				    
				<?php endforeach ?>
					      	
					      
				<tr class="inni-typy-suma">
				    	<td></td>
				    	<td></td>
				    	<td></td>
						<td class="text-center">Twoje punkty łcznie:</td>
				    	<td class="text-center"><?php echo $lacznie; ?></td>
				    	<td></td>
				    </tr>
					</tbody>
				</table>
			</div>

			<!-- mobile table -->

			<div class="d-md-none">
				<table class="table">
				  <thead>
				    
				    <tr>
				      	<td class="pl-0 pr-0">
						  	<div class="float-left"><strong>Mecz (jego wynik)</strong></div>
							<div class="float-right"><strong>Typ i punkty</strong></div>
							<div class="clearfix"></div>
						</td>
					</tr>
				  </thead>
				  <tbody>
				  	<?php $lacznie = '0'; ?>
					<?php foreach ($mecze_z_grupy as $mecz): ?>
					<tr>
				      <td class="pl-0 pr-0">

						<div class="float-left">
			      			<img src="<?php echo base_url().'assets/images/flags/'.$mecz['img']; ?>" width="20px">
			      		</div>
			      		<div class="float-left ml-10">
			      			<?php echo $mecz['gospodarz'] .' - '. $mecz['gosc']; ?>
			      			<?php if (isset($mecz['wynik_gospodarz_wynik'])): ?>
					      		 <strong class="ml-10"><?php echo $mecz['wynik_gospodarz_wynik'] .' - '. $mecz['wynik_gosc_wynik']; ?></strong>
					      	<?php else: ?>
					      		<strong> - </strong>
					      	<?php endif ?><br>

					      	<div class="data-sm"><?php echo substr($mecz['data_meczu'], 0, -3); ?></div>

			      		</div>
			      		<div class="float-right text-right">
				      			
				      		<?php if ($mecz['gospodarz_wynik'] == ''): ?>
								- : -
					      	<?php else: ?>
								<?php echo $mecz['gospodarz_wynik'] .' : '. $mecz['gosc_wynik']; ?>
					      	<?php endif ?><br>

				      		<?php if (isset($mecz['wynik_pkt'])): ?>
				      			<div class="data-sm"><?php echo $mecz['wynik_pkt']; ?> pkt</div>
				      			<?php $lacznie = $lacznie + $mecz['wynik_pkt'];?>
				      		<?php else: ?>
				      			-
				      		<?php endif ?>
						    
			      		</div>
			      		<div class="clearfix"></div>
				      		
				      	</td>
				    </tr>
				    
				<?php endforeach ?>
					      	
					      
				<tr class="inni-typy-suma">
					<td class="text-right">Punkty łcznie: <?php echo $lacznie; ?></td>
			    </tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>

</div>