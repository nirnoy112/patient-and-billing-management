<?php

	/*****
	*
	* @File: 'patient/patient-modal.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 20 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div id="patientSection" class="modal">
    <div class="modal-dialog" style="width: 90%; display: block;">
        <div class="modal-content">
            <div class="modal-header">
                <!-- header section -->
                <h4 class="modal-heading">ENLIST NEW PATIENT</h4>
            </div>
            <div class="row modal-body" style="padding: 0px 25px 0px 25px;">
                <?php echo form_open('',array("class"=>"form-horizontal")); ?>
            	<div class="col-sm-12" style="padding: 15px 0px 15px 0px;">
            		<h5 class="modal-info">FIND EXISTING PATIENT</h5>
            		<label class="col-sm-2">ENTER PID :</label>
            		<div class="col-sm-2">
            			<input type="text" id="query_pid" name="patient[PID]">
            			<input type="hidden" id="api_url" name="api_url" value="<?= site_url('patient/port?pid='); ?>">
            			<input type="hidden" id="firstNameRes" name="firstNameRes" value="">
            			<input type="hidden" id="lastNameRes" name="lastNameRes" value="">
            			<input type="hidden" id="dobRes" name="dobRes" value="">
            			<input type="hidden" id="pidRes" name="pidRes" value="">
            			<input type="hidden" id="financialClassRes" name="financialClassRes" value="">
            		</div>
            		<div class="col-sm-2">
            			<a id="modal-search-link" href="" class="btn btn-xs btn-primary">CHECK</a>
            		</div>

            		<label class="col-sm-2">ENTER LASTNAME :</label>
            		<div class="col-sm-2">
            			<input type="text" id="query_ln" name="query_ln">
            			<input type="hidden" id="ln_api_url" name="ln_api_url" value="<?= site_url('patient/sbln?ln='); ?>">
            			<input type="hidden" id="firstNameResLn" name="firstNameResLn" value="">
            			<input type="hidden" id="lastNameResLn" name="lastNameResLn" value="">
            			<input type="hidden" id="dobResLn" name="dobResLn" value="">
            			<input type="hidden" id="pidResLn" name="pidResLn" value="">
            			<input type="hidden" id="financialClassResLn" name="financialClassResLn" value="">
            		</div>
            		<div class="col-sm-2">
            			<a id="modal-search-link-ln" href="" class="btn btn-xs btn-primary">SEARCH</a>
            		</div>
            	</div>
            	<div class="col-sm-12" style="padding: 15px 0px 15px 0px;">
            		<div class="col-sm-1"></div>
            		<div class="col-sm-4">
            			<p id="query-response" style="color: #7D3C98;">NO PID HAS BEEN CHECKED YET !</p>
            		</div>
            		<div class="col-sm-2"></div>
            		<div class="col-sm-4">
            			<p id="ln-query-response" style="color: #7D3C98;">NO LASTNAME HAS BEEN SEARCHED FOR YET !</p>
            		</div>
            		<div class="col-sm-1"></div>
            	</div>

            	<div class="col-sm-12" style="padding: 5px 5px 5px 5px; height: 200px; overflow: auto; border: 2px solid black;">
            		<h5 class="modal-info">FOUND PATIENT</h5>
            		<div id="search-result" class="col-sm-12">
            		</div>
            	</div>
                	<input type="hidden" name="aoid" value="<?= $aoid; ?>">
                	<input type="hidden" name="apid" value="<?= $apid; ?>">
                <div class="col-sm-12">
                	<h5 class="modal-info">PATIENT'S BASIC INFORMATION</h5>
                		<div class="form-group">
							<div class="col-sm-6">
								<label>PID</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="pidF" name="patient[PID]" size="8" />&nbsp;&nbsp;&nbsp;&nbsp;<label>LASTNAME</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="lastNameF" name="patient[lastName]" size="8" value="<?php echo ($this->input->post('lastName') ? $this->input->post('lastName') : $patient['lastName']); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;<label>FIRSTNAME</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="firstNameF" name="patient[firstName]" size="8" value="<?php echo ($this->input->post('firstName') ? $this->input->post('firstName') : $patient['firstName']); ?>" />
							</div>
							<label class="col-sm-1">DOB</label>
							<div class="col-sm-2">
								<div class="input-group date">
									<input class="form-control" id="dobF" type="text" name="patient[dob]" size="12" value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : $patient['dob']); ?>" />
									<div class="input-group-addon">
								        <span class="glyphicon glyphicon-th"></span>
									</div>
								</div>
							</div>
							<label class="col-sm-1">FNC CLS</label>
							<div class="col-sm-2">
								<select id="financialClassF" name="patient[financialClass]" class="form-control">
									<option value="NONE"<?php if($patient['financialClass'] == 'NONE') { echo ' selected="selected"'; } ?>>NONE</option>
									<option value="MEDICARE"<?php if($patient['financialClass'] == 'MEDICARE') { echo ' selected="selected"'; } ?>>MEDICARE</option>
									<option value="ORTHOMEDICS"<?php if($patient['financialClass'] == 'ORTHOMEDICS') { echo ' selected="selected"'; } ?>>ORTHOMEDICS</option>
									<option value="PIWC"<?php if($patient['financialClass'] == 'PIWC') { echo ' selected="selected"'; } ?>>PERSONAL INJURY WC</option>
									<option value="PPO"<?php if($patient['financialClass'] == 'PPO') { echo ' selected="selected"'; } ?>>PRIVATE INSURANCE(PPO)</option>
									<option value="IEHP"<?php if($patient['financialClass'] == 'IEHP') { echo ' selected="selected"'; } ?>>IEHP</option>
								</select>
							</div>
						</div>
                	</div>
                	<div class="col-sm-12">
                		<h5 class="modal-info">DIAGNOSTIC PROCEDURES IN ORDER</h5>
						<div class="form-group">
							<label class="col-sm-1">#</label>
							<label class="col-sm-4">PROCEDURE DESCRIPTION => CPT CODE</label>
							<label class="col-sm-2">ANATOMICAL POSITION</label>
							<label class="col-sm-2">ICD CODE</label>
							<label class="col-sm-3">DIAGNOSTIC DEFINITIVE</label>
						</div>
						<?php
							for($counter = 0; $counter < 12; $counter++) {
						?>
						<div class="form-group">
							<label class="col-sm-1"><?= $counter + 1; ?></label>
							<input type="hidden" name="ids[<?= $counter; ?>]" value="<?= $procedures[$counter]['id'] ?>">
							<input type="hidden" name="procedures[<?= $counter; ?>][patientId]" value="<?= $procedures[$counter]['patientId'] ?>">
							<div class="col-sm-4">
								<select name="procedures[<?= $counter; ?>][cptId]">
									<option value="0">0</option>
									<?php 
									foreach($all_cptcodes as $cptcode)
									{
										$selected = ($cptcode['id'] == $procedures[$counter]['cptId']) ? ' selected="selected"' : "";

										echo '<option value="'.$cptcode['id'].'" '.$selected.'>'.$cptcode['description'].' => '.$cptcode['code'].'</option>';
									} 
									?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="procedures[<?= $counter; ?>][anatomicalPosition]">
									<option value="NONE"<?php if($procedures[$counter]['anatomicalPosition'] == 'NONE') { echo ' selected="selected"'; } ?> >NONE</option>
									<option value="LEFT"<?php if($procedures[$counter]['anatomicalPosition'] == 'LEFT') { echo ' selected="selected"'; } ?> >LEFT</option>
									<option value="RIGHT"<?php if($procedures[$counter]['anatomicalPosition'] == 'RIGHT') { echo ' selected="selected"'; } ?> >RIGHT</option>
									<option value="BILATERAL"<?php if($procedures[$counter]['anatomicalPosition'] == 'BILATERAL') { echo ' selected="selected"'; } ?> >BILATERAL</option>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="procedures[<?= $counter; ?>][icdId]">
									<option value="0">0</option>
									<?php 
									foreach($all_icdcodes as $icdcode)
									{
										$selected = ($icdcode['id'] ==  $procedures[$counter]['icdId']) ? ' selected="selected"' : "";

										echo '<option value="'.$icdcode['id'].'" '.$selected.'>'.$icdcode['code'].'</option>';
									} 
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<select name="procedures[<?= $counter; ?>][definitiveId]">
									<option value="0">0</option>
									<?php 
									foreach($all_definitives as $definitive)
									{
										$selected = ($definitive['id'] == $procedures[$counter]['definitiveId']) ? ' selected="selected"' : "";

										echo '<option value="'.$definitive['id'].'" '.$selected.'>'.$definitive['value'].'</option>';
									} 
									?>
								</select>
							</div>
						</div>
						<?php
							}
						?>
                	</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-6">
							<?php

							if($patient['id'] == 0) {

							?>

							<button type="submit" name="add_patient" id="add_patient" value="add_patient" class="btn btn-s-lg btn-success btn-rounded no_border">ADD</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel_patient" value="cancel_patient" class="btn btn-warning">CANCEL</button>

							<?php

							} else {

							?>

							<button type="submit" name="update_patient" id="update_patient" value="update_patient" class="btn btn-s-lg btn-success btn-rounded no_border">CODE</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel_patient" value="cancel_patient" class="btn btn-warning">CANCEL</button>

							<?php

							}

							?>
						</div>
					</div>
				<?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <!-- footer section -->
            </div>
        </div>
    </div>
</div>