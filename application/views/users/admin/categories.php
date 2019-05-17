<h1>Categories created by @<?= $user->username ?></h1>
<h3><a href="<?= base_url() ?>categories/create">Create a new category</a></h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($categories as $category): ?>
            <tr>
                <td><?= $category->name ?></td>
                <td><?= $category->created_at ?></td>
                <td>
                    <a href="<?= base_url('categories/edit/' . $category->id) ?>">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </td>
                <td>
                    <a href="" onclick="
                        event.preventDefault();
                        if(confirm('Are you sure you want to delete?'))
                        {
                            document.getElementById('category-<?= $category->id ?>').submit();
                        }
                    ">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <?= form_open('categories/delete', array('id' => 'category-' . $category->id)) ?>
                        <input type="hidden" name="id" value="<?= $category->id ?>">
                    <?= form_close() ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
