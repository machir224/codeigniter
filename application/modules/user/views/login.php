<div class="row d-flex justify-content-center">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <form action="<?= base_url('user/login'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="identity" placeholder="<?php echo lang('login_identity_label'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="<?php echo lang('login_password_label'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    <?php echo lang('login_remember_label', 'remember'); ?>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block"><?php echo lang('login_submit_btn'); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1">
                    <a href="<?= base_url('user/forgot_password'); ?>"><?php echo lang('login_forgot_password'); ?></a>
                </p>
                <?php
                if (isset($site_settings) && $site_settings['registration_allowed'] == 1) {
                ?>
                    <p class="mb-0">
                        <a href="<?= base_url('user/register'); ?>" class="text-center"><?php echo lang('register'); ?></a>
                    </p>
                <?php
                }
                ?>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</div>