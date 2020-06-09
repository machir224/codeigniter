<?php
$siteLang = $this->session->userdata('site_lang');
if (file_exists(APPPATH . "language/" . $siteLang . "/menu_lang.php")) {
    $this->lang->load('menu', $siteLang);
}
?>
<!-- Collect the nav links, forms, and other content for toggling -->

<div class="collapse navbar-collapse order-3" id="navbarCollapse">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item <?= ($this->router->class === "site" && $this->router->method === "index") ? "active" : "not-active" ?>"><a class="nav-link" href="<?php echo base_url(); ?>"><?php echo ucwords(lang('home')); ?></a></li>
        <li class="nav-item <?= ($this->router->method === "contact_us") ? "active" : "not-active" ?>"><a class="nav-link" href="<?php echo base_url('contact_us'); ?>"><?php echo ucwords(lang('contact_us')); ?></a></li>
        <li class="nav-item <?= ($this->router->method === "about_us") ? "active" : "not-active" ?>"><a class="nav-link" href="<?php echo base_url('about_us'); ?>"><?php echo ucwords(lang('about_us')); ?></a></li>
    </ul>
</div>
<!-- /.navbar-collapse -->
<!-- Navbar Right Menu -->
<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
    <!-- Language Dropdown Menu -->
    <li class="nav-item dropdown">
        <?php
        $site_languages_slug = $this->config->item('site_languages_slug');
        $site_languages = $this->config->item('site_languages');
        if (count($site_languages_slug) > 0 && count($site_languages) > 0) { ?>
            <a href="#" class="nav-link" data-toggle="dropdown">
                <i class="flag-icon flag-icon-<?= isset($site_languages_slug[$siteLang]) ? $site_languages_slug[$siteLang] : 'us'; ?>"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <?php
                foreach ($site_languages as $lang) {
                    if ($this->session->userdata('site_lang') != $lang) {
                ?>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>LanguageSwitcher/switchLang/<?php echo $lang; ?>"><i class="flag-icon flag-icon-<?= isset($site_languages_slug[$lang]) ? $site_languages_slug[$lang] : ''; ?> mr-2"></i><?php echo ucfirst($lang); ?></a>
                <?php
                    }
                }
                ?>
            </div>
        <?php }
        ?>
    </li>

    <?php
    if ($this->ion_auth->logged_in()) {
    ?>
        <!-- User Account Menu -->
        <li class="nav-item dropdown user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <!-- <img src="<?php echo base_url('assets'); ?>/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image"> -->
                <img src="<?php echo base_url('uploads'); ?>/images/profile/<?= $this->session->userdata('profile_pic'); ?>" class="user-image img-circle elevation-2" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <!-- <span class="d-none d-md-inline">Hiren Macwan</span> -->
                <span class="d-none d-md-inline"><?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- The user image in the menu -->
                <li class="user-header bg-primary">
                    <!-- <img src="<?php echo base_url('assets'); ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
                    <img src="<?php echo base_url('uploads'); ?>/images/profile/<?= $this->session->userdata('profile_pic'); ?>" class="img-circle elevation-2" alt="User Image">

                    <p>
                        <?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?>
                        <!-- Hiren Macwan - Web Developer -->
                        <!-- <small>Member since Nov. 2015</small> -->
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="<?= base_url('user/profile'); ?>" class="btn btn-default btn-flat"><?php echo ucwords(lang('profile')); ?></a>
                    <a href="<?php echo base_url('user/logout'); ?>" class="btn btn-default btn-flat float-right"><?php echo ucwords(lang('sign_out')); ?></a>
                </li>
            </ul>
        </li>
    <?php
    } else {
    ?>
        <!-- User Account Menu -->
        <li class="nav-item dropdown user-menu">
            <!-- Menu Toggle Button -->
            <a class="nav-link dropdown-toggle" href="<?php echo base_url('user') ?>">
                <!-- <a class="nav-link dropdown-toggle" data-toggle="modal" data-target="#loginModal" href="#"> -->
                <!-- The user image in the navbar-->
                <img src="<?php echo base_url('assets'); ?>/img/user.png" class="user-image img-circle elevation-2" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="d-none d-md-inline"><?php echo ucwords(lang('login')); ?></span>
            </a>
        </li>
    <?php
    }
    ?>

</ul>
<!-- /.navbar-custom-menu -->