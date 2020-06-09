<div class="row">
    <!-- <div class="col-md-12 text-center mb-1">
        <a href="<?= base_url('user/create_user'); ?>" class="btn btn-primary"><?= lang('index_create_user_link') ?></a>
    </div> -->
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url('user/create_user'); ?>" class="btn btn-warning"><i class="fa fa-plus"></i> <i class="fa fa-user"></i> <?= lang('index_create_user_link'); ?></a>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="users_container table-responsive">
                    <table class="users_table table table-bordered table-striped rounded">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('index_fname_th'); ?></th>
                                <th><?php echo lang('index_lname_th'); ?></th>
                                <th><?php echo lang('index_email_th'); ?></th>
                                <!-- <th><?php echo lang('index_groups_th'); ?></th> -->
                                <th><?php echo lang('index_status_th'); ?></th>
                                <th><?php echo lang('index_action_th'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($users as $user) { ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <!-- <td>
							<?php foreach ($user->groups as $group) : ?>
							<?php echo anchor("user/edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><br />
							<?php endforeach ?>
							</td> -->
                                    <!-- <td><?php echo ($user->active) ? anchor("user/deactivate/" . $user->id, lang('index_active_link'), "class='btn btn-success'") : anchor("user/activate/" . $user->id, lang('index_inactive_link'), "class='btn btn-warning'"); ?></td> -->
                                    <td><?php echo ($user->active) ? '<button type="button" class="btn btn-success deactivate_user" data-user-id ="' . $user->id . '" data-user-email ="' . $user->email . '" data-toggle="modal" data-target="#deactivateUserModal">' . lang('index_active_link') . '</button>' : anchor("user/activate/" . $user->id, lang('index_inactive_link'), "class='btn btn-warning'"); ?></td>
                                    <td>
                                        <?php echo anchor("user/edit_user/" . $user->id, '<i class="fa fa-pencil"></i>', "class='btn btn-info'"); ?>
                                        <?php //echo anchor("user/delete_user/".$user->id, '<i class="fa fa-trash"></i>', "class='btn btn-danger'") ;
                                        ?>
                                        <?php echo '<a href="#" class="btn btn-danger delete_user" data-user-id ="' . $user->id . '" data-user-email ="' . $user->email . '" data-toggle="modal" data-target="#deleteUserModal"><i class="fa fa-trash"></i></a>'; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deactivateUserModal" tabindex="-1" role="dialog" aria-labelledby="deactivateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('user/deactivate'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deactivateUserModalLabel"><?php echo lang('deactivate_heading'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <p class="deactivateModalSubHead"><?php echo sprintf(lang('deactivate_subheading'), '{USERNAME}'); ?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="user_id">
                    <input type="hidden" name="confirm" value="yes">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?= lang('deactivate_submit_btn'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('user/delete_user'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel"><?php echo lang('delete_heading'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <p class="deleteModalSubHead"><?php echo sprintf(lang('delete_subheading'), '{USERNAME}'); ?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="del_user_id">
                    <input type="hidden" name="confirm" value="yes">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?= lang('delete_submit_btn'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <p><?php echo anchor('user/create_user', lang('index_create_user_link')) ?> | <?php echo anchor('user/create_group', lang('index_create_group_link')) ?></p> -->

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('.users_table').DataTable();
        $('.deactivate_user').click(function() {
            var user_id = $(this).attr('data-user-id');
            var user_email = $(this).attr('data-user-email');
            $('#user_id').val(user_id);
            var sub_head = $('.deactivateModalSubHead').text().replace('{USERNAME}', user_email);
            $('.deactivateModalSubHead').text(sub_head);
        });

        $('.delete_user').click(function() {
            var user_id = $(this).attr('data-user-id');
            var user_email = $(this).attr('data-user-email');
            $('#del_user_id').val(user_id);
            var sub_head = $('.deleteModalSubHead').text().replace('{USERNAME}', user_email);
            $('.deleteModalSubHead').text(sub_head);
        });
    });
</script>