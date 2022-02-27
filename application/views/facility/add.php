<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 14 May, 2017.
    * @LastUpdatedOn: 14 May, 2017.
    *
    *****/
?>

<?php echo form_open('facility/add',array("class"=>"form-horizontal")); ?>
	<div class="col-sm-offset-2 col-sm-6">
		<div class="form-group">
			<label for="name" class="col-md-4 control-label">Name</label>
			<div class="col-md-8">
				<input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="name" />
			</div>
		</div>
		<div class="form-group">
			<label for="uCode" class="col-md-4 control-label">UCode</label>
			<div class="col-md-8">
				<input type="text" name="uCode" value="<?php echo $this->input->post('uCode'); ?>" class="form-control" id="uCode" />
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="col-md-4 control-label">Address</label>
			<div class="col-md-8">
				<input type="text" name="address" value="<?php echo $this->input->post('address'); ?>" class="form-control" id="address" />
			</div>
		</div>
		<div class="form-group">
			<label for="address2" class="col-md-4 control-label">Address2</label>
			<div class="col-md-8">
				<input type="text" name="address2" value="<?php echo $this->input->post('address2'); ?>" class="form-control" id="address2" />
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="col-md-4 control-label">City</label>
			<div class="col-md-8">
				<input type="text" name="city" value="<?php echo $this->input->post('city'); ?>" class="form-control" id="city" />
			</div>
		</div>
		<div class="form-group">
			<label for="state" class="col-md-4 control-label">State</label>
			<div class="col-md-8">
				<input type="text" name="state" value="<?php echo $this->input->post('state'); ?>" class="form-control" id="state" />
			</div>
		</div>
		<div class="form-group">
			<label for="zip" class="col-md-4 control-label">Zip</label>
			<div class="col-md-8">
				<input type="text" name="zip" value="<?php echo $this->input->post('zip'); ?>" class="form-control" id="zip" />
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="col-md-4 control-label">Phone</label>
			<div class="col-md-8">
				<input type="text" name="phone" value="<?php echo $this->input->post('phone'); ?>" class="form-control" id="phone" />
			</div>
		</div>
		<div class="form-group">
			<label for="fax" class="col-md-4 control-label">Fax</label>
			<div class="col-md-8">
				<input type="text" name="fax" value="<?php echo $this->input->post('fax'); ?>" class="form-control" id="fax" />
			</div>
		</div>
		<div class="form-group">
            <div class="col-sm-offset-6 col-sm-6">
				<button type="submit" class="btn btn-success">Save</button>
	        </div>
		</div>
	</div>
<?php echo form_close(); ?>