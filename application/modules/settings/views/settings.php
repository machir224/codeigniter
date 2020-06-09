<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart(uri_string()); ?>
                <?php
                if (isset($settings) && !empty($settings)) {
                    foreach ($settings as $setting) {
                        if ($setting->key_name == 'registration_allowed') {
                ?>
                            <div class="form-group row">
                                <label for="<?= $setting->key_name; ?>" class="col-sm-2"><?= lang($setting->key_name); ?></label>
                                <div class="col-sm-8">
                                    <select name="<?= $setting->key_name; ?>" class="form-control" required>
                                        <option value="0" <?php if ($setting->value == 0)  echo 'selected'; ?>><?= lang('no'); ?></option>
                                        <option value="1" <?php if ($setting->value == 1)  echo 'selected'; ?>><?= lang('yes'); ?></option>
                                    </select>
                                </div>
                            </div>
                        <?php
                        } elseif ($setting->key_name == 'logo') {
                        ?>
                            <div class="form-group row">
                                <label for="<?= $setting->key_name; ?>" class="col-sm-2"><?= lang($setting->key_name); ?></label>
                                <div class="col-sm-8 text-center">
                                    <div class="mb-3 pt-1">
                                        <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('assets'); ?>/img/company/<?= ($setting->value && file_exists(FCPATH . 'assets/img/company/' . $setting->value)) ? $setting->value : 'logo.png'; ?>" alt="Company Logo">
                                    </div>
                                    <label class="btn btn-primary"><?= lang('change_logo'); ?>
                                        <input type="file" name="<?= $setting->key_name; ?>" hidden>
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="old_logo" value="<?= $setting->value; ?>">
                        <?php
                        } else {
                        ?>
                            <div class="form-group row">
                                <label for="<?= $setting->key_name; ?>" class="col-sm-2"><?= lang($setting->key_name); ?></label>
                                <div class="col-sm-8">
                                    <input type="<?= ($setting->key_name == 'admin_email') ? 'email' : 'text'; ?>" name="<?= $setting->key_name; ?>" id="<?= $setting->key_name; ?>" class="form-control" value="<?= $setting->value; ?>" required>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>
                <div class="form-group text-center">
                    <?php echo form_hidden($csrf); ?>
                    <?php echo form_submit('submit', lang('save'), 'class="btn btn-success"'); ?>
                    <a class="btn btn-warning" href="<?php echo base_url('dashboard'); ?>"><?= lang('cancel'); ?></a>
                </div>
                <?php echo form_close(); ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>