<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 14 AUGUST, 2017.
    * @LastUpdatedOn: 15 AUGUST, 2017.
    *
    *****/
?>

<?php echo form_open('user/edit/'.$user['id'],array("class"=>"form-horizontal")); ?>
	<div class="col-sm-offset-2 col-sm-6">
		<div class="form-group">
			<label for="roleId" class="col-md-4 control-label">User Role</label>
			<div class="col-md-8">
				<select name="roleId" class="form-control">
					<?php 
					foreach($all_roles as $role)
					{
						$selected = ($role['id'] == $user['roleId']) ? ' selected="selected"' : "";

						echo '<option value="'.$role['id'].'" '.$selected.'>'.$role['title'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="realName" class="col-md-4 control-label">Full Name</label>
			<div class="col-md-8">
				<input type="text" name="realName" value="<?php echo ($this->input->post('realName') ? $this->input->post('realName') : $user['realName']); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="username" class="col-md-4 control-label">Username</label>
			<div class="col-md-8">
				<input type="text" name="username" value="<?php echo ($this->input->post('username') ? $this->input->post('username') : $user['username']); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-md-4 control-label">Password (MD5 Encoded)</label>
			<div class="col-md-8">
				<input type="text" value="<?php echo md5($user['password']); ?>" class="form-control" disabled="disabled" />
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-md-4 control-label">New Password (To Change)</label>
			<div class="col-md-8">
				<input type="password" name="password" value="" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="suspended" class="col-md-4 control-label">Suspened User ?</label>
			<div class="col-md-8">
				<input type="radio" name="suspended" value="1" <?php if($user['suspended'] == 1) { echo 'checked'; } ?>><label for="male">YES</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="suspended" value="0" <?php if($user['suspended'] == 0) { echo 'checked'; } ?>><label for="female">NO</label>
			</div>
		</div>
		<div class="form-group">
            <div class="col-sm-offset-6 col-sm-6">
				<button type="submit" class="btn btn-success">Save</button>
	        </div>
		</div>
	</div>
<?php echo form_close(); ?>