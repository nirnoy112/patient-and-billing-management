<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 20 JUNE, 2017.
    * @LastUpdatedOn: 20 JUNE, 2017.
    *
    *****/
?>

<?php echo form_open('billing_company/edit/'.$bc['id'],array("class"=>"form-horizontal")); ?>
	<div class="col-sm-offset-2 col-sm-6">
		<div class="form-group">
			<label for="name" class="col-md-4 control-label">Company Name</label>
			<div class="col-md-8">
				<input type="text" name="companyName" value="<?php echo ($this->input->post('companyName') ? $this->input->post('companyName') : $bc['companyName']); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="col-md-4 control-label">Company Address</label>
			<div class="col-md-8">
				<input type="text" name="address" value="<?php echo ($this->input->post('address') ? $this->input->post('address') : $bc['address']); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="address2" class="col-md-4 control-label">Represinting Real Name</label>
			<div class="col-md-8">
				<input type="text" name="realName" value="<?php echo ($this->input->post('realName') ? $this->input->post('realName') : $bc['realName']); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="col-md-4 control-label">Represinting Username</label>
			<div class="col-md-8">
				<input type="text" name="username" value="<?php echo ($this->input->post('username') ? $this->input->post('username') : $bc['username']); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="state" class="col-md-4 control-label">Representing Password</label>
			<div class="col-md-8">
				<input type="password" name="password" value="<?php echo ($this->input->post('password') ? $this->input->post('password') : $bc['password']); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
            <div class="col-sm-offset-6 col-sm-6">
				<button type="submit" class="btn btn-success">Save</button>
	        </div>
		</div>
	</div>
<?php echo form_close(); ?>