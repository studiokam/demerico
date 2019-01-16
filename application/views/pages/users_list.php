<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h4>Lista osób</h4>
			<table class="table">
				  <thead>
				    <tr>
				      <th scope="col">Nick</th>
				      <th class="text-right" scope="col">Pokazuj typy</th>
				    </tr>
				  </thead>
				  <tbody>
				    
				  
			<?php foreach ($users as $user): ?>
					<tr>
				      <td><?php echo $user['username']; ?></td>
				      <td>
				      	<form action="" method="get">		
							<label class="switch">
					          	<input type="checkbox" class="success" name="id" class="custom-control-input" value="<?php echo $user['id'] ?>"  onchange="window.location.href='<?php echo base_url(); ?>users_list?id=' + this.value;" <?php if(in_array($user['id'], $obserwowani)) echo "checked ='checked'";?>>
					          	<span class="slider round"></span>
					        </label>
						</form>
				      </td>
				    </tr>
			<?php endforeach ?>
				</tbody>
			</table>
		</div>
		
	</div>
</div>