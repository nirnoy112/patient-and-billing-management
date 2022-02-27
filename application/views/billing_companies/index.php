<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 20 JUNE, 2017.
    * @LastUpdatedOn: 20 JUNE, 2017.
    *
    *****/
?>

<div class="pull-left">
	<a href="<?php echo site_url('billing_company/add'); ?>" class="btn btn-success">Add New Billing Company</a> 
</div>
<br><br>
<table class="table table-striped table-bordered">
    <tr>
		<th>ID</th>
		<th>Company Name</th>
		<th>Company Address</th>
		<th>Representing Real Name</th>
		<th>Representing Username</th>
		<th>Actions</th>
    </tr>
	<?php foreach($bcs as $bc){ ?>
    <tr>
		<td><?php echo $bc['id']; ?></td>
		<td><?php echo $bc['companyName']; ?></td>
		<td><?php echo $bc['address']; ?></td>
		<td><?php echo $bc['realName']; ?></td>
		<td><?php echo $bc['username']; ?></td>
		<td>
            <a href="<?php echo site_url('billing_company/edit/'.$bc['id']); ?>" class="btn btn-info btn-xs">Edit</a> 
            <a href="<?php echo site_url('billing_company/remove/'.$bc['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>