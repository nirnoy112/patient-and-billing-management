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
	<a href="<?php echo site_url('physician/add'); ?>" class="btn btn-success">Add New Physician</a> 
</div>
<br><br>
<table class="table table-striped table-bordered">
    <tr>
		<th>ID</th>
		<th>Name</th>
		<th>Actions</th>
    </tr>
	<?php foreach($physicians as $p){ ?>
    <tr>
		<td><?php echo $p['id']; ?></td>
		<td><?php echo $p['name']; ?></td>
		<td>
            <a href="<?php echo site_url('physician/edit/'.$p['id']); ?>" class="btn btn-info btn-xs">Edit</a> 
            <a href="<?php echo site_url('physician/remove/'.$p['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>