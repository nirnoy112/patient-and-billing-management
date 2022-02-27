<?php echo form_open('',array("class"=>"form-horizontal", "method"=>"post", "id"=>"patient-filtering-form")); ?>
	<input type="hidden" name="fdata[sortBy]" value="<?php if($filter_data['sortBy'] != null){ echo $filter_data['sortBy']; } else { echo ''; } ?>">
	<input type="hidden" name="fdata[sortingOrder]" value="<?php if($filter_data['sortingOrder'] != null){ echo $filter_data['sortingOrder']; } else { echo ''; } ?>">
	<div class="row">
		<div class="col"><h4 class="text-center" style="border-bottom: 2px solid white;">FILTERING OPTIONS</h4></div>
		<div class="col-sm-4">
			<div class="col-sm-4"><label class="control-label">FACILITY:</label></div>
			<div class="col-sm-8">
				<select name="fdata[fid]" class="form-control">
					<option value="0">ALL</option>
					<?php 
					foreach($all_facilities as $facility)
					{
						$selected = ($facility['id'] == $filter_data['fid']) ? ' selected="selected"' : "";

						echo '<option value="'.$facility['id'].'" '.$selected.'>'.$facility['name'].'-'.$facility['uCode'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="col-sm-4"><label class="control-label">PHYSICIAN:</label></div>
			<div class="col-sm-8">
				<select name="fdata[rpid]" class="form-control">
					<option value="0">ALL</option>
					<?php 
					foreach($all_physicians as $physician)
					{
						$selected = ($physician['id'] == $filter_data['rpid']) ? ' selected="selected"' : "";

						echo '<option value="'.$physician['id'].'" '.$selected.'>'.$physician['name'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="col-sm-3"><label class="control-label">TECH:</label></div>
			<div class="col-sm-9">
			<select name="fdata[tid]" class="form-control">
					<option value="0">ALL</option>
					<?php 
					foreach($all_techs as $tech)
					{
						$selected = ($tech['id'] == $filter_data['tid']) ? ' selected="selected"' : "";

						echo '<option value="'.$tech['id'].'" '.$selected.'>'.$tech['title'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<div class="col-sm-6"><label class="control-label">SELECT A DATE RANGE:</label></div>
			<div class="col-sm-6">
				<div class="input-group input-daterange" id="datepicker">
					<input type="text" class="form-control" name="fdata[dateFrom]" value="<?php if($filter_data['dateFrom'] != null){ echo $filter_data['dateFrom']; } else { echo ''; } ?>" />
				    <div class="input-group-addon"><b>TO</b></div>
				    <input type="text" class="form-control" name="fdata[dateTo]" value="<?php if($filter_data['dateTo'] != null){ echo $filter_data['dateTo']; } else { echo ''; } ?>" />
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-12" style="text-align: center;">
			<button type="submit" id="filter_patients" name="filter_patients" class="btn btn-s-lg btn-warning btn-rounded no_border">FILTER</button>
		</div>
	</div>
	<br>
	<br>
<?php echo form_close(); ?>
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
	<?php echo form_open('',array("class"=>"form-horizontal")); ?>
	<input type="hidden" name="oid" value="<?= $p['OSID'] ?>">
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
            <button type="submit" name="edit_patient" value="ap" class="btn btn-xs btn-success">EDIT</button>&nbsp;&nbsp;<a href="<?php echo site_url('patient/remove/' . $p['id'] . '/0'); ?>" class="btn btn-xs btn-danger">DELETE</a>
        </td>
		<td>
            <button type="submit" name="manage_attachments" value="ma" class="btn btn-xs btn-primary">ATTACHMENTS</button>&nbsp;&nbsp;(<?= $ctrl->countAttachments($p['id']); ?>)
        </td>
        <td>
        	<a href="<?php echo site_url('patient/hcfa/' . $p['id'] . '/' . $p['OSID']); ?>" class="btn btn-xs btn-default">HCFA</a>&nbsp;&nbsp;<button type="submit" name="start_print" value="sp" class="btn btn-xs btn-info">PRINT</button>&nbsp;&nbsp;<button type="submit" name="start_send" value="ss" class="btn btn-xs btn-success">SEND</button>&nbsp;&nbsp;<button type="submit" name="start_direct" value="sd" class="btn btn-xs btn-primary">DIRECT</button>
        </td>
    </tr>
    <?php echo form_close(); ?>
	<?php } ?>
</table>
<div class="row">
	<div class="col-sm-offset-4 col-sm-6">
		<?= $links; ?>
	</div>
</div>