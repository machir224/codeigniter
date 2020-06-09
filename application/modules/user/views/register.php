<div class="row d-flex justify-content-center">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <form action="<?= base_url('user/register'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="first_name" placeholder="<?php echo lang('create_user_fname_label'); ?>" value="<?= set_value('first_name'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="last_name" placeholder="<?php echo lang('create_user_lname_label'); ?>" value="<?= set_value('last_name'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="phone" placeholder="<?php echo lang('create_user_phone_label'); ?>" value="<?= set_value('phone'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="<?php echo lang('create_user_email_label'); ?>" value="<?= set_value('email'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="<?php echo lang('create_user_password_label'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirm" placeholder="<?php echo lang('create_user_password_confirm_label'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block"><?php echo lang('register'); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1">
                    <a href="<?= base_url('user/forgot_password'); ?>"><?php echo lang('login_forgot_password'); ?></a>
                </p>
                <p class="mb-1">
                    <a href="<?= base_url('user/login'); ?>"><?php echo lang('login_submit_btn'); ?></a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</div>