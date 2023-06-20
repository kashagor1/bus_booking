</div>
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url();?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url();?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url();?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url();?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url();?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url();?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url();?>assets/dist/js/pages/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#myTable').DataTable();


  $('#dtBasicExample').DataTable();
$('#rlist').DataTable();



  


  
    
  $(document).on('click', '.update_company_info', function() {
    var c_id = $(this).attr("c_id");
    console.log(c_id);
    $.post("<?php echo base_url()?>dashboard/company_edit_info", {cid: c_id}, function(data) {
        console.log(data);
         $('#edit_company_phone').val(data.company_phone);
         $('#edit_company_name').val(data.company_name);
         $('#edit_company_address').val(data.company_address);
         $('#ce_id').val(data.id);
    }, "JSON");
});




  $(document).on('click', '.update_route_info', function() {
    var r_id = $(this).attr("c_id");
    console.log(r_id);
    $.post("<?php echo base_url()?>dashboard/route_edit_info", {cid: r_id}, function(data) {
        console.log(data);
         $('#edit_r_name').val(data.route_name);
         $('#edit_r_fare').val(data.fare);
        $('#edit_point_type').val(data.point_type);
         $('#re_id').val(data.id);
    }, "JSON");
});



$(document).on('click', '.add-section', function() {
            var clonedSection = $(this).closest('.section-container').clone();
            clonedSection.find('input[type="text"], input[type="number"]').val('');
            $(this).closest('.section-container').after(clonedSection);
        });

        // Remove Section
        $(document).on('click', '.remove-section', function() {
            if ($('#section-form .section-container').length > 1) {
                $(this).closest('.section-container').remove();
            }
        });


});



</script>

</body>
</html>