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
<div id="paymentSection" class="modal">
    <div class="modal-dialog" style="width: 50%; display: block;">
        <div class="modal-content">
            <div class="modal-header">
                <!-- header section -->
                <h4 class="modal-heading">PAYMENT SECTION</h4>
                <br>
                <div class="col-sm-offset-2 col-sm-10">
					<div class="col-sm-6">SELECTED PATIENT NAME:</div>
					<div class="col-sm-6"><?= $patient['lastName'] . ' ' . $patient['firstName'] . ' ' . $patient['middleName']; ?></div>
				</div>
            </div>
            <div class="row modal-body" style="padding: 10px 25px 10px 25px;">
	            <h5 class="modal-info">POSTING PAYMENT DETAILS:</h5>
	            <?php echo form_open($submit_route, array("class"=>"form-horizontal", "method"=>"post")); ?>
	            <input type="hidden" name="aoid" value="<?= $aoid ?>">
				<input type="hidden" name="apid" value="<?= $apid ?>">
	            <div class="col-sm-12">
	            	<div class="col-sm-1"></div>
	            	<div class="col-sm-10">
	            		<table class="table table-striped">
							<tr>
								<td style="width: 40%;">AMOUNT OF PAYMENT</td>
								<td style="width: 60%;">
									<input type="text" size="4" id="payment-amount" name="payment-amount"> &nbsp;&nbsp;( Total Due: $ <?php echo $patient['totalDue'] ?>)
								</td>
							</tr>
							<tr>
								<td style="width: 40%;">PAYMENT NOTE</td>
								<td style="width: 60%;">
									<textarea rows="3" id="payment-note" name="payment-note" style="width:100%;"></textarea>
								</td>
							</tr>
							<tr>
								<td style="width: 40%;">DATE OF PAYMENT</td>
								<td style="width: 60%;">
									<input type="text" id="payment-date" name="payment-date" value="<?php echo date('m-d-Y'); ?>" disabled="disabled">
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
	            	<button type="submit" name="post_payment" value="post_payment" class="btn btn-s-lg btn-primary btn-rounded no_border">POST</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" id="cancel_payment" name="cancel_payment" value="cancel_payment" class="btn btn-warning">CANCEL</button>
	            </div>
            	<?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <!-- footer section -->
            </div>
        </div>
    </div>
</div>