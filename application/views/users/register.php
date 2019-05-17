<?= validation_errors() ?>

<?= form_open('users/register') ?>
    <div class="row">
        <div class="col-md-4 offset-4">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="password_confirm">Password Confirm</label>
                <input type="password" class="form-control" name="password_confirm" placeholder="Enter password confirm">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
    </div>
<?= form_close() ?>
