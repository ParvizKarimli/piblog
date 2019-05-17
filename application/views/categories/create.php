<?= validation_errors() ?>

<?= form_open('categories/create') ?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter name">
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="<?= base_url() ?>categories" class="btn btn-outline-info">Cancel</a>
<?= form_close() ?>
