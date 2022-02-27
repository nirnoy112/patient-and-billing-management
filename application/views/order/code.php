
<?php echo form_open('order/code/'.$order['id'],array("class"=>"form-horizontal")); ?>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="scheduledTime" class="col-md-4">SCHEDULED TIME</label>
			<div class="col-md-8">
				<input type="text" name="scheduledTime" value="<?php echo ($this->input->post('scheduledTime') ? $this->input->post('scheduledTime') : $order['scheduledTime']); ?>" class="form-control" id="scheduledTime" />
			</div>
		</div>
		<div class="form-group">
			<label for="facilityId" class="col-md-4">FACILITY</label>
			<div class="col-md-8">
				<select name="facilityId" class="form-control">
					<?php 
					foreach($all_facilities as $facility)
					{
						$selected = ($facility['id'] == $order['facilityId']) ? ' selected="selected"' : "";

						echo '<option value="'.$facility['id'].'" '.$selected.'>'.$facility['name'].'-'.$facility['uCode'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="referringPhysicianId" class="col-md-4">REFFERING PHYSICIAN</label>
			<div class="col-md-8">
				<select name="referringPhysicianId" class="form-control">
					<?php 
					foreach($all_physicians as $physician)
					{
						$selected = ($physician['id'] == $order['referringPhysicianId']) ? ' selected="selected"' : "";

						echo '<option value="'.$physician['id'].'" '.$selected.'>'.$physician['name'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="tech" class="col-md-4">TECH</label>
			<div class="col-md-8">
				<input type="text" name="tech" value="<?php echo ($this->input->post('tech') ? $this->input->post('tech') : $order['tech']); ?>" class="form-control" id="tech" />
			</div>
		</div>
		<div class="form-group">
			<label for="cptId" class="col-md-4">CPT CODE</label>
			<div class="col-md-8">
				<select name="cptId" class="form-control">
					<?php 
					foreach($all_cptcodes as $cptcode)
					{
						$selected = ($cptcode['id'] == $order['cptId']) ? ' selected="selected"' : "";

						echo '<option value="'.$cptcode['id'].'" '.$selected.'>'.$cptcode['code'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="icdId" class="col-md-4">ICD CODE</label>
			<div class="col-md-8">
				<select name="icdId" class="form-control">
					<?php 
					foreach($all_icdcodes as $icdcode)
					{
						$selected = ($icdcode['id'] == $order['icdId']) ? ' selected="selected"' : "";

						echo '<option value="'.$icdcode['id'].'" '.$selected.'>'.$icdcode['code'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="definitiveId" class="col-md-4">DEFINITIVE DIAGNOSIS</label>
			<div class="col-md-8">
				<select name="definitiveId" class="form-control">
					<?php 
					foreach($all_definitives as $definitive)
					{
						$selected = ($definitive['id'] == $order['definitiveId']) ? ' selected="selected"' : "";

						echo '<option value="'.$definitive['id'].'" '.$selected.'>'.$definitive['value'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-sm-9">
		<input type="hidden" name="aoid" value="<?= $aoid; ?>">
		<input type="hidden" name="apid" value="<?= $apid; ?>">
    	<div class="col-sm-7">
    		<h5 class="modal-info">PATIENT IDENTITY</h5>
        	<div class="form-group">
				<div class="col-sm-2">FIRSTNAME</div>
				<div class="col-sm-4">
					<input type="text" name="patient[firstName]" value="<?php echo ($this->input->post('firstName') ? $this->input->post('firstName') : $patient['firstName']); ?>" />
				</div>
				<div class="col-sm-2">LASTNAME</div>
				<div class="col-sm-4">
					<input type="text" name="patient[lastName]" value="<?php echo ($this->input->post('lastName') ? $this->input->post('lastName') : $patient['lastName']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">DOB</div>
				<div class="col-sm-4">
					<input type="text" name="patient[dob]" value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : $patient['dob']); ?>" />
				</div>
				<div class="col-sm-2">ID</div>
				<div class="col-sm-4">
					<input type="text" name="patient[pId]" value="<?php echo ($this->input->post('pId') ? $this->input->post('pId') : $patient['pId']); ?>" />
				</div>
			</div>
			<h5 class="modal-info"">ORDER JUSTIFICATION</h5>
			<div class="form-group">
				<div class="col-sm-3">REASON</div>
				<div class="col-sm-9">
					<input type="text" name="patient[resonBehindOrder]" value="<?php echo ($this->input->post('resonBehindOrder') ? $this->input->post('resonBehindOrder') : $patient['resonBehindOrder']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3">HISTORY</div>
				<div class="col-sm-9">
					<input type="text" name="patient[history]" value="<?php echo ($this->input->post('history') ? $this->input->post('history') : $patient['history']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3">NOTES</div>
				<div class="col-sm-9">
					<input type="text" name="patient[notes]" value="<?php echo ($this->input->post('notes') ? $this->input->post('notes') : $patient['notes']); ?>" />
				</div>
			</div>
    	</div>
    	<div class="col-sm-5">
    		<h5 class="modal-info">DIAGNOSTIC TESTS IN ORDER</h5>
			<div class="form-group">
				<label class="col-sm-2">#</label>
				<label class="col-sm-5">TITLE</label>
				<label class="col-sm-5">ANATOMICAL POSITION</label>
			</div>
			<?php
				for($counter = 0; $counter < 6; $counter++) {
			?>
			<div class="form-group">
				<label class="col-sm-2"><?= $counter + 1; ?></label>
				<div class="col-sm-5">
					<input type="text" size="15" name="exams[<?= $counter; ?>][title]" />
				</div>
				<div class="col-sm-5">
					<select name="exams[<?= $counter; ?>][anatomicalPosition]">
						<option value="">NONE</option>
						<option value="LEFT LATERAL">LEFT LATERAL</option>
						<option value="RIGHT LATERAL">RIGHT LATERAL</option>
						<option value="BILATERAL">BILATERAL</option>
					</select>
				</div>
			</div>
			<?php
				}
			?>
    	</div>
	</div>
	<div class="col-sm-offset-5 col-sm-7">
		<button type="submit" name="code_order" class="btn btn-success">CODE</button>
    </div>
<?php echo form_close(); ?>