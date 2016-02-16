<?php $this->load->view('partials/header'); ?>
        <div class="page-header">
            <h1><?php echo $title; ?> <small>Manage navigation</small></h1>
            <a id="btn-add" class="btn btn-success pull-right" href="<?php echo site_url('al/add_group'); ?>"><i class="icon-plus icon-white"></i> Add navigation group</a>
        </div>

        <?php if ($groups): ?>
			<?php foreach ($groups as $group): ?>
    		<div class="info_wrapper">
    			<div class="info_header">
    				<span class="info_title"><?php echo $group['name']; ?> (<?php echo $group['slug']; ?>)</span>
    				<a style="float:right;margin-top:-5px;" class="btn btn-danger delete" data-type="group" data-href="<?php echo site_url('al/delete_group/'.$group['id']); ?>" data-name="<?php echo $group['name']; ?>'" href="javascript:;"><i class="icon-trash icon-white"></i> Delete</a>
    				<a style="float:right;margin-top:-5px;margin-right:5px;" class="btn btn-primary" href="<?php echo site_url('al/edit_group/'.$group['id']); ?>"><i class="icon-edit icon-white"></i> Edit</a>
    				<a style="float:right;margin-top:-5px;margin-right:5px;" class="btn btn-success" href="<?php echo site_url('al/add/'.$group['id']); ?>"><i class="icon-plus icon-white"></i> Add item to group</a>
    			</div>
    			<div class="info_box">
    				<ol class="sortable">
    					<?php echo build_admin_tree($group['items']); ?>
    				</ol>
    			</div>
    		</div>
			<?php endforeach; ?>
        <?php else: ?>
            <div class="hero-unit">
                <p>There is no navigation groups.</p>
                <p>
                    <a class="btn btn-success" href="<?php echo site_url('al/add_group'); ?>"><i class="icon-plus icon-white"></i> Add navigation group</a>
                </p>
            </div>
        <?php endif; ?>

        <div class="modal hide fade" id="confirm-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Please confirm</h3>
            </div>
            <div class="modal-body">
                Description...
            </div>
            <div class="modal-footer"></div>
        </div>
<?php $this->load->view('partials/footer'); ?>
