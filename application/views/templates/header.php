<html>
<head>
    <title>piBlog</title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= base_url() ?>">piBlog</a>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>posts">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>categories">Categories</a>
                </li>
            </ul>
            <ul class="navbar-nav navbar-right">
                <?php if( ! $this->session->userdata('logged_in')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>users/login">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>users/register">Register</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>admin">
                            Admin Panel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('users/' . $this->session->userdata('username')) ?>">
                            <?= $this->session->userdata('username') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>posts/create">Create Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>categories/create">Create Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" onclick="
                            event.preventDefault();
                            document.getElementById('user-log-out').submit();
                        ">
                            Log out
                        </a>
                        <?php $this->load->helper('form'); ?>
                        <?= form_open('users/logout', array('id' => 'user-log-out')) ?>
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">
                        <?= form_close() ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <h1 class="text-center"><?= $title ?></h1>
    <div class="container">
        <!-- Flash messages -->
        <?php if($this->session->flashdata('user_registered')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('user_registered') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('user_updated')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('user_updated') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('user_loggedin')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('user_loggedin') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('login_failed')): ?>
            <p class="alert alert-danger"><?= $this->session->flashdata('login_failed') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('user_loggedout')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('user_loggedout') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('post_created')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('post_created') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('post_updated')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('post_updated') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('post_deleted')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('post_deleted') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('category_created')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('category_created') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('category_updated')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('category_updated') ?></p>
        <?php endif; ?>

        <?php if($this->session->flashdata('category_deleted')): ?>
            <p class="alert alert-success"><?= $this->session->flashdata('category_deleted') ?></p>
        <?php endif; ?>
