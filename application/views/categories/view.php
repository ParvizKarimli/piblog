<?php foreach($category_posts as $category_post): ?>
    <div>
        <h3><?= $category_post->title ?></h3>
        <div class="row">
            <div class="col-md-12">
                <img src="<?= base_url('assets/images/posts/thumbnails/' . $category_post->thumbnail) ?>">
                <small class="post-date"><?= $category_post->created_at ?></small>
                <div><?= word_limiter($category_post->body, 50) ?></div>
                <p><a href="<?= base_url('posts/' . $category_post->id . '/' . $category_post->slug)?>">Read More</a></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="text-center">
    <?= $this->pagination->create_links() ?>
</div>
