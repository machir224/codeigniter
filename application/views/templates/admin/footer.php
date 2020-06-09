      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2019-<?= date('Y'); ?> <a href="#">Confidosoft</a>.</strong> All rights
    reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>HM</b>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets');?>/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url('assets');?>/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets');?>/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets');?>/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url('assets');?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets');?>/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets');?>/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets');?>/js/demo.js"></script>
</body>
</html>