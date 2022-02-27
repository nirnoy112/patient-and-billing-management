<?php

	/*****
	*
	* @File: 'process/print.php'.
	* @Author: NASID.
	* @CreatedOn: 05 JUNE, 2017.
	* @LastUpdatedOn: 06 JUNE, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div id="assigningSection" class="modal">
    <div class="modal-dialog" style="width: 50%; display: block;">
        <div class="modal-content">
            <div class="modal-header">
                <!-- header section -->
                <h4 class="modal-heading">ASSIGNING SECTION</h4>
                <br>
                <div class="col-sm-offset-2 col-sm-10">
					<div class="col-sm-6">SELECTED PATIENT NAME:</div>
					<div class="col-sm-6"><?= $patient['lastName'] . ' ' . $patient['firstName'] . ' ' . $patient['middleName']; ?></div>
				</div>
            </div>
            <div class="row modal-body" style="padding: 10px 25px 10px 25px;">
	            <h5 class="modal-info">ASSIGN SELECTED PATIENT TO:</h5>
	            <?php echo form_open($submit_route, array("class"=>"form-horizontal", "method"=>"post")); ?>
	            <input type="hidden" name="aoid" value="<?= $aoid ?>">
				<input type="hidden" name="apid" value="<?= $apid ?>">
	            <div class="col-sm-12">
	            	<div class="col-sm-1"></div>
	            	<div class="col-sm-10">
	            		<table class="table table-striped">
							<tr>
								<td style="width: 60%;">SELECT A BILLING COMPANY</td>
								<td style="width: 40%;">
									<select name="bcId" class="form-control">
									<option value="0">NONE</option>
										<?php 
										foreach($all_bcs as $bc)
										{
											$selected = ($bc['id'] == $patient['BCID']) ? ' selected="selected"' : "";

											echo '<option value="'.$bc['id'].'" '.$selected.'>'.$bc['companyName'].'</option>';
										} 
										?>
									</select>
								</td>
							</tr>
						</table>
	            	</div>
	            	<div class="col-sm-1"></div>
	            </div>
	            <br>
	            <br>
	            <br>
	            <div class="col-sm-offset-4 col-sm-12">
	            	<button type="submit" name="assign_patient" value="assign_patient" class="btn btn-s-lg btn-primary btn-rounded no_border">ASSIGN</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" id="close_asign" name="close_asign" value="close_asign" class="btn btn-warning">CLOSE</button>
	            </div>
            	<?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <!-- footer section -->
            </div>
        </div>
    </div>
</div>