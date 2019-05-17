<h1>Comments written to the posts of @<?= $user->username ?></h1>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Body</th>
        <th>Name</th>
        <th>Email</th>
        <th>Post</th>
        <th>Created at</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($comments as $comment): ?>
            <tr>
                <td><?= $comment->body ?></td>
                <td><?= $comment->name ?></td>
                <td><?= $comment->email ?></td>
                <td>
                    <a href="<?= base_url('posts/' . $comment->post_id) ?>">
                        Post ID: <?= $comment->post_id ?>
                    </a>
                </td>
                <td><?= $comment->created_at ?></td>
                <td>
                    <a href="" onclick="
                        event.preventDefault();
                        if(confirm('Are you sure you want to delete?'))
                        {
                            document.getElementById('comment-<?= $comment->id ?>').submit();
                        }
                        ">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <?= form_open('comments/delete', array('id' => 'comment-' . $comment->id)) ?>
                        <input type="hidden" name="comment_id" value="<?= $comment->id ?>">
                        <input type="hidden" name="post_id" value="<?= $comment->post_id ?>">
                    <?= form_close() ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
