</div>
<footer class="main-footer">
  <strong>Copyright &copy; 2023-<?= Date('Y') ?> <a href="http://kashagor.my.id/"
      target="_blank">kashagor.my.id</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.2.0
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
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
  src="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?PHP echo BASE_URL(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
    $('#Ticketlist').DataTable();


    $('#dtBasicExample').DataTable();
    //$('#rlist').DataTable();

    var table = $('#rlist').DataTable({
      paging: true,
      bFilter: true,
      ordering: true,
      searching: false,
      dom: 'lBfrtip',
      lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
      buttons: [

        "copy",               // Copy button
        "csv",                // CSV export button
        "excel",              // Excel export button
        "pdf",                // PDF export button
        "print",              // Print button
        "colvis"
      ]
    });



    // $('#rlist').DataTable({
    //       "paging": true,
    //       "lengthChange": false,
    //       "searching": false,
    //       "ordering": true,
    //       "info": true,
    //       "autoWidth": false,
    //       "responsive": true,
    //     });




    $(document).on('click', '.update_company_info', function () {
      var c_id = $(this).attr("c_id");
      $.get("<?php echo base_url() ?>dashboard/company/edit_info", { cid: c_id }, function (data) {
        $('#edit_company_phone').val(data.company_phone);
        $('#edit_company_name').val(data.company_name);
        $('#edit_company_address').val(data.company_address);
        $('#ce_id').val(data.id);
      }, "JSON");
    });
    $(document).on('click', '.update_company_user_info', function () {
      var u_id = $(this).attr('u_id');
      $.post("<?php echo base_url() ?>dashboard/company/user_info", { uid: u_id }, function (data) {
        $('#cusername').val(data.username);
        $('#cpassword').val(data.password);
        $('#crole_type').val(data.role_id);
        $('#cphone').val(data.phone);
        $('#cemail').val(data.email);
        $('#cfullname').val(data.fullname);
        $('#cuid').val(data.id);

      }, "JSON");

    });

    $(document).on('change', '#inputCompany', function () {
      var company_id = $(this).val();
      $.get("<?php echo base_url() ?>dashboard/company/company_info", { cid: company_id }, function (data) {
        console.log(data);
        $('#company_name').val(data.company_name);
      }, "JSON");
    });

    $(document).on('click', '.update_route_info', function () {
      var r_id = $(this).attr("c_id");
      $.post("<?php echo base_url() ?>dashboard/routes/edit_info", { cid: r_id }, function (data) {
        $('#edit_r_name').val(data.route_name);
        $('#edit_r_fare').val(data.fare);
        $('#edit_point_type').val(data.point_type);
        $('#re_id').val(data.id);
      }, "JSON");
    });


    // var newIndex = 1;
    // $(document).on('click', '.add-section', function() {
    //             var clonedSection = $(this).closest('.section-container').clone();
    //             clonedSection.find('input[type="text"], input[type="number"]').val('');
    //             $(this).closest('.section-container').after(clonedSection);
    //             console.log( "I am here");
    //             clonedSection.find('[id^="route_input"]').attr('id', 'route_input_' + newIndex);
    //            clonedSection.find('[id^="route_input_a_result"]').attr('id', 'route_input_a_result_' + newIndex);
    //            var so = 'route_input_'+newIndex;
    //            var so_out = 'route_input_a_result_'+newIndex;

    //            setupLiveSearch(so,so_out);

    //            newIndex++;

    //         });

    //         // Remove Section
    //         $(document).on('click', '.remove-section', function() {
    //             if ($('#section-form .section-container').length > 1) {
    //                 $(this).closest('.section-container').remove();
    //             }
    //         });


    // });




    // Get session values for com_id and role_id
    var com_id = '<?php echo session()->get('com_id'); ?>';
    var role_id = '<?php echo session()->get('role_id'); ?>';

    $('#cc_route_id').on('input', function () {
      var searchTerm = $(this).val();

      // AJAX request to fetch information from CodeIgniter
      $.ajax({
        url: '<?php echo base_url() ?>district/odtbaseonroi',
        method: 'POST',
        data: { id: searchTerm },
        dataType: 'json',
        success: function (response) {

          // If role_id is 110, check company_id with com_id
          if (role_id == 110) {
            if (response.company_id == com_id) {
              // Update the input fields with the response values
              $('#main_boarding').val(response.main_boarding);
              $('#total_fare').val(response.total_fare);
              $('#final_destination').val(response.final_destination);
              $('#company_id').val(response.company_id);
            } else {
              // If company_id doesn't match, show "Unauthorized"
              $('#main_boarding').val("Unauthorized");
              $('#total_fare').val("Unauthorized");
              $('#final_destination').val("Unauthorized");
              $('#company_id').val("Unauthorized");
            }
          } else {
            // If role_id is 111, display data as usual
            $('#main_boarding').val(response.main_boarding);
            $('#total_fare').val(response.total_fare);
            $('#final_destination').val(response.final_destination);
            $('#company_id').val(response.company_id);
          }
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
    });

    $('#tcc_route_id').on('input', function () {
      var searchTerm = $(this).val();

      // AJAX request to fetch information from CodeIgniter
      $.ajax({
        url: '<?php echo base_url('dashboard/coach/info') ?>',
        method: 'GET',
        data: { id: searchTerm },
        dataType: 'json',
        success: function (response) {

          // If role_id is 110, check company_id with com_id
          if (role_id == 110) {
            if (response.company_id == com_id) {
              // Update the input fields with the response values
              $('#coach_type').val(response.coach_type);
              $('#vehicle_number').val(response.vehicle_number);
              $('#supervison_no').val(response.supervisor_no);
              $('#seat_layout').val(response.seat_layout);
              $('#departure').val(response.departure);
              $('#arrival').val(response.arrival);
              $('#main_boarding').val(response.main_boarding);
              $('#final_destination').val(response.final_destination);
              $('#total_fare').val(response.total_fare);
            } else {
              // If company_id doesn't match, show "Unauthorized"
              $('#vehicle_number').val("Unauthorized");
              $('#coach_type').val("Unauthorized");
              $('#supervison_no').val("Unauthorized");
              $('#seat_layout').val("Unauthorized");
              $('#departure').val("Unauthorized");
              $('#arrival').val("Unauthorized");
              $('#main_boarding').val("Unauthorized");
              $('#final_destination').val("Unauthorized");
              $('#total_fare').val("Unauthorized");
            }
          } else {
            // If role_id is 111, display data as usual
            $('#coach_type').val(response.coach_type);
            $('#vehicle_number').val(response.vehicle_number);
            $('#supervison_no').val(response.supervisor_no);
            $('#seat_layout').val(response.seat_layout);
            $('#departure').val(response.departure);
            $('#arrival').val(response.arrival);
            $('#main_boarding').val(response.main_boarding);
            $('#final_destination').val(response.final_destination);
            $('#total_fare').val(response.total_fare);
          }
        },
        error: function (xhr, status, error) {
          // Handle any errors that occurred during the AJAX request
          $('#vehicle_number').val("NO COACH WAS FOUND WITH THE ID");
          console.error(error);
        }
      });
    });





  });








  $(document).ready(function () {

    var searchResults = [];

    fetch('http://localhost:8080/district')
      .then(response => response.json())
      .then(data => {

        searchResults = data.map(function (obj) {
          return obj.district_name;
        });
      })
      .catch(error => {
        console.error('Error:', error);
      });

    // Add new input row on clicking "+"
    $('.add-section').click(function () {
      var sectionContainer = $(this).closest('.section-container');
      var clonedSection = sectionContainer.clone(true);
      clonedSection.find('input[type="text"], input[type="number"]').val('');

      sectionContainer.after(clonedSection);
    });

    // Remove input row on clicking "-"
    $(document).on('click', '.remove-section', function () {
      var sectionContainer = $(this).closest('.section-container');
      sectionContainer.remove();
    });

    // Live search functionality
    $(document).on('keyup', '[name="route_name[]"]', function () {
      var input = $(this);
      var inputValue = input.val();

      if (inputValue.length >= 2) { // Check if at least two characters have been entered
        var filterLetters = inputValue.toLowerCase();

        var filteredResults = searchResults.filter(function (result) {
          return result.toLowerCase().startsWith(filterLetters);
        });

        var searchResultsHtml = '';
        for (var i = 0; i < filteredResults.length; i++) {
          searchResultsHtml += '<div class="search-result">' +
            filteredResults[i] + '</div>';
        } input.siblings('#route_input_a_result').html(searchResultsHtml);
      } else {
        input.siblings('#route_input_a_result').empty();
      }
    }); // Select search result on click
    $(document).on('click', '.search-result', function () {
      var selectedResult = $(this).text(); var
        input = $(this).closest('.section-container').find('[name="route_name[]" ]'); input.val(selectedResult);
      $(this).parent().empty();
    });
  }); </script>



</body>

</html>