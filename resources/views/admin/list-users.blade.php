<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">				
                    <h1 class="page-header">Users List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					@if(Session::has('success'))
						<div class="alert alert-success">
							{{Session::get('success')}}
						</div>
					@endif
					@if(Session::has('danger'))
						<div class="alert alert-danger">
							{{Session::get('danger')}}
						</div>
					@endif					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Users List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php if(isset($users) && count($users)>0): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User Name</th>
                                            <th>Role</th>
                                            <th>Capabilities</th>
                                            <th>Update</th> 
                                           <?php if(Auth::user()->current_user_can('administrator')){ ?> <th>Delete</th> <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user->id; ?></td>
                                            <td><?php echo $user->user_name; ?></td>
                                            <td><?php echo $user->role; ?></td>
                                            <td><?php echo $user->capabilities; ?></td>	
                                            <td><a href="update-user/<?php echo base64_encode($user->id); ?>" class="btn btn-info btn-sm"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a></td>
                                           <?php 	if(Auth::user()->current_user_can('administrator')){ ?>  <td><a href="list-users/delete/<?php echo base64_encode($user->id); ?>" class="btn btn-info btn-sm" onclick="return confirm('Are you sure want to deleted? ');" ><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></td> <?php } ?>
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