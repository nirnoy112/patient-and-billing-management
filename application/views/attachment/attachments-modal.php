<?php

	/*****
	*
	* @File: 'attachment/attachments-modal.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 27 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div id="attachmentSection" class="modal">
    <div class="modal-dialog" style="width: 50%; display: block;">
        <div class="modal-content">
            <div class="modal-header">
                <!-- header section -->
                <h4 class="modal-heading">PATIENT ATTACHMENTS</h4>
            </div>
            <div class="row modal-body" style="padding: 10px 25px 10px 25px;">
	            <?php echo form_open($submit_route, array("class"=>"form-horizontal", "method"=>"post", "enctype"=>"multipart/form-data")); ?>
	            <input type="hidden" name="aoid" value="<?= $aoid ?>">
				<input type="hidden" name="apid" value="<?= $apid ?>">
            	<div class="col-sm-12">
	            	<label class="col-sm-5 control-label">UPLOAD NEW ATTACHMENT</label>
	            	<div class="col-sm-5 control-label"><input type="file" name="fileToUpload"></div>
	            	<div class="col-sm-2"><button type="submit" name="upload_attachment" value="upload_attachment" class="btn btn-info">UPLOAD</button></div>
	            </div>
	            <?php echo form_close(); ?>
	            <br>
	            <br>
	            <br>
	            <h5 class="modal-info">EXISTING ATTACHMENTS</h5>
	            <div class="col-sm-12">
	            	<div class="col-sm-2"></div>
	            	<div class="col-sm-8">
	            		<table class="table table-striped">
							<tr>
								<th>ID</th>
								<th>ATTACHED FILENAME</th>
								<th>ACTION</th>
							</tr>
							<?php $counter = 1; ?>
							<?php foreach($attachments as $a){ ?>
							<?php echo form_open($submit_route, array("class"=>"form-horizontal", "method"=>"post")); ?>
							<input type="hidden" name="atchId" value="<?php echo $a['id']; ?>">
							<tr>
								<td><?= $counter++ ?></td>
								<td><?php echo $a['filename']; ?></td>
								<td>
							        <button type="submit" name="download_file" value="download_file">DOWNLOAD</button>
							    </td>
							</tr>
							<?php echo form_close(); ?>
							<?php } ?>
						</table>
	            	</div>
	            	<div class="col-sm-2"></div>
	            </div>
	            <br>
	            <br>
	            <br>
	            <?php echo form_open($submit_route, array("class"=>"form-horizontal", "method"=>"post")); ?>
	            <div class="col-sm-offset-5 col-sm-12">
	            	<button type="submit" name="close_attachments" value="close_attachments" class="btn btn-warning">CLOSE</button>
	            </div>
            	<?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <!-- footer section -->
            </div>
        </div>
    </div>
</div>