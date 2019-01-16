<div class="container">
	<div class="row mt-80">
		<div class="col-lg-4 col-md-6 mb-30">
			<h4>Typy od poczatku</h4>
			<p>Dla wszytkich zakładów</p>
			
			<table class="table table-sm mt-30 table-hover">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">nick</th>
			      <th class="text-right" scope="col">pkt</th>
			    </tr>
			  </thead>
			  <tbody>
    
  			<?php $i = 1; ?>
			<?php foreach ($all_points as $row): ?>
				<tr>
			      <th scope="row"><?php echo $i; $i++; ?></th>
			      <td><?php echo $row['username']; ?></td>
			      <td class="text-right"><?php echo $row['sum_points']; ?></td>
			    </tr>
			<?php endforeach ?>

			</tbody>
			</table>
		</div>
		<div class="col-lg-4 col-md-6 mb-30">
			<h4>Typy ostatniej Kolejki</h4>
			<p><?php echo $group_name; ?></p>
			
			<?php if ($last_group): ?>
			<table class="table table-sm mt-30 table-hover">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">nick</th>
			      <th class="text-right" scope="col">pkt</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i = 1; ?>
				<?php foreach ($last_group as $row): ?>
				<tr>
			      <th scope="row"><?php echo $i; $i++; ?></th>
			      <td><?php echo $row['username']; ?></td>
			      <td class="text-right"><?php echo $row['sum_points']; ?></td>
			    </tr>
				<?php endforeach ?>
			    </tbody>
			</table>
			<?php endif ?>
		</div>
		<div class="col-lg-4 col-md-6 mb-30">
			<h4>Typy gdzie typował każdy gracz</h4>
			<small>Pokazuje tylko takie mecze gdzie typował każdy (min 10 typów)</small>

			<table class="table table-sm mt-30 table-hover">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">nick</th>
			      <th class="text-right" scope="col">pkt</th>
			    </tr>
			  </thead>
			  <tbody>
    
  			<?php $i = 1; ?>
			<?php foreach ($typowali_wszyscy as $row): ?>
				<tr>
			      <th scope="row"><?php echo $i; $i++; ?></th>
			      <td><?php echo $row['username']; ?></td>
			      <td class="text-right"><?php echo $row['pts']; ?></td>
			    </tr>
			<?php endforeach ?>

			</tbody>
			</table>

		</div>
	</div>
	<div class="row mt-50">
		<div class="col-lg-4 col-md-6 mb-30">
			<h4>Typy gdzie typowali wybrani gracze</h4>
			<?php if ($logged_in): ?>
				<p>Osoby wybrane w tym <a href="users_list">ustawieniu</a> - min. 1 pkt</p>
			<?php else: ?>
				<p>Zaloguj się aby wybrać osoby</p>
			<?php endif ?>
			
			<table class="table table-sm mt-30 table-hover">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">nick</th>
			      <th class="text-right" scope="col">pkt</th>
			    </tr>
			  </thead>
			  <tbody>
    
  			<?php $i = 1; ?>
			<?php foreach ($wybrani_points as $row): ?>
				<tr>
			      <th scope="row"><?php echo $i; $i++; ?></th>
			      <td><?php echo $row['username']; ?></td>
			      <td class="text-right"><?php echo $row['sum_points']; ?></td>
			    </tr>
			<?php endforeach ?>

			</tbody>
			</table>
		</div>
		<div class="col-lg-8 col-md-6 mb-30">
			<h4>Podział na ligi</h4>
			<p>Dla wszytkich zakładów</p>
			
			<table class="table table-sm mt-30 table-hover">
			  <thead>
			    <tr>
			      <th scope="col">liga</th>
			      <th scope="col">nick</th>
			      <th scope="col">pkt</th>
			      <th class="text-right" scope="col">więcej</th>
			    </tr>
			  </thead>
			  <tbody>
    
			<?php foreach ($ligi_dane as $liga): ?>
				<tr>
			      <td><img src="<?php echo base_url();?>/assets/images/flags/<?php echo $liga['img']; ?>" width="18px" class="mr-10"><?php echo $liga['name']; ?></td>
			      <td>
			      	<?php 
			      	foreach ($ligi as $key => $value) {
			      		if ($key == $liga['id_ligi']) {
			      			echo $ligi[$liga['id_ligi']][0]['username'];
			      		}
			      	} ?>
			      </td>
			      <td>
			      	<?php 
			      	foreach ($ligi as $key => $value) {
			      		if ($key == $liga['id_ligi']) {
			      			echo $ligi[$liga['id_ligi']][0]['pts'];
			      		}
			      	} ?>
			      </td>
			      <td class="text-right"><a class="badge badge-success" href="<?php echo base_url(); ?>ranking_lig/<?php echo $liga['id_ligi'] ?>">więcej</a></td>
			    </tr>
			<?php endforeach ?>

			</tbody>
			</table>
		</div>
		
	</div>
</div>