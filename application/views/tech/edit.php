<?php

    /*****
    *
    * @Author: Nirnoy.
    * @CreatedOn: 14 May, 2017.
    * @LastUpdatedOn: 14 May, 2017.
    *
    *****/
?>

<?php echo form_open('tech/edit/'.$tech['id'],array("class"=>"form-horizontal")); ?>
    <div class="col-sm-offset-2 col-sm-6">
        <div class="form-group">
            <label for="title" class="col-md-4 control-label">Title</label>
            <div class="col-md-8">
                <input type="text" name="title" value="<?php echo ($this->input->post('title') ? $this->input->post('title') : $tech['title']); ?>" class="form-control" id="title" />
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-6 col-sm-6">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div> 
<?php echo form_close(); ?>