<?php if ($ligi): ?>
	<?php $i = 1; ?>
<div class="container">
	<div class="row mt-50">
		<div class="col-12">
			
			<h4>Ranking wszystkich typów </h4>
			<hr>
			<h4><img src="<?php echo site_url(); ?>assets/images/flags/<?php echo $ligi_dane[0]['img']; ?>" width="20px" class="mr-10"><?php echo $ligi_dane[0]['name']; ?></h4>
		</div>
	</div>
	<div class="row mt-50">
		
		<div class="col-md-6">
			<table class="table table-hover table-sm table-hover">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Nick</th>
			      <th scope="col" class="text-right">Pkt</th>
			    </tr>
			  </thead>
			  <tbody>

			  	<?php foreach ($ligi as $key => $value): ?>
					<?php foreach ($value as $val_key => $val_value): ?>
						<tr>
					      <th scope="row"><?php echo $i; $i++ ?></th>
					      <td><?php echo $val_value['username']; ?></td>
					      <td class="text-right"><?php echo $val_value['pts']; ?></td>
					    </tr>
					<?php endforeach ?>
				<?php endforeach ?>
			    
			  </tbody>
			</table>
		</div>
		<div class="col-md-6"></div>
	</div>
</div>
<?php else:?>
 
<div class="container">
	<div class="row">
		<div class="col-12">
			Nie ma jeszcze typów dla tej ligi
		</div>
	</div>
</div>
<?php endif ?>

