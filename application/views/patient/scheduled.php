<table class="table table-striped table-bordered">
    <tr>
		<th>#</th>
		<th>FirstName</th>
		<th>LastName</th>
		<!-- <th>Date Of Birth</th> -->
		<th>PID</th>
		<th>Status</th>
		<th>Due Bills</th>
		<th>Actions</th>
		<th>Patient Options</th>
		<th>Attatchments</th>
		<th>Processing</th>
    </tr>
    <?php
    $count = 1;
    ?>
	<?php foreach($patients as $p){ ?>
	<?php echo form_open('patient/scheduled?oid=' . $oid,array("class"=>"form-horizontal")); ?>
	<input type="hidden" name="oid" value="<?= $oid ?>">
	<input type="hidden" name="pid" value="<?= $p['id'] ?>">
    <tr>
		<td><?php echo $count++; ?></td>
		<td><?php echo $p['firstName']; ?></td>
		<td><?php echo $p['lastName']; ?></td>
		<!-- <td><?php //echo $p['dob']; ?></td> -->
		<td><?php echo $p['PID']; ?></td>
		<?php
		foreach($all_statuses as $status) {
				
			if($p['processStatusId'] == $status['id']) {

				echo '<td>'.$status['title'].'</td>';

			}

		}
		?>
		<td>
			<?php echo ($p['totalDue'] != null)? sprintf('Total Due: $ %.2f&nbsp;<button type="submit" name="start_payment" value="pp" class="btn btn-xs btn-success">POST</button>', $p['totalDue']) : 'NO DUE'; ?>
		</td>
		<td>
			<?php
				if($p['processStatusId'] == 1) {
			?>
				<button type="submit" name="manage_patient" value="ap" class="btn btn-xs btn-info">CODE</button>
			<?php
				} else {
			?>
				<button type="submit" name="manage_patient" value="ap" class="btn btn-xs btn-info">RECODE</button>
			<?php
				}
			?>
			<?php
				if((int)$roleId != 3) {
			?>
				&nbsp;&nbsp;<button type="submit" name="start_assign" value="sa" class="btn btn-xs btn-default"><?php if((int)$p['BCID'] == 0) { echo 'ASSIGN'; } else { echo 'REASSIGN'; } ?></button>&nbsp;&nbsp;<?php if((int)$p['BCID'] == 0) { echo 'TO: NONE'; } else { echo 'TO: ' . $ctrl->getBC($p['BCID'])['companyName']; } ?>
			<?php
				}
			?>
		</td>
		<td>
            <button type="submit" name="edit_patient" value="ap" class="btn btn-xs btn-success">EDIT</button>&nbsp;&nbsp;<a href="<?php echo site_url('patient/remove/' . $p['id'] . '/' . $oid); ?>" class="btn btn-xs btn-danger">DELETE</a>
        </td>
		<td>
            <button type="submit" name="manage_attachments" value="ma" class="btn btn-xs btn-primary">ATTACHMENTS</button>&nbsp;&nbsp;(<?= $ctrl->countAttachments($p['id']); ?>)
        </td>
        <td>
        	<a href="<?php echo site_url('patient/hcfa/' . $p['id'] . '/' . $oid); ?>" class="btn btn-xs btn-default">HCFA</a>&nbsp;&nbsp;<button type="submit" name="start_print" value="sp" class="btn btn-xs btn-info">PRINT</button>&nbsp;&nbsp;<button type="submit" name="start_send" value="ss" class="btn btn-xs btn-success">SEND</button>&nbsp;&nbsp;<button type="submit" name="start_direct" value="sd" class="btn btn-xs btn-primary">DIRECT</button>
        </td>
    </tr>
    <?php echo form_close(); ?>
	<?php } ?>
</table>