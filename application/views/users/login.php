<?= validation_errors() ?>

<?php if( ! empty($error)) { echo $error; } ?>

<?= form_open('users/login') ?>
    <div class="row">
        <div class="col-md-4 offset-4">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Enter username" autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
    </div>
<?= form_close() ?>
