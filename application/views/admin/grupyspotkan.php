<div class="container">
	<div class="row">
		<div class="col-12">
			<br><br>
			<h4>Dodaj nowa grupę</h4>
			<p>Na tej stronie dodajesz nowe mecze do typowania. Najpierw trzeba wybrać datę - data jest jednakowa dla wszsytkich spotkań czyli dodaj w danej dacie np. środowe i wtorkowe mecze LM lub tylko środowe jeśli tak wolisz. Dla rozgrywek ligowych w weekendy podaj jedn datę i do niej wszystkie mecze.</p>
			<hr>
		</div>
	</div><br><br>
	<div class="row">
		<div class="col-md-4">
			<h4>Dodaj</h4>
			<?php echo validation_errors(); ?>
			<?php echo form_open('admin/grupyspotkan'); ?>
				<div class="form-group">
                    <label for="exampleInputEmail1">Nadaj nazwę dla grupy spotkań </label>
                    <input type="text" class="form-control" name="name" placeholder="Nick" value="<?php echo set_value('name'); ?>">
                    <small>Obecny nr. weekendu to: <strong>Week <?php echo date('W', time()); ?></strong></small>
                </div>
				<button type="submit" class="btn btn-sm btn-success">Dodaj</button>
			</form>
		</div>
		<div class="col-md-7 offset-md-1">
			<h4>Lista dodanych grup</h4>
			<?php foreach ($grupy as $grupa): ?>
				<div class="grupa">
					<h6><?php echo $grupa['name']; ?></h5>
					<p>Data dodania: <?php echo $grupa['create_at']; ?></p>
					<a href="<?php echo base_url(); ?>admin/grupa/<?php echo $grupa['id']; ?>" class="btn btn-sm btn-success">Zobacz</a>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
