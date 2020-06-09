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
                                <th><?php echo lang('index_status_th'); ?></th>
                                <th><?php echo lang('index_action_th'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

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
        var url = '<?php echo base_url(); ?>';
        var table = $('.users_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": url + "user/get_users",
            "oLanguage": {
                'sUrl': url + 'assets/plugins/datatables/language/<?php echo $this->session->userdata('site_lang'); ?>.json'
            }
        });

        $(document).on('click', '.deactivate_user', function() {
            var user_id = $(this).attr('data-user-id');
            var user_email = $(this).attr('data-user-email');
            $('#user_id').val(user_id);
            var sub_head = $('.deactivateModalSubHead').text().replace('{USERNAME}', user_email);
            $('.deactivateModalSubHead').text(sub_head);
        });

        $(document).on('click', '.delete_user', function() {
            var user_id = $(this).attr('data-user-id');
            var user_email = $(this).attr('data-user-email');
            $('#del_user_id').val(user_id);
            var sub_head = $('.deleteModalSubHead').text().replace('{USERNAME}', user_email);
            $('.deleteModalSubHead').text(sub_head);
        });
    });
</script>