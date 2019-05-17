    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?= base_url('admin/user') ?>">
                        <i class="fas fa-user fa-fw"></i>
                        User
                    </a>
                </li>
                <?php if($this->session->userdata('username') === 'admin'): ?>
                    <li>
                        <a href="<?= base_url('admin/users') ?>">
                            <i class="fas fa-users fa-fw"></i>
                            Users
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?= base_url('admin/categories') ?>">
                        <i class="fas fa-newspaper fa-fw"></i>
                        Categories
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/posts') ?>">
                        <i class="fas fa-file-alt fa-fw"></i>
                        Posts
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/comments') ?>">
                        <i class="fas fa-comments fa-fw"></i>
                        Comments
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>

    <div id="page-wrapper">
