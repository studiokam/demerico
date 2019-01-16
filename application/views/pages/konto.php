<div class="container">

	<?php if ($this->session->flashdata('danger')): ?>
		<div class="danger mb-50 mt-50">
			<div class="alert alert-danger" role="alert">
  				<?php echo $this->session->flashdata('danger'); ?>
			</div>
		</div>
	<?php endif ?>
	
	<div class="row mt-50">
		<div class="col-md-5 mb-70">
			<h4 class="float-left"><?php echo ucfirst($this->session->userdata('username')); ?></h4>
			<a href="<?php echo base_url(); ?>users/logout" class="btn btn-danger btn-sm float-right">Wyloguj</a>
			<div class="clearfix"></div>
			
			<hr class="mb-20">
			<?php echo validation_errors(); ?>
			<?php echo form_open('konto'); ?>
				
				<div class="my-label">Email</div>
				<div class="form-group">
			   		<input type="email" class="form-control" name="email" value="<?php echo (set_value('email')? set_value('email') : $email); ?>">
				</div>
				  
				<div class="my-label">Hasło</div>
			  	<div class="form-group">
			    	<input type="password" class="form-control" name="password" placeholder="Podaj nowe hasło" value="<?php echo set_value('password'); ?>">
			  	</div>
			  	<div class="form-group">
			    	<input type="password" class="form-control" name="password2" placeholder="Podaj nowe hasło ponownie" value="<?php echo set_value('password'); ?>">
			  	</div>
			  	<button type="submit" class="btn-sm btn btn-success">Zapisz</button>
				
			</form>
		</div>
		<div class="col-md-6 offset-md-1">
			<h4>Domyślne ustawienia</h4>
			<hr class="mb-25">
			<form action="" method="get">		
				<label class="switch">
		          	<input type="checkbox" class="success" name="default" class="custom-control-input" value="<?php echo ($pokazuj_innych > 0 ? '0' : '1' ); ?>"  onchange="window.location.href='<?php echo base_url(); ?>konto?default=' + this.value;" <?php if($pokazuj_innych > 0) echo "checked ='checked'";?>>
		          	<span class="slider round"></span>
		        </label>
		        <label class ="cdustom-control-label" for="cuvstomControlAutosizing">Pokazuj jak typuj inni</label>
			</form>
			<small>Wybierz czy domyślnie pokazywać typy innych wybranych osób czy nie</small>
			<hr>
			Te osoby będa pokazywane <a href="<?php echo base_url(); ?>users_list" class="btn btn-sm btn-success float-right">Wybierz osoby</a>
			<p class="mt-30">
				<?php if ($obserwowani_ilsc > 0): ?>
					<?php foreach ($obserwowani as $obserwowany): ?>
						- <?php echo $obserwowany; ?><br>
					<?php endforeach ?>
				<?php else:?>
				Nie dodałeś jeszcze obserwowanych osób - aby włczyć pokazywanie innych, wybierz przynajmniej jedna 
				<?php endif ?>
				
			</p>
		</div>
	</div>
</div>