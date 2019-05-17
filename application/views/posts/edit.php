<?= validation_errors() ?>

<?= form_open_multipart('posts/edit/' . $post->id) ?>
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Enter title" value="<?= set_value('title', $post->title) ?>">
    </div>
    <div class="form-group">
        <label for="body">Body</label>
        <textarea class="form-control" name="body" placeholder="Enter body"><?= set_value('body', $post->body) ?></textarea>
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select class="form-control" name="category_id">
            <option value="<?= FALSE ?>">-- Select category --</option>
            <?php foreach($categories as $category): ?>
                <option value="<?= $category->id ?>"
                    <?php if($post->category_id === $category->id): ?>
                        <?= 'selected' ?>
                    <?php endif; ?>
                ><?= $category->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="userfile">Upload Image</label><br>
        <input type="file" name="userfile">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url('posts/' . $post->id . '/' . $post->slug) ?>" class="btn btn-outline-info">Cancel</a>
<?= form_close() ?>
