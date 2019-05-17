<h1>@<?= $user->username ?></h1>
<p><b>Name: </b><?= $user->name ?></p>
<p><b>Created at: </b><?= $user->created_at ?></p>
<p><a href="<?= base_url('users/edit/' . $user->id) ?>">[Edit]</a></p>
