<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <?php echo validation_errors(); ?>

            <?php echo form_open('users/register'); ?>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nick</label>
                    <input type="text" class="form-control" name="username" placeholder="Nick" value="<?php echo set_value('username'); ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                    <small>- nie wymagamy potwierdzenia rejestracji</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Hasło</label>
                    <input type="password" class="form-control" name="password" placeholder="Hasło">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Powtórz Hasło</label>
                    <input type="password" class="form-control" name="password2" placeholder="Powtórz Hasło">
                </div>
                <button type="submit" class="btn btn-block btn-primary">Rejestruj</button>
            </form>

        </div>
    </div>
</div>