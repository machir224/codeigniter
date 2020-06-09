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
            <?php echo lang('edit_user_fname_label', 'first_name');?>
            <?php echo form_input($first_name);?>
          </div>

          <div class="form-group">
            <?php echo lang('edit_user_lname_label', 'last_name');?>
            <?php echo form_input($last_name);?>
          </div>

          <div class="form-group">
            <?php echo lang('edit_user_company_label', 'company');?>
            <?php echo form_input($company);?>
          </div>

          <div class="form-group">
            <?php echo lang('edit_user_phone_label', 'phone');?>
            <?php echo form_input($phone);?>
          </div>  
        </div>
        <div class="col-md-6 float-left">
          <div class="form-group">
            <?php echo lang('edit_user_password_label', 'password');?>
            <?php echo form_input($password);?>
          </div>

          <div class="form-group">
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
            <?php echo form_input($password_confirm);?>
          </div>

          <?php if ($this->ion_auth->is_admin()): ?>
            <h3><?php echo lang('edit_user_groups_heading');?></h3>
            <?php foreach ($groups as $group):?>
              <div class="form-check form-check-inline">
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
                <input type="checkbox" name="groups[]" class="form-check-input" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                <label class="form-check-label">
                  <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                </label>
              </div>
            <?php endforeach?>
          <?php endif ?>  
        </div>

        <div class="form-group">
          <?php echo form_hidden('id', $user->id);?>
          <?php echo form_hidden($csrf); ?>
          <?php echo form_submit('submit', lang('edit_user_submit_btn'), 'class="btn btn-success"');?>
          <?php echo form_button('cancel', 'Cancel', 'class="btn btn-warning"');?>
        </div>
        <?php echo form_close();?>

      </div>
      <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
</div>