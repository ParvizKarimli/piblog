<h1>Posts created by @<?= $user->username ?></h1>
<h3><a href="<?= base_url() ?>posts/create">Create a new post</a></h3>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Title</th>
        <th>Body</th>
        <th>Category</th>
        <th>Thumbnail</th>
        <th>Created at</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
            <tr>
                <td>
                    <a href="<?= base_url('posts/' . $post->id . '/' . $post->slug) ?>">
                        <?= $post->title ?>
                    </a>
                </td>
                <td><?= word_limiter($post->body, 5) ?></td>
                <td><?= $post->name ?></td>
                <td>
                    <img src="<?= base_url('assets/images/posts/thumbnails/' . $post->thumbnail) ?>">
                </td>
                <td><?= $post->created_at ?></td>
                <td>
                    <a href="<?= base_url('posts/edit/' . $post->id . '/' . $post->slug) ?>">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </td>
                <td>
                    <a href="" onclick="
                        event.preventDefault();
                        if(confirm('Are you sure you want to delete?'))
                        {
                            document.getElementById('post-<?= $post->id ?>').submit();
                        }
                    ">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <?= form_open('posts/delete', array('id' => 'post-' . $post->id)) ?>
                        <input type="hidden" name="id" value="<?= $post->id ?>">
                    <?= form_close() ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
