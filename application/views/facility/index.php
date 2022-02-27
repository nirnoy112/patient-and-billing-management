<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 14 May, 2017.
    * @LastUpdatedOn: 14 May, 2017.
    *
    *****/
?>

<div class="pull-left">
	<a href="<?php echo site_url('facility/add'); ?>" class="btn btn-success">Add New Facility</a> 
</div>
<br><br>
<table class="table table-striped table-bordered">
    <tr>
		<th>ID</th>
		<th>Name</th>
		<th>UCode</th>
		<th>Address</th>
		<th>Address2</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>Phone</th>
		<th>Fax</th>
		<th>Actions</th>
    </tr>
	<?php foreach($facilities as $f){ ?>
    <tr>
		<td><?php echo $f['id']; ?></td>
		<td><?php echo $f['name']; ?></td>
		<td><?php echo $f['uCode']; ?></td>
		<td><?php echo $f['address']; ?></td>
		<td><?php echo $f['address2']; ?></td>
		<td><?php echo $f['city']; ?></td>
		<td><?php echo $f['state']; ?></td>
		<td><?php echo $f['zip']; ?></td>
		<td><?php echo $f['phone']; ?></td>
		<td><?php echo $f['fax']; ?></td>
		<td>
            <a href="<?php echo site_url('facility/edit/'.$f['id']); ?>" class="btn btn-info btn-xs">Edit</a> 
            <a href="<?php echo site_url('facility/remove/'.$f['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>