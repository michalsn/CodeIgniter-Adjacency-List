<?php echo $this->load->view('partials/header'); ?>
        <div class="page-header">
            <h1><?php echo $title; ?> <small><?php echo $name; ?></small></h1>
        </div>

        <div class="row">
            <div class="span12">
                <?php echo form_open('al/edit_group'.$id, array('class'=>'form-horizontal')); ?>
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="name">Name</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="name" name="name" value="<?php echo set_value('name', $name); ?>">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <a class="btn" href="<?php echo site_url('al'); ?>">Cancel</a>
                        </div>
                    </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
<?php echo $this->load->view('partials/footer'); ?>
