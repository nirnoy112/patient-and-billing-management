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
    <a href="<?php echo site_url('tech/add'); ?>" class="btn btn-success">Add New Tech</a> 
</div>
<br><br>
<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Actions</th>
    </tr>
    <?php foreach($techs as $t){ ?>
    <tr>
        <td><?php echo $t['id']; ?></td>
        <td><?php echo $t['title']; ?></td>
        <td>
            <a href="<?php echo site_url('tech/edit/'.$t['id']); ?>" class="btn btn-info btn-xs">Edit</a> 
            <a href="<?php echo site_url('tech/remove/'.$t['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>