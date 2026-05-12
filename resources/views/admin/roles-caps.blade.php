<?php
$danger = $success = $info = $warning = 0;
$danger_msg = $success_msg = $info_msg = $warning_msg = '';
?>
<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Roles and Capabilities</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Roles and Capabilities
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php if(isset($rolesCaps) && count($rolesCaps)>0): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Roles</th>
                                            <th>Capabilities</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach($rolesCaps as $roles_caps): ?>
                                        <tr>
                                            <td><?php echo $roles_caps->name; ?></td>
                                            <td>
												<?php if(!empty($roles_caps->capabilities)):
													$roles_and_capss = unserialize($roles_caps->capabilities);
													foreach($roles_and_capss as $roles_and_caps):
												?>
												<span class="label label-default"><?php echo isset($rolesAndCaps[$roles_and_caps])?$rolesAndCaps[$roles_and_caps]:""; ?></span>
												<!--span class="label label-default">Update admin</span>
												<span class="label label-default">Delete admin</span>
												<span class="label label-default">See admin</span>
												<span class="label label-default">Add GB Associate</span>
												<span class="label label-default">Update GB Associate</span>
												<span class="label label-default">Delete GB Associate</span>
												<span class="label label-default">See GB Associate</span-->
												<?php endforeach; endif; ?>
											</td>	
                                            <td><a href="roles-and-capabilities/update/<?php echo base64_encode($roles_caps->id); ?>" class="btn btn-info btn-sm">UPDATE</a></td>
                                        </tr>
										<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
							<?php else: ?>
							<div class="alert alert-warning">
								No result found.
							</div>							
							<?php endif; ?>
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
