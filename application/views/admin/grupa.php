<div class="container">
	<br><br>
	<div class="row">
		<div class="col-12">
			<h4>Dodaj mecze do grupy</h4>
			<?php echo validation_errors(); ?>
			<?php echo form_open('admin/grupa/'.$id); ?>
			<div class="row">
				<div class="col-2">
					<div class="form-group">
						<label for="exampleFormControlSelect1">Liga</label>
						<select class="form-control" name="liga">
							<option value="">Wybierz ligę</option>
							<?php foreach ($ligi as $liga): ?>
								<option value="<?php echo $liga['id_ligi']; ?>" <?php echo  set_select('liga', $liga['id_ligi']); ?>><?php echo $liga['name']; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
	                    <label>Gospodarz</label>
	                    <input type="text" class="form-control" name="gospodarz" placeholder="" value="<?php echo set_value('gospodarz'); ?>">
	                </div>
				</div>
				<div class="col-3">
					<div class="form-group">
	                    <label>Gość</label>
	                    <input type="text" class="form-control" name="gosc" placeholder="" value="<?php echo set_value('gosc'); ?>">
	                </div>
				</div>
				<div class="col-2">
					<div class="form-group">
						<label for="exampleInputEmail1">Data spotkania</label>
						<input class="form-control" id="in_date" name="in_date" placeholder="(DD/MM/YYYY)" type="text" value="<?php echo set_value('in_date'); ?>" required/>
					</div>
				</div>
				<div class="col-2">
					<div class="form-group">
						<label for="exampleInputEmail1">Godzina</label>
						<input type="text" class="form-control" id="display_to_hours" name="display_to_hours" placeholder="HH:MM" value="<?php echo set_value('display_to_hours'); ?>" required>
						<script type="text/javascript">
							$('#display_to_hours').chungTimePicker({
								viewType: 1
							});
						</script>
					</div>
				</div>
			</div>
				
				
                

				
				<button type="submit" class="btn btn-sm btn-success float-right">Dodaj</button>
				<p class="clearfix"></p>
			</form>
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-9">
			
			<h4>Lista spotkań w tej grupie</h4>
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">Liga</th>
			      <th scope="col">Data</th>
			      <th class="text-center" scope="col">Spotkanie</th>
			      <th class="text-center" scope="col">Wynik</th>
			      <th class="text-right" scope="col">Opcje</th>
			    </tr>
			  </thead>
			  <tbody>
			<?php foreach ($mecze as $mecz): ?>
				<tr>
			      <th><img src="<?php echo base_url().'assets/images/flags/'.$mecz['img']; ?>" width="20px"></th>
			      <td><?php echo $mecz['data_meczu']; ?></td>
			      <td class="text-center"><?php echo $mecz['gospodarz'] .' - '. $mecz['gosc']; ?></td>
			      <td class="text-center">
			      	<?php if ($mecz['gospodarz_wynik'] == '' || $mecz['gosc_wynik'] == ''): ?>
			      		- : -
			      	<?php else: ?>
						<?php echo $mecz['gospodarz_wynik'] .' : '. $mecz['gosc_wynik']; ?>
			      	<?php endif ?>
			      </td>
			      <td class="text-right">
			      	<a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>admin/mecz/<?php echo $mecz['mecz_id']; ?>">Edytuj</a>
			      </td>
			    </tr>
			<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
