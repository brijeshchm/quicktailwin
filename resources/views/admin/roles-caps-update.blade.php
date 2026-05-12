<?php
$danger = $success = $info = $warning = 0;
$danger_msg = $success_msg = $info_msg = $warning_msg = '';
 
?>
<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Update Roles and Capabilities</h1>
					@if(Session::has('success_msg'))
						<div class="alert alert-success">
							{{Session::get('success_msg')}}
						</div>
					@endif
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Update Roles and Capabilities
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
								<?php if(isset($rolesCaps) && count($rolesCaps)==1): ?>
                                <div class="col-lg-6 col-lg-offset-3">
                                    <form role="form" action="" method="POST">
										<?php echo csrf_field(); ?>
										<input type="hidden" name="role_id" value="<?php echo $rolesCaps->id; ?>">
										<div class="form-group">
											<label>ID:</label>
											<p class="form-control-static"><?php echo $rolesCaps->id; ?></p>
										</div>
										<div class="form-group">
											<label>Role:</label>
											<p class="form-control-static"><?php echo $rolesCaps->name; ?></p>
										</div>
										<div class="form-group">
											<label>Slug:</label>
											<p class="form-control-static"><?php echo $rolesCaps->role; ?></p>
										</div>
                                        <div class="form-group">
                                            <label>Capabilities:</label>
											<?php
											$roles_and_capss = unserialize($rolesCaps->capabilities);
											foreach($rolesAndCaps as $key=>$value): ?>
											<label class="checkbox-inline"><input type="checkbox" name="role_capabilities[]" value="<?php echo $key; ?>" <?php echo (is_array($roles_and_capss) && in_array($key,$roles_and_capss))?"checked":""; ?>><?php echo $value; ?></label>
											<?php endforeach; ?>											
                                        </div>
										<div class="form-group text-right">
											<input type="submit" name="submit" class="btn btn-info" value="UPDATE">
										</div>										
									</form>
								</div>
								<?php else: ?>
								<div class="alert alert-warning">
									No result found.
								</div>								
								<?php endif; ?>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
