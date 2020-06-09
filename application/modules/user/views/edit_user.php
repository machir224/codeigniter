<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"><?php echo lang('edit_user_subheading');?></h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="card-body">
        <?php echo form_open(uri_string());?>
        <div class="col-md-6 float-left">
          <div class="form-group">
            <label for="first_name"><?= lang('edit_user_fname_label');?></label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $user->first_name; ?>" required>
          </div>

          <div class="form-group">
            <label for="last_name"><?= lang('edit_user_lname_label');?></label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?= $user->last_name; ?>" required>
          </div>

          <div class="form-group">
            <label for="company"><?= lang('edit_user_company_label');?></label>
            <input type="text" name="company" id="company" class="form-control" value="<?= $user->company; ?>">
          </div>

          <div class="form-group">
            <label for="phone"><?= lang('edit_user_phone_label');?></label>
            <input type="text" name="phone" id="phone" class="form-control" value="<?= $user->phone; ?>" required>
          </div>  
        </div>
        <div class="col-md-6 float-left">
          <div class="form-group">
            <label for="password"><?= lang('edit_user_password_label');?></label>
            <input type="password" name="password" id="password" class="form-control">
          </div>

          <div class="form-group">
            <label for="password_confirm"><?= lang('edit_user_password_confirm_label');?></label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
          </div>

          <?php if ($this->ion_auth->is_admin()): ?>
          <div class="form-group">
            <label for="groups"><?= lang('edit_user_groups_heading');?></label>
            <select class="form-control" name="groups[]">
              <?php foreach ($groups as $group):?>
                <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) {
                      if ($gID == $grp->id) {
                          $checked= ' checked="checked"';
                      break;
                      }
                  }
                ?>
                <option value="<?php echo $group['id'];?>"><?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?></option>
              <?php endforeach ?>  
            </select>
          </div>
          <?php endif ?>  
        </div>
        <div class="clearfix"></div>

        <div class="form-group text-center">
          <?php echo form_hidden('id', $user->id);?>
          <?php echo form_hidden($csrf); ?>
          <?php echo form_submit('submit', lang('edit_user_submit_btn'), 'class="btn btn-success"');?>
          <a class="btn btn-warning" href="<?php echo base_url('user'); ?>"><?= lang('cancel'); ?></a>
        </div>
        <?php echo form_close();?>

      </div>
      <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
</div>