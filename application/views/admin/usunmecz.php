<div class="container">
	<br><br>
	<div class="row">
		<div class="col-12 text-center">
			<h4>Czy chcesz usunć ten mecz?</h4>
			<small><?php echo $mecz['data_meczu'];?></small>
			<h6><?php echo $mecz['gospodarz'] . ' - ' . $mecz['gosc'];?></h6><br>
			<a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>admin/usunmecz/<?php echo $mecz['mecz_id']; ?>?del=tak">Tak - usuń ten mecz</a>
		</div>
	</div>
</div>