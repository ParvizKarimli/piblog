<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><i class="fas fa-home"></i> piBlog</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fas fa-user fa-fw"></i>
                        <?= $username ?>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="/admin">
                            <i class="fas fa-tachometer-alt fa-fw"></i> Admin Panel
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-fw"></i>
                             Log Out
                        </a>
                        <?php $this->load->helper('form'); ?>
                        <?= form_open('users/logout', array('id' => 'logout-form')) ?>
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">
                        <?= form_close() ?>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
