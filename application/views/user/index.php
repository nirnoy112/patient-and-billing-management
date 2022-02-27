<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 14 AUGUST, 2017.
    * @LastUpdatedOn: 15 AUGUST, 2017.
    *
    *****/
?>

<div class="pull-left">
	<a href="<?php echo site_url('user/add'); ?>" class="btn btn-success">Add New User</a> 
</div>
<br><br>
<table class="table table-striped table-bordered">
    <tr>
		<th>ID</th>
		<th>Username</th>
		<th>Real Name</th>
		<th>Active Role</th>
		<th>Is Suspended ?</th>
		<th>Actions</th>
    </tr>
	<?php foreach($users as $user){ ?>
    <tr>
		<td><?php echo $user['id']; ?></td>
		<td><?php echo $user['username']; ?></td>
		<td><?php echo $user['realName']; ?></td>
		<td>
		<?php
			foreach($all_roles as $role)
			{
				if($user['roleId'] == $role['id']) {
					echo $role['title'];
				}
			}
		?>
		</td>
		<td>
		<?php
			echo ($user['suspended'] == 0) ? 'NO' : 'YES';
		?>
		</td>
		<td>
            <a href="<?php echo site_url('user/edit/'.$user['id']); ?>" class="btn btn-info btn-xs">Edit</a> 
            <a href="<?php echo site_url('user/remove/'.$user['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>