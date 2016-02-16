<?php $this->load->view('partials/header'); ?>
        <div class="page-header">
            <h1><?php echo $title; ?> <small>Navigation: <?php echo $navigation['name']; ?></small></h1>
        </div>

        <div class="row">
            <div class="span12">
                <?php echo form_open('al/add/'.$navigation['id'], array('class'=>'form-horizontal')); ?>
                    <fieldset>
                        <div class="control-group">
                        <label class="control-label" for="name">Name</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="name" name="name" value="<?php echo set_value('name'); ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="url">URL</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="url" name="url" value="<?php echo set_value('url'); ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="parent_id">Parent</label>
                            <div class="controls">
                                <?php echo form_dropdown('parent_id', $dropdown); ?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Add item</button>
                            <a class="btn" href="<?php echo site_url('al'); ?>">Cancel</a>
                        </div>
                    </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
<?php $this->load->view('partials/footer'); ?>
