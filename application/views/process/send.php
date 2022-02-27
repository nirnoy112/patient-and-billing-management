<?php

	/*****
	*
	* @File: 'process/send.php'.
	* @Author: NASID.
	* @CreatedOn: 05 JUNE, 2017.
	* @LastUpdatedOn: 06 JUNE, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div id="sendingSection" class="modal">
    <div class="modal-dialog" style="width: 50%; display: block;">
        <div class="modal-content">
            <div class="modal-header">
                <!-- header section -->
                <h4 class="modal-heading">SENDING SECTION</h4>
                <br>
                <div class="col-sm-offset-2 col-sm-10">
					<div class="col-sm-6">SELECTED PATIENT NAME:</div>
					<div class="col-sm-6"><?= $patient['lastName'] . ' ' . $patient['firstName'] . ' ' . $patient['middleName']; ?></div>
				</div>
            </div>
            <div class="row modal-body" style="padding: 10px 25px 10px 25px;">
	            <h5 class="modal-info">AVAILABLE OPTIONS&nbsp;&nbsp;&nbsp;&nbsp;<a id="select-all-link-s" href="" class="btn btn-xs btn-success">CHECK ALL</a></h5></h5>
	            <?php echo form_open($submit_route, array("class"=>"form-horizontal", "method"=>"post")); ?>
	            <input type="hidden" name="aoid" value="<?= $aoid ?>">
				<input type="hidden" name="apid" value="<?= $apid ?>">
	            <div class="col-sm-12">
	            	<div class="col-sm-2"></div>
	            	<div class="col-sm-8">
	            		<table class="table table-striped">
	            			<tr>
	            				<th style="width: 70%;">OPTION</th>
	            				<th style="width: 30%;">CHECKBOX</th>
	            			</tr>
							<tr>
								<td style="width: 70%;">HCFA</td>
								<td style="width: 30%;">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="optS1" name="opt[hcfa]" value="YES" />
								</td>
							</tr>
							<tr>
								<td style="width: 70%;">ORDER</td>
								<td style="width: 30%;">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="optS2" name="opt[order]" value="YES" />
								</td>
							</tr>
							<tr>
								<td style="width: 70%;">ATTACHMENTS</td>
								<td style="width: 30%;">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="optS3" name="opt[attachments]" value="YES" />
								</td>
							</tr>
							<tr>
								<td style="width: 70%;">W-9</td>
								<td style="width: 30%;">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="optS4" name="opt[w9]" value="YES" />
								</td>
							</tr>
						</table>
	            	</div>
	            	<div class="col-sm-2"></div>
	            </div>
	            <br>
	            <div class="col-sm-12">
	            	<div class="col-sm-2"></div>
	            	<label class="col-sm-2">
	            		EMAIL:
	            	</label>
	            	<div class="col-sm-4">
	            		<input type="email" name="opt[emailToSend]">
	            	</div>
	            	<div class="col-sm-2"><button type="submit" name="selected_send" value="ssnd" class="btn btn-xs btn-primary btn-rounded no_border">SEND</button></div>
	            	<div class="col-sm-2"></div>
	            </div>
	            <div class="col-sm-12" style="min-height: 30px;"></div>
	            <div class="col-sm-offset-5 col-sm-12">
	            	<button type="submit" id="close_send" name="close_send" value="close_send" class="btn btn-warning">CLOSE</button>
	            </div>
            	<?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <!-- footer section -->
            </div>
        </div>
    </div>
</div>