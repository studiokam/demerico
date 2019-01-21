<div class="container">
	<br><br>
	<div class="row">

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
