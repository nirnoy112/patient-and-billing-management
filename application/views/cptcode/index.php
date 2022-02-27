<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 16 May, 2017.
    * @LastUpdatedOn: 16 May, 2017.
    *
    *****/
?>

<div class="pull-left">
	<a href="<?php echo site_url('cptcode/add'); ?>" class="btn btn-success">Add CPT Code</a> 
</div>
<br><br>
<table class="table table-striped table-bordered">
    <tr>
		<th>ID</th>
		<th>Code</th>
		<th>Description</th>
		<th>Actions</th>
    </tr>
	<?php foreach($cptcodes as $c){ ?>
    <tr>
		<td><?php echo $c['id']; ?></td>
		<td><?php echo $c['code']; ?></td>
		<td><?php echo $c['description']; ?></td>
		<td>
            <a href="<?php echo site_url('cptcode/edit/'.$c['id']); ?>" class="btn btn-info btn-xs">Edit</a> 
            <a href="<?php echo site_url('cptcode/remove/'.$c['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>