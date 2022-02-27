<?php echo validation_errors(); ?>

<?php echo form_open('patient/add'); ?>

	<div>
				ProcessStatusId : 
				<select name="processStatusId">
					<option value="">select status</option>
					<?php 
					foreach($all_statuses as $status)
					{
						$selected = ($status['id'] == $this->input->post('processStatusId')) ? ' selected="selected"' : "";

						echo '<option value="'.$status['id'].'" '.$selected.'>'.$status['title'].'</option>';
					} 
					?>
				</select>
		</div>
	<div>OSID : <input type="text" name="OSID" value="<?php echo $this->input->post('OSID'); ?>" /></div>
	<div>FirstName : <input type="text" name="firstName" value="<?php echo $this->input->post('firstName'); ?>" /></div>
	<div>LastName : <input type="text" name="lastName" value="<?php echo $this->input->post('lastName'); ?>" /></div>
	<div>Dob : <input type="text" name="dob" value="<?php echo $this->input->post('dob'); ?>" /></div>
	<div>PID : <input type="text" name="PID" value="<?php echo $this->input->post('PID'); ?>" /></div>
	<div>ResonBehindOrder : <textarea name="resonBehindOrder"><?php echo $this->input->post('resonBehindOrder'); ?></textarea></div>
	<div>History : <textarea name="history"><?php echo $this->input->post('history'); ?></textarea></div>
	<div>Notes : <textarea name="notes"><?php echo $this->input->post('notes'); ?></textarea></div>
	
	<button type="submit">Save</button>

<?php echo form_close(); ?>