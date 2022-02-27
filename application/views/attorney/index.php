<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 19 May, 2017.
    * @LastUpdatedOn: 19 May, 2017.
    *
    *****/
?>

<div class="pull-left">
	<a href="<?php echo site_url('attorney/add'); ?>" class="btn btn-success">Add New Attorney</a> 
</div>
<br><br>
<table class="table table-striped table-bordered">
    <tr>
		<th>ID</th>
		<th>Name</th>
		<th>Primary Contact</th>
		<th>Email</th>
		<th>Address</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>Phone</th>
		<th>Fax</th>
		<th>Actions</th>
    </tr>
	<?php foreach($attorneys as $a){ ?>
    <tr>
		<td><?php echo $a['id']; ?></td>
		<td><?php echo $a['name']; ?></td>
		<td><?php echo $a['primaryContact']; ?></td>
		<td><?php echo $a['email']; ?></td>
		<td><?php echo $a['address']; ?></td>
		<td><?php echo $a['city']; ?></td>
		<td><?php echo $a['state']; ?></td>
		<td><?php echo $a['zip']; ?></td>
		<td><?php echo $a['phone']; ?></td>
		<td><?php echo $a['fax']; ?></td>
		<td>
            <a href="<?php echo site_url('attorney/edit/'.$a['id']); ?>" class="btn btn-info btn-xs">Edit</a> 
            <a href="<?php echo site_url('attorney/remove/'.$a['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>