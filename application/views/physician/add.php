<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 14 May, 2017.
    * @LastUpdatedOn: 14 May, 2017.
    *
    *****/
?>

<?php echo form_open('physician/add',array("class"=>"form-horizontal")); ?>
    <div class="col-sm-offset-2 col-sm-6">
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Name</label>
            <div class="col-md-8">
                <input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="name" />
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-6 col-sm-6">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>