<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 16 May, 2017.
    * @LastUpdatedOn: 16 May, 2017.
    *
    *****/
?>

<?php echo form_open('cptcode/edit/'.$cptcode['id'],array("class"=>"form-horizontal")); ?>
	<div class="col-sm-offset-2 col-sm-6">
		<div class="form-group">
			<label for="code" class="col-md-4 control-label">Code</label>
			<div class="col-md-8">
				<input type="text" name="code" value="<?php echo ($this->input->post('code') ? $this->input->post('code') : $cptcode['code']); ?>" class="form-control" id="code" />
			</div>
		</div>
		<div class="form-group">
			<label for="description" class="col-md-4 control-label">Description</label>
			<div class="col-md-8">
				<input type="text" name="description" value="<?php echo ($this->input->post('description') ? $this->input->post('description') : $cptcode['description']); ?>" class="form-control" id="description" />
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-offset-6 col-sm-6">
				<button type="submit" class="btn btn-success">Save</button>
	        </div>
		</div>
	</div>
<?php echo form_close(); ?>