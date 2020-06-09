<div class="row d-flex justify-content-center">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                    <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
                </p>

                <form action="<?php echo base_url('user/forgot_password'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="identity" placeholder="<?php echo lang('login_identity_label'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block"><?php echo lang('forgot_password_submit_btn'); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="<?php echo base_url('user/login') ?>"><?php echo lang('login_submit_btn'); ?></a>
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