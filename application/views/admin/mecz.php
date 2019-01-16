<div class="container"><br><br>
	<div class="row">
		<div class="col-12 text-center">
			<h4>Edycja wyniku meczu</h4>
			<a class="badge badge-danger" href="<?php echo base_url(); ?>admin/usunmecz/<?php echo $mecz['mecz_id']; ?>">Usuń ten mecz</a>
			<br>
			<br>
			<img src="<?php echo base_url().'assets/images/flags/'.$mecz['img']; ?>" width="42px"><br>
			<?php echo $mecz['data_meczu']; ?><br><br>
			

		</div> 
		<div class="col-12">
			<?php echo validation_errors(); ?>
			<?php echo form_open('admin/mecz/'.$mecz['mecz_id']); ?>
			<div class="row">
				<div class="col-12 text-center">
					<h4><?php echo $mecz['gospodarz'] . ' - ' . $mecz['gosc']; ?></h4>
				</div>
			</div>
			<div class="row">
				
				<div class="col-1 offset-5">
					<div class="form-group">
	                    <input type="text" class="form-control text-center font-weight-bold" name="gospodarz_wynik" placeholder="" value="<?php echo $mecz['gospodarz_wynik']; ?>">
	                </div>
				</div>
				<div class="col-1">
					<div class="form-group">
	                    <input type="text" class="form-control text-center font-weight-bold" name="gosc_wynik" placeholder="" value="<?php echo $mecz['gosc_wynik']; ?>">
	                </div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-2 offset-5 text-center">
					<button type="submit" class="btn btn-block btn-success">Zapisz</button>
				</div>
			</div>
				
			</form>
		</div>
	</div>
</div>