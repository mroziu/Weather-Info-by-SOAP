<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if (!isset($page_title)) { echo "brak page title"; exit(0); } ?>
<title>Weather Information - <?php echo $page_title;?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<?php echo link_tag(asset_url().'css/style.css'); ?>
<script type="text/javascript" src="<?php echo asset_url().'js/jquery-2.1.1.min.js' ?>"></script> 
<script type="text/javascript" src="<?php echo asset_url().'js/jquery.tablesorter.min.js' ?>"></script> 
<script type="text/javascript" src="<?php echo asset_url().'js/jquery.tablesorter.widgets.js' ?>"></script> 
<?php echo link_tag(asset_url().'css/jquery-ui.css'); ?>
<script src="<?php echo asset_url().'js/jquery-ui.js'; ?>"></script>
</head>
<body>
<h3 class="left"><?php echo anchor(base_url().'', 'Home', 'title="Home"'); ?></h3>
<h3 class="right">Weather Info</h3>
<h3 class="leftbreak"><?php echo anchor(base_url('weather/admin').'', 'Admin', 'title="Admin"'); ?></h3>
<div id="page-wrap">
    <div id="text-message">
        <?php
        if ($this->session->flashdata('text') != false) {
            $message = $this->session->flashdata('text');
            $type = $this->session->flashdata('type');
            if ($type == 0) {
                echo '<div class="information"><p>'.$message.'</p></div>'; }
            else {
                echo '<div class="error"><p>'.$message.'</p></div>'; }
        }
        if (validation_errors() != false) {
            echo '<div class="error">'.validation_errors().'</div>'; 
        }
        ?>
</div> <!-- text-message -->
<h1><?php echo $page_title; ?></h1>
