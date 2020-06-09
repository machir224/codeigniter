<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="author" content="Hiren Macwan">
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">
    <title><?= (isset($site_settings) && $site_settings['site_name'] != '') ? $site_settings['site_name'] : 'HM'  ?> | <?php echo $page_title ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/Ionicons/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- flag-icon-css -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/flag-icon-css/css/flag-icon.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/adminlte.min.css">

    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/style.css">

    <!-- jQuery 3 -->
    <script src="<?php echo base_url('assets'); ?>/plugins/jquery/jquery.min.js"></script>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="<?php echo base_url(); ?>" class="navbar-brand">
                    <!-- <img src="<?php echo base_url(); ?>/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                    <img src="<?php echo base_url(); ?>/assets/img/company/<?= (isset($site_settings) && $site_settings['logo'] != '') ? $site_settings['logo'] : 'logo.png'; ?>" alt="Company Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><?= (isset($site_settings) && $site_settings['site_name'] != '') ? $site_settings['site_name'] : 'HM'  ?></span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php $this->load->view('templates/public/header_menu'); ?>

            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="content-header">
                <!-- Content Header (Page header) -->
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"><?php echo $page_title; ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php
                                if (isset($breadcrumb) && !empty($breadcrumb)) {
                                    $b_size = sizeof($breadcrumb);
                                    $b_count = 1;
                                    foreach ($breadcrumb as $m_link => $m_name) {
                                        $is_home = '';
                                        if ($b_count == 1) {
                                            $is_home = '<i class="fa fa-home"></i>';
                                        }
                                        if ($b_count == $b_size) {
                                ?>
                                            <li class="breadcrumb-item active"><?php echo $is_home . ' ' . ucwords($m_name); ?></li>
                                        <?php
                                        } else {
                                        ?>
                                            <li class="breadcrumb-item"><a href="<?= ($m_link != '') ? base_url($m_link) : base_url(); ?>"><?php echo $is_home . ' ' . ucwords($m_name); ?></a></li>
                                <?php
                                        }
                                        $b_count++;
                                    }
                                }
                                ?>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>

            <!-- Main content -->
            <div class="content">
                <div class="container">

                    <?php if ($this->session->flashdata('error') || $this->session->flashdata('success') || $this->session->flashdata('message')) { ?>
                        <!-- <div class="row" style="margin:20px auto 0px; float:none;"> -->
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col-md-12">
                                <?php if ($this->session->flashdata('error')) { ?>
                                    <div class="alert alert-danger alert-dismissible" style="margin-bottom: 0px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Message!</strong> <?php echo $this->session->flashdata('error') ?>
                                    </div>

                                <?php } ?>
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-success alert-dismissible" style="margin-bottom: 0px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Message!</strong> <?php echo $this->session->flashdata('success') ?>
                                    </div>

                                <?php } ?>

                                <?php if ($this->session->flashdata('message')) { ?>
                                    <div class="alert alert-warning alert-dismissible" style="margin-bottom: 0px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Message!</strong> <?php echo $this->session->flashdata('message') ?>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>