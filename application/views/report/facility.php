<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 16 AUGUST, 2017.
    * @LastUpdatedOn: 17 AUGUST, 2017.
    *
    *****/
?>
<?php echo form_open('report/facility',array("class"=>"form-horizontal")); ?>
<br>
<br>
<div class="row">
	<div class="col"><h4 class="text-center" style="border-bottom: 2px solid white;">REPORTING OPTIONS</h4></div>
	<br>
	<div class="col-sm-offset-3 col-sm-6">
		<div class="col-sm-4"><label class="control-label">SELECT A DATE RANGE:</label></div>
		<div class="col-sm-8">
			<div class="input-group input-daterange" id="datepicker">
				<input type="text" class="form-control" name="dateFrom" value="<?php echo date('m-d-Y'); ?>" />
			    <div class="input-group-addon"><b>TO</b></div>
			    <input type="text" class="form-control" name="dateTo" value="<?php echo date('m-d-Y'); ?>" />
			</div>
		</div>
	</div>
</div>
<br>
<br>
<div class="row">
	<div class="col"><h4 class="text-center" style="border-bottom: 2px solid white;">FACILITY SELECTION OPTIONS</h4></div>
	<br>
	<div class="col-sm-offset-1 col-sm-10" style="padding: 10px; border: 2px solid gray; border-radius: 10px;">
		<?php

			$counter = 0;
			foreach ($all_facilities as $facility) {

				echo '<div class="col-sm-4"><input type="checkbox" name="facilityOpts[' . $counter . ']" value="' . $facility['id'] . '" />&nbsp;&nbsp;&nbsp;' . $facility['name'] . '-' . $facility['uCode'] . ' [ ' . $facility['city'] . ', ' . $facility['state'] . ' ' . $facility['zip'] . ' ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>';

				$counter = $counter + 1;

				if($counter % 3 == 0) {

					echo '<br><br>';

				}

			}

		?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-sm-12" style="text-align: center;">
		<button type="submit" id="create_f_report" name="create_f_report" class="btn btn-s-lg btn-info btn-rounded no_border">CREATE REPORT</button>
	</div>
</div>
<br>
<br>
<?php echo form_close(); ?>