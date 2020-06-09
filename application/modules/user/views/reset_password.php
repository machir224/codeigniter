<div class="row d-flex justify-content-center">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <form action="<?php echo base_url('user/reset_password/' . $code); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="password" name="new" id="new" pattern="^.{' <?php echo $this->data['min_password_length']; ?> '}.*$" class="form-control" placeholder="<?php echo lang('reset_password_validation_new_password_label'); ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="new_confirm" id="new_confirm" pattern="^.{' <?php echo $this->data['min_password_length']; ?> '}.*$" class="form-control" placeholder="<?php echo lang('reset_password_validation_new_password_confirm_label'); ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="user_id" id="user_id" value="<?= $user->id; ?>">
                            <?php echo form_hidden($csrf); ?>
                            <button type="submit" class="btn btn-primary btn-block"><?php echo lang('reset_password_submit_btn'); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="<?php echo base_url('user/login');?>">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</div>