<ul class="list-group">
    <?php foreach($categories as $category): ?>
        <li class="list-group-item">
            <a href="<?= base_url('categories/' . $category->id) ?>">
                <?= $category->name ?>
            </a>
            <?php if($this->session->userdata('user_id') === $category->user_id): ?>
                <a class="btn btn-warning" href="<?= base_url('categories/edit/' . $category->id) ?>">
                    Edit
                </a>
                <a class="btn btn-danger" href="#"
                   onclick="
                           if(confirm('Are you sure you want to delete?'))
                           {
                                document.getElementById('category-<?= $category->id ?>').submit();
                           }
                   "
                >Delete</a>
                <?= form_open('categories/delete', array('id' => 'category-' . $category->id)) ?>
                    <input type="hidden" name="id" value="<?= $category->id ?>">
                <?= form_close() ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
