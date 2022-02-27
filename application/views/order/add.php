
<?php echo form_open('order/add',array("class"=>"form-horizontal")); ?>
	<div class="col-sm-offset-4 col-sm-6">
		<div class="form-group">
			<label for="date" class="col-md-4">Select Date</label>
			<div class="col-md-4">
				<div class="input-group date">
					<input type="text" class="form-control" name="schedule-date" id="schedule-date" value="<?= date('m-d-Y'); ?>" />
					<div class="input-group-addon">
				        <span class="glyphicon glyphicon-th"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="scheduledTime" class="col-md-4">Schedule Time</label>
			<div class="col-md-4">
				<input type="text" name="time" value="<?php echo ( $this->input->post('time') ? $this->input->post('scheduledTime') : date("H:i") ); ?>" class="form-control" id="time" />
			</div>
		</div>
		<div class="form-group">
			<label for="facilityId" class="col-md-4">Select Facility</label>
			<div class="col-md-4">
				<select name="facilityId" class="form-control">
					<?php 
					foreach($all_facilities as $facility)
					{
						$selected = ($facility['id'] == $this->input->post('facilityId')) ? ' selected="selected"' : "";

						echo '<option value="'.$facility['id'].'" '.$selected.'>'.$facility['name'].'-'.$facility['uCode'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="referringPhysicianId" class="col-md-4">Select Physician</label>
			<div class="col-md-4">
				<select name="referringPhysicianId" class="form-control">
					<?php 
					foreach($all_physicians as $physician)
					{
						$selected = ($physician['id'] == $this->input->post('referringPhysicianId')) ? ' selected="selected"' : "";

						echo '<option value="'.$physician['id'].'" '.$selected.'>'.$physician['name'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="tech" class="col-md-4">Enter Tech Information</label>
			<div class="col-md-4">
				<select name="techId" class="form-control">
					<?php 
					foreach($all_techs as $tech)
					{
						$selected = ($tech['id'] == $this->input->post('referringtechId')) ? ' selected="selected"' : "";

						echo '<option value="'.$tech['id'].'" '.$selected.'>'.$tech['title'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-4">
				<button type="submit" class="btn btn-success">SAVE SCHEDULE</button>
	        </div>
		</div>
	</div>

<?php echo form_close(); ?>