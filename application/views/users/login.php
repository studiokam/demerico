<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <?php echo validation_errors(); ?>

            <?php echo form_open('users/login'); ?>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nick</label>
                    <input type="text" class="form-control" name="username" placeholder="Nick">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Hasło</label>
                    <input type="password" class="form-control" name="password" placeholder="Hasło">
                </div>
                <button type="submit" class="btn btn-block btn-info">| Zaloguj</button>
            </form>

        </div>
    </div>
</div>