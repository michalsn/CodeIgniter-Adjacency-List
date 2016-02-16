<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?> - Adjacency list</title>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow">
        <meta name="author" content="michalsn">

        <!-- Le styles -->
        <link rel="stylesheet" href="static/css/bootstrap.css" />
        <link rel="stylesheet" href="static/css/bootstrap-responsive.css" />
        <link rel="stylesheet" href="static/css/style.css" />

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        <script src="static/js/bootstrap.js"></script>
        <script src="static/js/jquery.cookie.js"></script>
        <script src="static/js/jquery.mjs.nestedSortable.js"></script>
        <script src="static/js/scripts.js"></script>

        <script>
          var BASE_URL = "<?php echo base_url(); ?>";
          var LIST_MAX_LEVELS = "<?php echo $this->config->item('max_levels', 'adjacency_list');?>";
        </script>
    </head>

    <body>

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a href="<?php echo site_url('al'); ?>" class="brand">Adjacency list</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li <?php echo ($this->uri->rsegment(2) == 'samples') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo site_url('al/samples'); ?>">Samples</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

        <?php if (validation_errors()): ?>
            <?php echo validation_errors(); ?>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-error">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
