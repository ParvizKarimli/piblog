<?= validation_errors() ?>

<?= form_open('users/edit/' . $user->id) ?>
<div class="row">
    <div class="col-md-4 offset-4">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?= set_value('name', $user->name) ?>">
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter username" value="<?= set_value('username', $user->username) ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password">
        </div>
        <div class="form-group">
            <label for="password_confirm">Password Confirm</label>
            <input type="password" class="form-control" name="password_confirm" placeholder="Enter password confirm">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Update</button>
        <a href="<?= base_url('admin/user') ?>" class="btn btn-outline-info btn-block">Cancel</a>
    </div>
</div>
<?= form_close() ?>
