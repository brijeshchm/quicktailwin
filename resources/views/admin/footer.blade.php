    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo asset('admin/vendor/jquery/jquery.min.js'); ?>"></script>
	
	<!-- Select2 Core JS -->
    <script src="<?php echo asset('admin/vendor/select2/js/select2.full.js'); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo asset('admin/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
	
    <!-- Bootstrap DateTimePicker -->
    <script src="<?php echo asset('vendor/bootstrap-datetimepicker/build/js/moment.min.js'); ?>"></script>
    <script src="<?php echo asset('vendor/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
	
	<!-- TINY MCE Editor -->
    <!-- <script src="<?php echo asset('vendor/tinymce/tinymce.jquery.min.js'); ?>"></script> -->

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo asset('admin/vendor/metisMenu/metisMenu.min.js'); ?>"></script>
	<script src="{{ asset('admin/vendor/chosen-js/chosen.jquery.js') }}"></script>
    <!-- DataTables JavaScript -->
    <script src="<?php echo asset('admin/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo asset('admin/vendor/datatables-plugins/dataTables.bootstrap.min.js'); ?>"></script>
    <script src="<?php echo asset('admin/vendor/datatables-responsive/dataTables.responsive.js'); ?>"></script>	
	
    <!-- Morris Charts JavaScript -->
   <!-- <script src="<?php echo asset('admin/vendor/raphael/raphael.min.js'); ?>"></script>
    <script src="<?php echo asset('admin/vendor/morrisjs/morris.min.js'); ?>"></script>
    <script src="<?php echo asset('admin/data/morris-data.js'); ?>"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo asset('admin/dist/js/sb-admin-2.js'); ?>"></script>
	<script src="<?php echo asset('admin/dist/app/app.js') ?>"></script>
    <script src="<?php echo asset('admin/dist/app/counsellorDashboardController.js') ?>"></script>
    <script src="<?php echo asset('admin/dist/app/userController.js') ?>"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <!--script>
    $(document).ready(function() {
        var dataTableExample = $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script-->
	<div id="messagemodel" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
   
    <h5 class="modal-title">Massege</h5>
     <button type="button" class="close" data-dismiss="modal">&times;</button>
    
    </div>
    <div class="modal-body" style="padding-top:5px">
    </div>
    
    </div>
    
    </div>
</div>
<script>
	$( ".select2-single, .select2-multiple" ).select2( {		 
		theme: "bootstrap",
		placeholder: "Select",
		maximumSelectionSize: 6,
		containerCssClass: ':all:'
	} );
// test //
// **** //
/*$(".select2-single").select2({
  ajax: {
    url: "/developer/cities/getcities",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;
      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },

    cache: true
  },
	theme: "bootstrap",
	placeholder: "Select",
	maximumSelectionSize: 6,
	containerCssClass: ':all:',
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  //minimumInputLength: 1
});*/
// test //
// **** //
	$( ":checkbox" ).on( "click", function() {
		$( this ).parent().nextAll( "select" ).prop( "disabled", !this.checked );
	});
</script>	
	<script src="<?php echo asset('admin/vendor/datepicker/datepicker.min.js'); ?>"></script>
	<script type='text/javascript'>
	jQuery(document).ready(function(jQuery){jQuery.datepicker.setDefaults({"closeText":"Close","currentText":"Today","monthNames":["January","February","March","April","May","June","July","August","September","October","November","December"],"monthNamesShort":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"nextText":"Next","prevText":"Previous","dayNames":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],"dayNamesShort":["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],"dayNamesMin":["S","M","T","W","T","F","S"],"dateFormat":"MM d, yy","firstDay":1,"isRTL":false});});
	</script>
	<script src="<?php echo asset('admin/vendor/matchHeight/jquery.matchHeight-min.js'); ?>"></script>
    <script src="<?php echo asset('admin/dist/js/script.js'); ?>"></script>
  
	<script>
	 $(".select2-single-city").select2({
        theme: "bootstrap",
        placeholder: "Select a City",
        maximumSelectionSize: 6,
        containerCssClass: ":all:",
        ajax: {
            url: "/developer/cities/getajaxcities",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data.cities, function(obj) {
                        return {
                            id: obj.city,
                            text: obj.city
                        };
                    })
                }
            },
            cache: true
        }
    });
    $(".select2-single-state").select2({
        theme: "bootstrap",
        placeholder: "Select State",
        maximumSelectionSize: 6,
        containerCssClass: ":all:"
    });
	
 
	
	$(".select2-single-box").select2({
        theme: "bootstrap",
        placeholder: "Select State",
        maximumSelectionSize: 6,
        containerCssClass: ":all:"
    });
	
	 
		
	</script>
	<script>
$(".chosen-select").chosen();
		 
	</script>
</body>

</html>