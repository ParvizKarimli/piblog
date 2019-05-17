<small class="post-date"><?= $post->created_at ?> in <strong><?= $category ?></strong></small>
<img class="post-image" src="<?= base_url('assets/images/posts/' . $post->image) ?>">
<div><?= $post->body ?></div>
<?php if($this->session->userdata('user_id') === $post->user_id): ?>
    <a class="btn btn-warning" href="<?= base_url('posts/edit/' . $post->id . '/' . $post->slug) ?>">Edit</a>
    <a class="btn btn-danger" href="#"
       onclick="
            if(confirm('Are you sure you want to delete?'))
            {
                document.getElementById('post-<?= $post->id ?>').submit();
            }
       "
    >Delete</a>
    <?= form_open('posts/delete', array('id' => 'post-' . $post->id)) ?>
        <input type="hidden" name="id" value="<?= $post->id ?>">
    <?= form_close() ?>
<?php endif; ?>

<hr>

<h3>Comments</h3>

<?php foreach($comments as $comment): ?>
    <h5><?= $comment->body ?> [by <strong><?= $comment->name ?></strong>]
        <?php if($this->session->userdata('user_id') === $post->user_id): ?>
            <a class="btn-danger" href="#"
               onclick="
                       if(confirm('Are you sure you want to delete?'))
                       {
                       document.getElementById('comment-<?= $comment->id ?>').submit();
                       }
                       "
            >[X]</a>
            <?= form_open('comments/delete', array('id' => 'comment-' . $comment->id)) ?>
                <input type="hidden" name="comment_id" value="<?= $comment->id ?>">
                <input type="hidden" name="post_id" value="<?= $post->id ?>">
            <?= form_close() ?>
        <?php endif; ?>
    </h5>
<?php endforeach; ?>

<hr>

<h3>Add Comment</h3>

<?= validation_errors() ?>

<?= form_open('comments/create') ?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter name">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="body">Body</label>
        <textarea class="form-control" name="body" placeholder="Enter body"></textarea>
    </div>
    <input type="hidden" name="post_id" value="<?= $post->id ?>">
    <input type="hidden" name="post_slug" value="<?= $post->slug ?>">
    <button type="submit" class="btn btn-primary">Submit</button>
<?= form_close() ?>
