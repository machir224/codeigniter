<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
  <ul class="nav navbar-nav">
    <li class="<?=($this->router->method==="index" || $this->router->method==="home")?"active":"not-active"?>"><a href="<?php echo base_url(); ?>">Home</a></li>
    <li class="<?=($this->router->method==="contact_us")?"active":"not-active"?>"><a href="<?php echo base_url('contact_us'); ?>">Contact Us</a></li>
    <li class="<?=($this->router->method==="about_us")?"active":"not-active"?>"><a href="<?php echo base_url('about_us'); ?>">About Us</a></li>
    <!-- <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li class="divider"></li>
        <li><a href="#">Separated link</a></li>
        <li class="divider"></li>
        <li><a href="#">One more separated link</a></li>
      </ul>
    </li> -->
  </ul>
</div>
<!-- /.navbar-collapse -->
<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <!-- <select class="form-control" onchange="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/'+this.value;">
        <option value="english" <?php if($this->session->userdata('site_lang') == 'english') echo 'selected="selected"'; ?>>English</option>
        <option value="arabic" <?php if($this->session->userdata('site_lang') == 'arabic') echo 'selected="selected"'; ?>>Arabic</option>
      </select> -->
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ucfirst($this->session->userdata('site_lang')); ?> <span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu">
        <?php
        $site_languages = $this->config->item('site_languages');
        $lang_count = 1;
        if(count($site_languages) > 0){
          foreach ($site_languages as $lang) {
            if($this->session->userdata('site_lang') != $lang){
              ?>
              <li><a href="<?php echo base_url(); ?>LanguageSwitcher/switchLang/<?php echo $lang; ?>"><?php echo ucfirst($lang); ?></a></li>  
              <?php
            }
            if($lang_count > 1 && $lang_count < count($site_languages)){
              ?>
              <li class="divider"></li>
              <?php
            }
            $lang_count++;
          }
        }
        ?>
        <!-- <li><a href="<?php echo base_url(); ?>LanguageSwitcher/switchLang/english">English</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url(); ?>LanguageSwitcher/switchLang/arabic">Arabic</a></li> -->
      </ul>
    </li>
    <!-- User Account Menu -->
    <li class="dropdown user user-menu">
      <!-- Menu Toggle Button -->
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
        <img src="<?php echo base_url('assets');?>/img/user2-160x160.jpg" class="user-image" alt="User Image">
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">Alexander Pierce</span>
      </a>
      <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
          <img src="<?php echo base_url('assets');?>/img/user2-160x160.jpg" class="img-circle" alt="User Image">

          <p>
            Hiren Macwan - Web Developer
            <small>Member since Nov. 2015</small>
          </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
          <div class="row">
            <div class="col-xs-4 text-center">
              <a href="#">Followers</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Sales</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Friends</a>
            </div>
          </div>
          <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="pull-left">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
          </div>
          <div class="pull-right">
            <a href="#" class="btn btn-default btn-flat">Sign out</a>
          </div>
        </li>
      </ul>
    </li>
  </ul>
</div>
<!-- /.navbar-custom-menu -->