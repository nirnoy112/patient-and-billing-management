<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 14 AUGUST, 2017.
    * @LastUpdatedOn: 15 AUGUST, 2017.
    *
    *****/
?>


<?php echo form_open('user/add',array("class"=>"form-horizontal")); ?>
	<div class="col-sm-offset-2 col-sm-6">
		<div class="form-group">
			<label for="roleId" class="col-md-4 control-label">User Role</label>
			<div class="col-md-8">
				<select name="roleId" class="form-control">
					<?php 
					foreach($all_roles as $role)
					{
						$selected = ($role['id'] == $this->input->post('roleId')) ? ' selected="selected"' : "";

						echo '<option value="'.$role['id'].'" '.$selected.'>'.$role['title'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="realName" class="col-md-4 control-label">Full Name</label>
			<div class="col-md-8">
				<input type="text" name="realName" value="<?php echo $this->input->post('realName'); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-md-4 control-label">Username</label>
			<div class="col-md-8">
				<input type="text" name="username" value="<?php echo $this->input->post('username'); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-md-4 control-label">Password</label>
			<div class="col-md-8">
				<input type="password" name="password" value="<?php echo $this->input->post('password'); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
            <div class="col-sm-offset-6 col-sm-6">
				<button type="submit" class="btn btn-success">Save</button>
	        </div>
		</div>
	</div>
<?php echo form_close(); ?>