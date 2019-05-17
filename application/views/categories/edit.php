<?= validation_errors() ?>

<?= form_open('categories/edit/' . $category->id) ?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?= set_value('name', $category->name) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url() ?>categories" class="btn btn-outline-info">Cancel</a>
<?= form_close() ?>
