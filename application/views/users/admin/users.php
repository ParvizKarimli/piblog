<h1>Users</h1>
<table class="table table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Username</th>
        <th>Created at</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->username ?></td>
            <td><?= $user->name ?></td>
            <td><?= $user->created_at ?></td>
            <td>
                <a href="<?= base_url('users/edit/' . $user->id) ?>">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </td>
            <td>
                <a href="" onclick="
                    event.preventDefault();
                    if(confirm('Are you sure you want to delete?'))
                    {
                        document.getElementById('user-<?= $user->id ?>').submit();
                    }
                ">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <?= form_open('users/delete', array('id' => 'user-' . $user->id)) ?>
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                <?= form_close() ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
