<div class="row">
	<div class="col-md-12">
		<div class="col-md-3">
			<!-- small box -->
			<div class="small-box bg-info">
				<div class="inner">
					<h3><?php echo isset($users) ? count($users) : 0; ?></h3>
					<p><?= ucwords(lang('users')); ?></p>
				</div>
				<div class="icon">
					<i class="fa fa-users"></i>
				</div>
				<a href="<?= base_url('user');?>" class="small-box-footer"><?= ucfirst(lang('more_info')); ?> <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
</div>	