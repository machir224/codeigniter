<!-- Sidebar user panel -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <!-- <img src="<?php echo base_url('assets'); ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        <img src="<?php echo base_url('uploads'); ?>/images/profile/<?= $this->session->userdata('profile_pic');?>" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <!-- <a href="#" class="d-block">Hiren Macwan</a> -->
        <a href="<?= base_url('user/profile')?>" class="d-block"><?= $this->session->userdata('first_name').' '.$this->session->userdata('last_name'); ?></a>
    </div>
</div>

<!-- sidebar menu: : style can be found in sidebar.less -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
            <a class="nav-link <?= ($this->router->class === "dashboard") ? "active" : "not-active" ?>" href="<?= base_url('dashboard'); ?>">
                <i class="fa fa-dashboard nav-icon"></i>
                <p><?= ucwords(lang('dashboard')); ?></p>
            </a>
        </li>

        <?php if ($this->ion_auth->is_admin()) { ?>
            <li class="nav-item">
                <a class="nav-link <?= ($this->router->class === "user" || $this->router->method === "create_user" || $this->router->method === "edit_user") ? "active" : "not-active" ?>" href="<?= base_url('user'); ?>">
                    <i class="fa fa-users nav-icon"></i>
                    <p><?= ucwords(lang('users')); ?></p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($this->router->class === "settings") ? "active" : "not-active" ?>" href="<?= base_url('settings'); ?>">
                    <i class="fa fa-gear nav-icon"></i>
                    <p><?= ucwords(lang('settings')); ?></p>
                </a>
            </li>

        <?php } ?>

    </ul>
</nav>