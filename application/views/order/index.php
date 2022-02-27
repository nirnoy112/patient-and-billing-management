<div class="col-sm-12">
	<div class="pull-right">
		<a href="<?php echo site_url('order/add'); ?>" class="btn btn-success">ADD NEW SCHEDULE</a> 
	</div>
</div>
<br>
<br>
<?php echo form_open('order/filter',array("class"=>"form-horizontal")); ?>
	<input type="hidden" name="fdata[sortBy]" value="scheduledTime">
	<input type="hidden" name="fdata[sortingOrder]" value="asc">
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
			<button type="submit" id="run_filter" name="run_filter" class="btn btn-s-lg btn-warning btn-rounded no_border">RUN FILTER</button>
		</div>
	</div>
	<br>
<?php echo form_close(); ?>
<table class="table table-striped table-bordered">
    <tr>
		<th>SCHEDULED TIME</th>
		<th>FACILITY</th>
		<th>REFERRING PHYSICIAN</th>
		<th>TECH</th>
		<th>PATIENTS COUNT</th>
		<th>PATIENT LIST ACTIONS</th>
		<th>OTHER OPTIONS</th>
    </tr>
	<?php foreach($orders as $o){ ?>
	<?php echo form_open('',array("class"=>"form-horizontal")); ?>
    <tr>
		<input type="hidden" name="oid" value="<?= $o['id']?>">
		<input type="hidden" name="pid" value="0">
		<td><?php echo date(' m-d-Y, H:i ', $o['scheduledTime']); ?></td>

		<?php

			foreach($all_facilities as $facility) {
				
				if($o['facilityId'] == $facility['id']) {

					echo '<td>'.$facility['name'].'-'.$facility['uCode'].'</td>';

				}

			}

			foreach($all_physicians as $physician) {
				
				if($o['referringPhysicianId'] == $physician['id']) {

					echo '<td>'.$physician['name'].'</td>';

				}

			}

			if((int)$roleId == 2) {

				echo '<td>'.$realName.'</td>';

			} else {

				foreach($all_techs as $tech) {
					
					if($o['techId'] == $tech['id']) {

						echo '<td>'.$tech['title'].'</td>';

					}

				}

			}

		?>

		
        <td>
        	&nbsp;<strong style="color: blue; font-weight: 150%;"><?= $ctrl->countPatients($o['id']); ?></strong>&nbsp;&nbsp;ENLISTED PATIENTS
        </td>
        <td>
            <a href="<?php echo site_url('patient/scheduled?oid=' . $o['id']); ?>" class="btn btn-xs btn-info">VIEW PATIENTS</a>&nbsp;&nbsp;<button type="submit" name="manage_patient" value="ap" class="btn btn-xs btn-default">ADD PATIENT</button>
        </td>
        <td>
            <a href="<?php echo site_url('order/remove/' . $o['id']); ?>" class="btn btn-xs btn-danger">DELETE</a>
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