<?php foreach($posts as $post): ?>
    <div>
        <h3><?= $post->title ?></h3>
        <div class="row">
            <div class="col-md-12">
                <img src="<?= base_url('assets/images/posts/thumbnails/' . $post->thumbnail) ?>">
                <small class="post-date"><?= $post->created_at ?> in <strong><?= $post->name ?></strong></small>
                <div><?= word_limiter($post->body, 50) ?></div>
                <p><a href="<?= base_url('posts/' . $post->id . '/' . $post->slug)?>">Read More</a></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="text-center">
    <?= $this->pagination->create_links() ?>
</div>
