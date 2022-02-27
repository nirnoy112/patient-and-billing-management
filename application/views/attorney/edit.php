<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 19 May, 2017.
    * @LastUpdatedOn: 19 May, 2017.
    *
    *****/
?>

<?php echo form_open('attorney/edit/'.$attorney['id'],array("class"=>"form-horizontal")); ?>
	<div class="col-sm-offset-2 col-sm-6">
		<div class="form-group">
			<label for="name" class="col-md-4 control-label">Name</label>
			<div class="col-md-8">
				<input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $attorney['name']); ?>" class="form-control" id="name" />
			</div>
		</div>
		<div class="form-group">
			<label for="primaryContact" class="col-md-4 control-label">Primary Contact</label>
			<div class="col-md-8">
				<input type="text" name="primaryContact" value="<?php echo ($this->input->post('primaryContact') ? $this->input->post('primaryContact') : $attorney['primaryContact']); ?>" class="form-control" id="primaryContact" />
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="col-md-4 control-label">Email</label>
			<div class="col-md-8">
				<input type="text" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $attorney['email']); ?>" class="form-control" id="email" />
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="col-md-4 control-label">Address</label>
			<div class="col-md-8">
				<input type="text" name="address" value="<?php echo ($this->input->post('address') ? $this->input->post('address') : $attorney['address']); ?>" class="form-control" id="address" />
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="col-md-4 control-label">City</label>
			<div class="col-md-8">
				<input type="text" name="city" value="<?php echo ($this->input->post('city') ? $this->input->post('city') : $attorney['city']); ?>" class="form-control" id="city" />
			</div>
		</div>
		<div class="form-group">
			<label for="state" class="col-md-4 control-label">State</label>
			<div class="col-md-8">
				<input type="text" name="state" value="<?php echo ($this->input->post('state') ? $this->input->post('state') : $attorney['state']); ?>" class="form-control" id="state" />
			</div>
		</div>
		<div class="form-group">
			<label for="zip" class="col-md-4 control-label">Zip</label>
			<div class="col-md-8">
				<input type="text" name="zip" value="<?php echo ($this->input->post('zip') ? $this->input->post('zip') : $attorney['zip']); ?>" class="form-control" id="zip" />
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="col-md-4 control-label">Phone</label>
			<div class="col-md-8">
				<input type="text" name="phone" value="<?php echo ($this->input->post('phone') ? $this->input->post('phone') : $attorney['phone']); ?>" class="form-control" id="phone" />
			</div>
		</div>
		<div class="form-group">
			<label for="fax" class="col-md-4 control-label">Fax</label>
			<div class="col-md-8">
				<input type="text" name="fax" value="<?php echo ($this->input->post('fax') ? $this->input->post('fax') : $attorney['fax']); ?>" class="form-control" id="fax" />
			</div>
		</div>
		<div class="form-group">
            <div class="col-sm-offset-6 col-sm-6">
				<button type="submit" class="btn btn-success">Save</button>
	        </div>
		</div>
	</div>
<?php echo form_close(); ?>