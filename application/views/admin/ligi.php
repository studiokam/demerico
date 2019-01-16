<div class="container">
	
	<div class="row">
		<div class="col-md-4 mt-50">
			<h4>Ligi</h4>
			<br>
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">Img</th>
			      <th scope="col">Liga</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php foreach ($ligi as $liga): ?>
			  		<tr>
				      <td><img src="<?php echo base_url().'assets/images/flags/'.$liga['img']; ?>" width="20px"></td>
				      <td><?php echo $liga['name']; ?></td>
				    </tr>
			  	<?php endforeach ?>
			  </tbody>
			</table>
		</div>
		<div class="col-md-4 mt-50 offset-md-1">
			<h4>Dodaj Ligę</h4>
			

			<?php echo validation_errors(); ?>

            <?php echo form_open_multipart('admin/ligi'); ?>
                <div class="form-group">
                    <div class="my-label">Liga</div>
                    <input type="text" class="form-control" name="name" placeholder="Nazwa ligi np. Bundesliga" value="<?php echo set_value('name'); ?>">
                </div>
                <fieldset>
                  <div class="custom-file w-100">
                    <input type="file" class="custom-file-input" name="ligalogo" required>
                    <label class="custom-file-label" for="customFile">Wybierz plik...</label>
                  </div>
                </fieldset><br>
                <button type="submit" class="btn btn-success">Dodaj</button>
            </form>

		</div>
	</div>
</div>